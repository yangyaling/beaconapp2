<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/07/16
 * Time: 21:02
 */

header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

include 'lib.php';

$sql = "SELECT r.roomid,r.roomname,ifnull(count(us.useruuid),0) as num FROM rdroom r
        left join rdbeaconinfo b on b.roomid = r.roomid
        left join rduserstatus us on b.uuid=us.uuid and b.major=us.major and b.minor=us.minor
        and date_format(us.updatetime,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')
        where r.visible >0
        group by r.roomid";


$result = query_sql($sql, $conn, $code, $errors);
while ($row=fetch_single_row($result)) {
    $d = array("roomid"=>$row[0],"roomname"=>$row[1],"num"=>$row[2]);
    echo "data:".json_encode($d)."\n\n";

    @ob_flush();
    flush();
    sleep(1);
}
closeConnection($conn);