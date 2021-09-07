<?php
$securityKey16 = 'Skesj(eE%32sLOap';
$securityKey24 = 'Skesj(eE%32sLOapA9e2snEw';
$securityKey32 = 'Skesj(eE%32sLOapA9e2snEwEeopsWui';
$iv = '1234567890123456';
echo "PHP程序<br />";
$plainText = '我是python内容';
$aesTool = new Aes($securityKey16, 'AES-128-CBC', $iv);
echo '加密前的明文：'.$plainText."<br />";

echo "<hr />";
$cipherText = $aesTool->encrypt($plainText);
echo '加密后的密文：'.$cipherText."<br />";
//$cipherText = 'htfPHDKPsu3WLtElYtyiDH4KN2q/MDGJJvmYFHu7PK9ivCf85+1fEsBAUCADwGIaNsAKmIs63k/Z3xC+vDCniDWMu629SLOjGY1Ug1FHnOybcUqaPlFpFNuYLR8DMgXMg0xeAd2rnT+KMZBNaIWhLY76TpAz7CdsZ8biHiGhPASNHm3EiCtnSWOZONJRpwk/oiWVOHfvbPSigvxeaFNB5VxmqRgwfTtrxsbaDZ/1vaLZC8/ql57VwuCvmJvtPAlJfXBaY5bGf9DHob5NI8dpox7Yp9vsTY97yXAUmOfXJY47nK5nb4MpELBwFQskmcD2OwXPiEOTO9SPcNi7qz3hFURT6RXuQyh+wwA2HFUN7ZQ=';
$outPlainText = $aesTool->decrypt($cipherText);

echo "<hr />";
echo '解密后明文：'.$outPlainText."<br />";
/**
 * 按照加密方式可分为对称和非对称加密，对称加密即发送方和接收方都是用相同的秘钥进行加解密，非对称加密则使用一对公私钥来进行加解密，发送方使用公钥加密数据，接收方可使用私钥来解密。
 * 对称加密：
 *     简单的加密设计： 用密钥对原文做字节代替、行移动、列混淆、加轮秘钥
 *     优点： 安全、快速(加解密运算速度快、资源消耗少、消耗时间少)、支持二进制
 *     缺点： 发送方和接收方协定秘钥，双方保存好秘钥安全不被泄漏，加重了心智负担
 * 常见的对称加密方式有 DES、3DES、AES、Blowfish、IDEA、RC5、RC6， 从安全性、资源消耗、运算速度、消耗时间综合来看 AES 都是值得选择的对称加密方式
 *
 * AES(Advanced Encryption Standard)
 *      1.分块：将明文按照一定长度分块(block0、block1、block2、blockN....)，根据分块长度可以分为:AES-128、AES-192、AES-256 三种，对应分组长度为 128bit、192bit、256bit
 *      2.分块加密组合：将分块明文进行加密组合，分为四种模式： ECB(Electronic Code Book电子密码本)模式、CBC(Cipher Block Chaining，加密块链)模式、CFB(Cipher FeedBack Mode，加密反馈)模式、OFB(Output FeedBack，输出反馈)模式
 *
 *      ECB(Electronic Code Book电子密码本)模式，ECB模式是最早采用和最简单的模式，它将加密的数据分成若干组，每组的大小跟加密密钥长度相同，然后每组都用相同的密钥进行加密。
 *          优点: 1.简单； 2.有利于并行计算； 3.误差不会被扩散；
 *          缺点: 1.不能隐藏明文的模式； 2.可能对明文进行主动攻击；
 *
 *      CBC(Cipher Block Chaining，加密块链)模式
 *          优点： 不容易主动攻击,安全性好于ECB,适合传输长度长的报文,是SSL、IPSec的标准。
 *          缺点： 1.不利于并行计算； 2.误差传递； 3.需要初始化向量IV
 *
 *      CFB(Cipher FeedBack Mode，加密反馈)模式
 *          优点：1.隐藏了明文模式; 2.分组密码转化为流模式; 3.可以及时加密传送小于分组的数据;
 *          缺点: 1.不利于并行计算; 2.误差传送：一个明文单元损坏影响多个单元; 3.唯一的IV;
 *
 *      OFB(Output FeedBack，输出反馈)模式
 *          优点: 1.隐藏了明文模式; 2.分组密码转化为流模式; 3.可以及时加密传送小于分组的数据;
 *          缺点: 1.不利于并行计算; 2.对明文的主动攻击是可能的; 3.误差传送：一个明文单元损坏影响多个单元;
 *
 *      涉及到2个小知识：
 *          填充方式(原始数据长度不是分组大小的整数倍，则需要对数据进行填充)，以AES-128为例：
 *              NoPadding:
 *                  不做任何填充，但是要求明文必须是16字节的整数倍。
 *              ZeroPadding:
 *                  数据长度不对齐时使用0填充，否则不填充
 *              PKCS5Padding:
 *                  如果明文长度为10bytes, 进行分组时候则需要 6bytes 才满分组条件，在明文块末尾补足相应数量的字符
 *                  比如明文：{1,2,3,4,5,a,b,c,d,e},缺少6个数量字符，则补全为{1,2,3,4,5,a,b,c,d,e,6,6,6,6,6,6}
 *              ISO10126Padding:
 *                  如果明文长度为10bytes, 进行分组时候则需要 6bytes 才满分组条件，和 PKCS5Padding 不同的是在明文块末尾补足相应数量的字节，最后一个字符值等于缺少的字符数，其他字符填充随机数。
 *                  比如明文：{1,2,3,4,5,a,b,c,d,e},缺少6个字节，则可能补全为{1,2,3,4,5,a,b,c,d,e,x,c,7,G,e,6}
 *                  其中：x,c,7,G,e 随机字符， 最后一个 6 则为缺省的字符数
 *              ...............:
 *          IV 初始向量：
 *              其中CBC、CFB、OFB 三种加密分组模式需要初始向量 IV 来辅助加密,但是增加了复杂度，它的作用和MD5的“加盐”有些类似，目的是防止同样的明文块始终加密成同样的密文块
 * Class AesTool
 * @package App\Utils
 */
