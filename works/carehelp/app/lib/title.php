<?php if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  { 
$referer_domain = $_SERVER['HTTP_REFERER'];	
$href=$referer_domain;
//echo $href;
?>

<div id="title">
<?php if(basename($_SERVER['PHP_SELF'])=="join-form1.php"){?>
    <a href='javascript:back()'><img src="/img/back.svg" alt="" ></a>
<?}else if(basename($_SERVER['PHP_SELF'])=="kiosk.php"){?>
	<img src="/img/back.svg" alt="" onclick="location.replace('mypage.php');">
<?}else{?>
	<img src="/img/back.svg" alt="" onclick="history.back();">
<?}?>
    <p><?=$title?></p>
</div>
<script type="text/javascript" charset="UTF-8">
	function back(){
	//alert();
		window.webkit.messageHandlers.back.postMessage("MessageBody");
	}
 </script>
<?php }
else if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){ ?>
	
<div id="title">
	<img src="/img/back.svg" alt="" onclick="window.nightingale.back();">
    <p><?=$title?></p>
</div>

<?php }
else{?>
<?if(basename($_SERVER['PHP_SELF'])=="kiosk.php"){
	$href = "mypage.php";	
?>
	
<?}?>
<div id="title">
    <img src="/img/back.svg" alt="" onclick="<?=$href == null ? 'history.back();':'location.replace(\''.$href.'\');'?>">
    <p><?=$title?></p>
</div>

<?php }?>