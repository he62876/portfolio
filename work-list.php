<?php 
include($_SERVER['DOCUMENT_ROOT'].'/inc/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/inc/menu.php');


//페이징 기본 변수 설정
$page = (!isset($_GET['page']) ? "1":$_GET['page']);
$list = 10; // 페이지당 보여줄 게시글 수
$block = 5; // 하단에 보여줄 페이지 블럭 수

//전체 게시글 수 구하기
$sql = "SELECT count(*) FROM work_data WHERE state = 1";
$total_count = $pdo->query($sql)->fetchColumn(); 

//전체 페이지 수 및 시작 위치 계산
$total_page = ceil($total_count / $list); // 전체 페이지 수 (올림)
$start = ($page - 1) * $list; // LIMIT 시작 위치

$sql = "SELECT * FROM work_data WHERE state = 1 ORDER BY reg_date DESC LIMIT :start, :list";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
$stmt->bindValue(':list', (int)$list, PDO::PARAM_INT);
$stmt->execute();

$data_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$rownum = $total_count - $start;




?>
    <div class="content">
        <div>
            <table class="table">
                <tr>
                    <th>순번</th>
                    <th>제목</th>
                    <th>등록일</th>
                </tr>
                <?php if($data_list == 0) { ?>
                <tr>
                    <td colspan="3">데이터가 없습니다.</td>
                </tr>
                <?php } else {
                    foreach($data_list as $d) { ?>
                <tr>
                    <td><?=$rownum?></td>
                    <td><a href="work-info.php?no=<?=$d['no']?>"><?=$d['subject']?></a></td>
                    <td><?=substr($d['reg_date'],0,10)?></td>
                </tr>
                <?php  $rownum--; }
                }?>
            </table>
            <a href="work-info.php">글쓰기</a>
        </div>
		<?php
		$block_start = floor(($page - 1) / $block) * $block + 1; // 블럭의 시작 페이지
		$block_end = $block_start + $block - 1; // 블럭의 마지막 페이지

		if ($block_end > $total_page) {
			$block_end = $total_page; // 마지막 블럭이 총 페이지 수를 넘지 않도록
		}
		?>

		<div>
			<?php if ($page > 1): ?>
				<a href="?page=1">[처음]</a>
				<a href="?page=<?= $page - 1 ?>">[이전]</a>
			<?php endif; ?>

            <?php for ($i = $block_start; $i <= $block_end; $i++): ?>
                <?php if ($i == $page): ?>
                    <b style="color: #0366d6; font-size: 16px; margin: 0 5px;"><?= $i ?></b>
                <?php else: ?>
                    <a href="?page=<?= $i ?>" style="margin: 0 5px; text-decoration: none; color: #555;"><?= $i ?></a>
                <?php endif; ?>
            <?php endfor; ?>

			<?php if ($page < $total_page): ?>
				<a href="?page=<?= $page + 1 ?>">[다음]</a>
				<a href="?page=<?= $total_page ?>">[마지막]</a>
			<?php endif; ?>
		</div>
    </div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/inc/footer.php'); ?>