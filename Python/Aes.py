# coding: utf-8
from Crypto.Cipher import AES
import base64

class Aes(object):

    def __init__(self, securityKey, iv):
        self.securityKey = securityKey
        self.iv = iv
	'''
	加密
	@param string $plainText 明文
	'''
    def encrypt(self, plainText):
        plainText = self.addPKCS7Padding(plainText)
        cipher = AES.new(self.securityKey, AES.MODE_CBC, self.iv)
        encrypted = cipher.encrypt(plainText)
        return base64.b64encode(encrypted)
	'''
	解密
	@param string $cipherText 密文
	'''
    def decrypt(self, cipherText):
        cipherText = base64.b64decode(cipherText)
        cipher = AES.new(self.securityKey, AES.MODE_CBC, self.iv)
        decrypted = cipher.decrypt(cipherText)
        decrypted = self.stripPKSC7Padding(decrypted)
        return decrypted
	'''
     填充算法
     @param string $source
     @return string
	'''
    def addPKCS7Padding(self, source):
        block = AES.block_size
        padding = block - len(source) % block
        padding_text = chr(padding) * padding
        return source + padding_text
    '''
     移去填充算法
     @param string $source
     @return string
    '''
    def stripPKSC7Padding(self, source):
        lengt = len(source)
        unpadding = ord(source[lengt - 1])
        return source[0:lengt-unpadding]

if __name__ == '__main__':
	
	securityKey16 = 'Skesj(eE%32sLOap'
	securityKey24 = 'Skesj(eE%32sLOapA9e2snEw'
	securityKey32 = 'Skesj(eE%32sLOapA9e2snEwEeopsWui'
	iv = "1234567890123456"
	aes = Aes(securityKey16, iv)
	plainText = "我是python内容";
	cipherText = aes.encrypt(plainText)
	print('Python程序')
	print('加密前的明文：'+plainText)
	print('加密后的密文：'+ cipherText)
	outPlainText = aes.decrypt(cipherText)
	print('解密后明文：'+ outPlainText)