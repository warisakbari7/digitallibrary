$(document).ready(() => {

    // script for searching users
    $('#btn_search').click(() => {
        let input = $('input#search').val().trim();
        let token = $('input[name=_token').val();
        let id = $('#img').data('id');
        if (input != '') {
            $.get('article-search/', { data: input, _token: token, approved: 'yes', id }, response => {
                $("tbody").empty();
                $('tbody').html(response.rows);
                $('ul.pagination').remove();
            });
        } else {
            $('#search').val('');
        }
    })

})