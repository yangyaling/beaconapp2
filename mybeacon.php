<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="mybeacon.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="mybeacon.js"></script>
    <title>RDBEACONINFO</title>
</head>
<body>
<h1>テーブルネーム：RDBEACONINFO</h1>

<?php

define("SAE_MYSQL_HOST_M",     "ja-cdbr-azure-east-a.cloudapp.net");
define("SAE_MYSQL_USER",     "bf7588dfac7e65");
define("SAE_MYSQL_PASS",     "92137672");
define("SAE_MYSQL_DB",     "rdbeacoAvghw9hxk");

$dbcolarray = array('id', 'locationname', 'uuid', 'major', 'minor');
$conn = @mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
mysql_select_db(SAE_MYSQL_DB,$conn);
$sql = sprintf("select count(*) from %s", "RDBEACONINFO");
$result = mysql_query($sql, $conn);
if ($result)
{
    
    $dbcount = mysql_fetch_row($result);
    $tpl_db_count = $dbcount[0];
}
else
{
    die("query failed");
}
$tpl_db_tablename = 'RDBEACONINFO';
$tpl_db_coltitle = $dbcolarray;
//表中内容
$tpl_db_rows = array();
$sql = sprintf("select %s from %s", implode(",",$dbcolarray), $tpl_db_tablename);
$result = mysql_query($sql, $conn);
echo "<div  align='center'>";
echo "<div  align='left'>";
echo "<caption style='font-size:15px' align='left'>ロケーション数：<label id='tableRowCount'>".$dbcount[0]."</label></caption>";
echo '<table id="Table" border=1 cellpadding=10 cellspacing=2 bordercolor=#ffaaoo>';

//表头
$thstr = "<th>" . implode("</th><th>", $dbcolarray) . " </th>";
echo $thstr;
echo "<th><input type='button' value='Add' onclick='addFun()' /> </th>";

//表中的内容
while ($row=mysql_fetch_array($result, MYSQL_ASSOC))//与$row=mysql_fetch_assoc($result)等价
{
    echo "<tr>";
    $tdstr = "";
    foreach ($dbcolarray as $td)
        $tdstr .= "<td>$row[$td]</td>";
    echo $tdstr;

    echo "<td>";
    $functionstr = "'editFun(".$row[$dbcolarray[0]].")'";
    echo "<input type='button' value='Edit' onclick=".$functionstr."/>";
    $functionstr="'deleteFun(".$row[$dbcolarray[0]].")'";
    echo    "<input type='button' value='Delete' onclick=".$functionstr."/>";
    echo '</td>';
    echo "</tr>";
}
echo "</table>";
echo "</div>";

mysql_free_result($result);
mysql_close($conn);
?>


<div id="editdiv" style="display:none;color:red;" align="left">
<table id="editItem" border=1 cellpadding=10 cellspacing=2 bordercolor=#ffaaoo>
    <th>id</th><th>locationname</th><th>uuid</th><th>major</th><th>minor</th><th>Action</th>
    <tr>
        <td><input  style="width:20px"  type=text id="editdiv_id" size="1" readonly="true" /></td>
        <td><input type=text id="editdiv_locationname" size="15"/></td>
        <td><input type=text id="editdiv_uuid" size="45"/></td>
        <td><input type=text id="editdiv_major" size="5"/></td>
        <td><input type=text id="editdiv_minor" size="5"/></td>
        <td><input type=button name="Update" value="Update" onclick="updateFun()" /></td>
    </tr>
</table>
</div>
<div id="adddiv" style="display:none;color:green;" align="left">
<table id="editItem" border=1 cellpadding=10 cellspacing=2 bordercolor=#ffaaoo>
    <th>id</th><th>locationname</th><th>uuid</th><th>major</th><th>minor</th><th>Action</th>
    <tr>
        <td class="cellid">Auto</td>
        <td><input type=text id="adddiv_locationname" size="15"/></td>
        <td><input type=text id="adddiv_uuid" size="45"/></td>
        <td><input type=text id="adddiv_major" size="5"/></td>
        <td><input type=text id="adddiv_minor"size="5" /></td>
        <td><input type=button name="Insert" value="Insert" onclick="insertFun()" /></td>
    </tr>
</table>
</div>
</div>
</body>
</html> 