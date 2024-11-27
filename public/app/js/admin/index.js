$(document).ready(function() {

    $('#live').select2({
        placeholder: 'Live in',
    });

    // script for registering librarian
    $('#admin_form').ajaxForm({
        beforeSubmit: function validate() {
            $('span.text-danger').text('')
            isValidate = true;
            let image = $('#pic').val().split('.').pop().toLowerCase();
            if (image != '') {
                if ($.inArray(image, ['png', 'jpeg', , 'jpg', ]) != -1) {
                    let size = $('#pic')[0].files[0].size;
                    if (size < 10000 || size > 2000000) {
                        $('.image_error').text('Image size should be between 100 kb  - 2 mb')
                        isValidate = false;
                    } else {
                        $('.image_error').text('')
                    }
                } else {
                    $('.image_error').text('Only jpg, png and jpeg Format is Allowed!');
                    isValidate = false;
                }
            } else {
                $('.image_error').html('Image is required!');
                isValidate = false;
            }
            let name = $('input#name').val();
            let lastname = $('input#lastname').val();
            let password = $('input#password').val();
            let email = $('input#email').val();
            let occupation = $('input#occupation').val();
            let live = $('#live').val();
            let phone = $('#phone').val();
            let confirm = $('input#password_confirmation').val();
            if (name == '') {
                $('.name_error').text('Name is required.')
                isValidate = false;
            }
            if (lastname == '') {
                $('.lastname_error').text('Last Name is required.')
                isValidate = false;
            }
            if (password == '') {
                $('.password_error').text('Password is required.')
            } else {
                if (password.length < 8) {
                    $('.password_error').text('Password must be atleast 8 characters')
                } else if (password != confirm) {
                    $('.password_error').text('Password Did Not Matched!')
                    $('.password_confirmation_error').text('Password Did Not Matched!')
                    isValidate = false;
                }
            }
            if (email == '') {
                $('.email_error').text('Email is required.')
                isValidate = false;
            }
            if (occupation == '') {
                $('.occupation_error').text('Occupation is required.')
                isValidate = false;
            }
            if (live == '') {
                $('.live_error').text('Location is required.')
                isValidate = false;
            }
            if (phone == '') {
                $('.phone_error').text('Select enter phone number')
                isValidate = false;
            }
            return isValidate;
        },
        beforeSend: function() {},
        complete: function(data) {
            if (data.responseJSON.errors != undefined) {
                $('.email_error').text(data.responseJSON.errors.email[0]);
            } else {
                $('#admin_form')[0].reset();
                $('tbody').prepend(data.responseJSON.row);
                $(".toast-success").css('display', 'inline')
                setTimeout(() => {
                    $(".toast-success").css('right', '20px')

                }, 100);
                setTimeout(() => {
                    $(".toast-success").css('right', '-350px')
                    setTimeout(() => {
                        $('.toast-success').css('display', 'none')
                    }, 1400);
                }, 3000);
            }
        }

    })
})




// script for searching users
$('#btn_search').click(() => {
    let input = $('#search').val().trim();
    let token = $('input[name=_token').val();
    if (input != '') {
        $.post('admin/search/', { data: input, _token: token }, response => {
            $("tbody").empty();
            $('tbody').html(response.rows);
            $('ul.pagination').remove();
        })
    } else {
        $('#search').val('');
    }

});

// script for makeing status to active/deactive
function toggle(element) {
    let user = $(element).parent('label').attr('id');
    let status = (element.checked) ? 1 : 0;
    let token = $('input[name=_token]').val();
    $.post('admin/toggleUser', { id: user, status: status, _token: token }, function(response) {});
}