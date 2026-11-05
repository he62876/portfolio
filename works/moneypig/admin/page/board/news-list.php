<?php
include('../../lib/header.php');
include('../../../common.php');
include('../../lib/menu.php');

$category = (isset($_GET["category"])? $_GET["category"]: 0);
$keyword = (isset($_GET["keyword"])? $_GET["keyword"]: "");

$param = null;
$param1 = null;

$where = '';

if($category == 1) {
    $where .= " AND news_title LIKE '%".$keyword."%' ";
}
if($category == 2) {
    $where .= " AND news_content LIKE '%".$keyword."%' ";
}


//페이징 기본 변수 설정
$page = (!isset($_GET['page']) ? "1":$_GET['page']);
$list = 10; // 페이지당 보여줄 게시글 수
$block = 5; // 하단에 보여줄 페이지 블럭 수

//전체 게시글 수 구하기
$sql = "SELECT count(*) as cnt FROM news_info WHERE use_yn = 1".$where;
$total_count = $pdo->query($sql)->fetchColumn();

//전체 페이지 수 및 시작 위치 계산
$total_page = ceil($total_count / $list); // 전체 페이지 수 (올림)
$start = ($page - 1) * $list; // LIMIT 시작 위치 


$sql = "SELECT * FROM news_info WHERE use_yn = 1".$where." ORDER BY reg_date DESC LIMIT $start, $list";
$list_data = $pdo->query($sql, $param);

$rownum = $total_count - $start;
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
					<h6 class="title-strong">소식관리</h6>
				</div>
				<div class="card-body">
					<form action="news-list.php" id='SearchForm' method="GET">
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
									<th>제목</th>
									<th style="width: 100px;">등록일</th>
									<th style="width: 80px;">조회수</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<?php if($list_data == null) {?>
										<tr>
											<td colspan="5">조회된 정보가 없습니다.</td>
										</tr>
									<?php } else {
										foreach($list_data as $d) { ?>
										<tr>
											<td><?=$rownum?></td>
											<td><a href="news-info.php?news_no=<?=$d['news_no']?>" style="font-weight: 500; text-decoration:underline;"><?=stripslashes($d['news_title'])?></a></td>
											<td><?=substr($d['reg_date'],0,10)?></td>
											<td><?=number_format($d['hit'])?></td>
										</tr>
									<?php $rownum--; }
									}?>
								</tr>
							</tbody>
						</table>
					</div>
                    <?php
                    $block_start = floor(($page - 1) / $block) * $block + 1; // 블럭의 시작 페이지
                    $block_end = $block_start + $block - 1; // 블럭의 마지막 페이지

                    if ($block_end > $total_page) {
                        $block_end = $total_page; // 마지막 블럭이 총 페이지 수를 넘지 않도록
                    }
                    ?>

                    <ul class="page-list">
                        <?php if ($page > 1): ?>
                            <li><a href="?page=1">[처음]</a></li>
                            <li><a href="?page=<?= $page - 1 ?>">[이전]</a></li>
                        <?php endif; ?>

                        <?php for ($i = $block_start; $i <= $block_end; $i++): ?>
                            <?php if ($i == $page): ?>
                                <li class='on'><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php else: ?>
                                <li class='on'><a href="?page=<?= $i ?>"><?= $i ?></a></li>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $total_page): ?>
                            <li><a href="?page=<?= $page + 1 ?>">[다음]</a></li>
                            <li><a href="?page=<?= $total_page ?>">[마지막]</a></li>
                        <?php endif; ?>
                    </ul>
					<?php if($lv == 0) { ?>
					<div class="btn-box">
						<a href="news-info.php">등록</a>
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