<?php
$page = 'index';
include('lib/header.php');
include('../../common.php');

$param = null;

$user_cnt = $pdo->query("SELECT count(*) FROM carehelp_user_info WHERE user_grade = 2 AND state = 1")->fetchColumn();
// $hire_cnt = $pdo->query("SELECT count(*) FROM hire_info WHERE use_yn = 1")->fetchColumn();

$sql = "SELECT * FROM carehelp_user_info WHERE user_grade = 2 AND state = 1 ORDER BY reg_date DESC LIMIT 5";
$list_data = $pdo->query($sql, $param);

$profile1 = array('profile_1_1.png', 'profile_1_2.png', 'profile_1_3.png');
$img1 = time()%count($profile1);

$profile2 = array('profile_2_1.png', 'profile_2_2.png', 'profile_2_3.png');
$img2 = time()%count($profile2);
?>
<div id="index">
	<div class="swiper mySwiper">
		<div class="index_link" style="">
			<!--<div class="text">서비스 시작하기</div>-->
			<div class="link">
				<a href="https://play.google.com/store/apps/details?id=com.emscnc.nightingale.user&pcampaignid=web_share" target="_blank">
					<img src="/portfolio/works/carehelp/web/img/google.png">
					안드로이드 다운로드
				</a>
				<a href="https://apps.apple.com/kr/app/%EA%B0%84%EB%B3%91-%EB%82%98%EC%9D%B4%ED%8C%85%EA%B2%8C%EC%9D%BC-%EA%B0%84%EB%B3%91%EC%8B%A0%EC%B2%AD-%EA%B0%84%EB%B3%91%EC%82%AC-%EA%B0%84%EB%B3%91%ED%98%91%ED%9A%8C-%EA%B5%AC%EC%9D%B8%EA%B5%AC%EC%A7%81/id6476480122">
					<img src="/portfolio/works/carehelp/web/img/apple.png">
					애플 다운로드
				</a>
			</div>
		</div>
		<div class="swiper-pagination"></div>
		<div class="swiper-wrapper">
			<div class="bg bg1 swiper-slide" style="background: url('/portfolio/works/carehelp/web/img/bg1.png'); background-size: cover; background-position: center;">
				<p class="content">간편하고 빠른 비교견적 간병서비스</p>
				<p class="content pc" style="font-size: 50px; margin-bottom: 70px;">전국 어디서나 <span style="font-weight: 900">간병나이팅게일</span></p>
				<p class="content mb" style="font-size: 45px; margin-bottom: 70px;">전국 어디서나</br><span style="font-weight: 900">간병나이팅게일</span></p>
			</div>
			<div class="bg bg1 swiper-slide" style="background: url('/portfolio/works/carehelp/web/img/bg1_2.png'); background-size: cover; background-position: center;">
				<p class="content">검증된 후기와 프로필 열람</p>
				<p class="content pc" style="font-size: 50px; margin-bottom: 70px;">믿을 수 있는 <span style="font-weight: 900">간병인 매칭</span></p>
				<p class="content mb" style="font-size: 45px; margin-bottom: 70px;">믿을 수 있는</br><span style="font-weight: 900">간병인 매칭</span></p>
			</div>
			<div class="bg bg1 swiper-slide" style="background: url('/portfolio/works/carehelp/web/img/bg1_3.png'); background-size: cover; background-position: 85% center;">
				<p class="content">경제적이고 합리적인 간병비</p>
				<p class="content pc" style="font-size: 50px; margin-bottom: 70px;">간병이 필요할 땐 <span style="font-weight: 900">간병나이팅게일</span></p>
				<p class="content mb" style="font-size: 45px; margin-bottom: 70px;">간병이 필요할 땐</br><span style="font-weight: 900">간병나이팅게일</span></p>
			</div>
		</div>
	</div>
	<div class="count" style="background: #F1F3F6;">
		<img class="pc" src="/portfolio/works/carehelp/web/img/leaf1.png" style="margin-top:-60px;">
		<img class="leaf leaf1 mb" src="/portfolio/works/carehelp/web/img/leaf1.png" style="margin-right: -30px; ">
		<p class="title title1 pc">합리적인 간병비 비교견적</p>
		<p class="title title1 mb">합리적인 간병비</br>비교견적</p>
		<img class="pc" src="/portfolio/works/carehelp/web/img/leaf2.png" style="margin-top:-60px;">
		<img class="leaf leaf2 mb" src="/portfolio/works/carehelp/web/img/leaf2.png" style="margin-left: -30px; ">
		<p class="content pc">전국 병원 어디서나 내 마음에 딱 맞는 간병사를 만나보세요!</p>
		<p class="content mb">전국 병원 어디서나 내 마음에 딱 맞는</br>간병사를 만나보세요!</p>
		<div class="shadow_box">
			<div>
				<p>활동 간병사</p>
				<p class="counter"><span class="odd"><?=$user_cnt?></span>명</p>
			</div>
			<div>
				<p>누적 견적</p>
				<p class="counter"><span class="odd"><?=$hire_cnt?></span>건</p>
			</div>
		</div>
		<div class=" mobile_list" style="background: url('/portfolio/works/carehelp/web/img/mobile_list.png'); background-size: cover;">
			<div class="swiper mySwiper2">
				<div class="swiper-wrapper">
					<?php foreach($list_data as $d) {
						$cnt = $pdo->query("SELECT count(*) as cnt FROM carehelp_comment_info WHERE state = 1 AND pay_no = ".$d['user_no'])->fetchColumn();
						$star = $pdo->query("SELECT sum(star) as sum FROM carehelp_comment_info WHERE state = 1 AND pay_no = ".$d['user_no'])->fetchColumn();
						// $sql = "SELECT count(*) as cnt, sum(star) as sum FROM comment_info WHERE state = 1 AND pay_no = ".$d['user_no'];
						// $star = $pdo->query($sql, $param); ?>
					<div class="swiper-slide">
						
						<div class="d-flex justify-content-start align-items-center w-100">
							<div class="profile_img_on">
								<div class="profile_img">
									<?php if($d['img_url'] == null) { ?>
									<img src="/portfolio/works/carehelp/img/<?=$d['user_sex'] == 1 ? $profile1[$img1]:$profile2[$img2]?>" alt="">
									<?php } else { ?>
									<img src="/portfolio/works/carehelp/upload/<?=$d['img_url']?>" alt="">
									<?php } ?>
								</div>
							</div>
							<div class="profile_info">
								<span><?=$d['user_grade'] == 2 ? "간병사":"협회"?></span>
								<div class="profile_name">
									<strong><?=$d['user_name']?></strong>
									<?php if($d['membership'] == 1) { ?>
									<img src="/portfolio/works/carehelp/img/membership.svg" alt="">
									<?php } ?>
								</div>
								<div class="profile_star">
									<div>
										<img src="/portfolio/works/carehelp/img/star.svg" alt="">
										<p><?=$cnt == 0 ? "0.0" : round(($star/$cnt),2)?></p>
									</div>
									<div>
										<img src="/portfolio/works/carehelp/img/comment.svg" alt="">
										<p><?=$cnt?></p>
									</div>
								</div>
							</div>
						</div>
						<table class="info_table">
							<tr>
								<th>성별</th>
								<td><?=$d['user_sex'] == 1 ? "남성":"여성"?></td>
							</tr>
							<tr>
								<th>나이</th>
								<td><?=$d['user_old']?>세</td>
							</tr>
							<tr>
								<th>근무경력</th>
								<td><?=$d['career']?>년</td>
							</tr>
						</table>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="hire" style="background: #fff;">
		<p class="title title1 pc">간병나이팅게일은 편리합니다</p>
		<p class="title title1 mb">간병나이팅게일은</br>편리합니다</p>
		<p class="content pc">간병나이팅게일만의 기능들을 소개합니다</p>
		<p class="content mb">간병나이팅게일만의</br>기능들을 소개합니다</p>
		<div class="hire_box1">
			<div class="hire_box1_text">
				<img src="/portfolio/works/carehelp/web/img/mobile1.png">
				<p style="font-size: 45px; font-weight: bold; margin-bottom: 10px;">비교견적시스템</p>
				<p style="font-size: 20px; font-weight: 300;">더 이상 간병비로 스트레스 받지마세요!</br>
					비교견적으로 합리적인 가격으로</br>
					간병인을 찾아드립니다</p>
			</div>
			<p class="mb" style="font-size: 45px; font-weight: bold; margin-bottom: 10px;">비교견적시스템</p>
			<p class="mb" style="font-size: 20px; font-weight: 300; margin-bottom: 40px;">더 이상 간병비로 스트레스 받지마세요!</br>
				비교견적으로 합리적인 가격으로</br>
				간병인을 찾아드립니다</p>
			<p style="font-size: 20px; font-weight: 400;">● 프로필을 통해 믿을 수 있는 간병사인지 확인!</br>
				● 평점 후기를 통해 이용경험 확인가능</br>
				● 합리적인 가격으로 검증된 간병사 제공</p>
		</div>
		<div class="hire_box2">
			<div class="hire_box2_text">
				<img src="/portfolio/works/carehelp/web/img/mobile2.png">
				<p style="font-size: 45px; font-weight: bold; margin-bottom: 10px;">간병요청</p>
				<p style="font-size: 20px; font-weight: 300;">간편하고 빠른 간병요청</br>
					자세한 내용을 적어주시면 간병사들이</br>
					직접 내용을 확인하고 즉시 신청합니다</p>
			</div>
			<p class="mb" style="font-size: 45px; font-weight: bold; margin-bottom: 10px;">간병요청</p>
			<p class="mb" style="font-size: 20px; font-weight: 300; margin-bottom: 40px;">간편하고 빠른 간병요청</br>
				직접 내용을 확인하고,</br>
				견적을 제안합니다</p>
			<p style="font-size: 20px; font-weight: 400;">● 병원이 아닌 집에서도 이용가능!</br>
				● 환자의 상태를 섬세하게 체크</br>
				● 안심 할 수 있는 매칭서비스 제공</p>
		</div>
	</div>
	<div class="bg bg2" style="background: url('/portfolio/works/carehelp/web/img/bg2.png'); background-size: cover; background-position: center;">
		<p class="title title2 pc">간병나이팅게일은 특별합니다</p>
		<p class="title title2 mb">간병나이팅게일은</br>특별합니다</p>
		<p class="content pc">차별적이고 만족도 높은 서비스를 제공합니다</p>
		<p class="content mb">차별적이고 만족도 높은</br>서비스를 제공합니다</p>
		<ul>
			<li>
				<img src="/portfolio/works/carehelp/web/img/table1_1.png">
				<div>
					<p class="li_title">무료견적</p>
					<p>여러 곳 전화할 필요 없이</br>
					간편하게 신청할 수 있습니다</p>
				</div>
			</li>
			<li>
				<img src="/portfolio/works/carehelp/web/img/table1_2.png">
				<div>
					<p class="li_title">비교견적 서비스</p>
					<p>다양한 간병사의 제안을</br>
					받을 수 있습니다</p>
				</div>
			</li>
			<li>
				<img src="/portfolio/works/carehelp/web/img/table1_3.png">
				<div>
					<p class="li_title">검증된 간병사</p>
					<p>직접 촬영한 자격증과 프로필로</br>
					믿을 수 있는 간병사 선정가능</p>
				</div>
			</li>
			<li>
				<img src="/portfolio/works/carehelp/web/img/table1_4.png">
				<div>
					<p class="li_title">후기확인</p>
					<p>같은 보호자들이 체험하고 등록한</br>
					간병사들의 후기를 볼 수 있습니다</p>
				</div>
			</li>
		</ul>
	</div>
</div>
<?php include('lib/footer.php'); ?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src='/portfolio/works/carehelp/app/js/jquery.waypoints.min.js'></script>
<script src='/portfolio/works/carehelp/app/js/jquery.counterup.min.js'></script>
<!-- Initialize Swiper -->
<script>
	jQuery(document).ready(function( $ ) {
	   
		 $('.odd').counterUp({
			delay: 10,
			time: 1000
		});
	});

	var swiper = new Swiper(".mySwiper", {
		effect : 'fade',
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
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
	});

	var swiper2 = new Swiper(".mySwiper2", {
		spaceBetween: 15,
		centeredSlides: true,
		loop: true,
		speed: 5000,
		autoplay: {
		  delay: 0,
		  disableOnInteraction: false,
		},
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
	});

</script>