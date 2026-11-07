<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'].'/portfolio/works/moneypig/common.php');
// include_once ("../../../_inc/inc_fn.php");

// $param = null;

$board = $_POST['board'];
$mode = $_POST['mode'];
$no = isset($_POST['no']) ? $_POST['no'] : '';
// $reg_date = date('Y-m-d H:i:s');

// echo $board." ".$mode;

$agency_tp			= isset($_POST['agency_tp']) ? $_POST['agency_tp'] : '';
$agency_nm			= isset($_POST['agency_nm']) ? $_POST['agency_nm'] : '';
$ceo_nm				= isset($_POST['ceo_nm']) ? $_POST['ceo_nm'] : '';
$agency_id			= isset($_POST['agency_id']) ? $_POST['agency_id'] : '';
$agency_pw			= isset($_POST['agency_pw']) ? $_POST['agency_pw'] : '';
$tel				= isset($_POST['tel']) ? $_POST['tel'] : '';
$email				= isset($_POST['email']) ? $_POST['email'] : '';
$biz_num			= isset($_POST['biz_num']) ? $_POST['biz_num'] : '';
$address			= isset($_POST['address']) ? $_POST['address'] : '';
$address_det		= isset($_POST['address_det']) ? $_POST['address_det'] : '';
$set_amt			= isset($_POST['set_amt']) ? $_POST['set_amt'] : '';
$set_amt1			= isset($_POST['set_amt1']) ? $_POST['set_amt1'] : '';
$set_amt2			= isset($_POST['set_amt2']) ? $_POST['set_amt2'] : '';
$ems_amt			= isset($_POST['ems_amt']) ? $_POST['ems_amt'] : '';
$ems_amt1			= isset($_POST['ems_amt1']) ? $_POST['ems_amt1'] : '';
$ems_amt2			= isset($_POST['ems_amt2']) ? $_POST['ems_amt2'] : '';
$account_bank		= isset($_POST['account_bank']) ? $_POST['account_bank'] : '';
$account_num		= isset($_POST['account_num']) ? $_POST['account_num'] : '';
$account_owner		= isset($_POST['account_owner']) ? $_POST['account_owner'] : '';

if($board == 'cntr') {

    if($mode == 'input') {
        $sql = "INSERT INTO agency_info (agency_tp, grade, agency_nm, ceo_nm, agency_id, agency_pw, tel, email, biz_num, address, address_det, account_bank, account_num, account_owner, agency_state, reg_date)
                VALUES (1, 1, '$agency_nm', '$ceo_nm', '$agency_id', (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))), (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), '$email', '$biz_num', '$address', '$address_det', '$account_bank', (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), '$account_owner', 1, NOW())";
    }
    if($mode == 'update') {
        $sql = "UPDATE agency_info SET agency_nm = '$agency_nm', ceo_nm = '$ceo_nm', tel = (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), email = '$email',
				biz_num = '$biz_num', address = '$address', address_det = '$address_det', account_bank = '$account_bank', account_num = (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), account_owner = '$account_owner', up_reg_date = NOW()
                WHERE agency_no = '$no'";
    }
    if($mode == 'delete') {
		$agency_state = $_POST['agency_state'];

        $sql = "UPDATE agency_info SET agency_state = '$agency_state', up_reg_date = NOW() WHERE agency_no = '$no'";
    }

	if($mode == 'amt') {
		$sql = "UPDATE agency_info SET set_amt = '$set_amt', set_amt1 = '$set_amt1', set_amt2 = '$set_amt2', ems_amt = '$ems_amt', ems_amt1 = '$ems_amt1', ems_amt2 = '$ems_amt2', up_reg_date = NOW() WHERE agency_no = '$no'";
	}

	if($mode == 'pass') {
		$sql = "UPDATE agency_info SET agency_pw = (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))) WHERE agency_no = '$no'";
	}
}

