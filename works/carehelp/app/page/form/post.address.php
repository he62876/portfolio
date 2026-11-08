<?php
header("Content-Type: text/html; charset=UTF-8");
?>

<!-- <script src="https://dmaps.daum.net/map_js_init/postcode.v2.js"></script> --> 
<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
<script>
    new daum.Postcode({
        oncomplete: function(data) {
            if(data.userSelectedType=="R"){
                // userSelectedType : 검색 결과에서 사용자가 선택한 주소의 타입
                // return type : R - roadAddress, J : jibunAddress
                window.Android.setAddress(data.zonecode, data.roadAddress, data.buildingName);
            } else {
                window.Android.setAddress(data.zonecode, data.roadAddress, data.buildingName);
            }
        }
    }).open();
</script>