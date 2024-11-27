$(document).ready(function() {
    $('#catagories').select2({
        placeholder: 'select catagories',
        tags: true
    });




    // script for searching users
    $('#btn_search').click(() => {
        let input = $('#search').val().trim();
        let token = $('meta[name=csrf-token').attr('content');
        if (input != '') {
            $.post('users/search/', { data: input, _token: token }, response => {
                $("tbody").empty();
                $('tbody').html(response.rows);
                $('ul.pagination').remove();
            })
        } else {
            $('#search').val('');
        }
    })
});

// script for makeing status to active/deactive
function toggle(element) {
    let user = $(element).parent('label').attr('id');
    let status = (element.checked) ? 1 : 0;
    let token = $('meta[name=csrf-token]').attr("content");
    $.post('toggleUser', { id: user, status: status, _token: token }, function(response) {})
}