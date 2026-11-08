<?php

ini_set('display_errors', '0');

include('../../lib/header.php');
include('../../../common.php');
include_once ("../../../_inc/inc_fn.php");
$param = null;

$mode			= $_COOKIE['mode'];
$hire_no		= $_COOKIE['hire_no'];

$user_grade		= $_COOKIE['user_grade'];
$user_no		= $_COOKIE['user_no'];
$hire_type		= $user_grade == 1 ? 0:$_COOKIE['hire_type'];
$patient_cnt	= $hire_type == 1 || $user_grade == 1 ? 0:$_COOKIE['patient_cnt'];
$patient_tel	= $_COOKIE['patient_tel'];
$work_cnt		= $hire_type == 1 || $user_grade == 1 ? 1:$_COOKIE['work_cnt'];
$pay_type		= $user_grade == 1 ? 0:$_COOKIE['pay_type'];
$pay			= $user_grade == 1 || $pay_type == 4 ? 0:$_COOKIE['pay'];
$hire_cont		= $_POST['hire_cont'] == null ? urldecode($_COOKIE['hire_cont']):$_POST['hire_cont'];
$addr_type		= $_COOKIE['addr_type'];
$addr1			= urldecode($_COOKIE['addr1']);
$addr2			= urldecode($_COOKIE['addr2']);
$hospital_name	= urldecode($_COOKIE['hospital_name']);
//$hire_addr		= $addr_type == 1 ? $addr1." ".$addr2:$addr1;
$hire_sdate		= $_COOKIE['hire_sdate'];
$hire_stime		= $_COOKIE['hire_stime'];
$hire_edate		= $_COOKIE['hire_edate'];
$hire_etime		= 23;
$hire_time		= $_COOKIE['hire_time'];
$patient_name	= urldecode($_COOKIE['patient_name']);
$patient_age	= $hire_type == 2 ? 0:$_COOKIE['patient_age'];
$patient_weight = $hire_type == 2 ? 0:$_COOKIE['patient_weight'];
$patient_sex	= $hire_type == 2 ? 0:$_COOKIE['patient_sex'];
$patient_cont	= urldecode($_COOKIE['patient_cont']);
$patient_type1	= $hire_type == 2 ? 0:$_COOKIE['patient_type1'];
$patient_type2	= $hire_type == 2 ? 0:$_COOKIE['patient_type2'];
$patient_type3	= $hire_type == 2 ? 0:$_COOKIE['patient_type3'];
$patient_type4	= $hire_type == 2 ? 0:$_COOKIE['patient_type4'];
$patient_type5	= $hire_type == 2 ? 0:$_COOKIE['patient_type5'];
$patient_type6	= $hire_type == 2 ? 0:$_COOKIE['patient_type6'];
$patient_type7	= $hire_type == 2 ? 0:$_COOKIE['patient_type7'];
$patient_type8	= $_COOKIE['patient_type8'] == null ? 0:$_COOKIE['patient_type8'];
$hire_sex		= $_COOKIE['hire_sex'];
$end_date		= $_COOKIE['end_date']." 23:59:59";
$reg_date		= date('Y-m-d H:i:s');

