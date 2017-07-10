<?php
/**
 * Created by PhpStorm.
 * User: yangyl
 * Date: 2017/07/06
 * Time: 15:45
 */

// 东忠yangyl创建的mysql服务器
define("SAE_MYSQL_HOST_M", "beacon.mysqldb.chinacloudapi.cn");
define("SAE_MYSQL_USER", "beacon%yangyl");
define("SAE_MYSQL_PASS", "Passw0rd");
define("SAE_MYSQL_DB", "beacondb");

$conn = @mysql_connect(SAE_MYSQL_HOST_M . ':' . SAE_MYSQL_PORT, SAE_MYSQL_USER, SAE_MYSQL_PASS) or die("connect failed" . mysql_error());
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

//
function fetch_single_row($result, $result_type = MYSQL_BOTH)
{
    if ($result_type != null) {
        return mysql_fetch_array($result, $result_type);
    } else {
        return mysql_fetch_row($result);
    }
}