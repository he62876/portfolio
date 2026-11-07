<?php
include('../../lib/header.php'); 
include('../../../common.php');
include('../../lib/menu.php'); 

if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}


$param = null;

$req_no = $_GET['req_no'] == null ? 0 : $_GET['req_no'];
$type = $_GET['type'] == null ? 0 : $_GET['type'];
if($req_no != 0) {
	if($type == 'type1') {
		$sql = "SELECT *, a.reg_date as reg_date, code.name as name FROM user_singo a
				LEFT OUTER JOIN member_info b ON a.member_no = b.member_no
				LEFT OUTER JOIN store_info c ON a.store_no = c.store_no
				LEFT OUTER JOIN ceo_info d ON c.ceo_no = d.ceo_no
				LEFT OUTER JOIN code_info code ON a.singo_why = code.minr AND code.majr = 8
				WHERE a.req_no = ".$req_no;
	} else if($type == 'type2'){
		$sql = "SELECT *, a.reg_date as reg_date, code.name as name FROM campaign_singo a
				LEFT OUTER JOIN member_info b ON a.member_no = b.member_no
				LEFT OUTER JOIN store_info c ON a.store_no = c.store_no
				LEFT OUTER JOIN ceo_info d ON c.ceo_no = d.ceo_no
				LEFT OUTER JOIN code_info code ON a.singo_why = code.minr AND code.majr = 13
				WHERE a.campaign_no = ".$req_no;
	}
	$data = $pdo->row($sql, $param);
}
?>
<style>

    .card {
        min-height: 80vh;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h6 class="title-strong">신고관리</h6>
                </div>
                <div class="card-body">
					<strong>기본정보</strong>
					<div class="table-responsive">
						<table class="table info-table">
							<tbody>
								<tr>
									<th class="table-light" style="width: 150px;">신고대상</th>
									<td><?=$data['member_name']?></td>
									<th class="table-light" style="width: 150px;">신고자</th>
									<td><?=$data['ceo_name']?></td>
									<th class="table-light" style="width: 150px;">신고일</th>
									<td><?=substr($data['reg_date'],0,10)?></td>
								</tr>
								<tr>
									<th class="table-light">신고사유</th>
									<td colspan="5"><?=$data['name']?></td>
								</tr>
								<tr>
									<th class="table-light">상세정보</th>
									<td colspan="5"><?=$data['singo_memo']?></td>
								</tr>
							</tbody>
						</table>
					</div>
                    <div class="btn-box">
                        <a href="singo-list.php">목록</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>