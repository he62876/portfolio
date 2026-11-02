<!DOCTYPE html>
<html lang="ko">

<?php
include('common.php');
$page = ($_GET['page'] == null ? "1":$_GET['page']);

$param = null;


$sql = "SELECT count(*) as cnt FROM news_info WHERE use_yn = 1";
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

$news_list = $pdo->query("SELECT * FROM news_info WHERE use_yn = 1 ORDER BY reg_date", $param);

$rownum = $total_record - $page_start;
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


	<title>내돈내산 리뷰쓰면 돈돼지</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
	@import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css'); ﻿


    * {
        font-family: 'Noto Sans KR', sans-serif;
        box-sizing: border-box;
    }

	.NanumSquare{
		font-family: 'NanumSquare', sans-serif;
	}

	#news {
		padding: 50px 0;
	}

	#news .table.info-table {
		text-align: left;
	}


	/* 페이징 */
	.page-list {
		text-align: center;
		margin-bottom: 35px;
	}
	.page-list li, .page-list li a {
		display: inline-block;
	}
	.page-list li a {
		width: 35px;
		font-size: 12px;
		font-weight: 500;
		border: 1px solid #000;
		text-align: center;
		padding: 7.5px 0;
		margin: 0 4px;
	}
	.page-list li.on a {
		color: #fff;
		border-color: #000;
		background: #000;
	}
	/* 페이징 */
</style>
<html id="html">
	<body>
		<div id="news">
			<div class="content-page">
				<p class="title"><span class="NanumSquare">뉴스/소식</span></p>
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th style="width: 80px;">번호</th>
								<th>제목</th>
								<th style="width: 100px;">등록일</th>
							</tr>
						</thead>
						<tbody>
							<?php if($news_list == null) { ?>
							<tr>
								<td colspan="3">조회된 정보가 없습니다.</td>
							</tr>
							<?php } else {
								foreach($news_list as $d) {	?>
							<tr>
								<td><?=$rownum?></td>
								<td><a style="cursor:pointer" onclick="window.open('news-info.php?news_no=<?=$d['news_no']?>', '_blank', 'width=500, height=700')"><?=stripslashes($d['news_title'])?></a></td>
								<td><?=substr($d['reg_date'],0,10)?></td>
							</tr>
							<?php $rownum--; }
								} ?>
						</tbody>
					</table>
				</div>
				<ul class="page-list">
					<?php
						if ($page <= 1){
							// 빈 값
						} else {
							if(isset($unum)){
								echo "<li><a  href='news-list.php?page=1' aria-label='Previous'><<</a></li>";
							} else {
								echo "<li><a  href='news-list.php?page=1' aria-label='Previous'><<</a></li>";
							}
						}
						for($i = $block_start; $i <= $block_end; $i++){
							if($page == $i){
								echo "<li class='on'><a href=''> $i </a></li>";
							} else {
								if(isset($unum)){
									echo "<li><a  href='news-list.php?page=$i'> $i </a></li>";
								} else {
									echo "<li><a  href='news-list.php?page=$i'> $i </a></li>";
								}
							}
						}
						if($page >= $total_page){
							// 빈 값
						} else {
							if(isset($unum)){
								echo "<li><a   href='news-list.php?page=$total_page'>>></a>";
							} else {
								echo "<li><a   href='news-list.php?page=$total_page'>>></a>";
							}
						}
					?> 
				</ul>
				<button onclick="window.close()">닫기</button>
			</div>
		</div>
	</body>
</html>