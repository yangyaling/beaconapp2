<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-6-3
 * Time: 下午10:09
 */

//define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
//define("SAE_MYSQL_USER",     "b5b35eecdcd068");
//define("SAE_MYSQL_PASS",     "b5074189");
//define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");

include 'lib.php';

function getmonitorinfo($useruuid)
{
    //多条数据需要遍历
    $arrayReturn = array();
    $conn = @mysql_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS);
    if ($conn) {
        //mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
        //在html里设置utf8避免乱码
        mysql_select_db(SAE_MYSQL_DB, $conn);
        $strquery = "SELECT U.username,B.locationname,M.updatetime,M.status FROM RDMONITOR M LEFT JOIN RDUSERINFO U ON M.useruuid = U.uuid LEFT JOIN RDBEACONINFO B ON M.uuid=B.UUID AND M.major=B.major AND M.minor = B.minor   WHERE M.useruuid ='" . $useruuid . "' ORDER BY M.updatetime desc LIMIT 10";
        $result = mysql_query($strquery);
        $index = 0;
        while ($row = mysql_fetch_row($result)) {
            $index = $index + 1;
            $arrayReturn[$row[0] . $row[2]] = array('location' => $row[1], 'updatetime' => $row[2], 'status' => $row[3]);
        }
    }
    //print_r($arrayReturn);
    return $arrayReturn;
}

function getalluserinfo()
{
    //多条数据需要遍历
    $arrayReturn = array();
    $conn = @mysql_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS);
    if ($conn) {
        //mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
        //在html里设置utf8避免乱码
        mysql_select_db(SAE_MYSQL_DB, $conn);

        $str1 = " SELECT U.uuid, U.username, if(IsNull( B.locationname ),'',B.locationname )AS locationname, ";
        $str2 = " if(IsNull( M.updatetime ),'',M.updatetime ) AS updatetime, count( M.updatetime ) ,U.status2  ";
        $str3 = " FROM RDUSERINFO U LEFT JOIN ( ";
        $str4 = " SELECT M . * ";
        $str5 = " FROM RDUSERSTATUS M ";
        $str6 = " WHERE M.updatetime = ( ";
        $str7 = " SELECT MAX( MM.updatetime ) ";
        $str8 = " FROM RDUSERSTATUS MM ";
        $str9 = " WHERE M.useruuid = MM.useruuid ) ";
        $str10 = " GROUP BY M.useruuid ";
        $str11 = " ) AS M ON U.uuid = M.useruuid ";
        $str12 = " LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid ";
        $str13 = " AND M.major = B.major ";
        $str14 = " AND M.minor = B.minor ";
        $str15 = " GROUP BY U.uuid ";

        $strquery = $str1 . $str2 . $str3 . $str4 . $str5 . $str6 . $str7 . $str8 . $str9 . $str10 . $str11 . $str12 . $str13 . $str14 . $str15;
        $result = mysql_query($strquery);
        $index = 0;
        while ($row = mysql_fetch_row($result)) {
            $arrayReturn[$row[0]] = array('username' => $row[1], 'locationname' => $row[2], 'lasttime' => $row[3], 'status' => $row[4], 'status2' => $row[5]);
        }
    }
    //print_r($arrayReturn);
    return $arrayReturn;
}

function updateusercomment($useruuid, $comment)
{
    $ret = array();
    $conn = @mysql_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS);
    if ($conn) {
        mysql_select_db(SAE_MYSQL_DB, $conn);

        //$sqldel ="delete from APPUSERINFO WHERE uuid='" . $useruuid ."'";

        $sqlupdate = "update RDUSERINFO set comment='" . $comment . "' WHERE uuid='" . $useruuid . "'";

        $result = mysql_query($sqlupdate);

        if ($result) {

            $ret['error'] = "";
        } else {
            $ret['error'] = mysql_error();
        }
    }
    mysql_close($conn);
    //print_r($ret);
    return $ret;
}

