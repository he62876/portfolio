<?php
session_start();
// 
// if( isset($_SESSION['LAST_ACT']) && time() - $_SESSION['LAST_ACT'] > 60*60*2){
    // header('Location: /admin/logout.php');
// }
// $_SESSION['LAST_ACT'] = time();
// 
if(!isset($_SESSION['lv'])) {
    echo "<meta http-equiv='refresh' content='0;url=/portfolio/works/moneypig/admin/login.php'>";
	exit;
}

$lv = $_SESSION['lv'];

?>
<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="돈되지, 내돈내산, 리뷰쓰면 돈되지, 리뷰100%, 리뷰이벤트, 먹튀제로, 동네광고, 사업장홍보, 캐시적립, 짠테크, 앱테크, 재테크">
	<meta name="description" content="우리 동네 사업장 이용하고 리뷰쓰면 사업장 사장님이 용돈을 드립니다. 다양한 곳에서 내돈내산 혜택 가득~ 매일매일 돈 쓸 맛 나는 앱테크 돈되지! 우리 동네 사업장 홍보도 하고 리뷰도 받자! 기자단, 체험단 필요없는 실속있는 홍보방법! 꿀돼지같은 우리 사업장 파트너 돈되지!">
	<meta property="og:type" content="website">
	<meta property="og:title" content="내돈내산 리뷰쓰면 돈되지">
	<meta property="og:image" content="/portfolio/works/moneypig/img/moneypig_meta_guide.png">
	<meta property="og:description" content="내돈내산 리뷰쓰면 돈되지입니다">
	<meta property="og:url" content="https://moneypig.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="eXLmcYdidByhd62Jv7bpHnUjMmBJhp70BDC9CgIrHLo" />
	<meta name="naver-site-verification" content="ca313ff7297cfd1c8d9f558a9bc18bfd96d09b3b" />
	<link rel="shortcut icon" href="/portfolio/works/moneypig/img/money.ico">
    <!-- plugin css -->
    <link href="/portfolio/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/portfolio/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/portfolio/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="/portfolio/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/portfolio/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />


    <!-- style-->
    <link rel="stylesheet" href="/portfolio/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/portfolio/css/reset.css">
    <link rel="stylesheet" href="/portfolio/works/moneypig/admin/css/style.css">
	<link rel="shortcut icon" href="../img/money.ico">


    <title>돈되지 관리자</title>
</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');

    * {
        font-family: 'Noto Sans KR', sans-serif;
        box-sizing: border-box;
    }
