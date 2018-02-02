<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/15
 * Time: 1:51
 */

namespace services\usappy\params;


class AccessInfo implements \JsonSerializable
{


    public function __construct()
    {
        $this->{'access-token'} = '';
        $this->{'token-type'} = '';
        $this->{'expiry'} = '';
        $this->{'client'} = '';
        $this->{'uid'} = '';
        $this->{'device_token'}='';
    }
    public function setAccessToken(string $accessToken) : AccessInfo
    {
        $this->{'access-token'}  = $accessToken;
        return $this;
    }

    public function setTokenType(string $tokenType) : AccessInfo
    {
        $this->{'token-type'} = $tokenType;
        return $this;
    }

    public function setExpiry(string $expiry) : AccessInfo
    {
        $this->{'expiry'} = $expiry;
        return $this;
    }

    public function setClient(string $client): AccessInfo
    {
        $this->{'client'} = $client;
        return $this;
    }

    public function setUid(string $uid): AccessInfo
    {
        $this->{'uid'} = $uid;
        return $this;
    }
    public function setCarId(string $car_id): AccessInfo
    {
        $this->{'car_id'} = $car_id;
        return $this;
    }
    public function setDeviceToken(string $device_token): AccessInfo
    {
        $this->{'device_token'} = $device_token;
        return $this;
    }
    public function getAccessToken(): string
    {
        return $this->{'access-token'};
    }

    public function getTokenType(): string
    {
        return $this->{'token-type'};
    }

    public function getExpiry(): string
    {
        return $this->{'expiry'};
    }

    public function getClient(): string
    {
        return $this->{'client'};
    }

    public function getUid(): string
    {
        return $this->{'uid'};
    }
    public function getCarId(): string
    {
        return $this->{'car_id'};
    }
    public function getDeviceToken(): string
    {
        return $this->{'device_token'};
    }


    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return (array)$this;
    }

    public function parseArray($data)
    {
        $keys = array_keys((array)$this);
        $data = (array)$data;
        foreach ($keys as $key){
            $this->$key = $data[$key];
        }
    }
}