<?php
include('../../lib/header.php');
$title = $grade == 1 ? "간병요청하기":"구인요청하기";
include('../../lib/title.php');
include('../../../common.php');

$hire_no = $_GET['hire_no'] == null ? 0:$_GET['hire_no'];
$write = $_GET['write'];

$param = null;

if($hire_no != 0) {
	$sql = "SELECT *, AES_DECRYPT(UNHEX(patient_tel),'naghtglae_00710') as patient_tel FROM hire_info WHERE hire_no = ".$hire_no;
	$data = $pdo->row($sql, $param);
}


$my = $pdo->row("SELECT agency_state, association_nm FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param);

$hire_time_list = $pdo->query("SELECT * FROM code_info WHERE majr = 10 AND minr != 0 AND use_yn = 1", $param);
?>
<style>
    p {
        font-size: 1.1rem;
        font-weight: bold;
    }

	body{
		background: #DFE4F2;
	}


    .content_page {
        margin-bottom: 10%;
		padding: 0;
    }
    .content_page p {
        font-size: 1.3rem;
    }

	.form_box {
		padding: 30px 5%;
		background: #F6F9FF;
		margin-bottom: 15px;
	}
	
	.content_page p.form_num {
		width: 40px; min-width: 40px;
		height: 40px;
		line-height: 33px;
		font-size: 16px;
		font-weight: bold;
		border: 3px solid #3478F6;
		border-radius: 100%;
		background: #fff;
		color: #3478F6;
		text-align: center;
	}

	#hospital_name {
		background: #fff;
		border-radius: 20px;
		box-shadow: 0 3px 6px rgba(0,0,0,.16);
		padding: 30px 25px;
		margin-top: 30px;
		margin-bottom: 15px;
		display: none;
	}

    form.state_info {
        display: block;
    }
    .btn_box {
		max-width: 768px;
		margin: 0 auto;
        width: 100%;
        position: absolute;
        bottom: 0;
    }
    .state_info > a, .state_info > button {

        border-radius: 0;
    }
    .state_info a {
        right: 0;
    }

    .state_form {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .state_form>div {
        width: 75%;
        text-align: center;
    }

    .state_form>div input[type="radio"] {
        display: none;
    }

    .state_form>div input[type="radio"] + label {
        margin: 0;
        width: 100%;
        font-size: 1.2rem;
        font-weight: 500;
        color: #C5C9D4;
        background: #fff;
        border: 1px solid #D7D8E0;
        border-radius: 3px;
        padding: 15% 0;
    }
	.state_form>div input[type="radio"] + label img {
		width: 30%;
		display: block;
		margin: 0 auto;
		margin-bottom: 15px;
	}
	.state_form>div input[type="radio"] + label img.on {
		display: none;
	}
    .state_form>div input:checked+label {
        color: #fff;
        background: #E8F0FF;
        border-color: #3478F6;
		color: #3478F6;
    }
	.state_form>div input:checked+label img.on {
		display: block;
	}
	.state_form>div input:checked+label img.off {
		display: none;
	}

	.popup_form .area_form input {
		display: block;
	}

	#agency_list {
		height: 200px;
		overflow-y: scroll;
	}
	#agency_list li {
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.popup_form.popup_form2 {
		z-index: 9;
	}

	#between_date p {
		padding: 15px;
		background: #3478F6;
		font-size: 20px;
		color: #fff;
	}
	#between_date p span {
		font-weight: bold;
		font-size: 20px;
		color: #FFD500;
	}
	#between_date p img {
		margin-right: 10px;
		width: 30px;
	}

	
	.title {
		position: fixed;
		text-align: center;
		padding: 3% 0;
		background: #fff;
		width: 100%;
	}
	.title img {
		position: absolute;
		width: 20px;
		left: 3%;
		top: 50%; transform: translateY(-50%);
	}
	.title p {
		font-size: 1.5rem;
		font-weight: 500;
	}

	.popup_form2 .state_form.d-flex {
		position: fixed;
		left: 0; right: 0; top: 85px;
	}

	#agency_cnt {
		position: fixed;
		margin: 0 15px;
		left: 0; right: 0; top: 170px;
	}

	
	input[type=checkbox] + label {
        font-size: 1.0rem;
        vertical-align: middle;
    }
    input[type=checkbox] + label::before {
        content: '';
        display: inline-block;
        vertical-align: bottom;
        width: 25px; height: 25px;
        background: url('../../../img/check_off.svg');
        background-size: cover;
        margin-right: 10px;
    }
    input[type=checkbox]:checked + label::before {
        background: url('../../../img/check_on.svg');
        background-size: cover;
    }
	
	.state_form a {
		color: #fff;
		background: #3478F6;
		padding: 10px;
		font-size: 1.4rem;
		font-weight: 500;
		border-radius: 5px;
		text-align: center;
	}
