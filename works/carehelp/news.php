<?php
$page = 'news';
include('lib/header.php');
include('../../common.php');

$param = null;

$where = '';

$sql = "SELECT * FROM carehelp_news_info WHERE use_yn = 1 ORDER BY reg_date DESC";
$list_data = $pdo->query($sql, $param);
$cnt = $pdo->query("SELECT count(*) FROM carehelp_news_info WHERE use_yn = 1")->fetchColumn();
?>
<div id="index">
	<div class="swiper mySwiper">
		<div class="swiper-wrapper">
			<div class="bg bg4 swiper-slide" style="background: url('/portfolio/works/carehelp/web/img/bg5.png'); background-size: cover; background-position: center;">
				<p class="content" style="font-size: 50px; font-weight: 900">소식</p>
			</div>
		</div>
	</div>
	<div class="faq" style="background: #fff;">
		<?php if($cnt == 0) { ?>
			<div class="shadow_box">
				<p style="font-size: 25px; font-weight: 500">등록된 게시물이 없습니다.</p>
			</div>
		<?php } else {
			foreach($list_data as $d) { ?>
			<div class="shadow_box">
				<div class="que content_page" id="news_no<?=$d['news_no']?>">
					<div>
						<p><?=$d['subject']?></p>
					</div>
					<img src="/portfolio/works/carehelp/img/arrow_b.svg" alt="" class="arrow_b">
					<img src="/portfolio/works/carehelp/img/arrow_t.svg" alt="" class="arrow_t">
				</div>
				<div class="anw content_page">
					<p>
						<?=$d['content']?>
					</p>
				</div>
			</div>
		<?php } }?>
	</div>
</div>
<?php include('lib/footer.php'); ?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Initialize Swiper -->
<script>
	function Search_Page(n)
	{
		if(n == "#") return;
		$("#SearchForm").submit();//GetRow_item();
	}
    $(".que").click(function () {
        $(this).next(".anw").stop().slideToggle(300);
        $(this).toggleClass('on').siblings().removeClass('on');
        $(this).next(".anw").siblings(".anw").slideUp(300); // 1개씩 펼치기
		if($(this).hasClass('on')==true){
			//alert(noti_no);
			var news_no = Number(($(this).attr('id')).match(/\d+$/));;
			var seq = "news";
			var board = "news";
			$.ajax({type: 'POST',
				url: '/app/page/mypage/json.php',
				data:"&mode=hit&board="+board+"&seq="+seq+"&no="+news_no,
				dataType: 'json',
				cache: false,
				beforeSend: function() { },
				success: function(data) {
					try
					{
						//alert(data.resCode);
						if(data.resCode == 1){
							//location.reload();
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
		else{
			//alert('off');
		}
    });
</script>