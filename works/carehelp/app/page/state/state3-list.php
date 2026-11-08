<?php
include('../../lib/header.php');
include('../../../common.php');

$param = null;
//설정한 지역 값 가져와서 검색하기
function unicode_decode($str) {
	return json_decode(sprintf('"%s"', $str));
}

$areas=explode(',',unicode_decode( str_replace('%' , '\\', $_COOKIE['area'])));//지역값 배열
$areas_string = unicode_decode( str_replace('%' , '\\', $_COOKIE['area']));//지역값 스트링 

$date = date('Y-m-d H:m:s');
$type = $_POST['type']==null? 0:$_POST['type'];
$where ="";if($type!=0){
	$where = " AND a.hire_type=".$type;
}
if($grade == 3){

	$state = $_POST['state']==null? 0:$_POST['state'];
	
	if($state!=0){
		if($state == 1 ) {
			$where .= " AND a.state = 1 AND a.end_date >= NOW()";
		}
		if($state == 2 ) {
			$where .= " AND ( a.state = 2 AND CONCAT(a.hire_edate, ' ', a.hire_etime, ':59:59') >= NOW() ) ";
		}
		if($state == 3 ) {
			$where .= " AND a.state IN (11,99) ";
		}
		if($state == 4 ) {
			$where .= " AND (( a.state = 1 AND a.end_date < NOW() ) OR (a.state = 2 AND CONCAT(a.hire_edate, ' ', a.hire_etime, ':59:59') < NOW()) OR (a.state = 10))";
		}
	}

	$my = $pdo->row("SELECT agency_state, association_nm FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param);

	if($my['agency_state'] == 0) {
		$sql = "SELECT *, a.state as state, a.reg_date as reg_date, a.pay_type as pay_type FROM hire_info a
			LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
			WHERE a.user_grade = 3 ".$where." AND a.use_yn = 1 AND (a.user_no = ".$_SESSION['user_no']." OR b.association_nm = ".$_SESSION['user_no'].") ORDER BY a.hire_no DESC";
	} else {
		$sql = "SELECT *, a.state as state, a.reg_date as reg_date, a.pay_type as pay_type FROM hire_info a
			LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
			WHERE a.user_grade = 3 ".$where." AND a.use_yn = 1 AND (a.user_no = ".$my['association_nm']." OR b.association_nm = ".$my['association_nm'].") ORDER BY a.hire_no DESC";
	}
	$list_data = $pdo->query($sql, $param);

	
	$state_nm = array(1 => "공고 중", 2 => "모집완료", 10 => "종료", 11 => "간병취소요청", 99 => "취소");
	$state_co = array(1 => "#3478F6", 2 => "#000", 10 => "#8C8F97", 11 => "#FF4E34", 99 => "#FF4E34");
}else{
	
	$work = $pdo->query("SELECT *, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H-%i-%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H-%i-%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.user_no = ".$_SESSION['user_no']." AND a.state = 2 AND b.state = 2 ", $param);
	//$work_cnt = $pdo->single("SELECT count(*) FROM pay_info WHERE user_no = ".$_SESSION['user_no']." AND state = 2 ", $param);



	if($work != null) {
		foreach($work as $w) {
		$where .= " AND NOT(DATE_FORMAT(CONCAT(a.hire_sdate,' ',a.hire_stime,':00:00'), '%Y-%m-%d %H-%i-%s') <  '".$w['edate']."' AND DATE_FORMAT(CONCAT(a.hire_edate,' ',a.hire_etime,':59:59'), '%Y-%m-%d %H-%i-%s') > '".$w['sdate']."')";
		
		}
		//echo $where;
	}

	$my = $pdo->row("SELECT * FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param);

	if($my['agency_state'] == 1) {
		$where .= " AND ( a.user_no = '".$my['association_nm']."' OR b.association_nm = '".$my['association_nm']."')";
	}

	$sql = "SELECT *, a.state as state, a.reg_date as reg_date, a.pay_type as pay_type FROM hire_info a
			LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
			WHERE a.state = 1 AND a.use_yn = 1 AND a.end_date >= '".$date."' AND a.user_grade = 3 ".$where." ORDER BY a.end_date ASC, a.hire_no DESC";
	$list_data = $pdo->query($sql, $param);
}
if(strlen($areas_string)>0 && $grade == 2){
	$sql = "SELECT *, a.state as state, a.reg_date as reg_date, a.pay_type as pay_type FROM hire_info a
			LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
			WHERE '".implode(' ',$areas)."' LIKE CONCAT('%',SUBSTRING_INDEX(a.hire_addr, ' ', 1),'%') AND a.state = 1 AND a.use_yn = 1 AND a.end_date >= '".$date."' AND a.user_grade = 3 ".$where." ORDER BY a.reg_date DESC";
	$list_data = $pdo->query($sql, $param);
}
//print_r($sql);
$sql = "SELECT * FROM code_info WHERE majr = 5 AND minr != 0 AND use_yn = 1";
$area_list = $pdo->query($sql, $param);

$pay_type = array(1 => '시급', 2 => '일급', 3 => '월급');

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
    body {
        background: #F8F8F8;
    }

    .content_page {
        position: relative;
    }

    .state_form {
        display: flex;
        justify-content: space-between;
		margin: 20px 0;
    }

    .state_form>div {
        width: 32%;
        text-align: center;
    }

    .state_form>div input {
        display: none;
    }

    .state_form>div label {
        margin: 0;
        width: 100%;
        font-size: 1rem;
        font-weight: 500;
        background: #fff;
        border: 1px solid #D7D8E0;
        border-radius: 15px;
        padding: 15px 0;
    }

    .state_form>div label svg {
        display: block;
        width: 25px;
        height: 25px;
        margin: 0 auto;
    }

    .state_form>div input:checked+label {
        color: #fff;
        background: #3478F6;
        border-color: #3478F6;
    }

    .state_form>div input:checked+label svg path {
        fill: #fff;
    }
    .state_form>div input:checked+label svg .blue {
        stroke: #3478F6;
        stroke-width: 3;
    }
    
    <?php if($grade == 2) { ?>
    .date_state {
        margin-bottom: 2px;
    }
    <?php } ?>

    .write_btn {
        position: fixed;
        width: 30%;
        bottom: 12%; right: 3%;
        text-align: right;
    }
    .write_btn img {
        width: 30%;
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

	@media screen and (min-width: 768px) {
		.write_btn {
			width: 150px;  right: 30%;
		}
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
        <div class="h-wrap">
            <div><a href=""><img src="/img/logo_b.svg" alt=""></a></div>
            <div style="text-align:right"><a href="/app/page/mypage/alim-list.php" class="alim"><img src="/img/alim_b.svg" alt="" style="width: 45%;""><div class="alim_yn" style="<?=$alim == null ? "display:none":""?>"></div></a></div>
        </div>
        <form action="<?=$_SERVER['PHP_SELF']?>" name='selType' method="post">
            <div class="state_form">
                <div>
                    <input type="radio" name="type" id="type0" <?php if($type==0) echo 'checked';?> value="0">
                    <label for="type0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                            <g id="그룹_27178" data-name="그룹 27178" transform="translate(-230 -320)">
                                <rect id="사각형_24608" data-name="사각형 24608" width="100" height="100"
                                    transform="translate(230 320)" fill="none" />
                                <path id="패스_8845" data-name="패스 8845"
                                    d="M-54.066-31.348l.9-3.541c1.068-4.16,2.192-9.05,3.2-13.435h.225c1.124,4.272,2.192,9.275,3.316,13.435l.9,3.541Zm12.872,17.369h10.568L-43.611-55.8H-55.64L-68.625-13.979h10.23l2.417-9.612h12.366Zm13.828,0H-1.059V-22.41H-17.3V-55.8H-27.366Zm32.434,0H31.375V-22.41H15.13V-55.8H5.068Z"
                                    transform="translate(298.625 404.8)" fill="#3478f6" />
                            </g>
                        </svg>
                        전체
                    </label>
                </div>
                <div>
                    <input type="radio" name="type" id="type1" <?php if($type==1) echo 'checked';?> value="1">
                    <label for="type1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                            <g id="그룹_27159" data-name="그룹 27159" transform="translate(17382 5771)">
                                <rect id="사각형_24609" data-name="사각형 24609" width="100" height="100"
                                    transform="translate(-17382 -5771)" fill="none" />
                                <g id="그룹_27156" data-name="그룹 27156" transform="translate(-125 240.343)">
                                    <path id="패스_8849" data-name="패스 8849"
                                        d="M8.741,140.46a23.409,23.409,0,1,1,31.254,0c6.048,9.438,10.864,22.181,7.781,36.916H.958C-2.123,162.641,2.694,149.9,8.741,140.46"
                                        transform="translate(-17245 -6100)" fill="#fb3" />
                                    <g id="그룹_27155" data-name="그룹 27155" transform="translate(-17211.523 -5964.757)">
                                        <path class="blue" id="합치기_3" data-name="합치기 3"
                                            d="M13107.235-1654.45v-12.713h-12.713v-16.709h12.713v-12.713h16.709v12.713h12.713v16.709h-12.713v12.713Z"
                                            transform="translate(-13094.523 1696.585)" fill="#e85b5b" stroke="rgba(0,0,0,0)"
                                            stroke-miterlimit="10" stroke-width="1" />
                                    </g>
                                </g>
                            </g>
                        </svg>
                        개인간병
                    </label>
                </div>
                <div>
                    <input type="radio" name="type" id="type2" <?php if($type==2) echo 'checked';?> value="2">
                    <label for="type2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
                            <g id="그룹_27160" data-name="그룹 27160" transform="translate(16943 5771)">
                                <rect id="사각형_24610" data-name="사각형 24610" width="100" height="100"
                                    transform="translate(-16943 -5771)" fill="none" />
                                <g id="그룹_27157" data-name="그룹 27157" transform="translate(205.76 338)">
                                    <path id="패스_8846" data-name="패스 8846"
                                        d="M108.625,34.47a19.774,19.774,0,1,1,26.4,0c5.108,7.973,9.177,18.739,6.573,31.187H102.051c-2.6-12.448,1.465-23.214,6.575-31.187"
                                        transform="translate(-17245 -6100)" fill="#717789" />
                                    <path id="패스_8847" data-name="패스 8847"
                                        d="M159.028,34.47a19.774,19.774,0,1,0-26.4,0c-5.108,7.973-9.177,18.739-6.573,31.187H165.6c2.6-12.448-1.465-23.214-6.575-31.187"
                                        transform="translate(-17219.348 -6100)" fill="#717789" />
                                    <path class="blue" id="패스_8848" data-name="패스 8848"
                                        d="M120.625,42a19.774,19.774,0,1,1,26.4,0c5.108,7.975,9.177,18.741,6.573,31.189H114.051c-2.6-12.448,1.465-23.214,6.575-31.189"
                                        transform="translate(-17232.174 -6091.951)" fill="#97d3f7" />
                                </g>
                            </g>
                        </svg>
                        공동간병
                    </label>
                </div>
            </div>
			<?php if($grade == 3) { ?>
			<a href="/app/page/form/pay-form1.php"><img src="/img/write.svg" style="width: 22px; margin-right: 5px;">새로운 구인글 등록하기</a>
			<select name="state">
				<option value="0" <?=$state == 0 ? "selected":""?>>전체</option>
				<option value="1" <?=$state == 1 ? "selected":""?>>공고 중</option>
				<option value="2" <?=$state == 2 ? "selected":""?>>모집완료</option>
				<option value="3" <?=$state == 3 ? "selected":""?>>취소</option>
				<option value="4" <?=$state == 4 ? "selected":""?>>종료</option>
			</select>
			<?php } ?>
            <?php if($grade == 2) { ?>
            <div style="margin-bottom: 20px;">
				<button onclick="openForm1();" type="button" class="popup_btn">지역선택</button>
				<?php
					foreach($areas as $area) {
						if(mb_strlen($area, 'utf-8') == 2) {	?>
						<p style="display: inline-block; vertical-align: middle;<?=$area != null? 'background:#72A4FF; line-height: 35px; border-radius: 35px; width: 60px; text-align: center; font-size: 18px; font-weight: 500; color: #fff;':''?>"><?=$area?></p>
				<?php	}} ?>
			</div>
            <div class="popup_form popup_form1">
                <div class="area_form">
                    <div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;">
                        <input type="checkbox" onclick="getCheckboxDel();" id="area0"><label for="area0">전국</label>
						<?php foreach($area_list as $d) { ?>
						<input type="checkbox" id="area<?=$d['minr']?>" value='<?=$d['name']?>,<?=$d['etc']?>' onclick='getCheckboxValue(event)' <?php if (in_array($d['name'],$areas)) echo 'checked="checked"'; ?> class="area_chk"><label for="area<?=$d['minr']?>"  ><?=$d['name']?></label>
						<?php } ?>
                    </div>
                    <div class="btn_box d-flex justify-content-between">
                        <button onclick="closeForm1();" type="button" style="width: 33%; background: #000; border-bottom-left-radius:15px;">닫기</button>
                        <button onclick="set_area();" type="button" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">설정하기</button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </form>
        <ul class="state_list">
			<?php if (!$list_data) {?>
					<div style="text-align: center;"><img src="/img/nodata.png" alt="" style="width:40%;margin-top: 45%;"></div>
			<?php } ?>
			<?php foreach($list_data as $d) {
					$date = date('Y-m-d H:m:s');
					$sdate = $d['hire_sdate']." ".$d['hire_stime'].":00:00";
					$edate = $d['hire_edate']." ".$d['hire_etime'].":59:59";
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
				
				?>
            <li>
                <a href="state-info.php?hire_no=<?=$d['hire_no']?>">
                    <?php if($grade == 2) { 
						$user_agency = $pdo->single( "SELECT agency_state FROM user_info WHERE user_no = ".$d['user_no'],$param);
						if($user_agency == 0) {
							$sql = "SELECT * FROM user_info WHERE user_no = ".$d['user_no'];
						} else {
							$sql = "SELECT *, b.association_nm as association_nm, a.responsibility as responsibility FROM user_info a
									LEFT OUTER JOIN user_info b ON a.association_nm = b.user_no WHERE a.user_no = ".$d['user_no'];
						}
						$user_info = $pdo->row($sql, $param); ?>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p><img src="/img/male.svg" style="width: 20px; margin-right: 5px;"><?=$user_info['association_nm']?>/<?=$user_info['responsibility']?></p>
                        <div style="text-align: right;">
                            <img src="/img/arrow.svg" alt="">
                        </div>
                    </div>
                    <p style="color:#3478F6; font-size: 1.1rem; font-weight: bold;"><img src="/img/clock.svg" style="width: 20px; margin-right: 5px;"><?="공고 ".$hours."시간 남음"?><img src="/img/view.svg" style="width: 20px; margin-right: 5px; margin-left: 20px;"><?="조회수 ".$d['hit']?></p>
                    <?php } ?>
                    <?php if($grade == 3) {?>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p><?=substr($d['reg_date'],0,10)?></p>
                        <div style="text-align: right;">
                            <?php if($grade == 3) {
								if(($d['state'] == 1 && $edate_time < $date) || ($d['state'] == 2 && $edate < $date)) { ?>
                            <span style="color:#8C8F97;">종료</span><img src="/img/arrow.svg" alt="">
							<?php } else if($d['state'] == 2 && $str_sdate <= $str_date && $str_edate >= $str_date) { ?>
                            <span style="color:#3478F6;">근무 중</span><img src="/img/arrow.svg" alt="">
							<?php } else { ?>
                            <span style="color:<?=$state_co[$d['state']]?>;"><?=$state_nm[$d['state']]?></span><img src="/img/arrow.svg" alt="">
							<?php }
								} else { 
								$sql = "SELECT state FROM hire_info WHERE hire_no = ".$d['hire_no'];
								$hire_state = $pdo->single($sql, $param);
								if ($hire_state == 2 && $d['state'] != 2) { ?>
							<span style="color:#FF4E34;">미채용</span><img src="/img/arrow.svg" alt="">
							<?php } else if(($d['state'] == 1 && $edate_time < $date) || ($d['state'] == 2 && $edate < $date)) { ?>
							<span style="color:#8C8F97;">종료</span><img src="/img/arrow.svg" alt="">
							<?php } else if($hire_state == 99) { ?>
							<span style="color:#8C8F97;">취소</span><img src="/img/arrow.svg" alt="">
							<?php } else { ?>
							<span style="color:<?=$state_co[$d['state']]?>;"><?=$state_nm[$d['state']]?></span><img src="/img/arrow.svg" alt="">
							<?php }
								}?>
                        </div>
                    </div>
                    <p style="color:#3478F6; font-size: 1.5rem; font-weight: bold;"><?=$d['state'] == 1 && $hours > 0 ? $hours."시간 남음":""?></p>
                    <p><?=$d['hire_type'] == 1 ? "개인":"공동"?>간병<?=$d['hire_type'] == 2 && $d['work_cnt'] > 0 ? "(".$d['work_cnt'].")":""?></p>
                    <?php } ?>
                    <table class="info_table">
                        <?php if($grade == 2) { ?>
                        <tr>
                            <th>분류</th>
                            <td><?=$d['hire_type'] == 1 ? "개인":"공동"?>간병<?=$d['hire_type'] == 2 && $d['work_cnt'] > 0 ? "(".$d['work_cnt'].")":""?></td>
                        </tr>
                        <tr>
                            <th>근무형태</th>
                            <td><?=$d['addr_type'] == 1 ? "병원":"재가"?>간병</td>
                        </tr>
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
                        <?php if($grade == 3) { 
								$sql = "SELECT user_name, a.pay_no as pay_no, a.user_no as user_no FROM pay_info a
										LEFT OUTER JOIN user_info b ON a.user_no = b.user_no
										WHERE a.state = 2 AND a.hire_no = ".$d['hire_no'];
								$user = $pdo->row($sql, $param);
								
								$sql = "SELECT count(*) FROM pay_info WHERE state = 1 AND hire_no = ".$d['hire_no'];
								$pay_cnt = $pdo->single($sql, $param);

								$hire_cnt = $pdo->single("SELECT count(*) FROM pay_info WHERE state = 2 AND hire_no = ".$d['hire_no'], $param);
						 ?>
                        <tr>
                            <th>간병사</th>
							<?php if($hire_cnt <= 1) { ?>
                            <td><?=$user == null ? "-":$user['user_name']." <a href='pay-info.php?pay_no=".$user['pay_no']."'>상세보기</a>"?></td>
							<?php } else{ ?>
                            <td><?=$user['user_name']." 외"." ".($hire_cnt - 1)."명"?></td> 
							<?php } ?>
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
                        <tr>
                            <th>간병비</th>
                            <td style="color:#3478F6; font-weight: bold;"><?=$d['pay_type'] == 4 ? "보호자와 협의":$pay_type[$d['pay_type']]." / ".number_format($d['pay'])."원"?></td>
                        </tr>
                    </table>
                </a>
                <?php if($grade == 2) {
						$sql = "SELECT * FROM pay_info WHERE state = 1 AND hire_no = ".$d['hire_no']." AND user_no = ".$_SESSION['user_no'];
						$data = $pdo->query($sql, $param);

						$sql = "SELECT * FROM hire_info a
								LEFT OUTER JOIN pay_info b ON a.hire_no = b.hire_no
								WHERE b.user_no = ".$_SESSION['user_no']." AND b.state = 2 AND a.hire_edate > '".$d['hire_sdate']."'";
						$data2 = $pdo->query($sql, $param);

						$agcy_state = $pdo->single("SELECT agency_state FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param); ?>
					<?php if(!$data)  { ?>
					
				<?php if($agcy_state == 1) { ?>
                <form action="json.php" method="post">
					<input type="hidden" name="mode" value="pay">
					<input type="hidden" name="type" value="2">
					<input type="hidden" name="hire_no" value="<?=$d['hire_no']?>">
					<input type="hidden" name="user_no" value="<?=$_SESSION['user_no']?>">
					<button class="star_link" type="button" onclick="<?=$agcy_state == 1 ? 'payForm':'openForm5'?>();" style="background: #000; border: none;">지원하기</button>
                </form>
					<?php } else { ?>
                <a href="/app/page/mypage/agency.php?type=3&agency_no=<?=$d['user_no']?>" class="star_link">지원하기</a>
					<?php }} ?>
                <?php } ?>
                <?php if($grade == 3) { ?>
                <form action="">
					<?php
						$sdate = $d['hire_sdate']." ".$d['hire_stime'].":00:00";
						$edate = $d['hire_edate']." ".$d['hire_etime'].":59:59";

						$str_date = strtotime($date);
						$str_sdate = strtotime($sdate);
						$str_edate = strtotime($edate);

						$pay_list = $pdo->query("SELECT *, a.user_no as user_no, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 2 AND b.state = 2
						AND '".$edate."' > DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') AND '".$sdate."'< DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':59:59'), '%Y-%m-%d %H:%i:%s')", $param);

						if($pay_list != null) {
							foreach($pay_list as $w) {
								${'cnt_where'.$d['hire_no']} .= " AND NOT('".$sdate."' <  '".$w['edate']."' AND '".$edate."' > '".$w['sdate']."')";
								${'user_no'.$d['hire_no']} .= " AND a.user_no != ".$w['user_no'];
								
							}
							//echo ${'cnt_where'.$d['hire_no']};
							//echo ${'user_no'.$d['hire_no']};
						}

						$pay_cnt = $pdo->single("SELECT count(*) FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.state = 1 AND a.hire_no = ".$d['hire_no'].${'user_no'.$d['hire_no']}, $param);
						$pay_yn = $pdo->row("SELECT * FROM pay_info WHERE hire_no = ".$d['hire_no']." AND state = 2",$param);

						$comment = $pdo->query("SELECT * FROM comment_info WHERE hire_no = ".$d['hire_no'], $param);
					?>
					<?php if($d['state'] == 1 && $pay_cnt > 0) { ?>
                    <button onclick="deleteForm2(<?=$d['hire_no']?>);" type="button" style="width: 39%;">모집취소</button>
					<?php } ?>
					<?php if($pay_yn) { ?>
					<?php if(($str_date >= $str_sdate && $str_date <= $str_edate) && $d['state'] != 10) { ?>
                    <button onclick="deleteForm2(<?=$d['hire_no']?>, 'work_fin');" type="button" style="width: 100%;">근무중단</button>
					<?php } else if($str_date < $str_sdate && $d['state'] == 2) { ?>
                    <button onclick="deleteForm2(<?=$d['hire_no']?>, 'state_can');" type="button" style="width: 100%;">확정취소</button>
					<?php } } ?>
					<?php if($d['state'] == 1 && $edate_time >= $date) { ?>
					<?php if($d['state'] == 1 && $edate_time >= $date && $pay_cnt == 0)  { ?>
                    <a href="/app/page/form/pay-form1.php?hire_no=<?=$d['hire_no']?>" style="width: <?=$d['state'] != 10 ? 19:49?>%; border: 1px solid #DEDEDE; color: #000;">수정</a>
					<?php } ?>
					<?php if($d['state'] != 2 && $pay_cnt == 0) { ?>
                    <button onclick="deleteForm1(<?=$d['hire_no']?>);" type="button" style="width: <?=$d['state'] == 99 || ($d['state'] == 1 && $edate_time < $date) ? 100:19?>%;">삭제</button>
					<?php } ?>
                    <a href="pay-list.php?hire_no=<?=$d['hire_no']?>" style="width: 59%; background: #3478F6;">지원현황 <span style="color:#FFEF56;"><?=$pay_cnt?></span></a>
					<?php } ?>
                </form>
                <?php } ?>
            </li>
			<?php } ?>
			<div class="popup_form popup_form2">
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
			<div class="popup_form popup_form4" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree2" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">지원하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 50%; background: #000000; border-bottom-left-radius:15px;">아니오</button>
						<button onclick="payOK();" type="button" style="width: 50%; background: #3478F6; border-bottom-right-radius:15px;">네</button>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form5" style="z-index:55; ">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 400px;">
						<div style="width: 100%;text-align: center;"><img style="width: 80px;" src="/img/warnning.svg"></div>
						<div id="agree3" style="width: 100%;text-align: center;margin-top: 15px;font-weight: bold;font-size: 22px; color: #3478F6;">소속 협회에 가입해주세요!</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px;">협회에 가입 시 견적참여, 구인지원 등 다양한</br>서비스를 이용할 수 있습니다</div>
						<div style="width: 100%;text-align: center;margin-top: 15px;font-weight: 500;font-size: 20px; color:#455572; background: #F1F3F6; padding: 15px;">협회가 가입되어 있지 않은 경우</br>APP 가입신청을 해야 합니다</div>
					</div>
					<div class="btn_box d-flex justify-content-between">
						<button onclick="closeForm1();" type="button" style="width: 33%; background: #000000; border-bottom-left-radius:15px;">닫기</button>
						<a href="share://나이팅게일 친구초대하기" style="width: 67%; background: #3478F6; border-bottom-right-radius:15px;">협회에 요청하기</a>
						
					</div>
				</div>
			</div>
			<div class="popup_form popup_form6">
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
            <!--<li>
                <a href="state-info.php">
                    <?php if($grade == 2) { ?>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p>서울간병인협회/이민혁</p>
                        <div style="text-align: right;">
                            <img src="/img/arrow.svg" alt="">
                        </div>
                    </div>
                    <p style="color:#3478F6; font-size: 1rem; font-weight: bold;">20시간 남음</p>
                    <?php } ?>
                    <?php if($grade == 3) {?>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p>2023-01-20</p>
                        <div style="text-align: right;">
                            <span style="color:#3478F6;">지원요청중</span><img src="/img/arrow.svg" alt="">
                        </div>
                    </div>
                    <p>개인간병</p>
                    <?php } ?>
                    <table class="info_table">
                        <?php if($grade == 2) { ?>
                        <tr>
                            <th>분류</th>
                            <td>개인간병</td>
                        </tr>
                        <tr>
                            <th>근무형태</th>
                            <td>병원간병</td>
                        </tr>
                        <tr>
                            <th>간병위치</th>
                            <td>서울 강남구 강남세브란스 병원 1601호</td>
                        </tr>
                        <?php } ?>
                        <?php if($grade == 3) { ?>
                        <tr>
                            <th>간병사</th>
                            <td>-</td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th>간병시간</th>
                            <td>12시간</td>
                        </tr>
                        <tr>
                            <th>간병비</th>
                            <td style="color:#3478F6; font-weight: bold;">일당 / <?=number_format(150000)?>원</td>
                        </tr>
                    </table>
                </a>
                <?php if($grade == 2) { ?>
                <button class="star_link">지원하기</button>
                <?php } ?>
                <?php if($grade == 3) { ?>
                <form action="">
                    <a href="pay-list.php" style="width: 59%; background: #3478F6;">견적현황 <span style="color:#FFEF56;">32</span></a>
                    <button style="width: 19%;">수정</button>
                    <button style="width: 19%;">삭제</button>
                </form>
                <?php } ?>
            </li>
            <li>
                <a href="state-info.php">
                    <?php if($grade == 2) { ?>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p>서울간병인협회/이민혁</p>
                        <div style="text-align: right;">
                            <img src="/img/arrow.svg" alt="">
                        </div>
                    </div>
                    <p style="color:#3478F6; font-size: 1rem; font-weight: bold;">20시간 남음</p>
                    <?php } ?>
                    <?php if($grade == 3) {?>
                    <div class="d-flex justify-content-between align-items-center date_state">
                        <p>2023-01-20</p>
                        <div style="text-align: right;">
                            <span style="color:#3478F6;">지원요청중</span><img src="/img/arrow.svg" alt="">
                        </div>
                    </div>
                    <p>공동간병</p>
                    <?php } ?>
                    <table class="info_table">
                        <?php if($grade == 2) { ?>
                        <tr>
                            <th>분류</th>
                            <td>개인간병</td>
                        </tr>
                        <tr>
                            <th>근무형태</th>
                            <td>병원간병</td>
                        </tr>
                        <tr>
                            <th>간병위치</th>
                            <td>서울 강남구 강남세브란스 병원 1601호</td>
                        </tr>
                        <?php } ?>
                        <?php if($grade == 3) { ?>
                        <tr>
                            <th>간병사</th>
                            <td>-</td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <th>간병시간</th>
                            <td>12시간</td>
                        </tr>
                        <tr>
                            <th>간병비</th>
                            <td style="color:#3478F6; font-weight: bold;">일당 / <?=number_format(150000)?>원</td>
                        </tr>
                    </table>
                </a>
                <?php if($grade == 2) { ?>
                <button class="star_link">지원하기</button>
                <?php } ?>
                <?php if($grade == 3) { ?>
                <form action="">
                    <a href="pay-list.php" style="width: 59%; background: #3478F6;">견적현황 <span style="color:#FFEF56;">32</span></a>
                    <button style="width: 19%;">수정</button>
                    <button style="width: 19%;">삭제</button>
                </form>
                <?php } ?>
            </li>-->
        </ul>
    </div>
</div>
<script type="text/javascript">
function closeForm1() {
	$('.popup_form').css('display', 'none');
}

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

			document.getElementById('agree').innerHTML = '견적이용권이 없습니다.';
			$('.popup_form3').css('display', 'block');
			$('.popup_form4').css('display', 'none');
			return; 

		} else {
			$.ajax({type: 'POST',
				url: 'json.php',
				data:"&mode=pay&hire_no="+hire_no+"&user_no="+user_no+"&pay="+pay+"&type=2&membership="+membership+"&ticket="+ticket,
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
							document.getElementById('agree').innerHTML = '모집 완료된 구인 요청입니다.';
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



function deleteForm1(hire_no1) {
	hire_no = hire_no1;
	$('.popup_form2').css('display', 'block');
}
function deleteForm2(hire_no1, mode1) {
	hire_no = hire_no1;
	mode    = mode1;
	$('.popup_form6').css('display', 'block');
}
function payForm() {
	$('.popup_form4').css('display', 'block');
}
</script>
<?php
$menu = "hire";
include('../../lib/menu.php');
include('../../lib/footer.php');
?>
<script>
	let area = '';
	var arrValues = new Array(); 
	arrValues = <?php echo json_encode($areas)?>; 
    function openForm1() {
        $('.popup_form1').css('display', 'block');
    }
	//지역선택시 저장
	function getCheckboxValue(event)  {
		
		if(event.target.checked)  {
			arrValues.push(event.target.value);
		}else {
			for(let i=0; i<arrValues.length; i++){
				var areadata = event.target.value.split(',');
				for(let j=0; j<areadata.length; j++){
					if(arrValues[i]==areadata[j]){
						arrValues = arrValues.filter((element) => element !== areadata[j]);
					}
				}
			}
		}
	}
	//설정하기 시 쿠키 저장

	function getCheckboxDel() {
		$('.area_chk').prop('checked', false);
		arrValues = [];
	}
	$('.area_chk').click(function(){
		if($('.area_chk').is(':checked')) {
			$('#area0').prop('checked', false);
		}
	});

	function set_area(){
		setCookie("area", arrValues, 86400);//하루동안저장
		$('.popup_form1').css('display', 'none');
		//새로고침 하면서 검색에 사용할것
		//location.reload();
		document.selType.submit();  
	}

	//전체 개인 공동 선택
	$("input[name='type']:radio").change(function () {
		//라디오 버튼 값을 가져온다.
		document.selType.submit();       
	});

	//상태값 선택
	$("select[name='state']").change(function () {
		//라디오 버튼 값을 가져온다.
		document.selType.submit();       
	});

    function openForm5() {
        $('.popup_form5').css('display', 'block');
    }
	function closeForm1() {
        $('.popup_form1').css('display', 'none');
        $('.popup_form2').css('display', 'none');
        $('.popup_form4').css('display', 'none');
        $('.popup_form5').css('display', 'none');
        $('.popup_form6').css('display', 'none');
    }
</script>