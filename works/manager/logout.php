<?php
//include_once ("../_inc/inc_ss.php");
if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
include_once ($_SERVER['DOCUMENT_ROOT']."/_inc/inc_ss.php");
}
else if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
include_once ($_SERVER['DOCUMENT_ROOT']."/_inc/inc_ss.php");
}
else{
session_start();
}
$result = session_destroy();
header("Content-Type:text/html;charset=utf-8");
if($result) { //세션닫기에 성공하면 
    ?>
	<script>
			location.replace("app.php"); //다시 처음 페이지로 돌아간다
	</script>
    <?php   }
?>
