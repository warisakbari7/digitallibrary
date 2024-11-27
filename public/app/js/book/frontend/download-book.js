$(document).ready(() => {
    $('#downloadbtn').click(() => {
        $id = $('img#lang').data('id')
        $.ajax({
            url: 'download_book/' + $id,
            type: 'GET',
        });
    })


    $(document).on('contextmenu', 'html', () => {
        return false;
    })


    // script for saving book
    $(document).on("click", "#save_btn", e => {
        e.preventDefault();
        let book = $("#lang").data("id");
        let _token = $('meta[name=csrf-token]').attr('content')
        $.post(`save_book/${book}`, { id: book, _token }, result => {
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