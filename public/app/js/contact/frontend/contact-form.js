$(() => {
    $(document).on('submit', '#ContactForm', e => {
        e.preventDefault();
        let fullname = $('#FullName').val().trim();
        let email = $("#Email").val().trim();
        let phone = $('#Phone').val().trim();
        let message = $('#Message').val().trim();
        let _token = $('input[name=_token]').val();

        $.ajax({
            url: 'contact-store',
            type: 'POST',
            data: { fullname, email, phone, message, _token },
            beforeSend: () => {
                $('#submitbtn').text('Sending...').attr('disabled', true);
            },
            success: result => {
                $('#ContactForm')[0].reset();
                if (result.msg == 'success') {
                    $('#submitbtn').html(`Send message <i class="fa fa-angle-right  pl-2 "></i> `).removeAttr('disabled');
                    $('#sentmsg').removeClass('invisible');
                    setTimeout(() => {
                        $('#sentmsg').addClass('invisible');
                    }, 3000);
                }
            }
        });

    })
})