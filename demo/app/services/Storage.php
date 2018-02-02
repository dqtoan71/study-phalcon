<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/11/26
 * Time: 23:24
 */

namespace services;


use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use library\exceptions\ErrorResponseException;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Common\Internal\Resources;
use MicrosoftAzure\Storage\Common\Internal\StorageServiceSettings;
use MicrosoftAzure\Storage\Common\SharedAccessSignatureHelper;
use Phalcon\Mvc\User\Component;
use MicrosoftAzure\Storage\Common\ServicesBuilder;

class Storage extends Component
{

    private $blobClient;
    private $container;
    private $connectionString;
    private $cdnUrl;

    /**
     * Storage constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->container = $config->container;
        $this->connectionString = $config->connectionString;
        $this->cdnUrl = $config->cdnUrl;
        $this->blobClient = ServicesBuilder::getInstance()->createBlobService($config->connectionString);
    }

    /**
     * delete file
     * @param string $filePath
     * @return bool
     */
    public function deleteBlob(string $filePath) {
        try {
            if($this->existBlob($filePath)){
                $this->blobClient->deleteBlob($this->container, $filePath);
                return true;
            }

        } catch (ServiceException $ignore){

        }
        return false;

    }

    /**
     * check file exist
     * @param string $filePath
     * @return bool
     */
    public function existBlob(string $filePath){
        try{
            $this->blobClient->getBlob($this->container,$filePath);
            return true;
        }catch (ServiceException $e){
            return false;
        }
    }

    /**
     * @param $file
     * @param $name
     * @throws ErrorResponseException
     */
    public function uploadBlob($file,$name)
    {
        if(!file_exists($file)){
            throw new ErrorResponseException('internal server error', -1, 500);
        }

        $content = fopen($file, 'r');
        try {
            $this->blobClient->createBlockBlob($this->container, $name, $content);
        }catch (ServiceException $e){
            throw new ErrorResponseException('internal server error', -1, 500,$e);
        }
    }

    /**
     * @param $path
     * @return bool|\MicrosoftAzure\Storage\Blob\Models\GetBlobResult
     * @throws ErrorResponseException
     */
    public function downloadBlob($path)
    {
        if (!$this->existBlob($path)) {
            return false;
        }
        try {
            $getBlobResult = $this->blobClient->getBlob($this->container, $path);
            return $getBlobResult;
        } catch (ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            throw new ErrorResponseException($error_message, $code, 500,$e);
        }
    }

    /**
     * @param $path
     * @return null|string
     */
    public function getLinkUrl($path)
    {
        if(!$this->existBlob($path)){
            return null;
        }

        $settings = StorageServiceSettings::createFromConnectionString($this->connectionString);
        $accountName = $settings->getName();
        $accountKey = $settings->getKey();
        $helper = new SharedAccessSignatureHelper(
            $accountName,
            $accountKey
        );

        $resourceName = "{$this->container}/$path";
        $resolveResource = $this->resolveUrl($resourceName);
        $sas = $helper->generateBlobServiceSharedAccessSignatureToken(
            Resources::RESOURCE_TYPE_BLOB,
            $resolveResource,
            'r',                            // Read
            '2018-12-01T08:30:00Z'//,       // A valid ISO 8601 format expiry time
        // '2016-01-01T08:30:00Z' //,       // A valid ISO 8601 format expiry time
        //'0.0.0.0-255.255.255.255'
        //'https,http'
        );


        $connectionStringWithSAS = Resources::BLOB_ENDPOINT_NAME .
            '='.
            'https://' .
            $accountName .
            '.' .
            Resources::BLOB_BASE_DNS_NAME .
            ';' .
            Resources::SAS_TOKEN_NAME .
            '=';
            // $sas;

        /** @var BlobRestProxy $blobClientWithSAS */
        $blobClientWithSAS = ServicesBuilder::getInstance()->createBlobService(
            $connectionStringWithSAS
        );

        $blobUrlWithSAS = sprintf(
            '%s%s',
            //'%s%s?%s',
            (string)$blobClientWithSAS->getPsrPrimaryUri(),
            $resolveResource,
            $sas
        );

        $host = (string)$blobClientWithSAS->getPsrPrimaryUri().'contents/';
        $urlWithCDN = str_replace($host, $this->cdnUrl, $blobUrlWithSAS);
        return $urlWithCDN;
    }

    /**
     * @param $path
     * @return string
     */
    private function resolveUrl($path) {
        $arr = explode('/', $path);
        $newArr = array_map(function($e) {
            return urlencode($e);
        }, $arr);
        return implode('/', $newArr);
    }

}