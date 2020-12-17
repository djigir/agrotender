window.onload = function (){
    $('#new_filters_currency_uah').attr('checked', 'true');
    $('#new_filters_currency_usd').attr('checked', 'true');
    $('#DataTables_Table_0').DataTable({
        "pageLength": 5000,
        "aaSorting": []
    });
    $('.dataTables_paginate').css('display', 'none');
    $('.dataTables_info').css('display', 'none');
    $('.dataTables_length').css('display', 'none');
    $('.dataTables_filter').css('display', 'none');

    // $(window).scroll(function() {
    //     var height = $(window).scrollTop();
    //     if(height < 90){
    //         $('#scroll-header').css('display', '');
    //     }else{
    //         $('#scroll-header').css('display', 'none');
    //     }
    //
    //     if(height > 300){
    //         $('.new_filters-wrap').addClass('active');
    //     } else{
    //         $('.new_filters-wrap').removeClass('active');
    //     }
    // });

    $('.sorting').click(function (event) {
        if($(this).hasClass('sorting_desc')){
            $(this).children('i').toggleClass('fa-sort fa-sort-down');
        } else if($(this).hasClass('sorting_asc')){
            $(this).children('i').toggleClass('fa-sort fa-sort-up');
        }
        else{
            $(this).children('i').toggleClass('fa-sort-up fa-sort');
            $(this).children('i').toggleClass('fa-sort-down fa-sort');
        }

    });

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
        $('#new_filters_currency_usd').removeAttr('checked');
        $('#new_filters_currency_uah').attr('checked', 'true');
    }

    if ($('#new_filters_currency_usd').attr('currency') != '' && $('#new_filters_currency_usd').attr('currency') == 1) {
        $('#new_filters_currency_uah').removeAttr('checked');
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
        console.log('click');
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

        if (!$(".regionInput").hasClass('isopen')) {
            $(".regionInput").addClass('isopen');
        } else {
            $(".regionInput").removeClass('isopen');
        }
    });

    $("#regionInputComp").click(function (event) {
        $("#regionDropCompany").toggle();

        if (!$("#regionInputComp").hasClass('isopen')) {
            $("#regionInputComp").addClass('isopen');
        } else {
            $("#regionInputComp").removeClass('isopen');
        }
    });

    $(".click_elev").click(function (event) {
        $("#regionDrop").toggle();
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
        let group = event.currentTarget.getAttribute('group');

        for (let i = 0; i < $('.culture').length; i++) {
            let elem = $('.culture')[i];
            elem.style.cssText = 'display: none !important';
            if (elem.getAttribute('group') === group) {
                elem.style.cssText = 'display: block';
            }
        }
    });

    $(".culture").click(function (event) {
        console.log('click')
        let group = event.currentTarget.getAttribute('group');
        let rubric_name = event.target.innerText;
        let rubric = event.currentTarget.getAttribute('rubric');

        $('#span-mobile-rubric').html(rubric_name);
        $('#input-mobile-rubric').attr('value', rubric);

        $('.step-1').css('display', '');
        $('.step-3').css('display', 'none');
        $('.step-3-1').css('display', 'none');
    });

    $(".culture_test").click(function (event) {
        console.log('click')
        let group = event.currentTarget.getAttribute('group');
        let rubric_name = event.target.innerText;
        let rubric = event.currentTarget.getAttribute('rubric');

        $('#span-mobile-rubric').html(rubric_name);
        $('#input-mobile-rubric').attr('value', rubric);

        $('.step-1').css('display', '');
        $('.step-3').css('display', 'none');
        $('.step-3-1').css('display', 'none');
    });
    
    $(".region").click(function (event) {
        let region = event.currentTarget.getAttribute('region');
        let region_name = event.currentTarget.getAttribute('region_name');

        if(region_name){
            if(region_name != 'Вся Украина' && region_name != 'АР Крым'){
                region_name += ' область';
            }
            $('#span-mobile-region').html(region_name);
        }

        $('#input-mobile-region').attr('value', region);

        $('#input-mobile-region-t').attr('value', region);
        $('#input-mobile-port-t').attr('value', null);

        $('.step-1').css('display', '');
        $('.step-4').css('display', 'none');
    });

    $('.port').click(function (event) {
        let port = event.currentTarget.getAttribute('port');
        let port_name = event.currentTarget.getAttribute('port_name');


        $('#span-mobile-region').html(port_name);
        $('#input-mobile-port-t').attr('value', port);
        $('#input-mobile-region-t').attr('value', null);
    });

    $('.remove-style-btn').click(function (event) {
        $('.remove-style-btn').css('border', 'none');
    })

    /* alert rewievs page */

    $('.addReview').on('click', function () {
        $('.noty_layout').css('display', 'block');
        /* Удаление alert по времени */
        setTimeout(function(){
            $('#noty_layout__bottomLeft').hide();
        }, 5000);
    });
    function changeBG(type = ''){
        if(type == 'active'){
            $('#bg-modal').addClass("modal-backdrop");
            $('#bg-modal').addClass("show");
            $('body').addClass('modal-open');
            $('#reviewModal').toggle();
        }else{
            $('body').removeClass('modal-open');
            $('#bg-modal').removeClass("modal-backdrop");
            $('#bg-modal').removeClass("show");
            $('#reviewModal').toggle();
        }

    }
        /* modal */
    $('#reviews').click(function () {
       changeBG('active');
    });

    $('.close').click(function (e) {
        changeBG();
    });

    /* закрыть модалльное окно по ESC */
    $(document).on('keydown', function (e) {
        if (e.keyCode == 27) {
            $('body').removeClass('modal-open');
            $('#bg-modal').removeClass("modal-backdrop");
            $('#bg-modal').removeClass("show");
            $('#reviewModal').css('display', 'none');
        }

    });

    /* изменение цвета всех звезд при клике на первую звезду */
    $("#first-rate").click(function (event) {
        let rate = $(this).attr('rate');
        $(".rate_input").attr('value', rate);
        for (let i = 0; i < $(".add_rate").length; i++) {
            let elem = $(".add_rate")[i];
            elem.classList.remove('fas');
            elem.classList.add('far');
        }
    });

    /* изменение цвета звезд на странице отзывов */
    $(".add_rate").click(function (event) {
        let rate = $(this).attr('rate');
        $(".rate_input").attr('value', rate);
        for (let i = 0; i < $(".add_rate").length; i++) {
            let elem = $(".add_rate")[i];
            if (i < rate - 1){
                elem.classList.remove('far');
                elem.classList.add('fas');
            }else  {
                elem.classList.remove('fas');
                elem.classList.add('far');
            }
        }
    })

    /* Переключение в таблице цен компании */
    $('#region-uah').click(function (event) {
        $('#region-uah').addClass('active');
        $('#region-usd').removeClass('active');

        $('.region-UAH').css('display', '');
        $('.region-USD').css('display', 'none');

    });

    $('#region-usd').click(function (event) {
        $('#region-usd').addClass('active');
        $('#region-uah').removeClass('active');

        $('.region-USD').css('display', '');
        $('.region-UAH').css('display', 'none');
    });

    $('#port-uah').click(function (event) {
        $('#port-uah').addClass('active');
        $('#port-usd').removeClass('active');

        $('.port-UAH').css('display', '');
        $('.port-USD').css('display', 'none');
    });

    $('#port-usd').click(function (event) {
        $('.port-USD').css('display', '');
        $('.port-UAH').css('display', 'none');

        $('#port-usd').addClass('active');
        $('#port-uah').removeClass('active');
    });

    /* feed slider */
    if (document.querySelector('.new_feed')) {
        setTimeout(() => new Swiper('.swiper-container', {
            // Optional parameters
            loop: false,
            slidesPerView: 4,
            noSwiping: false,
            // Navigation arrows
            navigation: {
                nextEl: '.new_feed-button.next',
                prevEl: '.new_feed-button.prev',
            },
            breakpoints: {
                480: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 3,
                },
            }
        }), 0)
    }

    const $new_feed_item_title = document.querySelectorAll('.new_feed-item-title')

    if ($new_feed_item_title.length) {
        $new_feed_item_title.forEach($el => {
            if ($el.textContent.length >= 25) {
                $el.textContent = $el.textContent.split('').filter((_, idx) => idx <= 22).join('') + '..'
            }
        })
    }

    const $headerWrap = document.querySelector('.header__wrap')

    const $headerWrap_container = $headerWrap.querySelector('.new_container')

};

