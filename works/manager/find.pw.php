
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-cache">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <title>비즈니스 전단</title>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');

	* {
		font-family: 'Noto Sans KR', sans-serif;+
		box-sizing: border-box;
		font-size: 15px;
	}


	.wrap {
		width: 100%;
		max-width: 768px;
		margin: 0 auto;
	}

	.content_box {
		height: 100vh;
		display: flex;
		align-items: center;
		margin-top: -85px;
	}

	.login {
		width: 80%;
		margin: 0 auto;
		text-align: center;
	}

	.login img {
		margin-bottom: 60px;
	}

	
	input, button {
		border: 1px solid #D2D6DA;
		border-radius: 8px;
		display: block;
		width: 100%;
		padding: 12px;
		font-size: 14px;
		font-weight: bold;
		color: #000;
	}


	.btn_box {
		display: flex;
		justify-content: space-between;
		margin: 10px 0 50px 0;
	}
	.btn_box > * {
		width: 49%;
		border-radius: 5px;
		color: #fff;
		font-weight: bold;
		padding: 15px 0;
		text-align: center;
	}
	.btn_box .button2 {
		background: #fff;
		color: #000;
		border: 1px solid #D5DADE;
	}
	.btn_box .button1 {
		background: #193D50;
	}

	button {
		border-color: #00A8FF;
		color: #fff;
		background: #00A8FF;
	}
	input:placeholder {
		color: #7B809A;
	}

	input[type=radio] {
		display: none;
	}
	input[type=radio] + label {
		font-size: 14px;
	}
	input[type=radio] + label::before {
		content: '';
		width: 20px;
		height: 20px;
		display: inline-block;
		background: url('/img/radio_off.svg');
		vertical-align: middle;
		margin-right: 4px;
	}
	input[type=radio]:checked + label::before {
		background: url('/img/radio_on.svg');
	}

	.find {
		position: absolute;
		width: 100%;
		bottom: 95px;
		left: 50%; transform: translateX(-50%);
		text-align: center;
	}
	.find a {
		color: #000;
		text-decoration: underline !important;
		font-size: 16px;
	}

	footer {
		position: absolute;
		width: 100%;
		bottom: 40px;
		left: 50%; transform: translateX(-50%);
		color: #979797;
		font-size: 14px;
		text-align: center;
	}
</style>
<body>
	<div class="wrap">
		<?php
		include ('common.php');
		$title = "비밀번호찾기";
		include ('lib/mb_title.php');
		include("_inc/incl_phpmail.php");

		$userid = $_POST["userid"];
		$user_email = $_POST["user_email"];
		

		if($user_email!=null){

			function generateRandomString($length = 10) {
				$characters = '0123456789';
				$charactersLength = strlen($characters);
				$randomString = '';
			
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[mt_rand(0, $charactersLength - 1)];
				}
				return $randomString;
			}
			
			$pw = generateRandomString(6);
			$sql = "SELECT email FROM user_info WHERE user_id = '".$userid."'";

			$data = $pdo->row($sql, $param);
			if($data!=null){
				$change = $pdo->query("UPDATE user_info SET user_pw = PASSWORD('".$pw."') WHERE user_id = '".$userid."'", $param);
				$ret = SendMailSFRH($data['email'],"#R_PW#",$userid."\t".$pw);
			}
			
			else{

			}
			
		}



		?>
		<div class="popup_form popup_form1">
			<div class="area_form">
				<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
					<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 18px;">서비스 이용약관에 동의해주세요.</div>
					<button onclick="closeForm1();" type="button" style="width: 100%; font-weight: bold; color: #fff; background: #00A8FF; border-radius:5px;">닫기</button>
				</div>
			</div>
		</div>
		<div class="content_box">
			<div class="login">
				<img src="img/login.png">
				<form  method='post' name='findID'   action='<?=$PHP_SELF?>'>
					<?php if(!$data) { ?>
					<input type="text"  name="userid" id="userid" placeholder="아이디입력" style="margin-bottom: 10px;">
					<input type="text"  name="user_email" id="email" placeholder="이메일입력" style="margin-bottom: 20px;">
					<button type="button" onclick='find_pw();'>비밀번호찾기</button>
					<?php } ?>
					<?php if($data) { ?>
					<div class="form-group" style="padding:2%;">
						<?=$user_email?> 주소로 임시 비밀번호가 발송됩니다.
					</div>	
					<?php if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  { ?>
					<button type="button" onclick="javascript:back();">로그인하러 가기</button>
					<script type="text/javascript" charset="UTF-8">
						function back(){
						//alert();
							window.webkit.messageHandlers.back.postMessage("MessageBody");
						}
					 </script>
					<?}else{?>
					<button type="button" onclick="location.replace('login.php');">로그인하러 가기</button>
					<?php } ?>
					<?php } ?>
				</form>
			</div>
			<footer>Copyright ⓒ 2024 EMS communications</footer>
		</div>
	</div>
</body>
<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>
<script>
    // content, cate, index를 인수로 받아 form 태그로 전송하는 함수
function find_pw() {
	var userid = $("#userid");
	var email = $("#email");

	if($.trim(userid.val()) == "") { 
		document.getElementById('agree').innerHTML = '아이디를 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		//alert('아이디를 입력해주세요');
		doubleSubmitFlag = false;
		//email.focus(); 
		return; 
	}
	if($.trim(email.val()) == "") { 
		document.getElementById('agree').innerHTML = '이메일을 입력해주세요.';
		$('.popup_form1').css('display', 'block');
		//alert('아이디를 입력해주세요');
		doubleSubmitFlag = false;
		//email.focus(); 
		return; 
	}
	document.findID.submit();
}

function closeForm1() {
	$('.popup_form1').css('display', 'none');
}
</script>
</html>
