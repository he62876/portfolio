<?php
include('../../lib/header.php');
$title = "상세보기";
include('../../lib/title.php');
include('../../../common.php');
include_once ("../../../_inc/inc_fn.php");
$pay_no = $_GET['pay_no'] == null ? 0:$_GET['pay_no'];

$param = null;

if($pay_no != 0) {
	$sql = "SELECT *, AES_DECRYPT(UNHEX(b.user_tel),KEY) as phone, b.user_grade as user_grade, a.state as state, a.user_no as user_no FROM pay_info a
			LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
			WHERE a.pay_no = ".$pay_no;
	$data = $pdo->row($sql, $param);
}

$pay_type = array(1 => "현금만 가능", 2 => "카드만 가능", 3 => "현금/카드 둘 다 가능");
$year = date("Y");


$sql = "SELECT * FROM code_info WHERE majr = 2 AND minr != 0 AND use_yn = 1";
$work_type = $pdo->query($sql, $param);
$sql = "SELECT * FROM code_info WHERE majr = 3 AND minr != 0 AND use_yn = 1";
$singo_type = $pdo->query($sql, $param);

$profile1 = array('profile_1_1.png', 'profile_1_2.png', 'profile_1_3.png');
$img1 = time()%count($profile1);

$profile2 = array('profile_2_1.png', 'profile_2_2.png', 'profile_2_3.png');
$img2 = time()%count($profile2);

if($data['sigun_seq'] > 0) {
	$sql = "SELECT * FROM sigun_address WHERE seq = ".$data['sigun_seq'];
	$address = $pdo->row($sql, $param);
}

$sql = "SELECT * FROM license_info WHERE use_yn = 1 AND user_no = ".$data['user_no'];
$license_list = $pdo->query($sql, $param);
?>
<style>
body{
    background:#F8F8F8;
}

p {
    font-size: 1.1rem;
    font-weight: bold;
}

.profile_info {
    width: 100%;
}
.profile_info span {
    font-size: 1rem;
    font-weight: 500;
    color: #A9AEB7;
}
.profile_info .profile_name strong {
    font-size: 1.5rem;
    font-weight: bold;
}
.profile_info .profile_name img {
    width: 23px;
    margin-left: 5px;
}

table.info_table {
    margin: 15px 0;
}

.state_list {
    margin-bottom: 0;
}
.state_list p.content_text {
    margin-top: 15px;
    font-size: 1rem;
    font-weight: 500;
}

.date_state span {
    margin: 0;
}

