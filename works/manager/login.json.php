<?php
include('common.php');
if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
include_once ("_inc/inc_ss.php");
include_once ("_inc/inc_fn.php");

}
else{
session_start();
}
$prevPage = $_SERVER['HTTP_REFERER'];

$id   = $_POST['user_id'];
$pass = $_POST['user_pw'];
$type = $_POST['user_tp'];


$param = null;

$sql = "SELECT *,CASE WHEN user_pw = PASSWORD('".$pass."') THEN 1 ELSE 0 END AS ipw FROM user_info WHERE user_tp = '$type' AND user_id = '$id'  AND state = 1";
$data = $pdo->row($sql, $param);

if($id==""){?>
    <script>
        alert('아이디를 입력해 주세요');
        history.back();
    </script>
	
<?}
else if($pass==""){
	?>
    <script>
        alert('비밀번호를 입력해 주세요');
        history.back();
    </script>
<?}
else{
if($data) { 
	if($data['ipw']==0){?>
		<script>
			alert('비밀번호를 확인해 주세요');
			history.back();
		</script>

	<?}
	else{
		$rs = $pdo->query("UPDATE user_info SET push_key='".$_COOKIE['Push']."'   WHERE user_no = ".$data['user_no']);
		$_SESSION['lv'] = $data['user_tp'];
		$_SESSION['no'] = $data['user_no'];
		$_SESSION['id'] = $data['user_id'];
		$_SESSION['name'] = $data['user_nm'];
		$_SESSION['sess_no'] = $data['user_no'];
		
		if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			
			if (isset($_SESSION['sess_no']) && $_SESSION['sess_no'] == 0) session_destroy();
			session_write_close();
		}
		if($data ) {
			header('location: /app.php?user_tp='.$_SESSION["lv"].'&user_id='.$_SESSION["id"].'&user_no='.$_SESSION['no'].'&user_pw='.$data['user_pw']);
		}
	}
} else { ?>
    <script>
        alert('존재하지 않는 회원입니다. 로그인 정보를 확인하세요.');
        history.back();
    </script>
<? }
}
?>