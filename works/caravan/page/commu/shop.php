<?php include('../../lib/header2.php');?>
<div class="menu">
    <div class="page-bg"
        style="background: url('/portfolio/works/caravan/img/commubg5.png'); background-size: cover; background-position: center;">
        <h2>열린광장</h2>
        <h1 class="slides">편의마켓입점신청</h1>
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
            <option value="/portfolio/works/caravan/page/commu/qna.php">FAQ</option>
            <option value="/portfolio/works/caravan/page/commu/caravan.php">카라반매도의뢰신청</option>
            <option value="/portfolio/works/caravan/page/commu/shop.php" selected>편의마켓입점신청</option>
        </select>
    </div>
</div>
<div class="container company" style="padding-bottom: 150px;">
    <p class="slidem commu-info">신청된 내용은 접수 후 24시간 이내에 회신됩니다</p>
    <form action="" class="commu-form commu-form2">
        <p>계정정보</p>
        <div class="input-box">
            <label for="name">이름</label>
            <input type="text" id="name" class="form-control" placeholder="이름을 입력해주세요">
        </div>
        <div class="input-box">
            <label for="pass1">비밀번호</label>
            <input type="password" id="pass1" class="form-control" placeholder="비밀번호를 입력해주세요">
        </div>
        <div class="input-box">
            <label for="pass2">비밀번호확인</label>
            <input type="password" id="pass2" class="form-control" placeholder="비밀번호를 한번 더 입력해주세요">
        </div>
        <div class="input-box">
            <label for="email">이메일</label>
            <input type="text" id="email" class="form-control" placeholder="연락처를 입력해주세요">
        </div>
        <p>상가정보</p>
        <div class="input-box">
            <label for="">상가명</label>
            <input type="text" class="form-control" placeholder="상가명을 입력하세요">
        </div>
        <div class="input-box">
            <label for="">대표자명</label>
            <input type="text" class="form-control" placeholder="상가대표자명을 입력하세요">
        </div>
        <div class="input-box">
            <label for="">상가주소</label>
            <input type="text" class="form-control">
            <button>주소찾기</button>
        </div>
        <div class="input-box input-box2">
            <label for=""></label>
            <input type="text" class="form-control">
        </div>
        <div class="input-box input-box2">
            <label for=""></label>
            <input type="text" class="form-control" placeholder="나머지 주소를 입력하세요">
        </div>
        <div class="input-box">
            <label for="">상가전화번호</label>
            <input type="text" class="form-control" placeholder="상가전화번호를 입력하세요">
        </div>
        <div class="input-box">
            <label for="">연락처</label>
            <input type="text" class="form-control" placeholder="연락처를 입력하세요">
        </div>
        <p>사업자등록정보</p>
        <div class="input-box">
            <label for="number">사업자등록번호</label>
            <input type="text" id="number" class="form-control" placeholder="차종을 입력해주세요">
        </div>
        <div class="input-box">
            <label for="num_img">사본</label>
            <input type="text" id="num_img" class="form-control" placeholder="사업자등록증 사본을 올려주세요">
            <input type="file" id="file1">
            <label for="file1">업로드</label>
        </div>
        <p>계좌정보</p>
        <div class="input-box">
            <label for="">은행</label>
            <select name="" id="" class="form-select">
                <option value="">선택</option>
            </select>
        </div>
        <div class="input-box">
            <label for="">계좌번호</label>
            <input type="text" class="form-control" placeholder="계좌번호를 입력하세요">
        </div>
        <div class="input-box">
            <label for="">예금주</label>
            <input type="text" class="form-control" placeholder="이름을 입력하세요">
        </div>
        <p>이용약관동의</p>
        <div class="check-box" style="text-align: left; margin-bottom: 10px">
            <input type="checkbox" id="allcheck">
            <label for="allcheck" style="margin:0">[전체동의] 모든 약관에 동의합니다</label>
        </div>
        <div class="input-box input-box-link">
            <div class="check-box">
                <input type="checkbox" id="ck1">
                <label for="ck1">(필수) 서비스이용약관</label>
            </div>
            <a href="">보기</a>
        </div>
        <div class="input-box input-box-link">
            <div class="check-box">
                <input type="checkbox" id="ck2">
                <label for="ck2">(필수) 개인정보처리방침</label>
            </div>
            <a href="">보기</a>
        </div>
        <button class="slidem">입점신청하기</button>
    </form>
</div>
<?php include('../../lib/footer.php');?>
<script>
    $("#allcheck").click(function(){
		//만약 전체 선택 체크박스가 체크된상태일경우
		if($("#allcheck").prop("checked")) {
			//해당화면에 전체 checkbox들을 체크해준다
			$("input[type='checkbox']").prop("checked",true);
		// 전체선택 체크박스가 해제된 경우
		} else {
			//해당화면에 모든 checkbox들의 체크를해제시킨다.
			$("input[type='checkbox']").prop("checked",false);
		}
	})
</script>