if($board == 'agcy') {


    function generateRandomString($length = 10) {
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $agency_code = generateRandomString(8);



    if($mode == 'input') {
		
		$distributor_no = $_POST['distributor_no'];
		$sql = "INSERT INTO agency_info (agency_code, agency_tp, grade, distributor_no, agency_nm, ceo_nm, agency_id, agency_pw, tel, email, biz_num, address, address_det, account_bank, account_num, account_owner, agency_state, reg_date)
				VALUES ('$agency_code', '$agency_tp', 2, '$distributor_no', '$agency_nm', '$ceo_nm', '$agency_id', (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))), (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), '$email', '$biz_num', '$address', '$address_det', '$account_bank', (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), '$account_owner', 1, NOW())";
    }
    if($mode == 'update') {
        $sql = "UPDATE agency_info SET agency_nm = '$agency_nm', ceo_nm = '$ceo_nm', tel = (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), email = '$email',
				biz_num = '$biz_num', address = '$address', address_det = '$address_det', account_bank = '$account_bank', account_num = (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), account_owner = '$account_owner', up_reg_date = NOW()
                WHERE agency_no = '$no'";
    }
	if($mode == 'amt') {
		$sql = "UPDATE agency_info SET set_amt = '$set_amt', set_amt1 = '$set_amt1', set_amt2 = '$set_amt2', up_reg_date = NOW() WHERE agency_no = '$no'";
	}
    if($mode == 'delete') {
		$agency_state = $_POST['agency_state'];

        $sql = "UPDATE agency_info SET agency_state = '$agency_state', up_reg_date = NOW() WHERE agency_no = '$no'";
    }

	if($mode == 'pass') {
		$sql = "UPDATE agency_info SET agency_pw = (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))) WHERE agency_no = '$no'";
	}
	
}

if($board == 'sell') {


    function generateRandomString($length = 10) {
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $agency_code = generateRandomString(8);
    $sql = "SELECT agency_code FROM agency_info WHERE agency_code = '".$agency_code."'";
    $data = $pdo->query($sql)->fetchColumn();

    if($mode == 'input') {
		
		$distributor_code = $_POST['distributor_code'];
		$code = $pdo->query("SELECT agency_code FROM agency_info WHERE grade = 2 AND agency_state = 1 AND agency_code = '".$distributor_code."'")->fetchColumn();

		$member = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_state != 99 AND agency_id = '".$agency_id."'")->fetchColumn();
		
		if($member != 0) { ?>
            <script>
                alert('가입한 아이디입니다.');
				location.replace('/portfolio/works/moneypig/admin/login.php');
            </script>

		<?php }

		else if(!isset($code)) {  ?>
            <script>
                alert('존재하지 않는 센터코드입니다.');
                window.history.back();
            </script>

        <?php 
		} else {
		
			
			$distributor_no	    = $pdo->query("SELECT distributor_no FROM agency_info WHERE agency_state = 1 AND agency_code = '".$distributor_code."'")->fetchColumn();
			$top_agency_no	    = $pdo->query("SELECT agency_no FROM agency_info WHERE agency_state = 1 AND agency_code = '".$distributor_code."'")->fetchColumn();


			$sql = "INSERT INTO agency_info (agency_tp, grade, distributor_no, top_agency_no, agency_nm, ceo_nm, agency_id, agency_pw, tel, email, biz_num, address, address_det, account_bank, account_num, account_owner, agency_state, reg_date)
					VALUES ('$agency_tp', 3, '$distributor_no', '$top_agency_no', '$agency_nm', '$ceo_nm', '$agency_id', (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))), (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), '$email', '$biz_num', '$address', '$address_det', '$account_bank', (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), '$account_owner', 0, NOW())";

            // echo $sql;
		}
    }
    if($mode == 'update') {
        $sql = "UPDATE agency_info SET agency_nm = '$agency_nm', ceo_nm = '$ceo_nm', tel = (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), email = '$email',
				biz_num = '$biz_num', address = '$address', address_det = '$address_det', account_bank = '$account_bank', account_num = (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), account_owner = '$account_owner', up_reg_date = NOW()
                WHERE agency_no = '$no'";
    }
    if($mode == 'ok') {

		$agency_code = generateRandomString(8);
		$data = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_code = '".$agency_code."'")->fetchColumn();

		if($data != 0) {

			$agency_code = generateRandomString(8);
		} else {
			$sql = "UPDATE agency_info SET agency_state = 1, agency_code = '$agency_code' WHERE agency_no = '$no'";
		}

    }
    if($mode == 'no') {

		$sql = "UPDATE agency_info SET agency_state = 99, agency_code = '$agency_code' WHERE agency_no = '$no'";
    }
	if($mode == 'amt') {
		$sql = "UPDATE agency_info SET set_amt = '$set_amt', set_amt1 = '$set_amt1', set_amt2 = '$set_amt2', up_reg_date = NOW() WHERE agency_no = '$no'";
	}
    if($mode == 'delete') {
		$agency_state = $_POST['agency_state'];

        $sql = "UPDATE agency_info SET agency_state = '$agency_state', up_reg_date = NOW() WHERE agency_no = '$no'";
    }

	if($mode == 'pass') {
		$sql = "UPDATE agency_info SET agency_pw = (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))) WHERE agency_no = '$no'";
	}
	
}


