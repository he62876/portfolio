<?php

/* if(!isset($_SESSION['lv'])) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/login.php'>";
	exit;
} */
 
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/works/pickme/common.php');


// $photo_cnt = $pdo->single("SELECT count(*) FROM kiosk_cnt ", $param);
// 
// $expert_cnt = $pdo->single("SELECT count(*) FROM user_info WHERE state = 1 AND user_tp = 2", $param);
// 
// $expert_cate = $pdo->query("SELECT * FROM code_info WHERE majr = 1 AND minr > 0 AND use_yn = 1", $param);
// $expert_list = $pdo->query("SELECT * FROM user_info WHERE state = 1 AND user_tp = 2 ORDER BY reg_date DESC", $param);
// 
// $qna_list = $pdo->query("SELECT *, a.category as category, a.reg_date as reg_date FROM qna_info a LEFT OUTER JOIN user_info b ON a.user_no = b.user_no WHERE a.qna_tp = 1 AND a.state = 1 ORDER BY a.reg_date DESC LIMIT 4", $param);
// $qna_cnt = $pdo->single("SELECT count(*) FROM qna_info a LEFT OUTER JOIN user_info b ON a.user_no = b.user_no WHERE a.qna_tp = 1 AND a.state = 1", $param);
?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- plugin css -->
    <link href="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link rel="stylesheet" href="/portfolio/bootstrap/css/bootstrap.min.css">
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


    <!-- style-->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style_w.css?ver=1">
	<link rel="shortcut icon" href="/img/money.ico">


    <title>AI 포토 방명록 픽미</title>
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
			<!--<div id="popup">
				<div>
				<img src="img/web/popup.svg"><p>어플에서</p>
				</div>
				<p style="margin-bottom: 30px;">편하게 정보를 볼 수 있어요</p>
				<a style="background: #001E5E; border-color:  #001E5E;; color: #fff;">어플다운로드</a>
				<a style="cursor: pointer;" onclick="popupClose();">괜찮아요</a>
			</div>-->
			<a href="http://pf.kakao.com/_wZvVn/chat" class="talk"><img src="/img/web/talk.png"></a>
			<div id="mobile_menu">
				<div class="mobile_menu_header">
					<!--<img src="/img/mb_logo.png">-->
					<div></div>
					<button onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';" style="background: transparent;"><img style="width: 20px;" src="img/web/close.png"></button>
				</div>
				<ul>
					<li><a class="s-core" href="#home" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">홈</a></li>
					<li><a class="s-core" href="#connect" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">만들어진 연결</a></li>
					<li><a class="s-core" href="#function" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">주요기능</a></li>
					<li><a class="s-core" href="#portfolio" onclick="document.all.mobile_menu.style.display = 'none'; document.all.html.style.overflow = 'scroll';">포트폴리오</a></li>
					<li><a href="/admin">관리자페이지</a></li>
				</ul>
			</div>
			<div id="index">
				<div class="header">
					<ul class="pc">
						<li><a href="#home"><img src="/img/web/logo2.svg"></a></li>
						<li><a href="#connect">만들어진 연결</a></li>
						<li><a href="#function">주요기능</a></li>
						<li><a href="#portfolio">포트폴리오</a></li>
						<li><a href="/admin" style="padding: 10px 27px 13px 27px; border: 2px solid #fff; border-radius: 3px;">관리자페이지</a></li>
					</ul>
					<div id="mb_header" class="mb">
						<img src="/img/web/logo2.svg">
						<button onclick="document.all.mobile_menu.style.display = 'block'; document.all.html.style.overflow = 'hidden';" style="background: transparent;"><img src="img/web/menu_btn.png" class="mb"></button>
					</div>
				</div>
				<div id="home" class="swiper mySwiper">
					<!--<div class="swiper-pagination"></div>-->
					<div class="swiper-wrapper">
						<div class="swiper-slide" style="background: url('img/bg1.png'); background-size: cover; background-position: center;">
							<div class="p_box">
								<p class="white sub_title" style="font-size: 25px; font-weight: bold;">우리의 가치</p>
								<p class="white title pc" style="line-height: 1.2;"><span>표정</span>을 읽고, <span>마음</span>을 연결합니다</p>
								<p class="white title mb" style="line-height: 1.2;"><span>표정</span>을 읽고,</br><span>마음</span>을 연결합니다</p>
								<p class="white sub_title pc">픽미는 얼굴 표정 인식 기술을 통해 사람들의 감정을 이해하고</br>이를 바탕으로 더욱 인간적인 소통을 가능하게 합니다</p>
								<p class="white sub_title mb">픽미는 얼굴 표정 인식 기술을 통해</br>사람들의 감정을 이해하고</br>이를 바탕으로 더욱 인간적인</br>소통을 가능하게 합니다</p>
							</div>
						</div>
						<div class="swiper-slide" style="background: url('img/bg2.png'); background-size: cover; background-position: center;">
							<div class="p_box">
								<p class="white sub_title" style="font-size: 25px; font-weight: bold;">우리의 가치</p>
								<p class="white title pc" style="line-height: 1.2;"><span>순간</span>을 읽고, <span>추억</span>을 연결합니다</p>
								<p class="white title mb" style="line-height: 1.2;"><span>순간</span>을 읽고,</br><span>추억</span>을 연결합니다</p>
								<p class="white sub_title pc">소중한 만남의 순간을 기록하고, 사진과 데이터를 연결하여 </br>잊지 못할 추억을 선사합니다</p>
								<p class="white sub_title mb">소중한 만남의 순간을 기록하고,</br>사진과 데이터를 연결하여 </br>잊지 못할 추억을 선사합니다</p>
							</div>
						</div>
						<div class="swiper-slide" style="background: url('img/bg3.png'); background-size: cover; background-position: center;">
							<div class="p_box">
								<p class="white sub_title" style="font-size: 25px; font-weight: bold;">우리의 가치</p>
								<p class="white title pc" style="line-height: 1.2;"><span>만남</span>을 연결하고, <span>경험</span>을 확장합니다</p>
								<p class="white title mb" style="line-height: 1.2;"><span>만남</span>을 연결하고,</br><span>경험</span>을 확장합니다</p>
								<p class="white sub_title pc">픽미는 단순한 기록을 넘어 사람과 사람,</br>대한민국 구석구석 세상을 연결하는 매개체 역할을 합니다</p>
								<p class="white sub_title mb">픽미는 단순한 기록을 넘어</br>사람과 사람,</br>대한민국 구석구석</br>세상을 연결하는</br>매개체 역할을 합니다</p>
							</div>
						</div>
					</div>
					<img src="img/web/scroll.svg" class="scroll">
				</div>
			</div>
			<div id="connect" style="text-align: center;">
				<p class="title white bold">만들어진 연결</p>
				<div class="counter">
					<p class="memory">Memories</br>Created</p>
					<!-- <p class="count odd"><?=number_format($photo_cnt)?></p> -->
					<p class="count odd"><?=number_format(1234)?></p>
				</div>
			</div>
			<div id="function">
				<div class="function_box">
					<ul class="mb">
						<li id="function1" class="on">AI필터</li>
						<li id="function2">참여유도</li>
						<li id="function3">연결소통</li>
					</ul>
					<div class="box_img">
						<div class="function function1" style="background: url('img/web/function_bg1.png'); background-size: cover; background-position: center;"></div>
						<div class="function function2" style="background: url('img/web/function_bg2.png'); background-size: cover; background-position: center; display: none;"></div>
						<div class="function function3" style="background: url('img/web/function_bg3.png'); background-size: cover; background-position: center; display: none;"></div>
					</div>
					<ul class="pc">
						<li id="function1" class="on">AI필터</li>
						<li id="function2">참여유도</li>
						<li id="function3">연결소통</li>
					</ul>
					<div class="function_info">
						<div class="function function1">
							<p class="function_title"><span>순간</span>을 특별하게,</br><span>추억</span>을 영원히</p>
							<p class="function_cont">AI 필터가 선사하는 마법 같은 변신!</br>
							평범한 사진도 특별하고 아름다운 예술 작품으로 만들어 드립니다.</br>
							소중한 추억을 더욱 빛나게 간직하세요.</p>
						</div>
						<div class="function function2" style="display: none;">
							<p class="function_title"><span>즐거움</span>을 더하고,</br><span>참여</span>를 유도하는 마법</p>
							<p class="function_cont">퀴즈, 게임, 경품 추첨 등 다양한 이벤트 기능으로</br>
							참여자들의 흥미를 자극하고 즐거움을 더합니다.</br>
							행사 분위기를 더욱 활기차게 만들고 적극적인 참여를</br>
							유도하여 성공적인 행사를 만들어 드립니다.</p>
						</div>
						<div class="function function3" style="display: none;">
							<p class="function_title"><span>연결</span>과 공유,</br><span>소통</span>의 새로운 경험</p>
							<p class="function_cont">촬영된 사진을 공유하고 사람들과 소통하는</br>
							즐거움을 누리세요. AI 포토 방명록이 만들어내는</br>
							특별한 포토북은 소중한 추억을 간직합니다.</p>
						</div>
					</div>
				</div>
			</div>
			<div id="portfolio">
				<p class="title bold">포트폴리오</p>
				<div class="swiper mySwiper4 expert_list">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<img src="/img/web/portfolio1.png">
							<p class="name">경북대학교경영자포럼</br>총동창회</p>
							<p class="date">2024.10.21</p>
						</div>
						<div class="swiper-slide">
							<img src="/img/web/portfolio2.png">
							<p class="name">대구파티마병원</br>협력의료기관 초청의 날</p>
							<p class="date">2024.10.31</p>
						</div>
						<div class="swiper-slide">
							<img src="/img/web/portfolio3.png">
							<p class="name">성주군사랑나눔장터</p>
							<p class="date">2024.11.21</p>
						</div>
						<div class="swiper-slide">
							<a href="https://www.newsro.kr/article243/587497/">
							<img src="/img/web/portfolio4.png">
							<p class="name">고령은행나무숲</p>
							<p class="date">2024.11.16 ~ 24</p>
							</a>
						</div>
						<div class="swiper-slide">
							<img src="/img/web/portfolio5.png">
							<p class="name">한국관광공사</br>디지털주민증발급</p>
							<p class="date">2024.11.16 ~ 24</p>
						</div>
						<div class="swiper-slide">
							<a href="http://www.kkongjinews.com/news/view.php?idx=172239">
							<img src="/img/web/portfolio6.png">
							<p class="name">이창재작가</br>북콘서트</p>
							<p class="date">2024.12.8</p>
							</a>
						</div>
						<div class="swiper-slide">
							<a href="http://www.kkongjinews.com/news/view.php?idx=172239">
							<img src="/img/web/portfolio7.png">
							<p class="name">김천고 송설</br>정기총회 및 송년의 밤</p>
							<p class="date">2024.12.12</p>
							</a>
						</div>
					</div>
				</div>
				<div class="navigation">
					<div class="swiper-button-prev2"></div>
					<div class="swiper-button-next2"></div>
				</div>
			</div>
			<footer>
				<div class="content-page">
					<div class="footer_box">
						<div class="footer_box">
							<img src="/img/web/logo2.svg" style="opacity: 0.42;">
							<div>
								<a style="cursor:pointer; color: #7F7F7F; font-size: 13px; font-weight: 400;" onclick="window.open('/terms/terms2.php', 'PopupWin', 'top=500,right=200,width=850,height=500');" class="after">개인정보처리방침</a>
								<a style="cursor:pointer; color: #7F7F7F; font-size: 13px; font-weight: 400;" onclick="window.open('/terms/terms1.php', 'PopupWin', 'top=500,right=200,width=850,height=500');">서비스이용약관</a>
								</br></br>
								<p style="color: #BDC0C5; font-size: 13px; font-weight: 400;">EMS커뮤니케이션즈 I 대표자 문 명 화 I 사업자등록번호 213-82-04651</br>
									대구광역시 남구 명덕로 54 3층 (하나새마을금고 건물)</br>
									대리점문의 1544-8254 (평일 AM 9:00 ~ PM 6:00)</p>
								</br>
								<p style="color: #BDC0C5; font-size: 13px; font-weight: 400;">Copyright ⓒ 2024 EMS communications</p>
							</div>
						</div>
						<div>
							<select name="select" onChange="MM_jumpMenu('parent',this,0)">
	    						<option selected value="default">연관홈페이지</option>
								<option value="https://vision.ne.kr/">광고문의</option>
							</select>
							<a href='https://www.instagram.com/aipickme/profilecard/?igsh=Nm8wOWRsdXRpOXJh'><img src="/img/web/insta.svg"></a>
							<a href='http://pf.kakao.com/_wZvVn'><img style="width: 32px;" src="/img/web/kakao.svg"></a>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/portfolio/bootstrap/js/bootstrap.min.js"></script>

<!-- apexcharts -->
<!-- <script src="/assets/libs/apexcharts/apexcharts.min.js"></script> -->

<!-- Initialize Swiper -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<!-- <script src='/assets/js/jquery.waypoints.min.js'></script> -->
<script src='js/jquery.counterup.min.js'></script>
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

	$(document).scroll(function () {
		var scrollTop = $(this).scrollTop();
		if (scrollTop > 300) {
			$('.header').addClass('on');
		} else {
			$('.header').removeClass('on');
		}
	});

	$('#function .function_box ul li').click(function (){
		$('#function .function_box ul li').removeClass('on');
		$(this).addClass('on');

		var num = $(this).attr('id');
		//alert(num);
		$('.function').hide();
		$('.'+num).show();
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

function MM_jumpMenu(targ,selObj,restore){ //v3.0

	if(selObj.options[selObj.selectedIndex].value != "default"){
		if(selObj.options[selObj.selectedIndex].target == "_blank"){
			window.open(selObj.options[selObj.selectedIndex].value,"new","");
		}else{
			eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
		}
		if (restore) selObj.selectedIndex=0;
	}
}
</script>