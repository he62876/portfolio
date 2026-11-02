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
        font-family: 'Noto Sans KR', sans-serif;
        box-sizing: border-box;
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
		padding: 20px 50px;
	}
	.box strong {
		position: relative;
		font-family: 'NanumSquare', sans-serif;
		font-size: 28px;
		font-weight: 900;
		color: #746DD4;
		letter-spacing: -2px;
	}
	.box strong::after {
		content: '';
		display: block;
		position: absolute;
		width: 100%;
		height: 10px;
		background: #FFDF9F;
		left: 0;
		top: 18px;
		z-index: -1;
	}
	.box strong.long::after {
		width: 140%;
	}
	.box strong.short::after {
		width: 70%;
	}

	.box img {
		margin: 20px 0;
	}
	.box p {
		font-size: 18px;
		font-weight: 400;
		line-height: 1.618;
		margin-bottom: 15px;
	}
	.box.number p {
		padding-left: 11px; text-indent: -11px;
	}
	.box.number p::before {
		content: "●";
		color: #746DD4;
		font-size: 8px;
		vertical-align: middle;
		margin-right: 5px;
	}
	.box.number p.not_number {
		padding-left: 0;
		text-indent: 0;
	}
	.box.number p.not_number::before {
		display: none;
	}

	a.button {
		display: block;
		text-align: center;
		width: 100%;
		margin: 0 auto;
		margin-top: 20px;
		padding: 15px 0;
		background: #FAE100;
		color: #000;
		font-size: 24px;
		font-weight: 500;
	}
	a:hover {
		color: #000;
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
			<img src="/img/manager/title.png">
		</div>
		<div>
			<div class="box">
				<strong>매니저는 무엇인가요?</strong>
				<img src="/img/manager/1.png">
				<p>N 잡러를 말합니다.</p>
				<p>즉, 개인이 가지고 있는 지식과 경험을 통해 우리동네 소상공인들에게 마케팅과 브랜딩을 기여할 수 있는 프리랜서를 말합니다.</p>
			</div>
			<div class="box number">
				<strong>어떤 일을 하나요?</strong>
				<img src="/img/manager/2.png">
				<p class="not_number">플랫폼이 제공하는 시스템 툴을 무료로 제공받아 본인이 유치한 사업장을 관리하시면 됩니다. </p>
				<p>우리동네 사업장 중에 영수증 이벤트를 하고 있거나, 홍보가 필요한 다양한 업종을 앱에 가입시키면 됩니다.</p>
				<p>마케터라면 체험단 모집도 시스템을 통해 필요한 사업장에 안내 및 관리할 수 있습니다.</p>
			</div>
			<div class="box number">
				<strong>매니저로 가입하면</br>어떤 혜택이 있나요? </strong>
				<img src="/img/manager/3.png">
				<p class="not_number">시스템이 제공하는 모든 기능을 이해한 후, 본인이 알고 있는 사업장을 가입시키면 고정 수익이 발생합니다.</p>
				<p>지정된 월 관리비 (사업장 유료 전환 시 지속 제공)</p>
				<p>체험단 유치 시 지정된 수수료 제공</p>
			</div>
			<div class="box number">
				<strong class="long">매니저 가입 조건은</br>어떻게 되나요? </strong>
				<img src="/img/manager/4.png">
				<p>본인의 전공 또는 관심분야의 직무를 살려  부수적인 경제 활동이 가능한 분</p>
				<p>현재와 미래에 대한 걱정을 덜고 보다 윤택한 삶을 위한 본인을 브랜딩 하여 수익화를 할 수 있는 분</p>
				<p>소상공인의 브랜드나 사업장에 프로포즈 가능한 분</p>
				<p>고객과 소상공인에게 이익을 연결할 수 있는 자</p>
			</div>
			<div class="box number">
				<strong>어떤 활동을 주로 해야 하나요?</strong>
				<img src="/img/manager/5.png">
				<p>사업자가 요청하는 미션 외 사회적, 문화적, 경제적 필요화 욕구를 충족시킬 수 잇는 윤리적 서비스를 지원해야 합니다.</p>
				<p>기타 활동에 필요한 상세한 내용은 리뷰쓰면 돈되지 플러스 친구를 통해 문의하시면 됩니다.</p>
			</div>
		</div>
		<a class="button" href="/admin/join.php?code=N7TMDS">매니저 가입하기</a>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>
<!-- Initialize Swiper -->
<script>


</script>

</html>