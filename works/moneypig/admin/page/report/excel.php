<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head>
<?php
include('../../../common.php');

ob_start();

// header( "Content-type: application/vnd.ms-excel;charset=UTF-8");
// header( "Expires: 0" );
// header( "Cache-Control: must-revalidate, post-check=0,pre-check=0" );
// header( "Pragma: public" );
// header( "Content-Disposition: attachment; filename=".date('Ymd_Hms').".xls" );

header( "Content-type: application/vnd.ms-excel; charset=utf-8");
header( "Content-Disposition: attachment; filename=moneypig".date('Ymd_Hms').".xls" );     //filename = 저장되는 파일명을 설정합니다.
header( "Content-Description: PHP4 Generated Data" );



    $param=null;
    $month = $_REQUEST['month'];
	//$day_count = date('t', strtotime($month."-01"));



	$where = '';
	if($month > 0) {
		$where = " AND DATE_FORMAT(a.up_reg_date, '%Y-%m') = '".$month."'";
		$where1 = " AND DATE_FORMAT(a.reg_date, '%Y-%m') = '".$month."'";
	}

    // if($sdate > 0) {
    //     $where .= " WHERE DATE_FORMAT(reg_date, '%Y-%m') >= '".$sdate."'";
    // }
    // if($sdate > 0 && $edate > 0) {
    //     $where .= " AND DATE_FORMAT(reg_date, '%Y-%m') <= '".$edate."'";
    // }
    // else if ($edate > 0) {
    //     $where .= " WHERE DATE_FORMAT(reg_date, '%Y-%m') <= '".$edate."'";
    // }
	
	//$SQL = "SELECT acnt.up_reg_date, count(DATE_FORMAT(acnt.up_reg_date, '%Y%m')) as cnt FROM ( SELECT a.up_reg_date, DATE_FORMAT(a.up_reg_date, '%Y%m') FROM cash_req a
	//		LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	//		WHERE a.req_state = 1".$where."   GROUP BY b.biz_num, DATE_FORMAT(a.up_reg_date, '%Y%m')) as acnt";

	$SQL = "SELECT count(DISTINCT ORN_DT.biz_num) as cnt 
	FROM
	(
	SELECT sum(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m') as reg_date, b.address as address, b.biz_num as biz_num, b.real_store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'campaign' as name FROM store_campaign_pay a
	LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	WHERE a.pay_state = 2 AND a.distributor_no = 1 AND a.agency_no IS NULL AND a.seller_no IS NULL AND a.manager_no IS NULL ".$where1." GROUP BY biz_num, reg_date
	UNION ALL
	SELECT sum(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m') as reg_date, b.address as address, b.biz_num as biz_num, b.real_store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'expense' as name FROM store_expense_pay a
	LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	WHERE a.pay_state = 1 AND a.distributor_no = 1 AND a.agency_no = 0 AND a.seller_no = 0 AND a.manager_no = 0 ".$where1." GROUP BY biz_num, reg_date) AS ORN_DT
	";
    $cnt = $pdo->row($SQL, $param);

    //$SQL = "SELECT *, count(CASE WHEN req_type = 1 THEN 1 END) as cnt, count(CASE WHEN req_type = 2 THEN 1 END) as cnt1, sum(CASE WHEN req_type = 1 THEN fee_amt END) as sum, sum(CASE WHEN req_type = 2 THEN fee_amt END) as sum1, DATE_FORMAT(a.up_reg_date, '%y%m') as reg_date, DATE_FORMAT(a.up_reg_date, '%Y-%m') as month FROM cash_req a
	//		LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	//		LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	//		WHERE a.req_state = 1".$where." GROUP BY b.biz_num, DATE_FORMAT(a.up_reg_date, '%Y%m')";
    //$list_data = $pdo->query($SQL, $param);

	//동네광고
	/*
	UNION ALL
	SELECT sum(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m') as reg_date, b.address as address, b.biz_num as biz_num, b.real_store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'ad' as name FROM push_pay_log a
	LEFT OUTER JOIN ad_info d ON a.ad_no = d.ad_no
	LEFT OUTER JOIN store_info b ON d.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON a.ceo_no = c.ceo_no
	WHERE a.use_yn = 1 ".$where1." GROUP BY biz_num, reg_date
	
	UNION ALL
	SELECT sum(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m') as reg_date, DATE_FORMAT(a.reg_date, '%y%m') as reg_date1, b.address as address, b.biz_num as biz_num, b.store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'ad' as name FROM push_pay_log a
	LEFT OUTER JOIN ad_info d ON a.ad_no = d.ad_no
	LEFT OUTER JOIN store_info b ON d.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON a.ceo_no = c.ceo_no
	WHERE a.use_yn = 1 ".$where1." GROUP BY biz_num, reg_date

	
	//수수료
	SELECT sum(a.fee_amt) as sum, DATE_FORMAT(a.up_reg_date, '%Y-%m') as reg_date, b.address as address, b.biz_num as biz_num, b.real_store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'cash' as name FROM cash_req a
	LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	WHERE a.req_state = 1 ".$where." GROUP BY biz_num, reg_date
	UNION ALL

	SELECT sum(a.fee_amt) as sum, DATE_FORMAT(a.up_reg_date, '%Y-%m') as reg_date, DATE_FORMAT(a.up_reg_date, '%y%m') as reg_date1, b.address as address, b.biz_num as biz_num, b.store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'cash' as name FROM cash_req a
	LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	WHERE a.req_state = 1 ".$where." GROUP BY biz_num, reg_date
	UNION ALL
	*/

	$SQL = "SELECT ORN_DT.reg_date as month, ORN_DT.reg_date1 as reg_date,
	SUM(CASE WHEN ORN_DT.name = 'campaign' THEN ORN_DT.sum ELSE 0 END) AS sum3,
	SUM(CASE WHEN ORN_DT.name = 'expense' THEN ORN_DT.sum ELSE 0 END) AS sum4,
	ORN_DT.address as address, ORN_DT.biz_num as biz_num, ORN_DT.real_store_name as real_store_name, ORN_DT.ceo_name as ceo_name, ORN_DT.ceo_email as ceo_email
	FROM
	(
	SELECT sum(a.amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m') as reg_date, DATE_FORMAT(a.reg_date, '%y%m') as reg_date1, b.address as address, b.biz_num as biz_num, b.store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'campaign' as name FROM store_campaign_pay a
	LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	WHERE a.pay_state = 2 AND a.distributor_no = 1 AND a.agency_no IS NULL AND a.seller_no IS NULL AND a.manager_no IS NULL ".$where1." GROUP BY biz_num, reg_date
	UNION ALL
	SELECT sum(a.toss_amt) as sum, DATE_FORMAT(a.reg_date, '%Y-%m') as reg_date, DATE_FORMAT(a.reg_date, '%y%m') as reg_date1, b.address as address, b.biz_num as biz_num, b.store_name as real_store_name, c.ceo_name as ceo_name, c.ceo_email as ceo_email, 'expense' as name FROM store_expense_pay a
	LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
	LEFT OUTER JOIN ceo_info c ON b.ceo_no = c.ceo_no
	WHERE a.pay_state = 1 AND a.distributor_no = 1 AND a.agency_no = 0 AND a.seller_no = 0 AND a.manager_no = 0 ".$where1." GROUP BY biz_num, reg_date
	) AS ORN_DT
	GROUP BY ORN_DT.biz_num, ORN_DT.reg_date";
    $list_data = $pdo->query($SQL, $param);



    // 테이블 상단 만들기
    $EXCEL_STR .= "
    <table border='1'>";
    
    if($list_data == null) {
        $EXCEL_STR .= "
        <tr>
             <td colspan='6'>조회된 데이터가 없습니다.</td>
        </tr>
        ";
    } else {
        foreach($list_data as $d) {
			$day_count = date('t', strtotime($d['month']."-01"));
           $EXCEL_STR .= "
           <tr>
				<td style=mso-number-format:'\@'>01</td>
        		<td>".$d['reg_date'].$day_count."</td>";
			if($cnt['cnt'] <= 100) {
           $EXCEL_STR .= "
				<td>5148154213</td>
				<td></td>
				<td>㈜이엠에스커뮤니케이션즈</td>
				<td>문명화</td>
				<td>대구광역시 남구 명덕로 54, 3층(대명동)</td>
				<td></td>
				<td></td>
				<td></td>
		   ";
			}
           $EXCEL_STR .= "
        		<td style=mso-number-format:'\@'>".$d['biz_num']."</td>
				<td></td>
        		<td>".$d['real_store_name']."</td>
        		<td>".$d['ceo_name']."</td>
        		<td>".$d['address']."</td>
				<td></td>
				<td></td>
        		<td>".$d['ceo_email']."</td>
				<td></td>
        		<td>".round(($d['sum3'] + $d['sum4']) / 1.1)."</td>
        		<td>".round(($d['sum3'] + $d['sum4']) - (($d['sum3'] + $d['sum4']) / 1.1))."</td>
				<td></td>
        		<td>".$day_count."</td>
				<td>돈되지 서비스 이용료</td>
				<td></td>
				<td></td>
				<td></td>
        		<td>".round(($d['sum3'] + $d['sum4']) / 1.1)."</td>
        		<td>".round(($d['sum3'] + $d['sum4']) - (($d['sum3'] + $d['sum4']) / 1.1))."</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td style=mso-number-format:'\@'>01</td>
           </tr>
           ";
        }
    }
    $EXCEL_STR .= "</table>";


ob_end_clean();


echo "<meta content=\"application/vnd.ms-excel;charset=UTF-8;\" name=\"Content-type\">";
echo $EXCEL_STR;

?>