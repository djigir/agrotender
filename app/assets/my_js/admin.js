window.onload = function (){
    /* email компаний  */
    // $('.export-btn').click(function (e){
    //
    //     let obl_id = $('.obl_filter').val()
    //
    //     let section_id = $('.section_filter').val()
    //
    //     // let link = $('.export-btn').attr('href');
    //
    //     let link = $('.export-input').val('ssasadasd');
    //
    //     // let new_link = link+`?[obl_id]=${obl_id}[section_id]=${section_id}`;
    //
    //     // let export_btn = $('.export-btn').attr('href', new_link);
    //
    // })

    $(".export-btn").click(function (event) {
        $.ajax({
            url: '/admin_dev/download_company_emails',
            method: 'GET',
            data: {obl_id: $('.obl_filter').val(), section_id: $('.section_filter').val()},
            success: function (data){
                window.location.href = ['/admin_dev/download_company_emails', {params : data.obl_id}]
            }
        })
    });

}


