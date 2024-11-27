$(document).ready(() => {
    // script for searching users
    $('#btn_search').click(() => {
        let input = $('input#search').val().trim();
        let token = $('input[name=_token').val();
        let approved = $('input#search').attr('name');
        if (input != '') {
            $.get('article-search/', { data: input, _token: token, approved: approved }, response => {
                $("tbody").empty();
                $('tbody').html(response.rows);
                numbering()
                $('ul.pagination').remove();
            })
        } else {
            $('#search').val('');
        }
    })

})


function numbering() {
    let tr = $('tbody>tr');
    $.each(tr, (index, element) => {
        $(element).children('td').first().text(index + 1)
    })
}