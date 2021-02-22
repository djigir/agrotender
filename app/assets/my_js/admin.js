window.onload = function (){
    /* email компаний  */
    $('.export-btn').click(function (e){
        // e.preventDefault();

        let obl_filter = $('.obl_filter').val();
        let section_filter = $('.section_filter').val();
        let email_filter = $('.email_filter').val();
        let phone_filter = $('.phone_filter').val();
        let name_filter = $('.name_filter').val();
        let id_filter = $('.id_filter').val();
        let ip_filter = $('.ip_filter').val();

        /* данные для фильтра */
        $('.export-input_obl').val(obl_filter);
        $('.export-input_section').val(section_filter);
        $('.export-input_email_filter').val(email_filter);
        $('.export-input_phone_filter').val(phone_filter);
        $('.export-input_name_filter').val(name_filter);
        $('.export-input_id_filter').val(id_filter);
        $('.export-input_ip_filter').val(ip_filter);

    })

    let str = window.location.pathname;

    let img_input = $('.logo-img').find('img');
    let src = img_input.attr('src');
        let src_to_database = '';
    /* ссылка чтобы открыть изображение на весь экран */
    let link = $('.form-element-files__image');

    if(str.indexOf('news') !== -1){
        let for_preview = img_input.attr('src', src.replace(window.location.host, window.location.host + '/files'))
        let link_for_preload = link.attr('href', src.replace(window.location.host, window.location.host + '/files'))
    }

    if(str.indexOf('banner_rotates') !== -1){
        let for_preview = img_input.attr('src', src.replace(window.location.host, window.location.host + '/files'))
        let link_for_preload = link.attr('href', src.replace(window.location.host, window.location.host + '/files'))
    }

    if(str.indexOf('faq_groups') !== -1 && str.indexOf('edit') !== -1){
        let for_preview = img_input.attr('src', src.replace(window.location.host, window.location.host + '/files'))
        let link_for_preload = link.attr('href', src.replace(window.location.origin, window.location.origin + '/files'))
    }

    if(str.indexOf('edit') !== -1 &&  (str.indexOf('comp_items_traders') !== -1 || str.indexOf('comp_items') !== -1)){
        $('.multiselect__input').attr("placeholder", "");
        $('.multiselect__option').attr("data-select", "");
        $('.multiselect__option').attr("data-selected", "");
        $('.multiselect__option').attr("data-deselect", "");
    }


    if(str.indexOf('edit') !== -1 && (str.indexOf('comp_items_traders') !== -1 || str.indexOf('comp_items') !== -1 || str.indexOf('faq_groups') !== -1 || str.indexOf('banner_rotates') !== -1)){
       $('.form-element-files__item').css({'width':'200px'});
       $('a.form-element-files__image').css({'height':'65%', 'padding-top':'25px'});
    }

    if(str.indexOf('edit') !== -1 && str.indexOf('news') !== -1){
        $('.form-element-files__item').css({'width':'200px'});
        $('a.form-element-files__image').css({'padding-top':'25px'});
    }

    if(str.indexOf('edit') !== -1 && str.indexOf('adv_torg_posts') !== -1){
        $('button').css('display', 'none');
        $('.form-element-files__item').css({'min-width':'200px'});
        $('a.form-element-files__image').css({'height':'100px'});
    }


    /* Для блока с событиями */
    setTimeout(function() {
        $('#actionTR').show();
    }, 250);

    if(str.indexOf('torg_elevators' !== -1)){
        $('#DataTables_Table_0_filter').css({
            'opacity':'0.8',
            'position': 'absolute',
            'top': '-9999px',
            'left': '-9999px'
        });

        $(document).on('input', '#search', function () {
            $('.input-sm').val($('#search').val())
            $(".input-sm").focus();

            setTimeout(function () {
                $('#search').focus();
            }, 100);
        });
    }
}