</style>
<body class="pace-done" oncontextmenu="return true" ondragstart="return true" onselectstart="return false">
    <div id="pace-inactive">
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div>
                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars" style="color:#aaa;"></i>
                    </button>
                </div>
                <div class="d-flex justify-content-between align-items-center logout">
					<?php if($lv == 4) { 

							$sql = "SELECT count(*) FROM campaign_req a
									LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
									LEFT OUTER JOIN ceo_info ceo ON b.ceo_no = ceo.ceo_no
									LEFT OUTER JOIN agency_info mngr ON ceo.mng_code = mngr.agency_code
									WHERE mngr.agency_no = ".$_SESSION['no']." AND req_state = 0";
							$agent_cnt = $pdo->single($sql);
							$sql = "SELECT *, a.reg_date as reg_date, mngr.agency_no as agency_noagency_nm FROM campaign_req a
									LEFT OUTER JOIN store_info b ON a.store_no = b.store_no
									LEFT OUTER JOIN ceo_info ceo ON b.ceo_no = ceo.ceo_no
									LEFT OUTER JOIN agency_info mngr ON ceo.mng_code = mngr.agency_code
									WHERE mngr.agency_no = ".$_SESSION['no']." AND req_state = 0";
							$agent_data = $pdo->query($sql);
?>
					<div class="dropdown d-inline-block">
						<button type="button" class="btn header-item noti-icon position-relative" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
							  <g id="그룹_28352" data-name="그룹 28352" transform="translate(-1617 -29)">
								<rect id="사각형_24652" data-name="사각형 24652" width="30" height="30" transform="translate(1617 29)" fill="none"/>
								<g id="그룹_28336" data-name="그룹 28336" transform="translate(838 -1892.72)">
								  <path id="패스_8861" data-name="패스 8861" d="M19.544,18.941h0a.679.679,0,0,0-.137-.079A6.95,6.95,0,0,1,16.645,13.6c-.22-3.5.146-6.162-.563-7.676a5.933,5.933,0,0,0-4.955-3.746V1.23a1.23,1.23,0,0,0-2.461,0v.982A6.037,6.037,0,0,0,3.7,5.928c-.71,1.513-.342,4.178-.563,7.676A7.069,7.069,0,0,1,.323,18.892a.32.32,0,0,0-.044.025l-.005,0h0A.592.592,0,0,0,0,19.414a.633.633,0,0,0,.656.607h18.48a.634.634,0,0,0,.657-.607.587.587,0,0,0-.249-.473" transform="translate(784 1924.72)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
								  <path id="패스_8862" data-name="패스 8862" d="M17.657,45.46a2.6,2.6,0,0,0,2.6-2.6h-5.2a2.6,2.6,0,0,0,2.6,2.6" transform="translate(776.24 1902.629)" fill="none" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
								</g>
							  </g>
							</svg>
							<span class="badge bg-danger rounded-pill"><?=$agent_cnt?></span>
						</button>
						<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown" style="border: none; border-radius: 10px;">
							<div class="p-3" style="background: #0A1E38; border-top-left-radius: 10px; border-top-right-radius: 10px;">
								<div class="row align-items-center">
									<div class="col">
										<h6 class="m-0" style="font-size:15px; font-weight: 400; color: #fff;"> 알림 </h6>
									</div>
								</div>
							</div>
							<div data-simplebar style="max-height: 230px;">
								<?php if ($agent_list == null) { ?>
								<a href="page/cash/agent-list.php" class="text-reset notification-item">
									<div class="d-flex">
										<div class="flex-shrink-0 me-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
											  <g id="그룹_28343" data-name="그룹 28343" transform="translate(-95 -2055)">
												<circle id="타원_354" data-name="타원 354" cx="20" cy="20" r="20" transform="translate(95 2055)" fill="#fae100"/>
												<g id="그룹_28342" data-name="그룹 28342" transform="translate(116 13.592)">
												  <path id="패스_8863" data-name="패스 8863" d="M18.385,13.954c2.888-1.4,4.773-3.671,4.773-6.237C23.157,3.455,17.974,0,11.578,0S0,3.455,0,7.718s5.185,7.721,11.578,7.721a16.737,16.737,0,0,0,3.912-.462,11.366,11.366,0,0,0,6.058,2.5s-2.943-1.146-3.164-3.525M1.79,7.718c0-3.6,4.383-6.525,9.789-6.525s9.79,2.921,9.79,6.525-4.383,6.527-9.79,6.527S1.79,11.323,1.79,7.718" transform="translate(-13 2052.408)" fill="#fff"/>
												  <path id="패스_8864" data-name="패스 8864" d="M15.836,9.615a1.231,1.231,0,1,1-1.23-1.23,1.231,1.231,0,0,1,1.23,1.23" transform="translate(-16.027 2050.511)" fill="#fff"/>
												  <path id="패스_8865" data-name="패스 8865" d="M21.042,9.615a1.231,1.231,0,1,1-1.231-1.23,1.231,1.231,0,0,1,1.231,1.23" transform="translate(-17.205 2050.511)" fill="#fff"/>
												  <path id="패스_8866" data-name="패스 8866" d="M10.631,9.615A1.231,1.231,0,1,1,9.4,8.385a1.231,1.231,0,0,1,1.231,1.23" transform="translate(-14.849 2050.511)" fill="#fff"/>
												</g>
											  </g>
											</svg>
										</div>
										<div class="flex-grow-1">
											<div class="font-size-13 text-muted">
												<p style="font-size:15px; font-weight: 400; margin-top: 10px;">새로운 요청이 없습니다.</p>
											</div>
										</div>
									</div>
								</a>
								<?php } else {
									foreach($agent_list as $d) { ?>
								<a href="page/cash/agent-list.php" class="text-reset notification-item">
									<div class="d-flex">
										<div class="flex-shrink-0 me-3">
											<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40">
											  <g id="그룹_28343" data-name="그룹 28343" transform="translate(-95 -2055)">
												<circle id="타원_354" data-name="타원 354" cx="20" cy="20" r="20" transform="translate(95 2055)" fill="#fae100"/>
												<g id="그룹_28342" data-name="그룹 28342" transform="translate(116 13.592)">
												  <path id="패스_8863" data-name="패스 8863" d="M18.385,13.954c2.888-1.4,4.773-3.671,4.773-6.237C23.157,3.455,17.974,0,11.578,0S0,3.455,0,7.718s5.185,7.721,11.578,7.721a16.737,16.737,0,0,0,3.912-.462,11.366,11.366,0,0,0,6.058,2.5s-2.943-1.146-3.164-3.525M1.79,7.718c0-3.6,4.383-6.525,9.789-6.525s9.79,2.921,9.79,6.525-4.383,6.527-9.79,6.527S1.79,11.323,1.79,7.718" transform="translate(-13 2052.408)" fill="#fff"/>
												  <path id="패스_8864" data-name="패스 8864" d="M15.836,9.615a1.231,1.231,0,1,1-1.23-1.23,1.231,1.231,0,0,1,1.23,1.23" transform="translate(-16.027 2050.511)" fill="#fff"/>
												  <path id="패스_8865" data-name="패스 8865" d="M21.042,9.615a1.231,1.231,0,1,1-1.231-1.23,1.231,1.231,0,0,1,1.231,1.23" transform="translate(-17.205 2050.511)" fill="#fff"/>
												  <path id="패스_8866" data-name="패스 8866" d="M10.631,9.615A1.231,1.231,0,1,1,9.4,8.385a1.231,1.231,0,0,1,1.231,1.23" transform="translate(-14.849 2050.511)" fill="#fff"/>
												</g>
											  </g>
											</svg>
										</div>
										<div class="flex-grow-1">
											<div class="font-size-13 text-muted">
												<p style="font-size:15px; font-weight: 400;">체험단 요청이 도착했습니다.</p>
												<p class="mb-0"><span style="font-size:12px; font-weight: 400; color: #B9B9B9;"><?=substr($d['reg_date'],0,10)?></span></p>
											</div>
										</div>
									</div>
								</a>
								<?php }
								} ?>
							</div>
						</div>
					</div>
					<?php } ?>
                    <p><span><?=$_SESSION['name']?></span>님 환영합니다</p>
                    <a class="logout-link" href="/portfolio/works/moneypig/admin/logout.php" onclick="return outFunction();">로그아웃</a>
                </div>
            </header>