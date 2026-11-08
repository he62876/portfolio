<?php
include('../../lib/header.php');
$title = "지원현황";
include('../../lib/title.php');
include('../../../common.php');

$param = null;

$hire_no = $_GET['hire_no'];
$work_cnt = $pdo->single("SELECT work_cnt FROM hire_info WHERE hire_no = ".$_GET['hire_no'], $param);

$sql = "SELECT * FROM hire_info WHERE hire_no = ".$hire_no;
$hire_info = $pdo->row($sql, $param);

$sdate = $hire_info['hire_sdate']." ".$hire_info['hire_stime'].":00:00";
$edate = $hire_info['hire_edate']." ".$hire_info['hire_etime'].":59:59";

$pay_list = $pdo->query("SELECT *, a.user_no as user_no, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 2 AND b.state = 2 AND '".$edate."' > DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') AND '".$sdate."'< DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s')", $param);

if($pay_list != null) {
	foreach($pay_list as $w) {
	//$cnt_where .= " AND NOT('".$sdate."' <  '".$w['edate']."' AND '".$edate."' > '".$w['sdate']."')";
		$user_no .= " AND a.user_no != ".$w['user_no'];
							
	}
	//echo ${'cnt_where'.$d['hire_no']};
}

$sql = "SELECT *, AES_DECRYPT(UNHEX(b.user_tel),'naghtglae_00710') as phone, b.user_no as user_no FROM pay_info a
		LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
		WHERE a.state = 1 AND a.hire_no = ".$hire_no.$user_no." ORDER BY membership DESC, pay ASC";
$list_data = $pdo->query($sql, $param);

$pay_type = array(1=>'현금만 가능', 2=>'카드만 가능', 3=>'현금/카드 둘 다 가능');
$year = date("Y");

$profile1 = array('profile_1_1.png', 'profile_1_2.png', 'profile_1_3.png');
$img1 = time()%count($profile1);

$profile2 = array('profile_2_1.png', 'profile_2_2.png', 'profile_2_3.png');
$img2 = time()%count($profile2);

$alim_no = $_GET['alim_no'] == null ? 0:$_GET['alim_no'];
if($alim_no > 0) {
	$rs = $pdo->query("UPDATE alim_info SET read_yn = 1 WHERE alim_no = ".$alim_no, $param);
}
?>
<style>
    p {
        font-size: 1.1rem;
        font-weight: bold;
    }

    .state_list {
        margin-bottom: 0;
    }

    .state_list form button {
        color: #fff;
        border: none;
        background: #3478F6;
    }

    .state_list form a {
        color: #000;
        border: 1px solid #DEDEDE;
    }

	.state_list form button:disabled {
		background: #DEDEDE;
	}
