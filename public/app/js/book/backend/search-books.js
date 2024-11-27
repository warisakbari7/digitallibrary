$(document).ready(() => {
    // script for searching users
    $('#btn_search').click(() => {
        let input = $('input#search').val().trim();
        let token = $('input[name=_token').val();
        let approved = $('input#search').attr('name');
        if (input != '') {
            $.get('book-search/', { data: input, _token: token, approved: approved }, response => {
                $("tbody").empty();
                $('tbody').html(response.rows);
                $('ul.pagination').remove();
            }).fail((err) => {})
        } else {
            $('#search').val('');
        }
    })

})