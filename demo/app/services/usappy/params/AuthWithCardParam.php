<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/14
 * Time: 23:53
 */

namespace services\usappy\params;


class AuthWithCardParam extends AuthParam implements \JsonSerializable
{
    /**
     * @var string
     */
    protected $cardNo;
    protected $member_birthday;

    /**
     * @return string
     */
    public function getCardNo(): string
    {
        return $this->cardNo;
    }

    /**
     * @param string $cardNo
     * @return AuthWithCardParam
     */
    public function setCardNo(string $cardNo)
    {
        $this->cardNo = $cardNo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMemberBirthday():string
    {
        return $this->member_birthday;
    }

    /**
     * @param mixed $member_birthday
     */
    public function setMemberBirthday(string $member_birthday):AuthParam
    {
        $this->member_birthday = $member_birthday;
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
}