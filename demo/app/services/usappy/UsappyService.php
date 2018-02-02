<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/14
 * Time: 19:13
 */

namespace services\usappy;


use library\ApiObject\ItemPurchaseHistory;
use library\exceptions\ErrorResponseException;
use Phalcon\Http\Client\Request;
use Phalcon\Mvc\User\Component;
use services\usappy\params\AccessInfo;
use services\usappy\params\AuthParam;
use services\usappy\params\LoginParam;

class UsappyService extends Component
{

    private $baseUrl;
    private $secret;

    public function __construct($configs)
    {
        $this->baseUrl = $configs->baseUrl;
        $this->secret = $configs->secret;
    }

    /**
     * @param LoginParam $params
     * @return object
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function login(LoginParam $params)
    {
        $params->setSecret($this->secret);
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');
        $response = $provider->post("auth/sign_in", json_encode($params));
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
            case 401:
                $body = json_decode($response->body);
                $login_result = $body->result;
                $login_isCorrect = $body->login;
                if ($login_result === "1") {
                    throw new ErrorResponseException($body->error, -1,500);
                }
                if ($login_isCorrect === "false") {
                    throw new ErrorResponseException($GLOBALS['lang']->incorrect_login, -1,401);
                }
                $accessInfo = new AccessInfo();
                $accessInfo
                    ->setAccessToken($response->header->get('access-token'))
                    ->setTokenType($response->header->get('token-type'))
                    ->setClient($response->header->get('client'))
                    ->setExpiry($response->header->get('expiry'))
                    ->setUid($response->header->get('uid'));

                return (object)[
                    'login_result' => $body,
                    'access_info' => $accessInfo
                ];
                break;
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                var_dump($res, $response->header);
                if (!$res->login === 'false' && $res->msg) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AuthParam $params
     * @return mixed
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function auth(AuthParam $params)
    {
        $params->setSecret($this->secret);
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        // var_dump(json_encode($params));
        $response = $provider->post("auth", json_encode($params));
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return json_decode($body);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                // var_dump($res);
                if ($res->status === 'error' && $res->errors) {
                    throw new ErrorResponseException($res->errors->full_messages[0], -1, 422);
                } else {
                    throw new ErrorResponseException("Internal server error", -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @return mixed
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getMemberInfo(AccessInfo $accessInfo)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }

        $response = $provider->get("members/basic");
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return json_decode($body);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                var_dump($res);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @return mixed
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function logout(AccessInfo $accessInfo)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }

        $response = $provider->delete("auth/sign_out");
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return json_decode($body);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                var_dump($res);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @return mixed
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getPointInfo(AccessInfo $accessInfo)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }

        $response = $provider->get("points");
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return json_decode($body);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                var_dump($res);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @return object
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getMemberCarInfo(AccessInfo $accessInfo)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }

        $response = $provider->get("my_cars");
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return (object)[
                    'login_result' => json_decode($body),
                    'access_info' => $accessInfo
                ];
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                var_dump($res);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @return mixed
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getCarList(AccessInfo $accessInfo)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }

        $response = $provider->get("my_cars");
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return json_decode($body);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @param $params
     * @return mixed|string
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function addMyCar(AccessInfo $accessInfo, $params)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');
        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }
        //var_dump($params);die;
        $response = $provider->post("my_cars", json_encode($params));
       // var_dump($response);die;
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body =json_decode($response->body);
                if (intval($body->result) === 0) {
                    return $body;
                }
                throw new ErrorResponseException($body->error, -1, 500);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @param $params
     * @return mixed|string
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function removeMyCar(AccessInfo $accessInfo, $params)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');

        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }

        $response = $provider->delete("my_cars/remove", $params);
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = json_decode($response->body);
               // var_dump($body->result);die;
                if (intval($body->result) === 0) {
                    return $body;
                }
                throw new ErrorResponseException($body->error, -1, 500);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @param $params
     * @return mixed|string
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function editMyCar(AccessInfo $accessInfo, $params)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('Content-Type', 'application/json');
        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }
        //var_dump($params);die;
        $response = $provider->post("my_cars/mycar_update", json_encode($params));
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = json_decode($response->body);
                if (intval($body->result) === 0) {
                    return $body;
                }
                throw new ErrorResponseException($body->error, -1, 500);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @param $params
     * @return mixed
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function updateMemberInfo(AccessInfo $accessInfo, $params)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('secret', 'ussec');
        $provider->header->set('Content-Type', 'application/json');
        $param = $params;
        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }
        $param['kaiinCd'] = $accessInfo->getUid();
        //var_dump($param);die;
        $response = $provider->post("members/update_basic", json_encode($param));
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $body = $response->body;
                return json_decode($body);
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

    /**
     * @param AccessInfo $accessInfo
     * @param $params
     * @return array
     * @throws ErrorResponseException
     * @throws \Phalcon\Http\Client\Provider\Exception
     */
    public function getPurchaseHistory(AccessInfo $accessInfo, $params)
    {
        $provider = Request::getProvider();
        $provider->setBaseUri($this->baseUrl);
        $provider->header->set('secret', 'ussec');
        $provider->header->set('Content-Type', 'application/json');
        $newParams = $params;
        foreach ((array)$accessInfo as $key => $value) {
            $provider->header->set($key, $value);
        }
        $newParams['kaiin_cd'] = $accessInfo->getUid();
        //var_dump($newParams['purchase_category']);die;
        $response = $provider->get("purchase_histories", $newParams);
        //var_dump(json_decode($response->body));die;
        $statusCode = $response->header->statusCode;
        switch ($statusCode) {
            case 200://success
                $data = json_decode($response->body);

                $result = [];
                foreach ($data as $item) {

                        if ($item->purchase_category == 1) {

                            foreach ($item->order_items as $value) {
                                $result[] = [
                                    // 'purchase_category' => $item->order_items->purchase_category,
                                    'code' => $value->jan_code,
                                    'name' => $value->product_name,
                                    'amount' => $value->order_quantity,
                                    'image' => $value->product_image,
                                    'date' => date('Y/m/d', strtotime($item->order->order_date)),
                                    //'unit_price' => $value->unit_price_incl_tax,
                                    'price' => ($value->unit_price_incl_tax) * ($value->order_quantity)
                                ];
                            }
                        }
                        else if ($item->purchase_category == 2) {
                            $purchase_shop=new ItemPurchaseHistory();
                            $purchase_shop->setSsCode($item->order->ss_code);
                            $shop_name= $purchase_shop->getShopName();
                            $brand_image= $purchase_shop->getBrandImage();
                            $result[] = [
                                'brand' => $brand_image,
                                'date' => date('Y/m/d', strtotime($item->order->order_date)),
                                'amount' => $item->order->quantity,
                                //'price' => $item->order->price,
                                'code' => $item->order->jan_code,
                                'shop' => $shop_name,
                                'price' => $item->order->price
                            ];
                        }
                    }
                usort($result, function($a, $b) {
                    return ($a['date'] > $b['date']) ? -1 : 1;
                });
                return $result;
                break;
            case 401:
            case 422:
                $body = $response->body;
                $res = json_decode($body);
                if ($res->errors) {
                    throw new ErrorResponseException($res->msg, -1, 500);
                } else {
                    throw new ErrorResponseException($GLOBALS['lang']->unknown_status, -1, 500);
                }
                break;
            case 500:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
            default:
                throw new ErrorResponseException($GLOBALS['lang']->request_fail, -1, 500);
        }
    }

}