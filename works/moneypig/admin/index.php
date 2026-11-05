<?php
include('../common.php');
include('lib/header.php');
include('lib/menu.php');


if($lv == 1) {
    echo "<meta http-equiv='refresh' content='0;url=/portfolio/works/moneypig/admin/cntr.php'>";
    exit;
}
if($lv == 2) {
    echo "<meta http-equiv='refresh' content='0;url=/portfolio/works/moneypig/admin/agcy.php'>";
    exit;
}
if($lv == 3) {
    echo "<meta http-equiv='refresh' content='0;url=/portfolio/works/moneypig/admin/sell.php'>";
    exit;
}
if($lv == 4) {
    echo "<meta http-equiv='refresh' content='0;url=/portfolio/works/moneypig/admin/mngr.php'>";
    exit;
}

$param = null;

$sql = "SELECT *, b.store_name as store_name, c.member_name as member_name, d.name as platform, e.platform_id as platform_id, a.reg_date as reg_date FROM cash_req a
		LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
		LEFT OUTER JOIN member_info c ON a.member_no = c.member_no
		LEFT OUTER JOIN code_info d ON a.platform_no = d.minr AND d.majr = 3
		LEFT OUTER JOIN member_platform e ON a.member_no = e.member_no AND a.platform_no = e.platform_no WHERE a.req_state = 1 ORDER BY a.reg_date DESC LIMIT 6";
$cash_list = $pdo->query($sql, $param);
$cash_cnt = $pdo->query("SELECT count(*)FROM cash_req WHERE req_state = 1")->fetchColumn();
$state_nm = array(0=>"적립요청", 1=>"적립완료", 9=>"적립취소");



$member_cnt = $pdo->query("SELECT count(*) FROM member_info WHERE member_state = 1")->fetchColumn();

$cntr_cnt = $pdo->query("SELECT count(*)FROM agency_info WHERE agency_state = 1 AND grade = 1")->fetchColumn();
$agcy_cnt = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 2")->fetchColumn();
$sell_cnt = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 3")->fetchColumn();
$mngr_cnt = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 4")->fetchColumn();
$ceo_cnt = $pdo->query("SELECT count(*) FROM ceo_info WHERE ceo_state = 1")->fetchColumn();
// $ceo_cnt = $pdo->single("SELECT count(*) FROM ceo_info WHERE ceo_state = 1", $param);

// $cupon_cnt = $pdo->single("SELECT count(*) FROM cupon_info", $param);
// $down_cnt = $pdo->single("SELECT count(*) FROM cupon_down_info", $param);

