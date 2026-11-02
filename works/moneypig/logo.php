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
	@import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css'); ﻿


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

	#body {
		padding: 50px 0 30px 50px;
	}

	#body p {
		color: #fff;
		margin: 30px 0 200px 0;
	}

	#info {
		text-align: center; 
		padding: 30px 0;
	}

	#info ul {
		width: 90%;
		margin: 0 auto;
		margin-top: 20px;
	}
	#info ul li {
		display: flex;
		justify-content: start;
		text-align: left;
		margin: 5px 0;
		background: #FAE100;
		border-radius: 10px;
		padding: 15px;
	}
	#info ul li p {
		margin-left: 10px;
	}

	#info > div {
		width: 90%;
		margin: 20px auto;
		padding: 20px;
		text-align: left;
		background: #F8F8F8;
		border-radius: 10px;
	}
	#info > div p {
		margin: 10px 0;
		padding-left: 14px; text-indent: -14px;
	}
	#info > div p::before {
		content: '';
		display: inline-block;
		vertical-align: middle;
		margin-right: 7px;
		width:7px; height: 7px;
		background: #FAE100;
		border-radius: 100%;
	}

	#form {
		text-align: center; 
		padding: 30px 0;
		background: #3F3A5A;
	}

	#form .input {
		width: 90%;
		text-align: left;
		margin: 5px auto;
	}
	#form .input label {
		display: block;
		margin-bottom: 5px;
		color: #fff;
		font-size: 15px;
		font-weight: 500;
	}
	#form .input input {
		width: 100%;
		padding: 10px;
		border-radius: 5px;
	}

	#form .radio {
		width: 90%;
		position: relative;
		text-align: left;
		margin: 0 auto;
		padding: 20px;
		border-radius: 20px;
		background: rgba(255,255,255,0.15);
	}
	#form .radio input,
	#form input[type="checkbox"] {
		display: none;
	}
	#form .radio input + label {
		position: relative;
		display: block;
		margin-left: 30px;
	}
	#form .radio input + label p {
		color: #fff;
		font-size: 15px;
		font-weight: 500;
	}
	#form .radio input + label::before {
		content: '';
		position: absolute;
		left: -30px; top: 50%; transform: translateY(-50%);
		background: url('/img/radio_off.svg');
		background-size: cover;
		width: 18px; height: 18px;
	}
	#form .radio input:checked + label::before {
		background: url('/img/radio_on.svg');
		background-size: cover;
	}

	#form select {
		width: 100%;
		height: 40px;
		padding: 5px;
	}

	#form input[type="checkbox"] + label {
		position: relative;
		color: #fff;
		font-size: 15px;
		font-weight: 500;
	}
	#form input[type="checkbox"] + label::before {
		content: '';
		display: inline-block;
		vertical-align: middle;
		background: url('/admin/img/check_off.svg');
		background-size: cover;
		width: 18px; height: 18px;
		margin-right: 10px;
	}
	#form input[type="checkbox"]:checked + label::before {
		background: url('/admin/img/check_on.svg');
		background-size: cover;
	}

	#form a {
		color: #fff;
		font-weight: bold;
		text-decoration: underline;
	}

	#form button {
		font-size: 18px;
		font-weight: bold;
		width: 150px;
		border-radius: 10px;
		padding: 10px 0;
		background: #FAE100;
		text-align: center;
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
		<div id="body" style="background: url('/img/logo_bg.png'); background-size: cover;">
			<img src="/img/logosong.svg" style="width: 80%;">
			<p>
			이제 소비자의 눈과 귀를 함께 두드려 보세요~</br>
			<span style="color:#FAE100; font-weight: bold;">15초~20초 영상</span>을 만들어</br>유튜브, 인스타, 네이버플레이스에</br>
			노출시켜드립니다.
			</p>
			<img src="/img/tiktok.png" style="width: 50%;">
		</div>
		<div id="info">
			<img src="/img/info.svg" style="width: 80%;">
			<ul>
				<li>
					<img src="/img/num1.svg" style="width: 5%;">
					<p>
					글과 사진보다는 유튜브, 인스타, 네이버플레이스를 
					통해 입체적인 인사이트가 필요해요
					</p>
				</li>
				<li style="background:#3F3A5A;">
					<img src="/img/num2.svg" style="width: 5%;">
					<p style="color: #fff;">
					소비자의 눈과 귀를 열어 마케팅의 문제를 보다 
					정확하게 구조화할 수 있어요
					</p>
				</li>
				<li>
					<img src="/img/num3.svg" style="width: 5%;">
					<p>
					플랫폼의 여러 서비스와 협업을 통해 자연스러운 
					구매 전환을 높일 수 있어요
					</p>
				</li>
			</ul>
			<img src="/img/info2.svg" style="width: 35%; margin-top: 40px;">
			<div>
				<img src="/img/info3.svg" style="width: 40%;">
				<p>숏폼영상(쇼츠,릴스,틱톡)에 최적화된 세로 영상을 만듭니다.</p>
				<p>1회 수정을 제공합니다. (자막 외 더빙 및 애니메이션 변경 불가)</p>
				<p>제공 받은 자료에 저작권 위반이 있을 경우 책임은 제공자에게 있습니다.</p>
			</div>
			<div>
				<img src="/img/info4.svg" style="width: 40%;">
				<p>발주 전 상호 협의하에 계약 철회 및 환불이 가능합니다.</p>
				<p>착수 이후 철회 시 총 결제 금액의 최대 30%까지 환불 가능합니다.</p>
				<p>작업 100% 완료 후에는 환불이 불가합니다.</p>
				<p>기타 작업 중 단순 변심으로 인한 전액 환불이 불가합니다.</p>
			</div>
		</div>
		<div id="form">
			<form method="post" action="/admin/page/board/json.php" onsubmit="return myFunction();">
				<input type="hidden" name="board" value="logo">
				<input type="hidden" name="mode" value="input">
				<img src="/img/form.svg" style="width: 35%;">
				<div class="input" style="margin-top: 20px;">
					<label>사업장명</label>
					<input type="text" placeholder="사업장명을 입력해주세요" name="store_nm" id="store_nm">
				</div>
				<div class="input">
					<label>대표자명</label>
					<input type="text" placeholder="대표자명을 입력해주세요" name="ceo_nm" id="ceo_nm">
				</div>
				<div class="input">
					<label>연락처</label>
					<input type="text" placeholder="연락처를 입력해주세요" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" name="tel" id="tel">
				</div>
				<img src="/img/service.svg" style="width: 35%; 35%; margin-top: 40px;">
				<div class="radio" style="margin-top: 30px;">
					<input type="radio" name="service" id="service1" value="1">
					<label for="service1">
						<img src="/img/service1.svg" style="width: 51.5%; margin-bottom: 10px;">
						<p>컷편집+배경음악+자막+더빙+효과+20초</p>
					</label>
				</div>
				<div class="radio" style="margin-top: 15px;">
					<input type="radio" name="service" id="service2" value="2">
					<label for="service2">
						<img src="/img/service2.svg" style="width: 57.75%; margin-bottom: 10px;">
						<p>영상편집+배경음악+자막+더빙+효과+20초</p>
						<p style="color:#908BAB; margin-top: 5px;">(스토리 영상 10초 이상 5개 파일, 스토리에 필요한 자막 제출)</p>
					</label>
				</div>
				<div class="radio" style="margin-top: 15px;">
					<input type="radio" name="service" id="service3" value="3">
					<label for="service3">
						<img src="/img/service3.svg" style="width: 63%; margin-bottom: 10px;">
						<p>기획연출+촬영+배경음악+CM송(작사,작곡,보컬)+효과+20초(협의)</p>
						<p style="color: #FAE100; margin: 15px 0 5px 0;">노래스타일</p>
						<select id="type" name="type">
							<option value="0">선택하세요</option>
						<?php foreach($cate_list as $d) { ?>
							<option value="<?=$d['minr']?>"><?=$d['name']?> 느낌을 원해요</option>
						<?php } ?>
						</select>
					</label>
				</div>
				<div class="d-flex justify-content-between" style="width: 80%; margin: 0 auto; margin-top: 20px;">
					<div>
						<input type="checkbox" id="ck">
						<label for="ck">개인정보이용약관에 동의합니다.</label>
					</div>
					<a href="https://moneypig.co.kr/app/terms/terms4.php" target="_blank">보기</a>
				</div>
				<p style="color:#fff; margin: 40px 0 10px 0;">검토 후 연락드리겠습니다</p>
				<button>문의하기</button>
			</form>
		</div>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>
<!-- Initialize Swiper -->
<script>

    function myFunction() {

        if($('#store_nm').val() == '') {
            alert('사업장명을 입력해주세요.');
            return false;
        }
        if($('#ceo_nm').val() == '') {
            alert('대표자명을 입력해주세요.');
            return false;
        }
        if($('#tel').val() == '') {
            alert('연락처를 입력해주세요.');
            return false;
        }
        if(!$('input[name="service"]').is(':checked')) {
            alert('서비스를 선택해주세요.');
            return false;
		}
        if($('#service3').is(':checked')) {
			if($('select[name="type"]').val() == 0) {
				alert('노래스타일을 선택해주세요.');
				return false;
			}
		}
        if(!$('#ck').is(':checked')) {
            alert('개인정보이용약관에 동의해주세요.');
            return false;
		}

        var check = confirm("진행하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }
    }

</script>

</html>