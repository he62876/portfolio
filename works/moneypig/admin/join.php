
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
	<meta property="og:image" content="/img/moneypig_meta_guide.png">
	<meta property="og:description" content="내돈내산 리뷰쓰면 돈되지입니다">
	<meta property="og:url" content="https://moneypig.co.kr">
	<meta name="robots" content="index,follow">
	<meta name="google-site-verification" content="eXLmcYdidByhd62Jv7bpHnUjMmBJhp70BDC9CgIrHLo" />
	<meta name="naver-site-verification" content="ca313ff7297cfd1c8d9f558a9bc18bfd96d09b3b" />
	<link rel="shortcut icon" href="/img/money.ico">
    <meta http-equiv="Cache-Control" content="no-cache">

    <!-- Bootstrap Css -->
    <link href="/assets/css/bootstrap.css" id="bootstrap-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="/css/reset.css">
    <title>돈되지 관리자</title>
</head>
<?php
include('../common.php');

$param = null;

$sql = "SELECT * FROM agency_info WHERE grade = 1 AND agency_state = 1";
$cntr_list = $pdo->query($sql, $param);

$category = $pdo->query("SELECT * FROM code_info WHERE use_yn = 1 AND majr = 1 AND minr != 0  AND sub_category = 0", $param);
// $code = $_GET['code'] == null ? "" : $_GET['code'];
$grade = isset($_GET['grade']) ? $_GET['grade'] : 2;
?>
<style>
	@import url('https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@100;300;400;500;700;900&display=swap');
	@import url('https://cdn.rawgit.com/moonspam/NanumSquare/master/nanumsquare.css');

	* {
		font-family: 'Noto Sans KR', sans-serif;
		box-sizing: border-box;
		font-size: 15px;
	}


	html {
		height: 100vh;
	}

    body {
		/* height: 100%; */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
		background: linear-gradient( to bottom, #FAE100 50%, #fff 50% );
    }

	.join {
		background: #fff;
		margin: 200px 0;
		padding: 30px;
		border-radius: 15px;
		box-shadow: 0 3px 6px rgba(0,0,0,0.3);
	}

	strong {
		font-family: 'NanumSquare', sans-serif;
		display: block;
		margin-top: 30px;
		font-size: 20px;
		font-weight: 900;
	}

	select, input[type="text"], input[type="password"] {
		width: 100%;
		border: 1px solid #C2C2C2;
		border-radius: 5px;
		padding: 5px 10px;
		font-size: 14px;
	}
	input::placeholder {
		color: #BFBFBF;
	}

	input[type="radio"], input[type="checkbox"] {
		display: none;
	}

	input[type="radio"] + label {
		font-size: 16px;
		font-weight: 500;
		margin-right: 60px;
	}
	input[type="radio"] + label::before {
		content: '';
		display: inline-block;
		width: 20px; height: 20px;
		background: url('img/radio_off.svg');
		vertical-align: middle;
		margin-right: 10px;
	}
	input[type="radio"]:checked + label::before {
		background: url('img/radio_on.svg');
	}

	input[type="checkbox"] + label {
		font-size: 16px;
		font-weight: 400;
	}
	input[type="checkbox"] + label::before {
		content: '';
		display: inline-block;
		width: 20px; height: 20px;
		background: url('img/check_off.svg');
		vertical-align: middle;
		margin-right: 10px;
	}
	input[type="checkbox"]:checked + label::before {
		background: url('img/check_on.svg');
	}

	.table th {
		width: 100px;
		font-size: 16px;
		font-weight: 500;
		white-space: nowrap;
	}
	.table td {
		width: 240px;
		white-space: nowrap;
	}
	.table > :not(caption) > * > * {
		border-bottom-width: 0;
		padding: 0.4rem 0.75rem;
	}

	.btn-box {
		text-align: center;
		margin-top: 30px;
	}
	.btn-box a, .btn-box button {
		width: 100px;
		display: inline-block;
		padding: 12px 0;
		vertical-align: middle;
		border: 1px solid #C1C1C1;
		border-radius: 8px;
		font-size: 14px;
		font-weight: bold;
	}
	a, a:hover {
		color: #000;
		font-size: 14px;
		font-weight: bold;
		cursor: pointer;
	}
	a:not([href]):not([class]), a:not([href]):not([class]):hover {
		text-decoration: underline;
	}
	button {
		background: #343436;
		color: #fff;
		border-color: #343436;
	}

	.form button {
		display: inline-block;
		background: #0A1E38;
		border-radius: 5px;
		font-size: 14px;
		font-weight: 400;
		padding: 5px 0;
	}

	.form {
		margin-top: 10px;
	}
	.form > div, .form > div > div {
		display:flex;
		justify-content: space-between;
	}
	.form > div {
		width: 100%;
		margin-bottom: 10px;
	}
	.form > div > div {
		width: 49%;
	}
	.form > div > div label {
		display: inline-block;
		width: 100px;
	}
	.form > div > div select, .form > div > div input, .form > div > div > div {
		width: calc(100% - 100px);
	}

	@media screen and (max-width: 768px){
		body {height: auto;}
		.join {margin: 30px 0;}
		.form > div {flex-direction: column; margin-bottom: 0;}
		.form > div > div {width: 100%; margin-bottom: 10px;}
		.d-flex.justify-content-between.align-items-center {flex-direction: column;}
	}

	p {
		margin-bottom: 5px;
	}
	p img {
		width: 20px; 
		margin-right: 10px;
	}
</style>
<body>
	<div class="join">
		<form action="/portfolio/works/moneypig/admin/page/user/json.php" method="POST">
			<input type="hidden" name="board" value="<?=$grade == 3 ? "sell":"mngr"?>">
			<input type="hidden" name="mode" value="input">
			<input type="hidden" name="grade" value="<?=$grade?>">
            <input type="hidden" name="checked_id" id="checked_id" value="">
			<div class="d-flex justify-content-between align-items-center">
			<?php if($grade==2){?>
				<img src="/portfolio/works/moneypig/admin/img/join_logo.svg">
			<?php }else{?>
				<img src="/portfolio/works/moneypig/admin/img/join_logo1.svg">
			<?php }?>

				<p>검토 후 처리됩니다</p>
			</div>
			<strong>회원구분</strong>
			<div>
				<input type="radio" name="agency_tp" id="type1" value="1"><label for="type1">사업자</label>
				<input type="radio" name="agency_tp" id="type2" value="2"><label for="type2">개인</label>
			</div>
			<strong>기본정보</strong>
			<div class="form">
				<div>
					<div>
						<label for="cntr_no"><?=$grade==2? "대리점코드":"센터코드"?></label>
						<input type="text" name="distributor_code" id="distributor_code" value="<?=isset($code) ? $code:''?>" placeholder="알고 계신 <?=$grade==2? "대리점":"센터"?>코드를 입력하세요">
						<!--<select name="distributor_no" id="cntr_no">
							<option value="0">총판을 선택하세요.</option>
							<?php foreach($cntr_list as $d) { ?>
							<option value="<?=$d['agency_no']?>"><?=$d['agency_nm']?></option>
							<?php } ?>
						</select>-->
					</div>
				</div>
				<div>
					<div>
						<label for="agency_nm"><?=$grade==2? "매니저명":"대리점명"?></label>
						<?php if($grade==2){?>
						<input type="text" name="agency_nm" id="agency_nm" value="" placeholder="매니저명을 입력하세요">
						<?php }else{?>
						<input type="text" name="agency_nm" id="agency_nm" value="" placeholder="대리점명을 입력하세요">
						<?php }?>
					</div>
				</div>
				<div>
					<div>
						<label for="agency_id">ID</label>
						<div>
							<input type="text" name="agency_id" id="agency_id" value="" placeholder="아이디를 입력하세요" style="width: 70%;" onkeyup="checkReg(event)" onchange="change_id()">
							<button type="button" style="width: 28%; cursor:pointer;" onclick="idck()">중복확인</button>
							<input type='hidden' id="chk_id" name='chk_id' value="0">
						</div>
					</div>
					<div>
						<label for="agency_pw">비밀번호</label>
						<div>
							<input type="password" name="agency_pw" id="agency_pw" placeholder="비밀번호를 입력하세요" style="margin-bottom: 5px;width: 100%;"></br>
							<input type="password" id="agency_pw2" placeholder="비밀번호를 한번 더 입력하세요" style="width: 100%;">
						</div>
					</div>
				</div>
				<div id="type1Ck">
					<div>
						<label for="biz_num">사업자번호</label>
						<input type="text" name="biz_num" id="biz_num" value="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="사업자번호를 입력하세요">
					</div>
					<div>
						<label for="ceo_nm">대표자명</label>
						<input type="text" name="ceo_nm" id="ceo_nm" value="" placeholder="대표자명을 입력하세요">
					</div>
				</div>
				<div>
					<div>
						<label for="tel">연락처</label>
						<input type="text" name="tel" id="tel" value="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="연락처를 입력하세요">
					</div>
					<div>
						<label for="email">이메일</label>
						<input type="text" name="email" id="email" value="" placeholder="이메일을 입력하세요">
					</div>
				</div>
				<div>
					<div>
						<label for="addr">주소</label>
						<div>
							<input type="text" name="address" id="addr" value="" placeholder="주소를 입력하세요" style="margin-bottom: 5px; width: 70%;" onclick="sample6_execDaumPostcode();" readonly>
                            <button type="button" style="width: 28%; cursor:pointer;margin-bottom: 5px" onclick="sample6_execDaumPostcode();">주소검색</button></br>
							<input type="text" name="address_det" id="addr1" value="" placeholder="상세주소를 입력하세요" style="width: 100%;">
						</div>
					</div>
					<div>
						<label for="account_bank">정산받을</br>계좌</label>
						<div>
							<input type="text" name="account_bank" id="account_bank" value="" placeholder="은행명을 입력하세요" style="width: 100%;"></br>
							<input type="text" name="account_num" id="account_num" value="" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="계좌번호를 입력하세요" style="margin: 5px 0;width: 100%;"></br>
							<input type="text" name="account_owner" id="account_owner" value="" placeholder="예금주명을 입력하세요" style="width: 100%;">
						</div>
					</div>
				</div>
			</div>
			<?php if($grade==2){?>
			<strong>인플루언서이신가요?</strong>
			<div>
				<input type="radio" name="memb_tp" id="type3" value="1"><label for="type3">예</label>
				<input type="radio" name="memb_tp" id="type4" value="0"><label for="type4">아니오</label>
			</div>
			<?php }?>
			<div id="type3Ck">
				<strong>인플루언서정보<span style="font-size: 16px;">(선택)</span></strong>
				<div class="form">
					<div>
						<div>
							<label for="category">활동분야</label>
							<select name="category" id="category">
								<option value="0">활동분야를 선택하세요</option>
								<?php foreach($category as $d) { ?>
								<option value="<?=$d['minr']?>"><?=$d['name']?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<p><img src="/portfolio/works/moneypig/admin/upload/icon/img20231214114030.png">네이버블로그</p>
					<div id="">
						<div>
							<label for="blog_url">주소</label>
							<input type="text" name="blog_url" id="blog_url" placeholder="네이버블로그 주소를 입력하세요">
						</div>
						<div>
							<label for="blog_info">이웃 수</label>
							<input type="text" name="blog_info" id="blog_info" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="네이버블로그 이웃 수를 입력하세요">
						</div>
					</div>
					<p><img src="/portfolio/works/moneypig/admin/upload/icon/img20231214114237.png">인스타그램</p>
					<div id="">
						<div>
							<label for="instar_url">주소</label>
							<input type="text" name="instar_url" id="instar_url" placeholder="인스타그램 주소를 입력하세요">
						</div>
						<div>
							<label for="instar_info">팔로워 수</label>
							<input type="text" name="instar_info" id="instar_info" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="인스타그램 팔로워 수를 입력하세요">
						</div>
					</div>
					<p><img src="/portfolio/works/moneypig/admin/upload/icon/img20231214114246.png">유튜브 쇼츠</p>
					<div id="">
						<div>
							<label for="youtube_url">주소</label>
							<input type="text" name="youtube_url" id="youtube_url"  placeholder="유튜브 주소를 입력하세요">
						</div>
						<div>
							<label for="youtube_info">구독자 수</label>
							<input type="text" name="youtube_info" id="youtube_info" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="유튜브 구독자 수를 입력하세요">
						</div>
					</div>
					<p><img src="/portfolio/works/moneypig/admin/upload/icon/img20231214114257.png">틱톡</p>
					<div id="">
						<div>
							<label for="tictok_url">주소</label>
							<input type="text" name="tictok_url" id="tictok_url"  placeholder="틱톡 주소를 입력하세요">
						</div>
						<div>
							<label for="tictok_info">구독자 수</label>
							<input type="text" name="tictok_info" id="tictok_info" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" placeholder="틱톡 구독자 수를 입력하세요">
						</div>
					</div>
				</div>
			</div>
			<strong>약관동의</strong>
			<div>
				<input type="checkbox" id="chk1">
				<label for="chk1">서비스 이용약관에 동의합니다</label>
				<a onclick="window.open('/app/terms/terms1.php', 'PopupWin', 'top=500,right=200,width=850,height=500');">보기</a>
			</div>
			<div>
				<input type="checkbox" id="chk2">
				<label for="chk2">개인정보 처리방침에 동의합니다</label>
				<a onclick="window.open('/app/terms/terms2.php', 'PopupWin', 'top=500,right=200,width=850,height=500');">보기</a>
			</div>
			<div class="btn-box">
				<a href="login.php">돌아가기</a>
				<button onclick="return myFunction();">가입신청</button>
			</div>
		</form>
        <iframe src="" id="ifrm1" scrolling='no' frameborder='no' width='0' height='0' name="ifrm1"></iframe>
	</div>
<!-- JAVASCRIPT -->

<script src="/portfolio/assets/libs/jquery/jquery.min.js"></script>
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>

    if($('#type1').is(':checked')) {
        $('#type1Ck').show();
    }
    else {
        $('#type1Ck').hide();
    }
    $('input[name="agency_tp"]').click(function() {
        if($('#type1').is(':checked')) {
            $('#type1Ck').show();
        }
        if(!$('#type1').is(':checked')) {
            $('#type1Ck').hide();
        }
    });

    if($('#type3').is(':checked')) {
        $('#type3Ck').show();
    }
    else {
        $('#type3Ck').hide();
    }
    $('input[name="memb_tp"]').click(function() {
        if($('#type3').is(':checked')) {
            $('#type3Ck').show();
        }
        if(!$('#type3').is(':checked')) {
            $('#type3Ck').hide();
        }
    });

    function myFunction() {
        if(!$('input[name="agency_tp"]').is(':checked')) {
            alert('분류를 선택하세요.');
            return false;
        }
        if($('#distributor_code').val() == '') {
            alert('대리점코드를 입력해주세요.');
            return false;
        }
        if($('#agency_nm').val() == '') {
            alert('매니저명을 입력해주세요.');
            return false;
        }
        if($('#agency_id').val() == '') {
            alert('아이디를 입력해주세요.');
            return false;
        }
        if($("input[name='checked_id']").val()!='y'){
            alert('아이디 중복확인을 해주세요.');
            $("input[name='checked_id']").eq(0).focus();
            return false;
    	}
        if($('#agency_pw').val() == '') {
            alert('비밀번호를 입력해주세요.');
            return false;
        }
        if($('#agency_pw').val() != $('#agency_pw2').val()) {
            alert('비밀번호를 확인해주세요.');
            return false;
        }
        if($('#type1').is(':checked')) {
			if($('#biz_num').val() == '') {
				alert('사업자번호를 입력해주세요.');
				return false;
			}
			if($('#ceo_nm').val() == '') {
				alert('대표자명을 입력해주세요.');
				return false;
			}
        }
        if($('#tel').val() == '') {
            alert('연락처를 입력해주세요.');
            return false;
        }
        if($('#email').val() == '') {
            alert('이메일을 입력해주세요.');
            return false;
        }
        if($('#addr').val() == '') {
            alert('주소를 입력해주세요.');
            return false;
        }
        if($('#account_bank').val() == '' || $('#account_num').val() == '' || $('#account_owner').val() == '') {
            alert('계좌를 입력해주세요.');
            return false;
        }
		<?php if($grade != 3) { ?>
        if(!$('input[name="memb_tp"]').is(':checked')) {
            alert('인플루언서 여부를 선택하세요.');
            return false;
        }
		<?php } ?>
        if($('#type3').is(':checked')) {
			if($('#blog_url').val() == '' && $('#blog_info').val() != '') {
				alert('네이버블로그 주소를 입력해주세요.');
				return false;
			}
			if($('#instar_url').val() == '' && $('#instar_info').val() != '') {
				alert('인스타그램 주소를 입력해주세요.');
				return false;
			}
			if($('#youtube_url').val() == '' && $('#youtube_info').val() != '') {
				alert('유튜브 주소를 입력해주세요.');
				return false;
			}
			if($('#tictok_url').val() == '' && $('#tictok_info').val() != '') {
				alert('틱톡 주소를 입력해주세요.');
				return false;
			}
        }
        if(!$('#chk1').is(':checked')) {
            alert('서비스 이용약관에 동의해주세요.');
            return false;
        }
        if(!$('#chk2').is(':checked')) {
            alert('개인정보 처리방침에 동의해주세요.');
            return false;
        }
        
        var check = confirm("가입 신청하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }
    }

    function myFunction2() {
        var check = confirm("진행하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }
    }

    function change_id() {
        document.getElementById("checked_id").value = 'n';
    }
    
    function idck() {
        var user_id = document.getElementById("agency_id").value;
        if (user_id.length >= 4) {
            ifrm1.location.href = "join.ck.php?agency_id=" + user_id;
            // window.open(url, "user_id", "width=400,height=200");
            // document.getElementById("checked_id").value = 'n';


        } else {
            alert("아이디를 4자 이상 입력해주세요.");
        }
        
    }



    function sample6_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function (data) {
                 // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                 // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                 // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                 var addr = ''; // 주소 변수
                 var extraAddr = ''; // 참고항목 변수

                 //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                 if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                     addr = data.roadAddress;
                 } else { // 사용자가 지번 주소를 선택했을 경우(J)
                     addr = data.jibunAddress;
                 }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if (data.userSelectedType === 'R') {
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if (data.buildingName !== '' && data.apartment === 'Y') {
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if (extraAddr !== '') {
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    document.getElementById("addr1").value = extraAddr;

                 } else {
                     document.getElementById("addr1").value = '';
                 }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                //document.getElementById('zip1').value = data.zonecode;
                document.getElementById("addr").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                document.getElementById("addr1").focus();
            }
        }).open();
    }

function checkReg(event) {
  const regExp = /[^0-9a-zA-Z]/g; // 숫자와 영문자만 허용
//   const regExp = /[^ㄱ-ㅎ|가-힣]/g; // 한글만 허용
  const del = event.target;
  if (regExp.test(del.value)) {
    del.value = del.value.replace(regExp, '');
  }
};
</script>
</body>

</html>
