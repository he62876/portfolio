<?php
$page = 'faq';
include('lib/header.php');
include('../../common.php');

$param = null;
$type = (isset($_POST["category"])? $_POST["category"]: 0);

$where = '';

if($type > 0) {
    $where .= " AND a.category = ".$type;
}

$sql = "SELECT *, c.name as category FROM carehelp_faq_info a
		LEFT OUTER JOIN carehelp_code_info c ON a.category = c.minr AND c.majr = 1
		WHERE a.grade1 = 1 AND a.use_yn = 1 ".$where." ORDER BY a.reg_date DESC";
$list_data = $pdo->query($sql, $param);
$category = $pdo->query("SELECT * FROM carehelp_code_info WHERE majr = 1 AND minr != 0 AND use_yn = 1", $param);
$cnt = $pdo->query("SELECT count(*) FROM carehelp_faq_info a
					LEFT OUTER JOIN carehelp_code_info c ON a.category = c.minr AND c.majr = 1
					WHERE a.grade1 = 1 AND a.use_yn = 1 ".$where)->fetchColumn();
?>
<div id="index">
	<div class="swiper mySwiper">
		<div class="swiper-wrapper">
			<div class="bg bg4 swiper-slide" style="background: url('/portfolio/works/carehelp/web/img/bg4.png'); background-size: cover; background-position: center;">
				<p class="content" style="font-size: 50px; font-weight: 900">자주묻는질문</p>
			</div>
		</div>
	</div>
	<div class="faq" style="background: #fff;">
        <form action="faq.php" id='SearchForm' method="POST" class="state_form">
            <select name="category" id="" onchange="Search_Page(1);">
                <option value="0">카테고리 선택</option>
				<?php foreach($category as $c) { ?>
                <option value="<?=$c['minr']?>" <?=$c['minr'] == $type ? "selected":""?>><?=$c['name']?></option>
				<?php } ?>
            </select>
        </form>
		<?php if($cnt == 0) { ?>
			<div class="shadow_box">
				<p style="font-size: 25px; font-weight: 500">등록된 게시물이 없습니다.</p>
			</div>
		<?php } else {
			foreach($list_data as $d) { ?>
			<div class="shadow_box">
				<div class="que content_page" id="faq_no<?=$d['faq_no']?>">
					<div>
						<span><?=$d['category']?></span>
						<p><?=$d['faq_subject']?></p>
					</div>
					<img src="/portfolio/works/carehelp/img/arrow_b.svg" alt="" class="arrow_b">
					<img src="/portfolio/works/carehelp/img/arrow_t.svg" alt="" class="arrow_t">
				</div>
				<div class="anw content_page">
					<p>
						<?=nl2br($d['faq_cont'])?>
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
			var faq_no = Number(($(this).attr('id')).match(/\d+$/));;
			var seq = "faq";
			var board = "faq";
			$.ajax({type: 'POST',
				url: '/app/page/mypage/json.php',
				data:"&mode=hit&board="+board+"&seq="+seq+"&no="+faq_no,
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