</style>
<div class="content_wrap">
    <div class="content_page">
        <ul class="state_list">
			<?php if (!$list_data) {?>
					<div style="text-align: center;"><img src="/img/nodata.png" alt="" style="width:40%;margin-top: 50%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></div>
			<?php } ?>
			<?php foreach($list_data as $d) { 
				$sql = "SELECT count(*) as cnt, sum(star) as sum FROM comment_info WHERE state = 1 AND pay_no = ".$d['user_no'];
				$star = $pdo->row($sql, $param);
			?>
            <li>
                <div class="d-flex justify-content-start align-items-center w-100">
                    <div class="profile_img_on">
                        <div class="profile_img">
							<?php if($d['img_url'] == null) { ?>
                            <img src="/img/<?=$d['user_sex'] == 1 ? $profile1[$img1]:$profile2[$img2]?>" alt="">
							<?php } else { ?>
                            <img src="/upload/<?=$d['img_url']?>" alt="">
							<?php } ?>
                        </div>
                    </div>
                    <div class="profile_info">
                        <span><?=$d['user_grade'] == 2 ? "간병사":"협회"?></span>
                        <div class="profile_name">
                            <strong><?=$d['user_grade'] == 2 ? iconv_substr($d['user_name'],0,1)."**":$d['association_nm']?></strong>
							<?php if($d['membership'] == 1) { ?>
                            <img src="/img/membership.svg" alt="">
							<?php } ?>
                        </div>
                        <div class="profile_star">
                            <div>
                                <img src="/img/star.svg" alt="">
                                <p><?=$star['cnt'] == 0 ? "0.0" : round(($star['sum']/$star['cnt']),2)?></p>
                            </div>
                            <div>
                                <img src="/img/comment.svg" alt="">
                                <p><?=$star['cnt']?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="info_table">
					<?php if($grade == 1) {?>
                    <tr>
                        <th>간병비</th>
                        <td style="color:#3478F6; font-weight: bold;">일급 / <?=number_format($d['pay'])?>원</td>
                    </tr>
					<?php } ?>
					<?php if ($d['user_grade'] == 2) { ?>
                    <tr>
                        <th>성별</th>
                        <td><?=$d['user_sex'] == 1 ? "남성":"여성"?></td>
                    </tr>
                    <tr>
                        <th>나이</th>
                        <td><?=$d['user_old']?>세</td>
                    </tr>
                    <tr>
                        <th>근무경력</th>
                        <td><?=$d['career']?>년</td>
                    </tr>
					<?php } else if($d['user_grade'] == 3) { ?>
                    <tr>
                        <th>담당자</th>
                        <td><?=$d['responsibility']?></td>
                    </tr>
                    <tr>
                        <th>설립년도</th>
                        <td><?=$d['work_year']?>년 (<?=$year - $d['work_year']?>년)</td>
                    </tr>
                    <tr>
                        <th>직원 수</th>
                        <td><?=$d['work_cnt']?>명</td>
                    </tr>
					<?php } ?>
                    <tr>
                        <th>결제수단</th>
							<?php if($d['user_grade'] == 2) {
								$pay_nm = $pdo->single("SELECT pay_type FROM user_info WHERE user_no = ".$d['association_nm'], $param);
							}?>
                        <td><?=$pay_type[$pay_nm]?></td>
                    </tr>
                </table>
                <form action="json.php" method="POST">
					<?php
						$sql = "SELECT state FROM hire_info WHERE hire_no = ".$d['hire_no'];
						$state = $pdo->single($sql, $param);
						$sql = "SELECT hire_no FROM hire_info WHERE hire_no = ".$d['hire_no'];
						$hire_no = $pdo->single($sql, $param);
					?>
					<input type="hidden" name="pay_no" value="<?=$d['pay_no']?>">
                    <a href="pay-info.php?pay_no=<?=$d['pay_no']?>" style="width: 33%;">상세</a>
                    <a href="tel:<?=$d['phone']?>" <?=$state != 1 ? "disabled":""?> style="width: 33%; color: #fff; background: #3478F6;">통화</a>
                    <button style="width: 33%;" type="button" <?=$state != 1 ? "disabled":""?> onclick="payForm1(<?=$d['pay_no']?>);">확정</button>
                </form>
				<div style="background:#FFFCE5; color: #6E4F47; text-align: center; border-radius: 10px; padding:15px; margin-top: 10px;font-size:14px;">간병사와 반드시 통화 후 확정하시길 바랍니다</br>환자의 상태에 따라 예상금액이 달라 질 수 있습니다</div>
            </li>
			<?php } ?>
			<input type="hidden" name="mode" value="pay_ok">
			<input type="hidden" name="work_cnt" value="<?=$work_cnt?>">
			<input type="hidden" name="hire_no" value="<?=$hire_no?>">
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
        </ul>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>
<script>
/*	function myFunction() {
        var check = confirm("간병사를 결정하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }

	} */


var pay_no = 0;
var isRun = false;
function payOK() {
	//window.nightingale.showLoading('1');

	var hire_no = $("input[name='hire_no']").val();
	var work_cnt = $("input[name='work_cnt']").val();
	
	if(isRun == true) {
        return;
    }
    
    isRun = true;

	$.ajax({type: 'POST',
		url: 'json.php',
		data:"&mode=pay_ok&hire_no="+hire_no+"&pay_no="+pay_no+"&work_cnt="+work_cnt,
		dataType: 'json',
		cache: false,
		beforeSend: function() { },
		success: function(data) {
			try
			{
				//alert(data.resCode);
				if(data.resCode == 1){
					isRun  = false;
					//window.nightingale.showLoading('0');
					if(<?=$grade?> == 1) {
						window.location.href = "state-list.php";
					} else {
						window.location.href = "state3-list.php";
					}
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


function payForm1(pay_no1) {
	pay_no = pay_no1;
	$('.popup_form1').css('display', 'block');
}
function closeForm1() {
	$('.popup_form1').css('display', 'none');
}

</script>