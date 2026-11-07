<?php
include('../../lib/header.php');
include('../../../common.php');
include('../../lib/menu.php');




if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}


$page = ($_GET['page'] == null ? 1:$_GET['page']);
$month = $_GET['month'] == null ? 0:$_GET['month'];
$state = $_GET['state'] == null ? 1:$_GET['state'];

$param = null;
$param1 = null;

$where = '';

$where1 = '';
$where2 = '';
$where3 = '';

if($month > 0) {
	$where1 = " AND DATE_FORMAT(a.bizdate, '%Y-%m') = '".$month."'";
	$where2 = " AND DATE_FORMAT(a.reg_date, '%Y-%m') = '".$month."'";
	$where3 = " AND DATE_FORMAT(a.up_reg_date, '%Y-%m') = '".$month."'";
	$where4 = " AND DATE_FORMAT(a.reg_date, '%Y-%m') = '".$month."'";
}

if($month != 0) {
    $where .= " AND DATE_FORMAT(up_reg_date, '%Y-%m') = '".$month."'";
}

if($state == 1) {
	$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m-%d')) as cnt FROM ( SELECT a.reg_date, DATE_FORMAT(a.reg_date, '%Y-%m-%d') FROM store_expense_pay a
			WHERE a.pay_state = 1 ".$where2."  GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m-%d')) as acnt";
}
if($state == 2) {
	$sql = "SELECT acnt.bizdate, count(DATE_FORMAT(acnt.bizdate, '%Y-%m-%d')) as cnt FROM ( SELECT a.bizdate, DATE_FORMAT(a.bizdate, '%Y-%m-%d') FROM dchagmt a
			WHERE a.msgtype = 1300 ".$where1."  GROUP BY DATE_FORMAT(a.bizdate, '%Y-%m-%d')) as acnt";
}
if($state == 3) {
	$sql = "SELECT acnt.up_reg_date, count(DATE_FORMAT(acnt.up_reg_date, '%Y-%m-%d')) as cnt FROM ( SELECT a.up_reg_date, DATE_FORMAT(a.up_reg_date, '%Y-%m-%d') FROM user_cash_out a
			WHERE a.out_state = 1 ".$where3."  GROUP BY DATE_FORMAT(a.up_reg_date, '%Y-%m-%d')) as acnt";
}
if($state == 4) {
	$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m-%d')) as cnt FROM ( SELECT a.reg_date, DATE_FORMAT(a.reg_date, '%Y-%m-%d') FROM push_pay_log a
			WHERE a.use_yn = 1 ".$where4."  GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m-%d')) as acnt";
}
if($state == 5) {
	$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m-%d')) as cnt FROM ( SELECT a.reg_date, DATE_FORMAT(a.reg_date, '%Y-%m-%d') FROM store_campaign_pay a
			WHERE a.distributor_no = 1 AND a.agency_no IS NULL AND a.seller_no IS NULL AND a.manager_no IS NULL AND a.pay_state = 2 ".$where4."  GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m-%d')) as acnt";
}
$list_cnt = $pdo->row($sql, $param1);
$cnt=$list_cnt['cnt'];
$start=$cnt - ((($page - 1) * 10) + 9);
if($start<0){
	$start =0;
}
$param["s"] = $start;
$param["e"] = $cnt - (($page - 1) * 10);



///////////////////////      페이지 구현      //////////////////////////
$total_record = $list_cnt['cnt']; // 불러올 게시물 총 개수
$list = 10; // 한 페이지에 보여줄 게시물 개수
$block_cnt = 5; // 하단에 표시할 블록 당 페이지 개수
$block_num = ceil($page / $block_cnt); // 현재 페이지 블록
$block_start = $page-1;//(($block_num - 1) * $block_cnt) + 1; // 블록의 시작 번호
if($block_start==0){
	$block_start=1;
}
$block_end = $block_start + $block_cnt - 1; // 블록의 마지막 번호
$total_page = ceil($total_record / $list); // 페이징한 페이지 수
if($block_end > $total_page){
	$block_end = $total_page; // 블록 마지막 번호가 총 페이지 수보다 크면 마지막 페이지 번호를 총 페이지 수로 지정함
}
$total_block = ceil($total_page / $block_cnt); // 블록의 총 개수
$page_start = ($page - 1) * $list; // 페이지의 시작 (SQL문에서 LIMIT 조건 걸 때 사용)
///////////////////////////////////////////////////////////////////////

