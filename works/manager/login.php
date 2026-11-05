
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
		margin-top: 125px;
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
		width: 100%;
		text-align: center;
	}
	.find a {
		color: #000;
		text-decoration: underline !important;
		font-size: 16px;
	}

	footer {
		width: 100%;
		color: #979797;
		font-size: 14px;
		text-align: center;
		margin-top: 50px;
		margin-bottom: 80px;
	}
</style>
<body>
	<div class="wrap">
		<?php
		$title = "로그인";
		include ('lib/mb_title.php');
		?>
		<div class="content_box">
			<div class="login">
				<img src="img/login1.png">
				<form action="login.json.php" method="post">
					<div style="text-align: left; margin-bottom: 20px;">
						<input type="radio" name="user_tp" value="1" id="type1" checked>
						<label for="type1" style="margin-right: 30px;">일반회원</label>
						<input type="radio" name="user_tp" value="2" id="type2">
						<label for="type2">전문가회원</label>
					</div>
					<input type="text" name="user_id" placeholder="아이디입력">
					<input type="password" name="user_pw" placeholder="비밀번호입력" style="margin: 10px 0 20px 0;">
					<button>로그인</button>
					<div class="btn_box">
						<a href="page/join/expert.join.php" class="button1">전문가회원가입</a>
						<a href="page/join/user.join.php" class="button2">일반회원가입</a>
					</div>
				</form>
				<div class="find">
					<a href="find.id.php" style="margin-right: 30px;">아이디찾기</a>
					<a href="find.pw.php">비밀번호찾기</a>
				</div>
				<footer>Copyright ⓒ 2024 EMS communications</footer>
			</div>
		</div>
	</div>
<!-- JAVASCRIPT -->
</body>
<script>
function setCookie(cookieName, value, exdays){
	var exdate = new Date();
	exdate.setDate(exdate.getDate() + exdays);
	var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
	document.cookie = cookieName + "=" + cookieValue;
}

function And_Push(key) {
	setCookie("Push",key,86400);
}
</script>
</html>
