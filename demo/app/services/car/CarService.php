<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/16
 * Time: 3:48
 */

namespace services\car;


use library\exceptions\ErrorResponseException;
use Phalcon\Http\Client\Request;
use Phalcon\Mvc\User\Component;

class CarService extends Component
{
    private $authToken;
    private $baseUrl;

    public function __construct($baseUrl,$token)
    {
        $this->baseUrl = $baseUrl;
        $this->authToken = $token;
    }

    /**
     * @return array
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getMakerList()
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('AuthToken', $this->authToken);
        $provider->header->set('Content-Type', 'application/json');

        $response = $provider->get('makers');
        $header = $response->header;

        switch ($header->statusCode){
            case 200:
                $data = json_decode($response->body);
                if($data->return_code===0){
                    throw new ErrorResponseException('car api error', -1, 500);
                }
                $result = [];
                foreach ($data->data as $item){
                    $result[] = [
                        'name' => $item->mk_nm,
                        'code' => $item->mk_cd
                    ];
                }
                return $result;
            default:
                throw new ErrorResponseException('car api error', -1, 500);
        }
    }

    /**
     * @param int $makerCode
     * @return array
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getCarNameList(int $makerCode)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('AuthToken', $this->authToken);
        $provider->header->set('Content-Type', 'application/json');

        $response = $provider->get('carnms', ['mk_cd'=>$makerCode]);
        $header = $response->header;

        switch ($header->statusCode){
            case 200:
                $data = json_decode($response->body);
                if($data->return_code===0){
                    throw new ErrorResponseException('car api error', -1, 500);
                }
                $result = [];
                foreach ($data->data as $item){
                    foreach ($item as $value){
                        $result[] = [
                            'maker'=> $value->mk_nm,
                            'name' => $value->car_nm,
                            'name_kana' => $value ->kana_nm,
                            'code' => $value->carnm_cd
                        ];
                    }
                }
                return $result;
            default:
                throw new ErrorResponseException('car api error', -1, 500);
        }
    }


    /**
     * @param int $carNameCode
     * @return array
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getModelList(int $carNameCode)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('AuthToken', $this->authToken);
        $provider->header->set('Content-Type', 'application/json');

        $response = $provider->get('cars', ['carnm_cd'=>$carNameCode]);
        $header = $response->header;
        switch ($header->statusCode){
            case 200:
                $data = json_decode($response->body);
                if($data->return_code===0){
                    throw new ErrorResponseException('car api error', -1, 500);
                }
                $result = [];
                foreach ($data->data as $item){
                    $grade_split = $item->tbl_grade1->grade2 !== "" ? " " : "";
                    $result[] = [
                        'code' => $item->car_cd,
                        'model' => $item->tbl_grade1->nin_kata,
                        'gradeName' => $item->tbl_grade1->grade1.$grade_split.$item->tbl_grade1->grade2,
                        'mission' => $item->tbl_grade1->mission_cd,
                        'releaseDate' => $item->tbl_grade1->hatubai_s
                    ];
                }
                return $result;
            default:
                throw new ErrorResponseException('car api error', -1, 500);
        }
    }


    /**
     * @param int $carNameCode
     * @param string $modelName
     * @return array
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getGradeList(int $carNameCode, string $modelName)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('AuthToken', $this->authToken);
        $provider->header->set('Content-Type', 'application/json');
        $response = $provider->get('cars', ['carnm_cd'=>$carNameCode]);
        $header = $response->header;
        switch ($header->statusCode){
            case 200:
                $data = json_decode($response->body);
                if($data->return_code===0){
                    throw new ErrorResponseException('car api error', -1, 500);
                }
                $result = [];
                foreach ($data->data as $item){
                    if ($item->tbl_grade1->nin_kata === $modelName) {
                        $grade_split = $item->tbl_grade1->grade2 !== "" ? " " : "";
                        $result[] = [
                            'maker'=> $item->mk_nm,
                            'name' => $item->carnm_nm,
                            'code' => $item->carnm_cd,
                            'gradeName' => $item->tbl_grade1->grade1.$grade_split.$item->tbl_grade1->grade2
                        ];
                    }
                }
                return array_unique($result, SORT_REGULAR);
            default:
                throw new ErrorResponseException('car api error', -1, 500);
        }
    }

}