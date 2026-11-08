<?php
include('../../lib/header.php');
$title = $grade == 1 ? "간병요청하기":"구인요청하기";
include('../../lib/title.php');
include('../../../common.php');

$hire_no = $_GET['hire_no'] == null ? 0:$_GET['hire_no'];

$param = null;

if($hire_no != 0) {
	$sql = "SELECT * FROM hire_info WHERE hire_no = ".$hire_no;
	$data = $pdo->row($sql, $param);
}

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
        margin-top: 20px;
    }

    .state_form {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .state_form>div {
        width: 32%;
        text-align: center;
    }

    .state_form>div input[type="radio"] {
        display: none;
    }

    .state_form>div input[type="radio"] + label {
        margin: 0;
        width: 100%;
        font-size: 1.4rem;
        font-weight: 500;
        color: #C5C9D4;
        background: #fff;
        border: 1px solid #D7D8E0;
        border-radius: 3px;
        padding: 10px 0;
    }
    .state_form>div input:checked+label {
        color: #fff;
        background: #3478F6;
        border-color: #3478F6;
    }

</style>
<div class="content_wrap">
    <div class="progress_bar">
        <div class="progress_color" style="width: 100%;"></div>
    </div>
    <form action="<?=$hire_no != 0 ? "state-info.php?hire_no=".$hire_no:"state-info.php"?>" class="state_info" method="POST" name='stateInfo'>
        <div class="content_page">
			<div class="popup_form popup_form1">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">서비스 이용약관에 동의해주세요.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 100%; background: #3478F6; border-bottom-left-radius:15px;border-bottom-right-radius:15px;">닫기</button>
					
					</div>
				</div>
			</div>
			<div class="form_box">
				<?php if($grade == 1) { ?>
				<p class="form_num">12</p>
				<?php } else { ?>
				<p class="form_num"><?=$_COOKIE['hire_type'] == 1 ? 15:8?></p>
				<?php } ?>
				<p>선호하는 간병사 성별을 선택하세요</p>
				<div class="state_form">
					<div>
						<input type="radio" name="hire_sex" id="gender1" value="0" checked <?=$data['hire_sex'] == 0 ? "checked":""?>>
						<label for="gender1">성별무관</label>
					</div>
					<div>
						<input type="radio" name="hire_sex" id="gender2" value="1" <?=$data['hire_sex'] == 1 ? "checked":""?>>
						<label for="gender2">남성선호</label>
					</div>
					<div>
						<input type="radio" name="hire_sex" id="gender3" value="2" <?=$data['hire_sex'] == 2 ? "checked":""?>>
						<label for="gender3">여성선호</label>
					</div>
				</div>
			</div>
				<div class="form_box">
				<?php if($grade == 1) { ?>
				<p class="form_num">13</p>
				<?php } else { ?>
				<p class="form_num"><?=$_COOKIE['hire_type'] == 1 ? 16:9?></p>
				<?php } ?>
				<p>게시기간을 선택하세요 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div class="state_form d-block">
					<label for="" style="margin-bottom:3px">오늘부터 선택한 날까지 공고됩니다</label>
					<input type="date" name="end_date" id="end_date" onchange="changeDate();" value="<?=$_COOKIE['end_date'] == null ? substr($data['end_date'],0,10):$_COOKIE['end_date']?>">
					<!--<select name="end_date" id="end_date">
						<option value="">선택</option>
					</select>-->
					<p style="font-size: 1.1rem; font-weight:500; color:#3478F6; margin-top: 3px;" id="endDate">날짜를 선택하세요.</p>
				</div>
			</div>
			<?php if($grade == 1 || $_COOKIE['hire_type'] != 2){ ?>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 14:17?></p>
				<p>추가내용을 입력하세요.</p>
				<div class="state_form d-block" style="margin-bottom: 80px;">
					<label for="" style="margin-bottom:3px">추가내용</label>
					<div class="state_form d-block" style="width: 100%;margin:0">
						<textarea rows="3" name="hire_cont" placeholder="예시) 하루 약 3번 챙겨주세요 "><?=$_COOKIE['hire_cont'] == null ? $data['hire_cont']:urldecode($_COOKIE['hire_cont'])?></textarea>
					</div>
				</div>
			</div>
			<?php } ?>
        </div>
        <div class="btn_box d-flex">
			<?php if(($_COOKIE['user_grade'] == 1) || ($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 1)) { ?>
            <a href="<?=$hire_no != 0 ? "pay-form4.php?hire_no=".$hire_no:"pay-form4.php"?>" style="color:#fff; background: #000; width: 50%">이전</a>
			<?php } else if($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 2) { ?>
            <a href="<?=$hire_no != 0 ? "pay-form2.php?hire_no=".$hire_no:"pay-form2.php"?>" style="color:#fff; background: #000; width: 50%">이전</a>
			<?php } ?>
            <button id="saveForm" style="background: #3478F6; width: 50%">완료하기</button>
        </div>
    </form>
</div>
<?php
include('../../lib/footer.php');
?>
<script>

var now_utc = Date.now() // 지금 날짜를 밀리초로
// getTimezoneOffset()은 현재 시간과의 차이를 분 단위로 반환
var timeOff = new Date().getTimezoneOffset()*60000; // 분단위를 밀리초로 변환
// new Date(now_utc-timeOff).toISOString()은 '2022-05-11T18:09:38.134Z'를 반환
var today = new Date(now_utc-timeOff).toISOString().split("T")[0];

var now = new Date();
var week = new Date(now.setDate(now.getDate() + 5));
var day = week.toISOString().substring(0,10);



var hire_sdate = getCookie("hire_sdate");

//alert(hire_sdate);

document.getElementById("end_date").setAttribute("min", today);
document.getElementById("end_date").setAttribute("max", hire_sdate);


function changeDate(){
	var now = new Date();
	var today = now.toISOString().substring(0,10);
	var day = $('#end_date').val();

	const dateA = new Date(day);
	const dateB = new Date(today);
	const diffMSec = dateA.getTime() - dateB.getTime();
	const diffDate = diffMSec / (24 * 60 * 60 * 1000);

	var endDate = $('#endDate');
	endDate.text(diffDate + "일 후까지 공지");
	// console.log(`날짜의 차이는 ${diffDate}일 입니다.`);  // 결과: '날짜의 차이는 31일입니다.'
}


$(document).ready(function(){
	var patient_type5 = getCookie("hire_sex");
	var hire_type = getCookie("hire_type");

	$("input[name='hire_sex'][value="+hire_sex+"]").prop("checked",true);
})

$('#saveForm').click(function(){
	var hire_sex = $("input[name='hire_sex']:checked").val();
	var end_date = $("input[name='end_date']").val();
	var hire_type = getCookie("hire_type");


	if(end_date == "") { 

		document.getElementById('agree').innerHTML = '게시기간을 선택해주세요.';
		$('.popup_form1').css('display', 'block');
		return false;

	} else {

		setCookie("hire_sex", hire_sex, 1);
		setCookie("end_date", end_date, 1);

		if(hire_type != 2) {
			var hire_cont = encodeURIComponent($("textarea[name='hire_cont']").val());
			setCookie("hire_cont", hire_cont, 1);
		}
		
		//window.nightingale.showLoading('1');
		document.stateInfo.submit();
		//window.nightingale.showLoading('0');

	}
})
function closeForm1() {
	$('.popup_form1').css('display', 'none');
	$('.popup_form2').css('display', 'none');
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