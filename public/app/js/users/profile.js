$(document).ready(() => {

    $('#btnmodal').click(() => {
        $('#updateform')[0].reset();
        $('#modelprofile').modal('show');
    })
    $("#modelprofile").on('show.bs.modal', function() {
        let name = $('b#liname').text();
        let lastname = $('b#lilastname').text();
        let phone = $('b#liphone').text();
        let live = $('b#lilive').text();
        let occupation = $('b#lioccupation').text();

        $('#name').val(name);
        $('#lastname').val(lastname);
        $('#phone').val(phone);
        $('#occupation').val(occupation);
        $('#live').val(live);
    })


    $(document).on('click', 'a.category-item', e => {
        $('a.category-item').removeClass('bg--two').removeClass('text-white');
        $('a.category-item').addClass('text--seven')

        if (e.target.localName == 'a') {
            alert('if')
            $(e.target).addClass('bg--two').addClass('text-white')
        } else {
            $(e.target).parents('a').first().addClass('bg--two').addClass('text-white')
        }
    })


    $('#updateform').submit(e => {
        e.preventDefault();
        $.ajax({
            url: e.target.action,
            type: 'PUT',
            data: {
                name: $('#name').val(),
                lastname: $('#lastname').val(),
                phone: $('#phone').val(),
                occupation: $('#occupation').val(),
                live: $('#live').val(),
                _token: $('input[name=_token]').val(),
            },
            beforeSend: () => {},
            success: response => {
                $('#updateform')[0].reset();
                $('b#liname').text(response.name);
                $('b#liphone').text(response.phone);
                $('b#lilastname').text(response.lastname);
                $('b#lioccupation').text(response.occupation);
                $('b#lilive').text(response.live)
                $('#modelprofile').modal('toggle');
            }
        })
    })

    // script for updating profile picture
    $("input#profilepic").change(function(d) {
        if (d.target.files[0] != undefined) {
            $('form#profilepicform').submit();
        }
    })
    $('form#profilepicform').ajaxForm({
        complete: response => {
            let src = $('#profileimg').attr('src').split('/');
            src[src.length - 1] = response.responseJSON
            let v = ''
            for (x in src) {
                if (x == (src.length - 1))
                    v += src[x];
                else
                    v += src[x] + '/';
            }
            $('#profileimg').attr('src', v)
        }
    })


    $('#userform').submit(e => {
        e.preventDefault();
        $.ajax({
            url: $('#userform').attr('action'),
            type: 'PUT',
            data: $('#userform').serializeArray(),
            beforeSend: function() {
                $('#changebtn').attr('disabled', true).text('changing...');
            },
            success: result => {
                let errors = '';
                if (result.errors != undefined) {
                    $.each(result.errors, (x, y) => {
                        errors += `<p>${y}</p>`;
                    })
                    $('#errormsg').removeClass('invisible').html(errors);
                    $('#changebtn').removeAttr('disabled').text('change');
                } else if (result.msg != undefined) {
                    errors = `<p>${result.msg}</p>`;
                    $('#errormsg').removeClass('invisible').html(errors);
                    $('#changebtn').removeAttr('disabled').text('change');

                } else {
                    $('#errormsg').addClass('invisible').html(errors = '');
                    $('#changebtn').removeAttr('disabled').text('change');
                    $('#userform')[0].reset();
                    $('#usermodal').modal('hide');
                    $('#msgmodal').modal('show');

                }
            }
        })
    })

    $('#usermodal').on('hidden.bs.modal', function() {
        $('#errormsg').addClass('invisible').html(errors = '');
        $('#changebtn').removeAttr('disabled').text('change');
        $('#userform')[0].reset();
        $('#usermodal').modal('hide');
    })

    $('.saved-book').click(e => {
        let book = $(e.target).data('id');
        let token = $('meta[name=csrf-token]').attr('content');
        $.ajax({
            url: `save_book/${book}`,
            type: 'POST',
            data: {
                _token: token
            },
            beforeSend: function() {
                $(e.target).off('click');
                $(e.target).attr('disabled', true);
            },
            success: result => {
                $(`#sb_${result.id}`).remove();
            }
        });
    })
})