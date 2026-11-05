<?php
include('../../lib/header.php'); 
include('../../../common.php'); 
include('../../lib/menu.php'); 

if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$category = (isset($_GET["category"])? $_GET["category"]: 1);
$keyword = (isset($_GET["keyword"])? $_GET["keyword"]: "");
$state = (isset($_GET["state"])? $_GET["state"]: 1);
$type = (isset($_GET["type"])? $_GET["type"]: "");

$param = null;
$param1 = null;

$where = '';

if($category == 1) {
    $where .= " WHERE member_name LIKE '%".$keyword."%' ";
}

if($state > 0) {
    if($state == 1) {
        $where .= " AND member_state = 1 ";
    }
    else if($state == 10) {
        $where .= " AND member_state = 0 ";
    }
    else if($state == 9) {
        $where .= " AND member_state = 9 ";
    }
}

if($type > 0) {
    $where .= " AND memb_type = ".$type;
}


$sql = "SELECT count(*) as cnt FROM member_info".$where;
$list_cnt = $pdo->row($sql, $param1);
$cnt = $list_cnt['cnt'];
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


$sql = "SELECT *,AES_DECRYPT(UNHEX(address),KEY) as member_address FROM member_info ".$where." ORDER BY reg_date DESC LIMIT $page_start, $list";
$list_data = $pdo->query($sql, $param);

$type_nm = array(1=>"kakao", 2=>"google", 3=>"apple");
$state_nm = array(1=>"정상", 0=>"탈퇴", 9=>"정지");

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
                    <h6 class="title-strong">회원관리</h6>
                </div>
                <div class="card-body">
                    <form action="user-list.php" id='SearchForm' method="GET">
                        <input type="hidden" name="page" id='ContetCurrentPage' value='<?=$page?>'>
                        <div class="search-box">
                            <div class="state-list">
                                <!-- <?=$state?> -->
                                <input onclick="return Search_Page(1);" <?=$state == 0 ? "checked":""?> type="radio" name="state" id="state0" value="0" checked><label for="state0">전체</label>
                                <input onclick="return Search_Page(1);" <?=$state == 1 ? "checked":""?> type="radio" name="state" id="state1" value="1"><label for="state1">정상</label>
                                <input onclick="return Search_Page(1);" <?=$state == 10 ? "checked":""?> type="radio" name="state" id="state2" value="10"><label for="state2">탈퇴</label>
                                <input onclick="return Search_Page(1);" <?=$state == 9 ? "checked":""?> type="radio" name="state" id="state3" value="9"><label for="state3">정지</label>
                            </div>
                            <div class="search-form">
								<select onchange="return Search_Page(1);" name="type">
                                    <option value="0" <?=$type == 0 ? "selected":""?>>전체</option>
                                    <option value="1" <?=$type == 1 ? "selected":""?>>일반회원</option>
                                    <option value="2" <?=$type == 2 ? "selected":""?>>인플루언서회원</option>
								</select>
                                <select name="category" id="">
                                    <option value="1" <?=$category == 1 ? "selected":""?>>이름</option>
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
                                    <th style="width: 100px;">분류</th>
                                    <th>이름</th>
									<th style="width: 100px;">지역</th>
                                    <th style="width: 100px;">OS타입</th>
                                    <th style="width: 100px;">포인트적립금</th>
                                    <th style="width: 80px;">쿠폰수</th>
                                    <th style="width: 100px;">가입일</th>
                                    <th style="width: 80px;">상태</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($list_data == null) { ?>
                                    <tr>
                                        <td colspan="8">조회된 정보가 없습니다.</td>
                                    </tr>
                                <?php } else {
                                    foreach($list_data as $d) {
										$date = Date('Y-m-d');
										$cupon = $pdo->single("SELECT count(*) FROM cupon_down_info a LEFT OUTER JOIN cupon_info c ON a.cupon_no = c.cupon_no WHERE '".$date."' BETWEEN c.from_date AND c.to_date AND a.state = 1 AND a.member_no = ".$d['member_no'], $param);
										$amt = $pdo->query("SELECT sum_cash_amt FROM user_cash_log WHERE member_no = ".$d['member_no'], $param);
										foreach($amt as $amt) {
											${'member_amt'.$d['member_no']} += $amt['sum_cash_amt'];
										}
										$address = explode(' ' , $d['member_address']); 
										?>
                                    <tr>
										<td><?=$rownum?></td>
										<td><?=$d['memb_type'] == 1 ? "일반회원":"인플루언서회원"?></td>
										<td><a href="user-info.php?member_no=<?=$d['member_no']?>" style="font-weight: 500; text-decoration:underline;"><?=$d['member_name']?></a></td>
										<td><?=$address[0]=="서울시"? "미입력":$address[0]==""? "미입력":$address[0]?></td>	
										<td><?=$d['os_type'] == 1 ? "안드로이드":"ios"?></td>
										<td><?=number_format(${'member_amt'.$d['member_no']})?></td>
										<td><?=number_format($cupon)?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
										<td><?=$state_nm[$d['member_state']]?></td>
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
                                    echo "<li><a  href='user-list.php?page=1&category=$category&keyword=$keyword&state=$state&type=$type' aria-label='Previous'><<</a></li>";
                                } else {
                                    echo "<li><a  href='user-list.php?page=1&category=$category&keyword=$keyword&state=$state&type=$type' aria-label='Previous'><<</a></li>";
                                }
                            }
                            for($i = $block_start; $i <= $block_end; $i++){
                                if($page == $i){
                                    echo "<li class='on'><a href=''> $i </a></li>";
                                } else {
                                    if(isset($unum)){
                                        echo "<li><a  href='user-list.php?page=$i&category=$category&keyword=$keyword&state=$state&type=$type'> $i </a></li>";
                                    } else {
                                        echo "<li><a  href='user-list.php?page=$i&category=$category&keyword=$keyword&state=$state&type=$type'> $i </a></li>";
                                    }
                                }
                            }
                            if($page >= $total_page){
                                // 빈 값
                            } else {
                                if(isset($unum)){
                                    echo "<li><a   href='user-list.php?page=$total_page&category=$category&keyword=$keyword&state=$state&type=$type'>>></a>";
                                } else {
                                    echo "<li><a   href='user-list.php?page=$total_page&category=$category&keyword=$keyword&state=$state&type=$type'>>></a>";
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
