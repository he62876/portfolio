<?php include('../../lib/header2.php');?>
<div class="menu">
    <div class="page-bg"
        style="background: url('/portfolio/works/caravan/img/commubg2.png'); background-size: cover; background-position: center;">
        <h2>열린광장</h2>
        <h1 class="slides">투자문의</h1>
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
            <option value="/portfolio/works/caravan/page/commu/invest.php" selected>투자문의</option>
            <option value="/portfolio/works/caravan/page/commu/qna.php">FAQ</option>
            <option value="/portfolio/works/caravan/page/commu/caravan.php">카라반매도의뢰신청</option>
            <option value="/portfolio/works/caravan/page/commu/shop.php">편의마켓입점신청</option>
        </select>
    </div>
</div>
<div class="container company" style="padding-bottom: 150px;">
    <p class="slidem commu-info">신청된 내용은 접수 후 24시간 이내에 회신됩니다</p>
    <form action="" class="commu-form commu-form2">
        <div class="input-box">
            <label for="select">관심분야</label>
            <div style="text-align:left">
                <div class="radio-box">
                    <input type="radio" name="type" id="type1">
                    <label for="type1">토지투자</label>
                </div>
                <div class="radio-box">
                    <input type="radio" name="type" id="type2">
                    <label for="type2">카라반투자</label>
                </div>
            </div>
        </div>
        <div class="input-box type1">
            <label for="">토지지번(주소)</label>
            <input type="text" class="form-control">
            <button>주소찾기</button>
        </div>
        <div class="input-box input-box2 type1" >
            <label for=""></label>
            <input type="text" class="form-control">
        </div>
        <div class="input-box type2">
            <label for="">차량대수</label>
            <select name="" id="" class="form-select">
                <option value="">선택하세요</option>
                <option value="">1대 ~ 4대 이하</option>
                <option value="">5대 ~ 9대 이하</option>
                <option value="">10대 이상</option>
            </select>
        </div>
        <div class="input-box">
            <label for="name">의뢰인명</label>
            <input type="text" id="name" class="form-control" placeholder="의뢰인명을 입력해주세요">
        </div>
        <div class="input-box">
            <label for="phone">연락처</label>
            <input type="text" id="phone" class="form-control" placeholder="연락처를 입력해주세요">
        </div>
        <div class="input-box">
            <label for="content">문의내용</label>
            <textarea name="" id="content" cols="30" rows="10" class="form-control" placeholder="내용을 입력해주세요"></textarea>
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
        <button class="slidem">문의하기</button>
    </form>
</div>
<?php include('../../lib/footer.php');?>
<script>
    $('.type1').hide();
    $('.type2').hide();

    $('input[name="type"]').click(function() {
        if($('#type1').is(':checked')) {
            $('.type1').show();
            $('.type2').hide();
        }
        if($('#type2').is(':checked')) {
            $('.type2').show();
            $('.type1').hide();
        }
    })

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