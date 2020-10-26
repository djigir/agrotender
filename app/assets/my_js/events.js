window.onload = function (){
    if($('#active-region').attr('check_active')){
        $('#active-region').addClass('active');
        $('#active-port').removeClass('active');
        $('#show-region').addClass('active');
        $('#show-port').removeClass('active');
    }

    if($('#active-port').attr('check_active')){
        $('#active-port').addClass('active');
        $('#active-region').removeClass('active');
        $('#show-port').addClass('active');
        $('#show-region').removeClass('active');
    }

    if($('#new_filters_currency_uah').attr('currency') != '' && $('#new_filters_currency_uah').attr('currency') == 0){
        $('#new_filters_currency_uah').attr('checked', 'true');
    }

    if ($('#new_filters_currency_usd').attr('currency') != '' && $('#new_filters_currency_usd').attr('currency') == 1) {
        $('#new_filters_currency_usd').attr('checked', 'true');
    }

    $('.mobile-icon').click(function () {
        $(".filters-wrap").toggle();

        if($(".filters-wrap").css('display') == 'block'){
            $('body').addClass('open');
            $('.wrap').addClass('open');
        }else{
            $('body').removeClass('open');
            $('.wrap').removeClass('open');
        }

    });

    $("#type-page").click(function () {
        $('.step-1').css('display', 'none');
        $('.step-2').css('display', '');
    });

    $("#back-page-type").click(function () {
        $('.step-1').css('display', '');
        $('.step-2').css('display', 'none');
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

    $("#choseProduct").mouseover(function () {
        $("#choseProduct").addClass('active');
    });

    $("#choseProduct").mouseout(function () {
        $("#choseProduct").removeClass('active');
    });

    $(".new_filters").mouseover(function () {
        $('.new_filters').addClass('active');
        $('.bg_filters').addClass('active');
    });
    $(".new_filters").mouseout(function () {
        $('.new_filters').removeClass('active');
        $('.bg_filters').removeClass('active');
    });


    $("#all_ukraine").mouseover(function () {
        $("#all_ukraine").addClass('active');
    });

    $("#all_ukraine").mouseout(function () {
        $("#all_ukraine").removeClass('active');
    });

    $('#active-region').click(function (event) {
        $('#active-region').addClass('active');
        $('#show-region').addClass('active');
        $('#show-port').removeClass('active');
        $('#active-port').removeClass('active');
    });

    $('#active-port').click(function (event) {
        $('#active-region').removeClass('active');
        $('#show-region').removeClass('active');
        $('#show-port').addClass('active');
        $('#active-port').addClass('active');
    });



    $(".group-culture").click(function (event) {
        let group = event.currentTarget.attributes[1].nodeValue;
        let group_culture = $(".group-culture");
        let culture_group = $(".culture-group");

        for(let i = 0; i < group_culture.length; i++){
            let elem = group_culture[i];
            elem.classList.remove('active');
            if(elem.getAttribute('group') === group){
                elem.classList.add('active');
            }
        }

        for(let i = 0; i < culture_group.length; i++){
            let elem = culture_group[i];
            elem.classList.remove('active');
            if(elem.getAttribute('group') === group){
                elem.classList.add('active');
            }
        }

    });



    $(".rubricInput").click(function (event) {
        $("#rubricDrop").toggle();
        $("#regionDrop").hide();
        $(".rubricGroup").hide();

        if (!$(".rubricInput").hasClass('isopen')) {
            $(".rubricInput").addClass('isopen');
        } else {
            $(".rubricInput").removeClass('isopen');
        }
    });

    $(".regionInput").click(function (event) {
        $("#regionDrop").toggle();
        $("#rubricDrop").hide();

        if (!$(".regionInput").hasClass('isopen')) {
            $(".regionInput").addClass('isopen');
        } else {
            $(".regionInput").removeClass('isopen');
        }
    });

    $(".getRubricGroup").click(function (event) {
        let group = event.currentTarget.attributes[1].nodeValue;
        console.log(group);
        for(let i = 0; i < $('.groupCulture').length; i++){
            let elem = $('.groupCulture')[i];
            elem.style.cssText = 'display: none !important';
            if(elem.getAttribute('group') === group){
                elem.style.cssText = 'display: block; column-count: 2; ';
            }
        }
    });

    $('.btn-search').click(function (event) {
        console.log($('#searchInput').val());

        if($('#searchInput').val() === ''){
            $('.searchDiv').addClass('tip');
            setTimeout(() => {
                $('.searchDiv').removeClass('tip');
            }, 500);
            event.preventDefault();
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

        for (let i = 0; i < $('.culture').length; i++) {
            let elem = $('.culture')[i];
            let group = event.currentTarget.attributes[2].value;
            elem.style.cssText = 'display: none !important';

            if (elem.getAttribute('group') === group) {
                elem.style.cssText = 'display: block';
            }
        }
    });

    $(".culture").click(function (event) {
        console.log('culture');
        let group = event.currentTarget.attributes[2].nodeValue;
        let rubric_name = event.target.innerText;
        let rubric_id = event.currentTarget.attributes[3].nodeValue;

        $('#span-mobile-rubric').html(rubric_name);
        $('#input-mobile-rubric').attr('value', rubric_id);

        $('.step-1').css('display', '');
        $('.step-3').css('display', 'none');
        $('.step-3-1').css('display', 'none');
    });

    $(".region").click(function (event) {
        let region = event.currentTarget.attributes[2].nodeValue;
        let region_name = event.target.innerHTML;

        $('#span-mobile-region').html(region_name);
        $('#input-mobile-region').attr('value', region);

        $('#input-mobile-region-t').attr('value', region);
        $('#input-mobile-port-t').attr('value', null);


        $('.step-1').css('display', '');
        $('.step-4').css('display', 'none');

    });

    $('.port').click(function (event) {
        let region = event.currentTarget.attributes[2].nodeValue;
        $('#input-mobile-port-t').attr('value', region);
        $('#input-mobile-region-t').attr('value', null);
        console.log(region);
    });

    $('.remove-style-btn').click(function (event) {
        $('.remove-style-btn').css('border', 'none');
    })

    /* alert rewievs page */

    $('.addReview').on('click', function () {
        $('.noty_layout').css('display', 'block');
    });

};