<?php
include('lib/header.php');
include('common.php');

$param = null;
$user_id = $_GET['id'] == null ? "":$_GET['id'];
if($user_id != "") {
	$data = $pdo->row("SELECT *, AES_DECRYPT(UNHEX(user_tel),KEY) as user_tel FROM user_info WHERE user_tp = 2 AND state = 1 AND user_id = '".$user_id."'", $param);
	$expert_no = $data['user_no'];
	$v_num = $pdo->single("SELECT asign_050_num FROM asign_050_info WHERE num_state = 1 AND user_seq = ".$expert_no, $param);
	$type = $pdo->single("SELECT card_tp FROM user_info WHERE user_tp = 2 AND state = 1 AND user_id LIKE '".$user_id."'", $param);
} else {
	$data = $pdo->row("SELECT *, AES_DECRYPT(UNHEX(user_tel),KEY) as user_tel FROM user_info WHERE user_no = ".$_SESSION['no'], $param);
	$type = $_GET['type'];
}

$category = $pdo->single("SELECT name FROM code_info WHERE majr = 1 AND minr = ".$data['category'], $param);

$get_code = get_kakao_geocode($data['address']);
	
$xml = simplexml_load_string($get_code); 
$latitude = (float)$xml->documents->y;
$longitude = (float)$xml->documents->x;
//print_r($latitude); 

$bg = array(1=>"card_bg2", 2=>"card_bg4", 3=>"card_bg5");
$bar = array(1=>"card_bar2", 2=>"card_bar3", 3=>"card_bar3");
$logo = array(1=>"card_icon2", 2=>"card_icon2", 3=>"card_icon2");
$name = array(1=>"#fff", 2=>"#fff", 3=>"#000");
$cate = array(1=>"#fff", 2=>"#fff", 3=>"#000");

$thead = array(1=>"#A5E3FF", 2=>"#fff", 3=>"#1B76DF");
$tbody = array(1=>"#fff", 2=>"#fff", 3=>"#000");


$box_border = array(1=>"#A5E3FF", 2=>"rgba(255,255,255,0.1)", 3=>"rgba(255,255,255,0.1)");
$box_back = array(1=>"#F8FDFF", 2=>"rgba(255,255,255,0.3)", 3=>"rgba(255,255,255,0.3)");
$box_text = array(1=>"#47748A", 2=>"#fff", 3=>"#fff");

$addr_icon = array(1=>"#1577EE", 2=>"#fff", 3=>"#fff");
$addr_text = array(1=>"#000", 2=>"#fff", 3=>"#fff");
?>
<style>
#wrap {
	padding-bottom: 0;
}

#card_info {
	min-height: 100vh;
	background: url('img/<?=$bg[$type]?>.png');
	background-size: cover;
}

.card_info {
	padding: 20px 5%;
}

.logo {
	float: right;
}

.profile_box {
	<?php if($type == 3) { ?>
	background: #fff;
	padding: 40px 25px 25px 25px;
	border-radius: 10px;
	margin-top: 20px;
	position: relative;
	<?php } ?>
}
.profile {
	<?php if($type == 1) { ?>
	text-align: center;
	<?php }
	if ($type == 2) { ?>
	display: flex;
	align-items: center;
	<?php } ?>
	<?php if($type != 3) { ?>
	margin-top: 50px;
	<?php } ?>
}
.qna_img {
	display: inline-block;
	width: 100px;
	height: 100px;
	<?php if($type == 1) { ?>
	margin-bottom: 15px;
	<?php }
	if ($type == 2) { ?>
	margin-right: 20px;
	<?php }
	if ($type == 3) { ?>
	position: absolute;
	border: 10px solid #fff;
	box-sizing: content-box;
	right: 0;
	top: -55px;
	<?php } ?>
}
.profile .user_cate {
	color: <?=$cate[$type]?>;
	font-size: 14px;
	margin-bottom: 2px;
}
.profile .user_nm {
	color: <?=$name[$type]?>;
	font-size: 22px;
	font-weight: bold;
}

table {
	margin-top: <?=$type == 2 ? 40:20?>px;
	margin-bottom: 20px;
}
table th, table td {
	text-align: left;
	vertical-align: middle;
	padding: 2.5px;
}
table th {
	width: 100px;
	color: <?=$thead[$type]?>;
	font-size: 12px;
}
table th svg {
	margin-right: 10px;
}
table td {
	color: <?=$tbody[$type]?>;
	font-size: 14px;
}
.emailCopy {
	display: inline-block;
	border: 1px solid #D5DADE;
	border-radius: 2px;
	background: #fff;
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 5px 10px;
	margin-left: 5px;
}

.box_title {
	text-align: center;
	font-size: 20px;
	font-weight: bold;
	color: <?=$addr_text[$type]?>;
	background: url('img/<?=$bar[$type]?>.svg');
	background-size: 100%;
	background-position: center;
	margin: 20px 0 10px 0;
}

