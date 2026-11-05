<style>
	#mb_title a {
		display: inline-block;
		line-height: 55px;
	}
</style>
		<div id="mb_title" style="background:<?=$theme == "light" ? "#fff":"#516068"?>; height: 55px; margin-bottom: 30px;">
			<?php if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  { ?>
				<?php if(basename($_SERVER['PHP_SELF'])=="expert.join.php" || basename($_SERVER['PHP_SELF'])=="user.join.php"  || basename($_SERVER['PHP_SELF'])=="find.id.php"   || basename($_SERVER['PHP_SELF'])=="find.pw.php" || basename($_SERVER['PHP_SELF'])=="terms1.php" || basename($_SERVER['PHP_SELF'])=="terms2.php"){?>
					<?php if((basename($_SERVER['PHP_SELF'])=="terms1.php" || basename($_SERVER['PHP_SELF'])=="terms2.php") && basename($_SERVER["HTTP_REFERER"])=="mypage.php") {?>
					<a onclick="history.back();" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
					<?php }else{?>
					<a href='javascript:back()' style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
					<script type="text/javascript" charset="UTF-8">
						function back(){
						//alert();
							window.webkit.messageHandlers.back.postMessage("MessageBody");
						}
					 </script>
					 <?php } ?>
				<?php }else{
					$referer_domain = $_SERVER['HTTP_REFERER'];	
					$href=basename($_SERVER["PHP_SELF"]);	
					if(strpos($referer_domain, $href) !== false) {
						if($href=="alim.php"){
							$back_url = $_COOKIE["back_url"];
							//echo basename($back_url);
						}
					}
					else{
						
						if(strpos($referer_domain, "app.php") !== false || strpos($referer_domain, "expert-list.php") !== false || strpos($referer_domain, "qna-list.php") !== false) {
							$back_url = $referer_domain;
							//echo basename($back_url);
							setcookie("back_url", $back_url, time()+3600);
						}
						if($href=="mypage.php" && strlen($back_url)==0){
							$back_url = $_COOKIE["back_url"];
							//echo basename($back_url);
						}
						else if($href=="alim.php" && strlen($back_url)==0){
							$back_url = $_COOKIE["back_url"];
							//echo basename($back_url);
						}
						else if($href=="estimate.php" && strlen($back_url1)==0){
							$back_url1 = $_COOKIE["old_url1"];
						}
						//echo $back_url1;
					}
					
				?>
					<?php if($href=="alim.php" || $href=="mypage.php"){?>
						<a onclick="<?=$back_url == null ? '':'location.replace(\''.$back_url.'\');'?>" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
					<?php }else if($href=="estimate.php"){?>
						<a onclick="<?=$back_url1 == null ? '':'location.replace(\''.$back_url1.'\');'?>" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
					<?php }else if($href=="faq.php"){?>
						<a onclick="location.replace('https://vision.ne.kr/page/mypage/mypage.php');" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>		
					<?php }else{?>
						<a onclick="history.back();" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
					<?php }?>
				<?php }?>
			<?php }else if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){ 
				$referer_domain = $_SERVER['HTTP_REFERER'];	
				$href=basename($_SERVER["PHP_SELF"]);	
				if(strpos($referer_domain, $href) !== false) {
					//echo "ccc";
				}
				else{
					//echo $referer_domain;
					/*if(strpos($referer_domain, "app.php") !== false || strpos($referer_domain, "expert-list.php") !== false || strpos($referer_domain, "qna-list.php") !== false) {
						$back_url = $referer_domain;
						setcookie("back_url", $back_url, time()+3600);
						//echo "aaa";
					}*/
					if($href=="mypage.php"){
						$back_url = $_COOKIE["back_url1"];
						//echo $back_url;
						if($back_url=="qna-list.php"){
							$back_url = "https://vision.ne.kr/page/qna/".$back_url;
						}
						else if($back_url=="expert-list.php"){
							$back_url = "https://vision.ne.kr/page/expert/".$back_url;
						}
						else{
							$back_url = "https://vision.ne.kr/".$back_url;
						}
						//echo basename($back_url);
						//echo "bbb";
					}
					else if($href=="estimate.php"){
						$back_url1 = $_COOKIE["old_url1"];
					}
				}		
			?>
				<?php if($href=="faq.php"){?>
				<a onclick="location.replace('https://vision.ne.kr/page/mypage/mypage.php');" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
				<?php }else if($href=="mypage.php"){?>
				<a onclick="<?=$back_url == null ? 'history.back();':'location.replace(\''.$back_url.'\');'?>" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
				<?php }else if($href=="estimate.php"){?>
				<a onclick="<?=$back_url1 == null ? 'history.back();':'location.replace(\''.$back_url1.'\');'?>" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
				<?php }else{?>
				<a onclick="window.vision.back();" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
				<?php }?>
			<?php }else{?>
				<a onclick="history.back();" style="margin-left: 15px;"><img src="/portfolio/works/manager/img/back_<?=$theme == "light" ? "b":"w"?>.svg"></a>
			<?php }?>
			<p style="color:<?=$theme == "light" ? "#000":"#fff"?>; font-size: 20px; line-height: 55px; display: inline-block; margin-left: 10px;"><?=$title?></p>
		</div>