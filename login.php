<?php

include 'lib.php';

$lifeTime = 24 * 3600;
session_set_cookie_params($lifeTime);

session_start();

//  表单提交后...
$posts = $_POST;
//  清除一些空白符号
foreach ($posts as $key => $value) {
    $posts[$key] = trim($value);
}
$password = $posts["password"];
$username = $posts["username"];

//查询用户是否存在
$sql = sprintf("SELECT * FROM user where userid='%s' and password='%s'",$username,$password);
$result = query_sql($sql, $conn, $code, $errors);

if ($myrow = fetch_single_row($result)){
//以下为身份验证成功后的相关操作
    $_SESSION["admin"] = $username;
    header("location:mybeacon.php");
}else{
    $_SESSION["admin"] = null;
    header("Content-type: text/html; charset=utf-8");
    echo "用户名或者密码不正确";
    header("location:login.html");
}
?>