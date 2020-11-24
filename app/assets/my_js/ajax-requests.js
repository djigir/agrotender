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
        }
    });
})

// vacancy
/*$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});*/

$('.edit-vacancy').click(function (event){
    event.preventDefault();
    $('#editVacancy').css('display', 'block');
    $.ajax({
        url: '/u/vacancy',
        method: 'get',
        data: {news_id: $(this).attr('vacancyid')},
        success: function(data){
            console.log(data);
            $('#contentItems').val(data.content)
            $('#titleItems').val(data.title);
            $('#form-edit').attr('idVacancy', data.id);
        }
    });
})

/*
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
        }
    });
})*/
