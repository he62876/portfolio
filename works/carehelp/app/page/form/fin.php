<?php

include('../../lib/header.php');
$title = "요청완료";
include('../../lib/title.php');
include('../../../common.php');

?>
<style>
#title p {
    font-size: 1.1rem;
}
#title img {
    display: none;
}

.content_page {
    height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
}
.content_page p {
    text-align: center;
}

.state_info {
	max-width: 768px;
	margin: 0 auto;
    position: absolute;
    bottom: 0;
}

img {
    width: 35%;
    margin-bottom: 30px;
}
</style>
<div class="countent_wrap">
    <div class="content_page">
        <img src="/img/pay_form.png" alt="">
        <p style="font-size: 1.4rem; font-weight: bold; margin-bottom: 10px;">간병인 요청완료!</p>
        <p style="font-size: 1.1rem; font-weight: 400;">간병인 요청이 완료되었습니다.</br>요청현황에서 간병인들의</br>지원을 확인할 수 있습니다.</br></br></br></br></br></p>
    </div>
    <div class="state_info">
        <a href="/app/page/state/state<?=$grade == 3 ? 3:""?>-list.php" style="background: #3478F6; width: 100%"><?=$grade == 1 ? "요청":"구인"?>현황으로 이동</a>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>