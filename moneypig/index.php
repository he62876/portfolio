<!DOCTYPE html>
<html lang="ko">

<?php
include('../../common.php');
$page = (!isset($_GET['page']) ? "1":$_GET['page']);


$param = null;
// $req_cnt1 = $pdo->single("SELECT COUNT(*) FROM store_cash_log WHERE pay_tp=1 AND pay_state=1 AND store_no!=3", $param);
$req_cnt = $pdo->query("SELECT count(*) FROM moneypig_cash_req WHERE req_state = 1")->fetchColumn();
// $cash_list = $pdo->query($sql, $param);
$sql = "SELECT *, a.store_no as store, b.store_no as store_no, b.store_name as store_name, c.name as store_category
		FROM (SELECT *, ROW_NUMBER() OVER(PARTITION BY store_no ORDER BY store_no DESC) as RN FROM moneypig_cash_req) a
		LEFT OUTER JOIN moneypig_store_info b ON a.store_no = b.store_no
		LEFT OUTER JOIN moneypig_code_info c ON b.store_category = c.minr AND c.majr = 2 AND c.sub_category IS NULL
		WHERE a.RN = 1	-- 2) RN 이 1인, 순번이 1번인 행만 조회
		ORDER BY a.store_no";
$data = $pdo->query($sql, $param);
$cash_list = $data->fetchAll(PDO::FETCH_ASSOC);
$cash_count = count($cash_list);

$sql = "SELECT * FROM moneypig_news_info WHERE use_yn = 1 ORDER BY reg_date";
$data = $pdo->query($sql, $param);
$news_list = $data->fetchAll(PDO::FETCH_ASSOC);
$news_cnt = count($news_list);

// 
// $rownum = $total_record - $page_start;
//홈페이지 방문 IP 저장/////////////////////////////////////////////////////////////////////////////////
// $ip = $_SERVER['REMOTE_ADDR'];
// 
// $ipcount = $pdo->row("SELECT COUNT(*) AS cnt FROM ipcheck WHERE ip_address='".$ip."'", $param);
// if($ipcount['cnt']>0){
	// $rt = $pdo->query("UPDATE ipcheck SET COUNT = COUNT+1 ,reg_date = NOW() WHERE ip_address='".$ip."'", $param);
// }
// else{
	// $rt = $pdo->query("INSERT INTO ipcheck(ip_address,COUNT,type,reg_date) VALUES('".$ip."',1,2,NOW())", $param);
// }
//홈페이지 방문 IP 저장////////////////////////////////////////////////////////////////////////////////
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="돈되지, 내돈내산, 리뷰쓰면 돈되지, 리뷰100%, 리뷰이벤트, 먹튀제로, 동네광고, 사업장홍보, 캐시적립, 짠테크, 앱테크, 재테크">
	<!-- <meta name="description" content="우리 동네 사업장 이용하고 리뷰쓰면 사업장 사장님이 용돈을 드립니다. 다양한 곳에서 내돈내산 혜택 가득~ 매일매일 돈 쓸 맛 나는 앱테크 돈되지! 우리 동네 사업장 홍보도 하고 리뷰도 받자! 기자단, 체험단 필요없는 실속있는 홍보방법! 꿀돼지같은 우리 사업장 파트너 돈되지!"> -->
	<meta name="description" content="리뷰 이벤트, 영수증 이벤트 매장과 사업장이 여러분의 가치있는 소비와 더 나은 경험을 제공합니다. 리뷰협찬, 리뷰포인트, 리뷰쿠폰, 위치기반 문자전송, 체험단 참여까지">
	<meta property="og:type" content="website">
	<meta property="og:title" content="내돈내산 리뷰쓰면 돈되지">
	<meta property="og:image" content="img/moneypig_meta_guide.png">
	<meta property="og:description" content="내돈내산 리뷰쓰면 돈되지입니다">
	<meta property="og:url" content="https://moneypig.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="eXLmcYdidByhd62Jv7bpHnUjMmBJhp70BDC9CgIrHLo" />
	<meta name="naver-site-verification" content="ca313ff7297cfd1c8d9f558a9bc18bfd96d09b3b" />
	<link rel="shortcut icon" href="img/money.ico">
	<meta name="naver-site-verification" content="b5ed3dbadf5be1f9ff15352deff612b6e5c306a8" />
    <!-- plugin css -->
    <link href="/portfolio/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/portfolio/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/portfolio/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/portfolio/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- style-->
    <link rel="stylesheet" href="/portfolio/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">


	<title>리뷰쓰면 돈되지 - 리뷰포인트 적립 시스템</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
	@import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css');
	/* @import url('https://cdn.jsdelivr.net/gh/projectnoonnu/noonfonts_six@1.2/S-CoreDream-1Thin.woff'); */
