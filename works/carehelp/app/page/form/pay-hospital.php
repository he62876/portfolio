<?php
include('../../lib/header.php');
$title = "간병장소선택";
include('../../lib/title.php');
include('../../../common.php');
?>	
<style>
	
	body {
		height: 100vh;
		overflow: hidden;
	}

	#wrap, .content_wrap, .popup {
		height: 100%;
		width: 100%;
	}
	
	#title {
		text-align: center;
		padding: 3% 0;
		background: #fff;
		width: 100%;
		max-width: 768px;
	}

	.popup .state_form.d-flex {
		max-width: 768px;
	}

	#agency_cnt {
		width: 100%;
		max-width: 768px;
		margin: 0 15px;
	}

	
	input[type=checkbox] + label {
        font-size: 1.0rem;
        vertical-align: middle;
    }
    input[type=checkbox] + label::before {
        content: '';
        display: inline-block;
        vertical-align: bottom;
        width: 25px; height: 25px;
        background: url('../../../img/check_off.svg');
        background-size: cover;
        margin-right: 10px;
    }
    input[type=checkbox]:checked + label::before {
        background: url('../../../img/check_on.svg');
        background-size: cover;
    }

	#agency_list {
		height: 200px;
		overflow-y: scroll;
	}
	#agency_list li {
		width: 100%;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

</style>
<div class="content_wrap">

	<div class="popup_form popup_form3" >
		<div class="area_form">
			<div class="d-flex justify-content-between" style="flex-wrap: wrap;padding: 15px;height: 180px;">
				<div id="agree3" style="width: 100%;text-align: center;margin-top: 30px;font-weight: bold;font-size: 22px;">서비스 이용약관에 동의해주세요.</div>
			</div>
			<div class="btn_box d-flex justify-content-between">
				<button onclick="closeForm3();" type="button" style="width: 100%; background: #3478F6; border-bottom-left-radius:15px;border-bottom-right-radius:15px;">닫기</button>
			
			</div>
		</div>
	</div>

	<div class="popup">
		<div class="state_form d-flex" style="margin: 15px;">
			<input type="text" id="hospital" placeholder="병원명을 입력해주세요."><button type="button" onclick="select_hospital();" style="position: relative;width: 20%; min-width: 64px;">검색</button>
		</div>
		<p id="agency_cnt" style="margin: 0 15px;">검색결과 <span style="color: #3478F6;">0개</span></p>
		<ul id="agency_list" class="state_list" style=" margin: 15px; height: calc(100% - 190px);" >
			<!--<li>병원명을 검색해주세요.</li>-->
		</ul>
	</div>
</div>
<?php
include('../../lib/footer.php');
?>
<script>

function select_hospital(){
	var hospital = document.getElementById("hospital");  
	var selectValue = hospital.value;  
	//alert(selectValue);
	if(selectValue == '') {

		document.getElementById('agree3').innerHTML = '병원명을 입력해주세요.';
		$('.popup_form3').css('display', 'block');
		return;

	} else {
		$.ajax({type: 'POST',
			url: '/app/page/state/json.php',
			data:"&mode=serch_hospital&hospital_nm="+selectValue,
			dataType: 'json',
			cache: false,
			beforeSend: function() { },
			success: function(data) {
				try
				{
					//alert(data.resCode);
					if(data.resCode == 1){
						//alert(JSON.stringify(data.gugun));
						$( '#agency_list' ).empty();
						if(data.hospital == null) {
							$( '#agency_cnt' ).html( '검색결과 <span style="color: #3478F6;">0개</span>' );
							$( '#agency_list' ).append( '<li>조회된 결과가 없습니다.</li>' );
						} else { 
							$( '#agency_cnt' ).html( '검색결과 <span style="color: #3478F6;">'+data.hospital.length+'개</span>' );
							for ( var i = 0; i < data.hospital.length; i++ ) {
								//alert(data.gugun[ i ]['gugun']);
								str = '';
								str += '<li class="state_form" onclick="hospital_input('+'\''+data.hospital[ i ]['dutyName']+'\',\''+data.hospital[ i ]['dutyAddr']+'\');">';
								str += '<div style="text-align: left;">';
								str += '<p>' + data.hospital[ i ]['dutyName'] + '</p>';
								str += '<span style="color: #8A8A8A; margin-top: 5px;">' + data.hospital[ i ]['dutyAddr'] + '</span>';
								str += '</div>';
								str += '<img src="/img/arrow.svg" style="position: relative; margin: 0; width: 30px; min-width: 30px;">';
								str += '</li>'
								$( '#agency_list' ).append( str );
							}
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
}

function closeForm3(){
	$('.popup_form3').css('display', 'none');
}

function hospital_input(name, addr) {
	setCookie("addr1", encodeURIComponent(addr), 1);
	setCookie("hospital_name", encodeURIComponent(name), 1);
	location.replace("pay-form1.php");
}

function setCookie(cookieName, value, exdays){
    var exdate = new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var cookieValue = escape(value) + ((exdays==null) ? "" : "; expires=" + exdate.toGMTString());
    document.cookie = cookieName + "=" + cookieValue;
}
 
</script>