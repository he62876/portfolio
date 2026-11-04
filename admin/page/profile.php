<?php 
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/admin/inc/header.php');
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/admin/inc/menu.php');




$sql = "SELECT * FROM profile_data WHERE no = 1";
$row = $pdo->query($sql);
$data = $row->fetch(PDO::FETCH_ASSOC);



?>
    <div class="content">
        <div class="">
            <form action="json.php" method="post" onsubmit="return myFunction();" enctype="multipart/form-data">
                <input type="hidden" name="table" value="profile">
                <input type="hidden" name="mode" value="<?=$data == 0 ? 'input':'update'?>">
                <input type="text" name="name" id="name" value="<?= $data == 0 ? '' : $data['name'] ?>" placeholder="이름">
                <input type="date" name="birth" id="birth" value="<?= $data == 0 ? '' : $data['birth'] ?>">
                <input type="text" name="email" id="email" value="<?= $data == 0 ? '' : $data['email'] ?>" placeholder="이메일">
                <textarea name="info" id="info"><?= $data == 0 ? '' : $data['info'] ?></textarea>
                <div class="btn_box">
                    <button><?=$data == 0 ? "등록" : "수정"?></button>
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
        if($('#name').val() == '') {
            alert('이름을 입력해주세요.');
            return false;
        }
        if($('#birth').val() == '') {
            alert('생일을 입력해주세요.');
            return false;
        }
        if($('#email').val() == '') {
            alert('이메일을 입력해주세요.');
            return false;
        }
        if($('#info').val().replace(/(^\s*)|(\s*$)/gi, "").length == 0) {
            alert('내용을 입력해주세요.');
            return false;
        }
        // <?php //if($no == 0) { ?>
        // if($('#file-name').val() == '') {
            // alert('배너이미지를 첨부해주세요.');
            // return false;
        // }
        // <?php //} ?>
        // if($('#file').val() != "") {
            // var maxSize = 10 * 1024 * 1024;
            // var fileSize = $('#file')[0].files[0].size;
            // 
            // if(fileSize > maxSize) {
                // alert('10MB 이하의 파일을 첨부해주세요.');
                // return false;
            // }
// 
        // }

        var check = confirm("진행하겠습니까?");
        if(check){
          document.inputForm.submit();
        }else{
          return false;
        }
    }
</script>