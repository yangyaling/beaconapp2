<?php
/**
 * Created by PhpStorm.
 * User: yangyl
 * Date: 2017/07/06
 * Time: 15:45
 */

// MySQL服务器
define("SAE_MYSQL_HOST_M", "rdbeacon.database.chinacloudapi.cn");
define("SAE_MYSQL_USER", "yangyl");
define("SAE_MYSQL_PASS", "Passw0rd");
define("SAE_MYSQL_DB", "rdbeacondb");

// 连接到数据库
function openConnection()
{
    $connectionOptions = array(
        'Database' => SAE_MYSQL_DB,
        'Uid' => SAE_MYSQL_USER,
        'PWD' => SAE_MYSQL_PASS,
        'CharacterSet' => 'UTF-8'
    );
    return sqlsrv_connect("tcp:" . SAE_MYSQL_HOST_M . ",1433", $connectionOptions);
}

// 关闭连接
function closeConnection($conn)
{

    // sqldatabase
    sqlsrv_close($conn);
}

// 执行查询处理
function query_sql($sql, $conn, &$code, &$errors)
{
    $result = sqlsrv_query($sql, $conn);

    if (!$result) {
        $code = '501';

        $errors = sqlsrv_errors();
    }
    return $result;
}

// 从结果集中取得一行作为关联数组，或数字数组，或二者兼有
function fetch_single_row($result)
{
    return sqlsrv_fetch_array($result);
}

$conn = openConnection();
if (!$conn) {
    die("Could not connect:" . sqlsrv_errors());
}