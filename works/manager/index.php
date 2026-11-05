<?php

/* if(!isset($_SESSION['lv'])) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/login.php'>";
	exit;
} */
 
include('../../common.php');

$param = null;

$expert_cnt = $pdo->query("SELECT count(*) FROM manager_user_info WHERE state = 1 AND user_tp = 2")->fetchColumn();

$expert_cate = $pdo->query("SELECT * FROM manager_code_info WHERE majr = 1 AND minr > 0 AND use_yn = 1", $param);
$expert_list = $pdo->query("SELECT * FROM manager_user_info WHERE state = 1 AND user_tp = 2 ORDER BY reg_date DESC", $param);

$qna_list = $pdo->query("SELECT *, a.category as category, a.reg_date as reg_date FROM manager_qna_info a LEFT OUTER JOIN manager_user_info b ON a.user_no = b.user_no WHERE a.qna_tp = 1 AND a.state = 1 ORDER BY a.reg_date DESC LIMIT 4", $param);
$qna_cnt = $pdo->query("SELECT count(*) FROM manager_qna_info a LEFT OUTER JOIN manager_user_info b ON a.user_no = b.user_no WHERE a.qna_tp = 1 AND a.state = 1")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <link rel="stylesheet" href="/portfolio/works/manager/css/style_w.css">
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
	<body>
		<div id="wrap">
			<div id="popup">
				<div>
				<img src="/portfolio/works/manager/img/web/popup.svg"><p>어플에서</p>
				</div>
				<p style="margin-bottom: 30px;">편하게 정보를 볼 수 있어요</p>
				<a style="background: #001E5E; border-color: #001E5E; color: #fff;" href="vision.ne.kr/app.php">앱 보러가기</a>
				<a style="cursor: pointer;" onclick="popupClose();">괜찮아요</a>
			</div>
			<a href="http://pf.kakao.com/_dZAYG/chat" class="talk"><img src="/portfolio/works/manager/img/web/talk.png"></a>
			<div id="index">
				<div class="header">
					<img src="/portfolio/works/manager/img/web/logo.svg">
				</div>
				<div class="swiper mySwiper">
					<div class="swiper-pagination"></div>
					<div class="swiper-wrapper">
						<div class="swiper-slide" data-swiper-autoplay="24000">
							<div class="p_box">
								<p class="white pc" style="line-height: 1.2;">바쁜 소상공인과 자영업자를 위한</p>
								<p class="white mb" style="line-height: 1.2;">바쁜 소상공인과 </br>자영업자를 위한</p>
								<p class="white bold pc" style="line-height: 1.2;">전문가 상담 서비스</p>
								<p class="white bold mb" style="line-height: 1.2;">전문가 상담 서비스</p>
								<p class="white sub_title pc">자영업 성공의 지름길, 분야별 전문가와 함께!</p>
								<p class="white sub_title mb">자영업 성공의 지름길,</br>분야별 전문가와 함께!</p>
							</div>
							<div class="bg_video">
								<video class="bg_video_content" autoplay muted loop>
									<source src="/portfolio/works/manager/img/web/index3.mp4" type="video/mp4" />
								</video>
							</div>
						</div>
						<div class="swiper-slide" data-swiper-autoplay="9000">
							<div class="p_box">
								<p class="white pc" style="line-height: 1.2;">소상공인·자영업자에게만 홍보되는</p>
								<p class="white mb" style="line-height: 1.2;">소상공인·</br>자영업자에게만</br>홍보되는</p>
								<p class="white bold" style="line-height: 1.2;">우리동네 전문가</p>
								<p class="white sub_title pc">영업의 시작은 노력이 아니라, 남들과 다른 차별성에서 시작된다!</p>
								<p class="white sub_title mb">영업의 시작은 노력이 아니라,</br>남들과 다른 차별성에서 시작된다!</p>
							</div>
							<div class="bg_video">
								<video class="bg_video_content" autoplay muted loop>
									<source src="/portfolio/works/manager/img/web/index1.mp4" type="video/mp4" />
								</video>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="p_box">
								<p class="white pc" style="line-height: 1.2;">우리동네 전문가 홍보를 위한</p>
								<p class="white mb" style="line-height: 1.2;">우리동네 전문가</br>홍보를 위한</p>
								<p class="white bold pc" style="line-height: 1.2;">스마트 전단지</p>
								<p class="white bold mb" style="line-height: 1.2;">스마트 전단지</p>
								<p class="white sub_title pc">세일즈는 작은 행동에서 시작되고, 바쁜 소상공인들과, 자영업자들을 위해</br>당신의 가치를 제안 해드립니다.지금 등록하세요</p>
								<p class="white sub_title mb">세일즈는 작은 행동에서 시작되고,</br>바쁜 소상공인들과, 자영업자들을 위해</br>당신의 가치를 제안 해드립니다.지금 등록하세요</p>
							</div>
							<div class="bg_video">
								<video class="bg_video_content" autoplay muted loop>
									<source src="/portfolio/works/manager/img/web/index2.mp4" type="video/mp4" />
								</video>
							</div>
						</div>
					</div>
					<div class="btn_box">
						<a><img src="/portfolio/works/manager/img/web/link_g.svg"></a>
						<a><img src="/portfolio/works/manager/img/web/link_a.svg"></a>
					</div>
				</div>
			</div>
			<div id="counter">
				<div>
					<div class="swiper mySwiper3">
						<div class="swiper-pagination2"></div>
						<div class="swiper-wrapper">
							<div class="swiper-slide title">
								<p class="white bold pc" style="line-height: 1.2;">
								우리동네 소상공인에게<br>
								홍보되는 전문가 플랫폼!
								</p>
								<p class="white bold mb" style="line-height: 1.2;">
								우리동네</br>소상공인에게<br>
								홍보되는</br>전문가 플랫폼!
								</p>
								<p class="blue">
								지금 등록하고 홍보해보세요
								</p>
							</div>
							<div class="swiper-slide title">
								<p class="white bold pc" style="line-height: 1.2;">
								바쁜 사장님!<br>
								전문가와 무료 상담해보세요
								</p>
								<p class="white bold mb" style="line-height: 1.2;">
								바쁜 사장님!<br>
								전문가와<br>무료 상담해보세요
								</p>
								<p class="blue">
								지인에게 물어볼 것 없이 여기서 바로 해결
								</p>
							</div>
						</div>
					</div>
					<div class="count">
						<div>
							<p class="white black num odd"><?=number_format($expert_cnt)?></p>
							<p class="white bold">누적 전문가 수</p>
							<p class="sky">
							수많은 전문가들이 비전과<br>
							함께 성장하고 있습니다.
							</p>
						</div>
						<div>
							<p class="white black num odd"><?=number_format($qna_cnt)?></p>
							<p class="white bold">상담건수</p>
							<p class="sky">
							검증받은 전문가들이 실시간<br>
							상담을 진행하고 있습니다.
							</p>
						</div>
						<div>
							<p class="white black num odd"><?=number_format(522)?></p>
							<p class="white bold">통화상담건수</p>
							<p class="sky">
							수많은 자영업자들이 통화상담으로<br>
							문제를 즉시 해결하고 있습니다.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div id="info">
				<div>
					<p class="title bold pc">우리동네 전문가와 함께하세요</p>
					<p class="title bold mb">우리동네 전문가와</br>함께하세요</p>
					<p class="blue pc">어렵지 않습니다! 쉽고 간편하게 가까운 전문가들을 만나보세요!</p>
					<p class="blue mb">어렵지 않습니다!</br>쉽고 간편하게</br>가까운 전문가들을 만나보세요!</p>
					<a class="button" style="cursor: pointer;" onclick="popupOpen();">더 많은 전문가 보기</a>
					<div class="expert_cate">
						<?php foreach($expert_cate as $d) { ?>
						<div>
							<div>
								<img src="/portfolio/works/manager/admin/upload/code/<?=$d['img_url']?>">
								<p><?=$d['name']?></p>
							</div>
						</div>
						<?php } ?>
					</div>
					<div class="swiper mySwiper2 expert_list">
						<div class="swiper-wrapper">
							<?php foreach($expert_list as $d) { 
								$category = $pdo->query("SELECT name FROM manager_code_info WHERE majr = 1 AND minr = ".$d['category'])->fetchColumn();
								$areas = explode(' ' , $d['address']);
							?>
							<div class="swiper-slide">
								<a style="cursor: pointer;" onclick="popupOpen();">
									<div class="expert_img" style="background: <?=$d['img_url'] == null ? "":"url('/portfolio/works/manager/upload/profile/".$d['img_url']."')"?>; background-size: cover; background-position: center;"></div>
									<p class="expert_area"><?=$areas[0]?></p>
									<p class="expert_nm"><?=$d['user_nm']?></p>
									<p class="expert_category"><?=$category?></p>
								</a>
							</div>
							<?php } ?>
						</div>
					</div>
					<div class="navigation">
						<div class="swiper-button-prev"></div>
						<div class="swiper-button-next"></div>
					</div>
				</div>
			</div>
			<div id="qna">
				<p class="title bold pc">전문가 의견 궁금해요</p>
				<p class="title bold mb">전문가 의견 </br>궁금해요</p>
				<p class="blue">전문적인 지식을 공유해보세요!</p>
				<div class="qna_list">
					<?php foreach($qna_list as $d){ 
						$category = $pdo->query("SELECT name FROM manager_code_info WHERE majr = 1 AND minr = ".$d['category'])->fetchColumn();
						$cnt = $pdo->query("SELECT count(*) FROM manager_qna_info WHERE qna_tp = 2 AND state = 1 AND qna_answer_no = ".$d['qna_no'])->fetchColumn();
					?>
					<div class="qna_info">
						<a style="cursor: pointer;" onclick="popupOpen();">
							<div class="qna_user">
								<div style="display: flex; align-items: center;">
									<div class="round_img qna_img" style="background: <?=$d['img_url'] == null ? "":"url('/portfolio/works/manager/upload/profile/".$d['img_url']."')"?>; background-size: cover; background-position: center;"></div>
									<div>
										<p class="qna_category"><?=$category?></p>
										<p class="qna_nm"><span><?=substr($d['reg_date'],0,10)?></span></p>
									</div>
								</div>
								<div>
									<img src="/portfolio/works/manager/img/answer.png" style="display: inline-block;">
									<p class="qna_cnt" style="display: inline-block;"><span><?=$cnt?>명</span>이 답변</p>
								</div>
							</div>
							<p class="qna_sub"><?=$d['qna_sub']?></p>
							<p class="qna_cont"><?=nl2br($d['qna_cont'])?></p>
						</a>
					</div>
					<?php } ?>
				</div>
				<a class="more" style="cursor: pointer;" onclick="popupOpen();"><p><span class="bold"><?=$qna_cnt?>건</span>의 질문들을 확인해보세요!</p></a>
			</div>
			<div id="membership">
				<p class="title bold" style="color: #fff;">전문가 멤버십 안내</p>
				<!--<p class="blue">아래 계좌로 입금하시면 관리자가 검토 후 연락을 드립니다.</p>
				<div class="bank">
					<p class="pc">하나새마을금고 123456-78-123456</p>
					<p class="mb">하나새마을금고</br>123456-78-123456</p>
				</div>
				<div class="pay">
					<div style="background: #00A8FF;">
						<p style="font-size: 16px;">알뜰한 혜택!</p>
						<p class="bold" style="font-size: 16px;">1개월 멤버십</p>
						<p class="bold" style="margin-top: 15px; font-size: 20px;">33,000원 <span style="font-weight: 400; font-size: 15px; opacity: 0.5; text-decoration : line-through;">44,000원</span></p>
					</div>
					<div style="background: #1B76DF;">
						<p style="font-size: 16px;">알뜰한 혜택!</p>
						<p class="bold" style="font-size: 16px;">6개월 멤버십 <span style="font-weight: 400; font-size: 12px;">1개월 할인</span></p>
						<p class="bold" style="margin-top: 15px; font-size: 20px;">165,000원 <span style="font-weight: 400; font-size: 15px; opacity: 0.5; text-decoration : line-through;">198,000원</span></p>
					</div>
					<div style="background: #001E5E;">
						<p style="font-size: 16px;">알뜰한 혜택!</p>
						<p class="bold" style="font-size: 16px;">12개월 멤버십 <span style="font-weight: 400; font-size: 12px;">2개월 할인</span></p>
						<p class="bold" style="margin-top: 15px; font-size: 20px;">330,000원 <span style="font-weight: 400; font-size: 15px; opacity: 0.5; text-decoration : line-through;">396,000원</span></p>
					</div>
				</div>-->
				<img src="/portfolio/works/manager/img/web/membership_pc.png" class="pc">
				<img src="/portfolio/works/manager/img/web/membership_mb.png" class="mb">
			</div>
			<div id="service">
				<p class="title bold">주요서비스</p>
				<p class="blue">다양한 서비스를 만나보세요</p>
				<div class="service_box">
					<div class="service_list">
						<div class="service_img">
							<img src="/portfolio/works/manager/img/web/service1.png" class="pc">
							<img src="/portfolio/works/manager/img/web/service1_mb.png" class="mb">
						</div>
						<div class="service_info">
							<strong>스마트명함</strong>
							<p>복잡한 명함 교환 없이</br>링크 하나로 고객에게 모든 정보를</br>전달합니다.</p>
						</div>
					</div>
					<div class="service_list">
						<div class="service_img">
							<img src="/portfolio/works/manager/img/web/service2.png" class="pc">
							<img src="/portfolio/works/manager/img/web/service2_mb.png" class="mb">
						</div>
						<div class="service_info">
							<strong>AI 상담서비스</strong>
							<p>고객의 질문에 대한</br>인공지능 예측 답변서비스</p>
						</div>
					</div>
					<div class="service_list">
						<div class="service_img">
							<img src="/portfolio/works/manager/img/web/service3.png" class="pc">
							<img src="/portfolio/works/manager/img/web/service3_mb.png" class="mb">
						</div>
						<div class="service_info">
							<strong>다채널 노출</strong>
							<p>플랫폼 외 전국 협약된</br>오프라인 기관들의 미디어를</br>통한 시인성 있는 홍보 노출</p>
						</div>
					</div>
				</div>
			</div>
			<div id="partner">
				<p class="title bold">PARTNER</p>
				<p class="blue pc">비전은 다양한 제휴채널 및 협력기관들과 함께 노력하고</br>최고의 전문가 연결을 지원합니다.</p>
				<p class="blue mb">비전은 다양한 제휴채널 및</br>협력기관들과 함께 노력하고</br>최고의 전문가</br>연결을 지원합니다.</p>
				<div class="swiper mySwiper4 expert_list">
					<div class="swiper-wrapper">
						<div class="swiper-slide"><img src="/portfolio/works/manager/img/web/partner2.png"></div>
						<div class="swiper-slide"><img src="/portfolio/works/manager/img/web/partner3.png"></div>
						<div class="swiper-slide"><img src="/portfolio/works/manager/img/web/partner4.png"></div>
					</div>
				</div>
				<div class="navigation">
					<div class="swiper-button-prev2"></div>
					<div class="swiper-button-next2"></div>
				</div>
			</div>
			<footer>
				<div class="content-page">
					<img src="/portfolio/works/manager/img/web/footer.svg">
					</br>
					</br>
					<a style="cursor:pointer; color: #BDC0C5;" onclick="window.open('/portfolio/works/manager/terms/terms2.php', 'PopupWin', 'top=500,right=200,width=850,height=500');" class="after">개인정보처리방침</a>
					<a style="cursor:pointer; color: #BDC0C5;" onclick="window.open('/portfolio/works/manager/terms/terms1.php', 'PopupWin', 'top=500,right=200,width=850,height=500');">서비스이용약관</a>
					</br>
					<p class="p2">서비스에 사용된 제품과, 콘텐츠는 해당 소유자 또는 라이선스 제공자의 것이며, 본 시스템은 저작권이 있는 자산입니다.</p>
					</br>
					<div class="pc">
						<p class="p1">주소</p>
						<p class="p2 after">대구광역시 남구</p>
						<p class="p1">사업자등록번호</p>
						<p class="p2 after">000-00-00000</p>
						<p class="p1">대표자</p>
						<p class="p2">홍 길 동</p>
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
						<p class="p1">대표자</p>
						<p class="p2">홍 길 동</p>
					</div>
					</br>
					<p class="p1">통신판매업신고번호</p>
					<p class="p2">남구</p>
					<p style="color: #BDC0C5; font-size: 14px; font-weight: 400;">Copyright ⓒ 2023 communications</p>
				</div>
			</footer>
		</div>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="/portfolio/works/manager/assets/libs/jquery/jquery.min.js"></script>
