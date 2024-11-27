$(document).ready(() => {
    let language = $('span#lang').data('language');
    switch (language) {
        case 'dari':
            a_dari()
            break;
        case 'pashto':
            a_pashto()
            break;
        case 'english':
            a_english();
            break;
        default:
            break;
    }


    // script for viewing of article
    $('#readbtn').click(() => {
        let id = $('span#lang').data('id');
        let token = $('input[name=_token]').val();
        $.ajax({
            url: 'view_article',
            type: 'post',
            data: {
                id: id,
                _token: token
            }
        });
    })



    // script for downloading of article
    $('#downloadbtn').click(() => {
        let id = $('span#lang').data('id');
        let token = $('input[name=_token]').val();
        $.ajax({
            url: 'view_article',
            type: 'post',
            data: {
                id: id,
                _token: token
            }
        });
    })

    // script for approving article
    $('button#approve').click(() => {
        let id = $("span#lang").data("id");
        let token = $("input[name=_token]").val();
        $.ajax({
            url: 'approve-article',
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



function a_dari() {


    $('.a_exist_error').text('این مقاله از قبل موجود است');

    $('#articleform').find("input").css('text-align', 'right');
    $('#articleform').find("textarea").css('text-align', 'right');

    $('#articlemodal').addClass('rtl').css('text-align', 'right');
    $('#lbl_a_name').text('نام مقاله')
    $('#a_name').attr('placeholder', 'نام مقاله');
    $('#lbl_a_author').text('نویسنده')
    $('#a_author').attr('placeholder', 'نام نویسنده')
    $('#lbl_a_page').text('تعداد صفحات و فصل')
    $('#lbl_a_pages').text('صفحه')
    $('#lbl_a_chapter').text('فصل')
    $('#lbl_a_publish').text('تاریخ نشر')
    $('#lbl_a_aboutauthor').text('درباره نویسنده');
    $('#a_aboutauthor').attr("placeholder", 'خلص زندگی نامه در ۱۰۰۰ حرف')
    $('#lbl_a_aboutarticle').text('درباره مقاله');
    $('#a_aboutarticle').attr('placeholder', 'درباره مقاله در ۱۰۰۰ حرف')
    $('#lbl_a_catagory').text('بخش')
    $('#a_lbl_finish').text('ثبت')
    $('#lbl_a_publish').text('تاریخ نشر')


    $('.a_name').text('').removeClass('text-danger');
    $('.a_author').text('').removeClass('text-danger');

}



function a_english() {
    $('.a_exist_error').text('This Article has already been registered');


    $('#articleform').find("input").css('text-align', 'left');
    $('#articleform').find("textarea").css('text-align', 'left');

    $('#articlemodal').removeClass('rtl').css('text-align', 'left');
    $('#lbl_a_name').text(' Article Name')
    $('#a_name').attr('placeholder', 'Article Full Name');
    $('#lbl_a_author').text('Author')
    $('#a_author').attr('placeholder', 'Author Full Name')
    $('#lbl_a_page').text('Number of Pages and Chapters')
    $('#lbl_a_pages').text('Pages')
    $('#lbl_a_chapter').text('Chapters')
    $('#lbl_a_publish').text(' Year of Publish')
    $('#lbl_a_aboutauthor').text('About Author');
    $('#a_aboutauthor').attr("placeholder", 'short biography in 1000 character')
    $('#lbl_a_aboutarticle').text('About Article');
    $('#a_aboutarticle').attr('placeholder', 'explain article briefly in 1000 character')
    $('#a_lbl_finish').text('Register')
    $('#lbl_a_publish').text('Year of publish')

    $('.a_name').text('').removeClass('text-danger');
    $('.a_author').text('').removeClass('text-danger');


}



function a_pashto() {



    $('.a_exist_error').text('دا مقاله مخکی نه ثبت شوی ده');

    $('#articleform').find("input").css('text-align', 'right');
    $('#articleform').find("textarea").css('text-align', 'right');
    $('#articlemodal').addClass('rtl').css('text-align', 'right');
    $('#lbl_language').text('‌‌ژبه')
    $('#lbl_a_name').text('مقاله نوم')
    $('#a_name').attr('placeholder', ' مقاله نوم');
    $('#lbl_a_author').text('لیکوال')
    $('#a_author').attr('placeholder', 'لیکوال نوم')
    $('#lbl_a_page').text('Number of Pages and Chapters')
    $('#lbl_a_pages').text('پانه')
    $('#lbl_a_chapter').text('Chapters')
    $('#lbl_a_publish').text(' Year of Publish')
    $('#lbl_a_aboutauthor').text('دلیکوال په اړه');
    $('#a_aboutauthor').attr("placeholder", 'short biography in 1000 character')
    $('#lbl_a_aboutarticle').text('دمقاله په اړه');
    $('#a_aboutarticle').attr('placeholder', 'explain article briefly in 1000 character')
    $('#a_lbl_finish').text('ثبت')
    $('#lbl_a_publish').text('دنشر نیټه')


    $('.a_name').text('').removeClass('text-danger');
    $('.a_author').text('').removeClass('text-danger');
}




$('textarea#a_aboutarticle').on('input', e => {
    $('#articlecounter').text(e.target.value.length)
})

$('textarea#a_aboutauthor').on('input', e => {
    $('#authorcounter').text(e.target.value.length)
})




// script for editing article

$('#articleform').ajaxForm({
    beforeSubmit: validate,
    beforeSend: function() {
        $("#a_lbl_finish").html('<div class="spinner"><span class="spinner-border spinner-border-sm text-light" style="height:1rem; width:1rem" role="status" aria-hidden="true"></span><span class="ml-1">Loading...</span></div>')
    },

    uploadProgress: function(event, position, total, percentcomplete) {},
    complete: function(result) {
        date = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        d = new Date(result.responseJSON.article.publish_date);

        $('#articleform')[0].reset()
        $('#articlecounter').text('0');
        $('#authorcounter').text('0');
        $("#a_lbl_finish").html('Register')
        $('#articlemodal').modal('hide');
        $("#title").text(result.responseJSON.article.title);
        $("#publish").html((d.getDate() + 1) + ' ' + date[d.getMonth()] + ' ' + d.getFullYear());
        $("#author").html(result.responseJSON.article.author);
        $("#pages").html(result.responseJSON.article.pages + ' Pages, ' + result.responseJSON.article.chapter + ' Chapters');
        $('textarea#a_aboutauthor').val(result.responseJSON.article.about_author);
        $('textarea#a_aboutarticle').val(result.responseJSON.article.about_article);
        $('#a_author').val(result.responseJSON.article.author);
        $('#a_name').val(result.responseJSON.article.title)
        $('#a_page').val(result.responseJSON.article.pages);
        $('#a_chapter').val(result.responseJSON.article.chapter);
        $('#a_publish').val(result.responseJSON.article.publish_date);
        $('#a_aboutarticle_container').remove();
        $('#a_aboutauthor_container').remove();
        if (result.responseJSON.article.about_author != '') {
            if ($('span#lang').data('language') == 'english') {
                let element = `  <div id="a_aboutauthor_container" class="pl-1 ">
                <hr>
                <h4 class="An_Dm_bold">About Author</h4>
                <small><p class="text-break">${ result.responseJSON.article.about_author }</p></small>
                </div>
                `;
                $('#article_container').append(element);
            } else if ($('span#lang').data('language') == 'dari') {
                let element = `  <div id="a_aboutauthor_container" class="pl-1 text-right">
                <hr>
                <h4 class="An_Dm_bold">درباره نویسنده</h4>
                <small><p class="text-break">${ result.responseJSON.article.about_author }</p></small>
                </div>
                `;
                $('#article_container').append(element);
            } else {
                let element = `  <div id="a_aboutauthor_container" class="pl-1 text-right">
                <hr>
                <h4 class="An_Dm_bold">دلیکوال لپاره</h4>
                <small><p class="text-break">${ result.responseJSON.article.about_author }</p></small>
                </div>
                `;
                $('#article_container').append(element);
            }
        } else {
            $('#a_aboutauthor_container').remove();
        }


        if (result.responseJSON.article.about_article != '') {
            if ($('span#lang').data('language') == 'english') {
                let element = `
                <div id="a_aboutarticle_container" class="pl-1 mt-5">
                <hr>
                <h4 class="An_Dm_bold">About Article</h4>
                <small><p class="text-break">${ result.responseJSON.article.about_article }</p></small>
                </div>
                `;
                $('#article_container').append(element);
            } else if ($('span#lang').data('language') == 'dari') {
                let element = `
                <div id="a_aboutarticle_container" class="pl-1 mt-5 text-right">
                <hr>
                <h4 class="An_Dm_bold">درباره مقاله </h4>
                <small><p class="text-break">${ result.responseJSON.article.about_article }</p></small>
                </div>
                `;
                $('#article_container').append(element);
            } else {
                let element = `
                <div id="a_aboutarticle_container" class="pl-1 mt-5 text-right">
                <hr>
                <h4 class="An_Dm_bold">دمقاله په اړه </h4>
                <small><p class="text-break">${ result.responseJSON.article.about_article }</p></small>
                </div>
                `;
                $('#article_container').append(element);
            }
        } else {
            $('#a_aboutarticle_container').remove();
        }
    },
})




// script for validating form 
function validate() {
    var isValid = true;
    var language = $('span#lang').data('language');
    if ($('#a_name').val() == '') {
        isValid = false;

        if (language == 'english')
            $('.a_name').text('Article name is required.').addClass('text-danger');
        else if (language == 'dari')
            $('.a_name').text('نام مقاله ضروری است.').addClass('text-danger');
        else
            $('.a_name').text('مقاله نوم ضروری ده.').addClass('text-danger');
    } else {
        $('.a_name').text('')
    }

    if ($('#a_author').val() == '') {
        isValid = false;
        if (language == 'english')
            $('.a_author').text('Author name is required.').addClass('text-danger');
        else if (language == 'dari')
            $('.a_author').text('نام نویسنده ضروری است.').addClass('text-danger');
        else
            $('.a_author').text('لیکوال نوم ضروری ده.').addClass('text-danger');

    } else {
        $('.a_author').text('')
    }

    if (isValid) {
        isValid = check();
    }
    return isValid;
}



// function for checking whehter article already exist or no
function check() {

    let name = $('#a_name').val();
    let author = $('#a_author').val();
    let token = $('input[name=_token]').val();
    var temp = true;
    $.ajax({
        url: $('span#lang').data("id"),
        type: 'PUT',
        data: { a_name: name, a_author: author, _token: token, validate: true },
        async: false,
        success: (result) => {
            if (result.msg == 'failed') {
                temp = false;
                $('.a_exist_error').removeClass('invisible');
            } else {
                temp = true;
                $('.a_exist_error').addClass('invisible');
            }
        }
    });
    return temp;
}