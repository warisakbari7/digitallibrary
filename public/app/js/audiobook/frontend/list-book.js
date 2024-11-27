$(() => {
    $(document).on('click', '.pagination a', (e) => {
        e.preventDefault();
        page = $(e.target).attr('href').split('page=')[1];
        $.get(window.location.href + `?page=${page}`).done(result => {
            $('#BookContainer').html(result);
            window.scrollTo(0, 0)
        })
    })

    $('#SearchForm').submit(e => {
        let value = $('#q').val().trim();
        if (value == '') {
            $('#q').val('');
            e.preventDefault();
        } else {
            $('#q').val(value);
        }
    })
})