</style>
<div class="content_wrap">
    <div class="progress_bar">
        <div class="progress_color" style="width: 20%;"></div>
    </div>
    <form action="<?=$hire_no != 0 ? "pay-form2.php?hire_no=".$hire_no:"pay-form2.php"?>" class="state_info" method="POST" name='payform2'>
		<input type="hidden" name="user_grade" value="<?=$grade?>">
		<input type="hidden" name="user_no" value="<?=$_SESSION['user_no']?>">
		<input type="hidden" name="hire_no" value="<?=$hire_no?>">
		<input type="hidden" name="mode" value="<?=$hire_no == 0 || $write != null ? 'input':'update'?>">
        <div class="content_page">
			<div class="popup_form popup_form1" >
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">서비스 이용약관에 동의해주세요.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 100%; background: #3478F6; border-bottom-left-radius:15px;border-bottom-right-radius:15px;">닫기</button>
					
					</div>
				</div>
			</div>
			<div class="popup_form popup_form3" >
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree3" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">서비스 이용약관에 동의해주세요.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 100%; background: #3478F6; border-bottom-left-radius:15px;border-bottom-right-radius:15px;">닫기</button>
					
					</div>
				</div>
			</div>
			<?php if($grade == 3) { ?>
			<div class="form_box">
				<p class="form_num">1</p>
				<p>분류를 선택하세요 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div class="state_form" style="margin-bottom: 5px;">
					<div style="width: 49%;">
						<input type="radio" name="hire_type" id="hire_type1" value= "1" checked <?=$data['hire_type'] == 1 ? "checked":""?>>
						<label for="hire_type1">
							<img src="/img/icon_type1_off.svg" class="off">
							<img src="/img/icon_type1_on.svg" class="on">
							개인간병
						</label>
					</div>
					<div style="width: 49%;">
						<input type="radio" name="hire_type" id="hire_type2" value= "2" <?=$data['hire_type'] == 2 ? "checked":""?>>
						<label for="hire_type2">
							<img src="/img/icon_type2_off.svg" class="off">
							<img src="/img/icon_type2_on.svg" class="on">
							공동간병
						</label>
					</div>
				</div>
				<div class="state_form" style="margin: 5px 0;">
				<?php if($_COOKIE['patient_cnt'] == null && $data['patient_cnt'] == null) { ?>
					<input type="text" name="patient_cnt" id="patient_cnt" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="병실환자수를 입력하세요." value="0">
				<?php } else {?>
					<input type="text" name="patient_cnt" id="patient_cnt" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="병실환자수를 입력하세요." value="<?=$_COOKIE['patient_cnt'] == null ? $data['patient_cnt']:$_COOKIE['patient_cnt']?>">
					<!-- 간병인원 디폴트로 0 넣어놓기 -->
				<?php } ?>
				</div>
				<div class="state_form" style="margin-top: 5px;">
				<?php if($_COOKIE['work_cnt'] == null && $data['work_cnt'] == null) { ?>
					<input type="text" name="work_cnt" id="work_cnt" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="모집인원을 입력하세요." value="1">
				<?php } else {?>
					<input type="text" name="work_cnt" id="work_cnt" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="모집인원을 입력하세요." value="<?=$_COOKIE['work_cnt'] == null ? $data['work_cnt']:$_COOKIE['work_cnt']?>">
					<!-- 간병인원 디폴트로 0 넣어놓기 -->
				<?php } ?>
				</div>
			</div>
			<?php } ?>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 1:2?></p>
				<p>간병장소를 선택하세요 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div class="state_form" style="margin-bottom: 5px;">
					<div style="width: 49%;">
						<input type="radio" name="addr_type" id="type1" value= "1" checked <?=$data['addr_type'] == 1 ? "checked":""?>>
						<label for="type1">
							<img src="/img/icon_hospital_off.svg" class="off">
							<img src="/img/icon_hospital_on.svg" class="on">
							병원
						</label>
					</div>
					<div style="width: 49%;">
						<input type="radio" name="addr_type" id="type2" value= "2" <?=$data['addr_type'] == 2 ? "checked":""?>>
						<label for="type2">
							<img src="/img/icon_home_off.svg" class="off">
							<img src="/img/icon_home_on.svg" class="on">
							집
						</label>
					</div>
				</div>
				<div class="popup_form popup_form2">
					<div class="area_form" style="height: 100%; width: 100%; border-radius: 0;">
						<div class="title">
							<img src="/img/back.svg" alt="" onclick="closeForm1();">
							<p>간병장소선택</p>
						</div>
						<div class="state_form d-flex" style="margin: 15px;">
							<input type="text" id="hospital" placeholder="병원명을 입력해주세요."><button type="button" onclick="select_hospital();" style="position: relative;width: 20%; min-width: 64px;">검색</button>
						</div>
						<p id="agency_cnt" style="margin: 0 15px;">검색결과 <span style="color: #3478F6;">0개</span></p>
						<ul id="agency_list" class="state_list" style=" margin: 15px; margin-top: 215px; height: calc(100% - 230px);" >
							<!--<li>병원명을 검색해주세요.</li>-->
						</ul>
					</div>
				</div>
				<div id="hospital_name">
					<?=$_COOKIE['hospital_name'] == null ? "<p>".$data['hospital_name']."</p>":"<p>".urldecode($_COOKIE['hospital_name'])."</p>"?>
					<?=$_COOKIE['addr1'] == null ? "<span>".$data['hire_addr']."</span>":"<span>".urldecode($_COOKIE['addr1'])."</span>"?>
				</div>
				<div class="state_form" style="margin-bottom:0; margin-top:5px">
					<input type="hidden" style="width:79%" id="addr1" name="addr1" value="<?=$_COOKIE['addr1'] == null ?  $data['hire_addr']:urldecode($_COOKIE['addr1'])?>" readonly>
					<a id="addr_btn" style="color: #fff; background: #000;width: 100%;min-width: 64px;" type="button" onclick="Postcode()">병원찾기</a>
				</div>
				<div class="state_form" id="addr_type1_form" style="margin-top:5px; margin-bottom: 5px;">
					<input type="text" placeholder="병동/병실을 입력하세요." name="addr2" value="<?=$_COOKIE['addr2'] == null ?  $data['hire_addr2']:urldecode($_COOKIE['addr2'])?>">
				</div>
				<div id="hospital_room">
					<input type="checkbox" id="room_chk" name="hospital_room" style="display: none;">
					<label for="room_chk">병실이 정해지지 않음</label>
				</div>
				<span style="font-weight: 500; color:#3478F6;">* 상세주소는 간병사가 확정되면 노출됩니다</span>
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 2:3?></p>
				<p>간병기간을 선택하세요 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div style="margin-top: 20px">
					<div>
						<label for="sdate" style="font-size: 1.2rem">시작일</label>
						<div class="state_form align-items-center" style="margin-top:3px">
							<input type="date" name="hire_sdate" id="hire_sdate" onchange="betweenDate();" placeholder="날짜" value="<?=$_COOKIE['hire_sdate'] == null ? $data['hire_sdate']:$_COOKIE['hire_sdate']?>">
							<!-- <select name="hire_sdate" id="sdate">
								<option value="">날짜</option>
							</select> -->
							&nbsp;
							<select name="hire_stime" id="" style="width:55%;">
								<option value="0">시간</option>
								<?php if($_COOKIE['hire_stime'] == null) {
										for($i = 7; $i <=12; $i++) {?>
										<option value="<?=$i?>" <?=$data['hire_stime'] == $i ? "selected":""?>><?=$i == 12 ? "오후 ":"오전 "?><?=$i."시"?></option>
										<?php } ?>
										<?php for($i = 1; $i <=11; $i++) { ?>
										<option value="<?=$i+12?>" <?=$data['hire_stime'] == $i+12 ? "selected":""?>><?="오후 ".$i."시"?></option>
								<?php }
									} else {
										for($i = 7; $i <=12; $i++) { ?>
										<option value="<?=$i?>" <?=$_COOKIE['hire_stime'] == $i ? "selected":""?>><?=$i == 12 ? "오후 ":"오전 "?><?=$i."시"?></option>
										<?php } ?>
										<?php for($i = 1; $i <=11; $i++) { ?>
										<option value="<?=$i+12?>" <?=$_COOKIE['hire_stime'] == $i+12 ? "selected":""?>><?="오후 ".$i."시"?></option>
								<?php }
								} ?>
							</select>
						</div>
					</div>
					<div>
						<label for="edate" style="font-size: 1.2rem">종료일</label>
						<div class="state_form align-items-center" style="margin-top:3px;margin-bottom:5px">
							<input type="date" name="hire_edate" id="hire_edate" onchange="betweenDate();" value="<?=$_COOKIE['hire_edate'] == null ? $data['hire_edate']:$_COOKIE['hire_edate']?>">
						</div>
						<div id="between_date"></div>
					<span style="font-weight: 500; color:#3478F6;">* 종료일을 알 수 없을 경우 임시 예정일을 등록해주세요 (날짜 변경 시 간병사와 협의하세요)</span>
					</div>
				</div>
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 3:4?></p>
				<p>간병시간을 선택하세요 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div class="state_form d-block">
					<label for="">간병시간</label>
					<!--<input type="number" min="0" max="24" name="hire_time" placeholder="하루 간병시간을 입력하세요. 예)12" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$hire_no != 0 ? $data['hire_time']:$_COOKIE['hire_time']?>">-->
					<select name="hire_time" id="">
						<option value="0">선택하세요.</option>
						<?php if($_COOKIE['hire_time'] == null) {
							if($grade == 3) { ?>
						<option value="4" <?=$data['hire_time'] == 4 ? "selected":""?>>격일</option>
						<?php }
							foreach($hire_time_list as $d) { ?>
						<option value="<?=$d['minr']?>" <?=$data['hire_time'] == $d['minr'] ? "selected":""?>><?=$d['name'].$d['etc']?></option>
						<?php }
						} else {
							if($grade == 3) { ?>
						<option value="4" <?=$_COOKIE['hire_time'] == 4 ? "selected":""?>>격일</option>
						<?php }
							foreach($hire_time_list as $d) {  ?>
						<option value="<?=$d['minr']?>" <?=$_COOKIE['hire_time'] == $d['minr'] ? "selected":""?>><?=$d['name'].$d['etc']?></option>
						<?php }
						} ?>
					</select>
				</div>
			</div>
			<?php if ($grade == 3){ ?>
			<div class="form_box">
				<p class="form_num">5</p>
				<p>지급금액을 입력하세요 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div class="state_form">
					<select name="pay_type" style="width: 29%">
						<?php if($_COOKIE['pay_type'] == null) { ?>
							<option value="1" <?=$data['pay_type'] == 1 ? "selected":""?>>시급</option>
							<option value="2" <?=$data['pay_type'] == 2 ? "selected":""?>>일급</option>
							<option value="3" <?=$data['pay_type'] == 3 ? "selected":""?>>월급</option>
							<option value="4" <?=$data['pay_type'] == 4 ? "selected":""?>>협의</option>
						<?php } else { ?>
							<option value="1" <?=$_COOKIE['pay_type'] == 1 ? "selected":""?>>시급</option>
							<option value="2" <?=$_COOKIE['pay_type'] == 2 ? "selected":""?>>일급</option>
							<option value="3" <?=$_COOKIE['pay_type'] == 3 ? "selected":""?>>월급</option>
							<option value="4" <?=$_COOKIE['pay_type'] == 4 ? "selected":""?>>협의</option>
						<?php } ?>
					</select>
					<input type="text" name="pay" style="width: 70%" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="<?=$_COOKIE['pay'] == null ? $data['pay']:urldecode($_COOKIE['pay'])?>">
				</div>
			</div>
			<div class="form_box">
				<p class="form_num">6</p>
				<p>보호자 연락처를 입력하세요</p>
				<div class="state_form" style="margin-bottom: 25px;">
					<input type="text" name="patient_tel" id= "patient_tel" placeholder="보호자 연락처를 입력해주세요" value="<?=$_COOKIE['patient_tel'] == null ? $data['patient_tel']:$_COOKIE['patient_tel']?>">
				</div>
				<span style="font-weight: 500; color:#3478F6;">* 보호자 연락처는 간병사가 확정되면 노출됩니다</span><br><br>
			</div>
			<?php } ?>
        </div>
        <div class="btn_box d-flex">
			<?php if($grade == 1) { ?>
            <a href="<?=$hire_no != 0 ? "/app/page/state/state-list.php":"/app/index.php"?>" style="color:#fff; background: #000; width: 50%">이전</a>
			<?php } else { ?>
            <a href="/app/page/state/state3-list.php" style="color:#fff; background: #000; width: 50%">이전</a>
			<?php } ?>
            <button id="saveForm" type="button" style="background: #3478F6; width: 50%">다음</button>
        </div>
    </form>
