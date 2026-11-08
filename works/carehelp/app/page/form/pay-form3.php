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
        right: 0;`
    }

    .state_form {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .state_form>div {
        width: 49%;
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
        <div class="progress_color" style="width: 60%;"></div>
    </div>
    <form action="<?=$hire_no != 0 ? "pay-form4.php?hire_no=".$hire_no:"pay-form4.php"?>" class="state_info" method="POST">
        <div class="content_page">
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 5:8?></p>
				<p>거동상태를 선택하세요</p>
				<div class="state_form">
					<div style="width:32%">
						<input type="radio" name="patient_type1" value="1" id="option1_1" checked <?=$data['patient_type1'] == 1 ? "checked":""?>>
						<label for="option1_1">혼자가능</label>
					</div>
					<div style="width:32%">
						<input type="radio" name="patient_type1" value="3" id="option1_3" <?=$data['patient_type1'] == 3 ? "checked":""?>>
						<label for="option1_3">거동보조</label>
					</div>
					<div style="width:32%">
						<input type="radio" name="patient_type1" value="2" id="option1_2" <?=$data['patient_type1'] == 2 ? "checked":""?>>
						<label for="option1_2">불가능</label>
					</div>
				</div>
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 6:9?></p>
				<p>식사상태를 선택하세요</p>
				<div class="state_form">
					<div style="width:32%">
						<input type="radio" name="patient_type2" value="1" id="option2_1" checked <?=$data['patient_type2'] == 1 ? "checked":""?>>
						<label for="option2_1">가능</label>
					</div>
					<div style="width:32%">
						<input type="radio" name="patient_type2" value="2" id="option2_2" <?=$data['patient_type2'] == 2 ? "checked":""?>>
						<label for="option2_2">피딩</label>
					</div>
					<div style="width:32%">
						<input type="radio" name="patient_type2" value="3" id="option2_3" <?=$data['patient_type2'] == 3 ? "checked":""?>>
						<label for="option2_3">금식</label>
					</div>
				</div>
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 7:10?></p>
				<p>수면상태를 선택하세요</p>
				<div class="state_form">
					<div>
						<input type="radio" name="patient_type3" value="1" id="option3_1" checked <?=$data['patient_type3'] == 1 ? "checked":""?>>
						<label for="option3_1">숙면</label>
					</div>
					<div>
						<input type="radio" name="patient_type3" value="2" id="option3_2" <?=$data['patient_type3'] == 2 ? "checked":""?>>
						<label for="option3_2">불면증</label>
					</div>
				</div>
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 8:11?></p>
				<p>섬망상태를 선택하세요</p>
				<div class="state_form">
					<div>
						<input type="radio" name="patient_type4" value="1" id="option4_1" checked <?=$data['patient_type4'] == 1 ? "checked":""?>>
						<label for="option4_1">없음</label>
					</div>
					<div>
						<input type="radio" name="patient_type4" value="2" id="option4_2" <?=$data['patient_type4'] == 2 ? "checked":""?>>
						<label for="option4_2">있음</label>
					</div>
				</div>
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 9:12?></p>
				<p>치매상태를 선택하세요</p>
				<div class="state_form">
					<div>
						<input type="radio" name="patient_type5" value="1" id="option5_1" checked <?=$data['patient_type5'] == 1 ? "checked":""?>>
						<label for="option5_1">없음</label>
					</div>
					<div>
						<input type="radio" name="patient_type5" value="2" id="option5_2" <?=$data['patient_type5'] == 2 ? "checked":""?>>
						<label for="option5_2">있음</label>
					</div>
				</div>
			</div>
        </div>
        <div class="btn_box d-flex">
            <a href="<?=$hire_no != 0 ? "pay-form2.php?hire_no=".$hire_no:"pay-form2.php"?>" style="color:#fff; background: #000; width: 50%">이전</a>
            <button id="saveForm" style="background: #3478F6; width: 50%">다음</button>
        </div>
    </form>
</div>
<?php
include('../../lib/footer.php');
?>
<script>

$(document).ready(function(){

	var patient_type1 = getCookie("patient_type1");
	var patient_type2 = getCookie("patient_type2");
	var patient_type3 = getCookie("patient_type3");
	var patient_type4 = getCookie("patient_type4");
	var patient_type5 = getCookie("patient_type5");

	$("input[name='patient_type1'][value="+patient_type1+"]").prop("checked",true);
	$("input[name='patient_type2'][value="+patient_type2+"]").prop("checked",true);
	$("input[name='patient_type3'][value="+patient_type3+"]").prop("checked",true);
	$("input[name='patient_type4'][value="+patient_type4+"]").prop("checked",true);
	$("input[name='patient_type5'][value="+patient_type5+"]").prop("checked",true);
	
})

$('#saveForm').click(function(){
	var patient_type1 = $("input[name='patient_type1']:checked").val();
	setCookie("patient_type1", patient_type1, 1);
	var patient_type2 = $("input[name='patient_type2']:checked").val();
	setCookie("patient_type2", patient_type2, 1);
	var patient_type3 = $("input[name='patient_type3']:checked").val();
	setCookie("patient_type3", patient_type3, 1);
	var patient_type4 = $("input[name='patient_type4']:checked").val();
	setCookie("patient_type4", patient_type4, 1);
	var patient_type5 = $("input[name='patient_type5']:checked").val();
	setCookie("patient_type5", patient_type5, 1);
})

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