.state_info > button {
	background: #3478F6; 
}
.state_info > button:disabled {
	background: #DEDEDE;
}
</style>
<div class="content_wrap">
	<?php if($data['img_url'] == null) { ?>
    <div class="profile_thum" style="background: url('/img/<?=$data['user_sex'] == 1 ? $profile1[$img1]:$profile2[$img2]?>'); background-size: cover; background-position: center;"></div>
	<?php } else { ?>
    <div class="profile_thum" style="background: url('/upload/<?=$data['img_url']?>'); background-size: cover; background-position: center;"></div>
	<?php } ?>
    <div class="profile_info" style="background: #fff">
        <div class="content_page">
            <span><?=$data['user_grade'] == 2 ? "간병사":"협회"?></span>
            <div class="profile_name">
                <strong><?=iconv_substr($data['user_name'],0,1)."**"?></strong>
                <?php if($data['membership'] == 1) { ?>
                <img src="/img/membership.svg" alt="">
                <?php } ?>
            </div>
            <table class="info_table">
				<?php if($grade == 1) { ?>
                <tr>
                    <th>간병비</th>
                    <td style="color:#3478F6; font-weight: bold">일당 / <?=number_format($data['pay'])?>원</td>
                </tr>
				<?php } ?>
                <tr>
                    <th><?=$data['user_grade'] == 2 ? "성별":"담당자"?></th>
                    <td><?=$data['user_grade'] == 2 ? $data['user_sex'] == 1 ? "남성":"여성" :$data['responsibility']?></td>
                </tr>
                <tr>
                    <th><?=$data['user_grade'] == 2 ? "나이":"대표자"?></th>
                    <td><?=$data['user_grade'] == 2 ? $data['user_old']."세":$data['boss']?></td>
                </tr>
                <tr>
                    <th><?=$data['user_grade'] == 2 ? "근무경력":"설립년도"?></th>
                    <td><?=$data['user_grade'] == 2 ? $data['career']."년":$data['work_year']."년 (".($year - $data['work_year'])."년)"?></td>
                </tr>
                <tr>
                    <th><?=$data['user_grade'] == 2 ? "국적":"직원 수"?></th>
                    <td><?=$data['user_grade'] == 2 ? $data['nationality'] == 1 ? "한국인":"외국인" :$data['work_cnt']."명"?></td>
                </tr>
                <tr>
                    <th><?=$data['user_grade'] == 2 ? "거주지":"주소"?></th>
                    <td><?=$address['sido']." ".$address['gugun']?> <?=$data['user_grade'] == 3 ? $data['address']:""?></td>
                </tr>
                <tr>
                    <th>결제수단</th>
					<?php if($data['user_grade'] == 2) {
						$pay_nm = $pdo->single("SELECT pay_type FROM user_info WHERE user_no = ".$data['association_nm'], $param);
					}?>
                    <td><?=$pay_type[$data['user_grade'] == 2 ? $pay_nm:$data['pay_type']]?></td>
                </tr>
            </table>
			<a href="tel:<?=$data['phone']?>" style="display: block; color: #fff; text-align: center; font-size: 1.3rem; font-weight: 500; background: #72A4FF; border-radius: 5px; line-height: 60px;">
				<svg style="width: 25px; height: 25px;" xmlns="http://www.w3.org/2000/svg" width="84.004" height="84.005" viewBox="0 0 84.004 84.005">
				  <path id="패스_8950" data-name="패스 8950" d="M65.339,83.993C67.214,84,84,71.582,84,70S65.213,56.571,63.586,56.571s-7.083,6.542-8.553,7.272-10.663.467-20.9-9.771S20.392,32.053,20.392,30.2s8.537-7.571,8.773-8.91S17.909,0,16.04,0,0,17.226,0,18.665s1.3,19.9,24.681,43.283S63.47,83.983,65.339,83.993" fill="#fff"/>
				</svg>
				전화걸기
			</a>
        </div>
    </div>
        </br>
    <div style="background: #fff">
        <div class="content_page">
            <p class="content_title"><?=$data['user_grade'] == 2 ? "전담간병":"소개글"?></p>
            <p class="content_text" style="color: <?=$data['user_grade'] == 2 ? "#3478F6":""?>">
                <?php if($data['user_grade'] == 2) { ?>
                    <?php
					if($data['work_type'] != 0 && $data['work_type'] != null){
						$work_list = explode(",", $data['work_type']);
						foreach($work_list as $work_nm) {
							$work_type = $pdo->single("SELECT name FROM code_info WHERE majr = 2 AND minr =".$work_nm, $param);
							$arr[] = $work_type; 
						}
						$work = implode(", ", $arr);	
					}
				?>
				<?=$data['work_type'] == 0 || $data['work_type'] == null ? "없음":$work?>
				<?php } else { ?>
				 <?=nl2br($data['intro'])?>
				 <?php } ?>
            </p>
        </br>
        </div>
    </div>
    <?php if($data['user_grade'] == 2) { ?>
        </br>
    <div style="background: #fff;">
        <div class="content_page">
            <p class="content_title">소속협회</p>
				<?php if($data['association_nm'] != null && $data['association_nm'] != 0 && $data['agency_state'] == 1) {
						$agcy = $pdo->row("SELECT *, AES_DECRYPT(UNHEX(boss_tel),KEY) as boss_tel FROM user_info WHERE user_no = '".$data['association_nm']."'", $param); 

						if($agcy['sigun_seq'] > 0) {
							$sql = "SELECT * FROM sigun_address WHERE seq = ".$agcy['sigun_seq'];
							$a_address = $pdo->row($sql, $param);
						}
						 ?>
				<table class="info_table">
					<tr>
						<th>협회명</th>
						<td><?=$agcy['association_nm']?></td>
					</tr>
					<tr>
						<th>업무시간</th>
						<td><?=$agcy['work_time']?></td>
					</tr>
				</table>
				<div class="d-flex justify-content-between align-items-center license">
					<p><?=$a_address['sido']." ".$a_address['gugun']." ".$agcy['address']?></p>
					<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
						$get_code = get_kakao_geocode($a_address['sido']." ".$a_address['gugun']." ".$agcy['address']);
						$xml = simplexml_load_string($get_code); 
						$latitude = (float)$xml->documents->y;
						$longitude = (float)$xml->documents->x;
							 
					?>
					<a href="map:<?=$latitude.",".$longitude?>">길찾기</a>
					<?}else{?>
					<a href="map:<?=$a_address['sido']." ".$a_address['gugun']." ".$agcy['address']?>">길찾기</a>
					<?}?>
				</div>
				</br>
				<a href="tel:<?=$agcy['boss_tel']?>" style="display: block; color: #fff; text-align: center; font-size: 1.3rem; font-weight: 500; background: #72A4FF; border-radius: 5px; line-height: 60px;">
					<svg style="width: 25px; height: 25px;" xmlns="http://www.w3.org/2000/svg" width="84.004" height="84.005" viewBox="0 0 84.004 84.005">
					  <path id="패스_8950" data-name="패스 8950" d="M65.339,83.993C67.214,84,84,71.582,84,70S65.213,56.571,63.586,56.571s-7.083,6.542-8.553,7.272-10.663.467-20.9-9.771S20.392,32.053,20.392,30.2s8.537-7.571,8.773-8.91S17.909,0,16.04,0,0,17.226,0,18.665s1.3,19.9,24.681,43.283S63.47,83.983,65.339,83.993" fill="#fff"/>
					</svg>
					전화걸기
				</a>
				<?php } else { ?>
				소속없음
				<?php } ?>
        </div>
    </div>
        </br>
    <div style="background: #fff;">
        <div class="content_page">
            <p class="content_title">자격증</p>
            <?php if($license_list == null) { ?>
			<p class="content_text">등록된 자격증이 없습니다.</p>
			<?php } else { 
					foreach($license_list as $d) { ?>
			<div class="d-flex justify-content-between align-items-center license">
				<p><?=$d['subject']?></p>
				<a href="license:https://carehelper.co.kr/upload/license/<?=$d['img_url']?>">이미지보기</a>
			</div>
			<?php  } } ?>
        </div>
    </div>
        </br>
    <div style="background: #fff;">
        <div class="content_page">
            <p class="content_title">간병 배상 책임 보험</p>
            <p class="content_text"><?=$data['insurance_name'] == null ? "해당없음":$data['insurance_name']?></p>
			<?php if($data['insurance_name'] != null) { ?>
            <p class="content_text"><?=$data['insurance_sdate']?> ~ <?=$data['insurance_edate']?></p>
            <p class="content_text"><?=$data['insurance_num']?></p>
			<?php } ?>
        </div>
    </div>
        </br>
    <!--<div style="background: #fff;">
        <div class="content_page">
            <p class="content_title">코로나 백신 접종</p>
            <p class="content_text"><?=$data['vaccine'] == null ? "해당없음":$data['vaccine']?></p>
        </div>
    </div>
        </br>-->
    <div style="background: #fff;">
        <div class="content_page">
            <p class="content_title">소개글</p>
            <p class="content_text"><?=$data['intro'] == null ? "소개글이 없습니다.":nl2br($data['intro'])?></p>
        </div>
    </div>
    <?php } ?>
        </br>
    <div style="background: #fff">
        <div class="content_page">
            <p class="content_title">평점</p>
			<?php
				$sql = "SELECT count(*) as cnt, sum(star) as sum FROM comment_info WHERE state = 1 AND pay_no = ".$data['user_no'];
				$star = $pdo->row($sql, $param);

				$sql = "SELECT *, a.reg_date as reg_date, b.user_name as user_name FROM comment_info a
						LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
						WHERE a.state = 1 AND a.pay_no = ".$data['user_no']." ORDER BY a.reg_date DESC LIMIT 1";
				$comment = $pdo->query($sql, $param);
			?>
            <div style="margin-bottom: 20px;" class="star_box">
                <span style="margin-right: 2px;">
                    <span style="width: <?=(($star['sum']/$star['cnt'])/5)*100?>%"></span>
                </span>
                <!-- <img src="/img/star_on.svg" alt="" style="width: 25px">
                <img src="/img/star_on.svg" alt="" style="width: 25px">
                <img src="/img/star_on.svg" alt="" style="width: 25px">
                <img src="/img/star_on.svg" alt="" style="width: 25px">
                <img src="/img/star.svg" alt="" style="width: 25px"> -->
                <p><?=$star['cnt'] == 0 ? "0.0":round(($star['sum']/$star['cnt']),2)?></p>
            </div>
            <ul class="state_list">
				<?php foreach($comment as $d) { ?>
                <li>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p><?=$d['user_name']?></p>
                        <div style="text-align: right;">
                            <span style="color:#5B5B5B; font-weight: 400"><?=substr($d['reg_date'])?></span>
                        </div>
                    </div>
                    <div class="star_box2">
                        <span>
                            <span style="width: <?=($d['star']/5)*100?>%"></span>
                        </span>
                    </div>
                    <p class="content_text" >
                        <?=nl2br($d['cont'])?>
                    </p>
                </li>
				<?php } ?>
                <!--<li>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p>김은혜</p>
                        <div style="text-align: right;">
                            <span style="color:#5B5B5B; font-weight: 400">2023-01-30</span>
                        </div>
                    </div>
                    <div class="star_box2">
                        <span>
                            <span style="width: <?=(4/5)*100?>%"></span>
                        </span>
                    </div>
                    <p class="content_text" >
                        약속시간도 잘 지키고 싹싹했습니다.</br>
                        아버지를 정성껏 보살펴주었습니다.</br>
                        감사합니다.
                    </p>
                </li>-->
            </ul>
            <a href="/app/page/mypage/comment-list.php?type=<?=$grade == 1 ? 2:4?>&pay_no=<?=$data['user_no']?>" class="star_link"><?=$star['cnt']?>개의 후기 확인하기</a>
        </div>
    </div>
        </br>
    <form action="json.php" method="POST" class="state_info">
		<?php if($data['state'] == 1) {
			$sql = "SELECT state FROM hire_info WHERE hire_no = ".$data['hire_no'];
			$state = $pdo->single($sql, $param);
			$sql = "SELECT hire_no FROM hire_info WHERE hire_no = ".$data['hire_no'];
			$hire_no = $pdo->single($sql, $param); ?>
		<input type="hidden" name="mode" value="pay_ok">
		<input type="hidden" name="pay_no" value="<?=$pay_no?>">
		<input type="hidden" name="hire_no" value="<?=$hire_no?>">
        <button style="width: 100%" type="button" <?=$state != 1 ? "disabled":""?> onclick="payForm1(<?=$pay_no?>);">확정하기</button>
		<?php } else { ?>
        <!--<button style="width: 100%;background: #000;" type="button" onclick="singoForm();" >신고하기</button>-->
		<?php } ?>
    </form>
			<div class="popup_form popup_form1">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 275px;">
						<div style="width: 100%;text-align: center;"><img style="width: 80px;" src="/img/warnning.svg"></div>
						<div id="agree3" style="width: 100%;text-align: center;margin-top: 15px;font-weight: bold;font-size: 22px; color: #3478F6;">간병사와 통화 후</br>결정하셨나요?</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px;">간병사와 반드시 통화 후</br><span style="color: #FF6D2D;font-size: 20px;font-weight: bold;">확정</span> 해주시길 바랍니다.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 33%; background: #000000; border-bottom-left-radius:15px;">닫기</button>
						<button onclick="payOK();" type="button" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">확정하기</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form2">
				<div class="area_form">
					<div class="state_form d-block" style="flex-wrap: wrap;padding: 15px;">
						<select name="singo_why" style="margin-bottom: 10px;">
							<option value="0">선택하세요</option>
							<?php foreach($singo_type as $s) {?>
							<option value="<?=$s['minr']?>"><?=$s['name']?></option>
							<?php } ?>
						</select>
						<textarea maxlenth="80" name="singo_cont" rows="5" placeholder="신고사유는 80자까지 입력 가능합니다."></textarea>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 33%; background: #000000; border-bottom-left-radius:15px;">닫기</button>
						<button onclick="singo(<?=$data['user_no']?>, <?=$_SESSION['user_no']?>);" type="button" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">신고하기</button>
					</div>
				</div>
			</div>
			<div class="popup_form popup_form3">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree2" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 17px;">서비스 이용약관에 동의해주세요.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 100%; background: #3478F6; border-bottom-left-radius:15px;border-bottom-right-radius:15px;">닫기</button>
					
					</div>
				</div>
			</div>
			<div class="popup_form popup_form4">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 17px;">신고하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="singoOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-left-radius:15px;">네</button>
						<button onclick="closeForm3();" type="button" style="width: 50%; background: #000000; border-bottom-right-radius:15px;">아니오</button>
						
					</div>
				</div>
			</div>
