window.onload = function (){
    $('.searchIcon').click(function () {
        console.log('click');
        if ($('.filters-wrap').css('display') == 'none') {
            $('.filters-wrap').css('display', 'block')
        } else {
            $('.filters-wrap').css('display', 'none')
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

        if($('.filters-wrap').css('display') == 'block'){
            $('.filters-wrap').css('display', 'none')
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

    $("#mobile-rubric").click(function () {
        $('.step-1').css('display', 'none');
        $('.step-3').css('display', '');
    });

    $('#one-back').click(function () {
        if ($('.userMobileMenu').css('display') == 'none') {
            $('.userMobileMenu').css('display', 'block')
        } else {
            $('.userMobileMenu').css('display', 'none')
        }
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


    /*$(".rubric").click(function (event) {
        $('.step-3').css('display', 'none');
        $('.step-3-1').css('display', '');

        let group = event.currentTarget.attributes[2].nodeValue;
        let rubric_name = event.target.innerText;
        let rubric_number = event.target.value;
        $('#input-mobile-rubric').attr('name', rubric_name);
        $('#input-mobile-rubric').attr('value', rubric_name);

        console.log(group, rubric_number);


    });*/
    $(".region").click(function (event) {
        let region = event.currentTarget.attributes[2].nodeValue;
        let region_name = event.target.innerHTML;
        $('#input-mobile-region').attr('name', region);
        $('#input-mobile-region').attr('value', region_name);
        console.log(region,region_name, event);
    });


}


/*                */