$sql = "SELECT amt.cnt as cnt1, cash.store as store, cash.cnt as cnt2, cash.sum as sum, out.cnt as cnt3, ad.cnt as cnt5, ad.sum as sum5, ad.ceo as ceo, campaign.cnt as cnt6, campaign.sum as sum6, campaign.store as store2 FROM
		(SELECT count(*) as cnt FROM dchagmt a WHERE a.msgtype = 1300".$where1.") amt,
		(SELECT count(*) as cnt, sum(toss_amt) as sum, count(distinct a.store_no) as store FROM store_expense_pay a LEFT OUTER JOIN store_info c ON a.store_no = c.store_no WHERE a.distributor_no = 1 AND a.pay_state = 1".$where2.") cash,
		(SELECT count(*) as cnt FROM user_cash_out a WHERE a.out_state = 1".$where3.") `out`,
		(SELECT count(*) as cnt, SUM(CASE WHEN use_yn = 1 THEN a.amt END) as sum, count(distinct a.ceo_no) as ceo FROM push_pay_log a WHERE use_yn = 1 ".$where4.") ad,
		(SELECT count(*) as cnt, SUM(CASE WHEN pay_state = 1 THEN a.amt END) as sum, count(distinct a.store_no) as store FROM store_campaign_pay a WHERE a.distributor_no = 1 AND a.agency_no IS NULL AND a.seller_no IS NULL AND a.manager_no IS NULL AND pay_state = 2 ".$where4.") campaign";
$data = $pdo->row($sql, $param);


if($state == 1) {
	$sql = "SELECT *, count(*) as cnt, sum(toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m-%d') as reg_date FROM store_expense_pay a WHERE a.distributor_no = 1 AND a.pay_state = 1".$where2." GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m-%d') ORDER BY a.reg_date DESC LIMIT $page_start, $list";
}
if($state == 2) {
	$sql = "SELECT *, count(*) as cnt, DATE_FORMAT(a.bizdate, '%Y-%m-%d') as reg_date FROM dchagmt a WHERE a.msgtype = 1300 ".$where1." GROUP BY DATE_FORMAT(a.bizdate, '%Y-%m-%d') ORDER BY a.bizdate DESC LIMIT $page_start, $list";
}
if($state == 3) {
	$sql = "SELECT *, count(*) as cnt, DATE_FORMAT(a.up_reg_date, '%Y-%m-%d') as reg_date FROM user_cash_out a WHERE a.out_state = 1".$where3." GROUP BY DATE_FORMAT(a.up_reg_date, '%Y-%m-%d') ORDER BY a.up_reg_date DESC LIMIT $page_start, $list";
}
if($state == 4) {
	$sql = "SELECT *, count(*) as cnt, sum(amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m-%d') as reg_date FROM push_pay_log a WHERE a.use_yn = 1".$where4." GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m-%d') ORDER BY a.reg_date DESC LIMIT $page_start, $list";
}
if($state == 5) {
	$sql = "SELECT *, count(*) as cnt, sum(amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m-%d') as reg_date FROM store_campaign_pay a WHERE a.distributor_no = 1 AND a.agency_no IS NULL AND a.seller_no IS NULL AND a.manager_no IS NULL AND a.pay_state = 2".$where4." GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m-%d') ORDER BY a.reg_date DESC LIMIT $page_start, $list";
}
$list_data = $pdo->query($sql, $param);


