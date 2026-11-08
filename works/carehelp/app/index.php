<?php
include('lib/header.php');
include('../common.php');
include_once ("../_inc/inc_fn.php");

//세선에 저장되는값 $_SESSION['user_no'] 로 사용하면됨
//$grade = $_SESSION['grade'];
//echo $_SESSION['user_no'];
PhpLog("user_no:".$_SESSION['user_no']);
if($grade == 2 || $grade == 3) {
    echo "<meta http-equiv='refresh' content='0;url=/app/page/state/state2-list.php'>";
    exit;
}

$noti = $pdo->row("SELECT * FROM notice_info WHERE use_yn = 1 AND grade1 = 1 ORDER BY noti_no DESC LIMIT 1");

$banr = $pdo->query("SELECT * FROM banner_info WHERE use_yn = 1 AND grade1 = 1 AND s_date <= CURDATE() AND e_date >= CURDATE() ORDER BY banner_order ASC");
$popup = $pdo->query("SELECT * FROM popup_info WHERE use_yn = 1 AND grade1 = 1 AND s_date <= CURDATE() AND e_date >= CURDATE() ORDER BY popup_order ASC");

$left = '';
$where1 = '';

if($grade == 1) {
	$left = ' LEFT OUTER JOIN hire_info b ON a.etc_no = b.hire_no ';
	$where1 = ' AND b.end_date >= CURDATE() ';
}
if($grade == 2) {
	$where1 = " AND a.reg_date BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW() ";
}
if($grade == 3) {
	$left = ' LEFT OUTER JOIN hire_info b ON a.etc_no = b.hire_no ';
	$where = " AND ((a.alim_tp = 7 AND  b.end_date >= CURDATE()) OR (a.alim_tp != 7  AND a.reg_date BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW()))";
}

$alim = $pdo->query("SELECT * FROM alim_info a ".$left." WHERE a.user_no = ".$_SESSION['user_no'].$where1." AND a.read_yn = 0", $param);
?>
<style>
    .content_wrap {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
	.notice-roll {position:relative;overflow:hidden;height:49px;border:1px solid #d5d5d5;background:#fff;margin:15px 0px -3px;padding:0 10px;box-sizing:content-box;border-radius:30px !important;}
	.notice-roll ul {position:absolute;width:100%;list-style:none;margin:0;padding:0}
	.notice-roll ul li {position:relative;height:35px;padding-right:20px;box-sizing:content-box}
	.notice-roll ul li a {line-height:36px;font-size:12px;margin-left:43px;display:block;}
	.notice-roll ul li span {line-height:45px;font-size:20px;margin-left:43px;font-weight: 500;}
	.notice-roll .label {position:absolute;top:11px;left;10px}
	.swiper {
        width: 100%;
        height: 100%;
      }

      .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
      }

      .swiper-slide img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: fill;
      }
	  
	.info {
		transition-delay: 0.3s;
	}
	.info p, .info img {
		display: inline-block;
		vertical-align: middle;
	}
	.info.on {
		transition-delay: 0s;
		border-bottom-color: rgba(0,0,0,0);
	}
	.info img {
		width: 15px;
	}
	.info img.info_b {
		display: inline-block;
	}
	.info img.info_t {
		display: none;
	}
	.info.on img.info_b {
		display: none;
	}
	.info.on img.info_t {
		display: inline-block;
	}
	.info_cont {
		display: none;
		overflow: hidden;
	}

.alim {
	position: relative;
}
.alim_yn {
	position: absolute;
	width: 10px; height: 10px;
	background: #3478F6;
	border-radius: 100%;
	top:-5px; right: -5px;
}

