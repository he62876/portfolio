<?php
include('../../lib/header.php');
include('../../../common.php');

$type = $_GET['type'] == null ? 0:$_GET['type'];

$param = null;

$where = '';

if($type > 0) {
	$where = " AND user_grade = ".$type;
}

if($grade == 1) {
	$sql = "SELECT * FROM hire_info WHERE user_grade = 1 AND use_yn = 1 AND user_no = ".$_SESSION['user_no']." ORDER BY reg_date DESC";
	$state_nm = array(1 => "지원요청", 2 => "모집완료", 10 => "종료", 11 => "간병취소요청", 99 => "취소");
	$state_co = array(1 => "#3478F6", 2 => "#000", 10 => "#8C8F97", 11 => "#FF4E34", 99 => "#FF4E34");

}
else {

	$state = $_GET['state']==null? 0:$_GET['state'];
	
	if($state!=0){
		if($state == 1 ) {
			$where .= " AND (b.state = 1 AND b.end_date >= NOW() AND a.state = 1)";
		}
		if($state == 2 ) {
			$where .= " AND (( b.state = 2 AND CONCAT(b.hire_edate, ' ', b.hire_etime, ':00:00') >= NOW() ) AND NOT (a.state = 1 AND b.state = 2)) AND a.state != 99 AND b.state != 99 ";
		}
		if($state == 3 ) {
			$where .= " AND (b.state = 99 OR a.state = 99) ";
		}
		if($state == 4 ) {
			$where .= " AND (( b.state = 1 AND b.end_date < NOW() ) OR (b.state = 2 AND CONCAT(b.hire_edate, ' ', b.hire_etime, ':00:00') < NOW()) OR (b.state = 10 AND a.state = 2) OR (a.state = 1 AND b.state = 2)) AND a.state != 99 AND b.state != 99";
		}
	}

	$sql = "SELECT *, a.state as state, a.pay as pay, b.pay as h_pay, a.fin_why as fin_why, b.fin_why as hire_fin_why, b.reg_date as reg_date FROM pay_info a
			LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no
			WHERE b.use_yn = 1 AND a.user_no = ".$_SESSION['user_no'].$where." ORDER BY a.reg_date DESC";
	$state_nm = array(1 => "지원", 2 => "채용확정", 10 => "종료", 11 => "간병취소요청", 99 => "취소");
	$state_co = array(1 => "#3478F6", 2 => "#3478F6", 10 => "#8C8F97", 11 => "#FF4E34", 99 => "#FF4E34");

	$pay_cnt1 = $pdo->single("SELECT count(*) FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE b.user_grade = 1 AND b.use_yn = 1 AND a.user_no = ".$_SESSION['user_no'], $param);
	$pay_cnt3 = $pdo->single("SELECT count(*) FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE b.user_grade = 3 AND b.use_yn = 1 AND a.user_no = ".$_SESSION['user_no'], $param);
}
$list_data = $pdo->query($sql, $param);

$date = date('Y-m-d H:m:s');

$pay_type = array(1 => '시급', 2 => '일급', 3 => '월급');

$alim_no = $_GET['alim_no'] == null ? 0:$_GET['alim_no'];
if($alim_no > 0) {
	$rs = $pdo->query("UPDATE alim_info SET read_yn = 1 WHERE alim_no = ".$alim_no, $param);
}


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
	$where1 = " AND ((a.alim_tp = 7 AND  b.end_date >= CURDATE()) OR (a.alim_tp != 7  AND a.reg_date BETWEEN DATE_ADD(NOW(),INTERVAL -1 MONTH ) AND NOW()))";
}

