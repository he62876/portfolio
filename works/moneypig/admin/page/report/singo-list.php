<?php
include('../../lib/header.php'); 
include('../../../common.php'); 
include('../../lib/menu.php'); 

if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$category = (isset($_GET["category"])? $_GET["category"]: 0);
$keyword = (isset($_GET["keyword"])? $_GET["keyword"]: "");
$state = (isset($_GET["state"])? $_GET["state"]: "");

$param = null;
$param1 = null;

$where = '';

if($category == 1) {
    $where = " AND d.ceo_name LIKE '%".$keyword."%' ";
}

if($state > 0) {
    if($state == 1) {
        $where .= " AND member_state = '1' ";
    }
    else if($state == 10) {
        $where .= " AND member_state = '0' ";
    }
}



$cnt1 = $pdo->single("SELECT count(*) FROM user_singo a
		LEFT OUTER JOIN member_info b ON a.member_no = b.member_no
		LEFT OUTER JOIN store_info c ON a.store_no = c.store_no
		LEFT OUTER JOIN ceo_info d ON c.ceo_no = d.ceo_no WHERE a.use_yn = 1".$where, $param1);
$cnt2 = $pdo->single("SELECT count(*) FROM campaign_singo a
		LEFT OUTER JOIN member_info b ON a.member_no = b.member_no
		LEFT OUTER JOIN store_info c ON a.store_no = c.store_no
		LEFT OUTER JOIN ceo_info d ON c.ceo_no = d.ceo_no WHERE a.use_yn = 1".$where, $param1);
//$list_cnt = $pdo->row($sql, $param1);
$cnt = $cnt1 + $cnt2;
$start=$cnt - ((($page - 1) * 10) + 9);
if($start<0){
	$start =0;
}
$param["s"] = $start;
$param["e"] = $cnt - (($page - 1) * 10);



///////////////////////      페이지 구현      //////////////////////////
$total_record = $cnt; // 불러올 게시물 총 개수
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


$sql = "SELECT *, a.reg_date as reg_date, code1.name as name1, code2.name as name2 FROM
		(SELECT req_no as req_no, member_no as member_no, store_no as store_no, singo_why as singo_why, use_yn as use_yn, reg_date as reg_date, 'type1' as type FROM user_singo
		UNION ALL 
		SELECT campaign_no as req_no, member_no as member_no, store_no as store_no, singo_why as singo_why, use_yn as use_yn, reg_date as reg_date, 'type2' as type FROM campaign_singo) AS  a
		LEFT OUTER JOIN member_info b ON a.member_no = b.member_no
		LEFT OUTER JOIN store_info c ON a.store_no = c.store_no
		LEFT OUTER JOIN ceo_info d ON c.ceo_no = d.ceo_no
		LEFT OUTER JOIN code_info code1 ON a.singo_why = code1.minr AND code1.majr = 8 AND a.type = 'type1'
		LEFT OUTER JOIN code_info code2 ON a.singo_why = code2.minr AND code2.majr = 13 AND a.type = 'type2'
		WHERE a.use_yn = 1 ".$where." ORDER BY a.reg_date DESC LIMIT $page_start, $list";
$list_data = $pdo->query($sql, $param);

$rownum = $total_record - $page_start;
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
                    <form action="singo-list.php" id='SearchForm' method="GET">
                        <input type="hidden" name="page" id='ContetCurrentPage' value='<?=$page?>'>
                        <div class="search-box">
                            <div class="state-list">
                                <!-- <?=$state?> -->
                                <input onclick="return Search_Page(1);" <?=$state == 0 ? "checked":""?> type="radio" name="state" id="state0" value="0" checked><label for="state0">전체</label>
                                <!--<input onclick="return Search_Page(1);" <?=$state == 1 ? "checked":""?> type="radio" name="state" id="state1" value="1"><label for="state1">정상</label>
                                <input onclick="return Search_Page(1);" <?=$state == 10 ? "checked":""?> type="radio" name="state" id="state2" value="10"><label for="state2">탈퇴</label>-->
                            </div>
                            <div class="search-form">
                                <select name="category" id="">
                                    <option value="1" <?=$category == 1 ? "selected":""?>>대표자명</option>
                                    <option value="2" <?=$category == 2 ? "selected":""?>>닉네임</option>
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
                                    <th>분류</th>
                                    <th>신고대상</th>
                                    <th>신고자</th>
                                    <th>신고사유</th>
                                    <th style="width: 100px;">신고날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($list_data == null) { ?>
                                    <tr>
                                        <td colspan="6">조회된 정보가 없습니다.</td>
                                    </tr>
                                <?php } else {
                                    foreach($list_data as $d) {
										?>
                                    <tr>
										<td><?=$rownum?></td>
										<td><?=$d['type'] == "type1" ? "내돈내산":"체험단"?></td>
										<td><a href="../user/user-info.php?member_no=<?=$d['member_no']?>" style="font-weight: 500; text-decoration:underline;"><?=$d['member_name']?></a></td>
										<td><a href="../user/shop-info.php?ceo_no=<?=$d['ceo_no']?>" style="font-weight: 500; text-decoration:underline;"><?=$d['ceo_name']?></a></td>
										<td><a href="singo-info.php?req_no=<?=$d['req_no']?>&type=<?=$d['type']?>" style="font-weight: 500; text-decoration:underline;"><?=$d['name1']?><?=$d['name2']?></a></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
                                    </tr>
                                <?php $rownum--; }
                                } ?>
                                <tr>
                            </tbody>
                        </table>
                    </div>
                    <ul class="page-list">
                        <?php
                            if ($page <= 1){
                                // 빈 값
                            } else {
                                if(isset($unum)){
                                    echo "<li><a  href='singo-list.php?page=1&category=$category&keyword=$keyword&state=$state' aria-label='Previous'><<</a></li>";
                                } else {
                                    echo "<li><a  href='singo-list.php?page=1&category=$category&keyword=$keyword&state=$state' aria-label='Previous'><<</a></li>";
                                }
                            }
                            for($i = $block_start; $i <= $block_end; $i++){
                                if($page == $i){
                                    echo "<li class='on'><a href=''> $i </a></li>";
                                } else {
                                    if(isset($unum)){
                                        echo "<li><a  href='singo-list.php?page=$i&category=$category&keyword=$keyword&state=$state'> $i </a></li>";
                                    } else {
                                        echo "<li><a  href='singo-list.php?page=$i&category=$category&keyword=$keyword&state=$state'> $i </a></li>";
                                    }
                                }
                            }
                            if($page >= $total_page){
                                // 빈 값
                            } else {
                                if(isset($unum)){
                                    echo "<li><a   href='singo-list.php?page=$total_page&category=$category&keyword=$keyword&state=$state'>>></a>";
                                } else {
                                    echo "<li><a   href='singo-list.php?page=$total_page&category=$category&keyword=$keyword&state=$state'>>></a>";
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