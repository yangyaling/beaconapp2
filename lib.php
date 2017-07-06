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
$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS) or die("connect failed" . mysql_error());
mysql_select_db(SAE_MYSQL_DB, $conn);