// $req_cnt = $pdo->single("SELECT count(*) FROM banner_req WHERE state = 0", $param);
// $req_cnt2 = $pdo->single("SELECT count(*) FROM banner_req WHERE state = 1 AND DATE_FORMAT(NOW(), '%Y-%m-%d') between s_date AND e_date", $param);
// 
// $amt_sum = $pdo->single("SELECT sum(amt) FROM dchagmt WHERE msgtype = 1300 AND DATE_FORMAT(bizdate, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $cash_sum = $pdo->single("SELECT sum(cash_amt) FROM cash_req WHERE req_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $cash_sum = $pdo->single("SELECT ifnull(sum(amt),0) FROM campaign_pay_touser WHERE pay_state = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $out_sum = $pdo->single("SELECT sum(amt) FROM user_cash_out WHERE out_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// 
// $money_today1 = $pdo->single("SELECT count(*) FROM cash_req WHERE req_type = 1 AND req_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')", $param);
// $money_month1 = $pdo->single("SELECT count(*) FROM cash_req WHERE req_type = 1 AND req_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $money_today4 = $pdo->single("SELECT count(*) FROM cash_req WHERE req_type = 2 AND req_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')", $param);
// $money_month4 = $pdo->single("SELECT count(*) FROM cash_req WHERE req_type = 2 AND req_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $money_today2 = $pdo->single("SELECT count(*) FROM dchagmt WHERE msgtype = 1300 AND DATE_FORMAT(bizdate, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')", $param);
// $money_month2 = $pdo->single("SELECT count(*) FROM dchagmt WHERE msgtype = 1300 AND DATE_FORMAT(bizdate, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $money_today3 = $pdo->single("SELECT count(*) FROM user_cash_out WHERE out_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')", $param);
// $money_month3 = $pdo->single("SELECT count(*) FROM user_cash_out WHERE out_state = 1 AND DATE_FORMAT(up_reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// 
// $money_today_1 = $pdo->single("SELECT SUM(amt) FROM store_campaign_pay WHERE pay_state = 2 AND distributor_no = 1 AND DATE_FORMAT(reg_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')", $param);
// $money_month_1 = $pdo->single("SELECT SUM(amt) FROM store_campaign_pay WHERE pay_state = 2 AND distributor_no = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $money_today_2 = $pdo->single("SELECT sum(CASE WHEN distributor_no = 1 THEN toss_amt END) FROM store_expense_pay WHERE pay_state = 1 AND DATE_FORMAT(reg_date, '%Y-%m-%d') = DATE_FORMAT(NOW(), '%Y-%m-%d')", $param);
// $money_month_2 = $pdo->single("SELECT sum(CASE WHEN distributor_no = 1 THEN toss_amt END) FROM store_expense_pay WHERE pay_state = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $money_today = $money_today_1 + $money_today_2;
// $money_month = $money_month_1 + $money_month_2;
// 
// $calc_month_1 = $pdo->single("SELECT sum(CASE WHEN distributor_no = 1 THEN benefit_amt END) FROM store_expense_pay WHERE pay_state = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $calc_month_2 = $pdo->single("SELECT sum(CASE WHEN distributor_no = 1 THEN amt END) FROM store_campaign_pay WHERE pay_state = 2 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $calc_month_3 = $pdo->single("SELECT sum(CASE WHEN distributor_no != 1 THEN amt END) FROM store_campaign_pay WHERE pay_state = 2 AND agency_no IS NULL AND seller_no IS NULL AND seller_no IS NULL AND manager_no IS NULL AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $calc_month = $calc_month_3;
// $calc_month = $calc_month_1 + $calc_month_2 - $calc_month_3;
// $calc_prev_1 = $pdo->single("SELECT sum(CASE WHEN distributor_no = 1 THEN benefit_amt END) FROM store_expense_pay WHERE pay_state = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW() - interval 1 month, '%Y-%m')", $param);
// $calc_prev_2 = $pdo->single("SELECT sum(CASE WHEN distributor_no = 1 THEN amt END) FROM store_campaign_pay WHERE pay_state = 2 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW() - interval 1 month, '%Y-%m')", $param);
// $calc_prev_3 = $pdo->single("SELECT sum(CASE WHEN distributor_no != 1 THEN amt END) FROM store_campaign_pay WHERE pay_state = 2 AND agency_no IS NULL AND seller_no IS NULL AND seller_no IS NULL AND manager_no IS NULL AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW() - interval 1 month, '%Y-%m')", $param);
// $calc_prev = $calc_prev_3;
// $calc_prev = $calc_prev_1 + $calc_prev_2 - $calc_prev_3;
// $cash1_cnt = $pdo->single("SELECT count(*) FROM store_cash_log WHERE pay_state = 1 AND pay_tp = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $cash2_cnt = $pdo->single("SELECT count(*) FROM cash_req WHERE req_state = 1 AND DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m')", $param);
// $cash3_cnt = $cash1_cnt + $cash2_cnt;
// 
// $campaign1_cnt = $pdo->single("SELECT count(*) FROM campaign_info WHERE DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND campaign_state != 0", $param);
// $campaign2_cnt = $pdo->single("SELECT count(*) FROM campaign_info WHERE DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND campaign_state = 9", $param);
// $campaign3_cnt = $pdo->single("SELECT count(*) FROM campaign_info WHERE DATE_FORMAT(reg_date, '%Y-%m') = DATE_FORMAT(NOW(), '%Y-%m') AND end_date <= DATE_FORMAT(NOW(), '%Y-%m-%d') AND campaign_state = 1", $param);
// 
// $ad_cnt = $pdo->single("SELECT count(*) FROM ad_info WHERE ad_state = 1", $param);
// $sql = "SELECT *, b.store_name as name, c.ceo_name as ceo_name, a.reg_date as reg_date FROM ad_info a
		// LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
		// LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no WHERE ad_state = 1 ORDER BY a.reg_date DESC LIMIT 8";
