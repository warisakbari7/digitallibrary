$(document).ready(function() {
    let bar = $('.bar')
    let percent = $('.percent')

    $('form').ajaxForm({
        beforeSubmit: function() {
            let image = $('input[type=file]').val().split('.').pop().toLowerCase();
            if (image != '') {
                if ($.inArray(image, ['png', 'jpeg', , 'jpg', ]) != -1) {
                    let size = $('#pic')[0].files[0].size;
                    if (size < 10000 || size > 2000000) {
                        $('div.danger').text('Image size should be between 100 kb  - 2 mb')
                        return false
                    } else {
                        $('div.danger').text('')
                        return true;
                    }
                } else {
                    $('div.danger').text('Only jpg, png and jpeg Format is Allowed!');
                    return false;
                }
            } else {
                $('.danger').html('Image is required!');
                return false;
            }
        },
        beforeSend: function() {
            let percentval = '0%';
            bar.width(percentval);
            percent.html(percentval);
        },
        uploadProgress: function(event, position, total, percentcomplete) {
            let percentval = percentcomplete + '%';
            bar.width(percentval);
            percent.html(percentval);
        },
        complete: function(data) {
            $('input[type=file]').val("");
            $('div.success').text('Saved');
            setInterval(() => {
                $('div.success').text('');
                $('.bar').width('0%');
                $('.percent').text('0%')
            }, 7000);
            let d = JSON.parse(data.responseText);
            $('.quotation').prepend(d.row);
            $('.popup').prepend(d.popup);
        }
    })
});

$('#pic').change(function() {
    $('div.success').text('');
    $('div.danger').text('');
    $('.bar').width('0%');
    $('.percent').html('0%');
});

// script for displaying modal for deleting record
function ShowModal(element) {
    $('#DeleteModal').modal('toggle')
    $('#DeleteId').val($(element).attr('id'));
}

// script for submitting delete form 
$('#DeleteForm').submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: 'quotation/1',
        type: 'DELETE',
        data: {
            id: $('#DeleteId').val(),
            _token: $("input[name=_token]").val()
        },
        beforeSend: function() {
            $("#btn_submit").html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>');
        },
        success: function(data) {
            $('#DeleteId').val('')
            $("#btn_submit").html('Delete');
            $('#DeleteModal').modal('toggle');
            $('#MessageModal').modal('toggle');
            $('div.' + data.id).remove();
            $('div#' + data.id).remove();
        }
    })
})