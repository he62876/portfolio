<?php include('../../lib/header2.php');?>
<div class="menu" style="margin-bottom:50px">
    <div class="page-bg"
        style="background: url('/portfolio/works/caravan/img/commubg1.png'); background-size: cover; background-position: center;">
        <h2>열린광장</h2>
        <h1 class="slides">소식공지</h1>
    </div>
    <div class="menu-select" style="height: 60px">
        <a href="/portfolio/works/caravan"><img src="/portfolio/works/caravan/img/home.svg" alt=""></a>
        <select name="" id="" onchange="location.href=value">
            <option value="/portfolio/works/caravan/page/company/info1.php">회사소개</option>
            <option value="http://211.233.5.220:8092/page/business/info1.php">사업안내</option>
            <!-- <option value="">이용안내</option> -->
            <option value="/portfolio/works/caravan/page/commu/noti.php" selected>열린광장</option>
        </select>
        <select name="" id="" class="side" onchange="location.href=value">
            <option value="/portfolio/works/caravan/page/commu/noti.php" selected>소식공지</option>
            <option value="/portfolio/works/caravan/page/commu/invest.php">투자문의</option>
            <option value="/portfolio/works/caravan/page/commu/qna.php">FAQ</option>
            <option value="/portfolio/works/caravan/page/page/commu/caravan.php">카라반매도의뢰신청</option>
            <option value="/portfolio/works/caravan/page/commu/shop.php">편의마켓입점신청</option>
        </select>
    </div>
</div>
<div class="container commu" style="padding-bottom: 150px;">
    <div class="table-responsive" style="margin-bottom: 10px;">
        <table class="table info-table board-table">
            <tr>
                <th class="table-light" style="border-bottom: 1px solid #dedede">제목</th>
            </tr>
            <tr>
                <!-- <th class="table-light">작성자</th> -->
                <td class="table-light">작성자 : 작성자 | 조회수 : 11</td>
            </tr>
            <tr>
                <td>공지사항입니다.</td>
            </tr>
        </table>
    </div>

    <div class="btn-box">
        <a href="noti.php"> 목록</a>
    </div>
</div>
<?php include('../../lib/footer.php');?>