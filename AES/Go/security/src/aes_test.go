package src

import (
	"bytes"
	basicAES "crypto/aes"
	"crypto/cipher"
	"encoding/base64"
	"fmt"
	"testing"
)

/**
 * run test
 */
func TestAes(t *testing.T) {

	plainText := "我是python内容"
	securityKey16 := "Skesj(eE%32sLOap"
	//securityKey24 := "Skesj(eE%32sLOapA9e2snEw"
	//securityKey32 := "Skesj(eE%32sLOapA9e2snEwEeopsWui"
	iv := "1234567890123456"
	aes := aesTool(securityKey16, iv)
	fmt.Println("加密前的明文：" + plainText)
	cipherText, _ := aes.encrypt(plainText)
	fmt.Println("加密后的密文：" + cipherText)
	outPlainText, _ := aes.decrypt(cipherText)
	fmt.Println("解密后明文：" + outPlainText)
}

type aes struct {
	securityKey []byte
	iv          []byte
}

/**
 * constructor
 */
func aesTool(securityKey string, iv string) *aes {
	return &aes{[]byte(securityKey), []byte(iv)}
}

/**
 * 加密
 * @param string $plainText 明文
 * @return bool|string
 */
func (a aes) encrypt(plainText string) (string, error) {
	block, err := basicAES.NewCipher(a.securityKey)
	if err != nil {
		return "", err
	}
	plainTextByte := []byte(plainText)
	blockSize := block.BlockSize()
	plainTextByte = addPKCS7Padding(plainTextByte, blockSize)
	cipherText := make([]byte, len(plainTextByte))
	mode := cipher.NewCBCEncrypter(block, a.iv)
	mode.CryptBlocks(cipherText, plainTextByte)
	return base64.StdEncoding.EncodeToString(cipherText), nil
}

/**
 * 解密
 * @param string $cipherText 密文
 * @return bool|string
 */
func (a aes) decrypt(cipherText string) (string, error) {
	block, err := basicAES.NewCipher(a.securityKey)
	if err != nil {
		return "", err
	}
	cipherDecodeText, decodeErr := base64.StdEncoding.DecodeString(cipherText)
	if decodeErr != nil {
		return "", decodeErr
	}
	mode := cipher.NewCBCDecrypter(block, a.iv)
	originCipherText := make([]byte, len(cipherDecodeText))
	mode.CryptBlocks(originCipherText, cipherDecodeText)
	originCipherText = stripPKSC7Padding(originCipherText)
	return string(originCipherText), nil
}

/**
 * 填充算法
 * @param string $source
 * @return string
 */
func addPKCS7Padding(ciphertext []byte, blockSize int) []byte {
	padding := blockSize - len(ciphertext)%blockSize
	paddingText := bytes.Repeat([]byte{byte(padding)}, padding)
	return append(ciphertext, paddingText...)
}

/**
 * 移去填充算法
 * @param string $source
 * @return string
 */
func stripPKSC7Padding(cipherText []byte) []byte {
	length := len(cipherText)
	unpadding := int(cipherText[length-1])
	return cipherText[:(length - unpadding)]
}
