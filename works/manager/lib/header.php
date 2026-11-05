<?php

if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
	include_once ($_SERVER['DOCUMENT_ROOT']."/portfolio/works/manager/_inc/inc_fn.php");
	//session_start();
	include_once ($_SERVER['DOCUMENT_ROOT']."/portfolio/works/manager/_inc/inc_ss.php");
	header("Cache-Control: no-cache");
	if (!ss_isUserLogOn())
	{
		//echo "<meta http-equiv='refresh' content='0;url=/login.php'>";
		//exit;
		
	}
	else{
		PhpLog1($_SESSION);
	}
}
else if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	$href=basename($_SERVER["PHP_SELF"]);
	if(strpos($href, "app.php") !== false || strpos($href, "expert-list.php") !== false || strpos($href, "qna-list.php") !== false) {
		//unset($_COOKIE['back_url']);
		setcookie("back_url1", $href, time()+3600);
		//echo "aaa";
	}
	include_once ($_SERVER['DOCUMENT_ROOT']."/portfolio/works/manager/_inc/inc_fn.php");
	include_once ($_SERVER['DOCUMENT_ROOT']."/portfolio/works/manager/_inc/inc_ss.php");
	header("Cache-Control: no-cache");
	if (!ss_isUserLogOn())
	{
		//echo "<meta http-equiv='refresh' content='0;url=/login.php'>";
		//exit;
		
	}
	else{
		PhpLog1($_SESSION);
	}
	if(strpos($href, "card-pre.php") !== false){
		PhpLog1($_SESSION);
	}
	
}
else{
	include_once ($_SERVER['DOCUMENT_ROOT']."/portfolio/works/manager/_inc/inc_fn.php");
	session_start();
	
}

$curr_page=basename($_SERVER["PHP_SELF"]);
if(strpos($curr_page, "estimate.php") !== false){
	//echo $_SERVER['HTTP_REFERER'];
	$back_url1 = $_SERVER['HTTP_REFERER'];
	setcookie("old_url1", $back_url1, time()+36000);
	//echo $_COOKIE["old_url1"];
	
}
/* if(!isset($_SESSION['lv'])) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/login.php'>";
	exit;
} */
 

$user_no = isset($_SESSION['no']) ? $_SESSION['no'] : 0;
$lv = isset($_SESSION['lv']) ? $_SESSION['lv'] : 0;

?>
<!DOCTYPE html>
<html lang="ko">

<head>
	<meta http-equiv="Cache-Control" content="no-cache">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

    <!-- plugin css -->
    <link href="/portfolio/works/manager/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/portfolio/works/manager/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/portfolio/works/manager/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/portfolio/works/manager/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/portfolio/works/manager/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


    <!-- style-->
    <link rel="stylesheet" href="/portfolio/works/manager/css/reset.css">
    <link rel="stylesheet" href="/portfolio/works/manager/css/style.css?ver=1">
	<link rel="shortcut icon" href="/portfolio/works/manager/img/money.ico">


    <title>비즈니스 전문가 매칭 플랫폼</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');

    * {
        font-family: 'Noto Sans KR', sans-serif;
        box-sizing: border-box;
    }
</style>
<html id="html">
	<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {?>
	<body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
	<?}else{?>
	<body>
	<?}?>
		<div id="wrap">