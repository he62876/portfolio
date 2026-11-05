
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/css/reset.css">
    <title>돈되지 관리자</title>
</head>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');

	* {
		font-family: 'Noto Sans KR', sans-serif;
		box-sizing: border-box;
		font-size: 15px;
	}

    body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
		background: linear-gradient( to bottom, #FAE100 50%, #fff 50% );
    }

	.login {
		width: 340px;
		text-align: center;
		border-radius: 15px;
		background: #fff;
		padding: 40px 25px;
		box-shadow: 0 3px 6px rgba(0,0,0,.3);
	}

	img {
		margin-bottom: 30px;
	}
	
	input, button, a {
		border: 1px solid #D2D6DA;
		border-radius: 5px;
		display: block;
		width: 100%;
		padding: 12px;
		font-size: 14px;
		font-weight: bold;
		color: #000;
	}

	a {
		display:block;
		width:100%;
		text-align: center;
	}
	button {
		border-color: #000;
		color: #fff;
		background: #000;
	}
	input:placeholder {
		color: #7B809A;
	}

	footer {
		position: absolute;
		bottom: 40px;
		color: #979797;
		font-size: 14px;
	}
</style>
<body>
	<div class="login">
		<img src="img/login_logo.svg">
		<form action="json.php" method="post">
			<input type="text" name="admin_id" placeholder="아이디입력">
			<input type="password" name="admin_pw" placeholder="비밀번호입력" style="margin: 10px 0 20px 0;">
			<button>로그인</button>
			<a href="join.php?grade=3" style="margin: 10px 0;">대리점 가입신청</a>
			<a href="join.php">매니저 가입신청</a>
		</form>
	</div>
	<footer>Copyright ⓒ 2023 EMS communications</footer>
<!-- JAVASCRIPT -->
</body>

</html>
