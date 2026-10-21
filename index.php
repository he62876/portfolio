<?php 
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/inc/header.php');

// 작업물 리스트 조회
$sql = "SELECT * FROM work_data WHERE state = 1 ORDER BY no ASC";
$data = $pdo->query($sql);
$work_list = $data->fetchAll(PDO::FETCH_ASSOC);
$work_cnt = count($work_list);

// 기술 태그 코드 테이블 조회
$code_sql = "SELECT minr, name, etc FROM `code` WHERE majr = 1";
$code_data = $pdo->query($code_sql)->fetchAll(PDO::FETCH_ASSOC);

// minr 컬럼을 키값으로 하는 배열 생성
$code_map = [];
foreach($code_data as $c) {
    $code_map[$c['minr']] = [
        'name' => $c['name'],
        'color' => $c['etc']
    ];
}

// $sql = "SELECT * FROM profile_data WHERE `no` = 1";
// $row = $pdo->query($sql);
// $profile = $row->fetch(PDO::FETCH_ASSOC);

//echo $sql;

?>
    <!-- <div class="content">
        </br>
        캘린더가............
    </div> -->
    <!-- <div id="dark">
        <input type="checkbox" id="dark_on_off">
        <label for="dark_on_off"></label>
    </div> -->
    <!-- <div id="profile">
        <div class="container">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    사진
                </div>
                <div>
                    <table class="table">
                        <tr>
                            <th>이름</th>
                            <td><?=$profile['name']?></td>
                        </tr>
                        <tr>
                            <th>생년월일</th>
                            <td><?=$profile['birth']?></td>
                        </tr>
                        <tr>
                            <th>이메일</th>
                            <td><?=$profile['email']?></td>
                        </tr>
                        <tr>
                            <th>소개</th>
                            <td><?=nl2br($profile['info'])?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> -->
    <div id="works" class="album py-5">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3'">
                <?php if($work_cnt == 0) {?>
                <p>데이터가 없습니다.</p>
                <?php } else { 
                    foreach($work_list as $d) { 
                        $work_subject = htmlspecialchars($d['subject'], ENT_QUOTES, 'UTF-8');
                        $work_content = htmlspecialchars($d['content'], ENT_QUOTES, 'UTF-8');
                        $work_url = htmlspecialchars($d['url'], ENT_QUOTES, 'UTF-8');
                        $work_thum = htmlspecialchars($d['thum'], ENT_QUOTES, 'UTF-8'); ?>
                <div class="col" style="margin-bottom: 20px;">
                    <div class="work_info col card h-100">
                        <a href="<?=$work_url?>" target="_blank" class="h-100">
                            <div class="thum_box card-img">
                                <div class="thumbnail"><p>view site</p></div>
                                <img src="portfolio/admin/img/work/<?=$work_thum?>" alt="">
                            </div>
                            <div class="work_sub card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <p class="subject"><?=$work_subject?></p>
                                    <p style="font-size: 12px;">보러가기</p>
                                </div>
                                <p class="cont"><?=nl2br($work_content)?></p>
                                <!-- <?=substr($d['reg_date'],0,10)?> -->
                            </div>
                            <div class="card-footer">
                                <div class="tools">
                                    <?php 
                                    if(!empty($d['tool'])) {
                                        $tools = explode(",", $d['tool']);
                                        foreach($tools as $t) {
                                            // 매핑 배열 데이터 매칭
                                            if(isset($code_map[$t])) {
                                                $tool_name = htmlspecialchars($code_map[$t]['name'], ENT_QUOTES, 'UTF-8');
                                                $tool_color = htmlspecialchars($code_map[$t]['color'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                    <p style="background: <?=$tool_color?>;"><?=$tool_name?></p>
                                    <?php }
                                    } ?>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <?php //$rownum--; 
                        }
                    }
                } ?>
            </div>
        </div>
    </div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/inc/footer.php'); ?>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/portfolio/bootstrap/js/bootstrap.min.js"></script>
<script>
    // $('#profile').click(function() {
    //     alert('test');
    // });

	$(document).scroll(function () {
		var scrollTop = $(this).scrollTop();
		if (scrollTop > 100) {
			$('header').addClass('on');
		} else {
			$('header').removeClass('on');
		}
	});

    $('#dark_on_off').click(function () {
        if($(this).is(':checked')) {
            $('body').addClass('dark');
        } else {
            $('body').removeClass('dark');
        }
    });
    
</script>
