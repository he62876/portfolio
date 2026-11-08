<?php
include('../../lib/header.php');
$title = "간병취소요청";
include('../../lib/title.php');
include('../../../common.php');

$hire_no = $_GET['hire_no'] == null ? 0:$_GET['hire_no'];
$pay_no  = $_GET['pay_no'] == null ? 0:$_GET['pay_no'];

$param = null;


if($hire_no != 0) {

	$sql = "SELECT cancel FROM hire_info WHERE hire_no = ".$hire_no;
	$cancel = $pdo->single($sql, $param);

	$sql = "SELECT pay_no FROM pay_info WHERE state = 2 AND hire_no = ".$hire_no;
	$pay1 = $pdo->single($sql, $param);

	$pay2 = $_GET['pay'];

	$pay = $pay2 == null ? $pay1:$pay2;
}
if($pay_no != 0) {
	$sql = "SELECT b.user_grade FROM pay_info a
			LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.pay_no = ".$pay_no;
	$user_grade = $pdo->single($sql, $param);

	$sql = "SELECT cancel FROM pay_info WHERE pay_no = ".$pay_no;
	$cancel = $pdo->single($sql, $param);

	$sql = "SELECT hire_no FROM pay_info WHERE pay_no = ".$pay_no;
	$hire1 = $pdo->single($sql, $param);

	$hire2 = $_GET['hire'];

	$hire = $hire2 == null ? $hire1:$hire2;
}

?>
<style>
    #title p {
        font-size: 1.1rem;
    }

    .content_page p {
        font-size: 1.3rem;
        font-weight: bold;
    }

    .btn_box {
		max-width: 768px;
		margin: 0 auto;
		display: flex;
        position: absolute;
        bottom: 0;
        width: 100%;
    }

</style>
<div class="content_wrap">
    <form action="json.php" method="POST">
		<input type="hidden" name="info" value="<?=$hire_no != 0 ? "hire":"pay"?>">
		<?php if($hire_no != 0) { ?>
		<input type="hidden" name="hire_no" value="<?=$hire_no?>">
		<input type="hidden" name="pay_no" value="<?=$pay?>">
		<?php } else if($pay_no != 0) { ?>
		<input type="hidden" name="hire_no" value="<?=$hire?>">
		<input type="hidden" name="pay_no" value="<?=$pay_no?>">
		<?php } ?>
        <div class="content_page">
            <p>취소사유를 입력해주세요</p>
            <div class="state_form d-block" style="margin: 20px 0;">
                <textarea name="cancel" id="" cols="30" rows="10" placeholder="예) 급한 사정으로 간병요청을 취소하겠습니다. 죄송합니다." <?=$cancel != null ? "disabled":""?>><?=$cancel?></textarea>
            </div>
            <p style="color: #3478F6; font-size:1.0rem; font-weight:500">- <?=$hire_no != 0 ? "간병사 또는 협회측에서": $user_grade == 1 ? "보호자가":"협회측에서" ?> 취소요청을 승인 시</br>
                   &nbsp;&nbsp;자동으로 종료처리가 됩니다.</br>
                </br>
				<?php if($hire_no != 0 && $pay == null) { ?>
                - 종료된 후 게시물을 재등록 할 수 있습니다.</br>
                </br>
				<?php } ?>
                - 취소요청을 승인하지 않을 경우 12시간 후</br>
                &nbsp;&nbsp;취소처리됩니다.</p>
        </div>
        <div class="btn_box">
			<?php if($cancel == null) { ?>
            <button name="mode" value="cancel" style="background: #3478F6; width: 100%;" type="button" onclick="cancelInput();">취소요청하기</button>
			<?php } else { ?>
            <button style="background: #000; width: 50%;">통화걸기</button>
            <button name="mode" value="cancel_ok" style="background: #3478F6; width: 50%;" type="button" onclick="cancelOKInput();">승인하기</button>
			<?php } ?>
        </div>
    </form>
			<div class="popup_form popup_form3" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 17px;">정말 삭제하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between" style="position: relative;">
						<button onclick="closeForm3();" type="button" style="width: 100%; background: #000000; border-bottom-right-radius:15px; border-bottom-left-radius:15px;">닫기</button>
					</div>
				</div>
			</div>
			<div class="popup_form popup_form4" style="z-index:55">
				<div class="area_form">
					<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 125px;">
						<div id="agree2" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 17px;">취소요청을 하시겠어요?</div>
					</div>
					<div class="btn_box d-flex justify-content-between" style="position: relative;">
						<button onclick="cancel();" type="button" style="width: 50%; background: #3478F6; border-bottom-left-radius:15px;">네</button>
						<button onclick="closeForm3();" type="button" style="width: 50%; background: #000000; border-bottom-right-radius:15px;">아니오</button>
						
					</div>
				</div>
			</div>
</div>
<?php
include('../../lib/footer.php');
?>
<script>
	function cancelInput() {
		var cancel = $("textarea[name='cancel']").val();
		//alert이 단말기에 따라 안보일수 있으므로 다른것으로 교체해야 할지도...
		if(cancel == "") { 
			document.getElementById('agree').innerHTML = '취소사유를 입력해주세요.';
			$('.popup_form3').css('display', 'block');
			return; 
		}  else {
			$('.popup_form4').css('display', 'block');
			return; 
		}
	}

	function cancelOKInput() {
		document.getElementById('agree2').innerHTML = '취소요청을 승인하시겠어요?';
		$('.popup_form4').css('display', 'block');
		return; 
	}

	function cancel() {
		var info = $("input[name='info']").val();
		var cancel = $("textarea[name='cancel']").val();
		var hire_no = $("input[name='hire_no']").val();
		var pay_no = $("input[name='pay_no']").val();
		var mode = $("button[name='mode']").val();


		$.ajax({type: 'POST',
			url: 'json.php',
			data:"&mode="+mode+"&info="+info+"&cancel="+cancel+"&hire_no="+hire_no+"&pay_no="+pay_no,
			dataType: 'json',
			cache: false,
			beforeSend: function() { },
			success: function(data) {
				try
				{
					//alert(data.resCode);
					if(data.resCode == 1){
						if(<?=$grade?> == 3) {
							window.location.href = "state3-list.php";
						} else {
							window.location.href = "state-list.php";
						}
					}
					else{
					
					}
				}
				catch(e)
				{
					console.log("error forward2 : " + e);
				}
			},
				error: function(data, status, err) {
				try{ console.log("error forward : " + data); alert(err); }
				catch(e){ console.log("error : " + e); alert('서버와의 통신이 실패했습니다.'); }
				return false;
			},
			complete: function() { },
			xhr: /*@cc_on false && @*/window.XMLHttpRequest ?
					function() { return new window.XMLHttpRequest(); } :
			function() { try { return new window.ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} }
		});

	}


    function closeForm3() {
        $('.popup_form').css('display', 'none');
    }

</script>