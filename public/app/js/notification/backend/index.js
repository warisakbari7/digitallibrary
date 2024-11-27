$(() => {
    $(document).on('click', '#btn_more', e => {
        let id = $(e.target).data('id');
        $.ajax({
            url: 'notification/more',
            type: 'GET',
            data: {
                id: id
            },
            beforeSend: function() {
                $(e.target).text('Loading...')
            },
            success: data => {
                $('#btn_more_container').remove();
                $('#no_container').append(data.rows);
                $('#no_container').append(data.btn);
            }
        })
    })


    $(document).on('click', '#no_delete', e => {
        let token = $('meta[name=csrf-token]').attr("content");
        let id = $(e.target).data('id');
        $.ajax({
            url: 'notification',
            type: "DELETE",
            data: {
                id: id,
                _token: token
            },
            success: data => {
                $(`div#${data.notification}`).slideUp(function() {
                    $(this).remove();
                });
            }
        })
    })
})