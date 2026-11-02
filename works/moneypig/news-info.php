<!DOCTYPE html>
<html lang="ko">

<?php
include('../../common.php');

$param = null;

$news_no = $_GET['news_no'];
//$data = $pdo->row("SELECT * FROM news_info WHERE news_no = ".$news_no, $param);

$sql = "SELECT * FROM moneypig_news_info WHERE news_no = ".$news_no;
$row = $pdo->query($sql);
$data = $row->fetch(PDO::FETCH_ASSOC);

$rs = $pdo->query("UPDATE moneypig_news_info SET hit = hit + 1 WHERE news_no = ".$news_no);

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
    <link rel="stylesheet" href="/portfolio/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/style.css">


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

</style>
<html id="html">
	<body>
		<div id="news">
			<div class="content-page">
				<p class="title"><span class="NanumSquare">뉴스/소식</span></p>
				<div class="table-responsive">
					<table class="table info-table">
						<tbody>
							<tr>
								<th class="table-light" style="width:100px">제목</th>
								<td><?=stripslashes($data['news_title'])?></td>
							</tr>
							<tr>
								<th class="table-light">작성일</th>
								<td><?=substr($data['reg_date'],0,10)?></td>
							</tr>
							<tr>
								<th class="table-light">내용</th>
								<td>
									<p style="min-height: 250px;"><?=stripslashes(nl2br($data['news_content']))?></p>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<button onclick="window.close()">닫기</button>
			</div>
		</div>
	</body>
</html>