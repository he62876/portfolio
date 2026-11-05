<?php
include('../common.php');

$agency_id = $_GET['agency_id'];

$param= null;
$sql="SELECT * FROM agency_info WHERE agency_id = '$agency_id' AND agency_state != 99";
$row = $pdo->query($sql);
$result = $row->fetch(PDO::FETCH_ASSOC);


if($result == 0) { ?>
    <script>
        alert ('<?php echo $agency_id ?>는 사용 가능한 아이디입니다.');
        parent.document.getElementById("checked_id").value = 'y';
    </script>
<?php } else { ?>
    <script>
        alert ('<?php echo $agency_id ?>는 이미 사용 중인 아이디입니다.');
        parent.document.getElementById("checked_id").value = 'n';
    </script>
<?php }
$pdo->CloseConnection();
?>