// $ad_list = $pdo->query($sql, $param);
// 
// $amt_cnt = $pdo->single("SELECT count(*) FROM dchagmt WHERE msgtype = 1300", $param);
// $sql = "SELECT *, c.agency_nm as agcy_nm, d.agency_nm as cntr_nm, DATE_FORMAT(a.bizdate, '%Y-%m-%d') as bizdate FROM dchagmt a
		//  LEFT OUTER JOIN ceo_info b ON a.cybercode = b.cybercode
		//  LEFT OUTER JOIN agency_info c ON b.mng_code = c.agency_code
		//  LEFT OUTER JOIN agency_info d ON c.distributor_no = d.agency_no
		//  WHERE a.msgtype = 1300 ORDER BY a.seq DESC LIMIT 8";
// $amt_list = $pdo->query($sql, $param);
?>
<style>
.table > :not(caption) > * > * {
	padding: 0.805rem 0.75rem;
}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid index">
			<div class="row">
				<div class="card mb-0">
					<div class="card-header pt-0">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27747" data-name="그룹 27747" transform="translate(6789 333)">
							<rect id="사각형_24535" data-name="사각형 24535" width="20" height="20" transform="translate(-6789 -333)" fill="none"/>
							<path id="빼기_2" data-name="빼기 2" d="M8,15A7.771,7.771,0,0,1,0,7.5,7.771,7.771,0,0,1,8,0a7.771,7.771,0,0,1,8,7.5A7.771,7.771,0,0,1,8,15ZM8.844,4.033a3.793,3.793,0,0,0-2.552.948,3.152,3.152,0,0,0,0,4.733,3.93,3.93,0,0,0,4.23.575L9.939,9.058a2.411,2.411,0,0,1-1.086.235A2.451,2.451,0,0,1,7.207,8.7a1.674,1.674,0,0,1-.624-1.353,1.674,1.674,0,0,1,.624-1.354,2.554,2.554,0,0,1,2.731-.356l.583-1.232A3.815,3.815,0,0,0,8.844,4.033Z" transform="translate(-6787 -331)"/>
						  </g>
						</svg>
						<p>실시간 적립요청</p>
					</div>
				</div>
				<div class="col-xl-12 ">
					<div class="row ">
						<?php if($cash_cnt == 0) { ?>
						<div class="col-xl-12 ">
							<div class="card card-h-100">
								<div class="card-body cash-list">
									조회된 정보가 없습니다.
								</div>
							</div>
						</div>
						<?php } else { 
							foreach($cash_list as $d) {
								$img = $pdo->query("SELECT img_url FROM store_img WHERE store_no = ".$d['store_no'])->fetchColumn(); ?>
										<div class="col-xl-2 ">
											<div class="card card-h-100">
												<div class="card-body cash-list">
													<a href="page/cash/cash-info.php?req_no=<?=$d['req_no']?>">
														<div class="d-flex justify-content-between">
															<div style="background: url('<?=$img == null ? "/portfolio/works/moneypig/img/store_img.svg":"/portfolio/works/moneypig/img/store/".$img?>'); background-size: cover; background-position:center;"></div>
															<img src="/portfolio/works/moneypig/admin/img/arrow.svg">
														</div>
														<p><?=$d['store_name']?></p>
														<table>
															<tr>
																<th>플랫폼</th>
																<td><?=$d['platform']?></td>
															</tr>
															<tr>
																<th>신청자</th>
																<td><?=$d['member_name']?></td>
															</tr>
															<tr>
																<th>신청일</th>
																<td><?=substr($d['reg_date'],0,10)?></td>
															</tr>
															<tr>
																<th>상태</th>
																<td><?=$state_nm[$d['req_state']]?></td>
															</tr>
														</table>
													</a>
												</div>
											</div>
										</div>
						<?php }
							} ?>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-12">
					<div class="row">
						<div class="col-xl-6">
							<div class="row">
								<div class="col-xl-6">
									<div class="row">
										<div class="col-xl-12">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27038" data-name="그룹 27038" transform="translate(-5691 5920)">
														<rect id="사각형_24531" data-name="사각형 24531" width="20" height="20" transform="translate(5691 -5920)" fill="none"/>
														<g id="그룹_27032" data-name="그룹 27032" transform="translate(-2.35 -2.532)">
														  <path id="패스_8481" data-name="패스 8481" d="M605.151,329.426A3.425,3.425,0,1,1,601.727,326,3.421,3.421,0,0,1,605.151,329.426Z" transform="translate(5101.958 -6241.465)"/>
														  <path id="패스_8482" data-name="패스 8482" d="M610.95,340.366c-.313-3.846-3.92-6.887-8.334-6.887s-8.019,3.041-8.335,6.887Z" transform="translate(5101.068 -6239.81)"/>
														</g>
													  </g>
													</svg>
													<p>회원통계</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>이용자</p>
														<span><a href="page/user/user-list.php"><?=number_format($member_cnt)?>명</a></span>
													</div>
													<div class="count">
														<p>사장님</p>
														<span><a href="page/user/shop-list.php"><?=number_format($ceo_cnt)?>명</a></span>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xl-12">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 20 20">
													  <defs>
														<clipPath id="clip-path">
														  <rect id="사각형_24174" data-name="사각형 24174" width="13.561" height="17.225" transform="translate(0 0)" fill="none"/>
														</clipPath>
													  </defs>
													  <g id="그룹_28254" data-name="그룹 28254" transform="translate(3278 -1200)">
														<rect id="사각형_24081" data-name="사각형 24081" width="20" height="20" transform="translate(-3278 1200)" fill="none"/>
														<g id="그룹_22555" data-name="그룹 22555" transform="translate(-3274.78 1201.279)">
														  <g id="그룹_22554" data-name="그룹 22554" transform="translate(0 0)" clip-path="url(#clip-path)">
															<path id="패스_8219" data-name="패스 8219" d="M12.753,70.588H.807a.807.807,0,0,0,0,1.614H12.753a.807.807,0,1,0,0-1.614" transform="translate(0 -54.977)"/>
															<path id="패스_8220" data-name="패스 8220" d="M29.406,2.6a.355.355,0,0,0,.355-.355V.355a.355.355,0,1,0-.711,0v1.89a.355.355,0,0,0,.355.355" transform="translate(-22.626 0)"/>
															<path id="패스_8221" data-name="패스 8221" d="M8.214,7.717a.355.355,0,0,0,.542-.46L7.5,5.783a.355.355,0,1,0-.542.46Z" transform="translate(-5.357 -4.407)"/>
															<path id="패스_8222" data-name="패스 8222" d="M45.921,7.842a.355.355,0,0,0,.271-.125l1.251-1.473a.356.356,0,0,0-.542-.46L45.65,7.256a.356.356,0,0,0,.271.586" transform="translate(-35.488 -4.407)"/>
															<path id="패스_8223" data-name="패스 8223" d="M12.465,17.666h0A5.166,5.166,0,0,0,7.3,22.832v5.893H17.631V22.832a5.166,5.166,0,0,0-5.166-5.166" transform="translate(-5.685 -13.759)"/>
														  </g>
														</g>
													  </g>
															</svg>
													<p>신고현황</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>신규신고</p>
														<span><a href="page/report/singo-list.php"><?=number_format($singo_cnt)?>건</a></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6">
									<div class="card card-h-100">
										<div class="card-header">
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
											  <g id="그룹_27039" data-name="그룹 27039" transform="translate(-5691 5891)">
												<rect id="사각형_24532" data-name="사각형 24532" width="20" height="20" transform="translate(5691 -5891)" fill="none"/>
												<g id="그룹_27036" data-name="그룹 27036" transform="translate(-0.403 0.343)">
												  <g id="그룹_27033" data-name="그룹 27033" transform="translate(5696.437 -5884.757)">
													<path id="패스_8475" data-name="패스 8475" d="M583.6,304.416a2.043,2.043,0,1,1-2.041-2.043A2.041,2.041,0,0,1,583.6,304.416Z" transform="translate(-576.592 -302.373)"/>
													<path id="패스_8476" data-name="패스 8476" d="M586.644,311.7a5.058,5.058,0,0,0-9.934,0Z" transform="translate(-576.71 -302.154)"/>
												  </g>
												  <g id="그룹_27035" data-name="그룹 27035" transform="translate(5691.403 -5886.342)">
													<path id="패스_8477" data-name="패스 8477" d="M578.772,302.892a2.043,2.043,0,1,1-2.043-2.04A2.045,2.045,0,0,1,578.772,302.892Z" transform="translate(-571.761 -300.852)"/>
													<path id="패스_8478" data-name="패스 8478" d="M579.584,306.808a5.415,5.415,0,0,0-2.738-.73,4.777,4.777,0,0,0-4.967,4.1h4.253A4.6,4.6,0,0,1,579.584,306.808Z" transform="translate(-571.879 -300.633)"/>
												  </g>
												  <g id="그룹_27034" data-name="그룹 27034" transform="translate(5703.7 -5886.342)">
													<path id="패스_8479" data-name="패스 8479" d="M584.347,302.892a2.043,2.043,0,1,0,2.043-2.04A2.044,2.044,0,0,0,584.347,302.892Z" transform="translate(-583.652 -300.852)"/>
													<path id="패스_8480" data-name="패스 8480" d="M583.68,306.808a5.406,5.406,0,0,1,2.738-.73,4.774,4.774,0,0,1,4.965,4.1H587.13A4.59,4.59,0,0,0,583.68,306.808Z" transform="translate(-583.68 -300.633)"/>
												  </g>
												</g>
												</g>
											</svg>
											<p>영업자통계</p>
										</div>
										<div class="card-body">
											<div class="count">
												<p>총판</p>
												<span><a href="page/user/cntr-list.php"><?=number_format($cntr_cnt)?>명</a></span>
											</div>
											<div class="count">
												<p>센터</p>
												<span><a href="page/user/agcy-list.php"><?=number_format($agcy_cnt)?>명</a></span>
											</div>
											<div class="count">
												<p>대리점</p>
												<span><a href="page/user/sell-list.php"><?=number_format($sell_cnt)?>명</a></span>
											</div>
											<div class="count">
												<p>매니저</p>
												<span><a href="page/user/mngr-list.php"><?=number_format($mngr_cnt)?>명</a></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12">
									<div class="row">
										<div class="col-xl-6">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27831" data-name="그룹 27831" transform="translate(-5691 5867)">
														<rect id="사각형_24533" data-name="사각형 24533" width="20" height="20" transform="translate(5691 -5867)" fill="none"/>
														<path id="패스_8472" data-name="패스 8472" d="M547.383,380.323v-4.748H535.83v8.2h5.348v4.363h11.465v-7.811Zm-1.03,2.42h-9.494v-3.2h9.494Zm0-4.483h-9.494V376.6h9.494Z" transform="translate(5156.17 -6238.575)"/>
													  </g>
													</svg>
													<p>쿠폰현황</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>발행수</p>
														<span><?=number_format($cupon_cnt)?>건</span>
													</div>
													<div class="count">
														<p>다운로드수</p>
														<span><?=number_format($down_cnt)?>건</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27044" data-name="그룹 27044" transform="translate(-5691 5773)">
														<rect id="사각형_24537" data-name="사각형 24537" width="20" height="20" transform="translate(5691 -5773)" fill="none"/>
														<g id="그룹_27024" data-name="그룹 27024" transform="translate(4439.131 -6480.929)">
														  <g id="그룹_27023" data-name="그룹 27023" transform="translate(1254.869 709.929)">
															<path id="패스_8471" data-name="패스 8471" d="M1258.761,715.072v-.02h-3.892v6.7h3.892v-.017l9.646,5.173V709.929Z" transform="translate(-1254.869 -709.929)"/>
														  </g>
														</g>
													  </g>
													</svg>
													<p>광고현황</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>요청중</p>
														<span><a href="page/cash/banr-list.php"><?=number_format($req_cnt)?>건</a></span>
													</div>
													<div class="count">
														<p>광고중</p>
														<span><a href="page/cash/banr-list.php"><?=number_format($req_cnt2)?>건</a></span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12">
									<div class="row">
										<div class="col-xl-6">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27041" data-name="그룹 27041" transform="translate(-5691 5844)">
														<rect id="사각형_24534" data-name="사각형 24534" width="20" height="20" transform="translate(5691 -5844)" fill="none"/>
														<g id="그룹_27020" data-name="그룹 27020" transform="translate(11349.838 61.791) rotate(-90)">
														  <rect id="사각형_24526" data-name="사각형 24526" width="15.64" height="2.908" transform="translate(5888.151 -5645.077)"/>
														  <rect id="사각형_24527" data-name="사각형 24527" width="11.454" height="2.912" transform="translate(5888.151 -5650.459)"/>
														  <rect id="사각형_24528" data-name="사각형 24528" width="7.264" height="2.91" transform="translate(5888.151 -5655.838)"/>
														</g>
													  </g>
													</svg>
													<p>월별 매출현황</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>오늘 매출</p>
														<span><?=number_format($money_today)?>원</span>
													</div>
													<div class="count">
														<p>이번달 매출</p>
														<span><?=number_format($money_month)?>원</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27042" data-name="그룹 27042" transform="translate(-5691 5820)">
														<rect id="사각형_24535" data-name="사각형 24535" width="20" height="20" transform="translate(5691 -5820)" fill="none"/>
														<path id="패스_8473" data-name="패스 8473" d="M512.857,359.416v17.021h12.137V359.416Zm2.175,2.22h7.786v3.4h-7.786Zm1.783,12.581h-1.921V372.44h1.921Zm0-2.812h-1.921v-1.776h1.921Zm0-2.813h-1.921v-1.776h1.921Zm3.072,5.625h-1.921V372.44h1.921Zm0-2.812h-1.921v-1.776h1.921Zm0-2.813h-1.921v-1.776h1.921Zm3.071,5.625h-1.923V372.44h1.923Zm0-2.812h-1.923v-1.776h1.923Zm0-2.813h-1.923v-1.776h1.923Z" transform="translate(5182.143 -6178.416)"/>
													  </g>
													</svg>
													<p>월별 정산현황</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>지난달 정산</p>
														<span><?=number_format($calc_prev)?>원</span>
													</div>
													<div class="count">
														<p>이번달 정산</p>
														<span><?=number_format($calc_month)?>원</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12">
									<div class="row">
										<div class="col-xl-6">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27747" data-name="그룹 27747" transform="translate(6789 333)">
														<rect id="사각형_24535" data-name="사각형 24535" width="20" height="20" transform="translate(-6789 -333)" fill="none"/>
														<path id="빼기_2" data-name="빼기 2" d="M8,15A7.771,7.771,0,0,1,0,7.5,7.771,7.771,0,0,1,8,0a7.771,7.771,0,0,1,8,7.5A7.771,7.771,0,0,1,8,15ZM8.844,4.033a3.793,3.793,0,0,0-2.552.948,3.152,3.152,0,0,0,0,4.733,3.93,3.93,0,0,0,4.23.575L9.939,9.058a2.411,2.411,0,0,1-1.086.235A2.451,2.451,0,0,1,7.207,8.7a1.674,1.674,0,0,1-.624-1.353,1.674,1.674,0,0,1,.624-1.354,2.554,2.554,0,0,1,2.731-.356l.583-1.232A3.815,3.815,0,0,0,8.844,4.033Z" transform="translate(-6787 -331)"/>
													  </g>
													</svg>
													<p>월별 이벤트참여 통계</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>현장이벤트</p>
														<span><a href="page/cash/point-list.php"><?=number_format($cash1_cnt)?>건</a></span>
													</div>
													<div class="count">
														<p>돈되지이벤트</p>
														<span><a href="page/cash/cash-list.php"><?=number_format($cash2_cnt)?>건</a></span>
													</div>
													<div class="count">
														<p>전체</p>
														<span><a><?=number_format($cash3_cnt)?>건</a></span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-6">
											<div class="card card-h-100">
												<div class="card-header">
													<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
													  <g id="그룹_27747" data-name="그룹 27747" transform="translate(6789 333)">
														<rect id="사각형_24535" data-name="사각형 24535" width="20" height="20" transform="translate(-6789 -333)" fill="none"/>
														<path id="빼기_2" data-name="빼기 2" d="M8,15A7.771,7.771,0,0,1,0,7.5,7.771,7.771,0,0,1,8,0a7.771,7.771,0,0,1,8,7.5A7.771,7.771,0,0,1,8,15ZM8.844,4.033a3.793,3.793,0,0,0-2.552.948,3.152,3.152,0,0,0,0,4.733,3.93,3.93,0,0,0,4.23.575L9.939,9.058a2.411,2.411,0,0,1-1.086.235A2.451,2.451,0,0,1,7.207,8.7a1.674,1.674,0,0,1-.624-1.353,1.674,1.674,0,0,1,.624-1.354,2.554,2.554,0,0,1,2.731-.356l.583-1.232A3.815,3.815,0,0,0,8.844,4.033Z" transform="translate(-6787 -331)"/>
													  </g>
													</svg>
													<p>월별 체험단 통계</p>
												</div>
												<div class="card-body">
													<div class="count">
														<p>체험단모집</p>
														<span><?=number_format($campaign1_cnt)?>건</span>
													</div>
													<div class="count">
														<p>체험단취소</p>
														<span><?=number_format($campaign2_cnt)?>건</span>
													</div>
													<div class="count">
														<p>체험단완료</p>
														<span><?=number_format($campaign3_cnt)?>건</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12">
									<div class="card card-h-100">
										<div class="card-header">
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
											  <g id="그룹_27040" data-name="그룹 27040" transform="translate(-5691 5867)">
												<rect id="사각형_24533" data-name="사각형 24533" width="20" height="20" transform="translate(5691 -5867)" fill="none"/>
												<path id="패스_8472" data-name="패스 8472" d="M547.383,380.323v-4.748H535.83v8.2h5.348v4.363h11.465v-7.811Zm-1.03,2.42h-9.494v-3.2h9.494Zm0-4.483h-9.494V376.6h9.494Z" transform="translate(5156.17 -6238.575)"/>
											  </g>
											</svg>
											<p>월별 입출금 통계</p>
										</div>
										<div class="card-body">
											<div class="count">
												<p>충전금</p>
												<span><?=number_format($amt_sum)?>원</span>
											</div>
											<div class="count">
												<p>캐시지급</p>
												<span><?=number_format($cash_sum)?>원</span>
											</div>
											<div class="count">
												<p>출금</p>
												<span><?=number_format($out_sum)?>원</span>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6">
							<div class="row">
								<div class="col-xl-12">
									<div class="card card-h-100">
										<div class="card-header">
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
											  <g id="그룹_27044" data-name="그룹 27044" transform="translate(-5691 5773)">
												<rect id="사각형_24537" data-name="사각형 24537" width="20" height="20" transform="translate(5691 -5773)" fill="none"/>
												<g id="그룹_27024" data-name="그룹 27024" transform="translate(4439.131 -6480.929)">
												  <g id="그룹_27023" data-name="그룹 27023" transform="translate(1254.869 709.929)">
													<path id="패스_8471" data-name="패스 8471" d="M1258.761,715.072v-.02h-3.892v6.7h3.892v-.017l9.646,5.173V709.929Z" transform="translate(-1254.869 -709.929)"/>
												  </g>
												</g>
											  </g>
											</svg>
											<p>동네광고관리</p>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th class="table-light" style="width: 80px;">순번</th>
															<th class="table-light" style="width: 100px;">대표자명</th>
															<th class="table-light">제목</th>
															<th class="table-light" style="width: 100px;">업체명</th>
															<th class="table-light" style="width: 80px;">수신인원</th>
															<th class="table-light" style="width: 150px;">광고발송일시</th>
														</tr>
													</thead>
													<tbody>
													<?php if($ad_list == null) { ?>
														<tr>
															<td colspan="6">조회된 정보가 없습니다.</td>
														</tr>
													<?php } else { 
														foreach($ad_list as $d) { ?>
														<tr>
															 <td><?=$ad_cnt?></td>
															 <td><?=$d['ceo_name']?></td>
															 <td><a href="page/cash/ad-info.php?ad_no=<?=$d['ad_no']?>" style="font-weight:500; text-decoration: underline"><?=$d['ad_title']?></a></td>
															 <td><?=$d['store_name']?></td>
															 <td><?=number_format($d['ad_user_cnt'])?></td>
															 <td><?=substr($d['reg_date'],0,16)?></td>
														</tr>
													<?php $ad_cnt--; }
														}?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-xl-12">
									<div class="card card-h-100">
										<div class="card-header">
											<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
											  <g id="그룹_27831" data-name="그룹 27831" transform="translate(-5691 5867)">
												<rect id="사각형_24533" data-name="사각형 24533" width="20" height="20" transform="translate(5691 -5867)" fill="none"/>
												<path id="패스_8472" data-name="패스 8472" d="M547.383,380.323v-4.748H535.83v8.2h5.348v4.363h11.465v-7.811Zm-1.03,2.42h-9.494v-3.2h9.494Zm0-4.483h-9.494V376.6h9.494Z" transform="translate(5156.17 -6238.575)"/>
											  </g>
											</svg>
											<p>충전금관리</p>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table class="table">
													<thead>
														<tr>
															<th class="table-light" style="width: 80px;">순번</th>
															<th class="table-light" style="width: 100px;">총판명</th>
															<th class="table-light" style="width: 100px;">매니저명</th>
															<th class="table-light" style="width: 100px;">입금자명</th>
															<th class="table-light">입금액</th>
															<th class="table-light" style="width: 150px;">입금일</th>
														</tr>
													</thead>
													<tbody>
														<?php if($amt_list == null) { ?>
														<tr>
															<td colspan="6">조회된 정보가 없습니다.</td>
														</tr>
														<?php } else {
															foreach($amt_list as $d) { ?>
															<tr>
																<td><?=$amt_cnt?></td>
																<td><?=$d['cntr_nm']?></td>
																<td><?=$d['agcy_nm']?></td>
																<td><?=$d['push_name']?></td>
																<td><?=number_format($d['amt'])?></td>
																<td><?=$d['bizdate']?></td>
															</tr>
														<?php $amt_cnt--; }
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
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include('lib/footer.php');
?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
	var swiper = new Swiper(".mySwiper", {
		spaceBetween: 30,
		centeredSlides: true,
		loop: true,
		autoplay: {
		  delay: 5000,
		  disableOnInteraction: false,
		},
		pagination: {
		  el: ".swiper-pagination",
		  clickable: true,
		},
	});
</script>