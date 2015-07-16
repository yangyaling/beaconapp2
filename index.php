<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css" media="screen">
    tr.t1 td {background-color:FFFFFF;}/* 第一行的背景色 */
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
    <title>在席情報</title>
</head>
<body onload="init()">
<?php

define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "bf7588dfac7e65");
define("SAE_MYSQL_PASS",     "92137672");
define("SAE_MYSQL_DB",     "rdbeacoAvghw9hxk");

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
$sql = "SELECT U.username, IF( ISNULL( B.locationname ) ,  '', B.locationname ) AS locationname, U.status2 FROM RDUSERINFO U ";
$sql = $sql."LEFT JOIN (SELECT M. *  FROM RDUSERSTATUS M WHERE M.updatetime = (  SELECT MAX( MM.updatetime )  FROM RDUSERSTATUS MM ";
$sql = $sql."WHERE M.useruuid = MM.useruuid ) GROUP BY M.useruuid) AS M ON U.uuid = M.useruuid LEFT JOIN RDBEACONINFO B ON M.uuid = B.uuid ";
$sql = $sql."AND M.major = B.major AND M.minor = B.minor GROUP BY U.uuid ";

$result = mysql_query($sql, $conn);

echo "<div  align='left'>";

echo '<table id="Table" border=1 cellpadding=10 cellspacing=1 bordercolor=#408080 width="100%">';
echo '<h1>【R＆D室要員在席情報一覧】</h1>';

$thstr = "※時間　";
echo $thstr;

$thstr = "<script type='text/javascript'>";
$thstr = $thstr."var myDate = new Date();";
$thstr = $thstr."document.write(myDate.toLocaleString())";
$thstr = $thstr."</script>";
echo $thstr;

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
                    $tdstr .= "<td align='center' style='color:#00DB00;' >●</td>";
                } else if ($row["status2"] == "1") {
                    $tdstr .= "<td align='center' style='color:#FF0000;' >●</td>";
                } else {
                    $tdstr .= "<td></td>";
                }
            }else{
                $tdstr .= "<td></td>";
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
echo $thstr;

mysql_free_result($result);
mysql_close($conn);
?>

</body>
</html>