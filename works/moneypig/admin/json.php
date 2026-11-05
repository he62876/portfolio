<?php
include('../common.php');
session_start();
$prevPage = $_SERVER['HTTP_REFERER'];

$id   = $_POST['admin_id'];
$pass = $_POST['admin_pw'];


$param = null;

$sql = "SELECT * FROM agency_info WHERE agency_id = '$id' AND agency_pw = (HEX(AES_ENCRYPT('$pass','moneypig_tro_230412'))) AND agency_state = 1";
$row = $pdo->query($sql);
$data = $row->fetch(PDO::FETCH_ASSOC);


if($data) { 
    
    $_SESSION['lv'] = $data['grade'];
    $_SESSION['no'] = $data['agency_no'];
    $_SESSION['id'] = $data['agency_id'];
    $_SESSION['name'] = $data['agency_nm'];

    if($data ) {
        header('location: /portfolio/works/moneypig/admin/');
    }
} else { ?>
    <script>
        alert('로그인 정보를 확인하세요.');
        history.back();
    </script>
<?php }

?>