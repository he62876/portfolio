<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- plugin css -->
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    
    <!-- style-->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">


    <title>간병통합관리시스템 간병나이팅게일</title>
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
<html id="html">
<body>
	<header>
		<a href="/portfolio/works/carehelp"><img src="/portfolio/works/carehelp/web/img/logo<?=$page != 'cs' ? 1:2?>.svg"></a>
		<ul>
			<li><a href="/portfolio/works/carehelp" <?=$page == 'index' ? "style='background: #3478F6; color: #fff;'":""?>>앱안내</a></li>
			<!--<li><a href="cs.php" <?=$page == 'cs' ? "style='background: #7752FD; color: #fff;'":""?>>협회용</a></li>-->
			<li><a href="news.php" <?=$page == 'news' ? "style='background: #000; color: #fff;'":""?>> 소식</a></li>
			<li><a href="faq.php" <?=$page == 'faq' ? "style='background: #000; color: #fff;'":""?>>자주묻는질문</a></li>
		</ul>
		<button onclick="document.all.mobile_menu.style.display = 'block'; document.all.html.style.overflow = 'hidden';"><img src="/portfolio/works/carehelp/web/img/ham<?=$page != 'cs' ? 1:2?>.png"></button>
	</header>
	<div class="menubar">
		<a href="http://pf.kakao.com/_ugxoKG/chat">
			<img src="/portfolio/works/carehelp/web/img/kakao.png">
			<p style="margin-bottom: 20px;">카카오문의</p>
		</a>
	</div>
	<div id="mobile_menu">
		<div class="mobile_menu_header">
			<img src="/portfolio/works/carehelp/web/img/logo3.svg">
			<button onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';"><img src="/portfolio/works/carehelp/web/img/close.png"></button>
		</div>
		<ul>
			<li <?=$page == 'index' ? "style='background: #3478F6;'":""?>><a href="/portfolio/works/carehelp">앱안내</a></li>
			<!--<li <?=$page == 'cs' ? "style='background: #7752FD;'":""?>><a href="cs.php">협회용</a></li>-->
			<li <?=$page == 'news' ? "style='background: #000;'":""?>><a href="news.php">소식</a></li>
			<li <?=$page == 'faq' ? "style='background: #000;'":""?>><a href="faq.php">자주묻는질문</a></li>
		</ul>
	</div>