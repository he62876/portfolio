<?php
include('../../../common.php');
include('../../lib/header.php');
include('../../lib/menu.php');



$page = ($_GET['page'] == null ? "1":$_GET['page']);
$cntr = $_GET['cntr'] == null ? 0:$_GET['cntr'];
$agcy = $_GET['agcy'] == null ? 0:$_GET['agcy'];
$sell = $_GET['sell'] == null ? 0:$_GET['sell'];
$mngr = $_GET['mngr'] == null ? 0:$_GET['mngr'];
$date = $_GET['date'] == null ? 0:$_GET['date'];
$state = $_GET['state'] == null ? 0:$_GET['state'];

$param = null;
$param1 = null;

$where = '';

if($cntr != 0 && $state != 0) {
	if($cntr == 999) {
		$where = " AND a.distributor_no IS NULL ";
	} else {
		$where = " AND a.distributor_no = ".$cntr;
	}
}

if($agcy != 0 && $state == 2) {
    $where .= " AND a.agency_no = ".$agcy;
}

if($sell != 0 && $state == 3) {
    $where .= " AND a.seller_no = ".$sell;
}

if($mngr != 0 && $state == 4) {
    $where .= " AND a.manager_no = ".$mngr;
}


if($date != 0) {
    $where .= " AND DATE_FORMAT(a.reg_date, '%Y-%m') = '".$date."'";
}


$sql = "SELECT * FROM agency_info WHERE grade = 1 AND agency_state = 1";
$cntr_list = $pdo->query($sql, $param);

if($lv == 0) {
	$sql = "SELECT * FROM agency_info WHERE grade = 2 AND agency_state = 1 AND distributor_no = ".$cntr;
}
if($lv == 1) {
	$sql = "SELECT * FROM agency_info WHERE grade = 2 AND agency_state = 1 AND distributor_no = ".$_SESSION['no'];
}
$agcy_list = $pdo->query($sql, $param);

if($lv < 2) {
	$sql = "SELECT * FROM agency_info WHERE grade = 3 AND agency_state = 1 AND top_agency_no = ".$agcy;
}
if($lv == 2) {
	$sql = "SELECT * FROM agency_info WHERE grade = 3 AND agency_state = 1 AND top_agency_no = ".$_SESSION['no'];
}
$sell_list = $pdo->query($sql, $param);

if($lv < 3) {
	$sql = "SELECT * FROM agency_info WHERE grade = 4 AND agency_state = 1 AND mid_agency_no = ".$sell;
}
if($lv == 3) {
	$sql = "SELECT * FROM agency_info WHERE grade = 4 AND agency_state = 1 AND mid_agency_no = ".$_SESSION['no'];
}
$mngr_list = $pdo->query($sql, $param);

if($lv == 0) {
	if($state == 0) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y년 %m월')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_point_pay a WHERE a.pay_state = 1 AND a.pay_type IN (2) GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 1) {
		
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.distributor_no IS NOT NULL AND a.distributor_no != 1 AND a.distributor_no != 0 ".$where." GROUP BY a.distributor_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.distributor_no IS NOT NULL AND a.distributor_no != 1 AND a.distributor_no != 0 ".$where." GROUP BY a.distributor_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 2) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.seller_no IS NULL ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.agency_no != 0 AND a.seller_no = 0 ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 3) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0 ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 4) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 ".$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
}

if($lv == 1) {
	if($state == 2) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.distributor_no = ".$_SESSION['no']." AND a.seller_no IS NULL ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.agency_no != 0 AND a.distributor_no = ".$_SESSION['no']." AND a.seller_no = 0 ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 3) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.distributor_no = ".$_SESSION['no']." AND a.manager_no IS NULL ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.distributor_no = ".$_SESSION['no']." AND a.manager_no = 0 ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 4) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL AND a.distributor_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 AND a.distributor_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";

	}
}

