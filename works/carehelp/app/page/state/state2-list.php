<?php
include('../../lib/header.php');
include('../../../common.php');

$param = null;
$keyword = $_POST['keyword'];
//설정한 지역 값 가져와서 검색하기
function unicode_decode($str) {
	return json_decode(sprintf('"%s"', $str));
}

$areas=explode(',',unicode_decode( str_replace('%' , '\\', $_COOKIE['area1'])));//지역값 배열
$areas_string = unicode_decode( str_replace('%' , '\\', $_COOKIE['area1']));//지역값 스트링 

$where = '';

if($keyword != null) {
	$where = " AND patient_cont LIKE '%".$keyword."%' ";
}

if($grade == 2) {
	$work = $pdo->query("SELECT *, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.user_no = ".$_SESSION['user_no']." AND a.state = 2 AND b.state = 2 ", $param);
	//$work_cnt = $pdo->single("SELECT count(*) FROM pay_info WHERE user_no = ".$_SESSION['user_no']." AND state = 2 ", $param);



	if($work != null) {
		foreach($work as $w) {
		$where .= " AND NOT(DATE_FORMAT(CONCAT(hire_sdate,' ',hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') <  '".$w['edate']."' AND DATE_FORMAT(CONCAT(hire_edate,' ',hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s') > '".$w['sdate']."')";
		
		}
		//echo $where;
	}
}

if(strlen($areas_string)>0){
	$sql = "SELECT * FROM hire_info WHERE '".implode(' ',$areas)."' LIKE CONCAT('%',SUBSTRING_INDEX(hire_addr, ' ', 1),'%') AND user_grade = 1 AND end_date >= NOW() AND use_yn = 1 AND state = 1 ".$where." ORDER BY end_date ASC, reg_date DESC";
}
else{
	$sql = "SELECT * FROM hire_info WHERE end_date >= NOW() AND user_grade = 1 AND state = 1 AND use_yn = 1 ".$where." ORDER BY end_date ASC, reg_date DESC";
}
$list_data = $pdo->query($sql, $param);

$sql = "SELECT * FROM code_info WHERE majr = 5 AND minr != 0 AND use_yn = 1";
$area_list = $pdo->query($sql, $param);

$banr = $pdo->query("SELECT * FROM banner_info WHERE use_yn = 1 AND grade".$grade." = 1 AND s_date <= CURDATE() AND e_date >= CURDATE() ORDER BY banner_order ASC");
$popup = $pdo->query("SELECT * FROM popup_info WHERE use_yn = 1 AND grade".$grade." = 1 AND s_date <= CURDATE() AND e_date >= CURDATE() ORDER BY popup_order ASC");

$user = $pdo->row("SELECT * FROM user_info WHERE user_no = ".$_SESSION['user_no']);

$left = '';
$where1 = '';

if($grade == 1) {
	$left = ' LEFT OUTER JOIN hire_info b ON a.etc_no = b.hire_no ';
	$where1 = ' AND b.end_date >= CURDATE() ';
}
if($grade == 2) {
	$where1 = " AND a.reg_date BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW() ";
}
if($grade == 3) {
	$left = ' LEFT OUTER JOIN hire_info b ON a.etc_no = b.hire_no ';
	$where1 = " AND ((a.alim_tp = 7 AND  b.end_date >= CURDATE()) OR (a.alim_tp != 7  AND a.reg_date BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW()))";
}

$alim = $pdo->query("SELECT * FROM alim_info a ".$left." WHERE a.user_no = ".$_SESSION['user_no'].$where1." AND a.read_yn = 0", $param);


?>
<style>
body{
    background:#F8F8F8;
}

