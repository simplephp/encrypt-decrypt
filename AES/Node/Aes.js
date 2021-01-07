'use strict';
const crypto = require('crypto');
const fs = require('fs');

class Aes {
	
	/**
	* Aes constructor.
	* @param string $securityKey
	* @param string $iv
	*/
	constructor(algorithm, securityKey, iv) {
		this.algorithm = algorithm;
		this.securityKey = securityKey;
		this.iv = iv;
	}
	
	/**
	* 加密
	* @param string plainText 明文
	* @return bool|string
	*/
	encrypt(plainText)
	{
		let cipherText,
		plainTextBuffer = this.addPKCS7Padding(Buffer.from(plainText));
		try {
			let cipher = crypto.createCipheriv(this.algorithm, this.securityKey, this.iv);
			cipher.setAutoPadding(false);
			let crypted  = cipher.update(plainTextBuffer);
			let newCipherText = Buffer.concat([crypted, cipher.final()]);
			cipherText = newCipherText.toString('base64');
		} catch (e) {
			console.log(e);
			cipherText = null;
		}
		return cipherText;
	}
	
	/**
	* 解密
	* @param string $cipherText 密文
	* @return bool|string
	*/
	decrypt(cipherText)
	{
		let plainText;
		try {
			let cipher = crypto.createDecipheriv(this.algorithm, this.securityKey, this.iv);
			cipher.setAutoPadding(false);
			let partCipherText = Buffer.concat([cipher.update(cipherText, 'base64'), cipher.final()]);
			let tmpPlainText = this.stripPKSC7Padding(partCipherText);
			plainText = tmpPlainText.toString();
		} catch (e) {
			console.log(e);
			plainText = null;
		}
		return plainText;
	}
	
	/**
	* 填充算法
	* @param string $source
	* @return string
	*/
	addPKCS7Padding(source)
    {
		let blockSize = 16;
		let textLength = source.length;
		//计算需要填充的位数
		let pad = blockSize - (textLength % blockSize);

		let result = Buffer.alloc(pad);
		result.fill(pad);
		return Buffer.concat([source, result]);
    }
    /**
     * 移去填充算法
     * @param string $source
     * @return string
     */
    stripPKSC7Padding(source)
    {
		var pad = source[source.length - 1];
		if (pad < 1 || pad > 16) {
			pad = 0;
		}
		return source.slice(0, source.length - pad);
    }
}
module.exports = Aes;


// run test
var securityKey16 = 'Skesj(eE%32sLOap';
var securityKey24 = 'Skesj(eE%32sLOapA9e2snEw';
var securityKey32 = 'Skesj(eE%32sLOapA9e2snEwEeopsWui';
var iv = '1234567890123456';
var algorithm = 'aes-128-cbc';
var aes = new Aes(algorithm, securityKey16, iv);

//加密
console.log('NodeJS程序');
var plainText = '我是python内容';
var cipherText = aes.encrypt(plainText);
console.log('加密前的明文：'+plainText);

console.log('加密后的密文：'+ cipherText);
//解密
var outPlainText = aes.decrypt(cipherText);
console.log('解密后明文：'+ outPlainText);