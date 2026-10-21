<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'common.php');

$table = $_POST['table'];
$mode = $_POST['mode'];
$no = $_POST['no'];


if($table == 'work') {

    $subject = $_POST['subject'];
    $tool = implode(',', $_POST['tool']);
    $content = $_POST['content'];
    $url = $_POST['url'];
    $thum = '';
	if ($_FILES['file']['name']) {
		//print_r($_FILES);
		$uploadOk = 0 ;
		$target_dir = "../img/work/";   //업로드될 디렉토리
		if(!is_dir($target_dir)) { mkdir($target_dir,0777); }
		
		$filename_1	= basename($_FILES['file']["name"]) ;
		$f_name = explode(".", $filename_1);
		$filename	=	"img".date('YmdHis')."".$f_name[1] ;
		$target_file = $target_dir."".$filename ;


		$thum = $filename; //파일의 주소 http:// 주소를 붙여서 완성형을 사용하거나 파일이름만 사용
		/////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////// 파일이 이미지 일때 체크해 주는 부분 일반 파일일땐 삭제/////////////////
		$uploadOk = 1; //파일이 업로드 될 수 있는 상태인지 확인
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION); //jpg, png등 파일형식 확인
		$check = getimagesize($_FILES['file']["tmp_name"]);
		
		if($check !== false) {
			$uploadOk = 1;
		} else {
			alert("이미지 파일이 아닙니다. 다시 확인해 주세요. ");
			$uploadOk = 0;
		}
		
		if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "png" && $imageFileType != "PNG" && $imageFileType != "jpeg" && $imageFileType != "JPEG" && $imageFileType != "gif" && $imageFileType != "GIF") { 		// 파일 형식 확인
			// alert("알수 없는 형식의 파일입니다. 다시 확인해 주세요.");
			$uploadOk = 0;
		}
		/////////////////////////////////////////////////////////////////////////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////////////



		if (file_exists($target_file)) {										// 기존 파일 확인
			$re_target_file	=	explode('.',$target_file) ;
			$target_file = $re_target_file[0]."1.".$re_target_file[1] ;

			$uploadOk = 1;
		}
		if ($_FILES['file']["size"] > 100000000) {							// 파일 크기 확인
			alert("파일 용량이 너무 큽니다. 10Mb 이하의 파일만 전송 가능합니다. ");
			$uploadOk = 0;
		}

		if ($uploadOk == 0) {
			// alert("파일 업로드 되지 않았습니다.");
		} else {
			//echo $_FILES['banner_path']["tmp_name"];
			if (move_uploaded_file($_FILES['file']["tmp_name"], $target_file)) {
				//alert($url_file." 등록성공.","test.php");
			}
		}
    }

    if($mode == 'input') {
        $sql = "INSERT INTO work_data (subject, tool, content, url, thum, state, reg_date)
                VALUES (:subject, :tool, :content, :url, :thum, 1, NOW())";
        
        $param = [
            ':subject' => $subject,
            ':tool'    => $tool,
            ':content' => $content,
            ':url'     => $url,
            ':thum'    => $thum
        ];
    }

    if($mode == 'update') {

        if($_FILES['file']['size'] > 0) {
            $thum = $thum;
        } else {
            $thum = $_POST["thum"];
        }

        $sql = "UPDATE work_data SET subject = :subject, tool = :tool, content = :content, url = :url, thum = :thum WHERE no = :no";
        
        $param = [
            ':subject' => $subject,
            ':tool'    => $tool,
            ':content' => $content,
            ':url'     => $url,
            ':thum'    => $thum,
            ':no'      => $no
        ];
    }

    if($mode == 'delete') {
        $sql = "UPDATE work_data SET state = 0 WHERE no = :no";
        
        $param = [
            ':no' => $no
        ];
    }
}

if($table == 'profile') {

    $name = $_POST['name'];
    $birth = $_POST['birth'];
    $email = $_POST['email'];
    $info = $_POST['info'];

    if($mode == 'input') {
        $sql = "INSERT INTO profile_data (name, birth, email, info)
                VALUES (:name, :birth, :email, :info)";

        $param = [
            ':name' => $name,
            ':birth'    => $birth,
            ':email' => $email,
            ':info'     => $info
        ];
    }

    if($mode == 'update') {

        $sql = "UPDATE profile_data SET name = :name, birth = :birth, email = :email, info = :info WHERE no = :no";

        $param = [
            ':name' => $name,
            ':birth'    => $birth,
            ':email' => $email,
            ':info'     => $info,
            ':no'     => $no
        ];
    }

}

$stmt = $pdo->prepare($sql);
$result = $stmt->execute($param);
if($result) { ?>
    <script>
        alert('저장에 성공했습니다.')
        <?php if($table == 'work') { ?>
        location.replace('work-list.php');
        <?php } else if($table == 'profile') { ?>
        location.replace('profile.php');
        <?php } ?>
    </script>
<?php } else { ?>
    <script>
        alert('저장에 실패했습니다.')
    </script>
<?php }

//$pdo->CloseConnection();

?>