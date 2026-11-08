<?if((strpos($_SERVER['HTTP_USER_AGENT'], 'AppleWebKit/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))  {
			
}
else if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
	
}
else{

$where = '';
	
if($grade == 2) {
	$work = $pdo->query("SELECT *, DATE_FORMAT(CONCAT(b.hire_sdate,' ',b.hire_stime,':00:00'), '%Y-%m-%d %H:%i:%s') as sdate, DATE_FORMAT(CONCAT(b.hire_edate,' ',b.hire_etime,':00:00'), '%Y-%m-%d %H:%i:%s') as edate FROM pay_info a LEFT OUTER JOIN hire_info b ON a.hire_no = b.hire_no WHERE a.user_no = ".$_SESSION['user_no']." AND a.state = 2 AND b.state = 2 ", $param);
	//$work_cnt = $pdo->single("SELECT count(*) FROM pay_info WHERE user_no = ".$_SESSION['user_no']." AND state = 2 ", $param);



	if($work != null) {
		foreach($work as $w) {
		$where .= " AND NOT(DATE_FORMAT(CONCAT(a.hire_sdate,' ',a.hire_stime,':00:00'), '%Y-%m-%d %H-%i-%s') <  '".$w['edate']."' AND DATE_FORMAT(CONCAT(a.hire_edate,' ',a.hire_etime,':00:00'), '%Y-%m-%d %H-%i-%s') > '".$w['sdate']."')";
		
		}
		//echo $where;
	}


	$sql = "SELECT count(*) FROM hire_info a WHERE a.end_date >= NOW() AND a.user_grade = 1 AND a.state = 1 AND a.use_yn = 1 ".$where;
	$hire_cnt1 = $pdo->single($sql, $param);

	$my = $pdo->row("SELECT * FROM user_info WHERE user_no = ".$_SESSION['user_no'], $param);
	if($my['agency_state'] == 1) {
		$where .= " AND ( a.user_no = '".$my['association_nm']."' OR b.association_nm = '".$my['association_nm']."')";
	}

	$sql = "SELECT count(*) FROM hire_info a LEFT OUTER JOIN user_info b ON a.user_no = b.user_no WHERE a.end_date >= NOW() AND a.user_grade = 3 AND a.state = 1 AND a.use_yn = 1 ".$where;
	$hire_cnt3 = $pdo->single($sql, $param);
}
if($grade == 3) {
	$sql = "SELECT count(*) FROM hire_info WHERE end_date >= NOW() AND user_grade = 1 AND state = 1 AND use_yn = 1";
	$hire_cnt1 = $pdo->single($sql, $param);
}
	
?>
<style>
	li {
		position: relative;
	}

	#menu ul li a span.count {
		position: absolute;
		font-size: 0.8rem;
		top: -10px; right: 10px;
		display: inline-block;
		width: 35px;
		color: #fff;
		background: #FF5700;
		border-radius: 20px;
	}
</style>
<div id="menu">
    <ul>
        <?php if($grade == 1) { ?>
        <li>
            <a href="/app/index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                    <g id="그룹_26560" data-name="그룹 26560" transform="translate(12227 -20332)">
                        <rect id="사각형_24070" data-name="사각형 24070" width="120" height="120"
                            transform="translate(-12227 20332)" fill="none" />
                        <g id="그룹_26559" data-name="그룹 26559" transform="translate(-78 145.5)">
                            <g id="그룹_26558" data-name="그룹 26558" transform="translate(-12117 20242.787)">
                                <path id="패스_8699" data-name="패스 8699"
                                    d="M39.431,29.875,28.58,49.656,17.727,29.875C-.486,33.94.51,53.053.51,53.053V78.142H56.649V53.053S57.644,33.94,39.431,29.875Z"
                                    transform="translate(-0.5 -29.875)"
                                    fill="<?=$menu == "index" ? "#3478F6":"#46484d"?>"
                                    stroke="<?=$menu == "index" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                                <line id="선_99" data-name="선 99" x2="11.64" transform="translate(34.86 28.748)"
                                    fill="none" stroke="#fff" stroke-linecap="round" stroke-miterlimit="10"
                                    stroke-width="7" />
                            </g>
                            <circle id="타원_311" data-name="타원 311" cx="17.107" cy="17.107" r="17.107"
                                transform="translate(-12106.714 20202.5)"
                                fill="<?=$menu == "index" ? "#3478F6":"#46484d"?>" />
                        </g>
                    </g>
                </svg>
                <span style="color:<?=$menu == "index" ? "#3478F6":"#46484d"?>">간병요청</span>
            </a>
        </li>
        <li>
            <a href="/app/page/state/state-list.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                    <g id="그룹_26557" data-name="그룹 26557" transform="translate(11772 -20332)">
                        <rect id="사각형_24070" data-name="사각형 24070" width="120" height="120"
                            transform="translate(-11772 20332)" fill="none" />
                        <g id="그룹_26551" data-name="그룹 26551">
                            <rect id="사각형_24464" data-name="사각형 24464" width="73.733" height="79.758" rx="6"
                                transform="translate(-11749 20352)" fill="<?=$menu == "state" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "state" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                            <g id="그룹_26202" data-name="그룹 26202" transform="translate(-11731.983 20372.914)">
                                <line id="선_93" data-name="선 93" x2="39.702" fill="none"
                                    stroke="<?=$menu == "state" ? "#fff":"#46484d"?>" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="7" />
                                <line id="선_94" data-name="선 94" x2="39.702" transform="translate(0 18.965)" fill="none"
                                    stroke="<?=$menu == "state" ? "#fff":"#46484d"?>" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="7" />
                                <line id="선_95" data-name="선 95" x2="39.702" transform="translate(0 37.93)" fill="none"
                                    stroke="<?=$menu == "state" ? "#fff":"#46484d"?>" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="7" />
                            </g>
                        </g>
                    </g>
                </svg>
                <span style="color:<?=$menu == "state" ? "#3478F6":"#46484d"?>">요청현황</span>
            </a>
        </li>
        <?php } ?>
        <?php if ($grade != 1) { ?>
        <li>
            <a href="/app/page/state/state2-list.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                    <g id="그룹_26207" data-name="그룹 26207" transform="translate(18416 12194)">
                        <rect id="사각형_24467" data-name="사각형 24467" width="120" height="120"
                            transform="translate(-18416 -12194)" fill="none" />
                        <g id="그룹_26201" data-name="그룹 26201" transform="translate(-18393 -12174)">
                            <ellipse id="타원_294" data-name="타원 294" cx="16.44" cy="16.44" rx="16.44" ry="16.44"
                                transform="translate(20.217 0)" fill="<?=$menu == "pay" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "pay" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                            <path id="패스_8456" data-name="패스 8456"
                                d="M1404.842,1358.781c-5.929-28.029-33.418-26.143-33.418-26.143h-6.17s-27.489-1.886-33.42,26.143c0,2.426-1.616,8.354,5.66,8.354h61.689C1406.459,1367.135,1404.842,1361.206,1404.842,1358.781Z"
                                transform="translate(-1331.682 -1287.091)" fill="<?=$menu == "pay" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "pay" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                        </g>
                    </g>
                </svg>
                <span style="color:<?=$menu == "pay" ? "#3478F6":"#46484d"?>">보호자구인</span>
				<?php if($grade != 1 && $hire_cnt1 > 0) { ?>
				<span class="count"><?=$hire_cnt1 <= 999 ? $hire_cnt1:"999+"?></span>
				<?php } ?>
            </a>
        </li>
        <li>
            <a href="/app/page/state/state3-list.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                    <g id="그룹_27069" data-name="그룹 27069" transform="translate(21812 4639)">
                        <rect id="사각형_24070" data-name="사각형 24070" width="120" height="120"
                            transform="translate(-21812 -4639)" fill="none" />
                        <g id="그룹_27068" data-name="그룹 27068" transform="translate(-92.984 184.017)">
                            <path id="패스_8844" data-name="패스 8844"
                                d="M55.877.5H36.307a35.789,35.789,0,0,0-4.542,71.291V89.642L49.3,72.114h6.579A35.807,35.807,0,0,0,55.877.5Z"
                                transform="translate(-21705.516 -4808.517)" fill="<?=$menu == "hire" ? "#3478F6":"none"?>" stroke="<?=$menu == "hire" ? "#3478F6":"#46484d"?>"
                                stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10"
                                stroke-width="7" />
                            <g id="그룹_27067" data-name="그룹 27067" transform="translate(-21659.422 -4787.951)">
                                <line id="선_100" data-name="선 100" y2="2.291" fill="none" stroke="<?=$menu == "hire" ? "#fff":"#46484d"?>"
                                    stroke-linecap="round" stroke-miterlimit="10" stroke-width="7" />
                                <line id="선_101" data-name="선 101" y2="20.503" transform="translate(0 14.892)"
                                    fill="none" stroke="<?=$menu == "hire" ? "#fff":"#46484d"?>" stroke-linecap="round" stroke-miterlimit="10"
                                    stroke-width="7" />
                            </g>
                        </g>
                    </g>
                </svg>
                <span style="color:<?=$menu == "hire" ? "#3478F6":"#46484d"?>">협회구인</span>
				<?php if($grade == 2 && $hire_cnt3 > 0) { ?>
				<span class="count"><?=$hire_cnt3 <= 999 ? $hire_cnt3:"999+"?></span>
				<?php } ?>
            </a>
        </li>
		<?php if($grade == 3){ ?>
        <li>
            <a href="/app/page/member/member-list.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
				  <g id="그룹_27615" data-name="그룹 27615" transform="translate(-2758 19273)">
					<rect id="사각형_24070" data-name="사각형 24070" width="120" height="120" transform="translate(2758 -19273)" fill="none"/>
					<g id="그룹_27614" data-name="그룹 27614" transform="translate(60 -254.998)">
					  <path id="패스_8877" data-name="패스 8877" d="M33.167,28.979H9.61A2.708,2.708,0,0,1,6.9,26.268V2.711A2.7,2.7,0,0,1,9.61,0H33.167a2.708,2.708,0,0,1,2.711,2.711V26.268a2.712,2.712,0,0,1-2.711,2.711M12.321,23.557H30.456V5.422H12.321Z" transform="translate(2736.505 -19001.002)" fill="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke-width="1.5"/>
					  <path id="패스_8878" data-name="패스 8878" d="M80.4,31.122a2.712,2.712,0,0,1-2.711-2.711V12.287H7.5V28.411a2.711,2.711,0,1,1-5.422,0V9.576A2.708,2.708,0,0,1,4.792,6.865H80.4a2.712,2.712,0,0,1,2.711,2.711V28.411A2.712,2.712,0,0,1,80.4,31.122" transform="translate(2715.201 -18970.646)" fill="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke-width="1.5"/>
					  <path id="패스_8879" data-name="패스 8879" d="M11.765,38.938a2.594,2.594,0,0,1-2.711-2.457V6.745a2.594,2.594,0,0,1,2.711-2.457,2.594,2.594,0,0,1,2.711,2.457V36.481a2.594,2.594,0,0,1-2.711,2.457" transform="translate(2746.034 -18978.463)" fill="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke-width="1.5"/>
					  <path id="패스_8880" data-name="패스 8880" d="M21.473,39.461A14.492,14.492,0,1,1,35.965,24.969,14.507,14.507,0,0,1,21.473,39.461m0-23.563a9.07,9.07,0,1,0,9.07,9.07,9.076,9.076,0,0,0-9.07-9.07" transform="translate(2736.89 -18954.676)" fill="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke-width="1.5"/>
					  <path id="패스_8881" data-name="패스 8881" d="M14.487,39.335A14.489,14.489,0,1,1,28.979,24.843,14.5,14.5,0,0,1,14.487,39.335m0-23.557a9.068,9.068,0,1,0,9.07,9.065,9.075,9.075,0,0,0-9.07-9.065" transform="translate(2706 -18955.211)" fill="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke-width="1.5"/>
					  <path id="패스_8882" data-name="패스 8882" d="M28.289,39.461A14.492,14.492,0,1,1,42.781,24.969,14.511,14.511,0,0,1,28.289,39.461m0-23.563a9.07,9.07,0,1,0,9.07,9.07,9.077,9.077,0,0,0-9.07-9.07" transform="translate(2767.006 -18954.676)" fill="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke="<?=$menu == "member" ? "#3478F6":"#46484d"?>" stroke-width="1.5"/>
					</g>
				  </g>
				</svg>
                <span style="color:<?=$menu == "member" ? "#3478F6":"#46484d"?>">간병사관리</span>
            </a>
        </li>
		<?php } ?>
        <?php if($grade == 2) { ?>
		<li>
            <a href="/app/page/state/state-list.php<?=$grade == 2 ?"?type=1":""?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                    <g id="그룹_26557" data-name="그룹 26557" transform="translate(11772 -20332)">
                        <rect id="사각형_24070" data-name="사각형 24070" width="120" height="120"
                            transform="translate(-11772 20332)" fill="none" />
                        <g id="그룹_26551" data-name="그룹 26551">
                            <rect id="사각형_24464" data-name="사각형 24464" width="73.733" height="79.758" rx="6"
                                transform="translate(-11749 20352)" fill="<?=$menu == "state" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "state" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                            <g id="그룹_26202" data-name="그룹 26202" transform="translate(-11731.983 20372.914)">
                                <line id="선_93" data-name="선 93" x2="39.702" fill="none"
                                    stroke="<?=$menu == "state" ? "#fff":"#46484d"?>" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="7" />
                                <line id="선_94" data-name="선 94" x2="39.702" transform="translate(0 18.965)" fill="none"
                                    stroke="<?=$menu == "state" ? "#fff":"#46484d"?>" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="7" />
                                <line id="선_95" data-name="선 95" x2="39.702" transform="translate(0 37.93)" fill="none"
                                    stroke="<?=$menu == "state" ? "#fff":"#46484d"?>" stroke-linecap="round"
                                    stroke-miterlimit="10" stroke-width="7" />
                            </g>
                        </g>
                    </g>
                </svg>
                <span style="color:<?=$menu == "state" ? "#3478F6":"#46484d"?>">지원현황</span>
            </a>
        </li>
        <?php } ?>
        <?php } ?>
        <li>
            <a href="/app/page/mypage/mypage.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 120 120">
                    <g id="그룹_26556" data-name="그룹 26556" transform="translate(11267 -20332)">
                        <rect id="사각형_24070" data-name="사각형 24070" width="120" height="120"
                            transform="translate(-11267 20332)" fill="none" />
                        <g id="그룹_26555" data-name="그룹 26555" transform="translate(1.5 -0.5)">
                            <circle id="타원_307" data-name="타원 307" cx="10" cy="10" r="10"
                                transform="translate(-11261.5 20382.5)" fill="<?=$menu == "mypage" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "mypage" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                            <circle id="타원_309" data-name="타원 309" cx="10" cy="10" r="10"
                                transform="translate(-11218.5 20382.5)" fill="<?=$menu == "mypage" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "mypage" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                            <circle id="타원_310" data-name="타원 310" cx="10" cy="10" r="10"
                                transform="translate(-11175.5 20382.5)" fill="<?=$menu == "mypage" ? "#3478F6":"none"?>"
                                stroke="<?=$menu == "mypage" ? "#3478F6":"#46484d"?>" stroke-linecap="round"
                                stroke-linejoin="round" stroke-miterlimit="10" stroke-width="7" />
                        </g>
                    </g>
                </svg>
                <span style="color:<?=$menu == "mypage" ? "#3478F6":"#46484d"?>">더 보기</span>
            </a>
        </li>
    </ul>
</div>
<?}?>