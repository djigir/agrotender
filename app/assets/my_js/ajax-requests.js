$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

/* NEWS */

$('.editNews').click(function (event){
    event.preventDefault();
    $('#editNews').css('display', 'block');
    $.ajax({
        url: '/u/print_news',
        method: 'POST',
        data: {news_id: $(this).attr('newsid')},
        success: function(data){
            $('#contentItems').val(data.content)
            $('#titleItems').val(data.title);
            $('#form-edit').attr('idNews', data.id);
            $('.id_news_form_edit').val(data.id);
            if(data.pic_src === ''){
                $('#logo_edit').attr('src', '/app/assets/img/nophoto.png');
            }else {
                $('#logo_edit').attr('src', data.pic_src);
            }
        }
    });
})



/*$('#save-edit-news').click(function (event){
    event.preventDefault();
    $.ajax({
        url: '/u/edit_news',
        method: 'POST',
        enctype: 'multipart/form-data',
        data: {news_id: $('#form-edit').attr('idNews'), title: $('#titleItems').val(),
            content: $('#contentItems').val(), src:($(".logo").attr('src')),
            file: $('#logo_edit_input').prop('value')},
        success: function(data){
            console.log(data);
            $('#contentItems').val(data.content);
            $('#titleItems').val(data.title);
            // $('.logo').attr('src', data.src);
            // location.reload();
        }
    });
})*/



$(document).on('submit', '.edit-news-form', function (event){
    event.preventDefault();
    $.ajax({
        url: '/u/edit_news',
        method: 'POST',
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data, status)
        {
            location.reload();
        },
        error: function (xhr, desc, err)
        {
            $('.alert-for-ajax').css('display', 'block');
            $('#alert-message').append((xhr.responseJSON.errors.title) ?? xhr.responseJSON.errors.content);
            setTimeout(function(){ $('.alert-for-ajax').hide(); }, 9000);
        }
    })
});

/* delete news */
$(".deleteNews").click(function (event) {
    event.preventDefault();
    $.ajax({
        url: '/u/delete_news',
        method: 'GET',
        data: {news_id: $(this).attr('newsid')},
        success: function (data){
            location.reload();
        }
    })
});

/*  VACANCY */

/* show vacancy in modal with old data */
$('.edit-vacancy').click(function (event){
    event.preventDefault();
    $('#editVacancy').css('display', 'block');
    $.ajax({
        url: '/u/print_vacancy',
        method: 'POST',
        data: {vacancyId: $(this).attr('vacancyid')},
        success: function(data){
            $('#contentItems').val(data.content)
            $('#titleItems').val(data.title);
            $('#form-edit').attr('idVacancy', data.id);
        }
    });
})

/* update vacancy */
$('#save-edit-vacancy').click(function (event){
    event.preventDefault();
    $('#editVacancy').css('display', 'block');
    $.ajax({
        url: '/u/edit_vacancy',
        method: 'GET',
        data: {vacancyId: $('#form-edit').attr('idVacancy'), title: $('#titleItems').val(), content: $('#contentItems').val()},
        success: function(data){
            let title = $('#contentItems').val(data.content)
            let content = $('#titleItems').val(data.title);
            location.reload();
            let id_editor_vacancy = $('.form-edit-vacancy').attr('idVacancy');
        },
        error: function (xhr, desc, err)
        {
            console.log(xhr.responseJSON.errors);
            $('.alert-for-ajax').css('display', 'block');
            $('#alert-message').append((xhr.responseJSON.errors.title ?? xhr.responseJSON.errors.content));
        }
    });
})



/* delete vacancy */
$(".remove-vacancy").click(function (event) {
     event.preventDefault();
     $.ajax({
         url: '/u/delete_vacancy',
         method: 'GET',
         data: {vacancyId: $(this).attr('vacancyid')},
         success: function (data){
             location.reload();
         }
     })
});

/* show preview img for news forms */

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e){
            $('#logo_edit, #add-news-prev').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#logo_edit_input, #input-add-news").change(function () {
    readURL(this);
});
