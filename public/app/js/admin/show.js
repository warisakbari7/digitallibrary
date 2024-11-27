// script for makeing status to active/deactive
function toggle(element) {
    let user = $(element).parent('label').data('id');
    let status = (element.checked) ? 1 : 0;
    let token = $('input[name=_token]').val();
    $.post('toggleUser', { id: user, status: status, _token: token }, function(response) {});
}