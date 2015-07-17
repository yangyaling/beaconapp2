/**
 * Created by jimiao on 2015/06/23.
 */
//在表格的第一列中查找等于指定ID的行
function SearchIdInTable(tablerow, findid)
{
    var i;
    var tablerownum = tablerow.length;
    for (i = 1; i < tablerownum; i++)
        if ($("#Table tr:eq(" + i + ") td:eq(0)").html() == findid)
            return i;
    return -1;
}

function updateRowInTable(username, locationname,status)
{
    var i = SearchIdInTable($("#Table tr"), username);
    var myDate = new Date();;
    document.getElementById("updatetime").innerHTML =myDate.toLocaleString();
    if (i != -1)
    {
        var pth=document.getElementById("Table").getElementsByTagName("th");

        var irow;
        for (irow=2;irow<pth.length+1;irow++) {
            var strtitle = pth[irow-1].innerHTML;
            var strvalue;
            if(status=="1"){
                strvalue="●[XX作業中]";
            }else{
                strvalue="●";
            }
            $("#Table tr:eq(" + i + ") td:eq("+(irow -1)+")").html(strtitle == locationname ? strvalue : "");
        }
        if(status =="1"){
            $("#Table tr:eq(" + i + ") td:eq("+(irow -1)+")").style.color ='#FF0000;';
        }else{
            $("#Table tr:eq(" + i + ") td:eq("+(irow -1)+")").style.color ='#00DB00;';
        }
    }
}

//用CSS控制奇偶行的颜色
function SetTableRowColor()
{
    $("#Table tr:odd").css("background-color", "#e6e6fa");
    $("#Table tr:even").css("background-color", "#fff0fa");
    $("#Table tr:odd").hover(
        function(){$(this).css("background-color", "orange");},
        function(){$(this).css("background-color", "#e6e6fa");}
    );
    $("#Table tr:even").hover(
        function(){$(this).css("background-color", "orange");},
        function(){$(this).css("background-color", "#fff0fa");}
    );
}

function checkuuid(uuid){
    var reg=/^[A-Fa-f0-9]{8}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{4}-[A-Fa-f0-9]{12}$/;
    return reg.test(uuid);
}

//响应edit按钮
function editFun(id)
{
    var i = SearchIdInTable($("#Table tr"), id);
    $("#editdiv").show();
    $("#adddiv").hide();
    $("#editdiv_id").val(id);
    $("#editdiv_locationname").val($("#Table tr:eq(" + i + ") td:eq(1)").html());
    $("#editdiv_uuid").val($("#Table tr:eq(" + i + ") td:eq(2)").html());
    $("#editdiv_major").val($("#Table tr:eq(" + i + ") td:eq(3)").html());
    $("#editdiv_minor").val($("#Table tr:eq(" + i + ") td:eq(4)").html());
}
//响应add按钮
function addFun()
{
    $("#editdiv").hide();
    $("#adddiv").show();
    return;
}
//记录条数增加
function IncTableRowCount()
{
    var tc = $("#tableRowCount");
    tc.html(parseInt(tc.html()) + 1);
}
//记录条数减少
function DecTableRowCount()
{
    var tc = $("#tableRowCount");
    tc.html(parseInt(tc.html()) - 1);
}
//增加一行
function addRowInTable(id, locationname, uuid,major,minor)
{
    //新增加一行
    var appendstr = "<tr>";
    appendstr += "<td>" + id + "</td>";
    appendstr += "<td>" + locationname + "</td>";
    appendstr += "<td>" + uuid + "</td>";
    appendstr += "<td>" + major + "</td>";
    appendstr += "<td>" + minor + "</td>";
    appendstr += "<td><input type=\"button\" value=\"Edit\" onclick=\"editFun(id);\" />";
    appendstr += "<input type=\"button\" value=\"Delete\" onclick=\"deleteFun(id)\" /></td>";
    appendstr += "</tr>";
    $("#Table").append(appendstr);
    IncTableRowCount();
}
//修改某一行
function updataRowInTable(id, locationname, uuid,major,minor)
{
    var i = SearchIdInTable($("#Table tr"), id);
    if (i != -1)
    {
        $("#Table tr:eq(" + i + ") td:eq(1)").html(locationname != "" ? locationname : " ");
        $("#Table tr:eq(" + i + ") td:eq(2)").html(uuid != "" ? uuid : " ");
        $("#Table tr:eq(" + i + ") td:eq(3)").html(major != "" ? major : " ");
        $("#Table tr:eq(" + i + ") td:eq(4)").html(minor != "" ? minor : " ");
        $("#editdiv").hide();
    }
}
//删除某一行
function deleteRowInTable(id)
{
    var i = SearchIdInTable($("#Table tr"), id);
    if (i != -1)
    {
        //删除表格中该行
        $("#Table tr:eq(" + i + ")").remove();
        SetTableRowColor();
        DecTableRowCount();
    }
}
//增加删除修改数据库函数 通过AJAX与服务器通信
function insertFun()
{
    var locationname = $("#adddiv_locationname").val();
    var uuid = $("#adddiv_uuid").val();
    var major = $("#adddiv_major").val();
    var minor = $("#adddiv_minor").val();

    if (locationname == "" || uuid == "" || major == "" || minor == "")
    {
        alert("信息不完整!");
        return ;
    }
    if (!checkuuid(uuid))
    {
        alert("uuid的格式不正确");
        return ;
    }
    //submit to server 返回插入数据的id
    $.post("myinsert.php", {locationname:locationname, uuid:uuid,major:major,minor:minor}, function(data){
        
        if (data == "f")
        {
            alert("Insert date failed");
        }
        else
        {
            addRowInTable(data, locationname, uuid,major,minor);
            SetTableRowColor();
            $("#adddiv").hide();
        }
    });
}
function deleteFun(id)
{
    if (confirm(id+" 确认删除?"))
    {
        //submit to server
        $.post("mydelete.php", {id:id}, function(data){
            if (data == "f")
            {
                alert("delete date failed");
            }
            else
            {
                deleteRowInTable(id);
            }
        });
    }
}
function updateFun()
{
    var id = $("#editdiv_id").val();
    var locationname = $("#editdiv_locationname").val();
    var uuid = $("#editdiv_uuid").val();
    var major = $("#editdiv_major").val();
    var minor = $("#editdiv_minor").val();
    if (locationname == "" || uuid == "" || major == "" || minor == "")
    {
        alert("信息不完整!");
        return ;
    }
    if (!checkuuid(uuid))
    {
        alert("uuid的格式不正确");
        return ;
    }
    //submit to server
    $.post("myupdate.php", {id:id, locationname:locationname, uuid:uuid,major:major,minor:minor}, function(data){
        if (data == "f")
        {
            alert("Updata date failed");
        }
        else
        {
            updataRowInTable(id,  locationname, uuid,major,minor);
        }
    });
}

$(document).ready(function()
{
    SetTableRowColor();
    UpdataTableRowCount();
});