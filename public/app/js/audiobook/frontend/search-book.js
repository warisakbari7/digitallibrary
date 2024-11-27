$(() => {
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