if($mode == "input") {
	if($work_cnt == 1) {
		$sql = "INSERT INTO hire_info (user_grade, user_no, hire_type, patient_cnt, patient_tel, pay_type, pay, hire_cont, addr_type, hire_addr, hire_addr2, hospital_name, hire_sdate, hire_stime, hire_edate, hire_etime, hire_time, patient_name, patient_age, patient_weight, patient_sex, patient_cont, patient_type1, patient_type2, patient_type3, patient_type4, patient_type5, patient_type6, patient_type7, etc, hire_sex, end_date, reg_date)
						VALUES ('$user_grade', '$user_no', '$hire_type', '$patient_cnt', (HEX(AES_ENCRYPT('$patient_tel','naghtglae_00710'))), '$pay_type', '$pay', '$hire_cont', '$addr_type', '$addr1', '$addr2', '$hospital_name', '$hire_sdate', '$hire_stime', '$hire_edate', '$hire_etime', '$hire_time', '$patient_name', '$patient_age', '$patient_weight', '$patient_sex', '$patient_cont', '$patient_type1', '$patient_type2', '$patient_type3', '$patient_type4', '$patient_type5', '$patient_type6', '$patient_type7', '$patient_type8', '$hire_sex', '$end_date', '$reg_date')";
	} else {
		for($i = 1; $i <= $work_cnt; $i++) {
			
			$cnt = $i.'/'.$work_cnt;

			${'sql'.$i} = "INSERT INTO hire_info (user_grade, user_no, hire_type, patient_cnt, patient_tel, work_cnt, pay_type, pay, hire_cont, addr_type, hire_addr, hire_addr2, hospital_name, hire_sdate, hire_stime, hire_edate, hire_etime, hire_time, patient_name, patient_age, patient_weight, patient_sex, patient_cont, patient_type1, patient_type2, patient_type3, patient_type4, patient_type5, patient_type6, patient_type7, etc, hire_sex, end_date, reg_date)
						VALUES ('$user_grade', '$user_no', '$hire_type', '$patient_cnt', (HEX(AES_ENCRYPT('$patient_tel','naghtglae_00710'))), '$cnt', '$pay_type', '$pay', '$hire_cont', '$addr_type', '$addr1', '$addr2' , '$hospital_name', '$hire_sdate', '$hire_stime', '$hire_edate', '$hire_etime', '$hire_time', '$patient_name', '$patient_age', '$patient_weight', '$patient_sex', '$patient_cont', '$patient_type1', '$patient_type2', '$patient_type3', '$patient_type4', '$patient_type5', '$patient_type6', '$patient_type7', '$patient_type8', '$hire_sex', '$end_date', '$reg_date')";
		}
	}
}
if($mode == "update") {
	$sql = "UPDATE hire_info SET addr_type = '$addr_type', pay_type = '$pay_type', pay = '$pay', hire_addr = '$addr1', hire_addr2 = '$addr2', hospital_name = '$hospital_name', hire_sdate = '$hire_sdate', hire_stime = '$hire_stime', hire_edate = '$hire_edate', hire_etime = '$hire_etime', hire_time = '$hire_time', patient_tel = (HEX(AES_ENCRYPT('$patient_tel','naghtglae_00710'))),
			patient_name = '$patient_name', patient_age = '$patient_age', patient_weight = '$patient_weight', patient_sex = '$patient_sex', patient_cont = '$patient_cont',
			patient_type1 = '$patient_type1', patient_type2 = '$patient_type2', patient_type3 = '$patient_type3', patient_type4 = '$patient_type4', patient_type5 = '$patient_type5', patient_type6 = '$patient_type6', patient_type7 = '$patient_type7', etc = '$patient_type8', hire_sex = '$hire_sex', end_date = '$end_date', up_reg_date = '$reg_date'
			WHERE hire_no = '$hire_no'";
}


//echo $sql;
if($mode == 'input' && $work_cnt > 1) {
		for($i = 1; $i <= $work_cnt; $i++) {
			${'data'.$i} = $pdo->query(${'sql'.$i}, $param);
		}
} else {
	$data = $pdo->query($sql, $param);
}

//푸시적용
if($addr_type == 1) {
	$addr_data = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".$addr1."'", $param);
}
if($addr_type == 2) {
	$str = $addr1;
	$addr = explode(' ',$str);
	$cnt = count($addr);

for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
	$addr_data .= $addr[$i]." ";
	}
}
//echo $addr_data;

$patient_sex = $patient_sex == 1 ? "남성":"여성";

include_once ("../../../_inc/push.php");
$push = new PushServer();
$push->db = &$pdo; 
if($mode == "input") {
	$hire_no = $pdo->lastInsertId();
	if($grade == 3){
		$hire_type = $hire_type == 1 ? "개인":"공동";
		//협회면 구인푸시
		$push->new_hire($hire_no, $user_no, $hire_type, $addr_data, $patient_sex, $patient_age, $patient_weight);
	}
	else{
		//보호자이면 견적푸시
		$push->new_estimate($hire_no, $user_no, $addr_data, $patient_sex, $patient_age, $patient_weight);	
	}
}


setcookie("hire_no", "", time() - 3600);
setcookie("hire_type", "", time() - 3600);
setcookie("patient_cnt", "", time() - 3600);
setcookie("patient_tel", "", time() - 3600);
setcookie("work_cnt", "", time() - 3600);
setcookie("pay_type", "", time() - 3600);
setcookie("pay", "", time() - 3600);
setcookie("addr_type", "", time() - 3600);
setcookie("addr1", "", time() - 3600);
setcookie("addr2", "", time() - 3600);
setcookie("hire_addr", "", time() - 3600);
setcookie("hire_sdate", "", time() - 3600);
setcookie("hire_stime", "", time() - 3600);
setcookie("hire_edate", "", time() - 3600);
setcookie("hire_etime", "", time() - 3600);
setcookie("hire_time", "", time() - 3600);
setcookie("patient_name", "", time() - 3600);
setcookie("patient_age", "", time() - 3600);
setcookie("patient_weight", "", time() - 3600);
setcookie("patient_sex", "", time() - 3600);
setcookie("patient_cont", "", time() - 3600);
setcookie("patient_type1", "", time() - 3600);
setcookie("patient_type2", "", time() - 3600);
setcookie("patient_type3", "", time() - 3600);
setcookie("patient_type4", "", time() - 3600);
setcookie("patient_type5", "", time() - 3600);
setcookie("patient_type6", "", time() - 3600);
setcookie("patient_type7", "", time() - 3600);
setcookie("patient_type8", "", time() - 3600);
setcookie("hire_sex", "", time() - 3600);
setcookie("end_date", "", time() - 3600);
setcookie("hire_cont", "", time() - 3600);

?>
<script>
	location.replace('fin.php');
</script>