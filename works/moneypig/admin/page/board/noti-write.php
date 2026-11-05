<?php
include('../../lib/header.php');
include('../../../common.php');
include('../../lib/menu.php');

if($_SESSION['lv'] != 0) {
    echo "<meta http-equiv='refresh' content='0;url=/admin/index.php'>";
	exit;
}


$noti_no = $_GET['noti_no'] == null ? 0:$_GET['noti_no'];

$param = null;

$sql = "SELECT * FROM notice_info WHERE noti_no = ".$noti_no;
$data = $pdo->row($sql, $param);

?>
<style>
    .table td {
        text-align: left;
        
    }

    .card {
        min-height: 80vh;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
			<div class="card">
				<div class="card-header">
					<h6 class="title-strong">공지사항<?=$noti_no == 0 ? "등록":"수정"?></h6>
				</div>
				<div class="card-body">
					<form action="json.php" id="inputForm" method="POST"  onsubmit="return myFunction();">
						<input type="hidden" name="board" value="notice">
						<input type="hidden" name="mode" value="<?=$noti_no == 0 ? 'input':'update'?>">
						<?php if($noti_no != 0) { ?>
							<input type="hidden" name="no" value="<?=$noti_no?>">
						<?php } ?>
						<div class="table-responsive">
							<table class="table">
								<tbody>
									<tr>
										<th class="table-light" style="width: 80px;">글제목</th>
										<td>
											<input type="text" name="noti_sj" id="noti_sj" placeholder="제목을 입력하세요." value="<?=stripslashes($data['noti_sj'])?>" style="width: 100%;">
										</td>
									</tr>
									<tr>
										<th class="table-light">내용</th>
										<td>
											<textarea name="noti_cont" id="ir1" placeholder="내용을 입력하세요."><?=stripslashes($data['noti_cont'])?></textarea>
											<div id="wPopup" class="modal">
												<div class="modal-content" style="width: 400px;">
													<iframe id="iFramePopUP" style="width: 100%;" frameborder="0" onload=""></iframe>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<th class="table-light">대상</th>
										<td>
											<div>
												<input type="checkbox" name="gbn[]" id="gbn2" value="2" <?=in_array(2, explode(",", $data['gbn']))? 'checked': ''?>>
												<label for="gbn2">사용자</label>
											</div>
											<div>
												<input type="checkbox" name="gbn[]" id="gbn3" value="3" <?=in_array(3, explode(",", $data['gbn']))? 'checked': ''?>>
												<label for="gbn3">업체사장님</label>
											</div>
											<div>
												<input type="checkbox" name="gbn[]" id="gbn4" value="4" <?=in_array(4, explode(",", $data['gbn']))? 'checked': ''?>>
												<label for="gbn4">총판</label>
											</div>
											<div>
												<input type="checkbox" name="gbn[]" id="gbn5" value="5" <?=in_array(5, explode(",", $data['gbn']))? 'checked': ''?>>
												<label for="gbn5">센터</label>
											</div>
											<div>
												<input type="checkbox" name="gbn[]" id="gbn6" value="6" <?=in_array(6, explode(",", $data['gbn']))? 'checked': ''?>>
												<label for="gbn6">대리점</label>
											</div>
											<div>
												<input type="checkbox" name="gbn[]" id="gbn7" value="7" <?=in_array(7, explode(",", $data['gbn']))? 'checked': ''?>>
												<label for="gbn7">매니저</label>
											</div>
											<!--<select name="gbn">
												<option value="1" <?=$data['gbn'] == 1 ? "selected":""?>>전체</option>
												<option value="2" <?=$data['gbn'] == 2 ? "selected":""?>>사용자</option>
												<option value="3" <?=$data['gbn'] == 3 ? "selected":""?>>업체사장님</option>
												<option value="4" <?=$data['gbn'] == 4 ? "selected":""?>>센터</option>
												<option value="5" <?=$data['gbn'] == 5 ? "selected":""?>>총판</option>
												<option value="6" <?=$data['gbn'] == 6 ? "selected":""?>>대리점</option>
											</select>-->
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="btn-box">
							<a href="noti-list.php">취소</a>
							<button onclick="submitContents();"><?=$noti_no == 0 ? "등록":"수정"?></button>
							<?php if($noti_no != 0) {?>
								<button name="mode" value="delete">삭제</button>
							<?php } ?>
						</div>
					</form>
				</div>
			</div>
        </div>
    </div>
</div>
<?php
include('../../lib/footer.php');
?>
<script type="text/javascript" src="../../../SE23/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
    var oEditors = [];
    var defaultHTML = "";
    var bLoaded = 0;
    var g_instElm = null;

    nhn.husky.EZCreator.createInIFrame({
        oAppRef: oEditors,
        elPlaceHolder: "ir1",
        sSkinURI: "../../../SE23/SmartEditor2Skin.html",
        htParams: {
            bUseToolbar: true, // 툴바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseVerticalResizer: false, // 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
            bUseModeChanger: true, // 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
            //bSkipXssFilter : true,		// client-side xss filter 무시 여부 (true:사용하지 않음 / 그외:사용)
            //aAdditionalFontList : [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]],		// 추가 글꼴 목록
            fOnBeforeUnload: function () {
                //alert("종료!");
            },
            I18N_LOCALE: "ko_KR"
        }, //boolean
        fOnAppLoad: function () {
            bLoaded = 1;
            if (defaultHTML != "") {
                oEditors.getById["ir1"].setIR(defaultHTML);
                oEditors.getById["ir1"].exec("FOCUS", []); // set focus
            }
        },
        fCreator: "createSEditor2"
    });

    function setHTML(sHTML) {
        if (bLoaded == 0) defaultHTML = sHTML; // SE 완전 Load전
        else oEditors.getById["ir1"].setIR(sHTML);
    }

    function pasteHTML(sHTML) {
        if (bLoaded == 0) defaultHTML = sHTML; // SE 완전 Load전
        else oEditors.getById["ir1"].exec("PASTE_HTML", [sHTML]);
    }

    function getHTML() {
        return oEditors.getById["ir1"].getIR();
    }

    function submitContents(elClickedObj) {
        oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []); // 에디터의 내용이 textarea에 적용됩니다.
        // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
        try {
            elClickedObj.form.submit();
        } catch (e) {}
    }


    
</script>