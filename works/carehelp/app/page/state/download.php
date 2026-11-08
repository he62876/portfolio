<?php
//include('../../lib/header.php');
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <title>간병 일자리 공유</title>
</head>
<style>
	* {
		margin:0;
		padding: 0;
	}
	a img {
		width: 85%;
		margin: 10px 0;
	}

	.button {
		position: absolute;
		width: 30%;
		left: 50%;
		transform: translateX(-50%);
		top: -10%;
	}
</style>
<div class="content_wrap">
    <img src="/img/down_bg.png" style="width: 100%;">
	<div style="background: #0050A2; text-align: center; padding: 60px 0; position: relative;">
		<img src="/img/down_btn.png" class="button">
		<a href="https://play.google.com/store/apps/details?id=com.emscnc.nightingale.user&pcampaignid=web_share"><img src="/img/google.png"></a>
		<a href="https://apps.apple.com/kr/app/%EA%B0%84%EB%B3%91-%EB%82%98%EC%9D%B4%ED%8C%85%EA%B2%8C%EC%9D%BC-%EA%B0%84%EB%B3%91%EC%8B%A0%EC%B2%AD-%EA%B0%84%EB%B3%91%EC%82%AC-%EA%B0%84%EB%B3%91%ED%98%91%ED%9A%8C-%EA%B5%AC%EC%9D%B8%EA%B5%AC%EC%A7%81/id6476480122"><img src="/img/apple.png"></a>
	</div>
</div>
<?php
//include('../../lib/footer.php');
// footer에 들어있는 회원 세션체크 때문에 로그인 화면으로 이동됨,, 의도는 오로지 다운로드 페이지만 나오도록 하는것! 일단 주석처리 해놨습니다
?>

<script type='text/javascript' charset='UTF-8'>
	var inappdeny_exec_vanillajs = (callback) => {
		if(document.readyState !== 'loading'){
			callback();
		}else{
			document.addEventListener('DOMContentLoaded', callback);
		} 
	};
	inappdeny_exec_vanillajs(() => { 
		/* Do things after DOM has fully loaded */ 
		function copytoclipboard(val){
			var t = document.createElement("textarea");
			document.body.appendChild(t);
			t.value = val;
			t.select();
			document.execCommand('copy');
			document.body.removeChild(t);
		};
		function inappbrowserout(){
			copytoclipboard(window.location.href);
			//alert('URL주소가 복사되었습니다.\n\nSafari가 열리면 주소창을 길게 터치한 뒤, "붙여놓기 및 이동"를 누르면 정상적으로 이용하실 수 있습니다.');
			location.href='x-web-search://?';
		};

		var useragt = navigator.userAgent.toLowerCase();
		var target_url = location.href;
		
		if(useragt.match(/kakaotalk/i)){
			
			//카카오톡 외부브라우저로 호출
			location.href = 'kakaotalk://web/openExternal?url='+encodeURIComponent(target_url);
			
		}else if(useragt.match(/line/i)){
			
			//라인 외부브라우저로 호출
			if(target_url.indexOf('?') !== -1){
				location.href = target_url+'&openExternalBrowser=1';
			}else{
				location.href = target_url+'?openExternalBrowser=1';
			}
			
		}else if(useragt.match(/inapp|naver|snapchat|wirtschaftswoche|thunderbird|instagram|everytimeapp|whatsApp|electron|wadiz|aliapp|zumapp|iphone(.*)whale|android(.*)whale|kakaostory|band|twitter|DaumApps|DaumDevice\/mobile|FB_IAB|FB4A|FBAN|FBIOS|FBSS|trill|SamsungBrowser\/[^1]/i)){
			
			//그외 다른 인앱들
			if(useragt.match(/iphone|ipad|ipod/i)){
				
				//아이폰은 강제로 사파리를 실행할 수 없다 ㅠㅠ
				//모바일대응뷰포트강제설정
				var mobile = document.createElement('meta');
				mobile.name = 'viewport';
				mobile.content = "width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui";
				document.getElementsByTagName('head')[0].appendChild(mobile);
				//노토산스폰트강제설정
				var fonts = document.createElement('link');
				fonts.href = 'https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap';
				document.getElementsByTagName('head')[0].appendChild(fonts);
				document.body.innerHTML = "<style>body{margin:0;padding:0;font-family: 'Noto Sans KR', sans-serif;overflow: hidden;height: 100%;}</style><h2 style='padding-top:50px; text-align:center;font-family: 'Noto Sans KR', sans-serif;'>인앱브라우저 호환문제로 인해<br />Safari로 접속해야합니다.</h2><article style='text-align:center; font-size:17px; word-break:keep-all;color:#999;'>아래 버튼을 눌러 Safari를 실행해주세요<br />Safari가 열리면, 주소창을 길게 터치한 뒤,<br />'붙여놓기 및 이동'을 누르면<br />정상적으로 이용할 수 있습니다.<br /><br /><button onclick='inappbrowserout();' style='min-width:180px;margin-top:10px;height:54px;font-weight: 700;background-color:#31408E;color:#fff;border-radius: 4px;font-size:17px;border:0;'>Safari로 열기</button></article><img style='width:70%;margin:50px 15% 0 15%' src='https://tistory3.daumcdn.net/tistory/1893869/skin/images/inappbrowserout.jpeg' />";
			
			}else{
				//안드로이드는 Chrome이 설치되어있음으로 강제로 스킴실행한다.
				//location.href='intent://'+target_url.replace(/https?:\/\//i,'')+'#Intent;scheme=http;package=com.android.chrome;end';
			}
		}
	});
</script>