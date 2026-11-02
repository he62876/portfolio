<!DOCTYPE html>
<html lang="ko">

<?php
include('common.php');
$req_no = $_GET['req_no'];
$code = $_GET['code'];

$param = null;

$sql = "SELECT *, a.biz_num as biz_num FROM banner_req a
		LEFT OUTER JOIN agency_info b ON a.cntr_no = b.agency_no
		WHERE a.req_no = ".$req_no;
$data = $pdo->row($sql, $param);

$s_month = $pdo->single("SELECT DATE_FORMAT(s_date, '%Y-%m') FROM banner_req WHERE req_no = ".$req_no, $param);
$e_month = $pdo->single("SELECT DATE_FORMAT(e_date, '%Y-%m') FROM banner_req WHERE req_no = ".$req_no, $param);
//$month = $_GET['month'] == null ? $s_month : $_GET['month'];


?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="돈돼지, 내돈내산, 리뷰쓰면 돈돼지, 리뷰100%, 리뷰이벤트, 먹튀제로, 동네광고, 가게홍보, 캐시적립, 짠테크, 앱테크, 재테크">
	<meta name="description" content="우리 동네 가게 이용하고 리뷰쓰면 가게 사장님이 용돈을 드립니다. 다양한 곳에서 내돈내산 혜택 가득~ 매일매일 돈 쓸 맛 나는 앱테크 돈돼지! 우리 동네 가게 홍보도 하고 리뷰도 받자! 기자단, 체험단 필요없는 실속있는 홍보방법! 꿀돼지같은 우리 가게 파트너 돈돼지!">
	<meta property="og:type" content="website">
	<meta property="og:title" content="내돈내산 리뷰쓰면 돈돼지">
	<meta property="og:image" content="/img/moneypig_meta_guide.png">
	<meta property="og:description" content="내돈내산 리뷰쓰면 돈돼지입니다">
	<meta property="og:url" content="https://moneypig.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="eXLmcYdidByhd62Jv7bpHnUjMmBJhp70BDC9CgIrHLo" />
	<meta name="naver-site-verification" content="ca313ff7297cfd1c8d9f558a9bc18bfd96d09b3b" />
    <!-- plugin css -->
    <link href="/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- style-->
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">


	<title>돈되지 광고 성과 보고서</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
	@import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css'); ﻿


    * {
		font-family: 'NanumSquare', sans-serif;
        box-sizing: border-box;
    }

	.NanumSquare{
		font-family: 'NanumSquare', sans-serif;
	}

	strong {
		font-family: 'NanumSquare', sans-serif;
		font-weight: 900;
		font-size: 24px;
	}

	#news {
		padding: 50px 0;
	}

	#news .table.info-table {
		text-align: left;
		margin: 20px 0;
	}

	thead, tbody, tfoot, tr, td, th {
		border-color: #DEE2E6;
	}

	.table.info-table th,
	.table.info-table td {
		white-space: nowrap;
		vertical-align: middle;
	}

	.table.info-table th {
		background: <?=$data['req_tp'] == 1 ? "#FFFCE1":"#F7F2FF"?>;
		border-bottom: none;
		font-weight: 700;
		font-size: 15px;
		width: 100px;
	}
	.table.info-table.date-table th,
	.table.info-table.date-table td {
		text-align: center;
	}
	.table.info-table.date-table th {
		font-weight: 900;
		font-size: 15px;
	}
	.table.info-table.date-table td {
		border-right: 1px solid #DEE2E6;
	}

	.content-page{
		width: 90%;
	}

	.d-flex {
		justify-content: space-between;
	}

	.d-flex > div {
		width: 49%;
	}
	
	@media screen and (max-width: 800px) {
		.d-flex {flex-direction: column;}
		.d-flex > div {margin-bottom: 20px; width: 100%;}
	}

	.d-flex > div > div {
		border: 1px #DEE2E6 solid;
		border-radius: 10px;
		margin-top: 15px;
	}

	.age_box {
		padding: 20px;
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
	}
	.age_box > div {
		width: 45%;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	.age_box > div > div > p {
		display: inline-block;
		vertival-align: middle;
		align-items: center;
	}
	.age_box > div > div > p.age_nm {
		margin: 2px 2px 2px 0;
		border: 3px solid #CECECE;
		border-radius: 100%;
		font-size: 18px;
		font-weight: 900;
		width: 40px; height: 40px;
		text-align: center;
		line-height: 36px;
	}

	.sex_box {
		padding: 27.5px;
		display: flex;
		justify-content: space-between;
		flex-wrap: wrap;
	}
	.sex_box > div {
		width: 50%;
		text-align: center;
	}
	.sex_box > div img {
		margin-bottom: 15px;
	}


	.tap_list {
		margin-top: 15px;
	}

	.tap_list > div {
		display: inline-block;
	}

	.tap_list > div input[type="radio"] {
		display: none;
	}
	.tap_list > div input[type="radio"] + label {
		position: relative;
		font-size: 25px;
		font-weight: 900;
		padding: 0 65px 0 20px;
		cursor: pointer;
		color: #C5C5C5;
	}
	.tap_list > div input[type="radio"] + label::after {
		content: '';
		position: absolute;
		height: 25px; width: 2.5px;
		background: #D3D3D3;
		top: 50%; transform: translateY(-50%);
		right: 0;
	}
	.tap_list > div input[type="radio"]:checked + label {
		color: #000;
	}
</style>
<html id="html">
	<body>
		<div id="news">
			<div class="content-page">
				<?php if($code == $data['biz_num']) { ?>
				<div class="table-responsive">
					<strong>기본정보</strong>
					<table class="table info-table">
						<tr>
							<th>타입</th>
							<td><?=$data['req_tp'] == 1 ? "고객용앱":"사장님용앱"?></td>
							<th>대행사명</th>
							<td><?=$data['agency_nm']?></td>
							<th>광고주명</th>
							<td><?=$data['req_name']?></td>
						</tr>
						<tr>
							<th>광고기간</th>
							<td><?=$data['s_date']?> ~</br><?=$data['e_date']?>(<?=$data['date1']?>일)</td>
							<th>노출수</th>
							<?php $view_cnt = $pdo->single("SELECT count(*) FROM banner_view WHERE DATE_FORMAT(reg_date, '%Y-%m-%d') >= DATE_FORMAT('".$data['s_date']."', '%Y-%m-%d') AND DATE_FORMAT(reg_date, '%Y-%m-%d') <= DATE_FORMAT('".$data['e_date']."', '%Y-%m-%d') AND req_no = ".$req_no); ?>
							<td><?=number_format($view_cnt)?></td>
							<th>클릭수</th>
							<?php $hit_cnt = $pdo->single("SELECT count(*) FROM banner_hit WHERE DATE_FORMAT(reg_date, '%Y-%m-%d') >= DATE_FORMAT('".$data['s_date']."', '%Y-%m-%d') AND DATE_FORMAT(reg_date, '%Y-%m-%d') <= DATE_FORMAT('".$data['e_date']."', '%Y-%m-%d') AND req_no = ".$req_no); ?>
							<td><?=number_format($hit_cnt)?></td>
						</tr>
						<tr>
							<th>노출지역</th>
							<?php
								$area_list = explode(",", $data['area_gu']);
								foreach($area_list as $area_nm) {
									$area_arr[] = $area_nm; 
								}
								$area = implode(", ", $area_arr);
							?>
							<td colspan="5"><p style="white-space:normal"><?=$data['area_gu'] == null ? "전체":$area?></p></td>
						</tr>
						<?php if($data['req_tp'] == 1) { ?>
						<tr>
							<th>성별</th>
							<?php $sex = array(0 => "전체", 1 => "남성", 2 => "여성"); ?>
							<td colspan="5"><?=$sex[$data['sex']]?></td>
						</tr>
						<tr>
							<th>연령</th>
							<?php
								$age_list = explode(",", $data['age']);
								foreach($age_list as $age_nm) {
									$age_arr[] = $age_nm."대"; 
								}
								$age = implode(", ", $age_arr);
							?>
							<td colspan="5"><p style="white-space:normal"><?=$data['age'] == null || $data['age'] == 0 ? "전체":$age?></p></td>
						</tr>
						<?php } else { ?>
						<tr>
							<th>카테고리</th>
							<?php
								if($data['category'] != 0) {
									$cate_list = explode(",", $data['category']);
									foreach($cate_list as $cate_nm) {
										$code_name = $pdo->single("SELECT name FROM code_info WHERE majr = 2 AND sub_category IS NULL AND minr = ".$cate_nm,$param);
										$cate_arr[] = $code_name; 
									}
									$cate = implode(", ", $cate_arr);
								}
							?>
							<td colspan="5"><p style="white-space:normal"><?=$data['category'] == 0 ? "전체":$cate?></p></td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<div class="table-responsive">
					<strong>일일 노출수/클릭수</strong>
					<?php
					$month_list = $pdo->query("SELECT DATE_FORMAT(reg_date, '%c월') as reg_date, DATE_FORMAT(reg_date, '%Y-%m') as reg_val, DATE_FORMAT(reg_date, '%Y%m') as dt FROM banner_view WHERE req_no = ".$req_no." AND DATE_FORMAT(reg_date, '%Y-%m') BETWEEN '".$s_month."' AND '".$e_month."' GROUP BY DATE_FORMAT(reg_date, '%Y-%m')", $param);
					?>
					<div class="tap_list">
						<?php foreach($month_list as $d) { ?>
						<div>
							<input type="radio" name="month" id="reg<?=$d['reg_val']?>" value="<?=$d['reg_val']?>" <?=$s_month == $d['reg_val'] ? "checked":""?>>
							<label class="NanumSquare" for="reg<?=$d['reg_val']?>"><?=$d['reg_date']?></label>
						</div>
						<?php } ?>
					</div>
					<?php foreach($month_list as $d) {
						${'year'.$d['dt']} = substr($d['dt'],0,4);
						${'month'.$d['dt']} = substr($d['dt'],4,6);
						${'date'.$d['dt']} = "${'year'.$d['dt']}-${'month'.$d['dt']}-01";
						${'time'.$d['dt']} = strtotime(${'date'.$d['dt']});
						//${'start_week'.$d['dt']} = date('w', ${'time'.$d['dt']}); // 1. 시작 요일
						${'total_day'.$d['dt']} = date('t', ${'time'.$d['dt']}); // 2. 현재 달의 총 날짜
						${'total_week'.$d['dt']} = ceil(${'total_day'.$d['dt']} / 3);  // 3. 현재 달의 총 주차 ?>
					<table class="mb-0 reg<?=$d['reg_val']?> table info-table date-table">
						<tr>
							<th class="NanumSquare" style="width: 9%;">날짜</th>
							<th class="NanumSquare" style="width: 12%;">노출수</th>
							<th class="NanumSquare" style="width: 12%;">클릭수</th>
							<th class="NanumSquare" style="width: 9%">날짜</th>
							<th class="NanumSquare" style="width: 12%">노출수</th>
							<th class="NanumSquare" style="width: 12%">클릭수</th>
							<th class="NanumSquare" style="width: 9%">날짜</th>
							<th class="NanumSquare" style="width: 12%">노출수</th>
							<th class="NanumSquare" style="width: 12%">클릭수</th>
						</tr>
						<?php for (${'n'.$d['dt']} = 1, ${'i'.$d['dt']} = 0; ${'i'.$d['dt']} < ${'total_week'.$d['dt']}; ${'i'.$d['dt']}++): ?> 
						<tr> 
							<!-- 1일부터 7일 (한 주) -->
							<?php for (${'k'.$d['dt']} = 0; ${'k'.$d['dt']} < 3; ${'k'.$d['dt']}++): ?> 
								<th class="NanumSquare" style="background: #F9F9F9;"> 
								<!-- 시작 요일부터 마지막 날짜까지만 날짜를 보여주도록 -->
								<?php if ( (${'n'.$d['dt']} > 1 || ${'k'.$d['dt']} >= ${'start_week'.$d['dt']}) && (${'total_day'.$d['dt']} >= ${'n'.$d['dt']}) ):  ?>
									<!-- 현재 날짜를 보여주고 1씩 더해줌 -->
									<?php echo ${'n'.$d['dt']}++."일";
										  $date_val = ${'year'.$d['dt']}."-".${'month'.$d['dt']}."-".sprintf('%02d', (${'n'.$d['dt']}-1)); ?>
								</th> 
								<td class="NanumSquare">
									<?php  $view_cnt = $pdo->single("SELECT count(*) FROM banner_view WHERE DATE_FORMAT(reg_date, '%Y-%m-%d') = '".$date_val."' AND req_no = ".$req_no, $param);	
										   echo $view_cnt == 0 ? "":number_format($view_cnt)?>
								</td>
								<td class="NanumSquare">
									<?php  $hit_cnt = $pdo->single("SELECT count(*) FROM banner_hit WHERE DATE_FORMAT(reg_date, '%Y-%m-%d') = '".$date_val."' AND req_no = ".$req_no, $param);	
										   echo $hit_cnt == 0 ? "":number_format($hit_cnt)?>
								</td>
								<?php endif ?>
							<?php endfor; ?> 
							</tr> 
						<?php endfor; ?> 
					</table>
					<table class="reg<?=$d['reg_val']?> table info-table date-table" style="margin-top: 0;">
						<?php $month_val = ${'year'.$d['dt']}."-".${'month'.$d['dt']};
							  $view_total = $pdo->single("SELECT count(*) FROM banner_view WHERE DATE_FORMAT(reg_date, '%Y-%m') = '".$month_val."' AND req_no = ".$req_no, $param);
							  $hit_total = $pdo->single("SELECT count(*) FROM banner_hit WHERE DATE_FORMAT(reg_date, '%Y-%m') = '".$month_val."' AND req_no = ".$req_no, $param); ?>
						<tr>
							<th class="NanumSquare" style="width: 15%">노출수 합계</th>
							<td class="NanumSquare" style="width: 35%; font-weight: 900; font-size: 18px;"><?=$view_total == 0 ? "":number_format($view_total)?></td>
							<th class="NanumSquare" style="width: 15%">클릭수 합계</th>
							<td class="NanumSquare" style="width: 35%; font-weight: 900; font-size: 18px;"><?=$hit_total == 0 ? "":number_format($hit_total)?></td>
						</tr>
					</table>
					<?php } ?>
				</div>
				<?php if($data['req_tp'] == 1) { ?>
				<div class="table-responsive d-flex">
				<?php
				$sigu = "";
				$gugun = explode(',' , $data['area_gu']);
				$ages = explode(',' , $data['age']);
				for($i=0;$i<count($gugun);$i++){
					if($i>0){
						$sigu .= "OR AES_DECRYPT(UNHEX(address),'moneypig_tro_230412') LIKE '%".$gugun[$i]."%' ";
					}
					else{
						$sigu .= " AES_DECRYPT(UNHEX(address),'moneypig_tro_230412') LIKE '%".$gugun[$i]."%' ";
					}
					
				}
				$where = "( ".$sigu." )";
				if(count($ages)>0){
					//연령대 전체
					if(count($ages)==1 && $ages[0]==0){
						
					}
					else{
						//개별 연령대 선택
						$where .= " AND member_old IN (".$data['age'].") ";
					}
				}
				if($data['member_sex']>0){
					//성별 체크시
					$where .= " AND member_sex=".$data['member_sex'];
				}
				$sql = "SELECT count(*) FROM member_info WHERE member_state = 1 AND ".$where;
				$all_cnt = $pdo->single($sql, $param);
				for($i = 10; $i <= 60; $i+=10) {
					${'age_cnt'.$i} = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND ".$where." AND member_old = ".$i,$param);
					${'age_per'.$i} = round((${'age_cnt'.$i}/$all_cnt) * 100);
				}
				$sex_cnt1 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_sex = 1 AND ".$where, $param);
				$sex_per1 = round(($sex_cnt1/$all_cnt) * 100);
				$sex_cnt2 = $pdo->single("SELECT count(*) FROM member_info WHERE member_state = 1 AND member_sex = 2 AND ".$where, $param);
				$sex_per2 = round(($sex_cnt2/$all_cnt) * 100);
				?>
					<div>
						<strong>성별 통계</strong>
						<div class="sex_box">
							<div>
								<img src="/img/report_m.png" style="width: 50px;">
								<p>남성 <span class="NanumSquare" style="font-size: 18px; font-weight: 900;"><?=$sex_per1?>%</span></p>
							</div>
							<div>
								<img src="/img/report_f.png" style="width: 50px;">
								<p>여성 <span class="NanumSquare" style="font-size: 18px; font-weight: 900;"><?=$sex_per2?>%</span></p>
							</div>
						</div>
					</div>
					<div>
						<strong>연령 통계</strong>
						<div class="age_box">
							<?php	$color = array(10 => '#F95BB4', 20 => '#4F89F1', 30 => '#F4D029', 40 => '#8872F4', 50 => '#61CD73', 60 => '#FFA200');
							for($i = 10; $i <= 60; $i+=10) { ?>
								<div>
									<div>
										<p class="age_nm NanumSquare" style="color:<?=$color[$i]?>"><?=$i?></p>
										<p><?=$i?>대<?=$i == 60 ? " 이상":""?></p>
									</div>
									<p class="NanumSquare" style="font-size: 18px; font-weight: 900;"><?=${'age_per'.$i}?>%</p>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php } ?>
				<p class="d-none" id="copy_id">https://moneypig.co.kr/report.php?req_no=<?=$req_no?>&code=<?=$code?></p>
				<button type="button" class="copyAlbumId mt-5">주소복사</button>
				<?php } else {?>
				<p>존재하지 않는 페이지입니다.</p>
				<?php } ?>
			</div>
		</div>
	</body>
</html>

<!-- JAVASCRIPT -->
<script src="/assets/libs/jquery/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="/js/jquery.counterup.min.js"></script>
<script src="/js/main.js"></script>

<script>

	$('.date-table').hide();

	$("input:radio[name='month']").each(function(){
			if($(this).is(":checked")) {
			var activeTab = $(this).attr('id');
			$('.'+activeTab).show();
		}
	});

    $("input:radio[name='month']").click(function() {
		var activeTab = $(this).attr('id');
		$('.date-table').hide();
		if($(this).is(":checked")) {
			$('.'+activeTab).show();
		}
    });

	 $('.copyAlbumId').click(function () {
 
		  var copyText = document.getElementById("copy_id");//클립보드에 복사할 텍스트 가져옴
		  var textArea = document.createElement("textarea");//textarea 생성
		  
		  textArea.value = copyText.textContent;//textarea에 텍스트 입력
		  document.body.appendChild(textArea);//body에 textarea 추가
		  
		  textArea.select();//선택
		  document.execCommand("Copy");//복사
		  textArea.remove();//생성한 textarea 삭제
		  
		  alert("복사되었습니다.");
      
    });


</script>