package com.tye.util;

import javax.crypto.Cipher;
import sun.misc.BASE64Encoder;
import sun.misc.BASE64Decoder;
import javax.crypto.spec.IvParameterSpec;
import javax.crypto.spec.SecretKeySpec;
import java.io.UnsupportedEncodingException;

public class Aes {
	
    private String ALGO = "AES";
    private byte[] iv;
	private String securityKey = "";
	private String method = "AES/CBC/PKCS5Padding";
    
    public Aes(String method, String securityKey, String iv) throws UnsupportedEncodingException {
    	this.securityKey = securityKey;
    	this.method = method;
    	this.iv = this.initIV(iv);
    }
    
	/**
     * run test
     * @param args
     * @throws Exception
     */
    public static void main(String[] args) throws Exception {
    	
    	String method = "AES/CBC/PKCS5Padding";
    	String securityKey16 = "Skesj(eE%32sLOap";
    	String securityKey24 = "Skesj(eE%32sLOapA9e2snEw";
    	String securityKey32 = "Skesj(eE%32sLOapA9e2snEwEeopsWui";
    	String iv = "1234567890123456";
    	String plainText = "����python����";
        Aes aes = new Aes(method, securityKey16, iv);
        System.out.println("Java����");
        System.out.println("����ǰ�����ģ�"+ plainText);
        String cipherText = aes.encrypt(plainText);//����java��AES/CBC/NoPadding����
        System.out.println("���ܺ������:"+cipherText);
        String outPlainText = aes.decrypt(cipherText);//����
        System.out.println("���ܺ�����:"+outPlainText);
    }
    
    /**
     * ����
     * @param plainText
     * @return
     * @throws Exception
     */
    public String encrypt(String plainText) throws Exception {
        try {
            Cipher cipher = Cipher.getInstance(this.method);
            byte[] dataBytes = plainText.getBytes("UTF-8");
            SecretKeySpec keyspec = new SecretKeySpec(this.securityKey.getBytes("UTF-8"), ALGO);
            IvParameterSpec ivspec = new IvParameterSpec(iv);
            cipher.init(Cipher.ENCRYPT_MODE, keyspec, ivspec);
            byte[] encrypted = cipher.doFinal(dataBytes);
            String EncStr = (new BASE64Encoder()).encode(encrypted);
            return EncStr;
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }
    
    /**
     * ����
     * @param cipherText
     * @return
     * @throws Exception
     */
    public String decrypt(String cipherText) throws Exception {
        try {
            byte[] encrypted1 = (new BASE64Decoder()).decodeBuffer(cipherText);
            Cipher cipher = Cipher.getInstance(this.method);
            SecretKeySpec keyspec = new SecretKeySpec(this.securityKey.getBytes("UTF-8"), ALGO);
            IvParameterSpec ivspec = new IvParameterSpec(iv);
            cipher.init(Cipher.DECRYPT_MODE, keyspec, ivspec);
            byte[] original = cipher.doFinal(encrypted1);
            String originalString = new String(original, "UTF-8");
            return originalString.trim();
        } catch (Exception e) {
            e.printStackTrace();
            return null;
        }
    }

	/**
	 * ��ʼ�����ķ�����ȫ��Ϊ0
	 * �����д���ʺ��������㷨��AES�㷨IVֵһ����128λ��(16�ֽ�)
	 */
	private byte[] initIV(String IVString) {
	    try {
	    	return IVString.getBytes("UTF-8");
	    } catch (Exception e) {
	        int blockSize = 16;
	        byte[] iv = new byte[blockSize];
	        for (int i = 0; i < blockSize; ++i) {
	            iv[i] = 0;
	        }
	        return iv;
	    }
	}
}