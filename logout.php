<?php
/**
 * Created by PhpStorm.
 * User: jimiao
 * Date: 2015/11/02
 * Time: 15:51
 */

session_start();
$_SESSION["admin"] = null;
header("location:login.html");
?>