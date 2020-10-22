window.onload = function (){
    $('.searchIcon').click(function () {
        $(".filters-wrap").toggle();
    });

    $('.userIcon').click(function () {
        $(".userMobileMenu").toggle();
    });

    $('.burger').click(function () {
        if(!$('.overlay').hasClass('open')){
            $('.overlay').addClass('open');
            $('.mobileMenu').addClass('open');
        }else{
            $('.overlay').removeClass('open');
            $('.mobileMenu').removeClass('open');
        }

        if($('.filters-wrap').css('display') == 'block'){
            $('.filters-wrap').css('display', 'none')
        }
    });

    $('.overlay').click(function () {
        $('.overlay').removeClass('open');
        $('.mobileMenu').removeClass('open');
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

    $("#mobile-rubric").click(function () {
        $('.step-1').css('display', 'none');
        $('.step-3').css('display', '');
    });

    $('#one-back').click(function () {
        $(".userMobileMenu").toggle();
    });

    $("#back").click(function () {
        $('.step-1').css('display', '');
        $('.step-3').css('display', 'none');

    });

    $("#back2").click(function () {
        $('.step-1').css('display', '');
        $('.step-4').css('display', 'none');
    });

    $("#back3").click(function () {
        $('.step-3').css('display', '');
        $('.step-3-1').css('display', 'none');
    });

    $("#mobile-region").click(function () {
        $('.step-1').css('display', 'none');
        $('.step-4').css('display', '');
    });


    $(".rubric").click(function (event) {
        $('.step-3').css('display', 'none');
        $('.step-3-1').css('display', '');

        for(let i = 0; i < $('.culture').length; i++){
            let elem = $('.culture')[i];
            if(elem.getAttribute('rubricId') === event.currentTarget.attributes[2].value){
                elem.style.cssText = 'display: block';


            }else{
                elem.style.cssText = 'display: none !important';
            }

        }
    });

    $(".culture").click(function (event) {
        let group = event.currentTarget.attributes[2].nodeValue;
        let rubric_name = event.target.innerText;

        $('#span-mobile-rubric').html(rubric_name);
        $('#input-mobile-rubric').attr('value', group);

        $('.step-1').css('display', '');
        $('.step-3').css('display', 'none');
        $('.step-3-1').css('display', 'none');
    });


    $(".region").click(function (event) {
        let region = event.currentTarget.attributes[2].nodeValue;
        let region_name = event.target.innerHTML;

        $('#span-mobile-region').html(region_name);
        $('#input-mobile-region').attr('value', region);

        $('.step-1').css('display', '');
        $('.step-4').css('display', 'none');

    });
    $('.remove-style-btn').click(function (event) {
        $('.remove-style-btn').css('border', 'none');
    })
}