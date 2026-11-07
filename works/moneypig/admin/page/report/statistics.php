<?php
include('../../lib/header.php');
include('../../../common.php');
include('../../lib/menu.php');

if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}


$smonth1 = $_POST['smonth1'] == null ? "":$_POST['smonth1'];
$emonth1 = $_POST['emonth1'] == null ? "":$_POST['emonth1'];
$smonth2 = $_POST['smonth2'] == null ? "":$_POST['smonth2'];
$emonth2 = $_POST['emonth2'] == null ? "":$_POST['emonth2'];
$smonth3 = $_POST['smonth3'] == null ? "":$_POST['smonth3'];
$emonth3 = $_POST['emonth3'] == null ? "":$_POST['emonth3'];


$param = null;
$where1 = '';
$where2_1 = '';
$where2_2 = '';
$where3 = '';
$where4 = '';

if($smonth1 > 0 && $emonth1 == null) {
	$where1 = " WHERE DATE_FORMAT(reg_date, '%Y-%m') >= '".$smonth1."'";
} else if($smonth1 > 0 && $emonth1 > 0) {
	$where1 = " WHERE DATE_FORMAT(reg_date, '%Y-%m') BETWEEN '".$smonth1."' AND '".$emonth1."'";
} else if($smonth1 == null && $emonth1 > 0) {
	$where1 = " WHERE DATE_FORMAT(reg_date, '%Y-%m') <= '".$emonth1."'";
}

if($smonth2 > 0 && $emonth2 == null) {
	$where2_1 = " AND DATE_FORMAT(bizdate, '%Y-%m') >= '".$smonth2."'";
	$where2_2 = " AND DATE_FORMAT(up_reg_date, '%Y-%m') >= '".$smonth2."'";
} else if($smonth2 > 0 && $emonth2 > 0) {
	$where2_1 = " AND DATE_FORMAT(bizdate, '%Y-%m') BETWEEN '".$smonth2."' AND '".$emonth2."'";
	$where2_2 = " AND DATE_FORMAT(up_reg_date, '%Y-%m') BETWEEN '".$smonth2."' AND '".$emonth2."'";
} else if($smonth2 == null && $emonth2 > 0) {
	$where2_1 = " AND DATE_FORMAT(bizdate, '%Y-%m') <= '".$emonth2."'";
	$where2_2 = " AND DATE_FORMAT(up_reg_date, '%Y-%m') <= '".$emonth2."'";
}

if($smonth3 > 0 && $emonth3 == null) {
	$where3 = " WHERE DATE_FORMAT(reg_date, '%Y-%m') >= '".$smonth3."'";
} else if($smonth3 > 0 && $emonth3 > 0) {
	$where3 = " WHERE DATE_FORMAT(reg_date, '%Y-%m') BETWEEN '".$smonth3."' AND '".$emonth3."'";
} else if($smonth3 == null && $emonth3 > 0) {
	$where3 = " WHERE DATE_FORMAT(reg_date, '%Y-%m') <= '".$emonth3."'";
}


$member_cnt_m = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_sex = 1", $param);
$member_cnt_w = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_sex = 2", $param);

$member_cnt_10 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_old IN (1,10)", $param);
$member_cnt_20 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_old IN (2,20)", $param);
$member_cnt_30 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_old IN (3,30)", $param);
$member_cnt_40 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_old IN (4,40)", $param);
$member_cnt_50 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_old IN (5,50)", $param);
$member_cnt_60 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_old IN (6,60)", $param);

$member_cnt = $pdo->single("SELECT count(*) FROM member_info", $param);
$member1_cnt = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1", $param);
$member0_cnt = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 0", $param);

$cntr_cnt = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 1", $param);
$agcy_cnt = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 2", $param);
$sell_cnt = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 3", $param);
$mngr_cnt = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 4", $param);
$ceo_cnt = $pdo->single("SELECT count(*) FROM ceo_info WHERE ceo_state = 1", $param);

$sql = "SELECT DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, count(CASE WHEN req_state = 0 THEN 1 END) as cnt1, count(CASE WHEN req_state = 9 THEN 1 END) as cnt2, count(CASE WHEN req_state = 1 THEN 1 END) as cnt3 FROM cash_req".$where1." GROUP BY DATE_FORMAT(reg_date, '%Y-%m') ORDER BY reg_date DESC";
$cash_cnt = $pdo->query($sql, $param);

