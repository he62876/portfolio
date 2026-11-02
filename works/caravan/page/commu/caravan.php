<?php include('../../lib/header2.php');?>
<div class="menu" style="margin-bottom:50px">
    <div class="page-bg"
        style="background: url('/portfolio/works/caravan/img/commubg4.png'); background-size: cover; background-position: center;">
        <h2>열린광장</h2>
        <h1 class="slides">카라반매도의뢰신청</h1>
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
            <option value="/portfolio/works/caravan/page/commu/qna.php">고객센터</option>
            <option value="/portfolio/works/caravan/page/commu/caravan.php" selected>카라반매도의뢰신청</option>
            <option value="/portfolio/works/caravan/page/commu/shop.php">편의마켓입점신청</option>
        </select>
    </div>
</div>
<div class="container company" style="padding-bottom: 150px;">
    <p class="slidem commu-info">신청된 내용은 접수 후 24시간 이내에 회신됩니다</br><span class="slidem" style="color:#F08200; font-size: 16px">* 본 서비스는 Mkon을 통해 카라반을 구매한 회원들만 이용 할 수 있습니다.</span></p>
    <form action="" class="commu-form">
        <p>의뢰자정보</p>
        <div class="input-box">
            <label for="email">이메일</label>
            <input type="text" id="email" class="form-control" placeholder="이메일 입력해주세요">
        </div>
        <div class="input-box">
            <label for="name">이름</label>
            <input type="text" id="name" class="form-control" placeholder="이름을 입력해주세요">
        </div>
        <div class="input-box">
            <label for="phone">연락처</label>
            <input type="text" id="phone" class="form-control" placeholder="연락처를 입력해주세요">
        </div>
        <p>차량정보</p>
        <div class="input-box">
            <label for="brand">브랜드명</label>
            <input type="text" id="brand" class="form-control" placeholder="브랜드명을 입력해주세요">
        </div>
        <div class="input-box">
            <label for="year">연식</label>
            <input type="text" id="year" class="form-control" placeholder="연식을 입력해주세요">
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
        <button class="slidem">의뢰하기</button>
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