<?php
include('../../../common.php');
include_once ("../../../_inc/push.php");
$push = new PushServer();
$push->db = &$pdo; 

$param = null;

$mode			= $_POST['mode'];

$user_no		= $_POST['user_no'];
$hire_no		= $_POST['hire_no'];
$pay_no			= $_POST['pay_no'];
$info			= $_POST['info'];
$reg_date		= date('Y-m-d H:i:s');

if($mode == "state_del") {
	$hire_no	= $_POST['hire_no'];
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"state_del");
	$rs = $pdo->query("UPDATE hire_info SET use_yn=0 where hire_no=".$hire_no, $param);
	if($rs>0){
		$result['resCode'] = 1;
	}
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;
}
if($mode == "state_can") {
	$hire_no	= $_POST['hire_no'];
	$fin_why	= $_POST['fin_why'];
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"state_can");
	$rs = $pdo->query("UPDATE hire_info SET state = 1, up_reg_date = '$reg_date' WHERE hire_no=".$hire_no, $param);
		  $pdo->query("UPDATE pay_info SET state = 99, fin_why = '$fin_why', up_reg_date = '$reg_date' WHERE state = 2 AND hire_no = ".$hire_no, $param);
	if($rs>0){
		$result['resCode'] = 1;
	}

	$user_no = $pdo->single("SELECT user_no FROM hire_info WHERE hire_no = ".$hire_no, $param);
	$user_no1 = $pdo->single("SELECT user_no FROM pay_info WHERE hire_no = ".$hire_no, $param);
	$type = $pdo->single("SELECT user_grade FROM hire_info WHERE hire_no = ".$hire_no, $param);
	if($type == 1) {
		$push->new_estimate_can($user_no1, $hire_no, $user_no);
	} else {
		$push->new_hire_can($user_no1, $hire_no, $user_no);
	}

	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;
}
if($mode == "appl_can") {
	$hire_no	= $_POST['hire_no'];
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"appl_can");
	$rs = $pdo->query("UPDATE hire_info SET state = 99, up_reg_date = '$reg_date' WHERE hire_no=".$hire_no, $param);
	if($rs>0){
		$result['resCode'] = 1;
	}
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;
}
if($mode == "work_fin") {
	$hire_no	= $_POST['hire_no'];
	$fin_why	= $_POST['fin_why'];
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"work_fin");
	$rs = $pdo->query("UPDATE hire_info SET state = 10, fin_why = '$fin_why', up_reg_date = '$reg_date' WHERE hire_no=".$hire_no, $param);
	if($rs>0){
		$result['resCode'] = 1;
	}

	$user_no = $pdo->single("SELECT user_no FROM hire_info WHERE hire_no = ".$hire_no, $param);
	$user_no1 = $pdo->single("SELECT user_no FROM pay_info WHERE hire_no = ".$hire_no, $param);
	$type = $pdo->single("SELECT user_grade FROM hire_info WHERE hire_no = ".$hire_no, $param);
	if($type == 1) {
		$push->new_estimate_fin($user_no1, $hire_no, $user_no);
	} else {
		$push->new_hire_fin($user_no1, $hire_no, $user_no);
	}

	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;
}

if($mode == "pay") {
	$grade	= $_POST['user_grade'];
	$type	= $_POST['type'];
	$pay	= $type == 1 ? $_POST['pay']:0;

	$membership		= $_POST['membership'];
	$ticket			= $_POST['ticket'];

	$pay_data = $pdo->query("SELECT * FROM pay_info WHERE hire_no = '$hire_no' AND user_no = '$user_no' AND state = 1", $param);
	$work_data = $pdo->query("SELECT * FROM hire_info WHERE hire_no = '$hire_no' AND state = 2", $param);
	
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"pay");

	if(!$pay_data && !$work_data) {
		$rs = $pdo->query("INSERT INTO pay_info (type, hire_no, user_no, pay, reg_date) VALUES ('$type', '$hire_no', '$user_no', '$pay', '$reg_date')", $param);
		if($membership == 0 && $ticket > 0) {
			  $pdo->query("UPDATE user_info SET ticket = ticket - 1 WHERE user_no = ".$user_no, $param);
		}

		$user_no1 = $pdo->single("SELECT user_no FROM hire_info WHERE hire_no = ".$hire_no, $param);
		//$user_no1 = $pdo->lastInsertId();
		if($type == 1) {
			$push->new_estimate_in($user_no1, $hire_no, $user_no);
		} else {
			$push->new_hire_in($user_no1, $hire_no, $user_no);
		}
	}

	if($rs>0){
		$result['resCode'] = 1;
	} else if ($work_data != null) {
		$result['resCode'] = -2;
	}
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;

	//$sql = "INSERT INTO pay_info (type, hire_no, user_no, pay, reg_date) VALUES ('$type', '$hire_no', '$user_no', '$pay', '$reg_date')";
}

