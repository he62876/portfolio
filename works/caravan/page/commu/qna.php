<?php include('../../lib/header2.php');?>
<div class="menu" style="margin-bottom:50px">
    <div class="page-bg"
        style="background: url(/portfolio/works/caravan/img/commubg3.png'); background-size: cover; background-position: center;">
        <h2>열린광장</h2>
        <h1 class="slides">FAQ</h1>
    </div>
    <div class="menu-select" style="height: 60px">
        <a href="/portfolio/works/caravan"><img src="/portfolio/works/caravan/img/home.svg" alt=""></a>
        <select name="" id="" onchange="location.href=value">
            <option value="/portfolio/works/caravan/page/company/info1.php">회사소개</option>
            <option value="/portfolio/works/caravan/page/business/info1.php">사업안내</option>
            <!-- <option value="">이용안내</option> -->
            <option value="/portfolio/works/caravan/page/commu/noti.php" selected>열린광장</option>
        </select>
        <select name="" id="" class="side" onchange="location.href=value">
            <option value="/portfolio/works/caravan/page/commu/noti.php">소식공지</option>
            <option value="/portfolio/works/caravan/page/commu/invest.php">투자문의</option>
            <option value="/portfolio/works/caravan/page/commu/qna.php" selected>FAQ</option>
            <option value="/portfolio/works/caravan/page/commu/caravan.php">카라반매도의뢰신청</option>
            <option value="/portfolio/works/caravan/page/commu/shop.php">편의마켓입점신청</option>
        </select>
    </div>
</div>
<div class="container commu" style="padding-bottom: 150px;">
    <div class="d-flex align-items-center title-search" >
        <p class="table-count">전체 <span>11</span>건</p>
        <form method="_GET" id='SearchForm' action="noti-list.php" >
            <input type="hidden" name="page" id='ContetCurrentPage' value='<?=$page?>'>
            <div class="d-flex justify-content-between align-items-center search-form">
                <select class="form-select" name="category" id=""style="margin-right: 5px;">
                    <option value="1" <?=$category == 1 ? "selected":""?>>제목</option>
                    <option value="2" <?=$category == 2 ? "selected":""?>>내용</option>
                </select>
                <input type="text" name="keyword" class="form-control" style="margin-right: 5px;" value="<?=$keyword?>" placeholder="검색어를 입력하세요">
                <button onclick="Search_Page(1);">검색</button>
            </div>
        </form>
    </div>
    <!-- <div class="cate-list">
        <input type="radio" name="category" id="cate0" checked><label for="cate0">전체</label>
        <input type="radio" name="category" id="cate1"><label for="cate1">회원가입</label>
        <input type="radio" name="category" id="cate2"><label for="cate2">예약방법</label>
        <input type="radio" name="category" id="cate3"><label for="cate3">서비스이용</label>
        <input type="radio" name="category" id="cate4"><label for="cate4">카라반</label>
        <input type="radio" name="category" id="cate5"><label for="cate5">편의마켓</label>
        <input type="radio" name="category" id="cate6"><label for="cate6">옵션</label>
        <input type="radio" name="category" id="cate7"><label for="cate7">결제관련</label>
        <input type="radio" name="category" id="cate8"><label for="cate8">환불 및 예약취소</label>
    </div> -->
    <div class="table-responsive pc">
        <table class="table">
            <thead>
                <tr>
                    <th class="table-light" style="width:80px">순번</th>
                    <th class="table-light">제목</th>
                    <th class="table-light" style="width:100px">작성자</th>
                    <th class="table-light" style="width:100px">작성일</th>
                    <th class="table-light" style="width:80px">조회수</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>5</td>
                    <td><a href="qna-info.php">질문입니다</a></td>
                    <td>홍길동</td>
                    <td>2022-06-30</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td><a href="qna-info.php">질문입니다</a></td>
                    <td>홍길동</td>
                    <td>2022-06-30</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td><a href="qna-info.php">질문입니다</a></td>
                    <td>홍길동</td>
                    <td>2022-06-30</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td><a href="qna-info.php">질문입니다</a></td>
                    <td>홍길동</td>
                    <td>2022-06-30</td>
                    <td>35</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td><a href="qna-info.php">질문입니다</a></td>
                    <td>홍길동</td>
                    <td>2022-06-30</td>
                    <td>35</td>
                </tr>
            </tbody>
        </table>
    </div>
    <ul class="mb" style="margin-bottom: 10px">
        <li style="text-align: left; padding: 10px; border-bottom:1px solid #d4d4d4">
            <a href="">
                <p>질문입니다</p>
                <span>2022-06-30 | 조회수 66</span>
            </a>
        </li>
        <li style="text-align: left; padding: 10px; border-bottom:1px solid #d4d4d4">
            <a href="">
                <p>질문입니다</p>
                <span>2022-06-30 | 조회수 66</span>
            </a>
        </li>
        <li style="text-align: left; padding: 10px; border-bottom:1px solid #d4d4d4">
            <a href="">
                <p>질문입니다</p>
                <span>2022-06-30 | 조회수 66</span>
            </a>
        </li>
        <li style="text-align: left; padding: 10px; border-bottom:1px solid #d4d4d4">
            <a href="">
                <p>질문입니다</p>
                <span>2022-06-30 | 조회수 66</span>
            </a>
        </li>
        <li style="text-align: left; padding: 10px; border-bottom:1px solid #d4d4d4">
            <a href="">
                <p>질문입니다</p>
                <span>2022-06-30 | 조회수 66</span>
            </a>
        </li>
    </ul>
    <ul class="page-list">
        <li><a href=""><<</a></li>
        <li><a href=""><</a></li>
        <li class="on"><a href="">1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li>
        <li><a href="">4</a></li>
        <li><a href="">5</a></li>
        <li><a href="">></a></li>
        <li><a href="">>></a></li>
    </ul>
</div>
<?php include('../../lib/footer.php');?>