$(document).ready(function() {
    $('#catagories').select2({
        placeholder: 'select catagories',
        tags: true
    });

    $('#live').select2({
        placeholder: 'Live in',
    });

    // script for registering librarian
    $('#librarian_form').ajaxForm({
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
            let catagories = $('#catagories').val();
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
            if (catagories == '') {
                $('.catagories_error').text('Select Some Catagory')
                isValidate = false;
            }
            return isValidate;
        },
        beforeSend: function() {},
        complete: function(data) {
            if (data.responseJSON.errors != undefined) {
                $('.email_error').text(data.responseJSON.errors.email[0]);
            } else {
                if (data.responseJSON.msg == "WrongId".toString())
                    $('.catagories_error').text('Please select catagory from Dropdown');
                if (data.responseJSON.msg == "success".toString()) {
                    let options = $('#catagories').val();
                    options.forEach(element => {
                        $('#catagories>option[value=' + element + ']').remove();
                    });
                    $('#librarian_form')[0].reset();
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

        }
    })

    // script for assigning catagory for user
    $('#AssignFrom').submit(e => {
        e.preventDefault();
        let data = $('#AssignList').val()
        let token = $('input[name=_token]').val()
        let id = $('.switch').data('id');
        $.post('assign', { catagory: data, _token: token, id: id }, response => {
            let li = '';
            response.catagory.forEach(element => {

                li += `<div id="${element}" class="border border-top-0 border-left-0 border-right-0">
                <li class="mt-1 mr-2">` + $('#AssignList>option[value=' + element + ']').text() + `</li>
                <input style="margin-top:-15px ; margin-right:40px" class="float-right mb-0" type="checkbox" value="${element}" name="` + $('#AssignList>option[value=' + element + ']').text() + `">
                </div>`

                $('#AssignList>option[value=' + element + ']').remove()
            });
            $('#AssignFrom')[0].reset();
            $('ul>p').remove();
            $('ul#removelist').prepend(li);
        })
    })

    // script for removing catagory from user
    $('#RemoveForm').on('submit', e => {
        e.preventDefault();
        let token = $('input[name=_token]').val();
        var form_data = $('#RemoveForm').serializeArray();
        var option = '';

        if (form_data.length > 0) {
            form_data.forEach(x => {
                option += `<option value="${x.value}">${x.name}</option>`;
            })
            form_data.forEach(x => {
                $('#' + x.value).remove();
            })
            $.post('remove', { data: form_data, _token: token }, response => {
                $('#AssignList').append(option);
                $('#RemoveForm')[0].reset();
            })
        }
    })
    $('#UpdateModal').on('hidden.bs.modal', function() {
        $("#UpdateForm")[0].reset();
    })

    // script for updating librarian
    $('#UpdateForm').ajaxForm({

        beforeSubmit: function validate() {
            $('span.text-danger').text('')
            isValidate = true;
            let image = $('#upic').val().split('.').pop().toLowerCase();
            if (image != '') {
                if ($.inArray(image, ['png', 'jpeg', , 'jpg', ]) != -1) {
                    let size = $('#upic')[0].files[0].size;
                    if (size < 10000 || size > 2000000) {
                        $('.uimage_error').text('Image size should be between 100 kb  - 2 mb')
                        isValidate = false;
                    } else {
                        $('.uimage_error').text('')
                    }
                } else {
                    $('.uimage_error').text('Only jpg, png and jpeg Format is Allowed!');
                    isValidate = false;
                }
            }
            let name = $('#uname').val();
            let lastname = $('#ulastname').val();
            let email = $('#uemail').val();
            let occupation = $('#uoccupation').val();
            let live = $('#ulive').val();
            if (name == '') {
                $('.uname_error').text('Name is required.')
                isValidate = false;
            }
            if (lastname == '') {
                $('.ulastname_error').text('Last Name is required.')
                isValidate = false;
            }
            if (email == '') {
                $('.uemail_error').text('Email is required.')
                isValidate = false;
            }
            if (occupation == '') {
                $('.uoccupation_error').text('Occupation is required.')
                isValidate = false;
            }
            if (live == '') {
                $('.ulive_error').text('Location is required.')
                isValidate = false;
            }
            return isValidate;
        },
        beforeSend: function() {
            $('#update_btn').attr('disabled', true);
            $('#update_btn').text('updating...', );
        },
        complete: function(data) {
            $('tr#' + data.responseJSON.id).empty();
            $('tr#' + data.responseJSON.id).html(data.responseJSON.row);
            $('#UpdateModal').modal('toggle');
            $('#MessageModal').modal('toggle');
            setTimeout(() => {
                $('#MessageModal').modal('toggle');
            }, 2000);

            $('#update_btn').removeAttr('disabled');
            $('#update_btn').text('Update', );
        }
    })

    // script for searching users
    $('#btn_search').click(() => {
        let input = $('#search').val().trim();
        let token = $('input[name=_token').val();
        if (input != '') {
            $.post('librarian/search/', { data: input, _token: token }, response => {
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
    let token = $('input[name=_token]').val();
    $.post('librarian/toggleUser', { id: user, status: status, _token: token }, function(response) {})
}

// script for showing model for updating
function Show(element) {
    let data = $(element).parents('tr').attr('id');
    $.get('librarian/' + data, function(response) {
        $('#uname').val(response.name);
        $('#ulastname').val(response.lastname);
        $('#uemail').val(response.email);
        $('#ulive').val(response.live_in);
        $('#uoccupation').val(response.occupation);
        $('#UpdateForm').attr('action', 'librarian/' + response.id)
        $('#UpdateModal').modal('toggle');
    })
}