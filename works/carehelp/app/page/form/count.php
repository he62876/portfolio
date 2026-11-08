<?php
include('../../lib/header.php');
include('../../../common.php');

$param = null;

$sql = "SELECT count(*) FROM user_info WHERE state = 1 AND user_grade = 2";
$user_cnt = $pdo->single($sql, $param);

$sql = "SELECT count(*) FROM hire_info WHERE use_yn = 1";
$hire_cnt = $pdo->single($sql, $param);
?>
<style>
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
</style>
<div class="countent_wrap">
    <div class="content_page">
        <p style="font-size: 1.4rem; font-weight: bold; margin-bottom: 10px;">전문 간병인들을 만나보세요!</p>
        <p style="font-size: 1.1rem; font-weight: 400;">환자 특성에 맞춰 가족같이 돌봐줄</br>간병인들이 대기 중입니다.</p>
        <div style=" margin-top: 50px;">
            <p style="color: #3478F6; font-size: 1.1rem; font-weight: 400;">대기 중인 간병사</p>
            <p ><span class="odd" style="color: #3478F6; font-size: 2rem; font-weight: bold;" ><?=number_format($user_cnt)?></span><span style="color: #3478F6; font-size: 2rem; font-weight: bold;" >명</span></p>
			
        </div>
        <div style=" margin-top: 40px;">
            <p style="color: #3478F6; font-size: 1.1rem; font-weight: 400;">지금까지 등록된 견적</p>
            <p ><span class="odd" style="color: #3478F6; font-size: 2rem; font-weight: bold;" ><?=number_format($hire_cnt)?></span><span style="color: #3478F6; font-size: 2rem; font-weight: bold;" >건</span></p>
        </div>
    </div>
    <div class="state_info">
        <a href="<?=$grade == 1 ?  '/app/index.php':'/app/page/state/state3-list.php'?>" style="color:#fff; background: #000; width: 50%">돌아가기</a>
        <a href="pay-form1.php" style="background: #3478F6; width: 50%">간병요청하기</a>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>

<script src='../../js/jquery.waypoints.min.js'></script>
<script src='../../js/jquery.counterup.min.js'></script>

<script type="text/javascript">
jQuery(document).ready(function( $ ) {
   
	 $('.odd').counterUp({
        delay: 10,
        time: 1000
    });
});
</script>