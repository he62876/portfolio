<?php
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/common.php');
session_start();
$prevPage = $_SERVER['HTTP_REFERER'];

$pass = $_POST['password'];


$param = null;

$sql = "SELECT * FROM profile_data WHERE `password` = (HEX(AES_ENCRYPT('$pass', KEY)))";
$row = $pdo->query($sql);
$data = $row->fetch(PDO::FETCH_ASSOC);


if($data) { 
    
    $_SESSION['admin'] = $data['name'];

    if($data ) {
        header('location: /portfolio/admin/');
    }
} else { ?>
    <script>
        alert('비밀번호를 확인하세요.');
        history.back();
    </script>
<?php }

?>