if($board == 'mngr') {

	$memb_tp =      isset($_POST['memb_tp']) ? $_POST['memb_tp'] : '';
	$category =     isset($_POST['category']) ? $_POST['category'] : '';
	$blog_url =     isset($_POST['blog_url']) ? $_POST['blog_url'] : '';
	$blog_info =    isset($_POST['blog_info']) ? $_POST['blog_info'] : '';
	$instar_url =   isset($_POST['instar_url']) ? $_POST['instar_url'] : '';
	$instar_info =  isset($_POST['instar_info']) ? $_POST['instar_info'] : '';
	$youtube_url =  isset($_POST['youtube_url']) ? $_POST['youtube_url'] : '';
	$youtube_info = isset($_POST['youtube_info']) ? $_POST['youtube_info'] : '';
	$tictok_url =   isset($_POST['tictok_url']) ? $_POST['tictok_url'] : '';
	$tictok_info =  isset($_POST['tictok_info']) ? $_POST['tictok_info'] : '';

    function generateRandomString($length = 10) {
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

	//$group_no = $_POST['group_no'];
	$agency_no =    isset($_POST['agency_no']) ? $_POST['agency_no'] : '';
	$set_amt =      isset($_POST['set_amt']) ? $_POST['set_amt'] : '';

    if($mode == 'input') {
		
		$distributor_code = $_POST['distributor_code'];
		$code = $pdo->query("SELECT agency_code FROM agency_info WHERE grade = 2 AND agency_state = 1 AND agency_code = '".$distributor_code."'")->fetchColumn();

        $member = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_state != 99 AND agency_id = '".$agency_id."'")->fetchColumn();
		
		if($member != 0) { ?>
            <script>
                alert('가입한 아이디입니다.');
				location.replace('/admin/login.php');
            </script>

		<?php }

		else if(!isset($code)) {  ?>
            <script>
                alert('존재하지 않는 대리점코드입니다.');
                window.history.back();
            </script>

        <?php 
		} else {
		
			
			$distributor_no	    = $pdo->query("SELECT distributor_no FROM agency_info WHERE agency_state = 1 AND agency_code = '".$distributor_code."'", )->fetchColumn();
			$top_agency_no	    = $pdo->query("SELECT top_agency_no FROM agency_info WHERE agency_state = 1 AND agency_code = '".$distributor_code."'", )->fetchColumn();
			$mid_agency_no	    = $pdo->query("SELECT agency_no FROM agency_info WHERE agency_state = 1 AND agency_code = '".$distributor_code."'", )->fetchColumn();


			$sql = "INSERT INTO agency_info (agency_tp, grade, distributor_no, top_agency_no, mid_agency_no, agency_nm, ceo_nm, agency_id, agency_pw, tel, email, biz_num, address, address_det, account_bank, account_num, account_owner, memb_tp, category, blog_url, blog_info, instar_url, instar_info, youtube_url, youtube_info, tictok_url, tictok_info, agency_state, reg_date)
					VALUES ('$agency_tp', 4, '$distributor_no', '$top_agency_no', '$mid_agency_no', '$agency_nm', '$ceo_nm', '$agency_id', (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))), (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), '$email', '$biz_num', '$address', '$address_det', '$account_bank', (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), '$account_owner', '$memb_tp', '$category', '$blog_url', '$blog_info', '$instar_url', '$instar_info', '$youtube_url', '$youtube_info', '$tictok_url', '$tictok_info', 0, NOW())";
		}
    }
    if($mode == 'update') {
        $sql = "UPDATE agency_info SET agency_nm = '$agency_nm', ceo_nm = '$ceo_nm', tel = (HEX(AES_ENCRYPT('$tel','moneypig_tro_230412'))), email = '$email',
				biz_num = '$biz_num', address = '$address', address_det = '$address_det', account_bank = '$account_bank', account_num = (HEX(AES_ENCRYPT('$account_num','moneypig_tro_230412'))), account_owner = '$account_owner', up_reg_date = NOW(),
				category = '$category', blog_url = '$blog_url', blog_info = '$blog_info', instar_url = '$instar_url', instar_info = '$instar_info', youtube_url = '$youtube_url', youtube_info = '$youtube_info', tictok_url = '$tictok_url', tictok_info = '$tictok_info'
                WHERE agency_no = '$no'";
    }
    if($mode == 'ok') {

		$agency_code = generateRandomString(8);
		$data = $pdo->query("SELECT count(*) FROM agency_info WHERE agency_code = '".$agency_code."'")->fetchColumn();

		if($data != 0) {

			$agency_code = generateRandomString(6);
		} else {
			$sql = "UPDATE agency_info SET agency_state = 1, agency_code = '$agency_code' WHERE agency_no = '$no'";
		}
    }
    if($mode == 'no') {

		$sql = "UPDATE agency_info SET agency_state = 99, agency_code = '$agency_code' WHERE agency_no = '$no'";
    }
	if($mode == 'amt') {
		$sql = "UPDATE agency_info SET set_amt = '$set_amt', set_amt1 = '$set_amt1', set_amt2 = '$set_amt2', up_reg_date = NOW() WHERE agency_no = '$no'";
	}
    if($mode == 'delete') {
		$agency_state = $_POST['agency_state'];

        $sql = "UPDATE agency_info SET agency_state = '$agency_state', up_reg_date = NOW() WHERE agency_no = '$no'";
    }

	if($mode == 'pass') {
		$sql = "UPDATE agency_info SET agency_pw = (HEX(AES_ENCRYPT('$agency_pw','moneypig_tro_230412'))) WHERE agency_no = '$no'";
	}
	
}


