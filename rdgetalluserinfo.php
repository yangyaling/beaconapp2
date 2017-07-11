<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/06/04
 * Time: 11:55
 */

include 'lib.php';

$arrayReturn = array();


//    $str1 = " SELECT U.uuid, U.username, if(IsNull( B.locationname ),'',B.locationname )AS locationname, ";
//    $str2 = " if(IsNull( M.updatetime ),'',M.updatetime ) AS updatetime, count( M.updatetime ) ,U.status2  ";
//    $str3 = " FROM RDUSERINFO U LEFT JOIN ( ";
//    $str4 = " SELECT M . * ";
//    $str5 = " FROM RDUSERSTATUS M ";
//    $str6 = " WHERE M.updatetime = ( ";
//    $str7 = " SELECT MAX( MM.updatetime ) ";
//    $str8 = " FROM RDUSERSTATUS MM ";
//    $str9 = " WHERE M.useruuid = MM.useruuid ) ";
//    $str10 = " GROUP BY M.useruuid ";
//    $str11 = " ) AS M ON U.uuid = M.useruuid ";
//    $str12 = " LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid ";
//    $str13 = " AND M.major = B.major ";
//    $str14 = " AND M.minor = B.minor ";
//    $str15 = " GROUP BY U.uuid ";

$strquery=<<<EOF
SELECT
	U.uuid,
	U.username,
	ISNULL(B.locationname, '') locationname,
	ISNULL(M.updatetime, '') updatetimem,
	M.status,
	U.status2
FROM
	RDUSERINFO U
LEFT JOIN (
	SELECT
		M.*,
		ROW_NUMBER () OVER (
			partition BY m.uuid
			ORDER BY
				updatetime DESC
		) rn,
		COUNT (uuid) OVER (PARTITION BY uuid) status
	FROM
		RDUSERSTATUS M
) AS M ON U.uuid = M.useruuid
AND M.rn = 1
LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid
AND M.major = B.major
AND M.minor = B.minor
EOF;



//    $strquery = $str1 . $str2 . $str3 . $str4 . $str5 . $str6 . $str7 . $str8 . $str9 . $str10 . $str11 . $str12 . $str13 . $str14 . $str15;

    $result = query_sql($strquery, $conn, $code, $errors);
    if($result){
        while ($row = fetch_single_row($result)) {
            $arrayReturn[$row[0]] = array('username' => $row[1], 'locationname' => $row[2], 'lasttime' => $row[3], 'status' => $row[4], 'status2' => $row[5]);
        }
    }else{
        $arrayReturn['yyy'] = sqlsrv_errors();
    }












//$arrReturn = getalluserinfo();
sendResponse(json_encode($arrayReturn));

?>