$alim = $pdo->query("SELECT * FROM alim_info a ".$left." WHERE a.user_no = ".$_SESSION['user_no'].$where1." AND a.read_yn = 0", $param);
?>
<style>
body{
    background:#F8F8F8;
}

    .state_form {
        display: flex;
        justify-content: space-between;
		margin: 20px 0;
    }

    .state_form>div {
        width: 49%;
        text-align: center;
    }

    .state_form>div input {
        display: none;
    }

    .state_form>div label {
        margin: 0;
        width: 100%;
        font-size: 1.1rem;
        font-weight: 500;
        background: #fff;
        border: 1px solid #D7D8E0;
        border-radius: 10px;
        padding: 10px 0;
    }
	.state_form>div label span {
		display: block;
		font-size: 1.5rem;
		font-weight: bold;
	}

    .state_form>div input:checked+label {
        color: #fff;
        background: #3478F6;
        border-color: #3478F6;
    }
	.state_form>div input:checked+label span {
		color: #FFEF56;
	}

	form[name='selType'] a,
	form[name='selType'] select {
		display: block;
		width: 100%;
		font-size: 18px;
		font-weight: 500;
	}
	form[name='selType'] a {
		text-align: center;
		line-height: 50px;
		color: #fff;
		background: #72A4FF;
		border-radius: 10px;

	}
	form[name='selType'] select {
		margin-bottom: 20px;
		margin-top: 10px;
		height: 50px;
		border-radius: 5px;
		border-color: #72A4FF;
		padding: 10px;
	}

	.comment {
		position: absolute;
		width: 70%;
		text-align: center;
		background: #27282B;
		padding: 10px 0;
		left: 50%; transform: translateX(-50%);
		bottom: -20px;
		border-radius: 50px;
		z-index: 4;
		box-shadow: 0 3px 6px rgba(0,0,0,0.16);
	}
	.comment p, .comment span {
		font-size: 18px;
		font-weight: 500;
		color: #fff;
	}
	.comment span {
		color: #FFEF56;
	}
	.comment::after {
		content: '';
		position: absolute;
		width: 10px; height: 10px;
		background: #27282B;
		display: inline-block;
		transform: rotate(45deg);
		top: -5px;
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
</style>
<div class="content_wrap">
    <div class="content_page">
        <?php if($grade != 1) { ?>
        <div class="h-wrap">
            <div><a href=""><img src="/img/logo_b.svg" alt=""></a></div>
            <div style="text-align:right"><a href="/app/page/mypage/alim-list.php" class="alim"><img src="/img/alim_b.svg" alt="" style="width: 45%;""><div class="alim_yn" style="<?=$alim == null ? "display:none":""?>"></div></a></div>
        </div>
        <?php if($grade == 2) { ?>
        <form action="state-list.php" method="GET" id='SearchForm' name="selType">
			<div class="state_form">
				<div>
					<input onclick="Search_Page(1);" type="radio" name="type" value="1" id="type1" <?=$type == 1 ? "checked":""?>>
					<label for="type1">
						<span><?=$pay_cnt1?></span>
						보호자 구인 지원
					</label>
				</div>
				<div>
					<input onclick="Search_Page(1);" type="radio" name="type" value="3" id="type2" <?=$type == 3 ? "checked":""?>>
					<label for="type2">
						<span><?=$pay_cnt3?></span>
						협회 구인 지원
					</label>
				</div>
			</div>
			<select name="state" onchange="Search_Page(1);">
				<option value="0" <?=$state == 0 ? "selected":""?>>전체</option>
				<option value="1" <?=$state == 1 ? "selected":""?>>공고 중</option>
				<option value="2" <?=$state == 2 ? "selected":""?>>모집완료</option>
				<option value="3" <?=$state == 3 ? "selected":""?>>취소</option>
				<option value="4" <?=$state == 4 ? "selected":""?>>종료</option>
			</select>
        </form>
        <?php }
        } ?>
        <ul class="state_list">
			<?php if (!$list_data) {?>
					<div style="text-align: center;"><img src="/img/nodata.png" alt="" style="width:40%;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);"></div>
			<?php } ?>
			<?php foreach($list_data as $d) {
					$sdate = $d['hire_sdate']." ".$d['hire_stime'].":00:00";
					$edate = $d['hire_edate']." ".$d['hire_etime'].":00:00";
					//echo $date.', '.$sdate;
					$edate_time = $d['end_date'];

					$str_date = strtotime($date);
					$str_sdate = strtotime($sdate);
					$str_edate = strtotime($edate);

					$endDate = strtotime($d['end_date']);
					$today = strtotime(date('Y-m-d H:i:s'));

					$diff = $endDate - $today;

					//$day = floor($diff/(24*3600));
					//$diff = $diff-($day*(24*3600));
					$hours = floor($diff/3600);
					
					//echo $day."일 ".$hours."시간";
				?>
            <li>
                <a href="state-info.php?hire_no=<?=$d['hire_no']?>&pay_no=<?=$d['pay_no'] == null ? 0:$d['pay_no']?>">
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p><?=substr($d['reg_date'],0,10)?></p>
                        <div style="text-align: right;">
							<?php if($grade == 1) {
								if(($d['state'] == 1 && $edate_time < $date) || ($d['state'] == 2 && $edate < $date)) { ?>
                            <span style="color:#8C8F97;">종료</span><img src="/img/arrow.svg" alt="">
							<?php } else if($d['state'] == 2 && $str_sdate <= $str_date && $str_edate >= $str_date) { ?>
                            <span style="color:#3478F6;">근무 중</span><img src="/img/arrow.svg" alt="">
							<?php } else { ?>
                            <span style="color:<?=$state_co[$d['state']]?>;"><?=$state_nm[$d['state']]?></span><img src="/img/arrow.svg" alt="">
							<?php }
								} else { 
								$sql = "SELECT * FROM hire_info WHERE hire_no = ".$d['hire_no'];
								$hire_info = $pdo->row($sql, $param);

								$sdate = $hire_info['hire_sdate']." ".$hire_info['hire_stime'].":00:00";
								$edate = $hire_info['hire_edate']." ".$hire_info['hire_etime'].":00:00";
								$edate_time = $hire_info['end_date'];

								$str_date = strtotime($date);
								$str_sdate = strtotime($sdate);
								$str_edate = strtotime($edate);
								$str_etime = strtotime($edate_time);

								if ((($d['state'] == 1 && $hire_info['state'] == 2) || ($d['state'] == 1 && $str_etime < $str_date) || (($hire_info['state'] == 2 && $d['state'] == 2) && $str_edate < $str_date) || ($hire_info['state'] == 10 && $d['state'] == 2)) && $d['state'] != 99 && $hire_info['state'] != 99) { ?>
							<span style="color:#8C8F97;">종료</span><img src="/img/arrow.svg" alt="">
							<?php } else if($hire_info['state'] == 99) { ?>
							<span style="color:#FF4E34;">취소</span><img src="/img/arrow.svg" alt="">
							<?php } else if($d['state'] == 1 && $d['user_grade'] == 3) { ?>
							<span style="color:<?=$state_co[$d['state']]?>;">지원완료</span><img src="/img/arrow.svg" alt="">
							<?php } else if($d['state'] == 2 && $str_sdate <= $str_date && $str_edate >= $str_date) { ?>
                            <span style="color:#3478F6;">근무 중</span><img src="/img/arrow.svg" alt="">
							<?php } else { ?>
							<span style="color:<?=$state_co[$d['state']]?>;"><?=$state_nm[$d['state']]?></span><img src="/img/arrow.svg" alt="">
							<?php }
								}?>
                        </div>
                    </div>
					<?php if($d['user_grade'] == 1) { ?>
                    <p><?=$d['patient_sex'] == 1 ? "남성":"여성"?>/<?=$d['patient_age']?>세/<?=$d['patient_weight']?>kg</p>
					<?php if($d['state'] == 1 && $hours >= 0) { ?>
                    <p style="color:#3478F6; font-size: 1.1rem; font-weight: bold;"><img src="/img/clock.svg" style="width: 20px; margin-right: 5px;"><?=$d['state'] == 1 && $hours >= 0 ? "공고 ".$hours."시간 남음":""?><img src="/img/view.svg" style="width: 20px; margin-right: 5px; margin-left: 20px;"><?="조회수 ".$d['hit']?></p>
					<?php } ?>
					<?php } else { 
							$sql = "SELECT * FROM hire_info a
									LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
									WHERE a.hire_no = ".$d['hire_no'];
							$user = $pdo->row($sql, $param); ?>
                    <p><img src="/img/male.svg" style="width: 20px; margin-right: 5px;"><?=$user['association_nm']?>/<?=$user['responsibility'] != null ? $user['responsibility']:$user['boss']?></p>
					<?php } ?>
                    <table class="info_table">
						<?php if(($grade != 2 && $d['state'] == 10) || ($grade == 2 && ($d['state'] == 99 || $hire_info['state'] == 10))) { 
								if($grade == 2 && $d['state'] == 99) { $fin_why_no = $d['hire_fin_why'] == null ? 99 : $d['hire_fin_why']; }
								else { $fin_why_no = $d['fin_why'] == null ? 99 : $d['fin_why']; }
								$fin_why = $pdo->single("SELECT name FROM code_info WHERE majr = 11 AND minr = ".$fin_why_no, $param); ?>
                            <tr>
                                <th><?=$grade == 2 && $d['state'] == 99 ? "취소":"중단"?>사유</th>
                                <td><?=$fin_why?></td>
                            </tr>
						<?php } ?>
                        <?php if($grade == 1) { 
								$sql = "SELECT user_name, a.pay_no as pay_no, a.user_no as user_no, b.association_nm as association_nm FROM pay_info a
										LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
										WHERE a.state = 2 AND a.hire_no = ".$d['hire_no'];
								$user = $pdo->row($sql, $param);

								$association_nm = $pdo->single("SELECT association_nm FROM user_info WHERE user_no = '".$user['association_nm']."'", $param);
						?>
                        <tr>
                            <th>간병사</th>
                            <td><?=$association_nm != null ? $association_nm."</br>":""?><?=$user == null ? "-":$user['user_name']." <a href='pay-info.php?pay_no=".$user['pay_no']."'>상세보기</a>"?></td>
                        </tr>
                        <?php } ?>
						<?php if($d['user_grade'] == 3) { ?>
                        <tr>
                            <th>분류</th>
                            <td><?=$d['hire_type'] == 1 ? "개인":"공동"?>간병</td>
                        </tr>
                        <tr>
                            <th>근무형태</th>
                            <td><?=$d['addr_type'] == 1 ? "병원":"재가"?>간병</td>
                        </tr>
						<?php } ?> 
                        <?php if($grade != 1) { ?>
                            <tr>
                                <th>간병위치</th>
								<?php
									if($d['addr_type'] == 1) {
										$hospital = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".$d['hire_addr']."'", $param);
									}
									if($d['addr_type'] == 2) {
										$str = $d['hire_addr'];
										$addr = explode(' ',$str);
										$cnt = count($addr);

										for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
											${'hire_addr'.$d['hire_no']} .= $addr[$i]." ";
										}
									}
								?>
                                <td><?=$d['addr_type'] == 1 ? $hospital:${'hire_addr'.$d['hire_no']}?></td>
                            </tr>
                        <?php } ?>
                        <tr>
							<?php
								$days = (strtotime($d['hire_edate']) - strtotime($d['hire_sdate'])) / 86400;
							?>
                            <th>간병기간</th>
                            <td><p style="color: #3478F6; font-size: 20px; font-weight: 500;">[<?=$days + 1?>일]</p><?=$d['hire_sdate']?> <?=$d['hire_stime']?>:00 ~</br><?=$d['hire_edate']?></td>
                        </tr>
                        <tr>
							<?php
								$hire_time = $pdo->single("SELECT name FROM code_info WHERE majr = 10 AND minr = ".$d['hire_time'], $param);
							?>
                            <th>간병시간</th>
                            <td><?=$hire_time?></td>
                        </tr>
                        <?php if($grade != 1 && $d['user_grade'] == 1) { ?>
                            <tr>
                                <th>진단정보</th>
                                <td><?=$d['patient_cont'] == null ? '-':$d['patient_cont']?></td>
                            </tr>
                        <?php } ?>
                        <?php if($grade != 1 && $d['type'] == 1) { ?>
                            <tr>
                                <th>간병비</th>
                                <td style="color:#3478F6; font-weight: bold;">일급 / <?=number_format($d['pay'])?>원</td>
                            </tr>
                        <?php } else if($grade != 1 && $d['type'] == 2) { 
								$sql = "SELECT * FROM hire_info WHERE hire_no = ".$d['hire_no'];
								$pay_info = $pdo->row($sql, $param); ?>
                            <tr>
                                <th>간병비</th>
                                <td style="color:#3478F6; font-weight: bold;"><?=$d['pay_type'] == 4 ? "보호자와 협의":$pay_type[$d['pay_type']]." / ".number_format($d['h_pay'])."원"?></td>
                            </tr>
						<?php } ?>
                    </table>
                </a>
                <?php if($grade == 1) { ?>
                <form action="">
					<?php
						$sdate = $d['hire_sdate']." ".$d['hire_stime'].":00:00";
						$edate = $d['hire_edate']." ".$d['hire_etime'].":00:00";

						$str_date = strtotime($date);
						$str_sdate = strtotime($sdate);
						$str_edate = strtotime($edate);

						$pay_list = $pdo->query("SELECT *, a.user_no as user_no, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':00:00'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 2 AND b.state = 2
						AND '".$edate."' > DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') AND '".$sdate."'< DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':00:00'), '%Y-%m-%d %H:%i:%s')", $param);

						if($pay_list != null) {
							foreach($pay_list as $w) {
								//${'cnt_where'.$d['hire_no']} .= " AND NOT('".$sdate."' <  '".$w['edate']."' AND '".$edate."' > '".$w['sdate']."')";
								${'user_no'.$d['hire_no']} .= " AND a.user_no != ".$w['user_no'];
								
							}
							//echo ${'cnt_where'.$d['hire_no']};
							//echo ${'user_no'.$d['hire_no']};
						}

						$pay_cnt = $pdo->single("SELECT count(*) FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 1 AND a.hire_no = ".$d['hire_no'].${'user_no'.$d['hire_no']}, $param);
						$pay_yn = $pdo->row("SELECT * FROM pay_info WHERE hire_no = ".$d['hire_no']." AND state = 2",$param);
						$comment = $pdo->query("SELECT * FROM comment_info WHERE state = 1 AND hire_no = ".$d['hire_no'], $param);
					?>
					<?php if($d['state'] == 1 && $edate_time >= $date && $pay_cnt == 0)  { ?>
                    <a href="/app/page/form/pay-form1.php?hire_no=<?=$d['hire_no']?>" style="width: <?=$d['state'] != 10 ? 19:49?>%; border: 1px solid #DEDEDE; color: #000;">수정</a>
					<?php } ?>
					<?php if(($d['state'] == 10 && $pay_yn == null) || ($d['state'] == 1 && $pay_cnt == 0)) { ?>
                    <button onclick="deleteForm1(<?=$d['hire_no']?>);" type="button" style="width: <?=($d['state'] == 10 && !$pay_yn) || ($d['state'] == 1 && $endDate < $str_date) ? 100:19?>%;">삭제</button>
					<?php } ?>
					<?php if($d['state'] == 1 && $pay_cnt > 0 && $edate_time >= $date) { ?>
                    <button onclick="deleteForm4(<?=$d['hire_no']?>,'appl_can');" type="button" style="width: 39%;">모집취소</button>
					<?php } ?>
					<?php if($d['state'] == 1 && $edate_time >= $date) { ?>
                    <a href="pay-list.php?hire_no=<?=$d['hire_no']?>" style="width: 59%; background: #3478F6;">지원현황 <span style="color:#FFEF56;"><?=$pay_cnt?></span></a>
					<?php } if($pay_yn) {  ?>
					<?php if($str_date >= $str_sdate && $str_date < $str_edate && $d['state'] != 10) { ?>
                    <button onclick="deleteForm2(<?=$d['hire_no']?>, 'work_fin');" type="button" style="width: <?=$comment == null ? 39:100?>%;">근무중단</button>
					<?php } else if($str_date < $str_sdate && $d['state'] == 2) { ?>
                    <button onclick="deleteForm2(<?=$d['hire_no']?>, 'state_can');" type="button" style="width: 39%;">확정취소</button>
					<?php } ?>
                    <a <?=$str_date >= $str_sdate ? 'href="/app/page/mypage/comment-write.php?pay_no='.$user['user_no'].'&hire_no='.$d['hire_no'].'"':''?> style="display: <?=$comment != null ? 'none':''?>; color: #fff; width: <?=$str_edate > $str_date && $d['state'] != 10 ? 59:100?>%; background: <?=$str_date >= $str_sdate ? '#3478F6;':'#cfcfcf;'?>" >간병사 후기쓰기</a>
						<?php if(($str_date > $str_edate || $d['state'] == 10) && !$comment) { ?>
						<div class="comment"><p><span>후기</span>를 남겨주세요!</p></div>
						<?php } ?>
					<?php } ?>
                </form>
                <?php } ?>
            </li>
			<?php } ?>
			<div class="popup_form popup_form1">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">정말 삭제하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="deleteOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form3">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">삭제하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="deleteForm3();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form4">
				<div class="area_form">
					<div class="" style="flex-wrap: wrap;padding: 15px;height: 200px;">
						<?php $fin_list = $pdo->query("SELECT * FROM code_info WHERE majr = 11 AND minr != 0 AND use_yn = 1", $param); ?>
						<?php foreach($fin_list as $f) { ?>
						<input type="radio" name="fin_why" id="fin<?=$f['minr']?>" value="<?=$f['minr']?>">
						<label for="fin<?=$f['minr']?>" style="width:100%;"><?=$f['name']?></label>
						<?php } ?>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">취소</button>
						<button onclick="cancelOK1();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">사유결정</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form2">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">정말 취소하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="cancelOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
        </ul>
    </div>
</div>
<script type="text/javascript">
var hire_no = 0;
var mode = '';
var isRun = false;
function deleteOK() {
	$.ajax({type: 'POST',
		url: 'json.php',
		data:"&mode=state_del&hire_no="+hire_no,
		dataType: 'json',
		cache: false,
		beforeSend: function() { },
		success: function(data) {
			try
			{
				//alert(data.resCode);
				if(data.resCode == 1){
					location.reload();
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

function cancelOK() {

	//window.nightingale.showLoading('1');
	
	var fin_why = $("input[name='fin_why']:checked").val();
	if(isRun == true) {
        return;
    }
    
    isRun = true;

	$.ajax({type: 'POST',
		url: 'json.php',
		data:"&mode="+mode+"&hire_no="+hire_no+"&fin_why="+fin_why,
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
					location.reload();
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

function deleteForm1(hire_no1) {
	hire_no = hire_no1;
	$('.popup_form3').css('display', 'block');
}
function deleteForm3() {
	$('.popup_form1').css('display', 'block');
	$('.popup_form3').css('display', 'none');
}
function deleteForm2(hire_no1, mode1) {
	hire_no = hire_no1;
	mode    = mode1;
	$('.popup_form4').css('display', 'block');
}
function deleteForm4(hire_no1, mode1) {
	hire_no = hire_no1;
	mode    = mode1;
	$('.popup_form2').css('display', 'block');
}
function cancelOK1() {
	$('.popup_form2').css('display', 'block');
	$('.popup_form4').css('display', 'none');
}
function closeForm1() {
	$('.popup_form').css('display', 'none');
}

</script>
<?php
$menu = "state";
include('../../lib/menu.php');
include('../../lib/footer.php');
?>
<script>
function Search_Page(n)
{
	if(n == "#") return;
	$("#SearchForm").submit();//GetRow_item();
}

</script>