.intro {
	border: 1px solid <?=$box_border[$type]?>;
	background: <?=$box_back[$type]?>;
	color: <?=$box_text[$type]?>;
	border-radius: 5px;
	text-align: center;
	padding: 15px;
	color: <?=$box_text[$type]?>;
	font-size: 14px;
	font-weight: 500;
}

.address > * {
	display: inline-block;
	vertical-align: middle;
}
.address > p {
	font-size: 14px;
	font-weight: 500;
	margin-left: 5px;
}

#map {
	margin: 10px 0;
}
.btn_box {
	display: flex;
	justify-content: space-between;
	margin: 0;
}
.btn_box a {
	display: block;
	font-size: 16px;
	font-weight: bold;
	color: #000;
	background: #fff;
	border-radius: 5px;
	border: 1px solid #D5DADE;
}

<?php if($type == 1) {?>
.url_info {
	display: flex;
	justify-content: space-between;
}
.url_info div > * {
	display: inline-block;
	veritbal-align: middle;
}
.url_info div p {
	color: #1577EE;
	font-size: 12px;
	font-weight: 400;
	margin-left: 5px;
}
.url_info a {
	display: block;
	border: 1px solid #D5DADE;
	border-radius: 2px;
	background: #fff;
	font-size: 10px;
	font-weight: bold;
	color: #000;
	padding: 5px 10px;
	margin: 0.5px 0;
}
<?php } ?>

