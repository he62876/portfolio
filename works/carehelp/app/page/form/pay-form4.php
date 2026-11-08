<?php
include('../../lib/header.php');
$title = $grade == 1 ? "간병요청하기":"구인요청하기";
include('../../lib/title.php');
include('../../../common.php');

$param = null;
$sql = "SELECT * FROM code_info WHERE majr = 6 AND minr != 0 AND use_yn = 1";
$option6 = $pdo->query($sql, $param);
$sql = "SELECT * FROM code_info WHERE majr = 7 AND minr != 0 AND use_yn = 1";
$option7 = $pdo->query($sql, $param);
$sql = "SELECT * FROM code_info WHERE majr = 8 AND minr != 0 AND use_yn = 1";
$option8 = $pdo->query($sql, $param);

$hire_no = $_GET['hire_no'] == null ? 0:$_GET['hire_no'];

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
        right: 0;
    }

    .state_form {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin: 20px 0;
    }
    .state_form > div {
        width: 100%;
        margin-bottom: 15px;
    }
    .state_form > div input {
        display: none;
    }
    .state_form > div label {
        font-size: 1.3rem;
        vertical-align: middle;
    }
    .state_form > div label::before {
        content: '';
        display: inline-block;
        vertical-align: bottom;
        width: 25px; height: 25px;
        background: url('../../../img/check_off.svg');
        background-size: cover;
        margin-right: 10px;
    }
    .state_form > div input:checked + label::before {
        background: url('../../../img/check_on.svg');
        background-size: cover;
    }

</style>
<div class="content_wrap">
    <div class="progress_bar">
        <div class="progress_color" style="width: 80%;"></div>
    </div>
    <form action="<?=$hire_no != 0 ? "pay-form5.php?hire_no=".$hire_no:"pay-form5.php"?>" class="state_info" method="POST">
        <div class="content_page">
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 10:13?></p>
				<p>배설상태를 선택하세요</br>(*중복 선택 가능)</p>
				<div class="state_form">
					<!--<div>
						<input type="checkbox" name="patient_type6" id="option6_0" value="0">
						<label for="option6_0">해당없음</label>
					</div>-->
					<?php foreach($option6 as $d){ ?>
					<div>
						<input type="checkbox" name="patient_type6" id="option6_<?=$d['minr']?>" value="<?=$d['minr']?>" <?=in_array($d['minr'], explode(",", $data['patient_type6']))? 'checked': ''?>>
						<label for="option6_<?=$d['minr']?>"><?=$d['name']?></label>
					</div>
					<?php } ?>
				</div>
            <!--<p>격리상태를 선택하세요</p>
            <div class="state_form">
                <div>
                    <input type="checkbox" name="patient_type7" id="option7_0" value="0">
                    <label for="option7_0">해당없음</label>
                </div>
				<?php foreach($option7 as $d){ ?>
                <div>
                    <input type="checkbox" name="patient_type7" id="option7_<?=$d['minr']?>" value="<?=$d['minr']?>" <?=in_array($d['minr'], explode(",", $data['patient_type7']))? 'checked': ''?>>
                    <label for="option7_<?=$d['minr']?>"><?=$d['name']?></label>
                </div>
				<?php } ?>
            </div>-->
			</div>
			<div class="form_box">
				<p class="form_num"><?=$grade == 1 ? 11:14?></p>
				<p>그 외 상태를 선택하세요</br>(*중복 선택 가능)</p>
				<div class="state_form">
					<?php foreach($option8 as $d){ ?>
					<div>
						<input type="checkbox" name="patient_type8" id="option8_<?=$d['minr']?>" value="<?=$d['minr']?>" <?=in_array($d['minr'], explode(",", $data['etc']))? 'checked': ''?>>
						<label for="option8_<?=$d['minr']?>"><?=$d['name']?></label>
					</div>
					<?php } ?>
				</div>
			</div>
        </div>
        <div class="btn_box d-flex">
            <a href="<?=$hire_no != 0 ? "pay-form3.php?hire_no=".$hire_no:"pay-form3.php"?>" style="color:#fff; background: #000; width: 50%">이전</a>
            <button id="saveForm" style="background: #3478F6; width: 50%">다음</button>
        </div>
    </form>
</div>
<?php
include('../../lib/footer.php');
?>
<script>

$(document).ready(function(){
	var patient_type6 = getCookie("patient_type6");
		patient_type6 = patient_type6.split(',');
	/*var patient_type7 = getCookie("patient_type7");
		patient_type7 = patient_type7.split(',');*/
	var patient_type8 = getCookie("patient_type8");
		patient_type8 = patient_type8.split(',');

	for(var i = 0; i < patient_type6.length; i++) {
		$("input[name='patient_type6']").each(function(){
			if(this.value == patient_type6[i]){
				this.checked = true;
			}
		})
	}

	/*for(var i = 0; i < patient_type7.length; i++) {
		$("input[name='patient_type7']").each(function(){
			if(this.value == patient_type7[i]){
				this.checked = true;
			}
		})
	}*/

	for(var i = 0; i < patient_type8.length; i++) {
		$("input[name='patient_type8']").each(function(){
			if(this.value == patient_type8[i]){
				this.checked = true;
			}
		})
	}
})

$('#saveForm').click(function(){
	var type6 = [];
	//var type7 = [];
	var type8 = [];
	$("input[name='patient_type6']:checked").each(function(){
		var patient_type6 = $(this).val();
			type6.push(patient_type6);
			setCookie('patient_type6', type6, 1);
	})
	/*$("input[name='patient_type7']:checked").each(function(){
		var patient_type7 = $(this).val();
			type7.push(patient_type7);
			setCookie('patient_type7', type7, 1);
	})*/
	$("input[name='patient_type8']:checked").each(function(){
		var patient_type8 = $(this).val();
			type8.push(patient_type8);
			setCookie('patient_type8', type8, 1);
	})
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

 

</script>