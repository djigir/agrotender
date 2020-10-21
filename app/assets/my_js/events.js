window.onload = function (){
    $('.searchIcon').click(function () {
        console.log('click');
        if ($('.filters-wrap').css('display') == 'none') {
            $('.filters-wrap').css('display', 'block')
        } else {
            $('.filters-wrap').css('display', 'none')
        }
    });

    $('.back').click(function () {
        if ($('.userMobileMenu').css('display') == 'none') {
            $('.userMobileMenu').css('display', 'block')
        } else {
            $('.userMobileMenu').css('display', 'none')
        }
    });

    $('.userIcon').click(function () {
        if ($('.userMobileMenu').css('display') == 'none') {
            $('.userMobileMenu').css('display', 'block')
        } else {
            $('.userMobileMenu').css('display', 'none')
        }
    });

    $('.burger').click(function () {
        console.log('click burger');
        if(!$('.overlay').hasClass('open')){
            $('.overlay').addClass('open');
            $('.mobileMenu').addClass('open');
        }else{
            $('.overlay').removeClass('open');
            $('.mobileMenu').removeClass('open');
        }
    });

    $('.overlay').click(function () {
        $('.overlay').removeClass('open');
        $('.mobileMenu').removeClass('open');
    });
}