.popup_form {
	display: block;
}
</style>
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<div class="content_wrap" style="background:url('/img/back.png'); background-size: cover;">
    <div class="content_page">
        <div class="h-wrap">
            <div><a href=""><img src="/img/logo_w.svg" alt=""></a></div>
            <div style="text-align:right"><a href="/app/page/mypage/alim-list.php" class="alim"><img src="/img/alim_w.svg" alt="" style="width: 45%;""><div class="alim_yn" style="<?=$alim == null ? "display:none":""?>"></div></a></div>
        </div>
        <div class="banr" style="padding-bottom: 0;background: rgba(81, 86, 190, 0.25);">
            <div style="padding-bottom: <?=$banr == null ? 31:""?>%;">
				<div class="swiper mySwiper" style="border-radius: 15px;">
					<div class="swiper-wrapper">
						<?php foreach($banr as $b) { ?>
						<div class="swiper-slide">
							<a href="chat:<?=$b['link_url']?>"><img src="/upload/banr/<?=$b['banner_path']?>"></a>
						</div>
						<?php } ?>
						<!--<div class="swiper-slide"><img src="/img/ex_banner.png"></div>
						<div class="swiper-slide"><img src="/img/ex_banner.png"></div>
						<div class="swiper-slide"><img src="/img/ex_banner.png"></div>-->
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
        </div>
		<div class="notice-roll">
			<span class="label label-purple"><img src="/img/noti.png" alt="" style="width:25px;margin-left: 10px;"></span>
			<ul>
				<li><a href="/app/page/mypage/notice.php" style="margin-left:0"><span class="color-grey ellipsis" style="color:#000"><i class="fa fa-exclamation-circle"></i><?= $noti == null ? " 등록된 공지사항이 없습니다.":$noti['noti_sj']?></span></a></li>
			</ul>
		</div>
    </div>
    <div class="index_content">
        <div class="content_page">
            <div style="margin-bottom:3%">
                <a href="/app/page/form/pay-form1.php"><img src="/img/idx_btn1.png" alt="" style="width:100%"></a>
            </div>
            <div>
                <a href="/app/page/mypage/faq.php" style="width:100%"><img src="/img/idx_btn3.png" alt="" style="width:100%"></a>
            </div>
        </div>
    </div>
	<div style="background: #F5F8FB;" class="info">
		<div class="content_page " style="text-align:center; padding: 15px 0">
			<p style="color: #A2ADB9; font-weight: 400; font-size: 16px; text-decoration: underline;">사업자 정보 펼쳐보기</p>
			<img src="/img/info_b.svg" class="info_b">
			<img src="/img/info_t.svg" class="info_t">
		</div>
	</div>
	<div style="background: #EAEEF2;" class="info_cont">
        <div class="content_page " style="text-align:center; ">
			<p style="color: #A2ADB9; font-weight: 700; font-size: 18px;">(주)이엠에스커뮤니케이션즈</p>
			<br>
			<p style="color: #A2ADB9; font-weight: 400; font-size: 16px;">대표자명 : 문 명 화</br>주소 : 대구광역시 남구 명덕로 54 3층</br>
			사업자등록번호 : 514-81-54213</br>직업정보제공사업신고번호 : J1400020230004</br>고객센터 운영시간 : 월~금</br>
			오전 9시 ~ 오후 6시 (공휴일, 주말 휴무)</br>
			ⓒEMS Communications 2023. All Rights Reserved.</p>
			</br>
			<p style="color: #A2ADB9; font-weight: 400; font-size: 16px;">(주)이엠에스커뮤니케이션즈에서 중개하는 정보는 보호자와,</br>협회가 제공하는 정보를 포함하고 있습니다.</br>
			보호자와, 간병인, 협회가 제공하는 정보에 대해</br>(주)이엠에스커뮤니케이션즈는 당사자가 아니므로,</br>상호 발생하는 분쟁과 관련한 의무와 책임은 당사자에게 있습니다.</br>
			다만, 원만한 분쟁 해결을 위해 중재자로서의 최선을 다하겠습니다.</p>
        </div>
	</div>
	<div style="background: #F5F8FB;padding-bottom: 20%;"></div>
	<?php if($popup != null) { ?>
    <div class="popup_form popup_form2">
        <div class="pay_form">
			<div class="swiper mySwiper2" style="border-radius: 15px;">
				<div class="swiper-wrapper">
					<?php foreach($popup as $b) { ?>
					<div class="swiper-slide">
						<a href="chat:<?=$b['link_url']?>"><img src="/upload/popup/<?=$b['popup_path']?>"></a>
					</div>
					<?php } ?>
					<!--<div class="swiper-slide"><img src="/img/ex_banner.png"></div>
					<div class="swiper-slide"><img src="/img/ex_banner.png"></div>
					<div class="swiper-slide"><img src="/img/ex_banner.png"></div>-->
				</div>
				<div class="swiper-pagination2"></div>
			</div>
            <div class="btn_box d-flex justify-content-between">
                <button id="close" type="button" style="background: #fff; color: #000; width: 50%;">하루 그만 보기</button>
                <button onclick="closeForm();" type="button" style="background: #000; width: 50%;">닫기</button>
            </div>
        </div>
    </div>
	<?php } ?>
</div>
<?php
$menu = "index";
include('lib/menu.php');
include('lib/footer.php');
?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
	var swiper = new Swiper(".mySwiper", {
		spaceBetween: 30,
		centeredSlides: true,
		//loop: true,
		autoplay: {
		  delay: 2500,
		  disableOnInteraction: false,
		},
		pagination: {
		  el: ".swiper-pagination",
		  clickable: true,
		},
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
	});

		  
	var swiper = new Swiper(".mySwiper2", {
		spaceBetween: 30,
		centeredSlides: true,
		//loop: true,
		pagination: {
		  el: ".swiper-pagination2",
		  clickable: true,
		},
		navigation: {
		  nextEl: ".swiper-button-next",
		  prevEl: ".swiper-button-prev",
		},
	});

    $(".info").click(function () {
        $(this).next(".info_cont").stop().slideToggle(300);
        $(this).toggleClass('on').siblings().removeClass('on');
        //$(this).next(".info_cont").siblings(".info_cont").slideUp(300); // 1개씩 펼치기
    });


    function closeForm() {
        $('.popup_form').css('display', 'none');
    }
</script>
<script>
    // 쿠키 가져오기
    var getCookie = function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
        }
        return "";
    }

    // 24시간 기준 쿠키 설정하기  
    var setCookie = function (cname, cvalue, exdays) {
        var todayDate = new Date();
        todayDate.setTime(todayDate.getTime() + (exdays*24*60*60*1000));    
        var expires = "expires=" + todayDate.toUTCString(); // UTC기준의 시간에 exdays인자로 받은 값에 의해서 cookie가 설정 됩니다.
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    var couponClose = function(){
        setCookie("close","Y",1);   //기간( ex. 1은 하루, 7은 일주일)
        $('.popup_form').css('display', 'none');
    }
    
    $(document).ready(function(){
        var cookiedata = document.cookie;
        if(cookiedata.indexOf("close=Y")<0){
            $(".popup_form").show();
        }else{
            $(".popup_form").hide();
        }
        $("#close").click(function(){
            couponClose();
        });
    });
</script>