$rownum = $total_record - $page_start;
?>
<style>

    .card {
        min-height: 80vh;
    }

	.search-box a {
		color: #fff;
		background: #02b754;
		text-align: center;
		padding: 5px 10px;
		border-radius: 5px;
	}
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h6 class="title-strong">매출내역</h6>
				</div>
				<div class="card-body">
					<form action="sales.php" id='SearchForm' method="GET">
						<input type="hidden" name="page" id='ContetCurrentPage' value='<?=$page?>'>
						<div class="search-box" style="margin-bottom: 10px;">
							<div class="search-form">
								<input type="month" onchange="Search_Page(1);" name="month" value="<?=$month?>">
							</div>
							<div>
								<a href="excel.php?month=<?=$month?>">엑셀다운로드</a>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table info-table">
								<tr>
									<th class="table-light">총 매출액</th>
									<td><?=number_format($data['sum'] + $data['sum1'] + ($data['cnt3'] * 300))?></td>
									<th class="table-light">공급가액</th>
									<td><?=number_format(round(($data['sum'] + $data['sum1'] + ($data['cnt3'] * 300)) / 1.1))?></td>
									<th class="table-light">세액</th>
									<td><?=number_format(round(($data['sum'] + $data['sum1'] + ($data['cnt3'] * 300)) - ($data['sum'] + $data['sum1'] + ($data['cnt3'] * 300)) / 1.1))?></td>
								</tr>
								<tr>
									<th class="table-light" style="width: 150px;">이용료매출액</th>
									<td><?=number_format($data['sum'] + $data['sum1'])?></td>
									<th class="table-light" style="width: 150px;">사업장수</th>
									<td colspan="3"><?=number_format($data['store'])?></td>
								</tr>
								<tr>
									<th class="table-light" style="width: 150px;">캠페인매출액</th>
									<td><?=number_format($data['sum6'])?></td>
									<th class="table-light" style="width: 150px;">캠페인건수</th>
									<td><?=number_format($data['cnt6'])?></td>
									<th class="table-light" style="width: 150px;">사업장수</th>
									<td><?=number_format($data['store2'])?></td>
								</tr>
								<!--<tr>
									<th class="table-light" style="width: 150px;">광고매출액</th>
									<td><?=number_format($data['sum5'])?></td>
									<th class="table-light" style="width: 150px;">광고건수</th>
									<td><?=number_format($data['cnt5'])?></td>
									<th class="table-light" style="width: 150px;">사장님수</th>
									<td><?=number_format($data['ceo'])?></td>
								</tr>-->
								<!--<tr>
									<th class="table-light" style="width: 150px;">충전매출액</th>
									<td><?=number_format($data['cnt1'] * 200)?></td>
									<th class="table-light" style="width: 150px;">충전건수</th>
									<td colspan="3"><?=number_format($data['cnt1'])?></td>
								</tr>-->
								<tr>
									<th class="table-light" style="width: 150px;">출금매출액</th>
									<td><?=number_format($data['cnt3'] * 300)?></td>
									<th class="table-light" style="width: 150px;">출금건수</th>
									<td colspan="3"><?=number_format($data['cnt3'])?></td>
								</tr>
							</table>
						</div>
						<div class="search-box">
							<div class="state-list">
								<!-- <?=$state?> -->
								<input onclick="Search_Page(1);" <?=$state == 1 ? "checked":""?> type="radio" name="state" id="state1" value="1"><label for="state1">이용료</label>
								<input onclick="Search_Page(1);" <?=$state == 5 ? "checked":""?> type="radio" name="state" id="state5" value="5"><label for="state5">캠페인</label>
								<!--<input onclick="Search_Page(1);" <?=$state == 4 ? "checked":""?> type="radio" name="state" id="state4" value="4"><label for="state4">광고</label>-->
								<!--<input onclick="Search_Page(1);" <?=$state == 2 ? "checked":""?> type="radio" name="state" id="state2" value="2"><label for="state2">충전</label>-->
								<input onclick="Search_Page(1);" <?=$state == 3 ? "checked":""?> type="radio" name="state" id="state3" value="3"><label for="state3">출금</label>
							</div>
						</div>
					</form>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th style="width: 100px;">날짜</th>
									<th>매출액</th>
									<th style="width: 100px;">건수</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php if($list_data == null) {?>
										<tr>
											<td colspan="9">조회된 정보가 없습니다.</td>
										</tr>
									<?php } else {
										foreach($list_data as $d) {?>
										<tr>
											<td><?=$rownum?></td>
											<td><?=$d['reg_date']?></td>
											<?php if($state == 1) { ?>
											<td><?=number_format($d['sum'] + $d['sum1'])?></td>
											<?php } else if($state == 4 || $state == 5) { ?>
											<td><?=number_format($d['sum'])?></td>
											<?php } else { ?>
											<td><?=number_format($d['cnt'] * ($state == 2 ? 200:300))?></td>
											<?php } ?> 
											<td><?=$d['cnt'] + $d['cnt1']?></td>
										</tr>
									<?php $rownum--; }
									}?>
								</tr>
							</tbody>
						</table>
					</div>
					<ul class="page-list">
						<?php
							if ($page <= 1){
								// 빈 값
							} else {
								if(isset($unum)){
									echo "<li><a  href='sales.php?page=1&month=$month&state=$state' aria-label='Previous'><<</a></li>";
								} else {
									echo "<li><a  href='sales.php?page=1&month=$month&state=$state' aria-label='Previous'><<</a></li>";
								}
							}
							for($i = $block_start; $i <= $block_end; $i++){
								if($page == $i){
									echo "<li class='on'><a href=''> $i </a></li>";
								} else {
									if(isset($unum)){
										echo "<li><a  href='sales.php?page=$i&month=$month&state=$state'> $i </a></li>";
									} else {
										echo "<li><a  href='sales.php?page=$i&month=$month&state=$state'> $i </a></li>";
									}
								}
							}
							if($page >= $total_page){
								// 빈 값
							} else {
								if(isset($unum)){
									echo "<li><a   href='sales.php?page=$total_page&month=$month&state=$state'>>></a>";
								} else {
									echo "<li><a   href='sales.php?page=$total_page&month=$month&state=$state'>>></a>";
								}
							}
						?> 
					</ul>
				</div>
			</div>
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
	$("#ContetCurrentPage").val(n);
	$("#SearchForm").submit();//GetRow_item();
}

</script>