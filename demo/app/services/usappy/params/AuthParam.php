<?php
/**
 * Created by PhpStorm.
 * User: yuuto
 * Date: 2017/10/14
 * Time: 23:44
 */

namespace services\usappy\params;
use Phalcon\Security\Random;


/**
 * Class authPrams
 * @package services
 *
 * esample
 * {
"member_mobId": "",
"password": "gjm123",
"member_kaiinName": "宇佐美　太郎",
"member_kaiinKana": "ｳｻﾐ ﾀﾛｳ",
"member_sex": "0",
"member_birthday": "20000101",
"member_yuubinBangou": "1400013",
"email": "test@alpha-it-ssytem.com",
"member_mailAddress2": "",
"member_favSSCode1": "236202",
"member_favSSCode2": "",
"member_address": "東京都品川区南大井",
"member_telNo1": "09099999999",
"member_telNo2": "",
"member_usamiMailReceive": "1",
"member_ssMailReceive": "1",
"member_spFlg1": "0",
"member_spFlg2": "0",
"member_usamiMailReceive2": "1",
"member_ssMailReceive2": "1",
"member_pcHtmlFlg": "0",
"member_mbHtmlFlg": "0",
"member_userAgent": "Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/55.0.2883.87 Safari/537.36",
"proId": "",
"secret": "ussec"
}
 */
class AuthParam implements \JsonSerializable
{

    /**
     * @var string
     * require
     */
    protected $email = '';

    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_usamiMailReceive = '0';

    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_ssMailReceive = '0';

    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_spFlg1 = '0';

    /**
     * @var string
     * require
     */
    protected $password = '';

    /**
     * @var string
     */
    protected $proId = "";

    /**
     * @var string
     * require
     */
    protected $secret = '';

    /**
     * @var string
     * device id
     */
    protected $member_mobId = '';

    /**
     * @var string
     * require
     * name
     */
    protected $member_kaiinName = '';

    /**
     * @var string
     * require
     * name_read
     */
    protected $member_kaiinKana = '';


    /**
     * @var string
     * require (0 or 1)
     * 0 male
     * 1 female
     */
    protected $member_sex = '0';

    /**
     * @var string
     * require
     * format YYYYMMDD
     */
   // protected $member_birthday = '';

    /**
     * @var string
     * zip code
     * require
     */
    protected $member_yuubinBangou = '';

    /**
     * @var string
     * favorite ss code1
     */
    protected $member_favSSCode1 = '';

    /**
     * @var string
     * favorite ss code2
     */
    protected $member_favSSCode2 = '';


    /**
     * @var string
     * require
     * address
     */
    protected $member_address = '';

    /**
     * @var string
     * tel1
     * require
     */
    protected $member_telNo1 = '';

    /**
     * @var string
     * tel2
     * require
     */
    protected $member_telNo2 = '';


    /**
     * @var string
     * require
     */
    protected $member_mailAddress2 = '';


    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_usamiMailReceive2 = '';


    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_ssMailReceive2 = '0';


    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_spFlg2 = '0';


    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_pcHtmlFlg = '0';


    /**
     * @var string
     * require (0 or 1)
     * 0 disable
     * 1 enable
     */
    protected $member_mbHtmlFlg = '0';


    /**
     * @var string
     * require
     */
    protected $member_userAgent = '';


    /**
     * @var string
     * require
     */
    protected $member_spApKey = '';

    protected $member_kaiinCd='';
    protected $member_birthday='';
    protected $member_ssCode='';
    protected $member_nendai='';
    protected $member_syoukenCode='';
    protected $member_passwordKbn='';
    protected $member_kaiinInfoInsKbn='';
    protected $member_beforeLoginYmdhms='';
    protected $member_updYmdhms='';
    protected $member_ruikelPt='';
    //protected $member_usamiMailReceive='';

    /**
     * AuthParam constructor.
     * @throws \Phalcon\Security\Exception
     */
    public function __construct()
    {
        $this->member_spApKey = 'NEWAPP' . ((new Random())->base64(34));
    }


    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return AuthParam
     */
    public function setEmail(string $email): AuthParam
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberUsamiMailReceive(): string
    {
        return $this->member_usamiMailReceive;
    }

