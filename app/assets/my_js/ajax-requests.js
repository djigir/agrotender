$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.editNews').click(function (event){
    event.preventDefault();
    $('#editNews').css('display', 'block');
    $.ajax({
        url: '/u/print_news',
        method: 'post',
        data: {news_id: $(this).attr('newsid')},
        success: function(data){
            console.log(data);
            $('#contentItems').val(data.content)
            $('#titleItems').val(data.title);
            $('#form-edit').attr('idNews', data.id);
        }
    });
})

$('#save-edit-news').click(function (event){
    event.preventDefault();
    $('#editNews').css('display', 'block');
    $.ajax({
        url: '/u/edit_news',
        method: 'post',
        data: {news_id: $('#form-edit').attr('idNews'), title: $('#titleItems').val(), content: $('#contentItems').val()},
        success: function(data){
            console.log(data);
            $('#contentItems').val(data.content)
            $('#titleItems').val(data.title);
            location.reload();
        }
    });
})

/* delete news */
$(".deleteNews").click(function (event) {
    event.preventDefault();
    $.ajax({
        url: '/u/delete_news',
        method: 'GET',
        // data: {news_id: $(".deleteNews").attr('newsid')},
        data: {news_id: $(this).attr('newsid')},
        success: function (data){
            location.reload();
        }
    })
});



/* show vacancy in modal with old data */
$('.edit-vacancy').click(function (event){
    event.preventDefault();
    $('#editVacancy').css('display', 'block');
    $.ajax({
        url: '/u/print_vacancy',
        method: 'POST',
        data: {vacancyId: $(this).attr('vacancyid')},
        success: function(data){
            console.log(data);
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
        },
        error: function (jqXhr, json, errorThrown){
            var errors = jqXhr.responseJSON;
            var errorsHtml = '';
            $.each(errors['errors'], function (index, value) {
                errorsHtml += '<ul class="list-group"><li class="list-group-item alert alert-danger">' + value + '</li></ul>';
            });
        }
    });
})

/* delete vacancy */
$(".remove-vacancy").click(function (event) {
     event.preventDefault();
     $.ajax({
         url: '/u/delete_vacancy',
         method: 'GET',
         // data: {vacancyId: $(".remove-vacancy").attr('vacancyid')},
         data: {vacancyId: $(this).attr('vacancyid')},
         success: function (data){
             location.reload();
         }
     })
});