﻿


    * {
        font-family: 'Noto Sans KR', sans-serif;
        box-sizing: border-box;
    }

	.NanumSquare{
		/* font-family: 'NanumSquare', sans-serif; */
        font-family: 'Escoredream';
	}

	.platform_icon {
		font-family: 'NanumSquare', sans-serif;
		font-weight: 900;
		font-size: 14px;
		color: #fff;
		border-radius: 100%;
		width: 47px; height: 47px;
		text-align: center;
		display: flex;
		align-items: center;
		justify-content: center;
		margin: 0 1px;
		line-height: 1;
	}

	/* 페이징 */
	.page-list {
		text-align: center;
		margin-bottom: 35px;
	}
	.page-list li, .page-list li a {
		display: inline-block;
	}
	.page-list li a {
		width: 35px;
		font-size: 12px;
		font-weight: 500;
		border: 1px solid #000;
		text-align: center;
		padding: 7.5px 0;
		margin: 0 4px;
	}
	.page-list li.on a {
		color: #fff;
		border-color: #000;
		background: #000;
	}
	/* 페이징 */
</style>
<html id="html">
	<body>
		<a href="http://pf.kakao.com/_MVdTG/chat" target="_blank" class="talk pc"><img src="img/talk.png"></a>
		<a href="http://pf.kakao.com/_MVdTG/chat" target="_blank" class="talk mb"><img src="img/mb_talk.png"></a>
		<div id="index" style="background:#FAE100;">
			<div id="mobile_menu">
				<div class="mobile_menu_header">
					<!--<img src="/img/mb_logo.png">-->
					<div></div>
					<button onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';" style="background: transparent;"><img style="width: 20px;" src="img/close.png"></button>
				</div>
				<ul>
					<li><a class="s-core" href="#index" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">홈</a></li>
					<li><a class="s-core" href="#service" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">서비스안내</a></li>
					<li><a class="s-core" href="#function" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">기능소개</a></li>
					<li><a class="s-core" href="#amt" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">가격정책</a></li>
					<li><a class="s-core" href="#download" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">다운로드</a></li>
					<li><a class="s-core" href="#news" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">뉴스/소식</a></li>
				</ul>
			</div>
			<div class="menu">
				<div>
					<img src="img/logo.svg" class="pc">
					<img src="img/logo.svg" class="mb">
					<button onclick="document.all.mobile_menu.style.display = 'block'; document.all.html.style.overflow = 'hidden';" style="background: transparent;"><img src="img/menu_btn.png" class="mb"></button>
					<ul class="pc">
						<li><a class="NanumSquare" href="#index">홈</a></li>
						<li><a class="NanumSquare" href="#service">서비스안내</a></li>
						<li><a class="NanumSquare" href="#function">기능소개</a></li>
						<li><a class="NanumSquare" href="#amt">가격정책</a></li>
						<li><a class="NanumSquare" href="#download">다운로드</a></li>
						<li><a class="NanumSquare" href="#news">뉴스/소식</a></li>
					</ul>
				</div>
			</div>
			<div class="color"></div>
			<div class="swiper mySwiper">
				<div class="swiper-pagination"></div>
				<div class="scroll">
					<img src="img/scroll.png" class="pc">
				</div>
				<div class="swiper-wrapper">
					<div class="swiper-slide">
						<div class="content-page">
							<p style="font-size: 16px;" class="pc">MONEYPIG</p>
							<p class="NanumSquare pc">
							인플루언서, 블로거, 크리에이터,</br>
							마케터 등 N잡러에게 제공되는</br>
							<span class="NanumSquare">매니저 전용기능</br>협찬은 기본! 고정수익까지 쭈~욱</span>
							</p>
							<p class="NanumSquare mb" >
							인플루언서, 블로거, 크리에이터,</br>
							마케터 등 N잡러에게 제공되는</br>
							<span class="NanumSquare">매니저 전용기능</br>협찬은 기본!</br>고정수익까지 쭈~욱</span>
							</p>
						</div>
						<img src="img/slide5.png" class="slide5 pc">
						<img src="img/mb_slide5.png" class="slide5 mb">
					</div>
					<div class="swiper-slide">
						<div class="content-page">
							<p style="font-size: 16px;" class="pc">MONEYPIG</p>
							<p class="NanumSquare">
							리뷰쓰고 포인트 받는</br>
							<span class="NanumSquare">리워드 플레이스</br>
							돈되지</span>
							</p>
						</div>
						<img src="img/cash1.png" class="cash1 pc">
						<img src="img/cash2.png" class="cash2 pc">
						<img src="img/slide1.png" class="slide1 pc">
						<img src="img/mb_slide1.png" class="slide1 mb">
					</div>
					<div class="swiper-slide">
						<div class="content-page">
							<p style="font-size: 16px;" class="pc">MONEYPIG</p>
							<p class="NanumSquare pc">
							<span class="NanumSquare">정</span>확한</br>
							<span class="NanumSquare">리</span>뷰는</br>
							<span class="NanumSquare">정</span>직한</br>
							<span class="NanumSquare">돈</span>되지
							</p>
							<p class="NanumSquare mb">
							<span class="NanumSquare">정</span>확한 
							<span class="NanumSquare">리</span>뷰는</br>
							<span class="NanumSquare">정</span>직한 
							<span class="NanumSquare">돈</span>되지
							</p>
						</div>
						<img src="img/slide4.png" class="slide4 pc">
						<img src="img/mb_slide4.png" class="slide4 mb">
					</div>
					<div class="swiper-slide">
						<div class="content-page">
							<p style="font-size: 16px;" class="pc">MONEYPIG</p>
							<p class="NanumSquare">
							우리 동네 사업장</br>
							<span class="NanumSquare">영수증이벤트 참여하면</br>
							포인트가 와르르!</span>
							</p>
						</div>
						<img src="img/slide2.png" class="slide2 pc">
						<img src="img/mb_slide2.png" class="slide2 mb">
					</div>
					<div class="swiper-slide">
						<div class="content-page">
							<p style="font-size: 16px;" class="pc">MONEYPIG</p>
							<p class="NanumSquare">
							우리 사업장 든든한</br>
							비즈니스 파트너</br>
							<span class="NanumSquare">돈되지 사장님용 APP</span>
							</p>
						</div>
						<img src="img/slide3.png" class="slide3 pc">
						<img src="img/mb_slide3.png" class="slide3 mb">
					</div>
				</div>
			</div>
		</div>
		<div id="service">
			<div class="content-page">
				<!-- <p class="title NanumSquare">돈되지에서</br><span class="NanumSquare"><?=number_format($req_cnt)?>명이 영수증 이벤트 참여하고 적립 받았어요!</span></p> -->
				<p class="title NanumSquare">돈되지에서</br><span class="NanumSquare"><?=number_format($req_cnt)?>명이 영수증 이벤트 참여하고 적립 받았어요!</span></p>
				<p class="sub-title NanumSquare" style="text-align: center; margin-top: 20px;">서비스안내</p>
				<div class="cash-list">
					<p class="NanumSquare" style="font-size:25px; font-weight: 400;">최근 적립해준 사업장</p>
					<div class="swiper mySwiper2">
						<div class="swiper-wrapper">
						<?php if($cash_count == 0) { ?>
						<?php } else {
							foreach($cash_list as $d) { 
								$cash_cnt = $pdo->query("SELECT count(*) FROM moneypig_cash_req WHERE req_state = 1 AND store_no = ".$d['store'])->fetchColumn();
								$platform_list = $pdo->query("SELECT * FROM moneypig_store_platform a LEFT OUTER JOIN moneypig_code_info b ON a.platform_no = b.minr AND b.majr = 3 WHERE b.use_yn = 1 AND a.platform_state = 1 AND a.store_no = ".$d['store_no'], $param);
								$img = $pdo->query("SELECT img_url FROM moneypig_store_img WHERE store_no = ".$d['store_no'])->fetchColumn();
								$name = array(1=>"배민", 2=>"요기요", 3=>"쿠팡</br>이츠", 4=>"네이버", 5=>"야놀자", 6=>"여기</br>어때", 7=>"땡겨요", 101=>"인스타", 102=>"페이</br>스북");
								?>
							<div class="swiper-slide">
								<div>
									<div class="store-img" style="background: url('<?=$img == null ? "img/store_img.svg":"img/store/".$img?>'); background-size: cover; background-position:center;"></div>
									<div class="d-flex ">
									<?php
										foreach ($platform_list as $p) {  ?>
											<div class="platform_icon" style="background: <?=$p['etc1'] == null ? $p['etc']:"linear-gradient(45deg, ".$p['etc'].",".$p['etc1'].")"?>">
												<?=$name[$p['platform_no']]?>
											</div>
											<!--<img src="/admin/upload/icon/<?=$p['img_url']?>" style="width: 35px; margin-right: 5px;">-->
									<?php } ?>
									</div>
									<p style="font-size:26px; font-weight: bold;"><?=$d['store_name']?></p>
									<p><?=$d['store_category']?></p>
									<!--p><?=$d['address']." ".$d['address_det']?></p-->
									<p><?=substr($d['address'], '0', 6)?></p>
								</div>
								<p class="count NanumSquare">이 사업장에서 <span class="NanumSquare"><?=number_format($cash_cnt)?>명</span>이 포인트를 받았어요!</p>
							</div>
						<?php }
							} ?>
						</div>
						<div class="arrow">
							<div class="swiper-button-prev"></div>
							<div class="swiper-button-next"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="service2">
				<div class="color"></div>
				<p class="title pc NanumSquare" style="color: #fff;transform: skewY(2deg);">리뷰도 받고 홍보도 하고</br><span class="NanumSquare">우리사업장 안성맞춤 홍보 플랫폼</span></p>
				<p class="title mb NanumSquare" style="color: #fff;transform: skewY(2deg);">리뷰도 받고 홍보도 하고</br><span class="NanumSquare">우리사업장 안성맞춤</br>홍보 플랫폼</span></p>
				<div class="box" style="transform: skewY(2deg);">
					<div>
						<p class="num NanumSquare">01</p>
						<p class="pc NanumSquare">
						리뷰신청 확인 후</br>
						우리 사업장 이용한</br>
						<span class="NanumSquare">고객에게</br>포인트 적립</span>
						</p>
						<p class="mb NanumSquare">
						리뷰신청 확인 후 
						우리 사업장 이용한</br>
						<span class="NanumSquare">고객에게 포인트 적립</span>
						</p>
						<img src="img/box1.png">
					</div>
					<div class="mb-0">
						<p class="num NanumSquare">02</p>
						<p class="pc NanumSquare">
						주변 손님들에게</br>
						<span class="NanumSquare">동네광고</span>로</br>
						내 사업장 홍보하기
						</p>
						<p class="mb NanumSquare">
						주변 손님들에게 
						<span class="NanumSquare">동네광고</span>로</br>
						내 사업장 홍보하기
						</p>
						<img src="img/box2.png">
					</div>
				</div>
			</div>
		</div>
		<div id="function">
			<div class="function2 function" style="background: #fff;">
				<div class="content-page">
					<!--<div class="swiper mySwiper3">
						<p class="sub-title mb NanumSquare">고객용 APP</p>
						<div class="swiper-pagination2 mb"></div>
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<img src="/img/function1_1.png">
							</div>
							<div class="swiper-slide">
								<img src="/img/function1_2.png">
							</div>
							<div class="swiper-slide">
								<img src="/img/function1_3.png">
							</div>
						</div>
					</div>
					<div class="swiper mySwiper4">
						<p class="sub-title pc NanumSquare">고객용 APP</p>
						<div class="swiper-pagination2 pc "></div>
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<p class="title"><span class="NanumSquare">내 주변<span></p>
								<p class="NanumSquare">
								우리동네 캐시 많이주는</br>
								사업장을 찾아보세요! 음식점부터</br>
								카페, 뷰티, 헬스, 숙박까지</br>
								가장 궁금한 캐시정보만 쏙쏙!
								</p>
							</div>
							<div class="swiper-slide">
								<p class="title"><span class="NanumSquare">캐시요청<span></p>
								<p class="NanumSquare">
								리뷰 작성 후 사장님에게</br>
								캐시를 요청하면</br>
								사장님이 캐시를 적립해드려요!
								</p>
							</div>
							<div class="swiper-slide">
								<p class="title"><span class="NanumSquare">캐시출금<span></p>
								<p class="NanumSquare">
								알뜰살뜰 열심히 모은 내 캐시</br>
								캐시출금을 통해 내 계좌로</br>
								출금 할 수 있어요!
								</p>
							</div>
						</div>
						<div class="arrow">
							<div class="swiper-button-prev2"></div>
							<div class="swiper-button-next2"></div>
						</div>
					</div>-->
					<div class="function-box1">
						<img src="img/function4.png">
						<div>
							<p class="sub-title sub-title1 NanumSquare">고객용 APP</p>
							<p class="title"><span class="NanumSquare">체험단 이벤트</span></p>
							<p class="NanumSquare" style="font-size: 18px; margin-bottom: 50px;">
							우리동네</br>
							사장님들이 요청한</br>
							체험단 이벤트에</br>
							참여할 수 있어요
							</p>
						</div>
					</div>
					<div class="function-box2">
						<div>
							<p class="title"><span class="NanumSquare">내돈내산 이벤트</span></p>
							<p class="NanumSquare" style="font-size: 18px; margin-bottom: 50px;">
							우리동네 사업장을</br>
							이용하고 사장님이 요청한</br>
							채널에 리뷰를 등록하면</br>
							포인트를 지급해드립니다
							</p>
						</div>
						<img src="img/function5.png">
					</div>
				</div>
			</div>
			<div class="function2">
				<div class="content-page">
					<div class="function-box1">
						<img src="img/function2.png">
						<div>
							<p class="sub-title NanumSquare">사장님용 APP</p>
							<p class="title"><span class="NanumSquare">캠페인 요청</span></p>
							<p class="NanumSquare" style="font-size: 18px; margin-bottom: 50px;">
							체험단을 위한</br>
							캠페인 요청 서비스!</br>
							사업장을 등록한 사장이라면</br>
							누구나 인플루언서를</br>
							모집 할 수 있습니다
							</p>
						</div>
					</div>
					<div class="function-box2">
						<div>
							<p class="title"><span class="NanumSquare">내돈내산 적립</span></p>
							<p class="NanumSquare" style="font-size: 18px; margin-bottom: 50px;">
							우리 사업장을 이용한</br>
							고객님의 영수증과 리뷰를</br>
							앱으로 확인하고 캐시를</br>
							지급 할 수 있어요
							</p>
						</div>
						<img src="img/function3.png">
					</div>
				</div>
			</div>
		</div>
		<div id="pos">
			<div class="content-page">
				<div class="pos">
					<img src="img/pos.png">
					<div>
						<p class="sub-title NanumSquare">사장님용 POS</p>
						<p class="title"><span class="NanumSquare">포인트 적립시스템</span></p>
						<p class="NanumSquare" style="font-size: 18px; margin-bottom: 50px;">
							미션이벤트에 참여한</br>
							고객에게 포인트적립!</br>
							영수증이벤트로 단골고객도 만들고</br>
							광고까지 일석이조~
						</p>
					</div>
				</div>
			</div>
		</div>
		<div id="amt">
			<div class="amt1">
				<p class="title"><span class="NanumSquare">서비스 가격 정책</span></p>
				<div class="amt_list">
				<img class="amt_img1" src="img/amt_img1.png">
				<img class="amt_img2" src="img/amt_img2.png">
					<div class="amt_box amt_box1">
						<p class="title NanumSquare" style="color: #FB3E30">1개월 약정</p>
						<div class="list">
							<p><span>적립시스템</span> 풀패키지</p>
							<p><span>매뉴얼</span> 지원</p>
							<p><span>판촉물</span> 지원</p>
							<p><span>입점이벤트</span> 지원</p>
						</div>
						<div class="sale">
							<div class="per">
								<p class="NanumSquare">50<span class="NanumSquare">%</span></p>
							</div>
							<div class="pay">
								<p class="before">44,000원</p>
								<p class="after" style="color: #FB3E30">22,000원</p>
							</div>
						</div>
					</div>
					<div class="amt_box amt_box2">
						<p class="title NanumSquare" style="color: #FA8937">6개월 약정</p>
						<p class="amt_service NanumSquare"><span class="NanumSquare">1개월</span> 추가</p>
						<div class="list">
							<p><span>적립시스템</span> 풀패키지</p>
							<p style="color: #FA8937"><span>문자광고</span> 무료</p>
							<p style="color: #FA8937"><span>체험단 모집</span> 지원</p>
							<p><span>매뉴얼</span> 지원</p>
							<p><span>판촉물</span> 지원</p>
							<p><span>입점이벤트</span> 지원</p>
						</div>
						<div class="sale">
							<div class="per">
								<p class="NanumSquare">50<span class="NanumSquare">%</span></p>
							</div>
							<div class="pay">
								<p class="before">220,000원</p>
								<p class="after" style="color: #FA8937">110,000원</p>
							</div>
						</div>
					</div>
					<div class="amt_box amt_box3">
						<p class="title NanumSquare" style="color: #772AFF">12개월 약정</p>
						<p class="amt_service NanumSquare"><span class="NanumSquare">2개월</span> 추가</p>
						<div class="list">
							<p><span>적립시스템</span> 풀패키지</p>
							<p style="color: #772AFF"><span>문자광고</span> 무료</p>
							<p style="color: #772AFF"><span>체험단 모집</span> 지원</p>
							<p><span>매뉴얼</span> 지원</p>
							<p><span>판촉물</span> 지원</p>
							<p><span>입점이벤트</span> 지원</p>
						</div>
						<div class="sale">
							<div class="per">
								<p class="NanumSquare">50<span class="NanumSquare">%</span></p>
							</div>
							<div class="pay">
								<p class="before">440,000원</p>
								<p class="after" style="color: #772AFF">220,000원</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="amt2">
				<p class="title"><span class="NanumSquare">서비스 가격 상세</span></p>
				<p class="sub_title pc NanumSquare">할인률에 따른 서비스 가격은 <span class="NanumSquare">시장환경 또는 내부정책에 따라 변동</span> 될 수 있습니다.</p>
				<p class="sub_title mb NanumSquare">할인률에 따른 서비스 가격은</br><span class="NanumSquare">시장환경 또는 내부정책에 따라 변동</span> 될 수 있습니다.</p>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th style="width: 50%;">서비스</th>
								<th style="width: 50%;">지원단가</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>적립시스템 풀패키지</td>
								<td style="font-weight: bold;">44,000원 (월)</td>
							</tr>
							<tr>
								<td>문자광고지원
									<p class="amt_service NanumSquare"><span class="NanumSquare">6개월/12개월</span>플랜
								</td>
								<td style="font-weight: bold;">55,000원 (월)</p>
								</td>
							</tr>
							<tr>
								<td>체험단 모집 지원
									<p class="amt_service NanumSquare"><span class="NanumSquare">6개월/12개월</span>플랜
								</td>
								<td style="font-weight: bold;">50,000원 (1회)</td>
							</tr>
							<tr>
								<td>현장교육지원</td>
								<td style="font-weight: bold;">50,000원 (1회)</td>
							</tr>
							<tr>
								<td>판촉물지원</td>
								<td style="font-weight: bold;">20,000원 (1회)</td>
							</tr>
							<tr>
								<td>입점이벤트지원</td>
								<td>앱 상단노출</td>
							</tr>
							<tr class="pc">
								<td style="border-bottom-width: 0; padding-top: 47px;">전체서비스 가격</td>
								<td style="border-bottom-width: 0;">
									<p class="before">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>44,000원</span> 50%</p>
									월 <p class="after" style="line-height: 36px;">22,000원</p>
								</td>
							</tr>
							<tr>
								<td  class="mb" colspan="2" style="border-bottom-width: 0;">
									<p class="before">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span>44,000원</span> 50%</p>
									월 <p class="after" style="line-height: 36px;">22,000원</p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="amt3">
				<p class="title"><span class="NanumSquare" style="color:#fff;">서비스 주요기능</span></p>
				<div class="pc list_box">
					<div>
						<div class="list">
							<img src="img/amt3_1.png">
							<div>
								<p class="list_title NanumSquare">입점이벤트</p>
								<p class="list_cont NanumSquare">가입 시 주변 알림 및 2일간 상단 노출</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_2.png">
							<div>
								<p class="list_title NanumSquare">무제한 쿠폰 생성</p>
								<p class="list_cont NanumSquare">사업장 쿠폰 무제한 생성</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_3.png">
							<div>
								<p class="list_title NanumSquare">영수증 리뷰 적립</p>
								<p class="list_cont NanumSquare">상시 사업장 홍보와 내돈내산 고객의</br>적립요청 실시간 확인</p>
							</div>
						</div>
					</div>
					<div>
						<div class="list">
							<img src="img/amt3_4.png">
							<div>
								<p class="list_title NanumSquare">고객 CRM 확보</p>
								<p class="list_cont NanumSquare">성별, 연령대, 위치기반 CRM 제공</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_5.png">
							<div>
								<p class="list_title NanumSquare">3km 타겟 문자</p>
								<p class="list_cont NanumSquare">3Km 이내 동네 푸시 알림 문자 전송</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_6.png">
							<div>
								<p class="list_title NanumSquare">체험단 모집</p>
								<p class="list_cont NanumSquare">앱을 통해 사장님이 직접 체험단</br>모집 공고 및 신청자 선별</p>
							</div>
						</div>
					</div>
				</div>
				<div class="mb list_box">
					<div>
						<div class="list">
							<img src="img/amt3_1.png">
							<div>
								<p class="list_title NanumSquare">입점이벤트</p>
								<p class="list_cont NanumSquare">가입 시 주변 알림 및</br>2일간 상단 노출</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_5.png">
							<div>
								<p class="list_title NanumSquare">3km 타겟 문자</p>
								<p class="list_cont NanumSquare">3Km 이내 동네</br>푸시 알림 문자 전송</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_3.png">
							<div>
								<p class="list_title NanumSquare">영수증 리뷰 적립</p>
								<p class="list_cont NanumSquare">상시 사업장 홍보와 내돈내산</br>고객의 적립요청 실시간 확인</p>
							</div>
						</div>
					</div>
					<div>
						<div class="list">
							<img src="img/amt3_2.png">
							<div>
								<p class="list_title NanumSquare">무제한 쿠폰 생성</p>
								<p class="list_cont NanumSquare">사업장 쿠폰</br>무제한 생성</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_4.png">
							<div>
								<p class="list_title NanumSquare">고객 CRM 확보</p>
								<p class="list_cont NanumSquare">성별, 연령대, 위치기반</br>CRM 제공</p>
							</div>
						</div>
						<div class="list">
							<img src="img/amt3_6.png">
							<div>
								<p class="list_title NanumSquare">체험단 모집</p>
								<p class="list_cont NanumSquare">앱을 통해 사장님이 직접 체험단</br>모집 공고 및 신청자 선별</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="download">
			<p class="title"><span class="NanumSquare" style="color: #fff;">다운로드</span></p>
			<div class="download-box">
				<p class="NanumSquare">고객용 APP</p>
				<div>
					<a href="https://play.google.com/store/apps/details?id=com.emscnc.moneypig.user" target="_blank">
						<img src="img/google.png">
						<p>안드로이드 다운로드</p>
					</a>
					<a href="https://apps.apple.com/kr/app/%EB%A6%AC%EB%B7%B0%EC%93%B0%EB%A9%B4-%EB%8F%88%EB%90%98%EC%A7%80-%EB%82%B4%EB%8F%88%EB%82%B4%EC%82%B0/id6450106078" target="_blank">
						<img src="img/apple.png">
						<p>애플 다운로드</p>
					</a>
				</div>
			</div>
			<div class="download-box">
				<p class="NanumSquare">사장님용 APP</p>
				<div>
					<a href="https://play.google.com/store/apps/details?id=com.emscnc.moneypig.store" target="_blank">
						<img src="img/google.png">
						<p>안드로이드 다운로드</p>
					</a>
					<a href="https://apps.apple.com/kr/app/%EB%A6%AC%EB%B7%B0%EC%93%B0%EB%A9%B4-%EB%8F%88%EB%90%98%EC%A7%80-%EC%82%AC%EC%9E%A5%EB%8B%98-%EC%A0%81%EB%A6%BD-%EC%B2%B4%ED%97%98%EB%8B%A8-%EC%BF%A0%ED%8F%B0-%EB%AC%B8%EC%9E%90/id6450106082" target="_blank">
						<img src="img/apple.png">
						<p>애플 다운로드</p>
					</a>
				</div>
			</div>
			<!--<div class="download-box">
				<p class="NanumSquare">사장님용 POS</p>
				<div>
					<a href="/admin/page/board/download.php?fileName=MPGUseSetup.exe">
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
						  <g id="그룹_29142" data-name="그룹 29142" transform="translate(-787 -6155)">
							<rect id="사각형_24330" data-name="사각형 24330" width="18" height="18" transform="translate(787 6155)" fill="none"/>
							<g id="그룹_29141" data-name="그룹 29141" transform="translate(-228 27.055)">
							  <path id="패스_8883" data-name="패스 8883" d="M27.228,1.265Q30.926.6,34.632,0q0,3.819,0,7.637c-2.468.011-4.936.055-7.406.065q0-3.22,0-6.437" transform="translate(996.033 6128.945)" fill="#fff"/>
							  <path id="패스_8884" data-name="패스 8884" d="M0,6.949c1.856-.337,3.72-.628,5.584-.9q0,3.168,0,6.334c-1.862,0-3.725.031-5.587.026Z" transform="translate(1017 6124.289)" fill="#fff"/>
							  <path id="패스_8885" data-name="패스 8885" d="M0,36.6c1.861-.007,3.722.028,5.583.024,0,2.117,0,4.235,0,6.352-1.859-.324-3.722-.607-5.584-.9Z" transform="translate(1017 6100.763)" fill="#fff"/>
							  <path id="패스_8886" data-name="패스 8886" d="M27.184,36.969H34.6q0,3.809,0,7.619c-2.465-.434-4.935-.838-7.4-1.232q0-3.193-.011-6.387" transform="translate(996.065 6100.475)" fill="#fff"/>
							</g>
						  </g>
						</svg>
						<p>포인트 관리 시스템</p>
					</a>
				</div>
			</div>-->
		</div>
		<div id="news">
			<div class="content-page">
				<p class="title"><span class="NanumSquare">뉴스/소식</span></p>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th style="width: 80px;">번호</th>
								<th>제목</th>
								<th style="width: 100px;">등록일</th>
							</tr>
						</thead>
						<tbody>
							<?php if($news_cnt == 0) { ?>
							<tr>
								<td colspan="3">조회된 정보가 없습니다.</td>
							</tr>
							<?php } else {
								foreach($news_list as $d) {	?>
							<tr>
								<td><?=$d['news_no']?></td>
								<td><a style="cursor:pointer" onclick="window.open('news-info.php?news_no=<?=$d['news_no']?>', '_blank', 'width=500, height=700')"><?=$d['news_title']?></a></td>
								<td><?=substr($d['reg_date'],0,10)?></td>
							</tr>
							<?php //$rownum--; 
							}
								} ?>
						</tbody>
					</table>
				</div>
				<!-- <ul class="page-list">
					<?php
						if ($page <= 1){
							// 빈 값
						} else {
							if(isset($unum)){
								echo "<li><a  href='index.php?page=1#news' aria-label='Previous'><<</a></li>";
							} else {
								echo "<li><a  href='index.php?page=1#news' aria-label='Previous'><<</a></li>";
							}
						}
						for($i = $block_start; $i <= $block_end; $i++){
							if($page == $i){
								echo "<li class='on'><a href=''> $i </a></li>";
							} else {
								if(isset($unum)){
									echo "<li><a  href='index.php?page=$i#news'> $i </a></li>";
								} else {
									echo "<li><a  href='index.php?page=$i#news'> $i </a></li>";
								}
							}
						}
						if($page >= $total_page){
							// 빈 값
						} else {
							if(isset($unum)){
								echo "<li><a   href='index.php?page=$total_page#news'>>></a>";
							} else {
								echo "<li><a   href='index.php?page=$total_page#news'>>></a>";
							}
						}
					?> 
				</ul> -->
				<!--<button onclick="window.open('news-list.php', '_blank', 'width=500, height=700')">소식 더 보기</button>-->
			</div>
		</div>
		<footer>
			<div class="content-page">
				<img src="img/footer.svg">
				<div class="pc">
					<p class="p1">주소</p>
					<p class="p2 after">대구광역시 남구</p>
					<p class="p1">사업자등록번호</p>
					<p class="p2 after">000-00-00000</p>
					<p class="p1">통신판매업신고번호</p>
					<p class="p2">남구</p>
				</div>
				<div class="mb">
					<p class="p1">주소</p>
					<p class="p2">대구광역시 남구</p>
				</div>
				<div class="mb">
					<p class="p1">사업자등록번호</p>
					<p class="p2">000-00-00000</p>
				</div>
				<div class="mb">
					<p class="p1">통신판매업신고번호</p>
					<p class="p2">남구</p>
				</div>
				<div>
					<p class="p2">서비스에 사용된 제품과, 콘텐츠는 해당 소유자 또는 라이선스 제공자의 것이며,</br>본 시스템은 저작권이 있는 자산입니다.(특허출원)</p>
				</div>
				<a style="cursor:pointer;" onclick="window.open('/app/terms/terms2.php', 'PopupWin', 'top=500,right=200,width=850,height=500');" class="after">개인정보처리방침</a>
				<a style="cursor:pointer; color: #fff;" onclick="window.open('/app/terms/terms1.php', 'PopupWin', 'top=500,right=200,width=850,height=500');">서비스이용약관</a>
				<p style="color: #fff; font-size: 14px; font-weight: 400;">Copyright ⓒ 2023 communications</p>
			</div>
		</footer>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/portfolio/bootstrap/js/bootstrap.min.js"></script>
