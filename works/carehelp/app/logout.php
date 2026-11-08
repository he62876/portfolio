<?php
include_once ("../_inc/inc_ss.php");
$result = session_destroy();
header("Content-Type:text/html;charset=utf-8");
if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
if($result) { //세션닫기에 성공하면 
    ?>
	<script>
			location.replace("app.login.php"); //다시 처음 페이지로 돌아간다
	</script>
    <?php   }
}
else{
if($result) { //세션닫기에 성공하면 
    ?>
	<script>
			location.replace("login.php"); //다시 처음 페이지로 돌아간다
	</script>
    <?php   }
}
?>
