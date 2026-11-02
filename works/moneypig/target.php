<!DOCTYPE html>
<html lang="ko">

<?php
include('common.php');

$param = null;

$cate_list = $pdo->query("SELECT * FROM code_info WHERE majr = 9 AND minr != 0 AND use_yn = 1", $param);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="돈돼지, 내돈내산, 리뷰쓰면 돈돼지, 리뷰100%, 리뷰이벤트, 먹튀제로, 동네광고, 가게홍보, 캐시적립, 짠테크, 앱테크, 재테크">
	<meta name="description" content="우리 동네 가게 이용하고 리뷰쓰면 가게 사장님이 용돈을 드립니다. 다양한 곳에서 내돈내산 혜택 가득~ 매일매일 돈 쓸 맛 나는 앱테크 돈돼지! 우리 동네 가게 홍보도 하고 리뷰도 받자! 기자단, 체험단 필요없는 실속있는 홍보방법! 꿀돼지같은 우리 가게 파트너 돈돼지!">
	<meta property="og:type" content="website">
	<meta property="og:title" content="내돈내산 리뷰쓰면 돈돼지">
	<meta property="og:image" content="/img/moneypig_meta_guide.png">
	<meta property="og:description" content="내돈내산 리뷰쓰면 돈돼지입니다">
	<meta property="og:url" content="https://moneypig.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="eXLmcYdidByhd62Jv7bpHnUjMmBJhp70BDC9CgIrHLo" />
	<meta name="naver-site-verification" content="ca313ff7297cfd1c8d9f558a9bc18bfd96d09b3b" />
	<link rel="shortcut icon" href="/img/money.ico">

    <!-- plugin css -->
    <link href="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- style-->
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">


	<title>내돈내산 리뷰쓰면 돈되지</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
	@import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css'); 
	@import url('https://webfontworld.github.io/SCoreDream/SCoreDream.css');﻿


    * {
        font-family: 'SCoreDream', sans-serif;
        box-sizing: border-box;
    }

	.dream{
        font-family: 'SCoreDream';
	}



	#header {
		position: relative;
		background: #fff;
		padding: 15px 0;
		text-align: center; 
	}

	#header svg {
		position: absolute;
		width: 20px;
		left: 15px;
		top: 50%; transform: translateY(-50%);
	}

	img {
		width: 100%;
	}


	.box {
		text-align: center;
		padding: 20px 50px;
	}
	.box strong.title {
		display: block;
		font-family: 'SCoreDream';
		font-size: 24px;
		font-weight: 300;
		color: #fff;
		letter-spacing: -2px;
		background: #F9742F;
		border-radius: 40px;
	}

	.box img {
		margin: 20px 0;
	}
	.box p {
		font-family: 'SCoreDream';
		font-size: 18px;
		font-weight: 400;
		line-height: 1.618;
		margin-bottom: 15px;
	}

	.box ul {
		width: 100%;
		margin: 0 auto;
		margin-top: 20px;
	}
	.box ul li {
		display: flex;
		justify-content: start;
		align-items: center;
		text-align: left;
		margin: 5px 0;
		border-radius: 10px;
		border: solid 2px #F9742F;
		padding: 15px;
	}
	.box ul li strong {
		font-size: 30px;
		font-weight: 900;
		font-family: 'SCoreDream';
		color: #F9742F;
	}
	.box ul li p {
		font-size: 18px;
		font-weight: 300;
		margin-left: 15px;
		margin-bottom:0;
	}

	.box > div {
		margin: 20px 0;
	}
	.box > div > div {
		display: flex;
		justify-content: start;
		align-items: center;
		text-align: left;
	}
	.box > div > div strong {
		font-size: 30px;
		font-weight: 900;
		font-family: 'SCoreDream';
		color: #F9742F;
	}
	.box > div > div p {
		font-size: 18px;
		font-weight: 500;
		margin-left: 15px;
		margin-bottom:0;
	}

</style>
<html id="html">
	<body>
		<div id="header">
			<a onclick="window.close();">
			<svg xmlns="http://www.w3.org/2000/svg" width="68.5" height="42.307" viewBox="0 0 68.5 42.307">
			  <g id="그룹_506" data-name="그룹 506" transform="translate(6821.5 4382.742)">
				<path id="패스_248" data-name="패스 248" d="M-6801.435-4344.87l-16.911-16.911,16.911-16.911" transform="translate(-0.154 0.192)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="6"/>
				<line id="선_55" data-name="선 55" x2="62.5" transform="translate(-6818.5 -4361.617)" fill="none" stroke="#000" stroke-linecap="round" stroke-width="6"/>
			  </g>
			</svg>
			</a>
			<p style="font-size: 16px; font-weight: 500; display: inline-block;">상세페이지</p>
		</div>
		<div class="title">
			<img src="/img/manager/target1.png">
		</div>
		<div>
			<div class="box">
				<strong class="title">동네문자란 무엇인가요?</strong>
				<img src="/img/manager/target2.png">
				<p>우리동네 고객들에게 푸시로 소식을</br>전달하는 서비스 입니다</p>
			</div>
			<div class="box">
				<strong class="title" style="background: #B43300;">동네문자의 장점은 무엇인가요?</strong>
				<ul>
					<li>
						<strong>1</strong>
						<p>
						전단지나 홍보물을 만들지 않아도
						내 매장 소식을 간편하게 전달할 수 있습니다.
						</p>
					</li>
					<li style="border-color: #B43300;">
						<strong style="color: #B43300;">2</strong>
						<p>
						내 매장을 이용한 고객에게 CRM 분석을 통해
						홍보할 수 있습니다.
						</p>
					</li>
					<li>
						<strong>3</strong>
						<p>
						내 고객외에 앱을 다운로드 받은 3KM 이내
						모든 고객에게 홍보할 수 있습니다.
						</p>
					</li>
				</ul>
			</div>
			<div class="box">
				<strong class="title">동네문자는 어떻게 보내나요?</strong>
				<div>
					<img src="/img/manager/target3.png">
					<div>
						<strong>1</strong>
						<p>동네문자 → 등록하기를 선택하세요.</p>
					</div>
				</div>
				<div>
					<img src="/img/manager/target4.png" style="width: 45%;">
					<div>
						<strong style="color: #B43300;">2</strong>
						<p>제목, 내용, 사진을 첨부하여 수신할 고객을 선택하세요.</p>
					</div>
				</div>
				<div>
					<img src="/img/manager/target5.png">
					<div>
						<strong>3</strong>
						<p>동네 반경을 선택하면 내 고객과 내 주변 고객을 카운트 할 수 있습니다.</p>
					</div>
				</div>
				<div>
					<img src="/img/manager/target6.png">
					<div>
						<strong style="color: #B43300;">4</strong>
						<p>발송하기 버튼을 누르면 푸시 문자가 전송됩니다.</p>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>
<!-- Initialize Swiper -->
<script>


</script>

</html>