<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css" media="screen">
    tr.t1 td {background-color:#FFFFFF;}/* 第一行的背景色 */
    tr.t2 td {background-color:#D2E9FF;}/* 第二行的背景色 */
</style>
<script type="text/javascript">
    <!--
    function init() {
        var ptr=document.getElementById("Table").getElementsByTagName("tr");
        var pth=document.getElementById("Table").getElementsByTagName("th");
        for (i=1;i<ptr.length+1;i++) {
            ptr[i-1].className = (i%2>0)?"t2":"t1";
        }
        for (i=1;i<pth.length+1;i++) {
            pth[i-1].width = 100/pth.length+"%";
        }
    }
    //-->
</script>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="mybeacon.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="mybeacon.js"></script>

    <title>次世代Ｒ＆Ｄ室</title>


</head>
<body onload="init()">
<?php

include 'lib.php';

//define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
//define("SAE_MYSQL_USER",     "b5b35eecdcd068");
//define("SAE_MYSQL_PASS",     "b5074189");
//define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");
//
//$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
//mysql_select_db(SAE_MYSQL_DB,$conn);

$sql = "select roomname from rdroom where visible=1";
$result = query_sql($sql, $conn, $code, $errors);
$displayname='ルーム未設定';
if ($row=fetch_single_row($result)){
    $displayname=$row['roomname'];
}

//表中的内容
$sql = "SELECT
	u.uuid,
	u.username,
	u.status2,
	COUNT (u.roomid) AS num
FROM
	(
		SELECT
			u.uuid,
			u.username,
			u.status2,
			u.listindex,
			rm.roomid
		FROM
			rduserinfo u
		LEFT JOIN rduserstatus us ON u.uuid = us.useruuid
		AND CONVERT (
			VARCHAR (10),
			us.updatetime,
			120
		) = CONVERT (VARCHAR(10), GETDATE(), 120)
		LEFT JOIN rdbeaconinfo b ON b.uuid = us.uuid
		AND b.major = us.major
		AND b.minor = us.minor
		LEFT JOIN rdroom rm ON rm.roomid = b.roomid
		AND rm.visible = 1
		WHERE
			u.visible = 1
	) u
GROUP BY
	u.uuid,
	u.username,
	u.status2,
	u.listindex
ORDER BY
	u.listindex ASC";

$result = query_sql($sql, $conn, $code, $errors);

//$dbcolarray = array(0=>'ユーザID',1=>'ユーザネーム',2=>$displayname);

echo   "<div  align='center'>
        <table id='Table' border=1 cellpadding=10 cellspacing=1 bordercolor=#408080 width='50%'>";


echo "<th style='display: none'>uuid</th><th>用户名</th><th>$displayname</th>";

while ($row=fetch_single_row($result)) {
    echo "<tr>";
    $uuid= $row['uuid'];
    $username=$row['username'];
    $num=$row['num'];
    $inhtm = '';
    $status2= $row['status2'];
    if($num >0){
        if($status2=='1'){
            $inhtm ="<strong>在席[busy]</strong>";//"<img src='open.png'>";
        }else{
            $inhtm ="<strong>在席</strong>";//"<img src='open.png'>";
        }

    }else{
        $inhtm ="<strong>不在</strong>";//"<img src='close.png'>";
    }
    $thstr = "<td style='display: none'>$uuid</td><td>$username</td><td>$inhtm</td>";
    echo $thstr;
    echo "</tr>";
}
echo "</table>";
//echo "<br/><a href='login.html'>■管理画面へ</a>";
//echo "<br/><a href='mybeacon.php'>■Beacon管理</a>";
echo "<div id='updatetime'>
            <script type='text/javascript'>
                var myDate = new Date();
                document.write('※更新時間：'+ myDate.toLocaleString())
            </script>";
echo "</div>";




//mysql_free_result($result);
//mysql_close($conn);
?>

<script>
    if(typeof(EventSource)!=="undefined"){

        var es = new EventSource("rdupdate_sse_rd.php");
        es.addEventListener("message",function(e){
            var data = JSON.parse(e.data);
            var uuid = data.uuid;
            var username = data.username;
            var num= data.num;
            var status2 =  data.status2;
            updateStatusInTable(uuid,num,status2);

        },false);
    }
</script>

</body>
</html>