if($mode == "view") {
	$user_no	= isset($_POST['user_no']) ? $_POST['user_no'] : '';
	$grade	    = isset($_POST['grade']) ? $_POST['grade'] : '';
	$agency_no	= isset($_POST['agency_no']) ? $_POST['agency_no'] : '';
	$ip_data	= isset($_POST['REMOTE_ADDR']) ? $_SERVER["REMOTE_ADDR"] : '';

	$result = array('resStatus'=>"OK", 'resCode'=>0, 'returndata'=>"comment");
	// $rs = $pdo->query("INSERT INTO personal_data_log (user_no, grade, agency_no, ip_data, reg_date) VALUES ('$user_no', '$grade', '$agency_no', '$ip_data', NOW())", $param);
	// if($rs>0){
		$result['resCode'] = 1;
	// }
	@header('Content-Type: Application/json');
	//PhpLog1(urldecode(json_encode($result)));
	echo urldecode(json_encode($result));
	$pdo->CloseConnection();
	return;

}


$result = $pdo->query($sql, $param);
if(isset($result)) { ?>
    <script>
        alert('저장에 성공했습니다.')
        <?php if($mode == 'delete') { ?>
            window.history.go(-2);
        <?php } else if($board == 'cntr' && $mode == "input") { ?>
        location.replace('cntr-list.php');
        <?php } else if($board == 'cntr' && $mode != "input") { ?>
        location.replace('cntr-info.php?agency_no=<?=$no?>');
        <?php } else if($board == 'agcy' && $mode == "input") { ?>
        location.replace('agcy-list.php');
        <?php } else if($board == 'agcy' && $mode != "input") { ?>
        location.replace('agcy-info.php?agency_no=<?=$no?>');
		<?php } else if(($board == 'sell' || $board == 'mngr') && $mode == "input") {  ?>
        location.replace('/portfolio/works/moneypig/admin/login.php');
        <?php } else if($board == 'sell' && $mode != "input") { ?>
        location.replace('sell-info.php?agency_no=<?=$no?>');
        <?php } else if($board == 'mngr' && $mode != "input") { ?>
        location.replace('mngr-info.php?agency_no=<?=$no?>');
        <?php } ?>
    </script>
<?php } else { ?>
    <script>
        alert('저장에 실패했습니다.')
    </script>
<?php }

//$pdo->CloseConnection();

?>