$sql = "SELECT a.reg_date as reg_date,
		sum(CASE WHEN a.name = 'type1' THEN a.cnt ELSE 0 END) AS cnt1,
		sum(CASE WHEN a.name = 'type2' THEN a.cnt ELSE 0 END) AS cnt2,
		sum(CASE WHEN a.name = 'type3' THEN a.cnt ELSE 0 END) AS cnt3
		FROM
		(SELECT DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, count(CASE WHEN campaign_state != 0 THEN 1 END) as cnt, 'type1' as name FROM campaign_info GROUP BY reg_date
		UNION ALL
		SELECT DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, count(CASE WHEN campaign_state = 9 THEN 1 END) as cnt, 'type2' as name FROM campaign_info GROUP BY reg_date
		UNION ALL
		SELECT DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, count(CASE WHEN campaign_state = 1 AND end_date <= DATE_FORMAT(NOW(), '%Y-%m-%d') THEN 1 END) as cnt, 'type3' as name FROM campaign_info GROUP BY reg_date)  AS a
		WHERE a.reg_date ".$where4." GROUP BY a.reg_date ORDER BY a.reg_date DESC ";
$campaign_cnt = $pdo->query($sql, $param);

$sql = "SELECT ORN_DT.reg_date as reg_date,
		SUM(CASE WHEN ORN_DT.name = 'sum1' THEN ORN_DT.sum ELSE 0 END) AS sum1,
		SUM(CASE WHEN ORN_DT.name = 'sum2' THEN ORN_DT.sum ELSE 0 END) AS sum2,
		SUM(CASE WHEN ORN_DT.name = 'sum3' THEN ORN_DT.sum ELSE 0 END) AS sum3
		FROM
		(SELECT sum(amt) as sum, DATE_FORMAT(bizdate, '%Y년 %m월') as reg_date, 'sum1' as name FROM dchagmt WHERE msgtype = 1300".$where2_1." GROUP BY reg_date
		UNION ALL
		SELECT sum(cash_amt) as sum, DATE_FORMAT(up_reg_date, '%Y년 %m월') as reg_date, 'sum2' as name FROM cash_req WHERE req_state = 1".$where2_2." GROUP BY reg_date
		UNION ALL
		SELECT sum(amt) as sum, DATE_FORMAT(up_reg_date, '%Y년 %m월') as reg_date, 'sum3' as name FROM user_cash_out WHERE out_state = 1".$where2_2." GROUP BY reg_date) AS ORN_DT
		GROUP BY ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC ";
$amt_cnt = $pdo->query($sql, $param);

$sql = "SELECT DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, count(DISTINCT store_no) as cnt, SUM(ad_user_cnt) as sum FROM ad_info".$where3." GROUP BY DATE_FORMAT(reg_date, '%Y-%m') ORDER BY reg_date DESC";
$ad_cnt = $pdo->query($sql, $param);

//$list_data = $pdo->query($sql, $param);

