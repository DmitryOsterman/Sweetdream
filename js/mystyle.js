// ========= полная загрузка странички с использованием jQuery: ========
$(document).ready(function () {

    console.log($('#idSearch').attr('name'));

// ==========   карусель главный покупок  =============================
//    $(function () {
//        $(".mainGoods").jCarouselLite({
//            auto: 4000,
//            speed: 2000,
//            visible: 1
//        });
//    });


// ==========   карусель топ покупок  =============================
    $(function () {
        $(".topSale").jCarouselLite({
            auto: 2000,
            speed: 2000,
            visible: 5
        });
    });


//========================================================================




//========================================================================
//  Показ / скрыть форму входа на сайт

//    $("#siteLogin").click(function () {
//        // скрываем сообщение warnings
//        $(".warning").hide(100);
//        // Показ / скрыть форму
//        $(".formLogin").toggle(100);
//    });
//
//    $("#closeFormLogin").click(function () {
//        $(".formLogin").hide();
//    });

//  Перехват управления Входа на сайт по ссылке

//    $("a#siteLogin").click(function (event) {
//        event.preventDefault();
//    });



//
//    $(function () {
//        if ((".formLogin").display != "none") {
//
//        }
//    })




});
//============================================================================
//  Показ \ скрыть форму входа на сайт
//   $('.formLogin').hide();
//   $('siteLogin a').click(function () {
//$(".siteLogin").click(
//    $(function () {
//        $('.formLogin').toggle(1600);
//    })
//)
//;


//=======       изм цвета через JS     ====================================
//        $('li a').hover(
//                function () {
//                    $(this).css('color', 'orange');
//                },
//                function () {
//                    $(this).css('color', '');
//                }
//        );

//    ========= эфект исчезновения и появления строки поиска ==============
//$('.searchContainer a').bind('click', function () {
//    $('#idSearch').toggle(555);
//});

//    ========= варианты карусели ==============
//$(function () {
//    $(".goods").jCarouselLite({
//        auto: 2000,
//        speed: 2000,
//        visible: 4
//        btnNext: ".next",
//        btnPrev: ".prev"
//    });
//});

// ==========   тень заголовков     ================
//    $('h1').dropShadow({left: 2, top: -19, blur: 0});  // Creates new drop shadows
//    $('h2').dropShadow({left: 2, top: -17, blur: 0});  // Creates new drop shadows
