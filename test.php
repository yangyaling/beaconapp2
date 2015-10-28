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

    <title>在席情報</title>
</head>
<body onload="init()">
<?php

define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "b5b35eecdcd068");
define("SAE_MYSQL_PASS",     "b5074189");
define("SAE_MYSQL_DB",     "rdbeacoAd7N1JMXE");





echo   "<div  align='left'>
        <table id='Table' border=1 cellpadding=10 cellspacing=1 bordercolor=#408080 width='100%'>
        <h1>【R＆D室要員在席情報一覧】(メンテナンス中)</h1>
        ※更新時間：
        <div id='updatetime'>
            <script type='text/javascript'>
                var myDate = new Date();
                document.write(myDate.toLocaleString())
            </script>
        </div>";
//表头



//表中的内容
$sql = "SELECT r.roomid,r.roomname,ifnull(count(us.useruuid),0) as num FROM rdroom r
        left join rdbeaconinfo b on b.roomid = r.roomid
        left join rduserstatus us on b.uuid=us.uuid and b.major=us.major and b.minor=us.minor
        and date_format(us.updatetime,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')
        group by r.roomid ";

$result = mysql_query($sql, $conn);

echo '11111111111';
$dbcolarray = array(0=>'ルームID',1=>'ルームネーム',2=>'状態');
echo "<th>" . implode("</th><th>", $dbcolarray) . " </th>";
while ($row=mysql_fetch_array($result, MYSQL_ASSOC)) {
    echo $row[0];
    echo "<tr>";
    if ($row["num"] > 0) {
        $thstr = "<tr>" . implode("</tr><tr>", $row) . " </tr>";
    }else{
        $thstr = "<tr>" . implode("</tr><tr>", $row) . " </tr>";
    }
    echo "</tr>";
}
echo "</table>";
echo "</div>";


echo "<br/><a href='mybeacon.php'>■Beacon管理</a>";

mysql_free_result($result);
mysql_close($conn);
?>

<script>
    if(typeof(EventSource)!=="undefined"){

        var es = new EventSource("rdupdate_sse.php");
        es.addEventListener("message",function(e){
            var data = JSON.parse(e.data);
            var username = data.username;
            var locationname = data.locationname;
            var status= data.status;
            var comment = data.comment;

            updateRowInTable(username, locationname,status,comment);

        },false);
    }
</script>

</body>
</html>