<?php if($type != 1) {?>
.url_box a {
	display: inline-block;
}
.url_box a:not(:last-child) {
	margin-right: 5px;
}
<?php } ?>
</style>
		<div class="popup_form popup_form1">
			<div class="area_form">
				<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
					<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 18px;">서비스 이용약관에 동의해주세요.</div>
					<button onclick="closeForm1();" type="button" style="width: 100%; font-weight: bold; color: #fff; background: #00A8FF; border-radius:5px;">닫기</button>
				</div>
			</div>
		</div>
		<div id="card_info">
			<div class="card_info">
				<!--<img src="/img/<?=$logo[$type]?>.png" class="logo">-->
				<div style="margin-top: <?=$type == 3 ? 40:0?>px">
					<?php if($type == 3) { ?>
					<div style="height: 30px;" class="url_box">
						<?php if($data['url_blog'] != null) { ?>
						<a href="<?=$data['url_blog']?>"><img src="/img/url_blog.svg"></a>
						<?php } ?>
						<?php if($data['url_instar'] != null) { ?>
						<a href="<?=$data['url_instar']?>"><img src="/img/url_instar.svg"></a>
						<?php } ?>
						<?php if($data['url_youtube'] != null) { ?>
						<a href="<?=$data['url_youtube']?>"><img src="/img/url_youtube.svg"></a>
						<?php } ?>
						<?php if($data['url_kakao'] != null) { ?>
						<a href="<?=$data['url_kakao']?>"><img src="/img/url_kakao.svg"></a>
						<?php } ?>
						<?php if($data['url_etc'] != null) { ?>
						<a href="<?=$data['url_etc']?>"><img src="/img/url_etc.svg"></a>
						<?php } ?>
					</div>
					<?php } ?>
					<div class="profile_box">
						<?php if($type == 3) { ?>
						<div class="round_img qna_img" style="background: <?=$data['img_url'] == null ? "url('/img/profile.png')":"url('/upload/profile/".$data['img_url']."')"?>; background-size: cover; background-position: center;"></div>
						<?php } ?>
						<div class="profile">
							<?php if($type != 3) { ?>
							<div class="round_img qna_img" style="background: <?=$data['img_url'] == null ? "url('/img/profile.png')":"url('/upload/profile/".$data['img_url']."')"?>; background-size: cover; background-position: center;"></div>
							<?php } ?>
							<div>
								<p class="user_cate"><?=$category?> 전문가</p>
								<p class="user_nm"><?=$data['user_nm']?> <span style="font-weight: 400; font-size: 14px;"><?=$data['rank']?></span></p>
								<?php if($type == 2 && ($data['url_blog'] != null || $data['url_instar'] != null || $data['url_youtube'] != null || $data['url_kakao'] != null || $data['url_etc'] != null)) { ?>
								<div style="margin-top: 10px;" class="url_box">
									<?php if($data['url_blog'] != null) { ?>
									<a href="<?=$data['url_blog']?>"><img src="/img/url_blog.svg"></a>
									<?php } ?>
									<?php if($data['url_instar'] != null) { ?>
									<a href="<?=$data['url_instar']?>"><img src="/img/url_instar.svg"></a>
									<?php } ?>
									<?php if($data['url_youtube'] != null) { ?>
									<a href="<?=$data['url_youtube']?>"><img src="/img/url_youtube.svg"></a>
									<?php } ?>
									<?php if($data['url_kakao'] != null) { ?>
									<a href="<?=$data['url_kakao']?>"><img src="/img/url_kakao.svg"></a>
									<?php } ?>
									<?php if($data['url_etc'] != null) { ?>
									<a href="<?=$data['url_etc']?>"><img src="/img/url_etc.svg"></a>
									<?php } ?>
								</div>
								<?php } ?>
							</div>
						</div>
						<table>
							<tr>
								<th>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30646" data-name="그룹 30646" transform="translate(-3369 -5728)">
										<rect id="사각형_24224" data-name="사각형 24224" width="18" height="18" transform="translate(3369 5728)" fill="none"/>
										<path id="패스_9429" data-name="패스 9429" d="M9.592,0H2.257A2.257,2.257,0,0,0,0,2.257V15.743A2.257,2.257,0,0,0,2.257,18H9.592a2.256,2.256,0,0,0,2.256-2.257V2.257A2.256,2.256,0,0,0,9.592,0M7.372,16.758H4.477a.445.445,0,0,1,0-.891H7.372a.445.445,0,1,1,0,.891m3.4-1.824H1.082V2.311h9.686Z" transform="translate(3372 5728)" fill="<?=$thead[$type]?>"/>
									  </g>
									</svg>
									연락처
								</th>
								<td><?=$v_num?></td>
							</tr>
							<?php if($data['main_number'] != null) { ?>
							<tr>
								<th>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30529" data-name="그룹 30529" transform="translate(-21 -349)">
										<g id="그룹_30489" data-name="그룹 30489" transform="translate(4243.518 -6013.984)">
										  <path id="패스_9396" data-name="패스 9396" d="M52.811,13.542,51.483,14.87l-1.727-1.726-2.7-2.7,1.329-1.328-3.631-3.63s-1.921,2.259-1.763,4.54a2.263,2.263,0,0,0,.664,1.443l3.889,3.888,2.915,2.915a2.269,2.269,0,0,0,1.444.664c2.282.158,4.54-1.764,4.54-1.764Z" transform="translate(-4262.73 6360.269)" fill="<?=$thead[$type]?>"/>
										  <path id="패스_9397" data-name="패스 9397" d="M51.437,18.984q-.159,0-.32-.011a3.039,3.039,0,0,1-1.936-.888l-6.8-6.8a3.035,3.035,0,0,1-.888-1.936c-.177-2.565,1.858-4.99,1.945-5.092a.773.773,0,0,1,.557-.272.761.761,0,0,1,.577.226L48.2,7.84a.772.772,0,0,1,0,1.092l-.782.781,3.333,3.333.781-.782a.772.772,0,0,1,1.092,0l3.629,3.629a.771.771,0,0,1-.046,1.134,8.506,8.506,0,0,1-4.772,1.956M44.119,5.942a5.83,5.83,0,0,0-1.086,3.3,1.494,1.494,0,0,0,.44.95l6.8,6.8a1.494,1.494,0,0,0,.95.44,5.95,5.95,0,0,0,3.3-1.084L52.08,13.9l-.782.782a.773.773,0,0,1-1.092,0L45.782,10.26a.772.772,0,0,1,0-1.092l.781-.782Z" transform="translate(-4262 6361)" fill="<?=$thead[$type]?>"/>
										</g>
										<rect id="사각형_24224" data-name="사각형 24224" width="18" height="18" transform="translate(21 349)" fill="none"/>
									  </g>
									</svg>
									대표전화
								</th>
								<td><?=$data['main_number']?></td>
							</tr>
							<?php } ?>
							<tr>
								<th>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30530" data-name="그룹 30530" transform="translate(-22 -371)">
										<path id="패스_9398" data-name="패스 9398" d="M1.665,2.676l7.3,5.42,7.369-5.125v9.156H1.665Zm1.939-.8H14.772L9.034,5.9ZM0,14H18V0H0Z" transform="translate(22 373)" fill="<?=$thead[$type]?>"/>
										<rect id="사각형_24225" data-name="사각형 24225" width="18" height="18" transform="translate(22 371)" fill="none"/>
									  </g>
									</svg>
									이메일
								</th>
								<td>
									<p id="copy_email" style="display:none;"><?=$data['email']?></p>
									<?=$data['email']?> <a class="emailCopy">복사</a>
								</td>
							</tr>
						</table>
						<div class="btn_box" id="save_card">
							<a href="tel:<?=$v_num?>" style="color: #000;">
								<svg id="그룹_30414" data-name="그룹 30414" xmlns="http://www.w3.org/2000/svg" width="16.582" height="19.647" viewBox="0 0 16.582 19.647">
								  <g id="그룹_26624" data-name="그룹 26624" transform="translate(0 6.829)">
									<path id="패스_1003" data-name="패스 1003" d="M30.4,62.241q.057.511.154,1.056c.606-1.758,2.648-5.464,9.158-5.845V54.613c-7.24.549-8.955,5.964-9.312,7.628" transform="translate(-23.135 -51.73)" fill="#1b76df"/>
									<path id="패스_1004" data-name="패스 1004" d="M30.138,53.066c.357-1.664,2.071-7.079,9.312-7.628V42.555s-10.43.45-9.312,10.511" transform="translate(-22.868 -42.555)" fill="#001e5e"/>
									<path id="패스_1005" data-name="패스 1005" d="M31.05,72.33c.072.4.16.82.269,1.252a9.991,9.991,0,0,1,8.889-4.538V66.485c-6.509.381-8.552,4.086-9.158,5.845" transform="translate(-23.625 -60.763)" fill="#00a8ff"/>
									<path id="패스_1006" data-name="패스 1006" d="M7.387,45.859C4.626,42.755,0,42.555,0,42.555v8.281a9.46,9.46,0,0,1,5.771,1.471,10.279,10.279,0,0,1,1.616-6.447" transform="translate(0 -42.555)" fill="#001e5e"/>
								  </g>
								  <path id="패스_1007" data-name="패스 1007" d="M12.836,5.619,9.83,6.694a8.29,8.29,0,0,1,4.243,2.389H14.1a8.537,8.537,0,0,1,4.715-2.493,2.2,2.2,0,0,1-.08-.374l-3.07-.655,0,.011-.149-.141c.083-.343.237-1.014.3-1.518a.776.776,0,0,0,.623-.668c.089-.579-.267-.435-.579-.133a2.357,2.357,0,0,0,.475-1.128c.12-.68-.312-1.737-.981-1.27-.17-.622-.5-.841-1.245-.645-.846.223-1.8.905-1.8,1.662a3.1,3.1,0,0,0,.356,1.38c-.312-.3-.668-.446-.579.133a.777.777,0,0,0,.623.668c.066.525.232,1.239.312,1.566l-.008-.008Z" transform="translate(-5.701 0)" fill="#001e5e"/>
								</svg>
								상담하기
							</a>
						</div>
					</div>
					<div class="box">
						<div class="box_title">소개글</div>
						<div class="intro">
							<?=nl2br($data['intro'])?>
						</div>
					</div>
					<?php if($type == 1) { ?>
					<?php if($data['url_blog'] != null || $data['url_instar'] != null || $data['url_youtube'] != null || $data['url_kakao'] != null || $data['url_etc'] != null) { ?>
					<div class="box">
						<div class="box_title">채널</div>
						<div class="intro">
							<?php if($data['url_blog'] != null) { ?>
							<div class="url_info">
								<div>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30505" data-name="그룹 30505" transform="translate(0 -0.15)">
										<rect id="사각형_24218" data-name="사각형 24218" width="18" height="18" rx="2" transform="translate(0 0.15)" fill="#03c75a"/>
										<path id="패스_9415" data-name="패스 9415" d="M2.866,11.828v-.686a3.29,3.29,0,0,0,2.382,1.009s3.936-.11,3.956-3.916c0,0,.53-4.449-3.714-4.845,0,0-1.95-.019-2.624,1.13V0S.178.036,0,.007V11.828ZM4.608,6.223a1.65,1.65,0,1,1-1.649,1.65,1.65,1.65,0,0,1,1.649-1.65" transform="translate(4.5 2.7)" fill="#fff"/>
									  </g>
									</svg>
									<p>네이버블로그</p>
								</div>
								<a href="<?=$data['url_blog']?>">보기</a>
							</div>
							<?php } ?>
							<?php if($data['url_instar'] != null) { ?>
							<div class="url_info">
								<div>
									<svg id="그룹_30501" data-name="그룹 30501" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 18 18">
									  <defs>
										<radialGradient id="radial-gradient" cx="0.293" cy="1.077" r="1.325" gradientTransform="matrix(1, 0, 0, -1, 0, 12.771)" gradientUnits="objectBoundingBox">
										  <stop offset="0" stop-color="#ffd87a"/>
										  <stop offset="0.097" stop-color="#ffd87a"/>
										  <stop offset="0.154" stop-color="#fccb76"/>
										  <stop offset="0.259" stop-color="#f4aa6d"/>
										  <stop offset="0.399" stop-color="#e7745d"/>
										  <stop offset="0.449" stop-color="#e36058"/>
										  <stop offset="0.679" stop-color="#cb3592"/>
										  <stop offset="1" stop-color="#6567ae"/>
										</radialGradient>
									  </defs>
									  <rect id="사각형_24221" data-name="사각형 24221" width="18" height="18" rx="2" fill="url(#radial-gradient)"/>
									  <g id="그룹_30500" data-name="그룹 30500" transform="translate(2.25 2.25)">
										<path id="패스_9406" data-name="패스 9406" d="M31.378,264.483H26.245a4.121,4.121,0,0,0-4.122,4.122v5.133a4.121,4.121,0,0,0,4.122,4.121h5.133a4.121,4.121,0,0,0,4.121-4.121V268.6a4.121,4.121,0,0,0-4.121-4.122m2.837,8.762a3.33,3.33,0,0,1-3.33,3.33H26.737a3.33,3.33,0,0,1-3.33-3.33V269.1a3.331,3.331,0,0,1,3.33-3.33h4.149a3.331,3.331,0,0,1,3.33,3.33Z" transform="translate(-22.123 -264.483)" fill="#fff"/>
										<path id="패스_9407" data-name="패스 9407" d="M59.582,296.839a3.523,3.523,0,1,0,3.523,3.523,3.523,3.523,0,0,0-3.523-3.523m0,5.643a2.12,2.12,0,1,1,2.12-2.12,2.12,2.12,0,0,1-2.12,2.12" transform="translate(-52.714 -293.651)" fill="#fff"/>
										<path id="패스_9408" data-name="패스 9408" d="M117.8,288.079a.9.9,0,1,1-.9-.9.9.9,0,0,1,.9.9" transform="translate(-106.758 -284.946)" fill="#fff"/>
									  </g>
									</svg>
									<p>인스타그램</p>
								</div>
								<a href="<?=$data['url_instar']?>">보기</a>
							</div>
							<?php } ?>
							<?php if($data['url_youtube'] != null) { ?>
							<div class="url_info">
								<div>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30571" data-name="그룹 30571" transform="translate(-3819 -6314)">
										<g id="그룹_30506" data-name="그룹 30506" transform="translate(3819 6316)">
										  <path id="패스_9403" data-name="패스 9403" d="M17.624,998.538a2.34,2.34,0,0,0-1.592-1.7c-1.4-.4-7.032-.4-7.032-.4s-5.629,0-7.032.4a2.339,2.339,0,0,0-1.591,1.7,28.841,28.841,0,0,0,0,9.284,2.34,2.34,0,0,0,1.591,1.705c1.4.4,7.032.4,7.032.4s5.629,0,7.032-.4a2.34,2.34,0,0,0,1.592-1.705A26.846,26.846,0,0,0,18,1003.18a26.843,26.843,0,0,0-.376-4.642" transform="translate(0 -996.43)" fill="red"/>
										  <path id="패스_9404" data-name="패스 9404" d="M72,1037.831l4.676-2.7-4.676-2.7Z" transform="translate(-65.302 -1028.381)" fill="#fff"/>
										</g>
										<rect id="사각형_24232" data-name="사각형 24232" width="18" height="18" transform="translate(3819 6314)" fill="none"/>
									  </g>
									</svg>
									<p>유튜브</p>
								</div>
								<a href="<?=$data['url_youtube']?>">보기</a>
							</div>
							<?php } ?>
							<?php if($data['url_kakao'] != null) { ?>
							<div class="url_info">
								<div>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30567" data-name="그룹 30567" transform="translate(-3841 -6320)">
										<rect id="사각형_24232" data-name="사각형 24232" width="18" height="18" transform="translate(3841 6320)" fill="none"/>
										<g id="그룹_30566" data-name="그룹 30566" transform="translate(-48 -11)">
										  <path id="패스_9425" data-name="패스 9425" d="M24.46,23.136a.876.876,0,0,0,.722-.315,1.222,1.222,0,0,0,.265-.8V15.611H26.7a1.37,1.37,0,0,1,.946.337,1.277,1.277,0,0,1,.407.914,1.353,1.353,0,0,1-.363.993,1.48,1.48,0,0,1-1.1.387h-.645v1.719h1.174A2.8,2.8,0,0,0,29.41,19a3.239,3.239,0,0,0,.692-2.148,3,3,0,0,0-.113-.807,3.2,3.2,0,0,0-.334-.769,3.039,3.039,0,0,0-.5-.637,3.193,3.193,0,0,0-2.31-.756H24.679a1.121,1.121,0,0,0-1.224,1.224v6.916a1.182,1.182,0,0,0,.274.8.907.907,0,0,0,.731.317" transform="translate(3872.632 6320.72)" fill="#ffe400"/>
										  <path id="패스_9426" data-name="패스 9426" d="M14.012,30.646H12.278a1.039,1.039,0,0,0-.692.233.755.755,0,0,0-.276.619.771.771,0,0,0,.272.633,1.049,1.049,0,0,0,.7.233h1.734Z" transform="translate(3881.625 6308.308)" fill="#ffe400"/>
										  <path id="패스_9427" data-name="패스 9427" d="M3.293,17.926a13.611,13.611,0,0,0,2.773-1.172c.418-.241.663-.38.835-.468a8.021,8.021,0,0,0,1.187.1H8.23a8.09,8.09,0,0,0,8.089-8.089v-.2A8.09,8.09,0,0,0,8.23,0H8.089A8.089,8.089,0,0,0,0,8.089v.2A8.088,8.088,0,0,0,4.239,15.41l0,.008,0,0a3.225,3.225,0,0,1-.55,1.155c-.344.462-.776,1-.975,1.212a.252.252,0,0,0-.074.125c.006.1.216.125.65.013m2.794-13.1a1.212,1.212,0,0,1,.322-.9,1.218,1.218,0,0,1,.9-.324H9.474a3.194,3.194,0,0,1,2.31.756,3.052,3.052,0,0,1,.5.637,3.209,3.209,0,0,1,.334.769,3,3,0,0,1,.113.808,3.239,3.239,0,0,1-.692,2.148,2.8,2.8,0,0,1-2.291.961H8.578V7.963h.645a1.48,1.48,0,0,0,1.1-.387,1.353,1.353,0,0,0,.363-.993,1.278,1.278,0,0,0-.407-.915,1.371,1.371,0,0,0-.946-.337H8.079v6.412a1.222,1.222,0,0,1-.265.8.877.877,0,0,1-.722.315.908.908,0,0,1-.731-.317,1.183,1.183,0,0,1-.274-.8ZM3.9,9.671a1.049,1.049,0,0,1-.7-.233.771.771,0,0,1-.271-.633.755.755,0,0,1,.276-.619A1.039,1.039,0,0,1,3.9,7.954H5.637V9.671Z" transform="translate(3890 6331)" fill="#2f2023"/>
										  <path id="패스_9428" data-name="패스 9428" d="M5.9,16.744A7.473,7.473,0,0,1,1.98,10.168V9.979A7.475,7.475,0,0,1,9.455,2.5h.13a7.519,7.519,0,0,1,1.44.14A7.455,7.455,0,0,0,9.092,2.39H8.961A7.475,7.475,0,0,0,1.487,9.865v.189A7.474,7.474,0,0,0,5.4,16.63Z" transform="translate(3888.899 6329.23)" fill="#966a73"/>
										  <rect id="사각형_24233" data-name="사각형 24233" width="9.538" height="14.353" transform="translate(3890.386 6331.62)" fill="none"/>
										  <rect id="사각형_24234" data-name="사각형 24234" width="16.319" height="18" transform="translate(3890 6331)" fill="none"/>
										</g>
									  </g>
									</svg>
									<p>플러스친구</p>
								</div>
								<a href="<?=$data['url_kakao']?>">보기</a>
							</div>
							<?php } ?>
							<?php if($data['url_etc'] != null) { ?>
							<div class="url_info">
								<div>
									<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
									  <g id="그룹_30531" data-name="그룹 30531" transform="translate(-22 -397)">
										<g id="그룹_30496" data-name="그룹 30496" transform="translate(22 402.586) rotate(-45)">
										  <path id="패스_9399" data-name="패스 9399" d="M3.95,0A3.954,3.954,0,0,0,0,3.95V7.022A3.922,3.922,0,0,0,.417,8.778a3.968,3.968,0,0,0,1.472,1.607,3.918,3.918,0,0,0,2.061.587,3.871,3.871,0,0,0,1.1-.159,1.629,1.629,0,0,0-.834-1.74,2.125,2.125,0,0,1-.265.018A2.074,2.074,0,0,1,1.889,7.171c0-.05-.008-.1-.008-.148V3.95a2.069,2.069,0,1,1,4.138,0V6q.252.154.489.33A6.516,6.516,0,0,1,7.865,7.515,3.769,3.769,0,0,0,7.9,7.022V3.95A3.955,3.955,0,0,0,3.95,0" fill="#1577ee"/>
										  <path id="패스_9400" data-name="패스 9400" d="M6.012.587A3.921,3.921,0,0,0,3.95,0,3.851,3.851,0,0,0,2.772.185a1.43,1.43,0,0,0,1.009,1.7c.056,0,.112-.007.169-.007A2.074,2.074,0,0,1,6.012,3.8c0,.049.007.1.007.149V7.023a2.069,2.069,0,0,1-4.138,0V5.208A6.482,6.482,0,0,1,.009,3.692C0,3.777,0,3.864,0,3.95V7.023a3.95,3.95,0,0,0,7.9,0V3.95a3.922,3.922,0,0,0-.417-1.756A3.972,3.972,0,0,0,6.012.587" transform="translate(0 6.583)" fill="#1577ee"/>
										</g>
										<rect id="사각형_24226" data-name="사각형 24226" width="18" height="18" transform="translate(22 397)" fill="none"/>
									  </g>
									</svg>
									<p>홈페이지</p>
								</div>
								<a href="<?=$data['url_etc']?>">보기</a>
							</div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>
					<?php } ?>
					<div class="box">
						<div class="box_title">주소</div>
						<div class="address">
							<svg xmlns="http://www.w3.org/2000/svg" width="21.011" height="24.33" viewBox="0 0 21.011 24.33">
							  <g id="그룹_30484" data-name="그룹 30484" transform="translate(-210 -579)">
								<path id="패스_9394" data-name="패스 9394" d="M21.011,15.989a5.023,5.023,0,1,1-5.023-5.023,5.023,5.023,0,0,1,5.023,5.023" transform="translate(204.517 573.517)" fill="<?=$addr_icon[$type]?>"/>
								<path id="패스_9395" data-name="패스 9395" d="M10.505,24.33a.751.751,0,0,1-.583-.278L6.966,20.392a10.505,10.505,0,1,1,7.079,0l-2.956,3.659a.751.751,0,0,1-.583.278M8.089,19.4l2.416,2.991,2.429-3.006a.734.734,0,0,1,.406-.331,9.005,9.005,0,1,0-5.671,0,.749.749,0,0,1,.419.347" transform="translate(210 579)" fill="<?=$addr_icon[$type]?>"/>
							  </g>
							</svg>
							<p style="color: <?=$addr_text[$type]?>;"><?=$data['address']?> <?=$data['address1']?></p>
							<div id="map" style="width:100%;height: 200px;"></div>
							<div class="btn_box">
								<p id="copy_id" style="display:none;"><?=$data['address']." ".$data['address1']?></p>
								<a style="color: #000;" class="copyAlbumId">주소복사</a>
								<a style="color: #000;" href="https://map.kakao.com/link/to/<?=$data['address']?>,<?=$latitude?>,<?=$longitude?>">길찾기</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php
include('lib/footer.php');
?>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=b8d830f5b17a78c8e58a54b5fa638d50"></script>
<script type="text/javascript" src="/assets/js/vcard1.js"></script>

<script>var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new kakao.maps.LatLng(<?=$latitude?>, <?=$longitude?>), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };

// 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
var map = new kakao.maps.Map(mapContainer, mapOption); 

// 커스텀 오버레이에 표시할 내용입니다     
// HTML 문자열 또는 Dom Element 입니다 
var content = "<div style='margin-top: 30px; background: rgba(0,0,0,.4); padding: 4px 8px;'><p style='color: #fff; font-size: 12px;'><?=$data['address']?> <?=$data['address1']?></p></div>";

// 커스텀 오버레이가 표시될 위치입니다 
var position = new kakao.maps.LatLng(<?=$latitude?>, <?=$longitude?>);  

// 커스텀 오버레이를 생성합니다
var customOverlay = new kakao.maps.CustomOverlay({
    position: position,
    content: content   
});

// 커스텀 오버레이를 지도에 표시합니다
customOverlay.setMap(map);

var imageSrc = '/img/map_marker.png', // 마커이미지의 주소입니다    
    imageSize = new kakao.maps.Size(30, 45), // 마커이미지의 크기입니다
    imageOption = {offset: new kakao.maps.Point(15, 45)}; // 마커이미지의 옵션입니다. 마커의 좌표와 일치시킬 이미지 안에서의 좌표를 설정합니다.

// 마커가 표시될 위치입니다 
var markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption),
    markerPosition  = new kakao.maps.LatLng(<?=$latitude?>, <?=$longitude?>); 

