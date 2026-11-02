    </div>
    <footer>
        <div class="container">
            <div class="footer-menu">
                <ul>
                    <li><a href="">인사말</a></li>
                    <li><a href="">찾아오시는길</a></li>
                    <li><a href="">개인정보이용안내</a></li>
                    <li><a href="">서비스이용약관</a></li>
                </ul>
                <a href="/portfolio/works/caravan/index.php"><img src="/img/footer.svg" alt=""></a>
            </div>
            <p class="pc">
                본사 : (00000)대구광역시 중구 / TEL : 000-0000-0000 /</br>
                FAX : 000-0000-0000 / E-Mail : ○○○@mail.com / 대표이사 : 홍길동</br></br>
                COPYRIGHT(C) All Rights Reserved.
            </p>
            <p class="mb">
                본사 : (00000)대구광역시 중구 /</br>
                TEL : 000-0000-0000 / FAX : 000-0000-0000 /</br>
                E-Mail : ○○○@mail.com / 대표이사 : 홍길동</br>
                </br>
                COPYRIGHT(C) All Rights Reserved.
            </p>
        </div>
    </footer>
    </body>
    <!-- JAVASCRIPT -->
    <script src="/portfolio/works/caravan/assets/libs/jquery/jquery.min.js"></script>
    <script src="/portfolio/works/caravan/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/portfolio/works/caravan/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="/portfolio/works/caravan/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/portfolio/works/caravan/assets/libs/node-waves/waves.min.js"></script>
    <script src="/portfolio/works/caravan/assets/libs/feather-icons/feather.min.js"></script>
    <!-- pace js -->
    <script src="/portfolio/works/caravan/assets/libs/pace-js/pace.min.js"></script>

    <!-- apexcharts -->
    <script src="/portfolio/works/caravan/assets/libs/apexcharts/apexcharts.min.js"></script>

    <!-- Swiper JS -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <!-- dashboard init -->
    <script src="/portfolio/works/caravan/assets/js/pages/dashboard.init.js"></script>

    <script src="/portfolio/works/caravan/assets/js/app.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
    <script src="/portfolio/works/caravan/js/main.js"></script>

    </html>

    <script>
        var autoplay = 5000;
        var swiper = new Swiper(".banner", {
            // slidesPerView: 1,
            spaceBetween: 30,
            effect: "fade",
            fadeEffect: {
                crossFade: true,
            },
            slideToClickedSlide: false, // 해당 슬라이드 클릭시 슬라이드 위치로 이동
            allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능,
            speed: 500,
            loop: true,
            pagination: {
                el: ".banner .swiper-pagination",
                type: 'custom',
                renderCustom: function (swiper, current, total) {
                    return '<span>0' + current +
                        '</span><div  class="swiper-progress-bar" style="width: 124px; display: inline-block; "><span class="slide_progress-bar"></span></div><span>0' +
                        total + '</span>';
                }
            },
            navigation: {
                nextEl: ".banner .swiper-button-next",
                prevEl: ".banner .swiper-button-prev",
            },
            autoplay: {
                delay: autoplay,
                disableOnInteraction: false
            },
            on: {
                init: function () {
                    $(".swiper-progress-bar").removeClass("active");
                    $(".swiper-progress-bar").eq(0).addClass("animate");
                    $(".swiper-progress-bar").eq(0).addClass("active");
                    $(".swiper-progress-bar").removeClass("animate");
                },
                slideChangeTransitionStart: function () {
                    $(".swiper-progress-bar").removeClass("animate");
                    $(".swiper-progress-bar").removeClass("active");
                    $(".swiper-progress-bar").eq(0).addClass("active");
                },
                slideChangeTransitionEnd: function () {
                    $(".swiper-progress-bar").eq(0).addClass("animate");
                }
            }
        });

        $(document).ready(function () {
            swiper.autoplay.start();
            $(".swiper-progress-bar").addClass("animate");
        });

        $('#stop').click(function () {
            swiper.autoplay.stop();
            $(".swiper-progress-bar").removeClass("animate");
            $("#stop").hide();
            $("#start").show();
        });
        $('#start').click(function () {
            swiper.autoplay.start();
            $(".swiper-progress-bar").eq(0).addClass("animate");
            $("#start").hide();
            $("#stop").show();
        });


        var swiper2 = new Swiper(".brand .mySwiper", {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: autoplay,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".brand .swiper-button-next",
                prevEl: ".brand .swiper-button-prev",
            },
            slideToClickedSlide: false, // 해당 슬라이드 클릭시 슬라이드 위치로 이동
            allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
            breakpoints: { //반응형 조건 속성
                768: {
                    slidesPerView: 2,
                }
            }

        });

        var swiper3 = new Swiper(".brand .mySwiper2", {
            effect: "fade",
            loop: true,
            fadeEffect: {
                crossFade: true,
            },
            autoplay: {
                delay: autoplay,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: ".brand .swiper-button-next",
                prevEl: ".brand .swiper-button-prev",
            },
            slideToClickedSlide: false, // 해당 슬라이드 클릭시 슬라이드 위치로 이동
            allowTouchMove: false, // (false-스와이핑안됨)버튼으로만 슬라이드 조작이 가능
        });
    </script>