<!DOCTYPE html>
<html lang="ko" id="html">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- plugin css -->
    <link href="/portfolio/works/caravan/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="/portfolio/works/caravan/assets/css/preloader.min.css" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="/portfolio/works/caravan/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="/portfolio/works/caravan/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="/portfolio/works/caravan/assets/css/app.css" id="app-style" rel="stylesheet" type="text/css" />


    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- jQuery UIW Css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <link rel="stylesheet" href="/portfolio/works/caravan/css/reset.css">
    <link rel="stylesheet" href="/portfolio/works/caravan/css/style.css">
    <title>카라반</title>
</head>
<body>
    <header class="header2">
        <div class="h-wrap">
            <a href="/portfolio/works/caravan/index.php" class="logo">
                <img src="/portfolio/works/caravan/img/logo2.svg" alt="" class="logo_img1">
                <img src="/portfolio/works/caravan/img/logo2.svg" alt="" class="logo_img2">
            </a>
            <ul class="main-menu">
                <li>
                    <a href="/portfolio/works/caravan/page/company/info1.php">회사소개</a>
                    <ul class="sub-menu">
                        <li><a href="/portfolio/works/caravan/page/company/info1.php">인사말</a></li>
                        <li><a href="/portfolio/works/caravan/page/company/info2.php">비전 및 전략</a></li>
                        <li><a href="/portfolio/works/caravan/page/company/map.php">찾아오시는 길</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/portfolio/works/caravan/page/business/info1.php">사업안내</a>
                    <ul class="sub-menu">
                        <li><a href="/portfolio/works/caravan/page/business/info1.php">사업소개</a></li>
                        <li><a href="/portfolio/works/caravan/page/business/info2.php">투자안내</a></li>
                        <li><a href="/portfolio/works/caravan/page/business/item.php">카라반상품안내</a></li>
                    </ul>
                </li>
                <!-- <li>
                    <a href="">이용안내</a>
                    <ul class="sub-menu">
                        <li><a href="/portfolio/works/caravan/page/invest.php">예약시스템소개</a></li>
                        <li><a href="">앱 다운로드</a></li>
                    </ul>
                </li> -->
                <li>
                    <a href="/portfolio/works/caravan/page/commu/noti.php">열린광장</a>
                    <ul class="sub-menu">
                        <li><a href="/portfolio/works/caravan/page/commu/noti.php">소식공지</a></li>
                        <li><a href="/portfolio/works/caravan/page/commu/invest.php">투자문의</a></li>
                        <li><a href="/portfolio/works/caravan/page/commu/qna.php">FAQ</a></li>
                        <li><a href="/portfolio/works/caravan/page/commu/caravan.php">카라반매도의뢰신청</a></li>
                        <li><a href="/portfolio/works/caravan/page/commu/shop.php">편의마켓입점신청</a></li>
                    </ul>
                </li>
            </ul>
            <div class="menu-background"></div>
            <div class="hamberger"
                onclick="document.all.menuModal.style.display = 'block'; document.all.html.style.overflow = 'hidden';">
                <img src="/portfolio/works/caravan/img/menu2.svg" alt="" class="menu1">
                <img src="/portfolio/works/caravan/img/menu2.svg" alt="" class="menu2">
            </div>
        </div>
    </header>
    <div id="menuModal">
        <div class="modal-content">
            <div class="modal-header">
                <p>메뉴</p>
                <div
                    onclick="document.all.menuModal.style.display = 'none'; document.all.html.style.overflow = 'scroll';">
                    <img src="/portfolio/works/caravan/img/close.svg" alt="">
                </div>
            </div>
            <div class="modal-body">
                <div class="container">
                    <ul class="pc">
                        <li class="menu-subject">
                            회사소개
                            <ul class="sub-menu">
                                <li><a href="/portfolio/works/caravan/page/company/info1.php">인사말</a></li>
                                <li><a href="/portfolio/works/caravan/page/company/info2.php">비전 및 전략</a></li>
                                <li><a href="/portfolio/works/caravan/page/company/map.php">찾아오시는 길</a></li>
                            </ul>
                        </li>
                        <li class="menu-subject">
                            사업안내
                            <ul class="sub-menu">
                                <li><a href="/portfolio/works/caravan/page/business/info1.php">사업소개</a></li>
                                <li><a href="/portfolio/works/caravan/page/business/info2.php">투자안내</a></li>
                                <li><a href="/portfolio/works/caravan/page/business/item.php">카라반상품안내</a></li>
                            </ul>
                        </li>
                        <!-- <li class="menu-subject">
                            시스템안내
                            <ul class="sub-menu">
                                <li><a href="">예약시스템소개</a></li>
                                <li><a href="">앱다운로드</a></li>
                            </ul>
                        </li> -->
                        <li class="menu-subject">
                            열린광장
                            <ul class="sub-menu">
                                <li><a href="/portfolio/works/caravan/page/commu/noti.php">소식공지</a></li>
                                <li><a href="/portfolio/works/caravan/page/commu/invset.php">투자문의</a></li>
                                <li><a href="/portfolio/works/caravan/page/commu/qna.php">FAQ</a></li>
                                <li><a href="/portfolio/works/caravan/page/commu/caravan.php">카라반매도의뢰신청</a></li>
                                <li><a href="/portfolio/works/caravan/page/commu/shop.php">편의마켓입점신청</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div id="sidebar-menu" class="mb">
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span>회사소개</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="/portfolio/works/caravan/page/company/info1.php">
                                            <span>인사말</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/company/info2.php">
                                            <span>비전 및 전략</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/company/map.php">
                                            <span>찾아오시는 길</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span>사업안내</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="/portfolio/works/caravan/page/business/info1.php">
                                            <span>사업소개</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/business/info2.php">
                                            <span>투자안내</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/business/item.php">
                                            <span>카라반상품안내</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span>시스템안내</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="/portfolio/works/caravan/page/">
                                            <span>예약시스템소개</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/">
                                            <span>앱다운로드</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> -->
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <span>열린광장</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li>
                                        <a href="/portfolio/works/caravan/page/commu/noti.php">
                                            <span>소식공지</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/commu/invset.php">
                                            <span>투자문의</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/commu/qna.php">
                                            <span>FAQ</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/commu/caravan.php">
                                            <span>카라반매도의뢰신청</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/portfolio/works/caravan/page/commu/shop.php">
                                            <span>편의마켓입점신청</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="b-warp">