</div>
<?php
include('../../lib/footer.php');
?>
<script>

//값 있을 때 show 유지...
var hire_no = $("#hire_no").val();
var home_addr1 = $("#addr1").val();
var home_hire_sdate = $("#hire_sdate").val();
var home_hire_edate = $("#hire_edate").val();

if(hire_no > 0 || home_addr1 != '') {
	$('#hospital_name').show();
	$("#addr_btn").text('수정하기');
}
if(hire_no > 0 || (home_hire_sdate != '' && home_hire_edate != '')) {
	var sdate = new Date($('#hire_sdate').val());
	var edate = new Date($('#hire_edate').val());
	var diff = Math.abs(edate.getTime() - sdate.getTime());
		diff = Math.ceil(diff / (1000 * 60 * 60 * 24));
	//console.log(diff + 1);
	if(diff > 0) {
		$('#between_date').html('<p><img src="/img/total_day.svg">간병기간은 총 <span>'+(diff+1)+'일</span>입니다.</p>');
	}
}


//날짜 차이
function betweenDate() {
	var sdate = new Date($('#hire_sdate').val());
	var edate = new Date($('#hire_edate').val());
	var diff = Math.abs(edate.getTime() - sdate.getTime());
		diff = Math.ceil(diff / (1000 * 60 * 60 * 24));
	//console.log(diff + 1);
	if(diff > 0) {
		$('#between_date').html('<p><img src="/img/total_day.svg">간병기간은 총 <span>'+(diff+1)+'일</span>입니다.</p>');
	}
}

