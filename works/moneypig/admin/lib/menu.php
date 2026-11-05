<?php

$href = '/portfolio/works/moneypig/';
$url = array(0 => '/admin/', 1 => '/admin/cntr.php', 2 => '/admin/agcy.php', 3 => '/admin/sell.php', 4 => '/admin/mngr.php');
$mypage = array(1 => 'cntr', 2 => 'agcy', 3 => 'sell', 4 => 'mngr');
$calc = array(0 => 1, 1 => 2, 2 => 3, 3=>4, 4=>4);

$now = date("Y-m");
?>
<div class="vertical-menu">
    <div data-simplebar class="">
        <div id="sidebar-menu">
            <img src="/admin/img/logo.svg" alt="" >
            <ul class="metismenu list-unstyled" id="side-menu">
                <li>
                    <a href="<?=$url[$lv]?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27764" data-name="그룹 27764" transform="translate(-35 -137)">
							<rect id="사각형_24535" data-name="사각형 24535" width="20" height="20" transform="translate(35 137)" fill="none"/>
							<path id="빼기_3" data-name="빼기 3" d="M6.7,16H3.349V8.381H0L9,0l9,8.381H14.651V16H11.3V10.667H6.7V16Z" transform="translate(36 139)" fill="#757f8d"/>
						  </g>  
						</svg>
                        <span>홈</span>
                    </a>
                </li>
				<li>
                    <a href="javascript: void(0);" class="has-arrow">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28299" data-name="그룹 28299" transform="translate(3287 -514)">
							<rect id="사각형_24642" data-name="사각형 24642" width="20" height="20" transform="translate(-3287 514)" fill="none"/>
							<g id="그룹_28291" data-name="그룹 28291" transform="translate(-46 -279)">
							  <path id="패스_8853" data-name="패스 8853" d="M2,2H8.586L12,5.414V14H2ZM0,0V16H14V4.586L9.414,0Z" transform="translate(-3238 795)" fill="#757f8d"/>
							  <rect id="사각형_24643" data-name="사각형 24643" width="6" height="1" transform="translate(-3234 802)" fill="#757f8d"/>
							  <rect id="사각형_24644" data-name="사각형 24644" width="4.001" height="1" transform="translate(-3234 800)" fill="#757f8d"/>
							  <rect id="사각형_24645" data-name="사각형 24645" width="6" height="1" transform="translate(-3234 804)" fill="#757f8d"/>
							  <rect id="사각형_24646" data-name="사각형 24646" width="6" height="1.001" transform="translate(-3234 805.999)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>이벤트참여관리</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="/admin/page/cash/point-list.php">
								<span>현장이벤트</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/point-info.php">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="/admin/page/cash/cash-list.php">
								<span>돈되지이벤트</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/cash-info.php">상세</a></li>
							</ul>
						</li>
                    </ul>
                </li>
				<?php if($lv == 0 || $lv == 4) { ?>
				<li>
                    <a href="javascript: void(0);" class="has-arrow">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28297" data-name="그룹 28297" transform="translate(3285 -574)">
							<rect id="사각형_24640" data-name="사각형 24640" width="20" height="20" transform="translate(-3285 574)" fill="none"/>
							<g id="그룹_28285" data-name="그룹 28285" transform="translate(-71 101)">
							  <path id="패스_8839" data-name="패스 8839" d="M6.25,16.25A2.25,2.25,0,0,0,8.5,14H4a2.249,2.249,0,0,0,2.25,2.25" transform="translate(-3210.5 475.75)" fill="#757f8d"/>
							  <path id="패스_8840" data-name="패스 8840" d="M6.75,0A6.745,6.745,0,0,0,3.771,12.8L4.5,14.625H9L9.729,12.8A6.745,6.745,0,0,0,6.75,0" transform="translate(-3211 474)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>캠페인관리</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="/admin/page/cash/campaign-list.php">
								<span>캠페인현황</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/campaign-info.php">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="/admin/page/cash/agent-list.php">
								<span>등록대행</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/agent-info.php">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="/admin/page/cash/talk-list.php">
								<span>톡딜관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/talk-info.php">상세</a></li>
							</ul>
						</li>
                    </ul>
                </li>
				<?php } ?>
				<?php if($lv != 0 && $lv != 4) { ?>
                <li>
                    <a href="/admin/page/cash/campaign-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28297" data-name="그룹 28297" transform="translate(3285 -574)">
							<rect id="사각형_24640" data-name="사각형 24640" width="20" height="20" transform="translate(-3285 574)" fill="none"/>
							<g id="그룹_28285" data-name="그룹 28285" transform="translate(-71 101)">
							  <path id="패스_8839" data-name="패스 8839" d="M6.25,16.25A2.25,2.25,0,0,0,8.5,14H4a2.249,2.249,0,0,0,2.25,2.25" transform="translate(-3210.5 475.75)" fill="#757f8d"/>
							  <path id="패스_8840" data-name="패스 8840" d="M6.75,0A6.745,6.745,0,0,0,3.771,12.8L4.5,14.625H9L9.729,12.8A6.745,6.745,0,0,0,6.75,0" transform="translate(-3211 474)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>체험단관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/cash/campaign-info.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
				<li>
                    <a href="javascript: void(0);" class="has-arrow">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28296" data-name="그룹 28296" transform="translate(3287 -617)">
							<rect id="사각형_24638" data-name="사각형 24638" width="20" height="20" transform="translate(-3287 617)" fill="none"/>
							<path id="패스_8846" data-name="패스 8846" d="M12.177,0,0,12.177H5.536v5.535L17.713,5.535Z" transform="translate(-3286 618)" fill="#757f8d"/>
						  </g>
						</svg>
                        <span>쿠폰관리</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="/admin/page/cash/publish-list.php">
								<span>쿠폰발행관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/publish-info.php">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="/admin/page/cash/coupon-list.php">
								<span>쿠폰사용관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="/admin/page/cash/coupon-info.php">상세</a></li>
							</ul>
						</li>
                    </ul>
                </li>
				<?php if($lv == 0) { ?>
                <li>
                    <a href="/admin/page/cash/money-list.php?state=1&month=<?=$now?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28288" data-name="그룹 28288" transform="translate(3267 -727)">
							<rect id="사각형_24641" data-name="사각형 24641" width="20" height="20" transform="translate(-3267 727)" fill="none"/>
							<g id="그룹_28287" data-name="그룹 28287" transform="translate(-23 51)">
							  <path id="패스_8847" data-name="패스 8847" d="M6.655,12.422c-2.5,0-5.111-.527-6.642-1.64,0,.019-.013.037-.013.055v1.585c0,1.461,2.98,2.643,6.655,2.643s6.655-1.182,6.655-2.643V10.837c0-.017-.013-.036-.013-.055-1.531,1.113-4.145,1.64-6.642,1.64" transform="translate(-3241 680.569)" fill="#757f8d"/>
							  <path id="패스_8848" data-name="패스 8848" d="M6.655,9.441c-2.5,0-5.111-.526-6.642-1.637,0,.017-.013.035-.013.053V9.441c0,1.461,2.98,2.645,6.655,2.645s6.655-1.183,6.655-2.645V7.857c0-.019-.013-.036-.013-.053C11.767,8.915,9.152,9.441,6.655,9.441" transform="translate(-3241 679.584)" fill="#757f8d"/>
							  <path id="패스_8849" data-name="패스 8849" d="M0,4.916V6.435c0,1.46,2.98,2.643,6.655,2.643s6.655-1.183,6.655-2.643V4.916C11.782,6.037,9.16,6.567,6.655,6.567S1.528,6.037,0,4.916" transform="translate(-3241 678.627)" fill="#757f8d"/>
							  <path id="패스_8850" data-name="패스 8850" d="M6.655,0C2.98,0,0,1.183,0,2.643V4.23C0,5.688,2.98,6.872,6.655,6.872s6.655-1.185,6.655-2.642V2.643C13.311,1.183,10.332,0,6.655,0" transform="translate(-3241 677)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>입출금관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/cash/money-list.php">상세</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/page/cash/out-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28295" data-name="그룹 28295" transform="translate(3286 -678)">
							<rect id="사각형_24641" data-name="사각형 24641" width="20" height="20" transform="translate(-3286 678)" fill="none"/>
							<g id="그룹_28289" data-name="그룹 28289" transform="translate(-19 -84)">
							  <path id="패스_8851" data-name="패스 8851" d="M14.652,0V1.465H1.465L0,2.93V8.791l2.93-2.93V4.4H14.652V5.861l2.93-2.93Z" transform="translate(-3266 765)" fill="#757f8d"/>
							  <path id="패스_8852" data-name="패스 8852" d="M14.652,6.931V8.4H2.93V6.931L0,9.862l2.93,2.93V11.327H16.117l1.465-1.465V4Z" transform="translate(-3266 766.86)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>출금요청관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/cash/out-info.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
                <li>
                    <a href="/admin/page/cash/ad-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28300" data-name="그룹 28300" transform="translate(3285 -863)">
							<rect id="사각형_24647" data-name="사각형 24647" width="20" height="20" transform="translate(-3285 863)" fill="none"/>
							<path id="패스_8857" data-name="패스 8857" d="M13,.939v1l-11,3-2-1v6l2-1,1.187.324-.326,1.281a1.5,1.5,0,0,0,1.083,1.823l2.938.748a1.5,1.5,0,0,0,1.824-1.082l.3-1.183L13,11.939v1l3,1.021V0ZM7.737,11.786a.508.508,0,0,1-.608.36L4.191,11.4a.5.5,0,0,1-.361-.608l.322-1.266,3.891,1.061ZM13,6.939H2v-1l11-3Zm2,0H14v-5h1Z" transform="translate(-3283 866)" fill="#757f8d"/>
						  </g>
						</svg>
                        <span>동네광고관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/cash/ad-info.php">상세</a></li>
                    </ul>
                </li>
				<?php if($lv == 0) { ?>
                <li>
                    <a href="/admin/page/user/user-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27038" data-name="그룹 27038" transform="translate(-5691 5920)">
							<rect id="사각형_24531" data-name="사각형 24531" width="20" height="20" transform="translate(5691 -5920)" fill="none"/>
							<g id="그룹_27032" data-name="그룹 27032" transform="translate(-2.35 -2.532)">
							  <path id="패스_8481" data-name="패스 8481" d="M605.151,329.426A3.425,3.425,0,1,1,601.727,326,3.421,3.421,0,0,1,605.151,329.426Z" transform="translate(5101.958 -6241.465)" fill="#757f8d"/>
							  <path id="패스_8482" data-name="패스 8482" d="M610.95,340.366c-.313-3.846-3.92-6.887-8.334-6.887s-8.019,3.041-8.335,6.887Z" transform="translate(5101.068 -6239.81)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>회원관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/user/user-info.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
                <li>
                    <a href="/admin/page/user/shop-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27038" data-name="그룹 27038" transform="translate(-5691 5920)">
							<rect id="사각형_24531" data-name="사각형 24531" width="20" height="20" transform="translate(5691 -5920)" fill="none"/>
							<g id="그룹_27032" data-name="그룹 27032" transform="translate(-2.35 -2.532)">
							  <path id="패스_8481" data-name="패스 8481" d="M605.151,329.426A3.425,3.425,0,1,1,601.727,326,3.421,3.421,0,0,1,605.151,329.426Z" transform="translate(5101.958 -6241.465)" fill="#757f8d"/>
							  <path id="패스_8482" data-name="패스 8482" d="M610.95,340.366c-.313-3.846-3.92-6.887-8.334-6.887s-8.019,3.041-8.335,6.887Z" transform="translate(5101.068 -6239.81)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>사장님관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/user/shop-info.php">상세</a></li>
                        <li><a href="/admin/page/user/store-info.php">상세</a></li>
                    </ul>
                </li>
				<?php if($lv == 0) { ?>
				<li>
                    <a href="javascript: void(0);" class="has-arrow">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27039" data-name="그룹 27039" transform="translate(-5691 5891)">
							<rect id="사각형_24532" data-name="사각형 24532" width="20" height="20" transform="translate(5691 -5891)" fill="none"/>
							<g id="그룹_27036" data-name="그룹 27036" transform="translate(-0.403 0.343)">
							  <g id="그룹_27033" data-name="그룹 27033" transform="translate(5696.437 -5884.757)">
								<path id="패스_8475" data-name="패스 8475" d="M583.6,304.416a2.043,2.043,0,1,1-2.041-2.043A2.041,2.041,0,0,1,583.6,304.416Z" transform="translate(-576.592 -302.373)" fill="#757f8d"/>
								<path id="패스_8476" data-name="패스 8476" d="M586.644,311.7a5.058,5.058,0,0,0-9.934,0Z" transform="translate(-576.71 -302.154)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27035" data-name="그룹 27035" transform="translate(5691.403 -5886.342)">
								<path id="패스_8477" data-name="패스 8477" d="M578.772,302.892a2.043,2.043,0,1,1-2.043-2.04A2.045,2.045,0,0,1,578.772,302.892Z" transform="translate(-571.761 -300.852)" fill="#757f8d"/>
								<path id="패스_8478" data-name="패스 8478" d="M579.584,306.808a5.415,5.415,0,0,0-2.738-.73,4.777,4.777,0,0,0-4.967,4.1h4.253A4.6,4.6,0,0,1,579.584,306.808Z" transform="translate(-571.879 -300.633)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27034" data-name="그룹 27034" transform="translate(5703.7 -5886.342)">
								<path id="패스_8479" data-name="패스 8479" d="M584.347,302.892a2.043,2.043,0,1,0,2.043-2.04A2.044,2.044,0,0,0,584.347,302.892Z" transform="translate(-583.652 -300.852)" fill="#757f8d"/>
								<path id="패스_8480" data-name="패스 8480" d="M583.68,306.808a5.406,5.406,0,0,1,2.738-.73,4.774,4.774,0,0,1,4.965,4.1H587.13A4.59,4.59,0,0,0,583.68,306.808Z" transform="translate(-583.68 -300.633)" fill="#757f8d"/>
							  </g>
							</g>
						  </g>
						</svg>
                        <span>영업자관리</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
						<li>
							<a href="<?=$href.'admin/page/user/cntr-list.php'?>">
								<span>총판관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="<?=$href.'admin/page/user/cntr-info.php'?>">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="<?=$href.'admin/page/user/agcy-list.php'?>">
								<span>센터관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="<?=$href.'admin/page/user/agcy-info.php'?>">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="<?=$href.'admin/page/user/sell-list.php'?>">
								<span>대리점관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="<?=$href.'admin/page/user/sell-info.php'?>">상세</a></li>
							</ul>
						</li>
						<li>
							<a href="<?=$href.'admin/page/user/mmgr-list.php'?>">
								<span>매니저관리</span>
							</a>
							<ul class="sub-menu d-none" aria-expanded="true">
								<li><a href="<?=$href.'admin/page/user/mmgr-info.php'?>">상세</a></li>
							</ul>
						</li>
                    </ul>
                </li>
				<?php } ?>
				<?php if($lv != 0) { ?>
				<?php if($lv < 2) { ?>
                <li>
                    <a href="<?=$href.'admin/page/user/agcy-list.php'?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27039" data-name="그룹 27039" transform="translate(-5691 5891)">
							<rect id="사각형_24532" data-name="사각형 24532" width="20" height="20" transform="translate(5691 -5891)" fill="none"/>
							<g id="그룹_27036" data-name="그룹 27036" transform="translate(-0.403 0.343)">
							  <g id="그룹_27033" data-name="그룹 27033" transform="translate(5696.437 -5884.757)">
								<path id="패스_8475" data-name="패스 8475" d="M583.6,304.416a2.043,2.043,0,1,1-2.041-2.043A2.041,2.041,0,0,1,583.6,304.416Z" transform="translate(-576.592 -302.373)" fill="#757f8d"/>
								<path id="패스_8476" data-name="패스 8476" d="M586.644,311.7a5.058,5.058,0,0,0-9.934,0Z" transform="translate(-576.71 -302.154)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27035" data-name="그룹 27035" transform="translate(5691.403 -5886.342)">
								<path id="패스_8477" data-name="패스 8477" d="M578.772,302.892a2.043,2.043,0,1,1-2.043-2.04A2.045,2.045,0,0,1,578.772,302.892Z" transform="translate(-571.761 -300.852)" fill="#757f8d"/>
								<path id="패스_8478" data-name="패스 8478" d="M579.584,306.808a5.415,5.415,0,0,0-2.738-.73,4.777,4.777,0,0,0-4.967,4.1h4.253A4.6,4.6,0,0,1,579.584,306.808Z" transform="translate(-571.879 -300.633)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27034" data-name="그룹 27034" transform="translate(5703.7 -5886.342)">
								<path id="패스_8479" data-name="패스 8479" d="M584.347,302.892a2.043,2.043,0,1,0,2.043-2.04A2.044,2.044,0,0,0,584.347,302.892Z" transform="translate(-583.652 -300.852)" fill="#757f8d"/>
								<path id="패스_8480" data-name="패스 8480" d="M583.68,306.808a5.406,5.406,0,0,1,2.738-.73,4.774,4.774,0,0,1,4.965,4.1H587.13A4.59,4.59,0,0,0,583.68,306.808Z" transform="translate(-583.68 -300.633)" fill="#757f8d"/>
							  </g>
							</g>
						  </g>
						</svg>
                        <span>센터관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="<?=$href.'admin/page/user/agcy-info.php'?>">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
				<?php if($lv < 3) { ?>
                <li>
                    <a href="<?=$href.'admin/page/user/sell-list.php'?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27039" data-name="그룹 27039" transform="translate(-5691 5891)">
							<rect id="사각형_24532" data-name="사각형 24532" width="20" height="20" transform="translate(5691 -5891)" fill="none"/>
							<g id="그룹_27036" data-name="그룹 27036" transform="translate(-0.403 0.343)">
							  <g id="그룹_27033" data-name="그룹 27033" transform="translate(5696.437 -5884.757)">
								<path id="패스_8475" data-name="패스 8475" d="M583.6,304.416a2.043,2.043,0,1,1-2.041-2.043A2.041,2.041,0,0,1,583.6,304.416Z" transform="translate(-576.592 -302.373)" fill="#757f8d"/>
								<path id="패스_8476" data-name="패스 8476" d="M586.644,311.7a5.058,5.058,0,0,0-9.934,0Z" transform="translate(-576.71 -302.154)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27035" data-name="그룹 27035" transform="translate(5691.403 -5886.342)">
								<path id="패스_8477" data-name="패스 8477" d="M578.772,302.892a2.043,2.043,0,1,1-2.043-2.04A2.045,2.045,0,0,1,578.772,302.892Z" transform="translate(-571.761 -300.852)" fill="#757f8d"/>
								<path id="패스_8478" data-name="패스 8478" d="M579.584,306.808a5.415,5.415,0,0,0-2.738-.73,4.777,4.777,0,0,0-4.967,4.1h4.253A4.6,4.6,0,0,1,579.584,306.808Z" transform="translate(-571.879 -300.633)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27034" data-name="그룹 27034" transform="translate(5703.7 -5886.342)">
								<path id="패스_8479" data-name="패스 8479" d="M584.347,302.892a2.043,2.043,0,1,0,2.043-2.04A2.044,2.044,0,0,0,584.347,302.892Z" transform="translate(-583.652 -300.852)" fill="#757f8d"/>
								<path id="패스_8480" data-name="패스 8480" d="M583.68,306.808a5.406,5.406,0,0,1,2.738-.73,4.774,4.774,0,0,1,4.965,4.1H587.13A4.59,4.59,0,0,0,583.68,306.808Z" transform="translate(-583.68 -300.633)" fill="#757f8d"/>
							  </g>
							</g>
						  </g>
						</svg>
                        <span>대리점관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="<?=$href.'admin/page/user/sell-info.php'?>">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
				<?php if($lv < 4) { ?>
                <li>
                    <a href="<?=$href.'admin/page/user/mngr-list.php'?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27039" data-name="그룹 27039" transform="translate(-5691 5891)">
							<rect id="사각형_24532" data-name="사각형 24532" width="20" height="20" transform="translate(5691 -5891)" fill="none"/>
							<g id="그룹_27036" data-name="그룹 27036" transform="translate(-0.403 0.343)">
							  <g id="그룹_27033" data-name="그룹 27033" transform="translate(5696.437 -5884.757)">
								<path id="패스_8475" data-name="패스 8475" d="M583.6,304.416a2.043,2.043,0,1,1-2.041-2.043A2.041,2.041,0,0,1,583.6,304.416Z" transform="translate(-576.592 -302.373)" fill="#757f8d"/>
								<path id="패스_8476" data-name="패스 8476" d="M586.644,311.7a5.058,5.058,0,0,0-9.934,0Z" transform="translate(-576.71 -302.154)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27035" data-name="그룹 27035" transform="translate(5691.403 -5886.342)">
								<path id="패스_8477" data-name="패스 8477" d="M578.772,302.892a2.043,2.043,0,1,1-2.043-2.04A2.045,2.045,0,0,1,578.772,302.892Z" transform="translate(-571.761 -300.852)" fill="#757f8d"/>
								<path id="패스_8478" data-name="패스 8478" d="M579.584,306.808a5.415,5.415,0,0,0-2.738-.73,4.777,4.777,0,0,0-4.967,4.1h4.253A4.6,4.6,0,0,1,579.584,306.808Z" transform="translate(-571.879 -300.633)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27034" data-name="그룹 27034" transform="translate(5703.7 -5886.342)">
								<path id="패스_8479" data-name="패스 8479" d="M584.347,302.892a2.043,2.043,0,1,0,2.043-2.04A2.044,2.044,0,0,0,584.347,302.892Z" transform="translate(-583.652 -300.852)" fill="#757f8d"/>
								<path id="패스_8480" data-name="패스 8480" d="M583.68,306.808a5.406,5.406,0,0,1,2.738-.73,4.774,4.774,0,0,1,4.965,4.1H587.13A4.59,4.59,0,0,0,583.68,306.808Z" transform="translate(-583.68 -300.633)" fill="#757f8d"/>
							  </g>
							</g>
						  </g>
						</svg>
                        <span>매니저관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="<?=$href.'admin/page/user/mngr-info.php'?>">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
				<?php } ?>
				<?php if($lv == 0) { ?>
                <li>
                    <a href="/admin/page/report/singo-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28294" data-name="그룹 28294" transform="translate(3285 -736)">
							<rect id="사각형_24647" data-name="사각형 24647" width="20" height="20" transform="translate(-3285 736)" fill="none"/>
							<g id="그룹_28293" data-name="그룹 28293" transform="translate(-24 10)">
							  <path id="패스_8854" data-name="패스 8854" d="M2.142,11.713A2.144,2.144,0,1,0,4.289,13.86a2.148,2.148,0,0,0-2.147-2.147" transform="translate(-3259 728)" fill="#757f8d"/>
							  <path id="패스_8855" data-name="패스 8855" d="M.141,5.494V8.306a7.622,7.622,0,0,1,5.295,2.259A7.669,7.669,0,0,1,7.69,15.88h2.82A10.536,10.536,0,0,0,.141,5.494" transform="translate(-3259 728)" fill="#757f8d"/>
							  <path id="패스_8856" data-name="패스 8856" d="M.145,0V2.81A13.217,13.217,0,0,1,13.183,15.88H16A16.032,16.032,0,0,0,.145,0" transform="translate(-3259 728)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>신고관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/report/singo-info.php">상세</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/page/report/sales.php?month=<?=$now?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27041" data-name="그룹 27041" transform="translate(-5691 5844)">
							<rect id="사각형_24534" data-name="사각형 24534" width="20" height="20" transform="translate(5691 -5844)" fill="none"/>
							<g id="그룹_27020" data-name="그룹 27020" transform="translate(11349.838 61.791) rotate(-90)">
							  <rect id="사각형_24526" class="rect" data-name="사각형 24526" width="15.64" height="2.908" transform="translate(5888.151 -5645.077)" fill="#757f8d"/>
							  <rect id="사각형_24527" class="rect" data-name="사각형 24527" width="11.454" height="2.912" transform="translate(5888.151 -5650.459)" fill="#757f8d"/>
							  <rect id="사각형_24528" class="rect" data-name="사각형 24528" width="7.264" height="2.91" transform="translate(5888.151 -5655.838)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>매출내역</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/report/sales.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
                <li>
                    <a href="/admin/page/report/calculate.php?state=<?=$calc[$lv]?>&date=<?=$now?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27042" data-name="그룹 27042" transform="translate(-5691 5820)">
							<rect id="사각형_24535" data-name="사각형 24535" width="20" height="20" transform="translate(5691 -5820)" fill="none"/>
							<path id="패스_8473" data-name="패스 8473" d="M512.857,359.416v17.021h12.137V359.416Zm2.175,2.22h7.786v3.4h-7.786Zm1.783,12.581h-1.921V372.44h1.921Zm0-2.812h-1.921v-1.776h1.921Zm0-2.813h-1.921v-1.776h1.921Zm3.072,5.625h-1.921V372.44h1.921Zm0-2.812h-1.921v-1.776h1.921Zm0-2.813h-1.921v-1.776h1.921Zm3.071,5.625h-1.923V372.44h1.923Zm0-2.812h-1.923v-1.776h1.923Zm0-2.813h-1.923v-1.776h1.923Z" transform="translate(5182.143 -6178.416)" fill="#757f8d"/>
						  </g>
						</svg>
                        <span>정산관리</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/report/calculate.php">상세</a></li>
                    </ul>
                </li>
				<?php if($lv < 2) { ?>
                <li>
                    <a href="/admin/page/cash/banr-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28316" data-name="그룹 28316" transform="translate(3286 -538)">
							<rect id="사각형_24510" data-name="사각형 24510" width="20" height="20" transform="translate(-3286 538)" fill="none"/>
							<path id="패스_8837" data-name="패스 8837" d="M1.119,5.6H7.836v7.837H8.955v3.357H1.119ZM8.955,1.119h5.6v2.24h2.24v8.954H8.955ZM7.836,0V4.479H0V17.911H10.075V13.434h7.836V2.239L15.672,0Z" transform="translate(-3285 539)" fill="#757f8d"/>
						  </g>
						</svg>
                        <span>광고<?=$lv == 0 ? "관리":"영업관리"?></span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/cash/banr-info.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
				<?php if($lv == 0) { ?>
				<li>
                    <a href="javascript: void(0);" class="has-arrow">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28301" data-name="그룹 28301" transform="translate(3132 -656)">
							<rect id="사각형_24639" data-name="사각형 24639" width="20" height="20" transform="translate(-3132 656)" fill="none"/>
							<g id="그룹_28284" data-name="그룹 28284" transform="translate(126 100)">
							  <path id="패스_8841" data-name="패스 8841" d="M0,11.1l8.891,5.557,8.891-5.539-1.6-1L8.891,14.657,1.6,10.1Z" transform="translate(-3257 558.126)" fill="#757f8d"/>
							  <path id="패스_8842" data-name="패스 8842" d="M0,8.125l8.891,5.557,8.891-5.54-1.64-1.028L8.891,11.633,1.638,7.1Z" transform="translate(-3257 557.791)" fill="#757f8d"/>
							  <path id="패스_8843" data-name="패스 8843" d="M8.892,0,0,5.557l8.891,5.557,8.891-5.539Z" transform="translate(-3257 557)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>게시판관리</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li>
                            <a href="/admin/page/board/faq-list.php">
                                <span>FAQ관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/admin/page/board/faq-info.php">상세</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?=$href.'admin/page/board/noti-list.php'?>">
                                <span>공지사항관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="<?=$href.'admin/page/board/noti-info.php'?>">상세</a></li>
                                <li><a href="<?=$href.'admin/page/board/noti-write.php'?>">등록</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?=$href.'admin/page/board/news-list.php'?>">
                                <span>소식관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="<?=$href.'admin/page/board/news-info.php'?>">상세</a></li>
                            </ul>
                        </li>
						<li>
                            <a href="/admin/page/board/file-list.php">
                                <span>자료실</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/admin/page/board/file-info.php">상세</a></li>
                                <li><a href="/admin/page/board/file-write.php">등록</a></li>
                            </ul>
                        </li>
                        <!--<li>
                            <a href="/admin/page/board/event-list.php">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
								  <g id="그룹_27044" data-name="그룹 27044" transform="translate(-5691 5773)">
									<rect id="사각형_24537" data-name="사각형 24537" width="20" height="20" transform="translate(5691 -5773)" fill="none"/>
									<g id="그룹_27024" data-name="그룹 27024" transform="translate(4439.131 -6480.929)">
									  <g id="그룹_27023" data-name="그룹 27023" transform="translate(1254.869 709.929)">
										<path id="패스_8471" data-name="패스 8471" d="M1258.761,715.072v-.02h-3.892v6.7h3.892v-.017l9.646,5.173V709.929Z" transform="translate(-1254.869 -709.929)" fill="#757f8d"/>
									  </g>
									</g>
								  </g>
								</svg>
                                <span>이벤트관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/admin/page/board/event-info.php">상세</a></li>
                            </ul>
                        </li>-->
                        <li>
                            <a href="/admin/page/board/banr-list.php">
                                <span>배너관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/admin/page/board/banr-info.php">상세</a></li>
                            </ul>
                        </li>
                        <!--<li>
                            <a href="/admin/page/board/popup-list.php">
								<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
								  <g id="그룹_27047" data-name="그룹 27047" transform="translate(-5691 5702)">
									<rect id="사각형_24540" data-name="사각형 24540" width="20" height="20" transform="translate(5691 -5702)" fill="none"/>
									<g id="그룹_27022" data-name="그룹 27022" transform="translate(-120.921 -315.588)">
									  <rect id="사각형_24530" class="rect" data-name="사각형 24530" width="11.022" height="11.02" rx="0.563" transform="translate(5812.921 -5379.354)" fill="#757f8d"/>
									  <path id="패스_8469" data-name="패스 8469" d="M185.729,445.332h-8.662a1.179,1.179,0,0,0-1.177,1.181v3.16h5.5a1.183,1.183,0,0,1,1.183,1.181v5.5h3.16a1.181,1.181,0,0,0,1.181-1.181v-8.658A1.181,1.181,0,0,0,185.729,445.332Z" transform="translate(5643.092 -5830.744)" fill="#757f8d"/>
									</g>
								  </g>
								</svg>
                                <span>팝업관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/admin/page/board/popup-info.php">상세</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/page/board/faq-list.php">
                                <span>문의하기</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/page/board/faq-info.php">상세</a></li>
                            </ul>
                        </li>-->
                        <li>
                            <a href="/admin/page/board/logo.php">
                                <span>로고송신청관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/page/board/noti-list.php">상세</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/admin/page/board/code.php">
                                <span>카테고리관리</span>
                            </a>
                            <ul class="sub-menu d-none" aria-expanded="true">
                                <li><a href="/page/board/noti-list.php">상세</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/page/report/statistics.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27041" data-name="그룹 27041" transform="translate(-5691 5844)">
							<rect id="사각형_24534" data-name="사각형 24534" width="20" height="20" transform="translate(5691 -5844)" fill="none"/>
							<g id="그룹_27020" data-name="그룹 27020" transform="translate(11349.838 61.791) rotate(-90)">
							  <rect id="사각형_24526" class="rect" data-name="사각형 24526" width="15.64" height="2.908" transform="translate(5888.151 -5645.077)" fill="#757f8d"/>
							  <rect id="사각형_24527" class="rect" data-name="사각형 24527" width="11.454" height="2.912" transform="translate(5888.151 -5650.459)" fill="#757f8d"/>
							  <rect id="사각형_24528" class="rect" data-name="사각형 24528" width="7.264" height="2.91" transform="translate(5888.151 -5655.838)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>통계</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/hire/hire1-info.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
				<?php if($lv != 0) { ?>
                <li>
                    <a href="/admin/page/board/noti-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27044" data-name="그룹 27044" transform="translate(-5691 5773)">
							<rect id="사각형_24537" data-name="사각형 24537" width="20" height="20" transform="translate(5691 -5773)" fill="none"/>
							<g id="그룹_27024" data-name="그룹 27024" transform="translate(4439.131 -6480.929)">
							  <g id="그룹_27023" data-name="그룹 27023" transform="translate(1254.869 709.929)">
								<path id="패스_8471" data-name="패스 8471" d="M1258.761,715.072v-.02h-3.892v6.7h3.892v-.017l9.646,5.173V709.929Z" transform="translate(-1254.869 -709.929)" fill="#757f8d"/>
							  </g>
							</g>
						  </g>
						</svg>
                        <span>공지사항</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/board/noti-info.php">상세</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/page/board/file-list.php">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						 <g id="그룹_27047" data-name="그룹 27047" transform="translate(-5691 5702)">
							<rect id="사각형_24540" data-name="사각형 24540" width="20" height="20" transform="translate(5691 -5702)" fill="none"/>
							<g id="그룹_27022" data-name="그룹 27022" transform="translate(-120.921 -315.588)">
							 <rect id="사각형_24530" class="rect" data-name="사각형 24530" width="11.022" height="11.02" rx="0.563" transform="translate(5812.921 -5379.354)" fill="#757f8d"/>
							  <path id="패스_8469" data-name="패스 8469" d="M185.729,445.332h-8.662a1.179,1.179,0,0,0-1.177,1.181v3.16h5.5a1.183,1.183,0,0,1,1.183,1.181v5.5h3.16a1.181,1.181,0,0,0,1.181-1.181v-8.658A1.181,1.181,0,0,0,185.729,445.332Z" transform="translate(5643.092 -5830.744)" fill="#757f8d"/>
							</g>
						  </g>
						</svg>
                        <span>자료실</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/board/file-info.php">상세</a></li>
                    </ul>
                </li>
                <li>
                    <a href="/admin/page/user/<?=$mypage[$lv]?>-info.php?agency_no=<?=$_SESSION['no']?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_27037" data-name="그룹 27037" transform="translate(-5691 5943)">
							<rect id="사각형_24510" data-name="사각형 24510" width="20" height="20" transform="translate(5691 -5943)" fill="none"/>
							<g id="그룹_27019" data-name="그룹 27019" transform="translate(-543.667 -213.287)">
							  <g id="그룹_27016" data-name="그룹 27016" transform="translate(6236.667 -5726.713)">
								<rect id="사각형_24520" class="rect" data-name="사각형 24520" width="2.932" height="2.93" fill="#757f8d"/>
								<rect id="사각형_24521" class="rect" data-name="사각형 24521" width="10.99" height="2.93" transform="translate(5.679)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27017" data-name="그룹 27017" transform="translate(6236.667 -5720.91)">
								<rect id="사각형_24522" class="rect" data-name="사각형 24522" width="2.932" height="2.93" fill="#757f8d"/>
								<rect id="사각형_24523" class="rect" data-name="사각형 24523" width="10.99" height="2.93" transform="translate(5.679)" fill="#757f8d"/>
							  </g>
							  <g id="그룹_27018" data-name="그룹 27018" transform="translate(6236.667 -5715.108)">
								<rect id="사각형_24524" class="rect" data-name="사각형 24524" width="2.932" height="2.932" fill="#757f8d"/>
								<rect id="사각형_24525" class="rect" data-name="사각형 24525" width="10.99" height="2.932" transform="translate(5.679)" fill="#757f8d"/>
							  </g>
							</g>
						  </g>
						</svg>
                        <span>내 정보</span>
                    </a>
                    <ul class="sub-menu d-none" aria-expanded="true">
                        <li><a href="/admin/page/user/<?=$mypage[$lv]?>-info.php">상세</a></li>
                    </ul>
                </li>
				<?php } ?>
                <li>
                    <a href="/admin/logout.php" onclick="return outFunction();">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
						  <g id="그룹_28319" data-name="그룹 28319" transform="translate(3267 -1733)">
							<path id="패스_8858" data-name="패스 8858" d="M11.143,3H9.714L4,8.714H5.429Z" transform="translate(-3265.286 1734.286)" fill="#757f8d"/>
							<path id="패스_8859" data-name="패스 8859" d="M4,7H5.429l5.714,5.714H9.714Z" transform="translate(-3265.286 1736)" fill="#757f8d"/>
							<path id="패스_8860" data-name="패스 8860" d="M1.429,1.429H18.571V18.571H1.429ZM0,20H20V0H0Z" transform="translate(-3267 1733)" fill="#757f8d"/>
						  </g>
						</svg>
                        <span>로그아웃</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>