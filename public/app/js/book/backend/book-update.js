$(document).ready(() => {
    let language = $('img#lang').data('language');
    switch (language) {
        case 'dari':
            b_dari()
            break;
        case 'pashto':
            b_pashto()
            break;
        case 'english':
            b_english();
            break;
        default:
            break;
    }






    // script for approving book
    $('button#approve').click(() => {
        let id = $("img#lang").data("id");
        let token = $("input[name=_token]").val();
        $.ajax({
            url: 'approve-book',
            type: 'PATCH',
            data: {
                id: id,
                _token: token
            },
            success: result => {
                let url = $('#back').parent('a').attr('href');
                if (result.msg == 'success') {
                    window.location.assign(url);
                }
            }
        });
    })
})



function b_dari() {


    $('.b_exist_error').text('این کتاب از قبل موجود است');

    $('#bookform').find("input").css('text-align', 'right');
    $('#bookform').find("textarea").css('text-align', 'right');

    $('#bookmodal').addClass('rtl').css('text-align', 'right');
    $('#lbl_b_name').text('نام کتاب')
    $('#b_name').attr('placeholder', 'نام کتاب');
    $('#lbl_b_author').text('نویسنده')
    $('#b_author').attr('placeholder', 'نام نویسنده')
    $('#lbl_b_page').text('تعداد صفحات و فصل')
    $('#lbl_b_pages').text('صفحه')
    $('#lbl_b_chapter').text('فصل')
    $('#lbl_b_edition').text('چاپ')
    $('#lbl_b_publish').text('تاریخ نشر')
    $('#lbl_b_aboutauthor').text('درباره نویسنده');
    $('#b_aboutauthor').attr("placeholder", 'خلص زندگی نامه در ۱۰۰۰ حرف')
    $('#lbl_b_aboutbook').text('درباره کتاب');
    $('#b_aboutbook').attr('placeholder', 'درباره کتاب در ۱۰۰۰ حرف')
    $('#lbl_b_catagory').text('بخش')
    $('#b_lbl_finish').text('ثبت')
    $('#lbl_b_publish').text('تاریخ نشر')


    $('.b_name').text('').removeClass('text-danger');
    $('.b_author').text('').removeClass('text-danger');

}



function b_english() {
    $('.b_exist_error').text('This Book has already been registered');


    $('#bookform').find("input").css('text-align', 'left');
    $('#bookform').find("textarea").css('text-align', 'left');

    $('#bookmodal').removeClass('rtl').css('text-align', 'left');
    $('#lbl_b_name').text(' Book Name')
    $('#b_name').attr('placeholder', 'Book Full Name');
    $('#lbl_b_author').text('Author')
    $('#b_author').attr('placeholder', 'Author Full Name')
    $('#lbl_b_page').text('Number of Pages and Chapters')
    $('#lbl_b_pages').text('Pages')
    $('#lbl_b_chapter').text('Chapters')
    $('#lbl_b_edition').text('Edition')
    $('#lbl_b_publish').text(' Year of Publish')
    $('#lbl_b_aboutauthor').text('About Author');
    $('#b_aboutauthor').attr("placeholder", 'short biography in 1000 character')
    $('#lbl_b_aboutbook').text('About Book');
    $('#b_aboutbook').attr('placeholder', 'explain book briefly in 1000 character')
    $('#b_lbl_finish').text('Register')
    $('#lbl_b_publish').text('Year of publish')

    $('.b_name').text('').removeClass('text-danger');
    $('.b_author').text('').removeClass('text-danger');


}



function b_pashto() {



    $('.b_exist_error').text('دا کتاب مخکی نه ثبت شوی ده');

    $('#bookform').find("input").css('text-align', 'right');
    $('#bookform').find("textarea").css('text-align', 'right');
    $('#bookmodal').addClass('rtl').css('text-align', 'right');
    $('#lbl_language').text('‌‌ژبه')
    $('#lbl_b_name').text('کتاب نوم')
    $('#b_name').attr('placeholder', ' کتاب نوم');
    $('#lbl_b_author').text('لیکوال')
    $('#b_author').attr('placeholder', 'لیکوال نوم')
    $('#lbl_b_page').text('Number of Pages and Chapters')
    $('#lbl_b_pages').text('پانه')
    $('#lbl_b_chapter').text('Chapters')
    $('#lbl_b_edition').text('چاپ')
    $('#lbl_b_publish').text(' Year of Publish')
    $('#lbl_b_aboutauthor').text('دلیکوال په اړه');
    $('#b_aboutauthor').attr("placeholder", 'short biography in 1000 character')
    $('#lbl_b_aboutbook').text('دکتاب په اړه');
    $('#b_aboutbook').attr('placeholder', 'explain book briefly in 1000 character')
    $('#b_lbl_finish').text('ثبت')
    $('#lbl_b_publish').text('دنشر نیټه')


    $('.b_name').text('').removeClass('text-danger');
    $('.b_author').text('').removeClass('text-danger');
}




$('textarea#b_aboutbook').on('input', e => {
    $('#bookcounter').text(e.target.value.length)
})

$('textarea#b_aboutauthor').on('input', e => {
    $('#authorcounter').text(e.target.value.length)
})




// script for adding book