</div>
<?php
include('../../lib/footer.php');
?>
<script>
	/* function myFunction() {
        var check = confirm("간병사를 결정하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }

	} */

var pay_no = 0;
var other_user_no = 0;
var singo_user_no = 0;
var isRun = false;
function payOK() {
	var hire_no = $("input[name='hire_no']").val();
	
	if(isRun == true) {
        return;
    }
    
    isRun = true;


	$.ajax({type: 'POST',
		url: 'json.php',
		data:"&mode=pay_ok&hire_no="+hire_no+"&pay_no="+pay_no,
		dataType: 'json',
		cache: false,
		beforeSend: function() { },
		success: function(data) {
			try
			{
				//alert(data.resCode);
				if(data.resCode == 1){
					isRun  = false;
					window.location.href = "state-list.php";
				}
				else{
					
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

function singoOK() {
	var singo_why = $("select[name='singo_why']").val();
	var singo_cont = $("textarea[name='singo_cont']").val();


	$.ajax({type: 'POST',
		url: 'json.php',
		data:"&mode=singo&singo_why="+singo_why+"&singo_cont="+singo_cont+"&singo_user_no="+singo_user_no+"&other_user_no="+other_user_no,
		dataType: 'json',
		cache: false,
		beforeSend: function() { },
		success: function(data) {
			try
			{
				//alert(data.resCode);
				if(data.resCode == 1){
					window.location.href = "state-list.php";
				}
				else{
					
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

$("textarea[name='singo_cont']").keyup(function () {
	var singo_cont = $(this).val();

	if(singo_cont.length > 80) {
		$(this).val($(this).val().substring(0, 80));
	}
})


function singo(user1, user2) {
	other_user_no = user1;
	singo_user_no = user2;

	var singo_why = $("select[name='singo_why']").val();
	var singo_cont = $("textarea[name='singo_cont']").val();

	if(singo_why == 0) {
		document.getElementById('agree2').innerHTML = '신고타입을 선택해주세요.';
		$('.popup_form3').css('display', 'block');
		return;
	} else if(singo_cont == "") {
		document.getElementById('agree2').innerHTML = '신고사유를 입력해주세요.';
		$('.popup_form3').css('display', 'block');
		return;
	} else {
		$('.popup_form4').css('display', 'block');
	}

}

function payForm1(pay_no1) {
	pay_no = pay_no1;
	$('.popup_form1').css('display', 'block');
}
function singoForm() {
	$('.popup_form2').css('display', 'block');
}
function closeForm1() {
	$('.popup_form').css('display', 'none');
}
function closeForm3() {
	$('.popup_form3').css('display', 'none');
	$('.popup_form4').css('display', 'none');
}
</script>
