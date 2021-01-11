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

}


