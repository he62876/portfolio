$('.logo_img2').hide();
$('.menu2').hide();

// $('.cont').hide();
// $('.sub').click(function () {
//     if ($(this).next().css("display") == "none") {
//         $(this).next().slideDown("fast");
//     } else {
//         $(this).next().slideUp("fast");
//     }
// });

// 메뉴
$(document).scroll(function () {
var hover = $('header .main-menu:hover').length;
var scrollTop = $(this).scrollTop();
    if (scrollTop > 300) {
        $('header').addClass('on');
        $('.logo_img2').show();
        $('.logo_img1').hide();
        $('.menu2').show();
        $('.menu1').hide();
    } else {
        if(hover == 0) {
            $('header').removeClass('on');
            $('.logo_img1').show();
            $('.logo_img2').hide();
            $('.menu1').show();
            $('.menu2').hide();
        }
    }
});

$('header .main-menu').mouseover(function () {
    $('header').addClass('on');
    $('.logo_img2').show();
    $('.logo_img1').hide();
    $('.menu2').show();
    $('.menu1').hide();
});
$('header .main-menu').mouseleave(function () {
    var scrollTop = $(document).scrollTop();
    if (scrollTop <= 300) {

        $('header').removeClass('on');
        $('.logo_img1').show();
        $('.logo_img2').hide();
        $('.menu1').show();
        $('.menu2').hide();
    }
});
// 메뉴


// 애니메이션
$(document).scroll(function() {
    var scrollTop = $(this).scrollTop();
    if(scrollTop > 500) {
        $('.brand').addClass('animate');
    } else {
        $('.brand').removeClass('animate');
    }

    if(scrollTop > 1200) {
        $('.contents ul').addClass('animate');
    } else {
        $('.contents ul').removeClass('animate');
    }

    if(scrollTop > 2000) {
        $('.invest ul').addClass('animate');
    } else {
        $('.invest ul').removeClass('animate');
    }
});
// 애니메이션

// 폼
