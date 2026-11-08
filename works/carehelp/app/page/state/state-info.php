<?php
include('../../lib/header.php');
$title = "상세페이지";
include('../../lib/title.php');
include('../../../common.php');
include_once ("../../../_inc/inc_fn.php");
$param = null;

$hire_no = $_GET['hire_no']==null? 0:$_GET['hire_no'];

$sql = "SELECT *, AES_DECRYPT(UNHEX(patient_tel),KEY) as patient_tel FROM hire_info WHERE hire_no = ".$hire_no;
$data = $pdo->row($sql, $param);

$date = date('Y-m-d H:m:s');
$sdate = $data['hire_sdate']." ".$data['hire_stime'].":00:00";
$edate = $data['hire_edate']." ".$data['hire_etime'].":00:00";
$edate_time = $data['end_date'];

$str_date = strtotime($date);
$str_sdate = strtotime($sdate);
$str_edate = strtotime($edate);
$str_edate_time = strtotime($edate_time);

if($grade != 2) {
	$state_nm = array(1 => $grade == 1 ? "지원요청중":"공고 중", 2 => "모집완료", 10 => "종료", 11 => "간병취소요청", 99 => "취소");
	$state_co = array(1 => "#3478F6", 2 => "#000", 10 => "#8C8F97", 11 => "#FF4E34", 99 => "#FF4E34");
} else {
	$state_nm = array(1 => "지원", 2 => "채용확정", 10 => "종료", 11 => "간병취소요청", 99 => "취소");
	$state_co = array(1 => "#3478F6", 2 => "#3478F6", 10 => "#8C8F97", 11 => "#FF4E34", 99 => "#FF4E34");

	$work = $pdo->query("SELECT *, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.user_no = ".$_SESSION['user_no']." AND a.state = 2 AND b.state = 2 ", $param);

	
	if($work != null) {
		foreach($work as $w) {
		$where .= " AND NOT (DATE_FORMAT('".$sdate."', '%Y-%m-%d %H:%i:%s') <  '".$w['edate']."' AND DATE_FORMAT('".$edate."', '%Y-%m-%d %H:%i:%s') > '".$w['sdate']."')";
		
		}
		$sql = "SELECT * FROM hire_info WHERE hire_no = ".$hire_no.$where;
		$work_data = $pdo->row($sql, $param);
		//echo $sql;
	}

	$pay_no = $_GET['pay_no'] == null ? 0 : $_GET['pay_no'];
	$pay_info = $pdo->row("SELECT * FROM pay_info WHERE pay_no = ".$pay_no, $param);
}

$hire_nm = array(0 => "성별무관", 1 => "남성선호", 2 => "여성선호");
$type1 = array(1 => "혼자가능", 2 => "불가능", 3 => "거동보조");
$type2 = array(1 => "가능", 2 => "피딩", 3 => "금식");

$type8 = $pdo->query("SELECT * FROM code_info WHERE majr = 8 AND use_yn = 1 ORDER BY minr");


$sql = "SELECT * FROM pay_info WHERE state = 1 AND hire_no = ".$data['hire_no']." AND user_no = ".$_SESSION['user_no'];
$pay = $pdo->single($sql, $param);


$endDate = strtotime($data['end_date']);
$today = strtotime(date('Y-m-d H:i:s'));

$diff = $endDate - $today;

//$day = floor($diff/(24*3600));
//$diff = $diff-($day*(24*3600));
$hours = floor($diff/3600);

$user = $pdo->row("SELECT * FROM user_info WHERE user_no = ".$_SESSION['user_no']);

