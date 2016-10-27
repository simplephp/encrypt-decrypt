/**
 * AES for java AES/ECB/PKCS5Padding
 * @author kevin(askyiwang@gmail.com)
 * @date 2016年10月25日22:27:21
 */
import javax.crypto.Cipher;
import javax.crypto.spec.SecretKeySpec;
import javax.crypto.Mac;
import javax.crypto.SecretKey;
import java.security.NoSuchAlgorithmException;
import java.security.InvalidKeyException;

public class Security {
	
	private static final String ALGORITHM = "AES";
	private static final String TRANSFORMATION = "AES/ECB/PKCS5Padding";
	private static final String DEFUALT_ENCODING = "UTF8";
	private String encKey;
	private String signKey;
	/**
	 * run test
	 * 
	 */
	public static void main(String[] args) {
		
		Security sec = new Security("8URK6BX9L20DY8V0", "8URK6BX9L20DY8V0");
		String key = "8URK6BX9L20DY8V0";
		String data = "0e1ec1a54dc21d486b1cc9c45a091eff";
		// 解密后 中文，需要处理下，不然会出现问题 String content = "中文也OK奥";
		String content = sec.decrypt(data, key);
		System.out.println("解密:" + content);
		String signContent = "68217BD37CD50114A3104B5C082899D9EFDD191D1FEA66210A5503FCDA6E933D";
		try {
			System.out.println("签名:" + sec.sign(content));
			System.out.println("验签:" + sec.verify(content, signContent));
		}catch(Exception e){
			System.out.println(e.toString());
		}
	}

	public Security(String encKey, String signKey){
		if(encKey != null && !"".equals(encKey) && signKey != null && !"".equals(signKey)){
			this.encKey = encKey;
			this.signKey = signKey;
		}
	}
	
	/**
	 * 签名
	 * @param content 	待签内容
	 * @return			签名
	 * @throws Exception
	 */
	public String sign(String content) throws Exception{
		Mac mac = Mac.getInstance("HmacSHA256");
		byte[] secretByte = signKey.getBytes(DEFUALT_ENCODING);
		byte[] dataBytes = content.getBytes(DEFUALT_ENCODING);
		SecretKey secret = new SecretKeySpec(secretByte, "HmacSHA256");
		mac.init(secret);
		byte[] doFinal = mac.doFinal(dataBytes);
		return parseByte2HexStr(doFinal);
	}
	/**
	 * 验签
	 * @param content 	签名内容
	 * @param sign		待验签名
	 * @return			true：合法； false：非法
	 * @throws Exception
	 */
	public boolean verify(String content, String sign) throws Exception{
		return sign.equals(sign(content));
	}
	
	/**
	 * 加密
     * @param String input 加密的字符串
     * @param String key   解密的key
	 * @return HexString
     */
	 
	public String encrypt(String input, String key){
		
		byte[] crypted = null;
		try{
			SecretKeySpec skey = new SecretKeySpec(key.getBytes(), ALGORITHM);
			Cipher cipher = Cipher.getInstance(TRANSFORMATION);
			cipher.init(Cipher.ENCRYPT_MODE, skey);
			crypted = cipher.doFinal(input.getBytes());
		}catch(Exception e){
			System.out.println(e.toString());
		}
		return parseByte2HexStr(crypted);

	}

	/**
	 * 将二进制转换成16进制
     * @param buf
     * @return
     */
    private static String parseByte2HexStr(byte buf[]) {
		
        StringBuffer sb = new StringBuffer();
        for (int i = 0; i < buf.length; i++) {
            String hex = Integer.toHexString(buf[i] & 0xFF);
            if (hex.length() == 1) {
                hex = '0' + hex;
            }
            sb.append(hex.toUpperCase());
        }
        return sb.toString();
		
    }
	
	/**
	 * 将16进制转换为二进制
     * @param hexStr
     * @return
     */
    private static byte[] parseHexStr2Byte(String hexStr) {
		
        if (hexStr.length() < 1)
            return null;
        byte[] result = new byte[hexStr.length()/2];
        for (int i = 0;i< hexStr.length()/2; i++) {
            int high = Integer.parseInt(hexStr.substring(i*2, i*2+1), 16);
            int low = Integer.parseInt(hexStr.substring(i*2+1, i*2+2), 16);
            result[i] = (byte) (high * 16 + low);
        }
        return result;
		
    }
	
	/**
	 * 解密
     * @param String input 解密的字符串
     * @param String key   解密的key
	 * @return String
     */
	public String decrypt(String input, String key){

		byte[] output = null;
		
		try{
			SecretKeySpec skey = new SecretKeySpec(key.getBytes(), ALGORITHM);
			Cipher cipher = Cipher.getInstance(TRANSFORMATION);
			cipher.init(Cipher.DECRYPT_MODE, skey);
			output = cipher.doFinal(parseHexStr2Byte(input));

		}catch(Exception e){
			System.out.println(e.toString());
		}
		return new String(output);
	}
}