// 마커를 생성합니다
var marker = new kakao.maps.Marker({
    position: markerPosition,
	image: markerImage 
});

// 마커가 지도 위에 표시되도록 설정합니다
marker.setMap(map);


// Without helper methods
/*
				
구분	명칭	설명	사용법
VERSION	Version	버전	VERSION:3.0
FN	    Formatted Name	이름의 형태	FN:홍 길동
N	    Name	이름, 성과 이름은 ;로 구분	N:홍;길동
ORG	    Organization	회사 및 조직명	ORG:주)모람씨앤티;기술연구소
TITLE	title	직함	TITLE:수석

TEL	    Telephone	전화번호
– WORK : 근무처
– HOME : 집
			 
– VOICE : 전화
– FAX :팩스	TEL;TYPE=WORK,VOICE:+82 (02) 123-4567
TEL;TYPE=WORK,FAX:+82 (0505) 111-2222
TEL;TYPE=HOME,VOICE:+82(404) 555-1212
TEL;TYPE=CELL,VOICE:+82(010) 9999-1234
			 
ADR	    Address	주소
– WORK : 근무처
– HOME : 집	ADR;TYPE=WORK:;;광장동 248-2 대광빌딩 3층;광진구;서울;143-805;대한민국

EMAIL	Email	이메일	EMAIL;TYPE=PREF,INTERNET:kdhong@moramcnt.com
URL	    URL	인터넷 주소	URL;WORK:http://www.moramcnt.com/
NOTE	note	메모	부가정보
			
*/
var <?=$data['user_id']?> = vCard.create(vCard.Version.FOUR)
//<?=$data['user_id']?>.add(vCard.Entry.NAME, "<?=$data['user_nm']?>;<?=$data['user_nm']?>;;")
<?=$data['user_id']?>.add(vCard.Entry.FORMATTEDNAME, "<?=$data['user_nm']?>")
<?=$data['user_id']?>.add(vCard.Entry.TITLE, "<?=$data['rank']?>")
<?=$data['user_id']?>.add(vCard.Entry.PHONE, "<?=$data['user_tel']?>", vCard.Type.CELL)
<?=$data['user_id']?>.add(vCard.Entry.EMAIL, "<?=$data['email']?>", vCard.Type.WORK)
<?=$data['user_id']?>.add(vCard.Entry.EMAIL, "<?=$data['email']?>", vCard.Type.HOME)
<?=$data['user_id']?>.add(vCard.Entry.ORGANIZATION, "<?=$data['user_nm']?>")
<?=$data['user_id']?>.add(vCard.Entry.ADDRESS, "<?=$data['address']?> <?=$data['address1']?>", vCard.Type.WORK)
//<?=$data['user_id']?>.add(vCard.Entry.URL, "http://john.doe")

