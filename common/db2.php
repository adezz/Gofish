<?php

//数据库类型
$dbms = 'mysql';     //数据库类型
$host = '127.0.0.1'; //数据库主机名
$dbName = 'GoFish';    //使用的数据库
$user = 'root';      //数据库连接用户名
$pass = 'XXX';          //对应的密码

$dsn = "$dbms:host=$host;dbname=$dbName";


//try {
//    $dbh = new PDO($dsn, $user, $pass); //初始化一个PDO对象
//} catch (PDOException $error) {
//    die ("Error: " . $error->getMessage() . "<br/>");
//}

//默认这个不是长连接，如果需要数据库长连接，需要最后加一个参数：array(PDO::ATTR_PERSISTENT => true)
$db = @new PDO($dsn, $user, $pass, array(PDO::ATTR_PERSISTENT => true));
