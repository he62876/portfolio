<?php
include('../../lib/header.php'); 
include('../../../common.php');
include('../../lib/menu.php'); 

if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$param = null;
$param1 = null;

$member_no = $_GET['member_no'] == null ? 0 : $_GET['member_no'];
if($member_no != 0) {
    $sql = "SELECT *, AES_DECRYPT(UNHEX(member_tel),'moneypig_ong_230412') as member_tel, AES_DECRYPT(UNHEX(address),'moneypig_tro_230412') as address FROM member_info WHERE member_no = ".$member_no;
	$data = $pdo->row($sql, $param);

	$id_type = array(1=>'카카오', 2=>'구글', 3=>'애플');
	$state_nm = array(1=>'정상', 0=>'탈퇴', 9=>'사용정지');

	$platform1 = $pdo->row("SELECT * FROM member_platform WHERE platform_no = 1 AND member_no = ".$member_no, $param);
	$platform2 = $pdo->row("SELECT * FROM member_platform WHERE platform_no = 2 AND member_no = ".$member_no, $param);
	$platform3 = $pdo->row("SELECT * FROM member_platform WHERE platform_no = 3 AND member_no = ".$member_no, $param);
	$platform4 = $pdo->row("SELECT * FROM member_platform WHERE platform_no = 4 AND member_no = ".$member_no, $param);
	$platform5 = $pdo->row("SELECT * FROM member_platform WHERE platform_no = 5 AND member_no = ".$member_no, $param);
	$platform6 = $pdo->row("SELECT * FROM member_platform WHERE platform_no = 6 AND member_no = ".$member_no, $param);

	$list_cnt = $pdo->row("SELECT count(*) as cnt FROM store_cash_log WHERE pay_tp = 1 AND pay_state = 1 AND member_no = ".$member_no, $param1);
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

	$sql = "SELECT *, b.store_name as store_name, a.reg_date as reg_date FROM store_cash_log a
			LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
			WHERE a.pay_tp = 1 AND a.pay_state = 1 AND a.member_no = ".$member_no." ORDER BY a.reg_date DESC LIMIT $page_start, $list";
	$point_data = $pdo->query($sql, $param);

	$point_cnt2 = $pdo->single("SELECT count(*) as cnt FROM store_cash_log WHERE pay_tp = 2 AND pay_state = 1 AND member_no = ".$member_no, $param1);
	$sql = "SELECT *, b.store_name as store_name, a.reg_date as reg_date FROM store_cash_log a
			LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
			WHERE a.pay_tp = 2 AND a.pay_state = 1 AND a.member_no = ".$member_no." ORDER BY a.reg_date DESC LIMIT 5";
	$point_data2 = $pdo->query($sql, $param);

	$cash_state_nm = array(0=>"적립요청", 1=>"적립완료", 9=>"적립취소");

	$rownum = $total_record - $page_start;


	$singo_cnt = $pdo->single("SELECT count(*) FROM user_singo WHERE member_no = ".$member_no." AND use_yn = 1", $param);
	$sql = "SELECT *, a.reg_date as reg_date, code.name as name FROM user_singo a
			LEFT OUTER JOIN store_info c ON a.store_no = c.store_no
			LEFT OUTER JOIN ceo_info d ON c.ceo_no = d.ceo_no
			LEFT OUTER JOIN code_info code ON a.singo_why = code.minr AND code.majr = 8
			WHERE a.member_no = ".$member_no." AND a.use_yn = 1 ORDER BY a.reg_date DESC";
	$singo_list = $pdo->query($sql, $param);

	$date = Date('Y-m-d');

	$cupon_cnt = $pdo->single("SELECT count(*) FROM cupon_down_info a LEFT OUTER JOIN cupon_info c ON a.cupon_no = c.cupon_no WHERE '".$date."' BETWEEN c.from_date AND c.to_date AND a.state = 1 AND a.member_no = ".$member_no, $param);
	$cupon_list = $pdo->query("SELECT *, a.reg_date as reg_date FROM cupon_down_info a LEFT OUTER JOIN store_info b ON b.store_no = a.store_no LEFT OUTER JOIN cupon_info c ON a.cupon_no = c.cupon_no
							  WHERE '".$date."' BETWEEN c.from_date AND c.to_date AND a.state = 1 AND a.member_no = ".$member_no." ORDER BY a.reg_date DESC", $param);
	
	if($data['memb_type'] == 2 ) {
		$category = $pdo->single("SELECT name FROM code_info WHERE majr = 2 AND minr = ".$data['category'], $param);
		$campaign_cnt1 = $pdo->single("SELECT count(*) FROM campaign_applicant WHERE applicant_state != 9 AND member_no = ".$member_no, $param);
		$campaign_cnt2 = $pdo->single("SELECT count(*) FROM campaign_applicant WHERE applicant_state IN (1,2,3,4) AND member_no = ".$member_no, $param);

		$cash_cnt = $pdo->single("SELECT count(*) FROM campaign_pay_touser WHERE pay_state = 1 AND member_no =".$member_no, $param);
		$cash_data = $pdo->query("SELECT *, b.subject as name FROM campaign_pay_touser a LEFT OUTER JOIN campaign_info b ON a.campaign_no = b.campaign_no WHERE a.pay_state = 1 AND a.member_no =".$member_no, $param);

		$out_cnt = $pdo->single("SELECT count(*) FROM user_cash_out WHERE member_no = ".$member_no, $param);
		$out_data = $pdo->query("SELECT * FROM user_cash_out a LEFT OUTER JOIN code_info b ON a.bank_code = b.etc AND b.majr = 7 WHERE a.member_no = ".$member_no." ORDER BY reg_date DESC", $param);
	}
	
	$amt = $pdo->query("SELECT sum_cash_amt FROM user_cash_log WHERE member_no = ".$member_no, $param);
	foreach($amt as $amt) {
		$member_amt += $amt['sum_cash_amt'];
	}
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
                    <h6 class="title-strong">회원관리</h6>
                </div>
                <div class="card-body">
					<strong>기본정보</strong>
					<div class="table-responsive">
						<table class="table info-table">
							<tbody>
								<tr>
									<th class="table-light" style="width: 150px;">가입일</th>
									<td><?=substr($data['reg_date'],0,10)?></td>
									<th class="table-light" style="width: 150px;">이름</th>
									<td><?=$data['member_name']?></td>
									<th class="table-light" style="width: 150px;">성별</th>
									<td><?=$data['member_sex'] == 1 ? "남성":"여성"?></td>
								</tr>
								<tr>
									<th class="table-light">연령대</th>
									<td><?=$data['member_old'] >= 10 ? $data['member_old']:$data['member_old']."0"?>대</td>
									<th class="table-light">거주지</th>
									<td><?=$data['address']?></td>
									<th class="table-light">연락처</th>
									<td id="member_tel"><button type="button" id="memberTel">보기</button></td>
								</tr>
								<tr>
									<th class="table-light">포인트적립금</th>
									<td><?=number_format($member_amt)?>원</td>
									<th class="table-light">캐시적립금</th>
									<td><?=number_format($data['member_amt'])?>원</td>
									<th class="table-light">상태</th>
									<td><?=$state_nm[$data['member_state']]?></td>
								</tr>
								<tr>
									<th class="table-light">아이디</th>
									<td colspan="<?=$data['member_state'] == 0 ? 3:5?>"><?=$id_type[$data['id_type']]?></td>
									<?php if($data['member_state'] == 0) { ?>
									<th class="table-light">탈퇴일</th>
									<td><?=substr($data['up_reg_date'],0,10)?></td>
									<?php } ?>
								</tr>
								<?php if($data['memb_type'] == 2) { ?>
								<tr>
									<th class="table-light">분류</th>
									<td>인플루언서회원</td>
									<th class="table-light">카테고리</th>
									<td colspan="3"><?=$category?></td>
								<tr>
									<th class="table-light">체험단<br>신청횟수</th>
									<td><?=number_format($campaign_cnt1)?></td>
									<th class="table-light">체험단<br>선정횟수</th>
									<td><?=number_format($campaign_cnt2)?></td>
									<th class="table-light">신고횟수</th>
									<td></td>
								</tr>
								</tr>
								<tr>
									<th class="table-light">네이버<br>블로그</th>
									<td colspan="3"><?=$data['blog_url'] == null ? "-":"<a href='".$data['blog_url']."' target='_blank'>".$data['blog_url']."</a>"?></td>
									<th class="table-light">이웃수</th>
									<td><?=$data['blog_info'] == null ? "-":$data['blog_info']?></td>
								</tr>
								<tr>
									<th class="table-light">인스타<br>아이디</th>
									<td colspan="3"><?=$data['instar_url'] == null ? "-":"<a href='".$data['instar_url']."' target='_blank'>".$data['instar_url']."</a>"?></td>
									<th class="table-light">팔로워수</th>
									<td><?=$data['instar_info'] == null ? "-":$data['instar_info']?></td>
								</tr>
								<tr>
									<th class="table-light">유튜브</th>
									<td colspan="3"><?=$data['youtube_url'] == null ? "-":"<a href='".$data['youtube_url']."' target='_blank'>".$data['youtube_url']."</a>"?></td>
									<th class="table-light">구독자수</th>
									<td><?=$data['youtube_info'] == null ? "-":$data['youtube_info']?></td>
								</tr>
								<tr>
									<th class="table-light">틱톡</th>
									<td colspan="3"><?=$data['tictok_url'] == null ? "-":"<a href='".$data['tictok_url']."' target='_blank'>".$data['tictok_url']."</a>"?></td>
									<th class="table-light">구독자수</th>
									<td><?=$data['tictok_info'] == null ? "-":$data['tictok_info']?></td>
								</tr>
								<tr>
									<th class="table-light">소개</th>
									<td colspan="3"><?=$data['intro']?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<strong>포인트적립내역</strong>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th>사업장명</th>
									<th>적립금액</th>
									<th>적립일</th>
									<th style="width: 150px;">잔액</th>
								</tr>
							</thead>
							<tbody>
								<?php if($point_data == null) { ?>
								<tr>
									<td colspan="7">조회된 정보가 없습니다.</td>
								</tr>
								<?php } else { 
									foreach($point_data as $d) { ?>
									<tr>
										<td><?=$rownum?></td>
										<td><?=$d['store_name']?></td>
										<td><?=number_format($d['pay_amt'])?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
										<td><?=number_format($d['sum_cash_amt'])?></td>
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
                                    echo "<li><a  href='user-info.php?member_no=$member_no&page=1' aria-label='Previous'><<</a></li>";
                                } else {
                                    echo "<li><a  href='user-info.php?member_no=$member_no&page=1' aria-label='Previous'><<</a></li>";
                                }
                            }
                            for($i = $block_start; $i <= $block_end; $i++){
                                if($page == $i){
                                    echo "<li class='on'><a href=''> $i </a></li>";
                                } else {
                                    if(isset($unum)){
                                        echo "<li><a  href='user-info.php?member_no=$member_no&page=$i'> $i </a></li>";
                                    } else {
                                        echo "<li><a  href='user-info.php?member_no=$member_no&page=$i'> $i </a></li>";
                                    }
                                }
                            }
                            if($page >= $total_page){
                                // 빈 값
                            } else {
                                if(isset($unum)){
                                    echo "<li><a   href='user-info.php?member_no=$member_no&page=$total_page'>>></a>";
                                } else {
                                    echo "<li><a   href='user-info.php?member_no=$member_no&page=$total_page'>>></a>";
                                }
                            }
                        ?> 
                    </ul>
					<strong>포인트결제내역</strong>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th>사업장명</th>
									<th>결제금액</th>
									<th>결제일</th>
									<th style="width: 150px;">잔액</th>
								</tr>
							</thead>
							<tbody>
								<?php if($point_data2 == null) { ?>
								<tr>
									<td colspan="7">조회된 정보가 없습니다.</td>
								</tr>
								<?php } else { 
									foreach($point_data2 as $d) { ?>
									<tr>
										<td><?=$point_cnt2?></td>
										<td><?=$d['store_name']?></td>
										<td><?=number_format($d['pay_amt'])?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
										<td><?=number_format($d['sum_cash_amt'])?></td>
									</tr>
								<?php $point_cnt2--; }
									}?>
							</tbody>
						</table>
					</div>
					<strong>쿠폰내역</strong>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th style="width: 150px;">사업장명</th>
									<th>쿠폰명</th>
									<th style="width: 150px;">다운일</th>
								</tr>
							</thead>
							<tbody>
								<?php if($cupon_list == null) { ?>
								<tr>
									<td colspan="4">조회된 정보가 없습니다.</td>
								</tr>
								<?php } else { 
									foreach($cupon_list as $d) { ?>
									<tr>
										<td><?=$cupon_cnt?></td>
										<td><a href="store-info.php?store_no=<?=$d['store_no']?>" style="font-weight: 500; text-decoration:underline;"><?=$d['store_name']?></a></td>
										<td><?=$d['cupon_name']?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
									</tr>
								<?php $cupon_cnt--; }
									}?>
							</tbody>
						</table>
					</div>
					<?php if($data['memb_type'] == 2) { ?>
					<strong>캐시적립내역</strong>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th>캠페인명</th>
									<th>결제금액</th>
									<th style="width: 150px;">결제일</th>
								</tr>
							</thead>
							<tbody>
								<?php if($cash_data == null) { ?>
								<tr>
									<td colspan="6">조회된 정보가 없습니다.</td>
								</tr>
								<?php } else { 
									foreach($cash_data as $d) { ?>
									<tr>
										<td><?=$cash_cnt?></td>
										<td><?=$d['name']?></td>
										<td><?=number_format($d['amt'])?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
									</tr>
								<?php $cash_cnt--; }
									}?>
							</tbody>
						</table>
					</div>
					<strong>출금내역</strong>
					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th style="width: 80px;">순번</th>
									<th>은행명</th>
									<th>예금주명</th>
									<th>출금금액</th>
									<th style="width: 100px;">출금요청일</th>
									<th style="width: 150px;">상태</th>
								</tr>
							</thead>
							<tbody>
								<?php if($out_data == null) { ?>
								<tr>
									<td colspan="6">조회된 정보가 없습니다.</td>
								</tr>
								<?php } else { 
									foreach($out_data as $d) { ?>
									<tr>
										<td><?=$out_cnt?></td>
										<td><?=$d['name']?></td>
										<td><?=$d['bank_owner']?></td>
										<td><?=number_format($d['amt'])?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
										<td><?=$d['out_state'] == 0 ? "요청중":"출금완료"?></td>
									</tr>
								<?php $rownum--; }
									}?>
							</tbody>
						</table>
					</div>
					<?php } ?>
					<strong>신고내역</strong>
					<form action="json.php" method="post" class="d-flex justify-content-between align-items-center">
						<input type="hidden" name="board" value="user">
						<input type="hidden" name="mode" value="stop">
						<input type="hidden" name="no" value="<?=$member_no?>">
						<div class="btn-box mb-1">
							<button onclick="return stop();" style="width: 80px;" name="state" value="<?=$data['member_state'] == 1 ? 9:1?>"><?=$data['member_state'] == 1 ? "정지하기":"정지취소"?></button>
						</div>
						최근수정일: <?=$data['up_reg_date']?>
					</form>
					<div class="table-responsive">
						<table class="table">
							<thead>
                                <tr>
                                    <th style="width: 80px;">순번</th>
                                    <th>신고자</th>
                                    <th style="width: 200px;">신고사유</th>
                                    <th style="width: 100px;">신고날짜</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($singo_list == null) { ?>
                                    <tr>
                                        <td colspan="4">조회된 정보가 없습니다.</td>
                                    </tr>
                                <?php } else {
                                    foreach($singo_list as $d) {
										?>
                                    <tr>
										<td><?=$singo_cnt?></td>
										<td><a href="shop-info.php?ceo_no=<?=$d['ceo_no']?>" style="font-weight: 500; text-decoration:underline;"><?=$d['ceo_name']?></a></td>
										<td><?=$d['name']?></td>
										<td><?=substr($d['reg_date'],0,10)?></td>
                                    </tr>
                                <?php $singo_cnt--; }
                                } ?>
                                <tr>
                            </tbody>
						</table>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>
<script>
	var memberTel = $('#memberTel');
	var member_tel = $('#member_tel');
	memberTel.click(function(){
		member_tel.text("<?=$data['member_tel']?>");

		var user_no = <?=$member_no?>;
		var grade = 1;
		var agency_no = <?=$_SESSION['no']?>;

		$.ajax({type: 'POST',
			url: 'json.php',
			data:"&mode=view&user_no="+user_no+"&grade="+grade+"&agency_no="+agency_no,
			dataType: 'json',
			cache: false,
			beforeSend: function() { },
			success: function(data) {
				try
				{
					//alert(data.resCode);
					if(data.resCode == 1){
						location.replace();
					}
					else{
					
					}
				}
				catch(e)
				{
					console.log("error forward2 : " + e);
				}
			},
				error: function(data, status, err) {
				try{ console.log("error forward : " + data); alert(err); }
				catch(e){ console.log("error : " + e); alert('서버와의 통신이 실패했습니다.'); }
				return false;
			},
			complete: function() { },
			xhr: /*@cc_on false && @*/window.XMLHttpRequest ?
					function() { return new window.XMLHttpRequest(); } :
			function() { try { return new window.ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} }
		});
	})
	
	//member_tel.html(<?=$data['member_tel']?>);

	function stop() {

        var check = confirm("진행하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }
	}
</script>