class Aes
{

    /**
     * @var string 秘钥
	 * AES-128-CBC key 长度 16 位,IV 16位
	 * AES-192-CBC key 长度 24 位,IV 16位
	 * AES-256-CBC key 长度 32 位,IV 16位
     */
    protected $securityKey;

    /**
     * @var string 加密方式 https://www.php.net/manual/zh/function.openssl-get-cipher-methods.php
     */
    protected $method;

    /**
     * @var string 偏移量
     */
    protected $iv;

    /**
     * Aes constructor.
     * @param string $securityKey
     * @param string $method
     * @param string $iv
     */
    public function __construct(string $securityKey, string $method = 'AES-128-CBC', string $iv = '')
    {
        if (empty($securityKey)) {
            throw new \RuntimeException('秘钥不能为空');
        }
		$this->securityKey = $securityKey;
        if (false === $this->isSupportCipherMethod($method)) {
            throw new \RuntimeException('暂不支持该加密方式');
        }
		$this->method = $method;

        $this->iv = $this->initializationVector($method, $iv);
    }


    /**
     * 加密
     * @param string $plainText 明文
     * @return bool|string
     */
    public function encrypt(string $plainText)
    {
        $originData = (openssl_encrypt($this->addPkcs7Padding($plainText, 16), $this->method, $this->securityKey, OPENSSL_NO_PADDING, $this->iv));
        return $originData === false ? false : base64_encode($originData);
    }

    /**
     * 解密
     * @param string $cipherText 密文
     * @return bool|string
     */
    public function decrypt(string $cipherText)
    {
        $str = base64_decode($cipherText);
        $data = openssl_decrypt($str, $this->method, $this->securityKey, OPENSSL_NO_PADDING, $this->iv);
        return $data === false ? false : $this->stripPKSC7Padding($data);
    }

    /**
     * 初始化向量
     * @param string $method
     * @param string $iv
     * @return false|string
     */
    private function initializationVector(string $method, string $iv = '')
    {
        $originIvLen = openssl_cipher_iv_length($method);
        if(false === $originIvLen) { return ''; }
        $currentIvLen = strlen($iv);
        if ($originIvLen === $currentIvLen) {
            $outIv = $iv;
        } elseif ($currentIvLen < $originIvLen) {
            $outIv = $iv . str_repeat("\0", $originIvLen - $currentIvLen);
        } elseif ($currentIvLen > $originIvLen) {
            $outIv = substr($iv, 0, $originIvLen);
        } else {
            $outIv = str_repeat("\0", $originIvLen);
        }
        return $outIv;
    }

    /**
     * 填充算法
     * @param string $source
     * @return string
     */
    private function addPKCS7Padding($source): string
    {
        $source = trim($source);
        $block = 16;

        $pad = $block - (strlen($source) % $block);
        if ($pad <= $block) {
            $char = chr($pad);
            $source .= str_repeat($char, $pad);
        }
        return $source;
    }

    /**
     * 是否支持该加密方式
     * @param string $method
     * @return bool
     */
    private function isSupportCipherMethod(string $method): bool
    {
        $method = strtolower($method);
        if (in_array($method, openssl_get_cipher_methods(), true)) {
            return true;
        }
        return false;
    }

    /**
     * 移去填充算法
     * @param string $source
     * @return string
     */
    private function stripPKSC7Padding($source): string
    {
        $char = substr($source, -1);
        $num = ord($char);
        if ($num === 62) return $source;
        $source = substr($source, 0, -$num);
        return $source;
    }

    /**
     * 十六进制转字符串
     * @param $hex
     * @return string
     */
    private function hexToStr($hex): string
    {
        $string = "";
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $string .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $string;
    }

    /**
     * 字符串转十六进制
     * @param $string
     * @return string
     */
    private function strToHex($string): string
    {
        $hex = "";
        $tmp = "";
        $iMax = strlen($string);
        for ($i = 0; $i < $iMax; $i++) {
            $tmp = dechex(ord($string[$i]));
            $hex .= strlen($tmp) === 1 ? "0" . $tmp : $tmp;
        }
        $hex = strtoupper($hex);
        return $hex;
    }
}
