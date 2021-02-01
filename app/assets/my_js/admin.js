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

    setTimeout(function() {
        $('#actionTR').show();
    }, 500);
}


