
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/app/css/reset.css?v=<?=time()?>">
    <link rel="stylesheet" href="/app/css/style.css?v=<?=time()?>">
    <title>간병비 비교견적 서비스 나이팅게일</title>
</head>
<?php 
include_once ("../_inc/inc_ss.php");
ss_fileDelete();
?>

    <div id="wrap">
<style>
    body {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .state_form {
        display: flex;
        justify-content: space-between;
    }
	.state_form input[type='text'] {
		border: none;
	}
	.input_box {
		border: 1px solid #D7D8E0;
		border-radius: 5px;
		padding: 5px;
	}


    img {
        width: 80%;
        margin-bottom: 30px;
    }

	a, button {
		display: block;
		font-size: 1.4rem;
		font-weight: 500;
		padding: 10px;
		border-radius: 5px;
		color: #fff;
		background: #3478F6;
	}

	button:disabled {
		background: #606060;
	}
</style>
<body>
<div class="content_wrap">
    <!-- <form action="login.json.php" method="POST">
        <select name="grade" id="">
            <option value="1">보호자</option>
            <option value="2">간병인</option>
            <option value="3">협회</option>
        </select>
        <button>접속</button>
    </form>
    </br>
    <a href="/page/join/join-form1.php">회원가입</a> -->
    <div class="content_page text-center">
        <img src="/img/login.svg" alt="" style="margin-bottom: 75px;">
        <form action="login.json.php" method="POST">
			<div class="popup_form popup_form1">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">휴대폰번호를 입력해주세요.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 100%; background: #3478F6; border-bottom-left-radius:15px;border-bottom-right-radius:15px;">닫기</button>
					</div>
				</div>
			</div>
            <div class="state_form"  style="margin-bottom: 5px">
                <!--<select name="grade" id="" style="width: 79%;">
					<option value="1">보호자</option>
					<option value="2">간병인</option>
					<option value="3">협회</option>
				</select>
				<button style="width:20%">접속</button>-->
            </div>
			<div class="state_form input_box" style="margin:0; margin-bottom: 3px;">
				<input type="text" style="width:78%" id="phone_num" placeholder="휴대폰번호 입력" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" onchange="numChange();">
				<button style="width: 21%; min-width: 70px;" onclick="getAuthNum();" type="button" id="login_btn">요청</button>
			</div>
            <div class="state_form input_box" style="margin-bottom: 5px;">
                <input type="text" id="auth_num" name="rand_num" placeholder="인증코드 입력" style="width: 78%;">
				<input type="text" id="timer" style="width: 21%; min-width: 70px; border:none; text-align: center; color:#3478F6;" value="0:00" readonly>
            </div>
        </form>
		<button style="width:100%; margin-bottom:5px;" onclick="login();" type="button">로그인</button>
		<a href="/app/page/join/join-form1.php" style="background: #fff; color:#3478F6; border: 1px solid #3478F6;">회원가입</a>
		<br>
		<img src="/img/qnaTitle.png" alt="" style="width:100%;margin-top: 30px;">
		<a href="chat:http://pf.kakao.com/_ugxoKG/chat" style="background: #fff; color:#3478F6;border: 1px solid #3478F6;;height:60px;">
			<img src="/img/tel.svg" alt="" style="height:32.4px;width: 120px;margin-bottom: 0;">
		</a>
		
    </div>
</div>
<script type="text/javascript">
	function Push1(key) {
		setCookie("Push",key,86400);
	}

	//더블클릭 방지
	var doubleSubmitFlag = false;
	function doubleSubmitCheck(){
		if(doubleSubmitFlag){
			return doubleSubmitFlag;
		}else{
			doubleSubmitFlag = true;
			return false;
		}
	}

    function getAuthNum() {

		//테스트 전화번호 01034960000 보호자 01034960001 간변인 01034960002 협회
		var phone_num = $("#phone_num");
		//alert이 단말기에 따라 안보일수 있으므로 다른것으로 교체해야 할지도...
		if($.trim(phone_num.val()) == "") {
			document.getElementById('agree').innerHTML = '휴대폰번호를 입력해주세요.';
			$('.popup_form1').css('display', 'block');
			doubleSubmitFlag = false; return; }
		else{
			$.ajax({type: 'POST',
				url: '../auth.php',
				data:"&cmd=login_get_auth_num&phnum="+phone_num.val(),
				dataType: 'json',
				cache: false,
				beforeSend: function() { },
				success: function(data) {
					try
					{
						//alert(data.resCode);
						if(data.resCode == 1){
							//임시로 바로 들어가게해놓음
							$('input[name=rand_num]').val(data.rand_num); 
							document.getElementById('agree').innerHTML = '인증번호가 요청되었습니다.';
							$('.popup_form1').css('display', 'block');
							const timer = document.getElementById('timer'); //스코어 기록창-분
							let time = 180000;
							let min = 3;
							let sec = 60;
							timer.value = min+":"+'00'; 

						    PlAYTIME=setInterval(function(){
								time=time-1000; //1초씩 줄어듦
								min=time/(60*1000); //초를 분으로 나눠준다.

								if(sec>0){ //sec=60 에서 1씩 빼서 출력해준다.
									sec=sec-1;
									timer.value = Math.floor(min)+':'+String(sec).padStart(2, '0'); //실수로 계산되기 때문에 소숫점 아래를 버리고 출력해준다.
									$('#login_btn').attr("disabled", true);
								   
								}
								if(sec <= 0){
									// 0에서 -1을 하면 -59가 출력된다.
									// 그래서 0이 되면 바로 sec을 60으로 돌려주고 value에는 0을 출력하도록 해준다.
									sec=60;
									timer.value = Math.floor(min)+':'+'00';
								}     
						   
							},1000); //1초마다 

							setTimeout(function(){
								clearInterval(PlAYTIME);
								$('#login_btn').attr("disabled", false);
							},180000);//3분이 되면 타이머를 삭제한다.

						}
						else{
							//-1 하루3회요청 초과
							if(data.resCode == -1){
								document.getElementById('agree').innerHTML = '하루 요청 횟수를 초과했습니다';
								$('.popup_form1').css('display', 'block');
							}
							//-2 없는 회원 전화번호
							else if(data.resCode == -2){
								document.getElementById('agree').innerHTML = '가입하지 않은 휴대폰번호입니다.<br>회원가입을 해주세요';
								$('.popup_form1').css('display', 'block');
							}
							//-3 사용정지된 회원 가입안됨 
							else if(data.resCode == -3){
								document.getElementById('agree').innerHTML = '사용정지된 회원의 휴대폰번호입니다.';
								$('.popup_form1').css('display', 'block');
							}
							//-4 탈퇴한회원
							else if(data.resCode == -4){
								document.getElementById('agree').innerHTML = '탈퇴한 회원의 휴대폰번호입니다.';
								$('.popup_form1').css('display', 'block');
							}
							//-5 미승인회원
							else if(data.resCode == -5){
								document.getElementById('agree').innerHTML = '관리자 승인 중 잠시만 기다려주세요.<br>승인 후 정상 접속됩니다.';
								$('.popup_form1').css('display', 'block');
							}
						}
					}
					catch(e)
					{
						console.log("error forward2 : " + e);
					}
				},
				error: function(data, status, err) {
					try{ console.log("error forward : " + data); alert(err); }
					catch(e){ console.log("error : " + e); alert('서버와의 통신이 실패했습니다.'); }
					return false;
				},
				complete: function() { },
				xhr: /*@cc_on false && @*/window.XMLHttpRequest ?
					function() { return new window.XMLHttpRequest(); } :
					function() { try { return new window.ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} }
			});
		}
	}

	function numChange() {
		$('#login_btn').attr("disabled", false);
		var isStop = true;
		clearInterval(PlAYTIME);
		$('#timer').val('0:00');
	}

	function login() {
		var phone_num = $("#phone_num");
		var auth_num = $("#auth_num");
		//alert이 단말기에 따라 안보일수 있으므로 다른것으로 교체해야 할지도...
		if($.trim(phone_num.val()) == "") { 
			document.getElementById('agree').innerHTML = '휴대폰번호를 입력해주세요.';
			$('.popup_form1').css('display', 'block');
			doubleSubmitFlag = false;  return; 
		}
		else if($.trim(auth_num.val()) == "") { 
			//alert("인증번호를 입력해주세요."); 
			document.getElementById('agree').innerHTML = '인증번호를 입력해주세요.';
			$('.popup_form1').css('display', 'block');
			doubleSubmitFlag = false;  return; 
		}
		else{
			$.ajax({type: 'POST',
				url: '../auth.php',
				data:"&cmd=phone_auth_login&phnum="+phone_num.val()+"&auth_num="+auth_num.val()+"&push_key=1111",
				dataType: 'json',
				cache: false,
				beforeSend: function() { },
				success: function(data) {
					try
					{
						//alert(data.resCode);
						if(data.resCode == 1){
							location.href='login.json.php?grade='+data.user_grade;
						}
						else{
							//0 실패 인증번호 다름
						}
					}
					catch(e)
					{
						console.log("error forward2 : " + e);
					}
				},
				error: function(data, status, err) {
					try{ console.log("error forward : " + data); alert(err); }
					catch(e){ console.log("error : " + e); alert('서버와의 통신이 실패했습니다.'); }
					return false;
				},
				complete: function() { },
				xhr: /*@cc_on false && @*/window.XMLHttpRequest ?
					function() { return new window.XMLHttpRequest(); } :
					function() { try { return new window.ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} }
			});
		}
	}

	function closeForm1() {
		$('.popup_form1').css('display', 'none');
	}
	function push(key) {
		setCookie("Push",key,86400);
		return key;
	}
</script>
<?php
include('lib/footer.php');
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 