### 项目介绍

项目地址：https://github.com/simplephp/encrypt-decrypt

![AES PKCS7Padding](https://img.shields.io/badge/AES-PKCS7Padding-green.svg "AES")
![RSA](https://img.shields.io/badge/RSA-更新中-green.svg "AES")

按照加密方式可分为对称和非对称加密，对称加密即发送方和接收方都是用相同的秘钥进行加解密，非对称加密则使用一对公私钥来进行加解密，发送方使用公钥加密数据，接收方可使用私钥来解密。
 * 对称加密：
 
 *     简单的加密设计： 用密钥对原文做字节代替、行移动、列混淆、加轮秘钥
 *     优点： 安全、快速(加解密运算速度快、资源消耗少、消耗时间少)、支持二进制
 *     缺点： 发送方和接收方协定秘钥，双方保存好秘钥安全不被泄漏，加重了心智负担
 * 常见的对称加密方式有 DES、3DES、AES、Blowfish、IDEA、RC5、RC6， 从安全性、资源消耗、运算速度、消耗时间综合来看 AES 都是值得选择的对称加密方式。
 
```diff
- 注意一下代码均为 DEMO 版本, 存在不严谨的地方，切勿直接拿到生产环境使用，否则后果自负。
```
### 项目结构

```
├─ Encrypt
│  ├─ AES
│     ├── Java
|         ├── Security
|             ├── src
|                 ├── com.tye.util
|                     ├── Aes.java
│     ├── Go
|         ├── security
|             ├── src
|                 ├── aes_test.go
│     ├── Python
|          ├── Aes.py
│     ├── Node
|          ├── Aes.js
│     ├── PHP
|          ├── Aes.php
│     ├── JavaScript
|          ├── Aes.html
```

如果你发现本项目涉及程序运行有误，欢迎提交 issues 进行指正。如对您有所帮助，请不吝:star2:。

#### 关于 AES-[128|192|256]-CBC
- [x] Java
- [x] Go
- [x] Python
- [x] NodeJS
    -  [crypto-js](https://github.com/brix/crypto-js)
- [x] PHP
    - OpenSSL
- [x] JavaScript
    - [crypto-js](https://github.com/brix/crypto-js)
- [ ] C/C++
- [ ] C#

#### AES-[128|192|256]-CBC 运行结果

|  结果 | 编程语言  |
| :------------ | :------------ |
| ![Java-AES-128-CBC-PKCS7Padding](https://github.com/simplephp/encrypt-decrypt/blob/master/AES/images/aes/Java-aes-128-cbc-pkcs7.png "Java AES-128-CBC PKCS7Padding") | Java |
| ![Go-AES-128-CBC-PKCS7Padding](https://github.com/simplephp/encrypt-decrypt/blob/master/AES/images/aes/Go-aes-128-cbc-pkcs7.png "Go AES-128-CBC PKCS7Padding") | Go |
| ![Python-AES-128-CBC-PKCS7Padding](https://github.com/simplephp/encrypt-decrypt/blob/master/AES/images/aes/Python-aes-128-cbc-pkcs7.png "Python AES-128-CBC PKCS7Padding") | Python |
|![NodeJS-AES-128-CBC-PKCS7Padding](https://github.com/simplephp/encrypt-decrypt/blob/master/AES/images/aes/NodeJS-aes-128-cbc-pkcs7.png "NodeJS AES-128-CBC PKCS7Padding") | NodeJS|
| ![PHP-AES-128-CBC-PKCS7Padding](https://github.com/simplephp/encrypt-decrypt/blob/master/AES/images/aes/PHP-aes-128-cbc-pkcs7.png "PHP AES-128-CBC PKCS7Padding") | PHP |
| ![JavaScript-AES-128-CBC-PKCS7Padding](https://github.com/simplephp/encrypt-decrypt/blob/master/AES/images/aes/JavaScript-aes-128-cbc-pkcs7.png "JavaScript AES-128-CBC PKCS7Padding") | JavaScript |

#### 问题反馈

- 报告 issue: [github issues](https://github.com/simplephp/encrypt-decrypt/issues)
