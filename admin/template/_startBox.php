<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
include 'config.php';
include('../functions/functions.php');
checkLogin(1);//2, 3, 4 ...visszautitva
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/admin.css" />
<title>Hegyaljafestival.hu Adminisztráció - </title>
</head>

<body>
<div id="container">