<script src="/portfolio/assets/libs/jquery/jquery.min.js"></script>
<script src="/portfolio/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/portfolio/assets/libs/metismenu/metisMenu.min.js"></script>
<script src="/portfolio/assets/libs/simplebar/simplebar.min.js"></script>
<script src="/portfolio/assets/libs/node-waves/waves.min.js"></script>
<script src="/portfolio/assets/libs/feather-icons/feather.min.js"></script>
<!-- pace js -->
<script src="/portfolio/assets/libs/pace-js/pace.min.js"></script>

<!-- apexcharts -->
<script src="/portfolio/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- dashboard init -->
<script src="/portfolio/assets/js/pages/dashboard.init.js"></script>

<script src="/portfolio/assets/js/app.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<!-- <script src="js/chart.js"></script> -->
<!-- <script src="js/main.js"></script> -->

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
	var swiper = new Swiper(".mySwiper", {
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		autoplay: {
		  delay: 5000,
		  disableOnInteraction: false,
		},
		pagination: {
		  el: ".swiper-pagination",
		  clickable: true,
		},
	});

	var swiper2 = new Swiper(".mySwiper2", {
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
		//slidesPerView: 3,
        //slidesPerGroup: 3,
        observer: true,
        observeParents: true,
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		autoplay: {
		  delay: 5000,
		  disableOnInteraction: false,
		},
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
		breakpoints: {
            1280: {
                slidesPerView: 3,
                slidesPerGroup: 1,
            },
            768: {
                slidesPerView: 1,
                slidesPerGroup: 1,
           }
        }
	});

	var bullet = ['내 주변', '캐시요청', '캐시출금'];

	var swiper3 = new Swiper(".mySwiper3", {
		effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		pagination: {
		  el: ".swiper-pagination2",
		  clickable: true,
		  renderBullet: function (index, className) {
			return '<div class="' + className + '"><span class="NanumSquare">' + (bullet[index]) + '</span></div>';
		  }
		}
	});

	var swiper4 = new Swiper(".mySwiper4", {
		effect: 'fade',
        fadeEffect: {
            crossFade: true,
        },
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		pagination: {
		  el: ".swiper-pagination2",
		  clickable: true,
		  renderBullet: function (index, className) {
			return '<div class="' + className + '"><span class="NanumSquare">' + (bullet[index]) + '</span></div>';
		  }
		},
		navigation: {
		  nextEl: ".swiper-button-next2",
		  prevEl: ".swiper-button-prev2",
		},
	});
	
	swiper3.controller.control = swiper4;
	swiper4.controller.control = swiper3;

	$(document).scroll(function () {
		var scrollTop = $(this).scrollTop();
		if (scrollTop > 300) {
			$('.menu').addClass('on');
		} else {
			$('.menu').removeClass('on');
		}
	});
</script>

</html>