$('#bookform').ajaxForm({
    beforeSubmit: validate,
    beforeSend: function() {
        $("#b_lbl_finish").html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>')
    },

    uploadProgress: function(event, position, total, percentcomplete) {},
    complete: function(result) {
        date = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        d = new Date(result.responseJSON.book.publish_date);
        $('#bookform')[0].reset()
        $('#bookcounter').text('0');
        $('#authorcounter').text('0');
        $("#b_lbl_finish").text('Register')
        $('#bookmodal').modal('hide');
        $("#title").text(result.responseJSON.book.title);
        $("#publish").text((d.getDate() + 1) + ' ' + date[d.getMonth()] + ' ' + d.getFullYear());
        $("#author").text(result.responseJSON.book.author);
        $("#pages").text(result.responseJSON.book.pages + ' Pages, ' + result.responseJSON.book.chapter + ' Chapters');
        $('textarea#b_aboutauthor').val(result.responseJSON.book.about_author);
        $('textarea#b_aboutbook').val(result.responseJSON.book.about_book);
        $('#b_author').val(result.responseJSON.book.author);
        $('#b_name').val(result.responseJSON.book.title)
        $('#b_page').val(result.responseJSON.book.pages);
        $('#b_chapter').val(result.responseJSON.book.chapter);
        $('#b_publish').val(result.responseJSON.book.publish_date);
        $('#b_aboutbook_container').remove();
        $('#b_aboutauthor_container').remove();
        if (result.responseJSON.book.about_author != '') {
            if ($('span#lang').data('language') == 'english') {
                let element = `  <div id="b_aboutauthor_container" class="pl-1 ">
                <hr>
                <h4 class="An_Dm_bold">About Author</h4>
                <small><p class="text-break">${ result.responseJSON.book.about_author }</p></small>
                </div>
                `;
                $('#book_container').append(element);
            } else if ($('span#lang').data('language') == 'dari') {
                let element = `  <div id="b_aboutauthor_container" class="pl-1 text-right">
                <hr>
                <h4 class="An_Dm_bold">درباره نویسنده</h4>
                <small><p class="text-break">${ result.responseJSON.book.about_author }</p></small>
                </div>
                `;
                $('#book_container').append(element);
            } else {
                let element = `  <div id="b_aboutauthor_container" class="pl-1 text-right">
                <hr>
                <h4 class="An_Dm_bold">دلیکوال لپاره</h4>
                <small><p class="text-break">${ result.responseJSON.book.about_author }</p></small>
                </div>
                `;
                $('#book_container').append(element);
            }
        } else {
            $('#b_aboutauthor_container').remove();
        }


        if (result.responseJSON.book.about_book != '') {
            if ($('span#lang').data('language') == 'english') {
                let element = `
                <div id="b_aboutbook_container" class="pl-1 mt-5">
                <hr>
                <h4 class="An_Dm_bold">About Book</h4>
                <small><p class="text-break">${ result.responseJSON.book.about_book }</p></small>
                </div>
                `;
                $('#book_container').append(element);
            } else if ($('span#lang').data('language') == 'dari') {
                let element = `
                <div id="b_aboutbook_container" class="pl-1 mt-5 text-right">
                <hr>
                <h4 class="An_Dm_bold">درباره کتاب </h4>
                <small><p class="text-break">${ result.responseJSON.book.about_book }</p></small>
                </div>
                `;
                $('#book_container').append(element);
            } else {
                let element = `
                <div id="b_aboutbook_container" class="pl-1 mt-5 text-right">
                <hr>
                <h4 class="An_Dm_bold">دکتاب په اړه </h4>
                <small><p class="text-break">${ result.responseJSON.book.about_book }</p></small>
                </div>
                `;
                $('#book_container').append(element);
            }
        } else {
            $('#b_aboutbook_container').remove();
        }
    },
})




// script for validating form 
function validate() {
    var isValid = true;
    var language = $('img#lang').data('language');
    if ($('#b_name').val() == '') {
        isValid = false;

        if (language == 'english')
            $('.b_name').text('Book name is required.').addClass('text-danger');
        else if (language == 'dari')
            $('.b_name').text('نام کتاب ضروری است.').addClass('text-danger');
        else
            $('.b_name').text('کتاب نوم ضروری ده.').addClass('text-danger');
    } else {
        $('.b_name').text('')
    }

    if ($('#b_author').val() == '') {
        isValid = false;
        if (language == 'english')
            $('.b_author').text('Author name is required.').addClass('text-danger');
        else if (language == 'dari')
            $('.b_author').text('نام نویسنده ضروری است.').addClass('text-danger');
        else
            $('.b_author').text('لیکوال نوم ضروری ده.').addClass('text-danger');

    } else {
        $('.b_author').text('')
    }

    if (isValid) {
        isValid = check();
    }
    return isValid;
}



// function for checking whehter book already exist or no
function check() {

    let name = $('#b_name').val();
    let author = $('#b_author').val();
    let edition = $('#b_edition').val();
    let token = $('input[name=_token]').val();
    var temp = true;
    $.ajax({
        url: $('img#lang').data("id"),
        type: 'PUT',
        data: { b_name: name, b_author: author, b_edition: edition, _token: token, validate: true },
        async: false,
        success: (result) => {
            if (result.msg == 'failed') {
                temp = false;
                $('.b_exist_error').removeClass('invisible');
            } else {
                temp = true;
                $('.b_exist_error').addClass('invisible');
            }
        }
    });
    return temp;
}