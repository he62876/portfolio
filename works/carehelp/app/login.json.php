<?php
//session_start();
include "../common.php";
include_once ("../_inc/inc_ss.php");
include_once ("../_inc/inc_fn.php");
$grade = $_REQUEST['grade'];

//$_SESSION['grade'] = $grade;
$userAgent = $_SERVER['HTTP_USER_AGENT'];
PhpLog("id:".$_SERVER['HTTP_USER_AGENT']);

if (ss_isUserLogOn())
{
	if(isset($_SESSION['grade'])) {
		if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
			$ret = $pdo->row("SELECT AES_DECRYPT(UNHEX(user_tel),KEY) as user_tel,auth_num,association_nm FROM user_info WHERE user_no = ".$_SESSION['user_no']." AND state=1");
			header('location: index.php?user_tel='.$ret["user_tel"].'&auth_num='.$ret["auth_num"].'&grade='.$_SESSION['grade'].'&user_no='.$_SESSION['user_no'].'&association_no='.($ret['association_nm']==null? 0:$ret['association_nm']));
		}
		else if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			$ret = $pdo->row("SELECT AES_DECRYPT(UNHEX(user_tel),KEY) as user_tel,auth_num,association_nm FROM user_info WHERE user_no = ".$_SESSION['user_no']." AND state=1");
			header('location: index.php?user_tel='.$ret["user_tel"].'&auth_num='.$ret["auth_num"].'&grade='.$_SESSION['grade'].'&user_no='.$_SESSION['user_no'].'&association_no='.($ret['association_nm']==null? 0:$ret['association_nm']));
			PhpLog("id:".$_SERVER['HTTP_X_REQUESTED_WITH']);
		}
		else{
			$ret = $pdo->row("SELECT AES_DECRYPT(UNHEX(user_tel),KEY) as user_tel,auth_num,association_nm FROM user_info WHERE user_no = ".$_SESSION['user_no']." AND state=1");
			header('location: index.php');
		}
	}
}
else{
	$_SESSION['grade'] = $grade;
	if(isset($_SESSION['grade'])) {
		header('location: index.php');
	}
}
?>