?>
<style>
	body::after {
		display:none;
	}

	.search-form {
		margin-bottom: 10px;
	}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
			<div class="card">
				<div class="card-header pb-0">
					<p>통계</p>
				</div>
			</div>
			<form action="statistics.php" id='SearchForm' method="POST">
				<div class="row">
					<div class="col-xl-12">
						<div class="row">
							<div class="col-xl-2">
								<div class="card card-h-100">
									<div class="card-header">
										성별통계
									</div>
									<div class="card-body">
										<div class="count">
											<p>남성</p>
											<span><?=number_format($member_cnt_m)?></span>
										</div>
										<div class="count">
											<p>여성</p>
											<span><?=number_format($member_cnt_w)?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-2">
								<div class="card card-h-100">
									<div class="card-header">
										회원통계
									</div>
									<div class="card-body">
										<div class="count">
											<p>가입</p>
											<span><?=number_format($member_cnt)?></span>
										</div>
										<div class="count">
											<p>탈퇴</p>
											<span><?=number_format($member0_cnt)?></span>
										</div>
										<div class="count">
											<p>이용자</p>
											<span><?=number_format($member1_cnt)?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4">
								<div class="card card-h-100">
									<div class="card-header">
										영업자통계
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-xl-6">
												<div class="count">
													<p>총판</p>
													<span><?=number_format($cntr_cnt)?></span>
												</div>
												<div class="count">
													<p>센터</p>
													<span><?=number_format($agcy_cnt)?></span>
												</div>
												<div class="count">
													<p>대리점</p>
													<span><?=number_format($sell_cnt)?></span>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="count">
													<p>매니저</p>
													<span><?=number_format($mngr_cnt)?></span>
												</div>
												<div class="count">
													<p>사장님</p>
													<span><?=number_format($ceo_cnt)?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-4">
								<div class="card card-h-100">
									<div class="card-header">
										연령별통계
									</div>
									<div class="card-body">
										<div class="row">
											<div class="col-xl-6">
												<div class="count">
													<p>10대</p>
													<span><?=number_format($member_cnt_10)?></span>
												</div>
												<div class="count">
													<p>20대</p>
													<span><?=number_format($member_cnt_20)?></span>
												</div>
												<div class="count">
													<p>30대</p>
													<span><?=number_format($member_cnt_30)?></span>
												</div>
											</div>
											<div class="col-xl-6">
												<div class="count">
													<p>40대</p>
													<span><?=number_format($member_cnt_40)?></span>
												</div>
												<div class="count">
													<p>50대</p>
													<span><?=number_format($member_cnt_50)?></span>
												</div>
												<div class="count">
													<p>60대 이상</p>
													<span><?=number_format($member_cnt_60)?></span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6">
								<div class="card card-h-100">
									<div class="card-header">
										적립요청통계
									</div>
									<div class="card-body">
										<div class="search-form"> 
											<input type="month" name="smonth1" value="<?=$smonth1?>" onchange="Search_Page(1);">
											<input type="month" name="emonth1" value="<?=$emonth1?>" onchange="Search_Page(1);">
										</div>
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th style="width: 25%;">기간</th>
														<th style="width: 25%;">적립요청</th>
														<th style="width: 25%;">적립취소</th>
														<th style="width: 25%;">적립완료</th>
													</tr>
												</thead>
												<tbody>
													<?php if($cash_cnt == null) {?>
													<tr>
														<td colspan="4">조회된 정보가 없습니다.</td>
													</tr>
													<?php } else { 
														foreach($cash_cnt as $d) { ?>
													<tr>
														<td><?=$d['reg_date']?></td>
														<td><?=number_format($d['cnt1'])?></td>
														<td><?=number_format($d['cnt2'])?></td>
														<td><?=number_format($d['cnt3'])?></td>
													</tr>
													<?php }
														} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="card card-h-100">
									<div class="card-header">
										체험단통계
									</div>
									<div class="card-body">
										<div class="search-form"> 
											<input type="month" name="smonth1" value="<?=$smonth4?>" onchange="Search_Page(1);">
											<input type="month" name="emonth1" value="<?=$emonth4?>" onchange="Search_Page(1);">
										</div>
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th style="width: 25%;">기간</th>
														<th style="width: 25%;">체험단모집</th>
														<th style="width: 25%;">체험단취소</th>
														<th style="width: 25%;">체험단완료</th>
													</tr>
												</thead>
												<tbody>
													<?php if($campaign_cnt == null) {?>
													<tr>
														<td colspan="4">조회된 정보가 없습니다.</td>
													</tr>
													<?php } else { 
														foreach($campaign_cnt as $d) { ?>
													<tr>
														<td><?=$d['reg_date']?></td>
														<td><?=number_format($d['cnt1'])?></td>
														<td><?=number_format($d['cnt2'])?></td>
														<td><?=number_format($d['cnt3'])?></td>
													</tr>
													<?php }
														} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-6">
								<div class="card card-h-100">
									<div class="card-header">
										충전금통계
									</div>
									<div class="card-body">
										<div class="search-form"> 
											<input type="month" name="smonth2" value="<?=$smonth2?>" onchange="Search_Page(1);">
											<input type="month" name="emonth2" value="<?=$emonth2?>" onchange="Search_Page(1);">
										</div>
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th style="width: 25%;">기간</th>
														<th style="width: 25%;">충전금</th>
														<th style="width: 25%;">적립</th>
														<th style="width: 25%;">출금</th>
													</tr>
												</thead>
												<tbody>
													<?php if($amt_cnt == null) {?>
													<tr>
														<td colspan="4">조회된 정보가 없습니다.</td>
													</tr>
													<?php } else { 
														foreach($amt_cnt as $d) { ?>
													<tr>
														<td><?=$d['reg_date']?></td>
														<td><?=number_format($d['sum1'])?></td>
														<td><?=number_format($d['sum2'])?></td>
														<td><?=number_format($d['sum3'])?></td>
													</tr>
													<?php }
														} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="card card-h-100">
									<div class="card-header">
										동네광고통계
									</div>
									<div class="card-body">
										<div class="search-form"> 
											<input type="month" name="smonth3" value="<?=$smonth3?>" onchange="Search_Page(1);">
											<input type="month" name="emonth3" value="<?=$emonth3?>" onchange="Search_Page(1);">
										</div>
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th style="width: 33%;">기간</th>
														<th style="width: 33%;">발송업체</th>
														<th style="width: 33%;">수신인원</th>
													</tr>
												</thead>
												<tbody>
												<?php if($ad_cnt == null) { ?>
													<tr>
														<td colspan="3">조회된 정보가 없습니다.</td>
													</tr>
												<?php } else {
													foreach($ad_cnt as $d) { ?>
													<tr>
														<td><?=$d['reg_date']?></td>
														<td><?=number_format($d['cnt'])?></td>
														<td><?=number_format($d['sum'])?></td>
													</tr>
												<?php }
													} ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
        </div>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>
<script>
function Search_Page(n)
{
	if(n == "#") return;
	//$("#ContetCurrentPage").val(n);
	$("#SearchForm").submit();//GetRow_item();
}

</script>