<?php
include('../../../common.php');
include('../../lib/header.php');
include('../../lib/menu.php');

$noti_no = $_GET['noti_no'] == null ? 0:$_GET['noti_no'];

$param = null;

$sql = "SELECT * FROM notice_info WHERE noti_no = ".$noti_no;
$data = $pdo->row($sql, $param);

$rs = $pdo->query("UPDATE notice_info SET hit = hit + 1 WHERE noti_no = ".$noti_no);

?>
<style>
    .table td {
        text-align: left;
        
    }

    .card {
        min-height: 80vh;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h6 class="title-strong">공지사항</h6>
				</div>
				<div class="card-body">
					<form action="json.php" id="inputForm" method="POST"  onsubmit="return myFunction();">
						<input type="hidden" name="board" value="notice">
						<input type="hidden" name="mode" value="<?=$noti_no == 0 ? 'input':'update'?>">
						<?php if($noti_no != 0) { ?>
							<input type="hidden" name="no" value="<?=$noti_no?>">
						<?php } ?>
						<div class="table-responsive">
							<table class="table info-table">
								<tbody>
									<tr>
										<th class="table-light" style="width: 150px;">글제목</th>
										<td>
											<?=stripslashes($data['noti_sj'])?>
										</td>
									</tr>
									<tr>
										<th class="table-light">내용</th>
										<td>
											<div style="white-space: normal;font-size:14px;">
											<?=stripslashes(nl2br($data['noti_cont']))?>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="btn-box">
							<a href="noti-list.php">목록</a>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>