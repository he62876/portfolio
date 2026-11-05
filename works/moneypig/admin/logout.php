<?php
//include_once ("../_inc/inc_ss.php");
session_start();
$result = session_destroy();
header("Content-Type:text/html;charset=utf-8");
if($result) { //세션닫기에 성공하면 
    ?>
	<script>
			location.replace("login.php"); //다시 처음 페이지로 돌아간다
	</script>
    <?php   }
?>