    /**
     * @param string $member_usamiMailReceive
     * @return AuthParam
     */
    public function setMemberUsamiMailReceive(string $member_usamiMailReceive): AuthParam
    {
        $this->member_usamiMailReceive = $member_usamiMailReceive;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberSsMailReceive(): string
    {
        return $this->member_ssMailReceive;
    }

    /**
     * @param string $member_ssMailReceive
     * @return AuthParam
     */
    public function setMemberSsMailReceive(string $member_ssMailReceive): AuthParam
    {
        $this->member_ssMailReceive = $member_ssMailReceive;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberSpFlg1(): string
    {
        return $this->member_spFlg1;
    }

    /**
     * @param string $member_spFlg1
     * @return AuthParam
     */
    public function setMemberSpFlg1(string $member_spFlg1): AuthParam
    {
        $this->member_spFlg1 = $member_spFlg1;
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
     * @return AuthParam
     */
    public function setPassword(string $password): AuthParam
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return string
     */
    public function getProId(): string
    {
        return $this->proId;
    }

    /**
     * @param string $proId
     * @return AuthParam
     */
    public function setProId(string $proId): AuthParam
    {
        $this->proId = $proId;
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
     * @return AuthParam
     */
    public function setSecret(string $secret): AuthParam
    {
        $this->secret = $secret;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberMobId(): string
    {
        return $this->member_mobId;
    }

    /**
     * @param string $member_mobId
     * @return AuthParam
     */
    public function setMemberMobId(string $member_mobId): AuthParam
    {
        $this->member_mobId = $member_mobId;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberKaiinName(): string
    {
        return $this->member_kaiinName;
    }

    /**
     * @param string $member_kaiinName
     * @return AuthParam
     */
    public function setMemberKaiinName(string $member_kaiinName): AuthParam
    {
        $this->member_kaiinName = $member_kaiinName;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberKaiinKana(): string
    {
        return $this->member_kaiinKana;
    }

    /**
     * @param string $member_kaiinKana
     * @return AuthParam
     */
    public function setMemberKaiinKana(string $member_kaiinKana): AuthParam
    {
        $this->member_kaiinKana = $member_kaiinKana;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberSex(): string
    {
        return $this->member_sex;
    }

    /**
     * @param string $member_sex
     * @return AuthParam
     */
    public function setMemberSex(string $member_sex): AuthParam
    {
        $this->member_sex = $member_sex;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberBirthday(): string
    {
        return $this->member_birthday;
    }

    /**
     * @param string $member_birthday
     * @return AuthParam
     */
    public function setMemberBirthday(string $member_birthday): AuthParam
    {
        $this->member_birthday = $member_birthday;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberYuubinBangou(): string
    {
        return $this->member_yuubinBangou;
    }

    /**
     * @param string $member_yuubinBangou
     * @return AuthParam
     */
    public function setMemberYuubinBangou(string $member_yuubinBangou): AuthParam
    {
        $this->member_yuubinBangou = $member_yuubinBangou;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberFavSSCode1(): string
    {
        return $this->member_favSSCode1;
    }

    /**
     * @param string $member_favSSCode1
     * @return AuthParam
     */
    public function setMemberFavSSCode1(string $member_favSSCode1): AuthParam
    {
        $this->member_favSSCode1 = $member_favSSCode1;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberFavSSCode2(): string
    {
        return $this->member_favSSCode2;
    }

    /**
     * @param string $member_favSSCode2
     * @return AuthParam
     */
    public function setMemberFavSSCode2(string $member_favSSCode2): AuthParam
    {
        $this->member_favSSCode2 = $member_favSSCode2;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberAddress(): string
    {
        return $this->member_address;
    }

    /**
     * @param string $member_address
     * @return AuthParam
     */
    public function setMemberAddress(string $member_address): AuthParam
    {
        $this->member_address = $member_address;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberTelNo1(): string
    {
        return $this->member_telNo1;
    }

    /**
     * @param string $member_telNo1
     * @return AuthParam
     */
    public function setMemberTelNo1(string $member_telNo1): AuthParam
    {
        $this->member_telNo1 = $member_telNo1;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberTelNo2(): string
    {
        return $this->member_telNo2;
    }

    /**
     * @param string $member_telNo2
     * @return AuthParam
     */
    public function setMemberTelNo2(string $member_telNo2): AuthParam
    {
        $this->member_telNo2 = $member_telNo2;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberMailAddress2(): string
    {
        return $this->member_mailAddress2;
    }

    /**
     * @param string $member_mailAddress2
     * @return AuthParam
     */
    public function setMemberMailAddress2(string $member_mailAddress2): AuthParam
    {
        $this->member_mailAddress2 = $member_mailAddress2;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberUsamiMailReceive2(): string
    {
        return $this->member_usamiMailReceive2;
    }

    /**
     * @param string $member_usamiMailReceive2
     * @return AuthParam
     */
    public function setMemberUsamiMailReceive2(string $member_usamiMailReceive2): AuthParam
    {
        $this->member_usamiMailReceive2 = $member_usamiMailReceive2;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberSsMailReceive2(): string
    {
        return $this->member_ssMailReceive2;
    }

    /**
     * @param string $member_ssMailReceive2
     * @return AuthParam
     */
    public function setMemberSsMailReceive2(string $member_ssMailReceive2): AuthParam
    {
        $this->member_ssMailReceive2 = $member_ssMailReceive2;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberSpFlg2(): string
    {
        return $this->member_spFlg2;
    }

    /**
     * @param string $member_spFlg2
     * @return AuthParam
     */
    public function setMemberSpFlg2(string $member_spFlg2): AuthParam
    {
        $this->member_spFlg2 = $member_spFlg2;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberPcHtmlFlg(): string
    {
        return $this->member_pcHtmlFlg;
    }

    /**
     * @param string $member_pcHtmlFlg
     * @return AuthParam
     */
    public function setMemberPcHtmlFlg(string $member_pcHtmlFlg): AuthParam
    {
        $this->member_pcHtmlFlg = $member_pcHtmlFlg;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberMbHtmlFlg(): string
    {
        return $this->member_mbHtmlFlg;
    }

    /**
     * @param string $member_mbHtmlFlg
     * @return AuthParam
     */
    public function setMemberMbHtmlFlg(string $member_mbHtmlFlg): AuthParam
    {
        $this->member_mbHtmlFlg = $member_mbHtmlFlg;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemberUserAgent(): string
    {
        return $this->member_userAgent;
    }

    /**
     * @param string $member_userAgent
     * @return AuthParam
     */
    public function setMemberUserAgent(string $member_userAgent): AuthParam
    {
        $this->member_userAgent = $member_userAgent;
        return $this;
    }
    public function getMemberSpApKey(): string
    {
        return $this->member_spApKey;
    }

    /**
     * @param string $member_userAgent
     * @return AuthParam
     */
    public function setMemberSpApKey(string $member_spApKey): AuthParam
    {
        $this->member_spApKey = $member_spApKey;
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
            if ($key !== 'member_kaiinKana') {
                $this->$key = $data[$key];
            } else {
                $this->$key = mb_convert_kana($data[$key], 'k');
            }
        }
    }
}
