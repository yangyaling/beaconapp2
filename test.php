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

$dbcolarray = array('名前');
$tpl_db_tablename = 'RDBEACONINFO';

$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
$sql = sprintf("select locationname from %s",$tpl_db_tablename);

mysql_select_db(SAE_MYSQL_DB,$conn);

$result = mysql_query($sql, $conn);

while ($row1=mysql_fetch_array($result, MYSQL_ASSOC)){
    $title=$row1["locationname"];
    array_push($dbcolarray, $title);
}


$tpl_db_coltitle = $dbcolarray;

//表中内容
$tpl_db_rows = array();
$sql = "SELECT U.username, IF( ISNULL( B.locationname ) ,  '', B.locationname ) AS locationname, U.status2,U.comment  FROM RDUSERINFO U ";
$sql = $sql."LEFT JOIN (SELECT M. *  FROM RDUSERSTATUS M WHERE M.updatetime = (  SELECT MAX( MM.updatetime )  FROM RDUSERSTATUS MM ";
$sql = $sql."WHERE M.useruuid = MM.useruuid ) GROUP BY M.useruuid) AS M ON U.uuid = M.useruuid LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid ";
$sql = $sql."AND M.major = B.major AND M.minor = B.minor GROUP BY U.uuid ";

$result = mysql_query($sql, $conn);

echo "<div  align='left'>";


echo '<table id="Table" border=1 cellpadding=10 cellspacing=1 bordercolor=#408080 width="100%">';
echo '<h1>【R＆D室要員在席情報一覧】(メンテナンス中)</h1>';
$thstr = "※更新時間：";
echo $thstr;

echo "<div id='updatetime'>";
$thstr = "<script type='text/javascript'>";
$thstr = $thstr."var myDate = new Date();";
$thstr = $thstr."document.write(myDate.toLocaleString())";
$thstr = $thstr."</script>";
echo $thstr;
echo "</div>";
//表头
$thstr = "<th>" . implode("</th><th>", $dbcolarray) . " </th>";
echo $thstr;

//表中的内容
while ($row=mysql_fetch_array($result, MYSQL_ASSOC)){
    echo "<tr>";
    $tdstr = "";

    foreach ($dbcolarray as $td){
        if($td=="名前"){
            $tdstr .= "<td>".$row["username"]."</td>";
        }else{
            if($row["locationname"] == $td) {
                if ($row["status2"] == "0") {
                    $tdstr .= "<td align='center' style='color:#311bdb;' >○</td>";
                } else if ($row["status2"] == "1") {
                    $tdstr .= "<td align='center' style='color:#311bdb;'>○[".$row["comment"]."]</td>";
                } else {
                    $tdstr .= "<td  align='center'  style='color:#311bdb;'></td>";
                }
            }else{
                $tdstr .= "<td  align='center'  style='color:#311bdb;'></td>";
            }
        }
    }
    echo $tdstr;
    echo "</tr>";
}
echo "</table>";
echo "</div>";

$thstr ="<br/>";
$thstr = $thstr."<a href='mybeacon.php'>■Beacon管理</a>";
//查询用户是否存在
mysql_free_result($result);
$result=mysql_query("SELECT * FROM user",$conn);
if ($myrow = mysql_fetch_row($result)){
    $str = $myrow[0]."," .$myrow[1];
}
echo $thstr;
echo "<br>str:=" .$str;
echo "<br>myrow:=" .$myrow;

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