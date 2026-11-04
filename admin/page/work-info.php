<?php 
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/admin/inc/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/admin/inc/menu.php');

$no = isset($_GET['no']) ? $_GET['no'] : 0;

$code = $pdo->query("SELECT * FROM `code` WHERE majr = 1 AND minr != 0 AND use_yn = 1", $param);

if($no != 0) {
    $sql = "SELECT * FROM work_data WHERE `no` =" .$no;
    $row = $pdo->query($sql);
    $data = $row->fetch(PDO::FETCH_ASSOC);
    //$data = $pdo->query($sql, $param);
}


?>
    <div class="content">
        <div class="">
            <form action="json.php" method="post" onsubmit="return myFunction();" enctype="multipart/form-data">
                <input type="hidden" name="table" value="work">
                <input type="hidden" name="mode" value="<?=$no == 0 ? 'input':'update'?>">
                <input type="hidden" name="no" value="<?=$no?>">
                <table class="table">
                    <tr>
                        <th>제목</th>
                        <td>
                            <input type="text" name="subject" id="subject" value="<?= $no == 0 ? '' : $data['subject'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>사용툴</th>
                        <td>
                            <?php foreach($code as $c) {
                                if($no == 0) { ?>
                            <input type="checkbox" name="tool[]" value="<?=$c['minr']?>" id="tool<?=$c['minr']?>">
                            <?php } else { ?>
                            <input type="checkbox" name="tool[]" value="<?=$c['minr']?>" id="tool<?=$c['minr']?>" <?=in_array($c['minr'], explode(",", $data['tool']))? 'checked': ''?>>
                            <?php } ?>
                            <label for="tool<?=$c['minr']?>"><?=$c['name']?></label>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
                <!-- <input type="text" name="subject" id="subject" value="<?= $no == 0 ? '' : $data['subject'] ?>"> -->
                <textarea name="content" id="content"><?= $no == 0 ? '' : $data['content'] ?></textarea>
                <input type="text" name="url" id="url" value="<?= $no == 0 ? '' : $data['url'] ?>">
                <input type="file" name="file" id="file" onchange="filname();">
                <input type="hidden" name="thum" value="<?= $no == 0 ? '' : $data['thum']?>">
                <img src="../img/work/<?=$data['thum']?>" alt="" id="preview">
                <div class="btn_box">
                    <button><?=$no == 0 ? "등록" : "수정"?></button>
                    <?php if($no != 0) { ?>
                    <button name="mode" value="delete">삭제</button>
                    <?php } ?>
                    <a href="work-list.php">목록</a>
                </div>
            </form>
        </div>
    </div>
<?php include($_SERVER['DOCUMENT_ROOT'].'/portfolio/admin/inc/footer.php'); ?>
<script>

    function filname() {
        var fileValue = $("#file").val().split("\\");
        var fileName = fileValue[fileValue.length-1]; // 파일명

        //$('#file-name').attr('value',fileName);


		var file = event.target.files[0];
		var reader = new FileReader(); 
		reader.onload = function(e) {

			$("#preview").attr("src", e.target.result);
			//$("#preview_link").bind("click",false);
		}

		reader.readAsDataURL(file);
    }
    
    function myFunction() {
        if($('#subject').val() == '') {
            alert('제목을 입력해주세요.');
            return false;
        }
        if($('#content').val().replace(/(^\s*)|(\s*$)/gi, "").length == 0) {
            alert('내용을 입력해주세요.');
            return false;
        }
        if($('#url').val() == '') {
            alert('주소를 입력해주세요.');
            return false;
        }
        <?php if($no == 0) { ?>
        if($('#file-name').val() == '') {
            alert('배너이미지를 첨부해주세요.');
            return false;
        }
        <?php } ?>
        if($('#file').val() != "") {
            var maxSize = 10 * 1024 * 1024;
            var fileSize = $('#file')[0].files[0].size;
            
            if(fileSize > maxSize) {
                alert('10MB 이하의 파일을 첨부해주세요.');
                return false;
            }

        }

        var check = confirm("진행하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }
    }
</script>