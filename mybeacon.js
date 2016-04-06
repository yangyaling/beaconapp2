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
function updateStatusInTable(userid, num,status2)
{
    var i = SearchIdInTable($("#Table tr"), userid);
    var myDate = new Date();
    document.getElementById("updatetime").innerHTML ='※更新時間：'+myDate.toLocaleString();
    if (i != -1)
    {
        if(num >0){
            if(status2=='1'){
                var inhtm ="<strong>在席[busy]</strong>";//"<img src='open.png'>";
            }else{
                var inhtm ="<strong>在席</strong>";//"<img src='open.png'>";
            }

            $("#Table tr:eq(" + i + ") td:eq(2)").html(inhtm);

        }else{
            var inhtm ="<strong>不在</strong>";//"<img src='close.png'>";
            $("#Table tr:eq(" + i + ") td:eq(2)").html(inhtm);

        }

    }
}

function updateRowInTable(username, locationname,status,comment)
{
    var i = SearchIdInTable($("#Table tr"), username);
    var myDate = new Date();
    document.getElementById("updatetime").innerHTML =myDate.toLocaleString();
    if (i != -1)
    {
        var pth=document.getElementById("Table").getElementsByTagName("th");

        var irow;
        for (irow=2;irow<pth.length+1;irow++) {
            var strtitle = pth[irow - 1].innerHTML;
            var strvalue;
            if (status == "1") {
                if (comment != "") {
                    strvalue = "○[" + comment + "]";
                } else {
                    strvalue = "○";
                }

            } else {
                strvalue = "○";
            }

            $("#Table tr:eq(" + i + ") td:eq("+(irow -1)+")").html(strtitle.trim() == locationname.trim() ? strvalue : "");
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
    $("#editdiv_roomid").val($("#Table tr:eq(" + i + ") td:eq(5)").html());
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
function addRowInTable(id, locationname, uuid,major,minor,roomid)
{
    //新增加一行
    var appendstr = "<tr>";
    appendstr += "<td>" + id + "</td>";
    appendstr += "<td>" + locationname + "</td>";
    appendstr += "<td>" + uuid + "</td>";
    appendstr += "<td>" + major + "</td>";
    appendstr += "<td>" + minor + "</td>";
    appendstr += "<td>" + roomid + "</td>";
    appendstr += "<td><input type=\"button\" value=\"Edit\" onclick=\"editFun(id);\" />";
    appendstr += "<input type=\"button\" value=\"Delete\" onclick=\"deleteFun(id)\" /></td>";
    appendstr += "</tr>";
    $("#Table").append(appendstr);
    IncTableRowCount();
}
//修改某一行
function updataRowInTable(id, locationname, uuid,major,minor,roomid)
{
    var i = SearchIdInTable($("#Table tr"), id);
    if (i != -1)
    {
        $("#Table tr:eq(" + i + ") td:eq(1)").html(locationname != "" ? locationname : " ");
        $("#Table tr:eq(" + i + ") td:eq(2)").html(uuid != "" ? uuid : " ");
        $("#Table tr:eq(" + i + ") td:eq(3)").html(major != "" ? major : " ");
        $("#Table tr:eq(" + i + ") td:eq(4)").html(minor != "" ? minor : " ");
        $("#Table tr:eq(" + i + ") td:eq(5)").html(roomid != "" ? roomid : " ");
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
    var roomid = $("#adddiv_roomid").val();
    if (locationname == "" || uuid == "" || major == "" || minor == "" || roomid == "")
    {
        alert("入力不正");
        return ;
    }
    if (!checkuuid(uuid))
    {
        alert("uuidが不正");
        return ;
    }
    //submit to server 返回插入数据的id
    $.post("myinsert.php", {locationname:locationname, uuid:uuid,major:major,minor:minor,roomid:roomid}, function(data){

        if (data == "f")
        {
            alert("Insert data failed");
        }
        else
        {
            addRowInTable(data, locationname, uuid,major,minor,roomid);
            SetTableRowColor();
            $("#adddiv").hide();
        }
    });
}
function deleteFun(id)
{
    if (confirm(id+" を削除しますか?"))
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
    var roomid = $("#editdiv_roomid").val();
    if (locationname == "" || uuid == "" || major == "" || minor == "" || roomid == "")
    {
        alert("入力不正!");
        return ;
    }
    if (!checkuuid(uuid))
    {
        alert("uuidが不正");
        return ;
    }
    //submit to server
    $.post("myupdate.php", {id:id, locationname:locationname, uuid:uuid,major:major,minor:minor,roomid:roomid}, function(data){
        if (data == "f")
        {
            alert("Updata date failed");
        }
        else
        {
            updataRowInTable(id,  locationname, uuid,major,minor,roomid);
        }
    });
}






//room edit

//响应edit按钮
function editFunRoom(id)
{
    var i = SearchIdInTable($("#Table tr"), id);
    $("#editdiv").show();
    $("#adddiv").hide();
    $("#editdiv_id").val(id);
    $("#editdiv_roomid").val($("#Table tr:eq(" + i + ") td:eq(1)").html());
    $("#editdiv_roomname").val($("#Table tr:eq(" + i + ") td:eq(2)").html());
    $("#editdiv_visible").val($("#Table tr:eq(" + i + ") td:eq(3)").html());

}

//响应edit按钮
function editFunUser(id)
{
    var i = SearchIdInTable($("#Table tr"), id);
    $("#editdiv").show();
    $("#editdiv_id").val(id);
    $("#editdiv_userid").val($("#Table tr:eq(" + i + ") td:eq(1)").html());
    $("#editdiv_username").val($("#Table tr:eq(" + i + ") td:eq(2)").html());
    $("#editdiv_visible").val($("#Table tr:eq(" + i + ") td:eq(3)").html());
    $("#editdiv_listindex").val($("#Table tr:eq(" + i + ") td:eq(4)").html());
}
//响应add按钮
function addFunRoom()
{
    $("#editdiv").hide();
    $("#adddiv").show();
    return;
}
//记录条数增加
function IncTableRowCountRoom()
{
    var tc = $("#tableRowCount");
    tc.html(parseInt(tc.html()) + 1);
}
//记录条数减少
function DecTableRowCountRoom()
{
    var tc = $("#tableRowCount");
    tc.html(parseInt(tc.html()) - 1);
}
//增加一行
function addRowInTableRoom(id, roomid, roomname,visible)
{
    //新增加一行
    var appendstr = "<tr>";
    appendstr += "<td>" + id + "</td>";
    appendstr += "<td>" + roomid + "</td>";
    appendstr += "<td>" + roomname + "</td>";
    appendstr += "<td>" + visible + "</td>";

    //appendstr += "<td>" + visible + "</td>";
    appendstr += "<td><input type=\"button\" value=\"Edit\" onclick=\"editFunRoom(id);\" />";
    appendstr += "<input type=\"button\" value=\"Delete\" onclick=\"deleteFunRoom(id)\" /></td>";
    appendstr += "</tr>";
    $("#Table").append(appendstr);
    IncTableRowCount();
}
//修改某一行
function updataRowInTableRoom(id, roomid, roomname,visible)
{
    var i = SearchIdInTable($("#Table tr"), id);
    if (i != -1)
    {
        $("#Table tr:eq(" + i + ") td:eq(1)").html(roomid != "" ? roomid : " ");
        $("#Table tr:eq(" + i + ") td:eq(2)").html(roomname != "" ? roomname : " ");
        $("#Table tr:eq(" + i + ") td:eq(3)").html(visible != "" ? visible : " ");

        //$("#Table tr:eq(" + i + ") td:eq(3)").html(visible != "" ? visible : " ");
        $("#editdiv").hide();
    }
}

//修改某一行
function updataRowInTableUser(id, userid, username,visible,listindex)
{
    var i = SearchIdInTable($("#Table tr"), id);
    if (i != -1)
    {
        //$("#Table tr:eq(" + i + ") td:eq(1)").html(roomid != "" ? roomid : " ");
        $("#Table tr:eq(" + i + ") td:eq(2)").html(username != "" ? username : " ");
        $("#Table tr:eq(" + i + ") td:eq(3)").html(visible != "" ? visible : " ");
        $("#Table tr:eq(" + i + ") td:eq(4)").html(listindex != "" ? listindex : " ");
        //$("#Table tr:eq(" + i + ") td:eq(3)").html(visible != "" ? visible : " ");
        $("#editdiv").hide();
    }
}
//删除某一行
function deleteRowInTableRoom(id)
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
function insertFunRoom()
{
    var roomid = $("#adddiv_roomid").val();
    var roomname = $("#adddiv_roomname").val();
    var visible = $("#adddiv_visible").val();


    if (roomid == "" || roomname == ""  || visible == "")
    {
        alert("入力不正!");
        return ;
    }

    //submit to server 返回插入数据的id
    $.post("myinsertroom.php", {roomid:roomid, roomname:roomname,visible:visible}, function(data){

        if (data == "f")
        {
            alert("Insert data failed");
        }
        else
        {
            addRowInTableRoom(data, roomid, roomname,visible);
            SetTableRowColor();
            $("#adddiv").hide();
        }
    });
}
function deleteFunRoom(id)
{
    if (confirm(id+" を削除しますか?"))
    {
        //submit to server
        $.post("mydeleteroom.php", {id:id}, function(data){
            if (data == "f")
            {
                alert("delete date failed");
            }
            else
            {
                deleteRowInTableRoom(id);
            }
        });
    }
}

function deleteFunUser(id)
{
    if (confirm(id+" を削除しますか?"))
    {
        //submit to server
        $.post("mydeleteuser.php", {id:id}, function(data){
            if (data == "f")
            {
                alert("delete date failed");
            }
            else
            {
                deleteRowInTableRoom(id);
            }
        });
    }
}
function updateFunRoom()
{
    var id = $("#editdiv_id").val();
    var roomid = $("#editdiv_roomid").val();
    var roomname = $("#editdiv_roomname").val();
    var visible = $("#editdiv_visible").val();

    if (roomid == "" || roomname == "" || visible == "")
    {
        alert("入力不正!");
        return ;
    }
    //submit to server
    $.post("myupdateroom.php", {id:id, roomid:roomid, roomname:roomname,visible:visible}, function(data){
        if (data == "f")
        {
            alert("Updata date failed");
        }
        else
        {
            updataRowInTableRoom(id,  roomid, roomname,visible);
        }
    });
}

function updateFunUser()
{
    var id = $("#editdiv_id").val();
    var userid = $("#editdiv_userid").val();
    var username = $("#editdiv_username").val();
    var visible = $("#editdiv_visible").val();
    var listindex = $("#editdiv_listindex").val();

    if (isNaN(visible) || isNaN(listindex) )
    {
        alert("入力不正!");
        return ;
    }
    //submit to server
    $.post("myupdateuser.php", {id:id, userid:userid, username:username,visible:visible,listindex:listindex}, function(data){
        if (data == "f")
        {
            alert("Updata date failed");
        }
        else
        {
            updataRowInTableUser(id,  userid, username,visible,listindex);
        }
    });
}

$(document).ready(function()
{
    SetTableRowColor();
    UpdataTableRowCount();
});