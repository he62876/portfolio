<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/portfolio/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/portfolio/css/reset.css">
    <title>login</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
    @import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css');

    * {
        font-family: 'Noto Sans KR', sans-serif;
        box-sizing: border-box;
        font-size: 15px;
    }
    
    html {
        width: 100%;
        height: 100vh;
    }

    body {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    #login {
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 15px;
    }

    form input, form button {
        display: block;
        width: 100%;
        font-size: 14px;
        padding: 5px 15px;
        margin: 2px 0;
    }

    form button {
        background-color: #000;
        color: #fff;
        font-weight: bold;
        border-radius: 2px;
    }
</style>
<body>
    <div id="login">
        <form action="json.php" method="POST">
            <input type="password" name="password" placeholder="비밀번호">
            <button>접속하기</button>
        </form>
    </div>
</body>
</html>