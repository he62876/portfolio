<?php
include('../../../common.php');
include('../../lib/header.php');
include('../../lib/menu.php');

// $page = ($_GET['page'] == null ? "1":$_GET['page']);
$category = (isset($_GET["category"])? $_GET["category"]: 0);
$keyword = (isset($_GET["keyword"])? $_GET["keyword"]: "");

$param = null;
$param1 = null;

$where = '';

if($category == 1) {
    $where .= " AND noti_sj LIKE '%".$keyword."%' ";
}
if($category == 2) {
    $where .= " AND noti_cont LIKE '%".$keyword."%' ";
}

if($lv > 0) {
	if($lv == 1) {
		$where .= " AND gbn LIKE '%4%'";
	}
	if($lv == 2) {
		$where .= " AND gbn LIKE '%5%'";
	}
	if($lv == 3) {
		$where .= " AND gbn LIKE '%6%'";
	}
	if($lv == 4) {
		$where .= " AND gbn LIKE '%7%'";
	}
}

if($lv == 1) {
	$where .=" AND a.distributor_no = ".$_SESSION['no'];
}

//페이징 기본 변수 설정
$page = (!isset($_GET['page']) ? "1":$_GET['page']);
$list = 10; // 페이지당 보여줄 게시글 수
$block = 5; // 하단에 보여줄 페이지 블럭 수

//전체 게시글 수 구하기
$sql = "SELECT count(*) as cnt FROM notice_info WHERE use_yn = 1".$where;
$total_count = $pdo->query($sql)->fetchColumn();

//전체 페이지 수 및 시작 위치 계산
$total_page = ceil($total_count / $list); // 전체 페이지 수 (올림)
$start = ($page - 1) * $list; // LIMIT 시작 위치 



$sql = "SELECT * FROM notice_info WHERE use_yn = 1".$where." ORDER BY reg_date DESC LIMIT $start, $list";
$list_data = $pdo->query($sql, $param);

$rownum = $total_count - $start;

$timestamp = strtotime("-3 days");
$new = date("Y-m-d", $timestamp);
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
					<h6 class="title-strong">공지사항</h6>
				</div>
				<div class="card-body">
					<form action="noti-list.php" id='SearchForm' method="GET">
						<input type="hidden" name="page" id='ContetCurrentPage' value='<?=$page?>'>
						<div class="search-box">
							<div class="state-list">
								<input type="radio" name="state" id="state0" checked><label for="state0">전체</label>
								<!-- <input type="radio" name="state" id="state1"><label for="state1">상가</label>
								<input type="radio" name="state" id="state2"><label for="state2">전문가</label>
								<input type="radio" name="state" id="state3"><label for="state3">사용자</label> -->
							</div>
							<div class="search-form">
								<select name="category" id="">
									<option value="1" <?=$category == 1 ? "selected":""?>>제목</option>
									<option value="2" <?=$category == 2 ? "selected":""?>>내용</option>
								</select>
								<input type="text" name="keyword" value="<?=$keyword?>">
								<button onclick="return Search_Page(1);">검색</button>
							</div>
						</div>
					</form>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<?php if($lv == 0) {?>
									<th style="width: 100px;">권한</th>
									<?php } ?>
									<th>제목</th>
									<th style="width: 100px;">등록일</th>
									<th style="width: 80px;">조회수</th>
								</tr>
							</thead>
							<tbody>
									<?php if($total_count == 0) {?>
										<tr>
											<td colspan="5">조회된 정보가 없습니다.</td>
										</tr>
									<?php } else {
										foreach($list_data as $d) {
											${'gbn_list'.$d['noti_no']} = explode(",", $d['gbn']);
											foreach(${'gbn_list'.$d['noti_no']} as $gbn_nm) {
												$grade = array(1=>'전체', 2=>'사용자', 3=>'업체사장님', 4=>'총판', 5=>'센터', 6=>'대리점', 7=>'매니저');
												${'arr'.$d['noti_no']}[] = $grade[$gbn_nm]; 
											}
											$gbn = implode(", ", ${'arr'.$d['noti_no']});
										?>
										<tr>
											<td><?=$rownum?></td>
											<?php if($lv == 0) {?>
											<td><?=$gbn?></td>
											<?php } ?>
											<td><a href="noti-<?=$lv == 0 ? "write":"info"?>.php?noti_no=<?=$d['noti_no']?>" style="font-weight: 500; text-decoration:underline;"><?=$new < substr($d['reg_date'],0,10) && $lv > 0 ? "<span style='color:#ff0000'>new </span>":""?><?=$d['noti_sj']?></a></td>
											<td><?=substr($d['reg_date'],0,10)?></td>
											<td><?=number_format($d['hit'])?></td>
										</tr>
									<?php $rownum--; }
									}?>
							</tbody>
						</table>
					</div>
					<ul class="page-list">
						<?php
							if ($page <= 1){
								// 빈 값
							} else {
								if(isset($unum)){
									echo "<li><a  href='noti-list.php?page=1&category=$category&keyword=$keyword' aria-label='Previous'><<</a></li>";
								} else {
									echo "<li><a  href='noti-list.php?page=1&category=$category&keyword=$keyword' aria-label='Previous'><<</a></li>";
								}
							}
							for($i = $block_start; $i <= $block_end; $i++){
								if($page == $i){
									echo "<li class='on'><a href=''> $i </a></li>";
								} else {
									if(isset($unum)){
										echo "<li><a  href='noti-list.php?page=$i&category=$category&keyword=$keyword'> $i </a></li>";
									} else {
										echo "<li><a  href='noti-list.php?page=$i&category=$category&keyword=$keyword'> $i </a></li>";
									}
								}
							}
							if($page >= $total_page){
								// 빈 값
							} else {
								if(isset($unum)){
									echo "<li><a   href='noti-list.php?page=$total_page&category=$category&keyword=$keyword'>>></a>";
								} else {
									echo "<li><a   href='noti-list.php?page=$total_page&category=$category&keyword=$keyword'>>></a>";
								}
							}
						?> 
					</ul>
					<?php if($lv == 0) { ?>
					<div class="btn-box">
						<a href="noti-write.php">등록</a>
					</div>
					<?php } ?>
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
	if($('input[name="keyword"]').val().match("\'")) {
		alert('검색어를 확인하세요.');
		return false;
	}
	 
	else { 

	if(n == "#") return;
	$("#ContetCurrentPage").val(n);
	$("#SearchForm").submit();//GetRow_item();

	}
}


</script>