$agcy_state = $pdo->single("SELECT agency_state FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param);

$sql = "SELECT count(*) FROM pay_info WHERE hire_no = ".$hire_no;
$pay_cnt = $pdo->single($sql, $param);

$pay_type = array(1 => '시급', 2 => '일급', 3 => '월급');

$alim_no = $_GET['alim_no'] == null ? 0:$_GET['alim_no'];
if($alim_no > 0) {
	$rs = $pdo->query("UPDATE alim_info SET read_yn = 1 WHERE alim_no = ".$alim_no, $param);
}

$pay_yn = $pdo->query("SELECT * FROM pay_info WHERE state = 2 AND hire_no = ".$hire_no." AND user_no = ".$_SESSION['user_no'], $param);

if($data['user_no'] != $_SESSION['user_no']) {
	$hit = $pdo->query("UPDATE hire_info SET hit = hit + 1 WHERE hire_no = ".$hire_no, $param);
}
?>
<style>
body {
	background: #F8F8F8;
}

p {
    font-size: 1.5rem;
    font-weight: bold;
}

.content_page {
	margin-bottom: 50px;
}
.popup_form  .content_page {
	margin-bottom: 0;
}

.state_form {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
}

.state_info {
	max-width: 768px;
	margin: 0 auto;
	position: absolute;
	bottom: 0;
}

.date_state {
    margin-bottom: 20px;
}

table.info_table {
    margin: 5px 0 20px 0;
}

table td a {
    display: inline;
    color: #000;
    padding: 2px 8px;
    margin-left: 5px;
    font-size: 0.9rem;
    font-weight: 500;
    border: 1px solid #DEDEDE;
    border-radius: 3px;
}
</style>
<div class="content_wrap">
    <div class="content_page">
		<?php if ($data['user_no'] == $_SESSION['user_no']) { ?>
        <div class="d-flex justify-content-between align-items-center date_state">
            <p><?=substr($data['reg_date'],0,10)?></p>
			<?php if($data['state'] == 2 && $sdate <= $date && $edate >= $date) { ?>
            <span style="margin-right:0; color:<?=$state_co[$data['state']]?>;">근무 중</span>
			<?php } else if(($data['state'] == 1 && $edate_time < $date) || ($data['state'] == 2 && $edate < $date)) {?>
            <span style="margin-right:0; color:#8C8F97;">종료</span>
			<?php } else { ?>
            <span style="margin-right:0; color:<?=$state_co[$data['state']]?>;"><?=$state_nm[$data['state']]?></span>
			<?php } ?>
        </div>
		<?php } else { ?>
        <div class="date_state">
			<?php if($data['user_grade'] == 1) { ?>
            <p><?=$data['patient_sex'] == 1 ? "남성":"여성"?>/<?=$data['patient_age']?>세/<?=$data['patient_weight']?>kg</p>
			<?php } else { 
					$user_agency = $pdo->single( "SELECT agency_state FROM user_info WHERE user_no = ".$data['user_no'],$param);
					if($user_agency == 0) {
					$sql = "SELECT * FROM user_info WHERE user_no = ".$data['user_no'];
					} else {
					$sql = "SELECT *, b.association_nm as association_nm, a.responsibility as responsibility FROM user_info a
							LEFT OUTER JOIN user_info b ON a.association_nm = b.user_no WHERE a.user_no = ".$data['user_no'];
					}
					$user_info = $pdo->row($sql, $param); ?>
            <p><?=$user_info['association_nm']?>/<?=$user_info['responsibility']?></p>
			<?php } ?>
			<?php if($data['state'] == 1 && $day.$hours > 0) { ?>
			<p style="color:#3478F6; font-size: 1.5rem; font-weight: bold;"><?="공고 ".$hours."시간 남음"?></p>
			<?php } ?>
        </div>
		<?php } ?>
		<div class="state_card">
			<div class="state_header">
				<p>기본정보</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<?php if($data['state'] == 10) {
						$fin_why_no = $data['fin_why'] == null ? 99 : $data['fin_why'];
						$fin_why = $pdo->single("SELECT name FROM code_info WHERE majr = 11 AND minr = ".$fin_why_no, $param); ?>
					<tr>
						<th>중단사유</th>
						<td><?=$fin_why?></td>
					</tr>
					<?php } ?>
					<?php if($pay_info['state'] == 99) {
						$fin_why_no = $data['fin_why'] == null ? 99 : $data['fin_why'];
						$fin_why = $pdo->single("SELECT name FROM code_info WHERE majr = 11 AND minr = ".$fin_why_no, $param); ?>
					<tr>
						<th>취소사유</th>
						<td><?=$fin_why?></td>
					</tr>
					<?php } ?>
					<?php if($data['user_grade'] == 3) { ?>
					<tr>
						<th>분류</th>
						<td><?=$data['hire_type'] == 1 ? "개인간병":"공동간병"?></td>
					</tr>
					<?php } ?>
					<?php if($data['hire_type'] == 1) { ?>
					<tr>
						<th>근무형태</th>
						<td><?=$data['addr_type'] == 1 ? "병원간병":"재가간병"?></td>
					</tr>
					<?php } ?>
					<?php if($data['hire_type'] == 2) { ?>
					<tr>
						<th>환자 수</th>
						<td><?=$data['patient_cnt']?>명</td>
					</tr>
					<tr>
						<th>모집인원</th>
						<td><?=$data['work_cnt'] > 0 ? substr($data['work_cnt'],-1,1):1?>명</td>
					</tr>
					<?php } ?>
					<?php if($data['user_grade'] == 3) { ?>
					<tr>
						<th>간병위치</th>
						<?php
							if($data['addr_type'] == 1) {
								$hospital = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".$data['hire_addr']."'", $param);
							}
							if($data['addr_type'] == 2) {
								$str = $data['hire_addr'];
								$addr = explode(' ',$str);
								$cnt = count($addr);

								for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
									${'hire_addr'.$hire_no} .= $addr[$i]." ";
								}
							}

							//$pay_yn = $pdo->query("SELECT * FROM pay_info WHERE state = 2 AND hire_no = ".$hire_no." AND user_no = ".$_SESSION['user_no'], $param);
						?>
						<?php if($data['user_no'] == $_SESSION['user_no'] || $pay_yn != null) { ?>
						<td>
							<div class="d-flex justify-content-between align-items-center license">
								<p><?=$data['addr_type'] == 1 ? $hospital."</br>":""?><?=$data['hire_addr']?></p>
								<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
									$get_code = get_kakao_geocode($data['hire_addr']);
									$xml = simplexml_load_string($get_code); 
									$latitude = (float)$xml->documents->y;
									$longitude = (float)$xml->documents->x;
										 
								?>
								<a href="map:<?=$latitude.",".$longitude?>">길찾기</a>
								<?}else{?>
								<a href="map:<?=$data['hire_addr']?>">길찾기</a>
								<?}?>
							</div>
							<?=$data['hire_addr2']?>
						</td>
						<?php } else { ?>
						<td><?=$data['addr_type'] == 1 ? $hospital:${'hire_addr'.$hire_no}?></td>
						<?php } ?>
					</tr>
					<?php } ?>
					<?php if($data['user_no'] == $_SESSION['user_no'] || $pay_yn != null) { ?>
					<tr>
						<th>보호자</th>
						<td>
							<div class="d-flex justify-content-between align-items-center license">
								<?php if($data['user_grade'] == 1) {$user_tel = $pdo->single("SELECT AES_DECRYPT(UNHEX(user_tel),KEY) FROM user_info WHERE user_no = ".$data['user_no'], $param); ?>
								<p><?=$user_tel?></p>
								<a href="tel:<?=$user_tel?>">전화하기</a>
								<?php } else { ?>
								<p><?=$data['patient_tel'] == null ? "-":$data['patient_tel']?></p>
								<?php if($data['patient_tel'] != null) { ?>
								<a href="tel:<?=$data['patient_tel']?>">전화하기</a>
								<?php } 
								} ?>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php if($data['user_no'] == $_SESSION['user_no']) {
						$sql = "SELECT user_name, a.pay_no as pay_no FROM pay_info a
								LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
								WHERE a.state = 2 AND a.hire_no = ".$data['hire_no'];
						$user = $pdo->row($sql, $param);

						$sql = "SELECT user_name, a.pay_no as pay_no FROM pay_info a
								LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
								WHERE a.state = 2 AND a.hire_no = ".$data['hire_no'];
						$user_list = $pdo->query($sql, $param);

						$sql = "SELECT count(*) FROM pay_info a
								LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
								WHERE a.state = 2 AND a.hire_no = ".$data['hire_no'];
						$user_cnt = $pdo->single($sql, $param); ?>
					<tr>
						<th>간병사</th>
						<?php if($user_cnt <= 1) { ?>
						<td><?=$user == null ? "-":$user['user_name']." <a href='pay-info.php?pay_no=".$user['pay_no']."'>상세보기</a>"?></td>
						<?php } else { ?>
						<td>
						<?php	foreach($user_list as $d) { ?>
						<?=$d['user_name']?> <a style="display:inline-block; margin-bottom: 3px;" href='pay-info.php?pay_no=<?=$d['pay_no']?>'>상세보기</a></br>
						<?php } ?>
						</td>
						<?php } ?>
					</tr>
					<?php } ?>
					<tr>
						<?php
							$days = (strtotime($data['hire_edate']) - strtotime($data['hire_sdate'])) / 86400;
						?>
						<th>간병기간</th>
						<td><p style="color: #3478F6; font-size: 20px; font-weight: 500;">[<?=$days + 1?>일]</p><?=$data['hire_sdate']?> <?=$data['hire_stime']?>:00 ~</br><?=$data['hire_edate']?></td>
					</tr>
					<tr>
						<?php
							$hire_time = $pdo->single("SELECT name FROM code_info WHERE majr = 10 AND minr = ".$data['hire_time'], $param);
							$hire_time_etc = $pdo->single("SELECT etc FROM code_info WHERE majr = 10 AND minr = ".$data['hire_time'], $param);
						?>
                        <th>간병시간</th>
                        <td><?=$hire_time.$hire_time_etc?></td>
					</tr>
					<tr>
						<th>선호성별</th>
						<td><?=$hire_nm[$data['hire_sex']]?></td>
					</tr>
					<?php if($data['user_grade'] == 3) { ?>
					<tr>
						<th>간병비</th>
                        <td style="color:#3478F6; font-weight: bold;"><?=$data['pay_type'] == 4 ? "보호자와 협의":$pay_type[$data['pay_type']]." / ".number_format($data['pay'])."원"?></td>
					</tr>
					<?php } ?>
					<!--<tr>
						<th>게시기간</th>
						<td>5일 후 12시 종료</td>
					</tr>-->
				</table>
			</div>
		</div>
		<?php if($data['user_grade'] == 1) { ?>
		<div class="state_card">
			<div class="state_header">
				<p>장소</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<th>구분</th>
						<td><?=$data['addr_type'] == 1 ? "병원":"집"?></td>
					</tr>
					<tr>
						<th>주소</th>
						<?php
							$hospital = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".$data['hire_addr']."'", $param);
							if($grade == 2) { 
								if($data['addr_type'] == 1) {
									$hospital = $pdo->single("SELECT dutyName FROM hospital_info WHERE dutyAddr = '".$data['hire_addr']."'", $param);
								}
								if($data['addr_type'] == 2) {
									$str = $data['hire_addr'];
									$addr = explode(' ',$str);
									$cnt = count($addr);

									for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
										${'hire_addr'.$hire_no} .= $addr[$i]." ";
									}
								}
							} else {
								$str = $data['hire_addr'];
								$addr = explode(' ',$str);
								$cnt = count($addr);

								for($i=0; $i<2; $i++) { // for문을 돌면서 차례대로 출력
									${'hire_addr'.$hire_no} .= $addr[$i]." ";
								}
							}

							//$pay_yn = $pdo->query("SELECT * FROM pay_info WHERE state = 2 AND hire_no = ".$hire_no." AND user_no = ".$_SESSION['user_no'], $param);
						?>
						<?php if($data['user_no'] == $_SESSION['user_no'] || $pay_yn != null) { ?>
						<td>
							<div class="d-flex justify-content-between align-items-center license">
								<p><?=$data['addr_type'] == 1 ? $hospital."</br>":""?><?=$data['hire_addr']?></p>
								<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
									$get_code = get_kakao_geocode($data['hire_addr']);
									$xml = simplexml_load_string($get_code); 
									$latitude = (float)$xml->documents->y;
									$longitude = (float)$xml->documents->x;
										 
								?>
								<a href="map:<?=$latitude.",".$longitude?>">길찾기</a>
								<?}else{?>
								<a href="map:<?=$data['hire_addr']?>">길찾기</a>
								<?}?>
							</div>
							<?=$data['hire_addr2']?>
						</td>
						<?php } else { ?>
						<td><?=$data['addr_type'] == 2 || $grade == 3 ? ${'hire_addr'.$hire_no}:$hospital?></td>
						<?php } ?>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>
		<?php if($data['hire_type'] != 2) { ?>
		<div class="state_card">
			<div class="state_header">
				<p>환자정보</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<?php if($grade != 3) { ?>
					<tr>
						<th>환자명</th>
						<?php if($data['user_no'] == $_SESSION['user_no'] || $pay_yn != null) {?>
						<td><?=$data['patient_name'] == null ? '-':$data['patient_name']?></td>
						<?php } else { ?>
						<td>-</td>
						<?php } ?>
					</tr>
					<?php } ?>
					<tr>
						<th>나이</th>
						<td><?=$data['patient_age']?>세</td>
					</tr>
					<tr>
						<th>성별</th>
						<td><?=$data['patient_sex'] == 1 ? "남성":"여성"?></td>
					</tr>
					<tr>
						<th>몸무게</th>
						<td><?=$data['patient_weight']?>kg</td>
					</tr>
					<tr>
						<th>진단정보</th>
						<td><?=$data['patient_cont'] == null ? "-":$data['patient_cont']?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="state_card">
			<div class="state_header">
				<p>증상정보</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<th>거동상태</th>
						<td><?=$type1[$data['patient_type1']]?></td>
					</tr>
					<tr>
						<th>식사상태</th>
						<td><?=$type2[$data['patient_type2']]?></td>
					</tr>
					<tr>
						<th>수면상태</th>
						<td><?=$data['patient_type3'] == 1 ? "숙면":"불면증"?></td>
					</tr>
					<tr>
						<th>섬망상태</th>
						<td><?=$data['patient_type4'] == 1 ? "없음":"있음"?></td>
					</tr>
					<tr>
						<th>치매상태</th>
						<td><?=$data['patient_type5'] == 1 ? "없음":"있음"?></td>
					</tr>
					<tr>
						<th>배설상태</th>
						<td>
						<?php if($data['patient_type6'] != 0) {
							$type6_list = explode(",", $data['patient_type6']);
							foreach($type6_list as $tp6) {
								$type6 = $pdo->single("SELECT name FROM code_info WHERE majr = 6 AND minr =".$tp6);
								$arr6[] = $type6; 
							}
							$type6 = implode("</br>", $arr6);	
							}
						?>
							<?=$type6 == null ? "해당없음":$type6?>
						</td>
					</tr>
					<!--<tr>
						<th>격리상태</th>
						<td>
						<?php if($data['patient_type7'] != 0) {
							$type7_list = explode(",", $data['patient_type7']);
							foreach($type7_list as $tp7) {
								$type7 = $pdo->single("SELECT name FROM code_info WHERE majr = 7 AND minr =".$tp7);
								$arr7[] = $type7; 
							}
							$type7 = implode(", ", $arr7);	
							}
						?>
							<?=$type7 == null ? "해당없음":$type7?>
						</td>
					</tr>-->
					<tr>
						<th>특이사항</th>
						<td>
						<?php if($data['etc'] != 0) {
							$type8_list = explode(",", $data['etc']);
							foreach($type8_list as $tp8) {
								$type8 = $pdo->single("SELECT name FROM code_info WHERE majr = 8 AND minr =".$tp8);
								$arr8[] = $type8; 
							}
							$type8 = implode("</br>", $arr8);	
							}
						?>
							<?=$type8 == null || $data['etc'] == 0 ? "해당없음":$type8?> 
						</td>
					</tr>
				</table>
			</div>
		</div>
		<?php } ?>
		<div class="state_card">
			<div class="state_header">
				<p>상세내용</p>
			</div>
			<div class="state_body">
				<table class="info_table">
					<tr>
						<td><?=$data['hire_cont'] == null ? '-':nl2br($data['hire_cont'])?></td>
					</tr>
				</table>
			</div>
		</div>
    </div>
    <form action="" class="state_info">
    <?php if($grade == 1) { 
		if ($data['state'] == 1 && $edate_time >= $date && $pay_cnt == 0) { ?>
        <a href="/app/page/form/pay-form1.php?hire_no=<?=$hire_no?>" style="background: #3478F6;">수정하기</a>
		<?php }
		if($data['state'] != 2 && $pay_cnt == 0) { ?>
        <button onclick="deleteForm1(<?=$data['hire_no']?>);" type="button" style="background: #000;width: <?=$data['state'] == 99 || ($data['state'] == 1 && $edate_time < $date) ? 100:50?>%;">삭제하기</button>
		<?php }
		if($data['state'] == 1 && $pay_cnt > 0 && $edate_time >= $date) { ?>
        <button onclick="deleteForm2(<?=$data['hire_no']?>,'appl_can');" type="button" style="background: #000;width: 100%;">모집취소하기</button>
    <?php } ?>
	<?php	} ?>
    <?php if($grade != 1 && $data['state'] == 1 && $date <= $data['end_date'] && !$pay) { ?>
	<?php if($data['user_grade']==1) {
		if ($grade == 2 && !$pay && $work_data) {?>
				<?php if($agcy_state == 1) { ?>
        <button onclick="<?=$agcy_state == 1 ? "openForm2":"openForm6"?>(<?=$hire_no?>, <?=$data['user_grade']?>);" type="button" style="background: #3478F6; width: 100%;">예상 간병비 제안</button>
				<?php } else { ?>
        <a href="/app/page/mypage/agency.php" style="background: #000000; width: 100%;">예상 간병비 제안</a>
				<?php } ?>
	<?php } }else{ 
		if ($grade == 2 && !$pay && $work_data) {?>
				<?php if($agcy_state == 1) { ?>
		<input type="hidden" name="type" value="2">
		<input type="hidden" name="user_no" value="<?=$_SESSION['user_no']?>">
		<input type="hidden" name="membership" value="<?=$user['membership']?>">   
		<input type="hidden" name="ticket" value="<?=$user['ticket']?>">
		<button onclick="<?=$agcy_state == 1 ? "payForm":"openForm6"?>(<?=$hire_no?>, <?=$data['user_grade']?>);" type="button" style="background: #000000; width: 100%;">지원하기</button>
				<?php } else { ?>
        <a href="/app/page/mypage/agency.php?type=3&agency_no=<?=$data['user_no']?>" style="background: #000000; width: 100%;">지원하기</a>
				<?php } ?>
	<?php } } ?>	
    <?php } ?>
    </form>
    <form action="" class="popup_form popup_form2">
		<div class="hire_no"></div>
		<input type="hidden" name="mode" value="pay">
		<input type="hidden" name="type" value="1">
		<input type="hidden" name="user_no" value="<?=$_SESSION['user_no']?>">
		<input type="hidden" name="membership" value="<?=$user['membership']?>">   
		<input type="hidden" name="ticket" value="<?=$user['ticket']?>">
        <div class="pay_form">
            <div class="content_page">
                <p class="content_title">예상 간병비 제안</p>
                <div class="state_form d-block">
                    <label for="" style="margin-bottom: 3px;">간병비(일급)</label>
                    <input type="text" name="pay" placeholder="금액을 입력해주세요" style="width: 100%" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');">
                </div>
                <p class="content_text" style="color:#3478F6">간병비는 보호자에게 참고용으로 전달됩니다.</br>예상 금액을 정확히 제시해주세요.</p>
            </div>
            <div class="btn_box d-flex justify-content-between">
                <button onclick="closeForm();" type="button" style="background: #000;">닫기</button>
                <button onclick="payInput();" type="button" style="background: #3478F6;">예상 간병비 제안</button>
            </div>
        </div>
    </form>
			<div class="popup_form popup_form1">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">정말 삭제하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="deleteOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form8">
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
			<div class="popup_form popup_form7">
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
			<div class="popup_form popup_form3" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree2" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">금액을 입력해주세요.</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 100%; background: #000000; border-bottom-right-radius:15px;">닫기</button>
					</div>
				</div>
			</div>
			<div class="popup_form popup_form4" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">견적을 넣으시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="payOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form5" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 17px;">지원하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="payOK2();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form6" style="z-index:55; ">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 400px;">
						<div style="width: 100%;text-align: center;"><img style="width: 80px;" src="/img/warnning.svg"></div>
						<div id="agree3" style="width: 100%;text-align: center;margin-top: 15px;font-weight: bold;font-size: 22px; color: #3478F6;">소속 협회에 가입해주세요!</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px;">협회에 가입 시 견적참여, 구인지원 등 다양한</br>서비스를 이용할 수 있습니다</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px; color:#455572; background: #F1F3F6; padding: 15px;">협회가 가입되어 있지 않은 경우</br>APP 가입신청을 해야 합니다</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm3();" type="button" style="width: 33%; background: #000000; border-bottom-left-radius:15px;">닫기</button>
						<a href="share://나이팅게일 친구초대하기" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">협회에 요청하기</a>
						
					</div>
				</div>
			</div>
