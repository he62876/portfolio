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
		background: #F6F9FF;
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
    .state_form label {
        margin-bottom: 3px;
    }
</style>
<div class="content_wrap">
    <div class="progress_bar">
        <div class="progress_color" style="width: 40%;"></div>
    </div>
	<?php if(($_COOKIE['user_grade'] == 1) || ($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 1)) { ?>
    <form action="<?=$hire_no != 0 ? "pay-form3.php?hire_no=".$hire_no:"pay-form3.php"?>" class="state_info" method="POST" name='payform3'>
	<?php } else if($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 2) { ?>
    <form action="<?=$hire_no != 0 ? "pay-form5.php?hire_no=".$hire_no:"pay-form5.php"?>" class="state_info" method="POST" name='payform5'>
	<?php } ?>
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
			<?php if(($_COOKIE['user_grade'] == 1) || ($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 1)) { ?>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 4:7?></p>
				<p>환자정보를 입력하세요</p>
				<div class="state_form d-block">
					<label for="">환자명</label>
					<input type="text" name="patient_name" id= "patient_name" placeholder="이름을 입력해주세요" value="<?=$_COOKIE['patient_name'] == null ? $data['patient_name']:urldecode($_COOKIE['patient_name'])?>">
				</div>
				<div class="state_form d-block">
					<label for="">나이 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></label>
					<input type="text" name="patient_age" id="patient_age" placeholder="숫자만 입력하세요" value="<?=$_COOKIE['patient_age'] == null ? $data['patient_age']:$_COOKIE['patient_age']?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
				</div>
				<div class="state_form d-block">
					<label for="">몸무게 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></label>
					<input type="text" name="patient_weight" id="patient_weight" placeholder="숫자만 입력하세요" value="<?=$_COOKIE['patient_weight'] == null ? $data['patient_weight']:$_COOKIE['patient_weight']?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
				</div>
				<div class="state_form d-block">
					<label for="">환자성별 <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></label>
					<select name="patient_sex" id="patient_sex">
						<option value="0">선택</option>
						<?php if($_COOKIE['patient_weight'] == null){ ?>
						<option value="1" <?=$data['patient_sex'] == 1 ? "selected":""?>>남성</option>
						<option value="2" <?=$data['patient_sex'] == 2 ? "selected":""?>>여성</option>
						<?php } else { ?>
						<option value="1" <?=$_COOKIE['patient_sex'] == 1 ? "selected":""?>>남성</option>
						<option value="2" <?=$_COOKIE['patient_sex'] == 2 ? "selected":""?>>여성</option>
						<?php } ?>
					</select>
				</div>
				<div class="state_form d-block">
					<label for="">진단정보</mr>(진단 및 환자 상태 기재)<span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></label>
					<textarea rows="3" name="patient_cont" id="patient_cont" value="" placeholder="예) 치매, 섬망증세"><?=$_COOKIE['patient_cont'] == null ? $data['patient_cont']:urldecode($_COOKIE['patient_cont'])?></textarea>
				</div>
				<?php } else if($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 2) { ?>
			<div class="form_box">
				<p class="form_num">7</p>
				<p>상세내용을 입력하세요. <span style="font-size: 22px; font-weight: bold; color: #3478F6;">*</span></p>
				<div class="state_form d-block">
					<textarea rows="10" name="hire_cont" placeholder="예시)&#13;&#10;병실 : 남자 일반 6인실&#13;&#10;비간병 1인&#13;&#10;재활투석 없습니다"><?=$_COOKIE['hire_cont'] == null ? $data['hire_cont']:urldecode($_COOKIE['hire_cont'])?></textarea>
				</div>
			</div>
				<?php } ?>
			</div>
        </div>
        <div class="btn_box d-flex">
			<?php if($_COOKIE['mode'] == 'input' && $hire_no != 0) { ?>
            <a href="pay-form1.php?hire_no=<?=$hire_no?>&write=re" style="color:#fff; background: #000; width: 50%">이전</a>
			<?php } else { ?>
            <a href="<?=$hire_no != 0 ? "pay-form1.php?hire_no=".$hire_no:"pay-form1.php"?>" style="color:#fff; background: #000; width: 50%">이전</a>
			<?php } ?>
            <button id="saveForm" style="background: #3478F6; width: 50%" type="button">다음</button>
        </div>
    </form>
</div>
<?php
include('../../lib/footer.php');
?>
<script>

$(document).ready(function(){
	var patient_name = getCookie("patient_name");
	var patient_age = getCookie("patient_age");
	var patient_weight = getCookie("patient_weight");
	var patient_sex = getCookie("patient_sex");
	var patient_cont = getCookie("patient_cont");

	//$("input[name='patient_name']").val(patient_name);
	//$("input[name='patient_age']").val(patient_age);
	//$("input[name='patient_weight']").val(patient_weight);
	//$("input[name='patient_sex']").val(patient_sex);
	//$("input[name='patient_cont']").val(patient_cont);
})

$('#saveForm').click(function(){

<?php if(($_COOKIE['user_grade'] == 1) || ($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 1)) { ?>
	var patient_name = encodeURIComponent($("input[name='patient_name']").val());
	var patient_age = $("input[name='patient_age']").val();
	var patient_weight = $("input[name='patient_weight']").val();
	var patient_sex = $("select[name='patient_sex']").val();
	var patient_cont = encodeURIComponent($("textarea[name='patient_cont']").val());

	/* if(patient_name == "") {

		document.getElementById('agree').innerHTML = '환자명을 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		return;

	} else */
	if(patient_age == "") {

		document.getElementById('agree').innerHTML = '환자나이를 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		return;
		
	} else if(patient_weight == "") {

		document.getElementById('agree').innerHTML = '환자몸무게를 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		return;
	
	} else if(patient_sex == 0) {

		document.getElementById('agree').innerHTML = '환자성별을 선택해주세요.';
		$('.popup_form1').css('display', 'block');
		return;
	
	}else if(patient_cont == "") {

		document.getElementById('agree').innerHTML = '진단정보를 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		return;
	
	}else {

		setCookie('patient_name', patient_name, 1);
		setCookie('patient_age', patient_age, 1);
		setCookie('patient_weight', patient_weight, 1);
		setCookie('patient_sex', patient_sex, 1);
		setCookie('patient_cont', patient_cont, 1);

		document.payform3.submit();
	}

	<?php } else if($_COOKIE['user_grade'] == 3 && $_COOKIE['hire_type'] == 2) { ?>
	var hire_cont = encodeURIComponent($("textarea[name='hire_cont']").val());

	if (hire_cont == "") {

		document.getElementById('agree').innerHTML = '상세내용을 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		return;

	} else {
		setCookie('hire_cont', hire_cont, 1);

		document.payform5.submit();
	}

	<?php } ?>
})
function closeForm1() {
	$('.popup_form1').css('display', 'none');
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