//function insertnewuser($useruuid, $username, $status2)
//{
//    $ret = array();
//    $conn = @mysql_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS);
//    if ($conn) {
//        mysql_select_db(SAE_MYSQL_DB, $conn);
//
//        //$sqldel ="delete from APPUSERINFO WHERE uuid='" . $useruuid ."'";
//        $sqlcheck = "select * from RDUSERINFO WHERE uuid='" . $useruuid . "'";
//
//        $sqlupdate = "update RDUSERINFO set username='" . $username . "',status2='" . $status2 . "' WHERE uuid='" . $useruuid . "'";
//        $sqlinsert = "INSERT INTO RDUSERINFO (id, uuid, username,status2) VALUES (NULL,'" . $useruuid . "', '" . $username . "','" . $status2 . "')";
//
//        $result = mysql_query($sqlcheck);
//
//        if ($row = mysql_fetch_row($result)) {
//            $result = mysql_query($sqlupdate);
//        } else {
//            $result = mysql_query($sqlinsert);
//        }
//
//        if ($result) {
//
//            $sqlcheck = "select uuid,username,status2 from RDUSERINFO WHERE uuid='" . $useruuid . "'";
//            $resultreq = mysql_query($sqlcheck);
//            if ($resultreq) {
//
//                while ($row = mysql_fetch_row($resultreq)) {
//                    //array_push($arrayReturn,$row);
//                    $ret['useruuid'] = $row[0];
//                    $ret['username'] = $row[1];
//                    $ret['status2'] = $row[2];
//
//                }
//            } else {
//                $ret['error'] = mysql_error();
//            }
//        } else {
//            $ret['error'] = mysql_error();
//        }
//    }
//    mysql_close($conn);
//    //print_r($ret);
//    return $ret;
//}

function updatestatus($useruuid, $uuid, $major, $minor, $status)
{
    $ret = array();
    $conn = @mysql_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS);
    date_default_timezone_set('Asia/Tokyo');
    if ($conn) {
        mysql_select_db(SAE_MYSQL_DB, $conn);

        $sqlinsert = "INSERT INTO RDMONITOR (useruuid, uuid,major,minor,updatetime, status) VALUES ('" . $useruuid . "', '" . $uuid . "', '" . $major . "', '" . $minor . "','" . date('Y-m-d H:i:s') . "','" . $status . "')";

        $result = mysql_query($sqlinsert);

        $sqlstsins = "INSERT INTO RDUSERSTATUS (useruuid, uuid, major,minor,updatetime) VALUES ('" . $useruuid . "', '" . $uuid . "', '" . $major . "', '" . $minor . "', '" . date('Y-m-d H:i:s') . "')";
        $sqlstsdel = "DELETE FROM RDUSERSTATUS WHERE useruuid='" . $useruuid . "' AND uuid='" . $uuid . "' AND major='" . $major . "' AND minor='" . $minor . "'";
        if ($status == '1') {
            $result = mysql_query($sqlstsins);
        } else {
            $result = mysql_query($sqlstsdel);
        }
    }
    mysql_close($conn);
    return $ret;
}

function reupdatestatus($useruuid, $uuid, $major, $minor, $status, $updatetime)
{
    $ret = array();
    $conn = @mysql_connect(SAE_MYSQL_HOST_M, SAE_MYSQL_USER, SAE_MYSQL_PASS);
    date_default_timezone_set('Asia/Tokyo');
    if ($conn) {
        mysql_select_db(SAE_MYSQL_DB, $conn);

        $sqlinsert = "INSERT INTO RDMONITOR (useruuid, uuid,major,minor,updatetime, status) VALUES ('" . $useruuid . "', '" . $uuid . "', '" . $major . "', '" . $minor . "','" . $updatetime . "','" . $status . "')";
        $ret['sql'] = $sqlinsert;
        $result = mysql_query($sqlinsert);

        $sqlstsins = "INSERT INTO RDUSERSTATUS (useruuid, uuid, major,minor,updatetime) VALUES ('" . $useruuid . "', '" . $uuid . "', '" . $major . "', '" . $minor . "', '" . $updatetime . "')";
        $sqlstsdel = "DELETE FROM RDUSERSTATUS WHERE useruuid='" . $useruuid . "' AND uuid='" . $uuid . "' AND major='" . $major . "' AND minor='" . $minor . "'";
        if ($status == '1') {
            $result = mysql_query($sqlstsins);
        } else {
            $result = mysql_query($sqlstsdel);
        }
    }

    mysql_close($conn);
    return $ret;
}

//function getlocation()
//{
//    //多条数据需要遍历
//    //header('Content-type: text/json; charset=UTF-8');
//    $arrayReturn = array();
////    if ($conn) {
//        //mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
//        //在html里设置utf8避免乱码
//        //mysql_select_db(SAE_MYSQL_DB, $conn);
//        $result = query_sql("SELECT locationname,uuid,major,minor FROM RDBEACONINFO", $conn, $code, $errors);
//        if ($result) {
//            //$arrayReturn['yyy'] = 'OI';
//            while ($row = fetch_single_row($result)) {
//                $arrayReturn[$row[0]] = array('uuid' => $row[1], 'major' => $row[2], 'minor' => $row[3]);
//            }
//        } else {
//            $arrayReturn['yyy'] = mysql_error();
//        }
////    } else {
//        //$arrayReturn['yyy'] = mysql_error();
////   }
//    //print_r($arrayReturn);
//    return $arrayReturn;
//}
arrayReturn;
//}
arrayReturn;
//}