<script src="/portfolio/works/manager/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- apexcharts -->
<script src="/portfolio/works/manager/assets/libs/apexcharts/apexcharts.min.js"></script>

<!-- Initialize Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src='/portfolio/works/manager/assets/js/jquery.waypoints.min.js'></script>
<script src='/portfolio/works/manager/assets/js/jquery.counterup.min.js'></script>
<script>

	jQuery(document).ready(function( $ ) {
	   
		 $('.odd').counterUp({
			delay: 10,
			time: 1000
		});
	});
	

	var swiper = new Swiper(".mySwiper", {
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
        observer: true,
        observeParents: true,
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		autoplay: {
		  delay: 10000,
		  disableOnInteraction: false,
		},
		pagination: {
		  el: ".swiper-pagination",
		  clickable: true,
		},
		/* breakpoints: {
            1280: {
                slidesPerView: 3,
                slidesPerGroup: 3,
            },
            768: {
                slidesPerView: 1,
                slidesPerGroup: 1,
           }
        } */
	});


	var swiper3 = new Swiper(".mySwiper3", {
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
        observer: true,
        observeParents: true,
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		autoplay: {
		  delay: 5000,
		  disableOnInteraction: false,
		},
		pagination: {
		  el: ".swiper-pagination2",
		  clickable: true,
		},
		/* breakpoints: {
            1280: {
                slidesPerView: 3,
                slidesPerGroup: 3,
            },
            768: {
                slidesPerView: 1,
                slidesPerGroup: 1,
           }
        } */
	});


	var swiper2 = new Swiper(".mySwiper2", {
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
		/* slidesPerView: 3,
        slidesPerGroup: 1, */
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

	var swiper4 = new Swiper(".mySwiper4", {
        allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
		/* slidesPerView: 3,
        slidesPerGroup: 1, */
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
		  nextEl: ".swiper-button-next2",
		  prevEl: ".swiper-button-prev2",
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

function popupOpen() {
	$('#popup').show();
}
function popupClose() {
	$('#popup').hide();
}

$(document).scroll(function() {
    var scrollTop = $(this).scrollTop();
    if(scrollTop > 500) {
        $('#counter .mySwiper3').addClass('animate');
    } else {
        $('#counter .mySwiper3').removeClass('animate');
    }

   /* if(scrollTop > 1200) {
        $('.contents ul').addClass('animate');
    } else {
        $('.contents ul').removeClass('animate');
    }

    if(scrollTop > 2000) {
        $('.invest ul').addClass('animate');
    } else {
        $('.invest ul').removeClass('animate');
    }*/
});
</script>