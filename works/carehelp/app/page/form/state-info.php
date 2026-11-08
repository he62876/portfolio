<?php
include('../../lib/header.php');
$title = "미리보기";
include('../../lib/title.php');
include('../../../common.php');

$param = null;

$hire_no = $_GET['hire_no']==null? 0:$_GET['hire_no'];

$hire_nm = array(0 => "성별무관", 1 => "남성", 2 => "여성");
$type1 = array(1 => "혼자가능", 2 => "불가능", 3 => "거동보조");
$type2 = array(1 => "가능", 2 => "피딩", 3 => "금식");

$type8 = $pdo->query("SELECT * FROM code_info WHERE majr = 8 AND use_yn = 1 ORDER BY minr");

$date = date('Y-m-d H:m:s');
$sdate = $_COOKIE['hire_sdate']." ".$_COOKIE['hire_stime'].":00:00";
$edate = $_COOKIE['hire_edate']." ".$_COOKIE['hire_etime'].":00:00";
$edate_time = $_COOKIE['end_date'];


$endDate = strtotime($_COOKIE['end_date']);
$today = strtotime(date('Y-m-d H:i:s'));

$diff = $endDate - $today;

//$day = floor($diff/(24*3600));
//$diff = $diff-($day*(24*3600));
$hours = floor($diff/3600);

$user = $pdo->row("SELECT * FROM user_info WHERE user_no = ".$_SESSION['user_no']);

$pay_type = array(1 => '시급', 2 => '일급', 3 => '월급');
$time_type = array(1 => '주간(7:30 ~ 19:30)', 2 => '야간(19:30 ~ 7:30)', 3 => '24시간', 4 => '격일', 10 => '시간협의');
?>
<style>
body {
	background: #F8F8F8;
}

p {
    font-size: 1.5rem;
    font-weight: bold;
}

.content_page {
	margin-bottom: 50px;
}
.popup_form  .content_page {
	margin-bottom: 0;
}

