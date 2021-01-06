window.onload = function (){
    /* email компаний  */
    $('.export-btn').click(function (e){
        // e.preventDefault();

        let obl_filter = $('.obl_filter').val();
        let section_filter = $('.section_filter').val();
        /* данные для фильтра */
        $('.export-input_obl').val(obl_filter)
        $('.export-input_section').val(section_filter)

    })

}


