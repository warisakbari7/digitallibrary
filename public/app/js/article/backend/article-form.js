var tags = [];
let a_element = $("span.article_tag");

$(document).ready(() => {
    $('#a_article').attr('accept', '.pdf')
    $('span.article_tag').css('cursor', 'pointer')

    $('#articlemodal').on('show.bs.modal', e => {
        $('span.article_tag').removeClass('text-white').removeClass('text-dark').removeClass('bg--two');
    })

    // script for changing direction of form for different language    
    $("#articlemodal").on('hidden.bs.modal', e => {

        $('#articleform')[0].reset();
        $('#articlenamelbl').text('');
        $('span.article_tag.bg--two').removeClass('bg--two').addClass('bg--four text-dark');
        $('#tagcounter').text('0');
        $('#articlecounter').text('0');
        $('#a_authorcounter').text('0');
        $('.progress').addClass('d-none');
        $('.a_article').text('*Note: PDF size should not be more then 60 MB');
        tags = [];
        $('#articlemodal').removeClass('rtl').css('text-align', 'left');
        $('#a_lbl_language').text('زبان');
        $('#lbl_a_name').text(' Article Name');
        $('#a_name').attr('placeholder', 'Article Full Name');
        $('#lbl_a_author').text('Author');
        $('#a_author').attr('placeholder', 'Author Full Name');
        $('#lbl_a_page').text('Number of Pages and Chapters');
        $('#lbl_a_pages').text('Pages');
        $('#lbl_a_chapter').text('Chapters');
        $('#lbl_a_publish').text(' Year of Publish');
        $('#lbl_a_aboutauthor').text('About Author');
        $('#a_aboutauthor').attr("placeholder", 'short biography in 1000 character');
        $('#lbl_a_aboutarticle').text('About Article');
        $('#a_aboutarticle').attr('placeholder', 'explain article briefly in 1000 character');
        $('#lbl_a_catagory').text('Categories');
        $('#lbl_a_article').text('Article');
        $('#a_lbl_finish').text('Register');
        $('.a_exist_error').text('This Article has already been registered');
        $('.a_exist_error').addClass("invisible");
        $('#a_lbl_language').text('Language');
        $('#articleform').find("input").css('text-align', 'left');
        $('#articleform').find("textarea").css('text-align', 'left');
        $('#articleform').find("select").css('text-align', 'left').css('direction', 'ltr');
        $('.a_tagcontainer').css('direction', 'ltr')
        $('#a_lang').text('Select Language')

        $('#a_articlebutton').text("Upload");
        $('#a_lblarticle').text("Uploaded : ");

        $.each(a_element, (index, span) => {
            $('span.article_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
            $('span#articlecounter').text(0)
            span.innerHTML = json_tag[index].ename
        })

        $.each($('#a_catagory>option'), (index, span) => {
            span.innerHTML = json_catagory[index].ename
        })
    })

    // script for changing lanugage add Article form
    $('#a_language').on('change', e => {
        switch (e.target.value) {
            case 'english':
                a_english('english');
                break;
            case 'pashto':
                a_pashto('pashto');
                break;
            case 'dari':
                a_dari('dari')
                break;
            default:
                break;
        }
    })


    $('textarea#a_aboutarticle').on('input', e => {
        $('#a_articlecounter').text(e.target.value.length)
    })

    $('textarea#a_aboutauthor').on('input', e => {
        $('#a_authorcounter').text(e.target.value.length)
    })

    // scriptfor selecting tags
    $('span.article_tag').click(e => {
        let a_element = $('span.article_tag.bg--two');
        if (a_element.length < 5) {
            if ($(a_element).attr('class') == $(e.target).attr('class')) {
                $(e.target).toggleClass('bg--two')
                $(e.target).toggleClass('bg--four')
                $(e.target).toggleClass('text-white')
                $('span#a_tagcounter').text(a_element.length - 1)
                let index = tags.indexOf(e.target.innerHTML);
                tags.splice(index, 1);
                let temp = tags.valueOf();
                $('#a_tags_values').val('')
                $('#a_tags_values').val(temp)

            } else {
                $(e.target).toggleClass('bg--four')
                $(e.target).toggleClass('bg--two')
                $(e.target).toggleClass('text-white')
                $('span#a_tagcounter').text($('span.article_tag.bg--two').length)
                tags.push(e.target.innerHTML);
                let temp = tags.valueOf()
                $('#a_tags_values').val('')
                $('#a_tags_values').val(temp)

            }

        } else if ($(a_element).attr('class') == $(e.target).attr('class')) {
            $(e.target).toggleClass('bg--two')
            $(e.target).toggleClass('bg--four')
            $(e.target).toggleClass('text-white')
            $('span#a_tagcounter').text(a_element.length - 1)
            let index = tags.indexOf(e.target.innerHTML);
            tags.splice(index, 1)
            let temp = tags.valueOf();
            $('#a_tags_values').val('')
            $('#a_tags_values').val(temp)
        }
    })


    // script for adding Article
    let bar = $('.a_bar')
    let percent = $('.a_percent')

    $('#articleform').ajaxForm({
        beforeSubmit: validate,
        beforeSend: function() {
            let percentval = '0%'
            $('.progress').removeClass('d-none');
            bar.width(percentval);
            percent.html(percentval);
            $('#a_lbl_finish').attr('disabled', true);
        },

        uploadProgress: function(event, position, total, percentcomplete) {
            let percentval = percentcomplete + '%';
            bar.width(percentval);
            percent.html(percentval);
        },
        complete: function(result) {

            $('#articleform')[0].reset();
            $('#articlenamelbl').text('');
            $('span.article_tag.bg--two').removeClass('bg--two').addClass('bg--four text-dark');
            $('#a_tagcounter').text('0');
            $('#articlecounter').text('0');
            $('#a_authorcounter').text('0');
            $('.progress').addClass('d-none');
            $('.a_article').text('*Note: PDF size should not be more then 60 MB');
            tags = [];
            $('#articlemodal').modal('hide');
            $('tbody').prepend(result.responseJSON.row);
            numbering();
            $('#a_lbl_finish').removeAttr('disabled');
        },
    })



    // script for giving error due to wrong input for Article input
    $('#a_article').change(d => {
        if (d.target.value != '') {
            let image = $('#a_article').val().split('.').pop().toLowerCase();
            if (image == 'pdf') {
                let size = $('#a_article')[0].files[0].size;
                if (size > 60000000) {
                    $('.a_article').text('PDF size should not be more then 60 MB')
                    $('.a_article').addClass('text-danger');
                    return false
                } else {
                    $('.a_article').text('')
                }
            } else {
                $('.a_article').text('Only PDF Format is Allowed!');
                $('.a_article').addClass('text-danger');
                return false;
            }
            $('.a_article').removeClass('text-danger');
            $('#articlenamelbl').text(d.target.files[0].name)
        } else {
            $('#articlenamelbl').text('')
        }

    })
});

// script for validating form 
function validate() {
    var isValid = true;
    var language = $('select[name=a_language]').val();
    if ($('#a_name').val() == '') {
        isValid = false;

        if (language == 'english')
            $('.a_name').text('Article name is required.').addClass('text-danger');
        else if (language == 'dari')
            $('.a_name').text('نام مقاله ضروری است.').addClass('text-danger');
        else
            $('.a_name').text('مقاله نوم ضروری ده.').addClass('text-danger');
        window.location.href = "#a_name";
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
        window.location.href = "#a_author";

    } else {
        $('.a_author').text('')
    }


    if ($('span.article_tag.bg--two').length == 0) {
        if (language == 'english')
            $('.a_tag').text('Select some tags').addClass("text-danger");
        else if (language == 'pashto')
            $('.a_tag').text('دا ضروری ده').addClass('text-danger');
        else
            $('.a_tag').text('لطفا از این ها انتخاب کنید').addClass('text-danger');
        window.location.href = "#lbl_a_tag";
        isValid = false;
    } else {
        $('.a_tag').text('');
    }

    if ($('#a_article').val() == '') {
        isValid = false;
        if (language == 'english')
            $('.a_article').text('Please add your Article').addClass('text-danger')
        else if (language == 'pashto')
            $('.a_article').text('مقاله اتنخاب وکړی').addClass('text-danger')
        else
            $('.a_article').text('مقاله را اضافه کنید').addClass('text-danger')
        window.location.href = "#a_article";

    } else {
        let pdf = $('#a_article').val().split('.').pop().toLowerCase();
        if (pdf == 'pdf') {
            let size = $('#a_article')[0].files[0].size;
            if (size > 60000000) {
                if (language == 'english')
                    $('.a_article').text('PDF size should not be more then 60 MB').addClass('test-danger');
                else if (language == 'pashto')
                    $('.a_article').text('PDFسایز له ۶۰ mb زیاد اجازه نه ده').addClass('test-danger');
                else
                    $('.a_article').text('سایز pdf از ۶۰ mb زیاد بوده نمی تواند').addClass('test-danger');
                window.location.href = "#a_article";

                return false
            } else {
                $('.a_article').removeClass('text-danger');
            }
        } else {
            if (language == 'english')
                $('.a_article').text('Only PDF Format is Allowed!').addClass('text-danger');
            else if (language == 'pashto')
                $('.a_article').text('یوازی pdf فارمت اجازه ده').addClass('text-danger');
            else
                $('.a_article').text('تنها pdfفارمت اجازه است').addClass('text-danger');
            window.location.href = "#a_article";
            return false;
        }
        $('.a_article').removeClass('text-danger')
    }

    if (isValid) {
        isValid = check();
    }
    return isValid;
}


// function for checking whehter Article already exist or no
function check() {

    let name = $('#a_name').val();
    let author = $('#a_author').val();
    let token = $('input[name=_token]').val();

    var temp = true;
    $.ajax({
        url: 'upload-article',
        type: 'POST',
        data: { a_name: name, a_author: author, _token: token, validate: true },
        async: false,
        success: (result) => {
            if (result.msg == 'failed') {
                temp = false;
                $('.a_exist_error').removeClass('invisible');
            } else {
                $('.a_exist_error').addClass('invisible');

            }
        }
    });
    return temp;
}


function a_dari(lang) {

    tags = []
    $('#articleform')[0].reset();
    $('#a_language').val(lang)
    $('#articlenamelbl').text('')

    $.each(a_element, (index, span) => {
        $('span.article_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
        $('span#a_tagcounter').text(0)
        span.innerHTML = json_tag[index].dname
    })

    $.each($('#a_catagory>option'), (index, span) => {
        span.innerHTML = json_catagory[index].dname
    })

    $('.a_exist_error').text('این کتاب از قبل موجود است');

    $('#articleform').find("input").css('text-align', 'right');
    $('#articleform').find("textarea").css('text-align', 'right');
    $('#articleform').find("select").css('text-align', 'right').css('direction', 'rtl');

    $('.a_tagcontainer').css('direction', 'rtl');
    $('#articlemodal').addClass('rtl').css('text-align', 'right');
    $('#a_lbl_language').text('زبان')
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
    $('#lbl_a_article').text('مقاله')
    $('#a_lbl_finish').text('ثبت')
    $('#lbl_a_publish').text('تاریخ نشر')


    $('.a_name').text('').removeClass('text-danger');
    $('.a_author').text('').removeClass('text-danger');
    $('.a_article').text('').removeClass('text-danger');
    $('.a_tag').text('').removeClass('text-danger');
    $('#a_articlebutton').text("آپلود");
    $('#a_lblarticle').text(": آپلود شده");
    $('#a_lang').text('انتخاب زبان')

}



function a_english(lang) {
    $('#articleform')[0].reset();
    $('#a_language').val(lang)
    $('#articlenamelbl').text('')

    tags = [];
    $('.a_exist_error').text('This Article has already been registered');

    $.each(a_element, (index, span) => {
        $('span.article_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
        $('span#a_tagcounter').text(0)
        span.innerHTML = json_tag[index].ename
    })
    $.each($('#a_catagory>option'), (index, span) => {
        span.innerHTML = json_catagory[index].ename
    })

    $('#articleform').find("input").css('text-align', 'left');
    $('#articleform').find("textarea").css('text-align', 'left');
    $('#articleform').find("select").css('text-align', 'left').css('direction', 'ltr');
    $('.a_tagcontainer').css('direction', 'ltr');

    $('#articlemodal').removeClass('rtl').css('text-align', 'left');
    $('#a_lbl_language').text('Language')
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
    $('#lbl_a_catagory').text('Categories')
    $('#lbl_a_article').text('Article')
    $('#a_lbl_finish').text('Register')
    $('#lbl_a_publish').text('Year of publish')

    $('.a_name').text('').removeClass('text-danger');
    $('.a_author').text('').removeClass('text-danger');
    $('.a_article').text('').removeClass('text-danger');
    $('.a_tag').text('').removeClass('text-danger');

    $('#a_articlebutton').text("Upload");
    $('#a_lblarticle').text("Uploaded : ");
    $('#a_lang').text('Select Language')

}



function a_pashto(lang) {

    $('#articleform')[0].reset();
    $('#a_language').val(lang)
    $('#articlenamelbl').text('')

    tags = []
    $('span.article_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
    $('span#a_tagcounter').text(0)
    $('.a_exist_error').text('دا مقاله مخکی نه ثبت شوی ده');
    $.each(a_element, (index, span) => {
        span.innerHTML = json_tag[index].pname
    })

    $.each($('#a_catagory>option'), (index, span) => {
        span.innerHTML = json_catagory[index].pname
    })
    $('.a_tagcontainer').css('direction', 'rtl');
    $('#articleform').find("input").css('text-align', 'right');
    $('#articleform').find("textarea").css('text-align', 'right');
    $('#articleform').find("select").css('text-align', 'right').css('direction', 'rtl');
    $('#articlemodal').addClass('rtl').css('text-align', 'right');
    $('#a_lbl_language').text('‌‌ژبه')
    $('#lbl_a_name').text('مقاله نوم')
    $('#a_name').attr('placeholder', ' کتاب نوم');
    $('#lbl_a_author').text('لیکوال')
    $('#a_author').attr('placeholder', 'لیکوال نوم')
    $('#lbl_a_page').text('د فصل او پاڼه نمبر')
    $('#lbl_a_pages').text('پانه')
    $('#lbl_a_chapter').text('فصل')
    $('#lbl_a_publish').text(' دنشر نیټه')
    $('#lbl_a_aboutauthor').text('دلیکوال په اړه');
    $('#a_aboutauthor').attr("placeholder", 'لنډ ژوندلیک په 1000 حروف کې')
    $('#lbl_a_aboutarticle').text('دکتاب په اړه');
    $('#a_aboutarticle').attr('placeholder', 'مقاله په لنډه توګه په 1000 حروف کې تشریح کړئ')
    $('#lbl_a_catagory').text('برخه')
    $('#lbl_a_article').text('کتاب')
    $('#a_lbl_finish').text('ثبت')
    $('#lbl_a_publish').text('دنشر نیټه')


    $('.a_name').text('').removeClass('text-danger');
    $('.a_author').text('').removeClass('text-danger');
    $('.a_article').text('').removeClass('text-danger');
    $('.a_tag').text('').removeClass('text-danger');
    $('#a_articlebutton').text("آپلود");
    $('#a_lblarticle').text(": آپلود شوی ده");
    $('#a_lang').text('دژبی انتخاب')
}



function numbering() {
    let tr = $('tbody>tr');
    $.each(tr, (index, element) => {
        $(element).children('td').first().text(index + 1)
    })
}