.state_form {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.state_info {
	max-width: 768px;
	margin: 0 auto;
	position: absolute;
	bottom: 0;
}

.date_state {
    margin-bottom: 20px;
}

table.info_table {
    margin: 5px 0 20px 0;
}

table td a {
    display: inline;
    color: #000;
    padding: 2px 8px;
    margin-left: 5px;
    font-size: 0.9rem;
    font-weight: 500;
    border: 1px solid #DEDEDE;
    border-radius: 3px;
}
</style>
<div class="content_wrap">
    <div class="content_page">
		<?php if ($data['user_no'] == $_SESSION['user_no']) { ?>
        <div class="d-flex justify-content-between align-items-center date_state">
            <p><?=substr(NOW(),0,10)?></p>
            <span style="margin-right:0; color:#3478F6;">견적요청중</span>
        </div>
		<?php } else { ?>
        <div class="date_state">
			<?php if($grade == 1) { ?>
            <p><?=$_COOKIE['patient_sex'] == 1 ? "남성":"여성"?>/<?=$_COOKIE['patient_age']?>세/<?=$_COOKIE['patient_weight']?>kg</p>
			<?php } else { 
					$sql = "SELECT * FROM user_info WHERE user_no = ".$_SESSION['user_no'];
					$user_info = $pdo->row($sql, $param); ?>
            <p><?=$user_info['association_nm']?>/<?=$user_info['responsibility']?></p>
			<?php } ?>
			<?php if($day.$hours > 0) { ?>
			<p style="color:#3478F6; font-size: 1.3rem; font-weight: bold;">공고 <?=($hours + 24)."시간 남음"?></p>
			<?php } ?>
        </div>
		<?php } ?>
		<div class="state_card">
			<div class="state_header">
				<p>기본정보</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<?php if($grade == 3) { ?>
					<tr>
						<th>분류</th>
						<td><?=$_COOKIE['hire_type'] == 1 ? "개인간병":"공동간병"?></td>
					</tr>
					<?php } ?>
					<?php if($_COOKIE['hire_type'] == 1) { ?>
					<tr>
						<th>근무형태</th>
						<td><?=$_COOKIE['addr_type'] == 1 ? "병원간병":"재가간병"?></td>
					</tr>
					<?php } ?>
					<?php if($_COOKIE['hire_type'] == 2) { ?>
					<tr>
						<th>환자 수</th>
						<td><?=$_COOKIE['patient_cnt']?>명</td>
					</tr>
					<tr>
						<th>모집인원 수</th>
						<td><?=$_COOKIE['work_cnt']?>명</td>
					</tr>
					<?php } ?>
					<?php if($grade == 3) { ?>
					<tr>
						<th>간병위치</th>
						<td><?=urldecode($_COOKIE['addr1'])?> <?=urldecode($_COOKIE['addr2'])?></td>
					</tr>
					<?php } ?>
					<tr>
						<th>간병기간</th>
						<td><?=$_COOKIE['hire_sdate']?> <?=$_COOKIE['hire_stime']?>:00 ~ <?=$_COOKIE['hire_edate']?> <?=$_COOKIE['hire_etime']?>:00</td>
					</tr>
					<tr>
						<th>간병시간</th>
						<td><?=$time_type[$_COOKIE['hire_time']]?></td>
					</tr>
					<tr>
						<th>선호성별</th>
						<td><?=$hire_nm[$_COOKIE['hire_sex']]?></td>
					</tr>
					<?php if($_COOKIE['user_grade'] == 3) { ?>
					<tr>
						<th>간병비</th>
                        <td style="color:#3478F6; font-weight: bold;"><?=$_COOKIE['pay_type'] == 4 ? "보호자와 협의":$pay_type[$_COOKIE['pay_type']]." / ".number_format($_COOKIE['pay'])."원"?></td>
					</tr>
					<?php } ?>
					<!--<tr>
						<th>게시기간</th>
						<td>5일 후 12시 종료</td>
					</tr>-->
				</table>
			</div>
		</div>
		<?php if($grade == 1) { ?>
		<div class="state_card">
			<div class="state_header">
				<p>장소</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<th>구분</th>
						<td><?=$_COOKIE['addr_type'] == 1 ? "병원":"집"?></td>
					</tr>
					<tr>
						<th>주소</th>
						<?php
							if($_COOKIE['addr_type'] == 1) {
								$hospital = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".urldecode($_COOKIE['addr1'])."'", $param);
							}
						?>
						<td><?=$_COOKIE['addr_type'] == 1 ? $hospital."</br>":""?><?=urldecode($_COOKIE['addr1'])?><?=$_COOKIE['addr_type'] == 2 ? '</br>'.urldecode($_COOKIE['addr2']):""?></td>
					</tr>
					<?php if($_COOKIE['addr_type'] == 1) { ?>
					<tr>
						<th>병동/병실</th>
						<td><?=urldecode($_COOKIE['addr2'])?></td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</div>
		<?php } ?>
		<?php if($_COOKIE['hire_type'] != 2) { ?>
		<div class="state_card">
			<div class="state_header">
				<p>환자정보</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<th>환자명</th>
						<td><?=$_COOKIE['patient_name'] == null ? '-':urldecode($_COOKIE['patient_name'])?></td>
					</tr>
					<tr>
						<th>나이</th>
						<td><?=$_COOKIE['patient_age']?>세</td>
					</tr>
					<tr>
						<th>성별</th>
						<td><?=$_COOKIE['patient_sex'] == 1 ? "남성":"여성"?></td>
					</tr>
					<tr>
						<th>몸무게</th>
						<td><?=$_COOKIE['patient_weight']?>kg</td>
					</tr>
					<tr>
						<th>진단정보</th>
						<td><?=$_COOKIE['patient_cont'] == null ? "-":urldecode($_COOKIE['patient_cont'])?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="state_card">
			<div class="state_header">
				<p>증상정보</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<th>거동상태</th>
						<td><?=$type1[$_COOKIE['patient_type1']]?></td>
					</tr>
					<tr>
						<th>식사상태</th>
						<td><?=$type2[$_COOKIE['patient_type2']]?></td>
					</tr>
					<tr>
						<th>수면상태</th>
						<td><?=$_COOKIE['patient_type3'] == 1 ? "숙면":"불면증"?></td>
					</tr>
					<tr>
						<th>섬망상태</th>
						<td><?=$_COOKIE['patient_type4'] == 1 ? "없음":"있음"?></td>
					</tr>
					<tr>
						<th>치매상태</th>
						<td><?=$_COOKIE['patient_type5'] == 1 ? "없음":"있음"?></td>
					</tr>
					<tr>
						<th>배설상태</th>
						<td>
						<?php if($_COOKIE['patient_type6'] != 0) {
							$type6_list = explode(",", $_COOKIE['patient_type6']);
							foreach($type6_list as $tp6) {
								$type6 = $pdo->single("SELECT name FROM code_info WHERE majr = 6 AND minr =".$tp6);
								$arr6[] = $type6; 
							}
							$type6 = implode("</br>", $arr6);	
							}
						?>
							<?=$type6 == null ? "해당없음":$type6?>
						</td>
					</tr>
					<!--<tr>
						<th>격리상태</th>
						<td>
						<?php if($_COOKIE['patient_type7'] != 0) {
							$type7_list = explode(",", $_COOKIE['patient_type7']);
							foreach($type7_list as $tp7) {
								$type7 = $pdo->single("SELECT name FROM code_info WHERE majr = 7 AND minr =".$tp7);
								$arr7[] = $type7; 
							}
							$type7 = implode(", ", $arr7);	
							}
						?>
							<?=$type7 == null ? "해당없음":$type7?>
						</td>
					</tr>-->
					<tr>
						<th>특이사항</th>
						<td>
						<?php if($_COOKIE['patient_type8'] != 0) {
							$type8_list = explode(",", $_COOKIE['patient_type8']);
							foreach($type8_list as $tp8) {
								$type8 = $pdo->single("SELECT name FROM code_info WHERE majr = 8 AND minr =".$tp8);
								$arr8[] = $type8; 
							}
							$type8 = implode("</br>", $arr8);	
							}
						?>
							<?=$type8 == null || $_COOKIE['patient_type8'] == 0 ? "해당없음":$type8?> 
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>
		<div class="state_card">
			<div class="state_header">
				<p>상세내용</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<td><?=$_COOKIE['hire_cont'] == null ? '-':nl2br(urldecode($_COOKIE['hire_cont']))?></td>
					</tr>
				</table>
			</div>
		</div>
    </div>
    <form action="json.php" class="state_info" method="POST" onsubmit="return doubleSubmitCheck(this, event);">
        <a href="/app/page/form/pay-form1.php?hire_no=<?=$hire_no?>" style="background: #3478F6;">수정하기</a>
        <button id="button1" type="submit" style="background: #000;">완료하기</button>
    </form>
			<div class="popup_form popup_form1">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">정말 삭제하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="deleteOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
</div>
<?php
include('../../lib/footer.php');
?>
<script type="text/javascript">



var isSubmit = false;
function doubleSubmitCheck(form, e){
    e.preventDefault();
	//window.nightingale.showLoading('1');
    if(isSubmit){
		//console.log("등록중");
        return false;
    }else{
        form.submit();
		//console.log("성공");
        isSubmit = true;
        return true;
    }
}


</script>