var now_utc = Date.now() // 지금 날짜를 밀리초로
// getTimezoneOffset()은 현재 시간과의 차이를 분 단위로 반환
var timeOff = new Date().getTimezoneOffset()*60000; // 분단위를 밀리초로 변환
// new Date(now_utc-timeOff).toISOString()은 '2022-05-11T18:09:38.134Z'를 반환
var today = new Date(now_utc-timeOff).toISOString().split("T")[0];

document.getElementById("hire_sdate").setAttribute("min", today);
document.getElementById("hire_edate").setAttribute("min", today);

$(document).ready(function(){

	var hire_type = getCookie("hire_type");
	var addr_type = getCookie("addr_type");
	var hire_sdate = getCookie("hire_sdate");
	var hire_edate = getCookie("hire_edate");
	var addr1 = getCookie("addr1");
	var addr2 = getCookie("addr2");
	var hire_time = getCookie("hire_time");
	var patient_tel = getCookie("patient_tel");
	
	if (hire_type > 0) {
		$("input[name='hire_type'][value="+hire_type+"]").prop("checked",true);
	}
	if (addr_type > 0) {
		$("input[name='addr_type'][value="+addr_type+"]").prop("checked",true);
	}
	//$("input[name='hire_sdate']").val(hire_sdate);
	//$("input[name='hire_edate']").val(hire_edate);
	//$("input[name='addr1']").val(addr1);
	//$("input[name='addr2']").val(addr2);
	//$("input[name='hire_time']").val(hire_time);
	

	if($("input[name='addr_type']:checked").val() == 1) {
		$("#addr_type1_form input").attr('placeholder','병동/병실을 입력하세요.');
		$("#addr_btn").removeAttr('onclick');
		$("#addr_btn").attr('href', 'pay-hospital.php');
		//$("#addr_btn").text('병원찾기');
		$("#addr1").removeAttr('onclick');
		$("#addr1").attr('href', 'pay-hospital.php');
		$("#hospital_room").show();
	}
	if($("input[name='addr_type']:checked").val() == 2) {
		$("#addr_type1_form input").attr('placeholder','나머지 주소를 입력하세요.');
		$("#addr_btn").attr('onclick', 'Postcode()');
		$("#addr_btn").removeAttr('href');
		//$("#addr_btn").text('주소찾기');
		$("#addr1").attr('onclick', 'Postcode()');
		$("#addr1").removeAttr('href');
		$("#hospital_room").hide();
	}

	$("input[name='addr_type']").click(function(){
		$("#hospital_name").hide();
		$("#addr1").val('');
		if($("input[name='addr_type']:checked").val() == 1) {
			$("#addr_type1_form input").attr('placeholder','병동/병실을 입력하세요.');
			$("#addr_btn").removeAttr('onclick');
			$("#addr_btn").attr('href', 'pay-hospital.php');
			$("#addr_btn").text('병원찾기');
			$("#addr1").removeAttr('onclick');
			$("#addr1").attr('href', 'pay-hospital.php');
			$("#hospital_room").show();
		}
		if($("input[name='addr_type']:checked").val() == 2) {
			$("#addr_type1_form input").attr('placeholder','나머지 주소를 입력하세요.');
			$("#addr_btn").attr('onclick', 'Postcode()');
			$("#addr_btn").removeAttr('href');
			$("#addr_btn").text('주소찾기');
			$("#addr1").attr('onclick', 'Postcode()');
			$("#addr1").removeAttr('href');
			$("#hospital_room").hide();
			$("#addr_type1_form input").val('');
			$("#addr_type1_form input").prop('readonly', false);
			$("input[name='hospital_room']").prop('checked', false);
		}
	})

	
	$("input[name='hospital_room']").click(function(){
		if($("input[name='hospital_room']").is(":checked")) {
			$("#addr_type1_form input").val('(병실 없음)');
			$("#addr_type1_form input").prop('readonly', true);
		} else {
			$("#addr_type1_form input").val('');
			$("#addr_type1_form input").prop('readonly', false);
		}
	})


	if($("input[name='hire_type']:checked").val() == 1) {
		$("#patient_cnt").hide();
		$("#patient_cnt").val(0);
		$("#work_cnt").hide();
		$("#work_cnt").val(1);

	}
	if($("input[name='hire_type']:checked").val() == 2) {
		$("#patient_cnt").show();
		$("#work_cnt").show();
		$("#type2").prop("disabled", true);
	}

	$("input[name='hire_type']").click(function(){
		if($("input[name='hire_type']:checked").val() == 1) {
			$("#patient_cnt").hide();
			$("#patient_cnt").val(0);
			$("#work_cnt").hide();
			$("#work_cnt").val(1);

			$("#type2").prop("disabled", false);
		}
		if($("input[name='hire_type']:checked").val() == 2) {
			$("#patient_cnt").show();
			$("#patient_cnt").val('');
			$("#work_cnt").show();
			$("#work_cnt").val('');

			$("#type2").prop("disabled", true);
			$("#type1").prop("checked", true);
			$("#addr_type1_form").show();
		}
	})

	$("select[name='pay_type']").change(function(){
		if($("select[name='pay_type'] option:selected").val() == 4) {
			$("input[name='pay']").prop("readonly", true);
			$("input[name='pay']").val("협의");
		} else {
			$("input[name='pay']").prop("readonly", false);
			$("input[name='pay']").val("");
		}
	})
})