var link = vCard.export(<?=$data['user_id']?>, "연락처 저장", false) // use parameter true to force download
document.getElementById("save_card").prepend(link)

//카카오 브라우저 닫기
var inappdeny_exec_vanillajs = (callback) => {
	if(document.readyState !== 'loading'){
		callback();
	}else{
		document.addEventListener('DOMContentLoaded', callback);
	} 
};
inappdeny_exec_vanillajs(() => { 
	/* Do things after DOM has fully loaded */ 
	function copytoclipboard(val){
		var t = document.createElement("textarea");
		document.body.appendChild(t);
		t.value = val;
		t.select();
		document.execCommand('copy');
		document.body.removeChild(t);
	};
	function inappbrowserout(){
		copytoclipboard(window.location.href);
		//alert('URL주소가 복사되었습니다.\n\nSafari가 열리면 주소창을 길게 터치한 뒤, "붙여놓기 및 이동"를 누르면 정상적으로 이용하실 수 있습니다.');
		location.href='x-web-search://?';
	};
		var useragt = navigator.userAgent.toLowerCase();
	var target_url = location.href;
	
	if(useragt.match(/kakaotalk/i)){
		
		//카카오톡 외부브라우저로 호출
		location.href = 'kakaotalk://web/openExternal?url='+encodeURIComponent(target_url);
		
	}else if(useragt.match(/line/i)){
		
		//라인 외부브라우저로 호출
		if(target_url.indexOf('?') !== -1){
			location.href = target_url+'&openExternalBrowser=1';
		}else{
			location.href = target_url+'?openExternalBrowser=1';
		}
		
	}else if(useragt.match(/inapp|naver|snapchat|wirtschaftswoche|thunderbird|instagram|everytimeapp|whatsApp|electron|wadiz|aliapp|zumapp|iphone(.*)whale|android(.*)whale|kakaostory|band|twitter|DaumApps|DaumDevice\/mobile|FB_IAB|FB4A|FBAN|FBIOS|FBSS|trill|SamsungBrowser\/[^1]/i)){
			
		//그외 다른 인앱들
		if(useragt.match(/iphone|ipad|ipod/i)){
				
			//아이폰은 강제로 사파리를 실행할 수 없다 ㅠㅠ
			//모바일대응뷰포트강제설정
			var mobile = document.createElement('meta');
			mobile.name = 'viewport';
			mobile.content = "width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui";
			document.getElementsByTagName('head')[0].appendChild(mobile);
			//노토산스폰트강제설정
			var fonts = document.createElement('link');
			fonts.href = 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap';
			document.getElementsByTagName('head')[0].appendChild(fonts);
			document.body.innerHTML = "<style>body{margin:0;padding:0;font-family: 'Noto Sans KR', sans-serif;overflow: hidden;height: 100%;}</style><h2 style='padding-top:50px; text-align:center;font-family: 'Noto Sans KR', sans-serif;'>인앱브라우저 호환문제로 인해<br />Safari로 접속해야합니다.</h2><article style='text-align:center; font-size:17px; word-break:keep-all;color:#999;'>아래 버튼을 눌러 Safari를 실행해주세요<br />Safari가 열리면, 주소창을 길게 터치한 뒤,<br />'붙여놓기 및 이동'을 누르면<br />정상적으로 이용할 수 있습니다.<br /><br /><button onclick='inappbrowserout();' style='min-width:180px;margin-top:10px;height:54px;font-weight: 700;background-color:#31408E;color:#fff;border-radius: 4px;font-size:17px;border:0;'>Safari로 열기</button></article><img style='width:70%;margin:50px 15% 0 15%' src='https://tistory3.daumcdn.net/tistory/1893869/skin/images/inappbrowserout.jpeg' />";
			
		}else{
			//안드로이드는 Chrome이 설치되어있음으로 강제로 스킴실행한다.
			//location.href='intent://'+target_url.replace(/https?:\/\//i,'')+'#Intent;scheme=http;package=com.android.chrome;end';
		}
	}
});

