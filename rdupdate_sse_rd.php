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

$sql = "SELECT u.uuid,u.username,count(rm.roomid) as num,u.status2
FROM rduserinfo u
left join rduserstatus us on u.uuid = us.useruuid and date_format(us.updatetime,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')
left join rdbeaconinfo b on b.uuid = us.uuid
						and b.major = us.major
                        and b.minor = us.minor
left join rdroom rm on rm.roomid = b.roomid and rm.visible = 1
where u.visible = 1
group by u.uuid
order by u.listindex asc";

$result = query_sql($sql, $conn, $code, $errors);
while ($row=fetch_single_row($result)) {
    $d = array("uuid"=>$row[0],"username"=>$row[1],"num"=>$row[2],"status2"=>$row[3]);
    echo "data:".json_encode($d)."\n\n";

    @ob_flush();
    flush();
    sleep(1);
}
closeConnection($conn);