<?php
/*if(extension_loaded("curl")){
	echo "cURL extension is loaded";

//	$url = "https://www.naver.com";
	$url = "https://www.moneypig.co.kr/info.php";
//	$url = "localhost:443/info.php";

	$ch = curl_init();                                 //curl 초기화
	curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
//	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
//	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초 
//	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);  
//	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함

	$response = curl_exec($ch);
	echo curl_errno($ch);       //에러 정보 출력
	echo curl_error($ch);       //에러 정보 출력
	echo($response);       //에러 정보 출력
	curl_close($ch);
} else {
	echo 'cURL extension failed';
}*/
$method = "POST";

$postData = [
				"b_no" => "4352342342423432"
			];

//$url = "http://106.240.237.243:8088/app/test1.php" . "?" . http_build_query($data, '',);
$url = "http://211.233.11.135:8089/from.device.php";
//$url = "https://ad.moneypig.co.kr/newshop.alert.php" . "?" . http_build_query($data);
$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);    //요청 결과를 문자열로 반환 
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);      //connection timeout 10초 
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함 
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));     
curl_setopt($ch, CURLOPT_TIMEOUT, 1);
curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
$res = curl_exec($ch);
curl_close($ch);
print_r($res);
//exec('php /moneypig/ad_push/newshop.alert.php "store_no=24"'.' > /dev/null 2>/dev/null &');
?>