.state_form {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.state_form input[type='text'] {
    width: 79%;
}
.state_form button {
    width: 20%;
	min-width: 70px;
}

.date_state {
    margin-bottom: 2px;
}
.swiper {
	width: 100%;
	height: 100%;
}

.swiper-slide {
	text-align: center;
	font-size: 18px;
	background: #fff;

	/* Center slide text vertically */
	display: -webkit-box;
	display: -ms-flexbox;
	display: -webkit-flex;
	display: flex;
	-webkit-box-pack: center;
	-ms-flex-pack: center;
	-webkit-justify-content: center;
	justify-content: center;
	-webkit-box-align: center;
	-ms-flex-align: center;
	-webkit-align-items: center;
	align-items: center;
}

.swiper-slide img {
	display: block;
	width: 100%;
	height: 100%;
	object-fit: fill;
}

.alim {
	position: relative;
}
.alim_yn {
	position: absolute;
	width: 10px; height: 10px;
	background: #3478F6;
	border-radius: 100%;
	top:-5px; right: -5px;
}

.popup_form10 {
	display: block;
}
</style>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<div class="content_wrap">
    <div class="content_page">
        <div class="h-wrap">
            <div><a href=""><img src="/img/logo_b.svg" alt=""></a></div>
            <div style="text-align:right"><a href="/app/page/mypage/alim-list.php" class="alim"><img src="/img/alim_b.svg" alt="" style="width: 45%;""><div class="alim_yn" style="<?=$alim == null ? "display:none":""?>"></div></a></div>
        </div>
        <?php if($grade != 1) { ?>
        <div class="banr" style="padding-bottom: 0;background: rgba(81, 86, 190, 0.25);">
            <div style="padding-bottom: <?=$banr == null ? 31:""?>%;">
				<div class="swiper mySwiper" style="border-radius: 15px;">
					<div class="swiper-wrapper">
						<?php foreach($banr as $b) { ?>
						<div class="swiper-slide">
							<a href="chat:<?=$b['link_url']?>"><img src="/upload/banr/<?=$b['banner_path']?>"></a>
						</div>
						<?php } ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
        </div>
        <?php } ?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" name='selType'>
            <div class="state_form">
                <input type="text" name="keyword" id='SearchForm' placeholder="진단정보를 검색하세요" value="<?=$keyword?>">
                <button onclick="Search_Page(1);">검색</button>
            </div>
            <div style="margin-bottom: 20px;">
				<button onclick="openForm1();" type="button" class="popup_btn">지역선택</button>
				<?php
					foreach($areas as $area) {
						if(mb_strlen($area, 'utf-8') == 2) {	?>
						<p style="display: inline-block; vertical-align: middle;<?=$area != null? 'background:#72A4FF; line-height: 35px; border-radius: 35px; width: 60px; text-align: center; font-size: 18px; font-weight: 500; color: #fff;':''?>"><?=$area?></p>
				<?php	}} ?>
			</div>
            <div class="popup_form popup_form1">
                <div class="area_form">
                    <div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;">
                        <input type="checkbox" onclick='getCheckboxDel()' id="area0"><label for="area0">전국</label>
						<?php foreach($area_list as $d) { ?>
						<input type="checkbox" id="area<?=$d['minr']?>" class="area_chk" value='<?=$d['name']?>,<?=$d['etc']?>' onclick='getCheckboxValue(event)' <?php if (in_array($d['name'],$areas)) echo 'checked="checked"'; ?> ><label for="area<?=$d['minr']?>" ><?=$d['name']?></label>
						<?php } ?>
                    </div>
                    <div class="btn_box d-flex justify-content-between">
                        <button onclick="closeForm();" type="button" style="width: 33%; background: #000; border-bottom-left-radius:15px;">닫기</button>
                        <button onclick="set_area();" type="button" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">설정하기</button>
                    </div>
                </div>
            </div>
        </form>
        <ul class="state_list">
			<?php if (!$list_data) {?>
					<div style="text-align: center;"><img src="/img/nodata.png" alt="" style="width:40%;margin-top: 25%;"></div>
			<?php } ?>
			<?php foreach($list_data as $d) { 
				$endDate = strtotime($d['end_date']);
				$today = strtotime(date('Y-m-d H:i:s'));
				$sdate = $d['hire_sdate']." ".$d['hire_stime'].":00:00";
				$edate = $d['hire_edate']." ".$d['hire_etime'].":59:59";

				$diff = $endDate - $today;

				//$day = floor($diff/(24*3600));
				//$diff = $diff-($day*(24*3600));
				$hours = floor($diff/3600);
				
				//echo $day."일 ".$hours."시간"; ?>
            <li>
                <a href="state-info.php?hire_no=<?=$d['hire_no']?>">
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p><img src="/img/male.svg" style="width: 20px; margin-right: 5px;"><?=$d['patient_sex'] == 1 ? "남성":"여성"?>/<?=$d['patient_age']?>세/<?=$d['patient_weight']?>kg</p>
                        <div style="text-align: right;">
                            <img src="/img/arrow.svg" alt="">
                        </div>
                    </div>
                    <p style="color:#3478F6; font-size: 1.1rem; font-weight: bold;"><img src="/img/clock.svg" style="width: 20px; margin-right: 5px;"><?="공고 ".$hours."시간 남음"?><img src="/img/view.svg" style="width: 20px; margin-right: 5px; margin-left: 20px;"><?="조회수 ".$d['hit']?></p>
                    <table class="info_table">
                        <tr>
                            <th>간병위치</th>
							<?php
							if($grade == 2) { 
								if($d['addr_type'] == 1) {
									$hospital = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".$d['hire_addr']."'", $param);
								}
								if($d['addr_type'] == 2) {
									$str = $d['hire_addr'];
									$addr = explode(' ',$str);
									$cnt = count($addr);

									for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
										${'hire_addr'.$d['hire_no']} .= $addr[$i]." ";
									}
								}
							} else {
								$str = $d['hire_addr'];
								$addr = explode(' ',$str);
								$cnt = count($addr);

								for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
									${'hire_addr'.$d['hire_no']} .= $addr[$i]." ";
								}
							}
							?>
                            <td><?=$d['addr_type'] == 2 || $grade == 3 ? ${'hire_addr'.$d['hire_no']}:$hospital?></td>
                        </tr>
                        <tr>
							<?php
								$days = (strtotime($d['hire_edate']) - strtotime($d['hire_sdate'])) / 86400;
							?>
                            <th>간병기간</th>
                            <td><p style="color: #3478F6; font-size: 20px; font-weight: 500;">[<?=$days + 1?>일]</p><?=$d['hire_sdate']?> <?=$d['hire_stime']?>:00 ~</br><?=$d['hire_edate']?></td>
                        </tr>
                        <tr>
							<?php
								$hire_time = $pdo->single("SELECT name FROM code_info WHERE majr = 10 AND minr = ".$d['hire_time'], $param);
							?>
                            <th>간병시간</th>
                            <td><?=$hire_time?></td>
                        </tr>
                        <tr>
                            <th>진단정보</th>
                            <td><?=$d['patient_cont'] == null ? '-':$d['patient_cont']?></td>
                        </tr>
                        <!-- <tr>
                            <th>평균견적</th>
							<?php
								$sdate = $d['hire_sdate']." ".$d['hire_stime'].":00:00";
								$edate = $d['hire_edate']." ".$d['hire_etime'].":00:00";

								$pay_list = $pdo->query("SELECT *, a.user_no as user_no, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':00:00'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 2 AND b.state = 2
								AND '".$edate."' > DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') AND '".$sdate."'< DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':00:00'), '%Y-%m-%d %H:%i:%s')", $param);

								if($pay_list != null) {
									foreach($pay_list as $w) {
										//${'cnt_where'.$d['hire_no']} .= " AND NOT('".$sdate."' <  '".$w['edate']."' AND '".$edate."' > '".$w['sdate']."')";
										${'user_no'.$d['hire_no']} .= " AND a.user_no != ".$w['user_no'];
										
									}
									//echo ${'cnt_where'.$d['hire_no']};
									//echo ${'user_no'.$d['hire_no']};
								}

								$sql = "SELECT count(*) as cnt, SUM(a.pay) as sum FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 1 AND a.hire_no = ".$d['hire_no'].${'user_no'.$d['hire_no']};
								$avg = $pdo->row($sql, $param);
							?>
                            <td style="color:#3478F6; font-weight: bold;">일급 / <?=$avg['cnt'] == 0 ? "150,000":number_format($avg['sum']/$avg['cnt'])?>원</td>
                        </tr> -->
                    </table>
                </a>
				<?php if($grade == 2) {
					$sql = "SELECT * FROM pay_info WHERE state = 1 AND hire_no = ".$d['hire_no']." AND user_no = ".$_SESSION['user_no'];
					$data = $pdo->query($sql, $param);

					$agcy_state = $pdo->single("SELECT agency_state FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param);
					if(!$data) {	?>
				<?php if($agcy_state == 1) { ?>
				<div class="d-flex justify-content-between">
				<a href="share://나이팅게일 간병 요청 공유하기%0ahttps://carehelper.co.kr/app/page/state/download.php?hire_no=<?=$d['hire_no']?>" class="star_link" style="width: 19%; background: #fff; border: solid 1px #DEDEDE; color: #000;">공유</a>
                <button onclick="openForm2(<?=$d['hire_no']?>, <?=$d['user_grade']?>);" class="star_link" style="width: 79%; ">예상 간병비 제안</button>
				</div>
				<?php } else { ?>
				<div class="d-flex justify-content-between">
				<a href="share://나이팅게일 간병 요청 공유하기%0ahttps://carehelper.co.kr/app/page/state/download.php?hire_no=<?=$d['hire_no']?>" class="star_link" style="width: 19%; background: #fff; border: solid 1px #DEDEDE; color: #000;">공유</a>
                <a href="/app/page/mypage/agency.php" class="star_link" style="width: 79%; ">예상 간병비 제안</a>
				</div>
				<?php } ?>
				<?php } else { ?>
				<a class="star_link" style="width: 100%; background: #fff; border: solid 1px #DEDEDE; color: #000;">신청 중</a>
				<?php }} ?>
				<?php if($grade == 3) { ?>
				<a href="share://나이팅게일 간병 요청 공유하기%0ahttps://carehelper.co.kr/app/page/state/download.php?hire_no=<?=$d['hire_no']?>" class="star_link" style="width: 100%; background: #fff; border: solid 1px #DEDEDE; color: #000;">공유</a>
				<?php } ?>
            </li>
			<?php 
				} ?>
			<div class="popup_form popup_form3" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 150px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">정말 삭제하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 100%; background: #000000; border-bottom-right-radius:15px;">닫기</button>
					</div>
				</div>
			</div>
			<div class="popup_form popup_form4" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 150px;">
						<div id="agree2" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;"><p id="want_pay" style="font-size: 22px;"></p>제안하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="payOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form5" style="z-index:55; ">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 400px;">
						<div style="width: 100%;text-align: center;"><img style="width: 80px;" src="/img/warnning.svg"></div>
						<div id="agree3" style="width: 100%;text-align: center;margin-top: 15px;font-weight: bold;font-size: 22px; color: #3478F6;">소속 협회에 가입해주세요!</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px;">협회에 가입 시 제안참여, 구인지원 등 다양한</br>서비스를 이용할 수 있습니다</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px; color:#455572; background: #F1F3F6; padding: 15px;">협회가 가입되어 있지 않은 경우</br>APP 가입신청을 해야 합니다</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 33%; background: #000000; border-bottom-left-radius:15px;">닫기</button>
						<a href="share://나이팅게일 친구초대하기" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">협회 공유하기</a>
						
					</div>
				</div>
			</div>
        </ul>
    </div>
    <form action="json.php" method="POST" class="popup_form popup_form2">
		<div class="hire_no"></div>
		<div class="user_grade"></div>
		<input type="hidden" name="mode" value="pay">
		<input type="hidden" name="type" value="1">
		<input type="hidden" name="user_no" value="<?=$_SESSION['user_no']?>">
		<input type="hidden" name="membership" value="<?=$user['membership']?>">
		<input type="hidden" name="ticket" value="<?=$user['ticket']?>">
        <div class="pay_form">
            <div class="content_page">
                <p class="content_title">예상 간병비 제안</p>
                <div class="state_form d-block">
                    <label for="" style="margin-bottom: 3px;">제안금액(일급)</label>
                    <input type="text" name="pay" id="pay" placeholder="금액을 입력해주세요" style="width: 100%"  onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
                <p class="content_text" style="color:#3478F6">간병비 제안은 보호자에게 참고용으로 전달됩니다.</br>예상 금액을 정확히 제시해주세요.</p>
            </div>
            <div class="btn_box d-flex justify-content-between">
                <button onclick="closeForm();" type="button" style="background: #000;">닫기</button>
                <button onclick="payInput();" type="button" style="background: #3478F6;">제안하기</button>
            </div>
        </div>
    </form>
	<?php if($popup != null && $grade != 1) { ?>
    <div class="popup_form popup_form10">
        <div class="pay_form">
			<div class="swiper mySwiper2" style="border-radius: 15px;">
				<div class="swiper-wrapper">
					<?php foreach($popup as $b) { ?>
					<div class="swiper-slide">
						<a href="chat:<?=$b['link_url']?>"><img src="/upload/popup/<?=$b['popup_path']?>"></a>
					</div>
					<?php } ?>
					<!--<div class="swiper-slide"><img src="/img/ex_banner.png"></div>
					<div class="swiper-slide"><img src="/img/ex_banner.png"></div>
					<div class="swiper-slide"><img src="/img/ex_banner.png"></div>-->
				</div>
				<div class="swiper-pagination2"></div>
			</div>
            <div class="btn_box d-flex justify-content-between">
                <button id="close" type="button" style="background: #fff; color: #000; width: 50%;">하루 그만 보기</button>
                <button onclick="closeForm();" type="button" style="background: #000; width: 50%;">닫기</button>
            </div>
        </div>
    </div>
	<?php } ?>
</div>
<?php
$menu = "pay";
include('../../lib/menu.php');
include('../../lib/footer.php');
?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
	var swiper = new Swiper(".mySwiper", {
		spaceBetween: 30,
		centeredSlides: true,
		//loop: true,
		autoplay: {
		  delay: 2500,
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
		  
	var swiper = new Swiper(".mySwiper2", {
		spaceBetween: 30,
		centeredSlides: true,
		//loop: true,
		pagination: {
		  el: ".swiper-pagination2",
		  clickable: true,
		},
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
	});

	let area = '';
	var arrValues = new Array(); 
	arrValues = <?php echo json_encode($areas)?>; 

    function openForm1() {
        $('.popup_form1').css('display', 'block');
    }

    function closeForm1() {
        $('.popup_form1').css('display', 'none');
    }
	//지역선택시 저장
	function getCheckboxValue(event)  {
		
		if(event.target.checked)  {
			arrValues.push(event.target.value);
		}else {
			for(let i=0; i<arrValues.length; i++){
				var areadata = event.target.value.split(',');
				for(let j=0; j<areadata.length; j++){
					if(arrValues[i]==areadata[j]){
						arrValues = arrValues.filter((element) => element !== areadata[j]);
					}
				}
			}
		}
	}
	//설정하기 시 쿠키 저장

	function getCheckboxDel() {
		$('.area_chk').prop('checked', false);
		arrValues = [];
	}

	$('.area_chk').click(function(){
		if($('.area_chk').is(':checked')) {
			$('#area0').prop('checked', false);
		}
	});

	function set_area(){
		setCookie("area1", arrValues, 86400);//하루동안저장
		$('.popup_form1').css('display', 'none');
		//새로고침 하면서 검색에 사용할것
		//location.reload();
		document.selType.submit();  
	}
</script>
<script>
	/*function myFunction() {
        var check = confirm("견적을 넣으시겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }

	}*/

	function payInput() {
		var pay = $("input[name='pay']").val();
		//alert이 단말기에 따라 안보일수 있으므로 다른것으로 교체해야 할지도...
		if(pay == "") { 
			document.getElementById('agree').innerHTML = '금액을 입력해주세요.';
			$('.popup_form3').css('display', 'block');
			return; 
		} else if(pay.length > 6) {
			document.getElementById('agree').innerHTML = '금액을 확인해주세요.';
			$('.popup_form3').css('display', 'block');
			return; 
		} else {
			$('#want_pay').html(pay.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'원으로');
			$('.popup_form4').css('display', 'block');
			return; 
		}
	}

	var isRun = false;
	function payOK() {
		//window.nightingale.showLoading('1');

		var hire_no = $("input[name='hire_no']").val();
		var user_no = $("input[name='user_no']").val();
		var type = $("input[name='type']").val();
		var pay = $("input[name='pay']").val();

		var membership = $("input[name='membership']").val();
		var ticket = $("input[name='ticket']").val();
	
		if(isRun == true) {
			return;
		}
		
		isRun = true;


		if(membership == 0 && ticket <= 0) {

			document.getElementById('agree').innerHTML = '제안이용권이 없습니다.';
			$('.popup_form3').css('display', 'block');
			$('.popup_form4').css('display', 'none');
			return; 

		} else {
			$.ajax({type: 'POST',
				url: 'json.php',
				data:"&mode=pay&hire_no="+hire_no+"&user_no="+user_no+"&pay="+pay+"&type="+type+"&membership="+membership+"&ticket="+ticket,
				dataType: 'json',
				cache: false,
				beforeSend: function() { },
				success: function(data) {
					try
					{
						//alert(data.resCode);
						if(data.resCode == 1){
							isRun  = false;
							//window.nightingale.showLoading('0');
							window.location.href = "state-list.php?type="+type;
						}
						else if(data.resCode == -2) {
							document.getElementById('agree').innerHTML = '모집 완료된 구인 요청입니다.';
							$('.popup_form3').css('display', 'block');
							$('.popup_form4').css('display', 'none');
							$('.popup_form2').css('display', 'none');
							return; 
						}
						else{
							window.location.href = "state-list.php?type="+type;
						}
					}
					catch(e)
					{
						console.log("error forward2 : " + e);
					}
				},
				error: function(data, status, err) {
					try{ console.log("error forward : " + data); alert(err); }
					catch(e){ console.log("error : " + e); alert('서버와의 통신이 실패했습니다.'); }
					return false;
				},
				complete: function() { },
				xhr: /*@cc_on false && @*/window.XMLHttpRequest ?
					function() { return new window.XMLHttpRequest(); } :
					function() { try { return new window.ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} }
			});
		}
	}


    function openForm1() {
        $('.popup_form1').css('display', 'block');
    }
    function openForm5() {
        $('.popup_form5').css('display', 'block');
    }


    function openForm2(no, grade) {
        $('.popup_form2').css('display', 'block');
		$('.hire_no').html('<input type="hidden" name="hire_no" value='+no+'>');
		$('.user_grade').html('<input type="hidden" name="user_grade" value='+grade+'>');
    }

    function closeForm() {
        $('.popup_form').css('display', 'none');
    }

    function closeForm3() {
        $('.popup_form3').css('display', 'none');
        $('.popup_form4').css('display', 'none');
        $('.popup_form5').css('display', 'none');
    }
</script>
<script>
function Search_Page(n)
{
	if(n == "#") return;
	$("#SearchForm").submit();//GetRow_item();
}

</script>
<script>
    // 쿠키 가져오기
    var getCookie = function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
        }
        return "";
    }

    

    var couponClose = function(){
        setCookie("close","Y",1);   //기간( ex. 1은 하루, 7은 일주일)
        $('.popup_form10').css('display', 'none');
    }
    
    $(document).ready(function(){
        var cookiedata = document.cookie;
        if(cookiedata.indexOf("close=Y")<0){
            $(".popup_form10").show();
        }else{
            $(".popup_form10").hide();
        }
        $("#close").click(function(){
            couponClose();
        });
    });
</script>