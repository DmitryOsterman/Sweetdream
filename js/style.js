// ========= полная загрузка странички с использованием jQuery: ========
$(document).ready(function () {

    console.log($('#idSearch').attr('name'));

// ==========   карусель топ покупок  =============================
    $(function () {
        $(".topSale").jCarouselLite({
            auto: 2000,
            speed: 2000,
            visible: 5
        });
    });

});

function toggleElemById(ob) {
    var el = document.getElementById(ob);
    el.style.display = (el.style.display != 'block' ? 'block' : 'none' );
}