//주소복사
$('.copyAlbumId').click(function () {
	var copyText = document.getElementById("copy_id");//클립보드에 복사할 텍스트 가져옴
	var textArea = document.createElement("textarea");//textarea 생성
						  
	textArea.value = copyText.textContent;//textarea에 텍스트 입력
	document.body.appendChild(textArea);//body에 textarea 추가
							  
	textArea.select();//선택
	document.execCommand("Copy");//복사
	textArea.remove();//생성한 textarea 삭제
							  
	document.getElementById('agree').innerHTML = '복사되었습니다.';
	$('.popup_form1').css('display', 'block');
});

//이메일복사
$('.emailCopy').click(function () {
	var copyText = document.getElementById("copy_email");//클립보드에 복사할 텍스트 가져옴
	var textArea = document.createElement("textarea");//textarea 생성
						  
	textArea.value = copyText.textContent;//textarea에 텍스트 입력
	document.body.appendChild(textArea);//body에 textarea 추가
							  
	textArea.select();//선택
	document.execCommand("Copy");//복사
	textArea.remove();//생성한 textarea 삭제
							  
	document.getElementById('agree').innerHTML = '복사되었습니다.';
	$('.popup_form1').css('display', 'block');
});


function closeForm1() {
	$('.popup_form1').css('display', 'none');
}
</script>