if($lv == 2) {
	if($state == 2) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.agency_no = ".$_SESSION['no']." AND a.seller_no IS NULL ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_point_pay a WHERE a.pay_state = 1 AND a.pay_type IN (2) AND a.agency_no IS NOT NULL AND a.agency_no = ".$_SESSION['no']." AND a.seller_no IS NULL ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 3) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.agency_no = ".$_SESSION['no']." AND a.manager_no IS NULL ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.agency_no = ".$_SESSION['no']." AND a.manager_no = 0 ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 4) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL AND a.agency_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 AND a.agency_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
}
if($lv == 3) {
	if($state == 3) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM ( SELECT a.reg_date, DATE_FORMAT(a.reg_date, '%Y-%m') FROM store_point_pay a
				WHERE a.seller_no IS NOT NULL AND a.seller_no = ".$_SESSION['no']." AND  a.pay_state = 1 ".$where."  GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
	if($state == 4) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL AND a.seller_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 AND a.seller_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";
	}
}
if($lv == 4) {
	if($state == 4) {
		$sql = "SELECT acnt.reg_date, count(DATE_FORMAT(acnt.reg_date, '%Y-%m')) as cnt FROM
				( SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL AND a.manager_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')
				UNION ALL
				SELECT count(*) as cnt, a.reg_date, DATE_FORMAT(a.reg_date, '%Y년 %m월'), a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 AND a.manager_no = ".$_SESSION['no'].$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m')) as acnt";

	}
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

if($lv == 0) {
	$sum1_1 = $pdo->single("SELECT SUM(CASE WHEN a.distributor_no = 1 THEN a.benefit_amt END) FROM store_expense_pay a WHERE a.pay_state = 1 ".$where, $param);
	$sum1_2 = $pdo->single("SELECT SUM(CASE WHEN a.distributor_no = 1 THEN a.amt END) FROM store_campaign_pay a WHERE a.pay_state = 2 ".$where, $param);
	$sum1 = $sum1_1 + $sum1_2;

	//count(CASE WHEN a.distributor_no IS NOT NULL AND a.distributor_no !=1 THEN a.amt END) as sum2, count(CASE WHEN a.agency_no IS NOT NULL THEN a.amt END) as sum3

	$sum2_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no WHERE a.pay_state = 1 AND a.distributor_no != 1 AND a.agency_no = 0 AND a.distributor_no != 1 ".$where, $param);
	$sum2_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no WHERE a.pay_state = 2 AND a.distributor_no != 1 AND a.agency_no IS NULL AND a.distributor_no != 1 ".$where, $param);
	$sum2 = $sum2_1 + $sum2_2;

	$sum3_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.agency_no = b.agency_no WHERE a.pay_state = 1 AND a.agency_no != 0 AND a.seller_no = 0 ".$where, $param);
	$sum3_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.agency_no = b.agency_no WHERE a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.seller_no IS NULL ".$where, $param);
	$sum3 = $sum3_1 + $sum3_2;

	$sum4_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0 ".$where, $param);
	$sum4_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where, $param);
	$sum4 = $sum4_1 + $sum4_2;

	$sum5_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.pay_state = 1 AND a.manager_no != 0 ".$where, $param);
	$sum5_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where, $param);
	$sum5 = $sum5_1 + $sum5_2;

	if($state == 0) {

		$sql = "SELECT a.reg_date as reg_date,
				SUM(CASE WHEN a.name = 'type1' THEN a.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN a.name = 'type2' THEN a.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(amt) as sum, DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, pay_state as pay_state, distributor_no as distributor_no, agency_no as agency_no, seller_no as seller_no, manager_no as manager_no, 'type1' as name FROM store_campaign_pay GROUP BY reg_date
				UNION ALL
				SELECT SUM(amt) as sum, DATE_FORMAT(reg_date, '%Y년 %m월') as reg_date, pay_state as pay_state, distributor_no as distributor_no, agency_no as agency_no, seller_no as seller_no, manager_no as manager_no, 'type2' as name FROM store_point_pay WHERE pay_type = 2 GROUP BY reg_date) AS a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON a.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON a.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON a.manager_no = e.agency_no
				WHERE a.pay_state = 1 ".$where." 
				GROUP BY a.reg_date ORDER BY a.reg_date DESC ";

	}
	if($state == 1) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, ORN_DT.distributor_no as distributor_no, b.agency_no as agency_no,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.distributor_no IS NOT NULL AND a.agency_no IS NULL ".$where." GROUP BY a.distributor_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.distributor_no IS NOT NULL AND a.agency_no = 0 ".$where."GROUP BY a.distributor_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE ORN_DT.distributor_no != 1 AND ORN_DT.distributor_no != 0 AND (ORN_DT.agency_no IS NULL OR ORN_DT.agency_no = 0)
				GROUP BY ORN_DT.distributor_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";

		 /* $sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm, a.distributor_no as distributor_no, b.agency_no as agency_no, b.set_amt as set_amt FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				WHERE a.distributor_no IS NOT NULL AND a.distributor_no != 1 AND a.distributor_no != 0 AND a.agency_no IS NULL AND a.pay_state = 1  ".$where." GROUP BY a.distributor_no, DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list"; */
	}
	if($state == 2) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, c.agency_no as agency_no,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.seller_no IS NULL ".$where." GROUP BY a.agency_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.agency_no != 0 AND a.seller_no = 0 ".$where."GROUP BY a.agency_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE (ORN_DT.agency_no IS NOT NULL OR ORN_DT.agency_no != 0) AND (ORN_DT.seller_no IS NULL OR ORN_DT.seller_no = 0)
				GROUP BY ORN_DT.agency_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";


		/* $sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, c.agency_no as agency_no FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON a.agency_no = c.agency_no
				WHERE a.agency_no IS NOT NULL AND a.seller_no IS NULL AND a.pay_state = 1  ".$where." GROUP BY a.agency_no, DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list"; */
	}
	if($state == 3) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, d.agency_no as agency_no,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where." GROUP BY a.seller_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0 ".$where."GROUP BY a.seller_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE (ORN_DT.seller_no IS NOT NULL OR ORN_DT.seller_no != 0) AND (ORN_DT.manager_no IS NULL OR ORN_DT.manager_no = 0)
				GROUP BY ORN_DT.seller_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";

		/* $sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, d.agency_no as agency_no FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON a.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON a.seller_no = d.agency_no
				WHERE a.seller_no IS NOT NULL AND a.manager_no IS NULL AND a.pay_state = 1  ".$where." GROUP BY a.seller_no, DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list"; */
	}
	if($state == 4) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, e.agency_nm as mngr_nm, e.agency_code as code,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where." GROUP BY a.manager_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 ".$where."GROUP BY a.manager_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE ORN_DT.manager_no IS NOT NULL AND ORN_DT.manager_no != 0
				GROUP BY ORN_DT.manager_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";


		/* $sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, e.agency_nm as mngr_nm, e.agency_code as code FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON a.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON a.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON a.manager_no = e.agency_no
				WHERE a.manager_no IS NOT NULL AND a.pay_state = 1  ".$where." GROUP BY a.manager_no, DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list"; */
	}
}
if($lv == 1) {

	$sum2_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.agency_no = 0 ".$where, $param);
	$sum2_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.agency_no IS NULL ".$where, $param);
	$sum2 = $sum2_1 + $sum2_2;

	$sum3_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.agency_no = b.agency_no WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.agency_no != 0 AND a.seller_no = 0 ".$where, $param);
	$sum3_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.agency_no = b.agency_no WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.seller_no IS NULL ".$where, $param);
	$sum3 = $sum3_1 + $sum3_2;

	$minus = $cnt3 * ($lv != 2 ? 1:$set_amt);

	$sum4_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0".$where, $param);
	$sum4_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where, $param);
	$sum4 = $sum4_1 + $sum4_2;

	$sum5_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.manager_no != 0 ".$where, $param);
	$sum5_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.distributor_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where, $param);
	$sum5 = $sum5_1 + $sum5_2;

	if($state == 1) {
		$sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				WHERE a.pay_state = 1  ".$where." AND a.distributor_no = ".$_SESSION['no']." AND a.agency_no IS NULL GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list";
	}
	if($state == 2) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, c.agency_no as agency_no,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.seller_no IS NULL ".$where." AND a.distributor_no = ".$_SESSION['no']." GROUP BY a.agency_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.agency_no != 0 AND a.seller_no = 0 ".$where." AND a.distributor_no = ".$_SESSION['no']." GROUP BY a.agency_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE (ORN_DT.agency_no OR NOT NULL OR ORN_DT.agency_no != 0) AND (ORN_DT.seller_no IS NULL OR ORN_DT.seller_no = 0)
				GROUP BY ORN_DT.agency_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";

		
	}
	if($state == 3) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, d.agency_no as agency_no,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where." AND a.distributor_no = ".$_SESSION['no']." GROUP BY a.seller_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0 ".$where." AND a.distributor_no = ".$_SESSION['no']." GROUP BY a.seller_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE (ORN_DT.seller_no IS NOT NULL OR ORN_DT.seller_no != 0) AND (ORN_DT.manager_no IS NULL OR ORN_DT.manager_no = 0)
				GROUP BY ORN_DT.seller_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";
	}
	if($state == 4) {

		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, e.agency_nm as mngr_nm, e.agency_code as code,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where." AND a.distributor_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 ".$where." AND a.distributor_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE ORN_DT.manager_no IS NOT NULL AND ORN_DT.manager_no != 0
				GROUP BY ORN_DT.manager_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";
	}
}
if($lv == 2) {

	$sum3_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.agency_no = b.agency_no WHERE a.agency_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.agency_no != 0 AND a.seller_no = 0 ".$where, $param);
	$sum3_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.agency_no = b.agency_no WHERE a.agency_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.agency_no IS NOT NULL AND a.seller_no IS NULL ".$where, $param);
	$sum3 = $sum3_1 + $sum3_2;

	$minus = $cnt3 * ($lv != 2 ? 1:$set_amt);

	$sum4_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.agency_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.seller_no  != 0 AND a.manager_no = 0 ".$where, $param);
	$sum4_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.agency_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where, $param);
	$sum4 = $sum4_1 + $sum4_2;

	$sum5_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.agency_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.manager_no  != 0 ".$where, $param);
	$sum5_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.agency_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where, $param);
	$sum5 = $sum5_1 + $sum5_2;


	if($state == 2) {
		$sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, c.agency_no as agency_no FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON a.agency_no = c.agency_no
				WHERE a.pay_state = 1  ".$where." AND a.agency_no = ".$_SESSION['no']." AND a.seller_no IS NULL GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list";
	}
	if($state == 3) {
		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, d.agency_no as agency_no,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 1 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where." AND a.agency_no = ".$_SESSION['no']." GROUP BY a.seller_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0 ".$where." AND a.agency_no = ".$_SESSION['no']." GROUP BY a.seller_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE (ORN_DT.seller_no IS NOT NULL OR ORN_DT.seller_no != 0) AND (ORN_DT.manager_no IS NULL OR ORN_DT.manager_no = 0)
				GROUP BY ORN_DT.seller_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";

	}
	if($state == 4) {
		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, e.agency_nm as mngr_nm, e.agency_code as code,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where." AND a.agency_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no IS NOT NULL ".$where." AND a.agency_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE ORN_DT.manager_no IS NOT NULL AND ORN_DT.manager_no != 0
				GROUP BY ORN_DT.manager_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";
	}
}
if($lv == 3) {

	$sum4_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.seller_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.seller_no != 0 AND a.manager_no = 0 ".$where, $param);
	$sum4_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.seller_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.seller_no IS NOT NULL AND a.manager_no IS NULL ".$where, $param);
	$sum4 = $sum4_1 + $sum4_2;

	$sum5_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.seller_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.manager_no != 0 ".$where, $param);
	$sum5_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.seller_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where, $param);
	$sum5 = $sum5_1 + $sum5_2;


	$set_amt = $pdo->single("SELECT set_amt FROM agency_info WHERE agency_no = ".$_SESSION['no'], $param);

	if($state == 3) {
		$sql = "SELECT *, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, sum(CASE WHEN a.pay_type = 1 THEN a.amt END) as amt, sum(CASE WHEN a.pay_type = 2 THEN a.amt END) as amt1, sum(CASE WHEN a.pay_type = 3 THEN a.amt END) as amt2, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, d.agency_no as agency_no FROM store_point_pay a
				LEFT OUTER JOIN agency_info b ON a.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON a.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON a.seller_no = d.agency_no
				WHERE a.pay_state = 1  ".$where." AND a.seller_no = ".$_SESSION['no']." AND a.manager_no IS NULL GROUP BY DATE_FORMAT(a.reg_date, '%Y-%m') ORDER BY a.reg_date DESC LIMIT $page_start, $list";
	}
	if($state == 4) {
		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, e.agency_nm as mngr_nm, e.agency_code as code,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where." AND a.seller_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 ".$where." AND a.seller_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE ORN_DT.manager_no IS NOT NULL AND ORN_DT.manager_no != 0
				GROUP BY ORN_DT.manager_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";

	}
}
if($lv == 4) {
	$sum5_1 = $pdo->single("SELECT SUM(a.toss_amt) FROM store_expense_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.manager_no = ".$_SESSION['no']." AND a.pay_state = 1 AND a.manager_no != 0 ".$where, $param);
	$sum5_2 = $pdo->single("SELECT SUM(a.amt) FROM store_campaign_pay a
			LEFT OUTER JOIN agency_info b ON a.seller_no = b.agency_no WHERE a.manager_no = ".$_SESSION['no']." AND a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where, $param);
	$sum5 = $sum5_1 + $sum5_2;

	$set_amt = $pdo->single("SELECT set_amt FROM agency_info WHERE agency_no = ".$_SESSION['no'], $param);

	if($state == 4) {
		$sql = "SELECT ORN_DT.reg_date as reg_date, b.agency_nm as cntr_nm, c.agency_nm as agcy_nm, d.agency_nm as sell_nm, e.agency_nm as mngr_nm, e.agency_code as code,
				SUM(CASE WHEN ORN_DT.name = 'type1' THEN ORN_DT.sum ELSE 0 END) AS amt1,
				SUM(CASE WHEN ORN_DT.name = 'type2' THEN ORN_DT.sum ELSE 0 END) AS amt2
				FROM
				(SELECT SUM(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type1' as name FROM store_campaign_pay a WHERE a.pay_state = 2 AND a.manager_no IS NOT NULL ".$where." AND a.manager_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date
				UNION ALL
				SELECT SUM(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y년 %m월') as reg_date, a.pay_state as pay_state, a.distributor_no as distributor_no, a.agency_no as agency_no, a.seller_no as seller_no, a.manager_no as manager_no, 'type2' as name FROM store_expense_pay a WHERE a.pay_state = 1 AND a.manager_no != 0 ".$where." AND a.manager_no = ".$_SESSION['no']." GROUP BY a.manager_no, a.reg_date) AS ORN_DT
				LEFT OUTER JOIN agency_info b ON ORN_DT.distributor_no = b.agency_no
				LEFT OUTER JOIN agency_info c ON ORN_DT.agency_no = c.agency_no
				LEFT OUTER JOIN agency_info d ON ORN_DT.seller_no = d.agency_no
				LEFT OUTER JOIN agency_info e ON ORN_DT.manager_no = e.agency_no
				WHERE ORN_DT.manager_no IS NOT NULL AND ORN_DT.manager_no != 0
				GROUP BY ORN_DT.manager_no, ORN_DT.reg_date ORDER BY ORN_DT.reg_date DESC LIMIT $page_start, $list";

	}
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
					<h6 class="title-strong">정산관리</h6>
				</div>
				<div class="card-body">
					<form action="calculate.php" id='SearchForm' method="GET">
						<input type="hidden" name="page" id='ContetCurrentPage' value='<?=$page?>'>
						<div class="search-box" style="margin-bottom: 10px;">
							<div class="search-form">
								<input onchange="Search_Page(1);" type="month" name="date" value="<?=$date?>">
							</div>
							<?php if(($lv == 0 && $state == 1) || ($lv == 1 && $state == 2) || ($lv == 2 && $state == 3) || ($lv == 3 && $state == 4)) { ?>
							<div>
								<a href="excel_c.php?month=<?=$date?>&lv=<?=$lv?>&no=<?=$_SESSION['no']?>">엑셀다운로드</a>
							</div>
							<?php } ?>
						</div>
						<div class="table-responsive">
							<table class="table info-table">
								<?php if($lv == 0) { ?>
								<tr>
									<th class="table-light" style="width: 150px;">본사정산액</th>
									<td colspan="5"><?=number_format($sum1)?></td>
								</tr>
								<?php } ?>
								<?php if($lv < 2) { ?>
								<tr>
									<th class="table-light" style="width: 150px;">총판정산액</th>
									<td><?=number_format($sum2 - ($lv == 1 && $agcy == 0 ? $sum3:0))?></td>
								<?php } if($lv < 3) { ?>
									<th class="table-light" style="width: 150px;">센터정산액</th>
									<td colspan="<?=$lv == 2 ? 3:1?>"><?=number_format($sum3 - ($lv == 2 && $sell == 0 ? $sum4:0))?></td>
								</tr>
								<?php } ?>
								<tr>
								<?php if($lv < 4) { ?>
									<th class="table-light" style="width: 150px;">대리점정산액</th>
									<td><?=number_format($sum4 - ($lv == 3 && $mngr == 0 ? $sum5:0))?></td>
								<?php } ?>
									<th class="table-light" style="width: 150px;">매니저정산액</th>
									<td colspan="<?=$lv == 4 ? 3:1?>"><?=number_format($sum5)?></td>
								</tr>
								<?php if($lv == 1) { ?>
								<tr>
									<th class="table-light" style="width: 150px;">공급가액</th>
									<td><?=number_format(($sum2 - ($lv == 1 && $agcy == 0 ? $sum3:0)) / 1.1)?></td>
									<th class="table-light" style="width: 150px;">세액</th>
									<td colspan="3"><?=number_format(($sum2 - ($lv == 1 && $agcy == 0 ? $sum3:0)) - ($sum2 - ($lv == 1 && $agcy == 0 ? $sum3:0)) / 1.1)?></td>
								</tr>
								<?php } ?>
								<?php if($lv == 2) { ?>
								<tr>
									<th class="table-light" style="width: 150px;">공급가액</th>
									<td><?=number_format(($sum3 - ($lv == 2 && $sell == 0 ? $sum4:0)) / 1.1)?></td>
									<th class="table-light" style="width: 150px;">세액</th>
									<td><?=number_format(($sum3 - ($lv == 2 && $sell == 0 ? $sum4:0)) - ($sum3 - ($lv == 2 && $sell == 0 ? $sum4:0)) / 1.1)?></td>
								</tr>
								<?php } ?>
								<?php if($lv == 3) { ?>
								<tr>
									<th class="table-light" style="width: 150px;">공급가액</th>
									<td><?=number_format(($sum4 - ($lv == 3 && $mngr == 0 ? $sum5:0)) / 1.1)?></td>
									<th class="table-light" style="width: 150px;">세액</th>
									<td><?=number_format(($sum4 - ($lv == 3 && $mngr == 0 ? $sum5:0)) - ($sum4 - ($lv == 3 && $mngr == 0 ? $sum5:0)) / 1.1)?></td>
								</tr>
								<?php } ?>
								<?php if($lv == 4) { ?>
								<tr>
									<th class="table-light" style="width: 150px;">공급가액</th>
									<td><?=number_format($sum5 / 1.1)?></td>
									<th class="table-light" style="width: 150px;">세액</th>
									<td><?=number_format($sum5 - ($sum5 / 1.1))?></td>
								</tr>
								<?php } ?>
							</table>
						</div>
						<div class="search-box">
                            <div class="state-list">
                                <!-- <?=$state?> -->
                                <?php if($lv == 0) { ?>
                                <!-- <input onclick="Search_Page(1);" <?=$state == 0 ? "checked":""?> type="radio" name="state" id="state0" value="0" checked><label for="state0">본사정산</label> -->
                                <input onclick="Search_Page(1);" <?=$state == 1 ? "checked":""?> type="radio" name="state" id="state1" value="1"><label for="state1">총판정산</label>
                                <?php } 
								if ($lv < 2) { ?>
                                <input onclick="Search_Page(1);" <?=$state == 2 ? "checked":""?> type="radio" name="state" id="state2" value="2"><label for="state2">센터정산</label>
								<?php } 
								if ($lv < 3) { ?>
                                <input onclick="Search_Page(1);" <?=$state == 3 ? "checked":""?> type="radio" name="state" id="state3" value="3"><label for="state3">대리점정산</label>
                                <?php } ?>
                                <input onclick="Search_Page(1);" <?=$state == 4 ? "checked":""?> type="radio" name="state" id="state4" value="4"><label for="state4">매니저정산</label>
                            </div>
							<div class="search-form">
                                <?php if($state != 0 && $lv == 0 ) { ?>
								<select name="cntr" name="category" id="" onchange="Search_Page(1);">
									<option value="0" >총판전체</option>
									<!--<option value="1" <?=$cntr == 1 ? "selected":""?>>이엠에스커뮤니케이션즈</option>-->
                                    <?php foreach($cntr_list as $d) { ?>
                                        <option value="<?=$d['agency_no']?>" <?=$cntr == $d['agency_no'] ? "selected":""?>><?=$d['agency_nm']?></option>
                                    <?php } ?>
								</select>
                                <?php } if($state >= 2 && $lv < 2) { ?>
								<select name="agcy" name="category" id="" onchange="Search_Page(1);">
									<option value="0" >센터전체</option>
                                    <?php foreach($agcy_list as $d) { ?>
                                        <option value="<?=$d['agency_no']?>" <?=$agcy == $d['agency_no'] ? "selected":""?>><?=$d['agency_nm']?></option>
                                    <?php } ?>
								</select>
                                <?php } if($state >= 3 && $lv < 3) { ?>
								<select name="sell" name="category" id="" onchange="Search_Page(1);">
									<option value="0" >대리점전체</option>
                                    <?php foreach($sell_list as $d) { ?>
                                        <option value="<?=$d['agency_no']?>" <?=$sell == $d['agency_no'] ? "selected":""?>><?=$d['agency_nm']?></option>
                                    <?php } ?>
								</select>
                                <?php } if($state == 4 && $lv < 4) { ?>
								<select name="mngr" name="category" id="" onchange="Search_Page(1);">
									<option value="0" >매니저전체</option>
                                    <?php foreach($mngr_list as $d) { ?>
                                        <option value="<?=$d['agency_no']?>" <?=$mngr == $d['agency_no'] ? "selected":""?>><?=$d['agency_nm']?></option>
                                    <?php } ?>
								</select>
                                <?php }?>
							</div>
						</div>
					</form>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th style="width: 100px;">날짜</th>
									<?php if($state == 0) { ?>
									<th>총 매출액</th>
									<?php } ?>
									<?php if($state != 0 && $lv==0) { ?>
									<th>총판명</th>
									<?php } ?>
									<?php if($state == 1) { ?>
									<th>센터수</th>
									<?php } ?>
									<?php if($lv < 2 && $state == 2) { ?>
									<th>센터명</th>
									<th>대리점수</th>
									<?php } ?>
									<?php if($lv < 2 && $state >= 3) { ?>
									<th>센터명</th>
									<?php } ?>
									<?php if($lv < 3 && $state == 3) { ?>
									<th>대리점명</th>
									<th>매니저수</th>
									<?php } ?>
									<?php if($lv < 3 && $state >= 4) { ?>
									<th>대리점명</th>
									<?php } ?>
									<?php if($lv != 4 && $state == 4) { ?>
									<th>매니저명</th>
									<th>사장님수</th>
									<?php } ?>
									<th>캠페인</th>
									<th>월정액</th>
									<!--<th>정산액C</th>-->
									<th>합계</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php if($list_data == null) {?>
										<tr>
											<td colspan="10">조회된 정보가 없습니다.</td>
										</tr>
									<?php } else {
										foreach($list_data as $d) { ?>
										<tr>
											<td><?=$rownum?></td>
											<td><?=$d['reg_date']?></td>
											<?php if($state == 0) { ?>
											<td></td>
											<?php } ?>
											<?php if($state != 0 && $lv==0) { ?>
											<td><?=$d['cntr_nm'] == null ? "본사":$d['cntr_nm']?></td>
											<?php } ?>
											<?php if($state == 1) { 
												$agcy = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 2 AND distributor_no = ".$d['agency_no'], $param);	?>
											<td><?=number_format($agcy)?></td>
											<?php } ?>
											<?php if($lv < 2 && $state == 2) { 
													$sell = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 3 AND top_agency_no = ".$d['agency_no'], $param);
												?>
											<td><?=$d['agcy_nm'] == null ? "본사":$d['agcy_nm']?></td>
											<td><?=number_format($sell)?></td>
											<?php } ?>
											<?php if($lv < 2 && $state >= 3) { ?>
											<td><?=$d['agcy_nm'] == null ? "본사":$d['agcy_nm']?></td>
											<?php } ?>
											<?php if($lv < 3 && $state == 3) { 
													$mngr = $pdo->single("SELECT count(*) FROM agency_info WHERE agency_state = 1 AND grade = 4 AND mid_agency_no = ".$d['agency_no'], $param);
												?>
											<td><?=$d['sell_nm'] == null ? "본사":$d['sell_nm']?></td>
											<td><?=number_format($mngr)?></td>
											<?php } ?>
											<?php if($lv < 3 && $state >= 4) { ?>
											<td><?=$d['sell_nm'] == null ? "본사":$d['sell_nm']?></td>
											<?php } ?>
											<?php if($lv != 4 && $state == 4) { 
												$ceo = $pdo->single("SELECT count(*) FROM ceo_info WHERE mng_code = '".$d['code']."'", $param);		
											?>
											<td><?=$d['mngr_nm'] == null ? "본사":$d['mngr_nm']?></td>
											<td><?=number_format($ceo)?></td>
											<?php } ?>
											<td><?=number_format($d['amt1'])?></td>
											<td><?=number_format($d['amt2'])?></td>
											<!--<td><?=number_format($d['amt3'],1)?></td>-->
											<td><?=number_format(($d['amt1'] + $d['amt2']))?></td>
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
									echo "<li><a  href='calculate.php?page=1&state=$state&date=$date&cntr=$cntr&agcy=$agcy' aria-label='Previous'><<</a></li>";
								} else {
									echo "<li><a  href='calculate.php?page=1&state=$state&date=$date&cntr=$cntr&agcy=$agcy' aria-label='Previous'><<</a></li>";
								}
							}
							for($i = $block_start; $i <= $block_end; $i++){
								if($page == $i){
									echo "<li class='on'><a href=''> $i </a></li>";
								} else {
									if(isset($unum)){
										echo "<li><a  href='calculate.php?page=$i&state=$state&date=$date&cntr=$cntr&agcy=$agcy'> $i </a></li>";
									} else {
										echo "<li><a  href='calculate.php?page=$i&state=$state&date=$date&cntr=$cntr&agcy=$agcy'> $i </a></li>";
									}
								}
							}
							if($page >= $total_page){
								// 빈 값
							} else {
								if(isset($unum)){
									echo "<li><a   href='calculate.php?page=$total_page&state=$state&date=$date&cntr=$cntr&agcy=$agcy'>>></a>";
								} else {
									echo "<li><a   href='calculate.php?page=$total_page&state=$state&date=$date&cntr=$cntr&agcy=$agcy'>>></a>";
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