</div>
<script type="text/javascript">
var hire_no = 0;
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

function cancelOK() {

	//window.nightingale.showLoading('1');
	
	if(isRun == true) {
        return;
    }
    
    isRun = true;

	$.ajax({type: 'POST',
		url: 'json.php',
		data:"&mode="+mode+"&hire_no="+hire_no,
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
	$('.popup_form8').css('display', 'block');
}
function deleteForm3() {
	$('.popup_form1').css('display', 'block');
	$('.popup_form8').css('display', 'none');
}
function deleteForm2(hire_no1, mode1) {
	hire_no = hire_no1;
	mode    = mode1;
	$('.popup_form7').css('display', 'block');
}
function closeForm1() {
	$('.popup_form1').css('display', 'none');
}

</script>
<?php
include('../../lib/footer.php');
?>
<script>
	/* function myFunction() {
        var check = confirm("견적을 넣으시겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }

	} */

	function payInput() {
		var pay = $("input[name='pay']").val();
		//alert이 단말기에 따라 안보일수 있으므로 다른것으로 교체해야 할지도...
		if(pay == "") { 
			document.getElementById('agree2').innerHTML = '금액을 입력해주세요.';
			$('.popup_form3').css('display', 'block');
			return; 
		} else if(pay.length > 6) {
			document.getElementById('agree2').innerHTML = '금액을 확인해주세요.';
			$('.popup_form3').css('display', 'block');
			return; 
		} else {
			$('.popup_form4').css('display', 'block');
			return; 
		}
	}
	function payOK() {
	
		if(isRun == true) {
			return;
		}
		
		isRun = true;

		var hire_no = $("input[name='hire_no']").val();
		var user_no = $("input[name='user_no']").val();
		var type = $("input[name='type']").val();
		var pay = $("input[name='pay']").val();

		var membership = $("input[name='membership']").val();
		var ticket = $("input[name='ticket']").val();

		if(membership == 0 && ticket <= 0) {

			document.getElementById('agree2').innerHTML = '견적이용권이 없습니다.';
			$('.popup_form3').css('display', 'block');
			$('.popup_form4').css('display', 'none');
			return; 

		} else {
			$.ajax({type: 'POST',
				url: 'json.php',
				data:"&mode=pay&hire_no="+hire_no+"&user_no="+user_no+"&pay="+pay+"&type="+type+"&membership="+membership+"&ticket="+ticket,
				dataType: 'json',
				cache: false,
				beforeSend: function() { },
				success: function(data) {
					try
					{
						//alert(data.resCode);
						if(data.resCode == 1){
							isRun  = false;
							window.location.href = "state-list.php?type="+type;
						}
						else if(data.resCode == -2) {
							document.getElementById('agree2').innerHTML = '모집 완료된 견적 요청입니다.';
							$('.popup_form3').css('display', 'block');
							$('.popup_form4').css('display', 'none');
							$('.popup_form2').css('display', 'none');
							return; 
						}
						else{
							window.location.href = "state-list.php?type="+type;
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

	function payForm(no, grade) {
		$('.popup_form5').css('display', 'block');
		$('.hire_no').html('<input type="hidden" name="hire_no" value='+no+'>');
		$('.user_grade').html('<input type="hidden" name="user_grade" value='+grade+'>');
	}

	function payOK2() {
	
		if(isRun == true) {
			return;
		}
		
		isRun = true;

		var hire_no = $("input[name='hire_no']").val();
		var user_no = $("input[name='user_no']").val();
		var type = $("input[name='type']").val();

		var membership = $("input[name='membership']").val();
		var ticket = $("input[name='ticket']").val();

		if(membership == 0 && ticket <= 0) {

			document.getElementById('agree2').innerHTML = '견적이용권이 없습니다.';
			$('.popup_form3').css('display', 'block');
			$('.popup_form4').css('display', 'none');
			return; 

		} else {
			$.ajax({type: 'POST',
				url: 'json.php',
				data:"&mode=pay&hire_no="+hire_no+"&user_no="+user_no+"&type="+type+"&membership="+membership+"&ticket="+ticket,
				dataType: 'json',
				cache: false,
				beforeSend: function() { },
				success: function(data) {
					try
					{
						//alert(data.resCode);
						if(data.resCode == 1){
							isRun  = false;
							window.location.href = "state-list.php?type="+type;
						}
						else if(data.resCode == -2) {
							document.getElementById('agree2').innerHTML = '모집 완료된 구인 요청입니다.';
							$('.popup_form3').css('display', 'block');
							$('.popup_form4').css('display', 'none');
							return; 
						}
						else{
							window.location.href = "state-list.php?type="+type;
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


    function openForm2(no, grade) {
        $('.popup_form2').css('display', 'block');
		$('.hire_no').html('<input type="hidden" name="hire_no" value='+no+'>');
		$('.user_grade').html('<input type="hidden" name="user_grade" value='+grade+'>');
    }
    function openForm6() {
        $('.popup_form6').css('display', 'block');
    }

    function closeForm() {
        $('.popup_form').css('display', 'none');
    }

    function closeForm3() {
        $('.popup_form3').css('display', 'none');
        $('.popup_form4').css('display', 'none');
        $('.popup_form5').css('display', 'none');
        $('.popup_form6').css('display', 'none');
    }
</script>
