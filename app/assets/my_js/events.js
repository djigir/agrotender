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

    $(".rubricInput").click(function (event) {
        if($("#rubricDrop").css('display') == 'none'){
            $("#rubricDrop").css('display', 'block')
        }else{
            $("#rubricDrop").css('display', 'none')
        }

    });

    $(".regionInput").click(function (event) {
        if($("#regionDrop").css('display') == 'none'){
            $("#regionDrop").css('display', 'block')
        }else{
            $("#regionDrop").css('display', 'none')
        }
    });

    $(".getRubricGroup").click(function (event) {
        $('.group-1').css('display', 'none');
        $('.group-2').css('display', 'none');
        $('.group-3').css('display', 'none');
        $('.group-4').css('display', 'none');
        $('.group-5').css('display', 'none');
        $('.group-6').css('display', 'none');
        $('.group-7').css('display', 'none');
        let group = event.currentTarget.attributes[1].nodeValue;

        if($(`.${group}`).css('display') == 'none'){
            $(`.${group}`).css('display', 'block')
        }else{
            $(`.${group}`).css('display', 'none')
        }

    });

    $("#choseProduct").click(function () {

        if (!$("#choseProduct").hasClass('active')) {
            $("#choseProduct").addClass('active');
        } else {
            $("#choseProduct").removeClass('active');
        }

    });

    $("#all_ukraine").click(function () {
        if (!$("#all_ukraine").hasClass('active')) {
            $("#all_ukraine").addClass('active');
        } else {
            $("#all_ukraine").removeClass('active');
        }

    });
    $(".regionInput").click(function () {
        if (!$(".regionInput").hasClass('isopen')) {
            $(".regionInput").addClass('isopen');
        } else {
            $(".regionInput").removeClass('isopen');
        }

    });

    $(".rubricInput").click(function () {
        if (!$(".rubricInput").hasClass('isopen')) {
            $(".rubricInput").addClass('isopen');
        } else {
            $(".rubricInput").removeClass('isopen');
        }

    });
}
