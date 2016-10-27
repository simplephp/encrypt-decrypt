<?php
/**
 * AES for PHP AES/ECB/PKCS5Padding
 * @author kevin(email: askyiwang@gmail.com, qq: 841694874)
 * @date 2016年10月25日22:27:21
 * @charset utf-8
 */
class Security {
	
	private $key = null;
	private $signKey = null;
	/**
	 * 
     * @param $key 		密钥
	 * @return String
     */
	public function __construct($key = null, $signKey = null) {
		
		if(is_null($key)) {
			throw new \Exception('set sccret key please.');
		}
		if(is_null($signKey)) {
			throw new \Exception('set sign key please.');
		}
		$this->key = $key;
		$this->signKey = $signKey;
		
	}
	/**
	 * 签名 php sha256 Java  HmacSHA256
     * @param String content 签名内容
	 * @return hex
     */
	 
	public function sign($content) {
		
		return strtoupper(hash_hmac('sha256', $content, $this->signKey));
		
	}
	
	/**
	 * 验签
	 * @param content 	签名内容
	 * @param sign		待验签名
	 * @return			true：合法； false：非法
	 * @throws Exception
	 */
	public function verify($content, $sign) {
		
		if($sign == $this->sign($content)) {
			return true;
		}
		return false;
		
	}
	
	/**
	 * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
	 * @return HexString
     */
	public function encrypt($input) {
		
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$input = $this->pkcs5_pad($input, $size);
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $this->key, $iv);
		$data = mcrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$data = bin2hex($data);
		return $data;
		
	}
	/**
	 * 填充方式 pkcs5
     * @param String text 		 原始字符串
     * @param String blocksize   加密长度
	 * @return String
     */
	private function pkcs5_pad($text, $blocksize) {
		
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
		
	}
	
	/**
	 * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
	 * @return String
     */
	public function decrypt($sStr) {

		$decrypted= mcrypt_decrypt(MCRYPT_RIJNDAEL_128,$this->key,hex2bin($sStr), MCRYPT_MODE_ECB);
		$dec_s = strlen($decrypted);
		$padding = ord($decrypted[$dec_s-1]);
		$decrypted = substr($decrypted, 0, -$padding);
		return $decrypted;
	}
	
	/**
     * key=value&key1=value1
     * @param $para 数组
     * @param $encode 是否需要URL编码
     * @return string
     */
    private function createLinkString($para, $encode) {
		
    	ksort($para);   //排序
    	$linkString = "";
    	while ( list ( $key, $value ) = each ( $para ) ) {
    		if ($encode) {
    			$value = urlencode ( $value );
    		}
    		$linkString .= $key . "=" . $value . "&";
    	}
    	// 去掉最后一个&字符
    	$linkString = substr ( $linkString, 0, count ( $linkString ) - 2 );

    	return $linkString;
		
    }
}

$data = "呵呵";
$security = new Security('8URK6BX9L20DY8V0', '8URK6BX9L20DY8V0');
$value = $security->encrypt($data);
echo "===================================================================加密==========================================================<br/>";
echo $value.'<br/>';
echo "===================================================================解密==========================================================<br/>";
echo $security->decrypt($value).'<br/>';

echo "===================================================================签名===========================================================<br/>";
$sign = $security->sign($data);
echo $sign.'<br/>';
echo "=================================================================签名结果===========================================================<br/>";
//var_dump($security->sign($data)).'<br/>';