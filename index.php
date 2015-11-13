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

    <title>次世代Ｒ＆Ｄ室1</title>


</head>
<body onload="init()">
<?php

define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "b5b35eecdcd068");
define("SAE_MYSQL_PASS",     "b5074189");
define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB,$conn);

//表中的内容
$sql = "SELECT r.roomid,r.roomname,ifnull(count(us.useruuid),0) as num FROM rdroom r
        left join rdbeaconinfo b on b.roomid = r.roomid
        left join rduserstatus us on b.uuid=us.uuid and b.major=us.major and b.minor=us.minor
        and date_format(us.updatetime,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')
        where r.visible > 0
        group by r.roomid ";

$result = mysql_query($sql, $conn);

$dbcolarray = array(0=>'ルームID',1=>'ルームネーム',2=>'状態');

echo   "<div  align='center'>
        <table id='Table' border=1 cellpadding=10 cellspacing=1 bordercolor=#408080 width='50%'>";


echo "<th style='display: none'>roomid</th><th>ルームネーム</th><th>状態</th>";

while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo "<tr>";
    $roomid= $row['roomid'];
    $roomname=$row['roomname'];
    $num=$row['num'];
    $inhtm = '';
    if($num >0){
        $inhtm ="<img src='open.png'>";
    }else{
        $inhtm ="<img src='close.png'>";
    }
    $thstr = "<td style='display: none'>$roomid</td><td>$roomname</td><td>$inhtm</td>";
    echo $thstr;
    echo "</tr>";
}
echo "</table>";
//echo "<br/><a href='login.html'>■管理画面へ</a>";
//echo "<br/><a href='mybeacon.php'>■Beacon管理</a>";
echo "※更新時間： <div id='updatetime'>
            <script type='text/javascript'>
                var myDate = new Date();
                document.write(myDate.toLocaleString())
            </script>";
echo "</div>";




mysql_free_result($result);
mysql_close($conn);
?>

<script>
    if(typeof(EventSource)!=="undefined"){

        var es = new EventSource("rdupdate_sse_new.php");
        es.addEventListener("message",function(e){
            var data = JSON.parse(e.data);
            var roomid = data.roomid;
            var rommname = data.roomname;
            var num= data.num;

            updateStatusInTable(roomid,num);

        },false);
    }
</script>

</body>
</html>
