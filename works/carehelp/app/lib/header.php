<?php
//session_start();

include_once ($_SERVER["DOCUMENT_ROOT"]."/_inc/inc_fn.php"); 
include_once ($_SERVER["DOCUMENT_ROOT"]."/_inc/inc_ss.php");
//if(!isset($_SESSION['grade']) && $page != 'join') {
//서비스 시 아래 주석 풀어야 됨
//회원가입 페이지는 아래 내용이 해당사항 없도록 해야됨
/*if (!ss_isUserLogOn() && $page!='join'){
	//세션 종료시 로그인 페이지로
    echo "<meta http-equiv='refresh' content='0;url=/login.php'>";
	exit;
}*/
$ver = '1.0';
$grade = isset($_SESSION['grade'])? $_SESSION['grade']:$_POST['grade'];
//echo $user_no;
if($page!='join' && !ss_isUserLogOn()){
	if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
		echo "<meta http-equiv='refresh' content='0;url=/app/app.login.php'>";
		exit;		
	}
	else{
		echo "<meta http-equiv='refresh' content='0;url=/app/login.php'>";
		exit;
	}
}
//PhpLog1($_SESSION);
header("Cache-Control: no-cache");//안드로이드에서 뒤로가기시 net::ERR_CACHE_MISS 페이지 오류가 남 처리
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
	<meta name="format-detection" content="telephone=no" />
<?}else{?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?}?>
    <meta http-equiv="Cache-Control" content="no-cache">
	<link rel="shortcut icon" href="/img/pavi.ico">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/app/css/reset.css?v=<?=time()?>">
    <link rel="stylesheet" href="/app/css/style.css?v=<?=time()?>">
    <title>간병비 비교견적 서비스 간병나이팅게일</title>
	<meta name="keywords" content="간병나이팅게일, 간병나이팅게일 앱, 간병나이팅게일 APP, 나이팅게일 간병, 간병사 관리 앱, 간병사 관리, 간병사, 간병협회, 간병인 관리, 간병인협회, 간병인, 간병인 구인">
	<meta name="description" content="간병나이팅게일은 보호자와 간병인, 협회간의 간병인 구인 구직을 할 수 있는 간병통합플랫폼입니다.">
	<meta property="og:type" content="website">
	<meta property="og:title" content="간병나이팅게일">
	<meta property="og:image" content="/img/carehelper_meta_img.png">
	<meta property="og:description" content="간병나이팅게일은 보호자와 간병인, 협회간의 간병인 구인 구직을 할 수 있는 간병 통합플랫폼입니다.">
	<meta property="og:url" content="https://www.carehelper.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="m-iTzcVlbabaM8FTT5Svq_7e4GhJQ5WTuElEvgscfGg" />
	<meta name="naver-site-verification" content="354c9a67fbf97b9e1ad5add40ef173d01c2a52c6" />
	<link rel="shortcut icon" href="/img/pavi.ico">
	
</head>
<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {?>
<body oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
<?}else{?>
<body>
<?}?>
    <div id="wrap">