<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/14
 * Time: 23:44
 */

namespace services\usappy\params;
/**
 * Class LoginParams
 * @package services
 * {
 *   "email": "yuto.uehara@mail.rooxim.com",
 *   "password": "gjm123",
 *   "secret": "ussec"
 * }
 */
class LoginParam implements \JsonSerializable
{
    /**
     * @var string
     * require
     */
    protected $email;

    /**
     * @var string
     * require
     */
    protected $password;

    /**
     * @var string
     * require
     */
    protected $secret;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return LoginParam
     */
    public function setEmail(string $email): LoginParam
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return LoginParam
     */
    public function setPassword(string $password): LoginParam
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @param string $secret
     * @return LoginParam
     */
    public function setSecret(string $secret): LoginParam
    {
        $this->secret = $secret;
        return $this;
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
        return get_object_vars($this);
    }


    public function parseArray($data)
    {
        $keys = array_keys(get_object_vars($this));
        $data = (array)$data;
        foreach ($keys as $key){
            $this->$key = $data[$key];
        }

    }
}