function select_hospital(){
	var hospital = document.getElementById("hospital");  
	var selectValue = hospital.value;  
	//alert(selectValue);
	if(selectValue == '') {

		document.getElementById('agree3').innerHTML = '병원명을 입력해주세요.';
		$('.popup_form3').css('display', 'block');
		return;

	} else {
		$.ajax({type: 'POST',
			url: '/app/page/state/json.php',
			data:"&mode=serch_hospital&hospital_nm="+selectValue,
			dataType: 'json',
			cache: false,
			beforeSend: function() { },
			success: function(data) {
				try
				{
					//alert(data.resCode);
					if(data.resCode == 1){
						//alert(JSON.stringify(data.gugun));
						$( '#agency_list' ).empty();
						if(data.hospital == null) {
							$( '#agency_cnt' ).html( '<p id="agency_cnt">검색결과 <span style="color: #3478F6;">0개</span></p>' );
							$( '#agency_list' ).append( '<li>조회된 결과가 없습니다.</li>' );
						} else { 
							$( '#agency_cnt' ).html( '<p id="agency_cnt">검색결과 <span style="color: #3478F6;">'+data.hospital.length+'개</span></p>' );
							for ( var i = 0; i < data.hospital.length; i++ ) {
								//alert(data.gugun[ i ]['gugun']);
								str = '';
								str += '<li class="state_form" onclick="hospital_input('+'\''+data.hospital[ i ]['dutyName']+'\',\''+data.hospital[ i ]['dutyAddr']+'\');">';
								str += '<div style="text-align: left;">';
								str += '<p>' + data.hospital[ i ]['dutyName'] + '</p>';
								str += '<span style="color: #8A8A8A; margin-top: 5px;">' + data.hospital[ i ]['dutyAddr'] + '</span>';
								str += '</div>';
								str += '<img src="/img/arrow.svg" style="position: relative; margin: 0; width: 30px; min-width: 30px;">';
								str += '</li>'
								$( '#agency_list' ).append( str );
							}
						}
					}
					else{
						
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
function hospital_input(name, addr) {
	$('#hospital_name').html('<p>'+name+'</p><span>'+addr+'<span>');
	$('#hospital_name').show();
	$('input[name="addr1"]').val(addr);
	$("#addr_btn").text('수정하기');
    $('.popup_form2').css('display', 'none');
}

$('#saveForm').click(function(){
	var hire_no = $("input[name='hire_no']").val();
	var mode = $("input[name='mode']").val();
	var user_grade = $("input[name='user_grade']").val();
	var user_no = $("input[name='user_no']").val();
	var hire_type = $("input[name='hire_type']:checked").val();
	var addr_type = $("input[name='addr_type']:checked").val();
	var patient_cnt = $("input[name='patient_cnt']").val();
	var patient_tel = $("input[name='patient_tel']").val();
	var work_cnt = $("input[name='work_cnt']").val();
	var hire_sdate = $("input[name='hire_sdate']").val();
	var hire_stime = $("select[name='hire_stime']").val();
	var hire_edate = $("input[name='hire_edate']").val();
	//var hire_etime = $("select[name='hire_etime']").val();
	var addr1 = encodeURIComponent($("input[name='addr1']").val());
	var addr2 = encodeURIComponent($("input[name='addr2']").val());
	var hospital_name = encodeURIComponent($("#hospital_name p").text());
	var hire_time = $("select[name='hire_time']").val();
	var pay_type = $("select[name='pay_type']").val();
	var pay = encodeURIComponent($("input[name='pay']").val());

	if(addr1 == "") {

		document.getElementById('agree').innerHTML = '간병주소를 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		return;

	}else if(hire_sdate == "") {

		document.getElementById('agree').innerHTML = '간병시작일을 선택하세요.';
		$('.popup_form1').css('display', 'block');
		return;

	}else if(hire_stime == 0) {

		document.getElementById('agree').innerHTML = '간병시작시간을 선택하세요.';
		$('.popup_form1').css('display', 'block');
		return;

	}else if(hire_edate == "") {

		document.getElementById('agree').innerHTML = '간병종료일을 선택하세요.';
		$('.popup_form1').css('display', 'block');
		return;

	} else if(hire_sdate+' '+hire_stime >= hire_edate+' 23:59') {

		document.getElementById('agree').innerHTML = '간병기간을 확인하세요.';
		$('.popup_form1').css('display', 'block');
		return;

	} else if(hire_time == 0) {

		document.getElementById('agree').innerHTML = '간병시간을 선택하세요.';
		$('.popup_form1').css('display', 'block');
		return;

	} else if(pay == "") {
		
		if(user_grade == 3) {

			document.getElementById('agree').innerHTML = '지급금액을 입력하세요.';
			$('.popup_form1').css('display', 'block');
			return;
		}
		
	} else if(patient_cnt == "") {
		
		if(user_grade == 3 && hire_type == 2) {

			document.getElementById('agree').innerHTML = '간병인원을 입력하세요.';
			$('.popup_form1').css('display', 'block');
			return;

		}
		
	}	else if(work_cnt == "") {
		
		if(user_grade == 3 && hire_type == 2) {

			document.getElementById('agree').innerHTML = '모집인원을 입력하세요.';
			$('.popup_form1').css('display', 'block');
			return;

		}
		
	} else {

		setCookie("hire_no", hire_no, 1);
		setCookie("mode", mode, 1);
		setCookie("user_grade", user_grade, 1);
		setCookie("user_no", user_no, 1);
		setCookie("addr_type", addr_type, 1);
		setCookie("hire_sdate", hire_sdate, 1);
		setCookie("hire_stime", hire_stime, 1);
		setCookie("hire_edate", hire_edate, 1);
		//setCookie("hire_etime", hire_etime, 1);
		setCookie("addr1", addr1, 1);
		setCookie("addr2", addr2, 1);
		setCookie("hire_time", hire_time, 1);

		setCookie("hospital_name", hospital_name, 1);
		
		if(user_grade == 3) {
		setCookie("hire_type", hire_type, 1);
		setCookie("pay_type", pay_type, 1);
		setCookie("pay", pay, 1);
		setCookie("patient_cnt", patient_cnt, 1);
		setCookie("patient_tel", patient_tel, 1);
		setCookie("work_cnt", work_cnt, 1);
		}

		document.payform2.submit();
	}
})
function openForm() {
    $('.popup_form2').css('display', 'block');
}
function closeForm1() {
	$('.popup_form1').css('display', 'none');
	$('.popup_form2').css('display', 'none');
}
function closeForm3() {
	$('.popup_form3').css('display', 'none');
}

function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}
 
function deleteCookie(cookieName){
    var expireDate = new Date();
    expireDate.setDate(expireDate.getDate() - 1);
    document.cookie = cookieName + "= " + "; expires=" + expireDate.toGMTString();
}
 
function getCookie(cookieName) {
    cookieName = cookieName + '=';
    var cookieData = document.cookie;
    var start = cookieData.indexOf(cookieName);
    var cookieValue = '';
    if(start != -1){
        start += cookieName.length;
        var end = cookieData.indexOf(';', start);
        if(end == -1)end = cookieData.length;
        cookieValue = cookieData.substring(start, end);
    }
    return unescape(cookieValue);
}

//setCookie("s_extent",0,100); 변수명, 값 , 유지시간
//getCookie("s_extent") 자바스크립트에서 사용 할때
//$_COOKIE['s_extent'] php에서 사용할때

</script>
<div id="layer" style="visibility:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
</div>

<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=0c6f68ea9807b418ec7796f6cf016072&​libraries=services"></script>

<script>
    // 우편번호 찾기 화면을 넣을 element
    var element_layer = document.getElementById('layer');
	
    function closeDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function Postcode() {
        new daum.Postcode({
            oncomplete: function(data) {
				//var geocoder = new kakao.maps.services.Geocoder();

				// 주소로 좌표를 검색합니다
				//geocoder.addressSearch(data.address, function(result, status) {

					// 정상적으로 검색이 완료됐으면 
					 //if (status === kakao.maps.services.Status.OK) {
						$('input[name=addr1]').val(data.address);   
						$('#hospital_name').html('<p>집</p><span>'+data.address+'</span>');
						$('#hospital_name').show();
						$("#addr_btn").text('수정하기');
						//var coords = new kakao.maps.LatLng(result[0].y, result[0].x);
						//result[0].y 위도 result[0].x 경도
						element_layer.style.display = 'none';
					//} 
				//});                
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = 'block';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
        var width = 320; //우편번호서비스가 들어갈 element의 width
        var height = 540; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 2; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top =  '15%'; //(((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';

    }
</script>