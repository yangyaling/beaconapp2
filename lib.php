<?php
/**
 * Created by PhpStorm.
 * User: yangyl
 * Date: 2017/07/06
 * Time: 15:45
 */

// MySQL服务器
define("SAE_MYSQL_HOST_M", "beacon.mysqldb.chinacloudapi.cn");
define("SAE_MYSQL_USER", "beacon%yangyl");
define("SAE_MYSQL_PASS", "Passw0rd");
define("SAE_MYSQL_DB", "beacondb");

//打开非持久的 MySQL 连接
$conn = @mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS) or die("Could not connect:" . mysql_error());

// 设置活动的 MySQL 数据库
mysql_select_db(SAE_MYSQL_DB, $conn);


// 关闭连接
function closeConnection($conn)
{
    // mysql数据库
    mysql_close($conn);

    // sqldatabase
    //    sqlsrv_close($conn);
}

// 连接到数据库
function query_sql($sql, $conn, &$code, &$errors)
{
    $result = mysql_query($sql, $conn);
//    $result = sqlsrv_query($conn, $sql);

    if (!$result) {
        $code = '501';

        $errors = mysql_error();
        //  $errors = sqlsrv_errors();
    }
    return $result;
}

// 从结果集中取得一行作为关联数组，或数字数组，或二者兼有
function fetch_single_row($result, $result_type = MYSQL_BOTH)
{
    if ($result_type != null) {
        return mysql_fetch_array($result, $result_type);
    } else {
        return mysql_fetch_row($result);
    }
}