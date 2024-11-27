$(document).ready(() => {
    $('#downloadbtn').click(() => {
        $id = $('#lang').data('id')
        $.ajax({
            url: 'download_article/' + $id,
            type: 'GET',
        });
    })
    $('#readbtn').click(() => {
        $id = $('#lang').data('id')
        $.ajax({
            url: 'download_article/' + $id,
            type: 'GET',
        });
    })

    $(document).on('contextmenu', 'html', () => {
        return false;
    })

    // script for saving article
    $(document).on("click", "#save_btn", e => {
        e.preventDefault();
        let article = $("#lang").data("id");
        let _token = $('meta[name=csrf-token]').attr('content')
        $.post(`save_article/${article}`, { id: article, _token }, result => {
            let text = $(e.target).text()
            if (text == 'Save') {
                $(e.target).text('Unsave')
                $(e.target).removeClass('bg--two')
                $(e.target).addClass('bg-success')
            } else {
                text = $(e.target).text('Save')
                $(e.target).addClass('bg--two')
                $(e.target).removeClass('bg-success')
            }
        })
    })
})