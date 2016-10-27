最近做项目涉及到一丢丢的安全问题，需要 PHP 加密，Java 解密，对方使用的 AES加密与解密填充模式使用AES/ECB/PKCS5Padding，编码为UTF-8，发现PHP的padding与Java的padding不一样，so 需要自己对加密字符串padding后在加密就能解决，php 加密和 java 不一样的问题，至于详细问题请google 不想误人子弟 。闲话不说了，直接上截图，如果帮助到你请给一个"星波波"奥(我真是厚脸皮+虚荣心的人)。注意 java 和 php的代码均为demo版本，切勿拿到生产环境使用，需要修改，我是做PHP 的，java 内功差，部分代码没有catch 异常，哈哈!!!
php 代码演示截图
![image](https://github.com/simplephp/php-java-AES-128-ECB/blob/master/aes1.jpg)
java 代码演示截图
![image](https://github.com/simplephp/php-java-AES-128-ECB/blob/master/aes2.jpg)
