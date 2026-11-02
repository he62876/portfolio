<!DOCTYPE html>
<html lang="ko">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="돈되지, 내돈내산, 리뷰쓰면 돈되지, 리뷰100%, 리뷰이벤트, 먹튀제로, 동네광고, 가게홍보, 캐시적립, 짠테크, 앱테크, 재테크">
	<meta name="description" content="우리 동네 가게 이용하고 리뷰쓰면 가게 사장님이 용돈을 드립니다. 다양한 곳에서 내돈내산 혜택 가득~ 매일매일 돈 쓸 맛 나는 앱테크 돈되지! 우리 동네 가게 홍보도 하고 리뷰도 받자! 기자단, 체험단 필요없는 실속있는 홍보방법! 꿀돼지같은 우리 가게 파트너 돈되지!">
	<meta property="og:type" content="website">
	<meta property="og:title" content="내돈내산 리뷰쓰면 돈되지">
	<meta property="og:image" content="/img/moneypig_meta_guide.png">
	<meta property="og:description" content="내돈내산 리뷰쓰면 돈되지입니다">
	<meta property="og:url" content="https://moneypig.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="eXLmcYdidByhd62Jv7bpHnUjMmBJhp70BDC9CgIrHLo" />
	<meta name="naver-site-verification" content="ca313ff7297cfd1c8d9f558a9bc18bfd96d09b3b" />
	<link rel="shortcut icon" href="/img/down2.ico">

    <!-- plugin css -->
    <link href="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- style-->
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">


	<title>내돈내산 리뷰쓰면 돈되지</title>
</head>
<style>

	body {
		height: 100vh;
		text-align: center;
		background: #772AFF;
		position: relative;
		overflow-x: hidden;
	}

	img {
		display: block;
		margin: 0 auto;
	}

	.counter {
		position: absolute;
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		top: 10px;
		right: 10px;
		width: 80px;
		height: 80px;
		border-radius: 20px;
		background: #fff;
	}

	.odd { 
		font-size: 20px;
		font-weight: 900;
		color: #772AFF;
		display: inline-block;
	}
	span {
		display: none;
		font-size: 20px;
		font-weight: 900;
		color: #772AFF;
	}

</style>
<html id="html">
	<body>
		<img src="/img/down_bg2.svg" style="width: 100%">
		<div class="counter">
			<p>방문자리뷰</p>
			<div>
				<p class="odd">999</p><span>+<span>
			</div>
		</div>
		<div style="background: #fff; margin-top: -250px; height: 300px;">
		</div>
		<div style="background: #fff; padding-bottom: 50px;">
			<div style="background:#F8F8F8; border-radius: 20px; width: 80%; margin: 0 auto; padding: 30px 0;">
				<a href="https://play.google.com/store/apps/details?id=com.emscnc.moneypig.store"><img src="/img/down2.svg" style="width: 70%;"></a>
				</br>
				<a href="https://apps.apple.com/kr/app/%EB%A6%AC%EB%B7%B0%EC%93%B0%EB%A9%B4-%EB%8F%88%EB%90%98%EC%A7%80-%EC%82%AC%EC%9E%A5%EB%8B%98-%EC%A0%81%EB%A6%BD-%EC%B2%B4%ED%97%98%EB%8B%A8-%EC%BF%A0%ED%8F%B0-%EB%AC%B8%EC%9E%90/id6450106082"><img src="/img/down3.svg" style="width: 70%;"></a>
			</div>
		</div>
	</body>
</html>


<script src="/assets/libs/jquery/jquery.min.js"></script>
<script src='/js/jquery.waypoints.min.js'></script>
<script src='/js/jquery.counterup.min.js'></script>
<script type='text/javascript' charset='UTF-8'>
	jQuery(document).ready(function( $ ) {
	   
		 $('.odd').counterUp({
			delay: 10,
			time: 1000
		});
	});
	
	setTimeout(function(){
		$('span').css('display', 'inline-block');
	},1100);

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