if($mode == "pay_ok") {

	
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"pay_ok");
	$rs =  $pdo->query("UPDATE pay_info SET state = 2, up_reg_date = '$reg_date' WHERE pay_no = '$pay_no'",$param);
		   $pdo->query("UPDATE hire_info SET state = 2, up_reg_date = '$reg_date' WHERE hire_no = '$hire_no'", $param);
	if($rs>0){
		$result['resCode'] = 1;
	}

	$user_no = $pdo->single("SELECT user_no FROM hire_info WHERE hire_no = ".$hire_no, $param);
	$user_no1 = $pdo->single("SELECT user_no FROM pay_info WHERE hire_no = ".$hire_no, $param);
	$type = $pdo->single("SELECT user_grade FROM hire_info WHERE hire_no = ".$hire_no, $param);
	if($type == 1) {
		$push->new_estimate_ok($user_no1, $hire_no, $user_no);
	} else {
		$push->new_hire_ok($user_no1, $hire_no, $user_no);
	}

	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;


}

if($mode == "cancel") {
	
	$cancel = $_POST['cancel'];
	//10취소승인대기 11간병취소요청(받음)

	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"cancel");
	if($info == "hire") {
		$rs = $pdo->query("UPDATE hire_info SET state = 10, cancel = '$cancel', up_reg_date = '$reg_date' WHERE hire_no = '$hire_no'", $param);
			  $pdo->query("UPDATE pay_info SET state = 11, up_reg_date = '$reg_date' WHERE pay_no = '$pay_no'",$param);
	}

	if($info == "pay") {
		$rs = $pdo->query("UPDATE pay_info SET state = 10, cancel = '$cancel', up_reg_date = '$reg_date' WHERE pay_no = '$pay_no'", $param);
			  $pdo->query("UPDATE hire_info SET state = 11, up_reg_date = '$reg_date' WHERE hire_no = '$hire_no'",$param);
	}

	if($rs>0){
		$result['resCode'] = 1;
	}
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;

}

if($mode == "cancel_ok") {
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"cancel_ok");
	$rs = $pdo->query("UPDATE hire_info SET state = 99, up_reg_date = '$reg_date' WHERE hire_no = '$hire_no'", $param);
		  $pdo->query("UPDATE pay_info SET state = 99, up_reg_date = '$reg_date' WHERE pay_no = '$pay_no'",$param);
	if($rs>0){
		$result['resCode'] = 1;
	}
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;

}

if($mode == "singo") {
	$singo_why		= $_POST['singo_why'];
	$singo_cont		= $_POST['singo_cont'];
	$singo_user_no	= $_POST['singo_user_no'];
	$other_user_no	= $_POST['other_user_no'];
	
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"singo");
	$rs = $pdo->query("INSERT INTO singo_info (singo_type, singo_cont, singo_user_no, other_user_no, reg_date) VALUES ('$singo_why', '$singo_cont', '$singo_user_no', '$other_user_no', '$reg_date')", $param);
	if($rs>0){
		$result['resCode'] = 1;
	}
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;

}

if($mode == "serch_hospital") {
	$hospital_nm	= $_POST['hospital_nm'];
	
	$sql = "SELECT dutyName, dutyAddr FROM hospital_info WHERE dutyName LIKE '%".$hospital_nm."%'";
	$agcy = $pdo->query($sql, $param);
	$arr1 = null;
	$temp1 = null;
	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"serch_hospital");
	foreach($agcy as $d){
		$temp1['dutyName'] = $d['dutyName'];
		$temp1['dutyAddr'] = $d['dutyAddr'];
		$arr1[] = $temp1;
	}
	$result['hospital'] = $arr1;
	$result['resCode'] = 1;
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;
}

$result = $pdo->query($sql, $param);
if($result>0) { ?>
	<script>
		location.replace('state-list.php?type=<?=$type?>');
	</script>
<?php }

?>