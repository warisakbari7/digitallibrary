var tags = [];
let element = $("span.book_tag");

$(document).ready(() => {



    $('#b_book').attr('accept', '.pdf')
    $('#b_cover').attr('accept', '.jpg,.jpeg,.png')
    $('span.book_tag').css('cursor', 'pointer')

    $('#bookmodal').on('show.bs.modal', e => {
        $('span.book_tag').removeClass('text-white').removeClass('text-dark').removeClass('bg--two');
    })

    // script for changing direction of form for different language    
    $("#bookmodal").on('hidden.bs.modal', e => {

        $('#bookform')[0].reset();
        $('#covernamelbl').text('');
        $('#booknamelbl').text('');
        $('#img_b_cover').attr('src', cover);
        $('span.book_tag.bg--two').removeClass('bg--two').addClass('bg--four text-dark');
        $('#b_tagcounter').text('0');
        $('#bookcounter').text('0');
        $('#b_authorcounter').text('0');
        $('.progress').addClass('d-none');
        $('.b_cover').text('*Note: Image must be between 500 KB - 2 MB');
        $('.b_cover').removeClass('text-danger');
        $('.b_book').text('*Note: PDF size should not be more then 60 MB');
        tags = [];
        $('#bookmodal').removeClass('rtl').css('text-align', 'left');
        $('#b_lbl_language').text('زبان');
        $('#lbl_b_name').text(' Book Name');
        $('#b_name').attr('placeholder', 'Book Full Name');
        $('#lbl_b_author').text('Author');
        $('#b_author').attr('placeholder', 'Author Full Name');
        $('#lbl_b_page').text('Number of Pages and Chapters');
        $('#lbl_b_pages').text('Pages');
        $('#lbl_b_chapter').text('Chapters');
        $('#lbl_b_edition').text('Edition');
        $('#lbl_b_publish').text(' Year of Publish');
        $('#lbl_b_aboutauthor').text('About Author');
        $('#b_aboutauthor').attr("placeholder", 'short biography in 1000 character');
        $('#lbl_b_aboutbook').text('About Book');
        $('#b_aboutbook').attr('placeholder', 'explain book briefly in 1000 character');
        $('#lbl_b_catagory').text('Categories');
        $('#lbl_b_cover').text('Cover');
        $('#lbl_b_book').text('Book');
        $('#b_lbl_finish').text('Register');
        $('.b_exist_error').text('This Book has already been registered');
        $('.b_exist_error').addClass("invisible");
        $('#b_lbl_language').text('Language');
        $('#bookform').find("input").css('text-align', 'left');
        $('#bookform').find("textarea").css('text-align', 'left');
        $('#bookform').find("select").css('text-align', 'left').css('direction', 'ltr');
        $('.b_tagcontainer').css('direction', 'ltr')
        $('#b_lang').text('Select Language')
        $('#b_bookbutton').text("Upload");
        $('#b_coverbutton').text("Upload");
        $('#b_lblcover').text("Uploaded : ");
        $('#b_lblbook').text("Uploaded : ");
        $('#b_cat_lbl').text('choose category');

        $.each(element, (index, span) => {
            $('span.book_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
            $('span#b_tagcounter').text(0)
            span.innerHTML = json_tag[index].ename
        })

        $.each($('#b_catagory>option').not('#b_cat_lbl'), (index, span) => {
            span.innerHTML = json_catagory[index].ename
        })
    })

    // script for changing lanugage add book form
    $('#b_language').on('change', e => {
        $('#booknamelbl').text('');
        $('#covernamelbl').text('');
        $('#img_b_cover').attr('src', cover);
        switch (e.target.value) {
            case 'english':
                b_english('english');
                break;
            case 'pashto':
                b_pashto('pashto');
                break;
            case 'dari':
                b_dari('dari')
                break;
            default:
                break;
        }
    })


    $('textarea#b_aboutbook').on('input', e => {
        $('#bookcounter').text(e.target.value.length)
    })

    $('textarea#b_aboutauthor').on('input', e => {
        $('#b_authorcounter').text(e.target.value.length)
    })

    // scriptfor selecting tags
    $('span.book_tag').click(e => {
        let element = $('span.book_tag.bg--two');
        if (element.length < 5) {
            if ($(element).attr('class') == $(e.target).attr('class')) {
                $(e.target).toggleClass('bg--two')
                $(e.target).toggleClass('bg--four')
                $(e.target).toggleClass('text-white')
                $('span#b_tagcounter').text(element.length - 1)
                let index = tags.indexOf(e.target.innerHTML);
                tags.splice(index, 1);
                let temp = tags.valueOf();
                $('#b_tags_values').val('')
                $('#b_tags_values').val(temp)

            } else {
                $(e.target).toggleClass('bg--four')
                $(e.target).toggleClass('bg--two')
                $(e.target).toggleClass('text-white')
                $('span#b_tagcounter').text($('span.book_tag.bg--two').length)
                tags.push(e.target.innerHTML);
                let temp = tags.valueOf()
                $('#b_tags_values').val('')
                $('#b_tags_values').val(temp)

            }

        } else if ($(element).attr('class') == $(e.target).attr('class')) {
            $(e.target).toggleClass('bg--two')
            $(e.target).toggleClass('bg--four')
            $(e.target).toggleClass('text-white')
            $('span#b_tagcounter').text(element.length - 1)
            let index = tags.indexOf(e.target.innerHTML);
            tags.splice(index, 1)
            let temp = tags.valueOf();
            $('#b_tags_values').val('')
            $('#b_tags_values').val(temp)
        }
    })


    // script for adding book
    let bar = $('.b_bar')
    let percent = $('.b_percent')

    $('#bookform').ajaxForm({
            beforeSubmit: validateBook,
            beforeSend: function() {
                let percentval = '0%'
                $('.progress').removeClass('d-none');
                bar.width(percentval);
                percent.html(percentval);
                $('#b_lbl_finish').attr('disabled', true);
            },

            uploadProgress: function(event, position, total, percentcomplete) {
                let percentval = percentcomplete + '%';
                bar.width(percentval);
                percent.html(percentval);
            },
            complete: function(result) {
                $('#bookform')[0].reset();
                $('#covernamelbl').text('');
                $('#booknamelbl').text('');
                $('#img_b_cover').attr('src', cover);
                $('span.book_tag.bg--two').removeClass('bg--two').addClass('bg--four text-dark');
                $('#b_tagcounter').text('0');
                $('#bookcounter').text('0');
                $('#b_authorcounter').text('0');
                $('.progress').addClass('d-none');
                $('.b_cover').text('*Note: Image must be between 500 KB - 2 MB');
                $('.b_cover').removeClass('text-danger');
                $('.b_book').text('*Note: PDF size should not be more then 60 MB');
                tags = [];
                $('#b_lbl_finish').removeAttr('disabled');
                $('#bookmodal').modal('hide');
            }
        })
        // script for attaching cover book image  into img tag
    $('#b_cover').change(d => {

        if (d.target.value != '') {
            let image = $('#b_cover').val().split('.').pop().toLowerCase();
            if ($.inArray(image, ['png', 'jpeg', , 'jpg', ]) != -1) {
                let size = $('#b_cover')[0].files[0].size;
                if (size < 10000 || size > 2000000) {
                    $('.b_cover').text('Image size should be between 100 kb  - 2 mb')
                    $('.b_cover').addClass('text-danger');
                    return false
                } else {
                    $('.b_cover').text('')
                    $('.b_cover').removeClass('text-danger');
                }
            } else {
                $('.b_cover').text('Only jpg, png and jpeg Format is Allowed!');
                $('.b_cover').addClass('text-danger');
                return false;
            }
            $('.b_cover').removeClass('text-danger');
            var reader = new FileReader();
            reader.onload = e => {
                $('#img_b_cover').attr('src', e.target.result);
            }
            reader.readAsDataURL(d.target.files[0]);
            $('#covernamelbl').text(d.target.files[0].name)
        } else {
            $('#img_b_cover').attr('src', cover);
            $('#covernamelbl').text('')
        }

    })


    // script for giving error due to wrong input for book input
    $('#b_book').change(d => {

        if (d.target.value != '') {
            let image = $('#b_book').val().split('.').pop().toLowerCase();
            if (image == 'pdf') {
                let size = $('#b_book')[0].files[0].size;
                if (size > 60000000) {
                    $('.b_book').text('PDF size should not be more then 60 MB')
                    $('.b_book').addClass('text-danger');
                    return false
                } else {
                    $('.b_book').text('')
                }
            } else {
                $('.b_book').text('Only PDF Format is Allowed!');
                $('.b_book').addClass('text-danger');
                return false;
            }
            $('.b_book').removeClass('text-danger');
            $('#booknamelbl').text(d.target.files[0].name)
        } else {
            $('#booknamelbl').text('')
        }

    })
});

// script for validating form 
function validateBook() {

    var isValid = true;
    var language = $('select[name=b_language]').val();
    if ($('#b_name').val() == '') {
        isValid = false;

        if (language == 'english')
            $('.b_name').text('Book name is required.').addClass('text-danger');
        else if (language == 'dari')
            $('.b_name').text('نام کتاب ضروری است.').addClass('text-danger');
        else
            $('.b_name').text('کتاب نوم ضروری ده.').addClass('text-danger');
        window.location.href = '#b_name'
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
        window.location.href = '#b_author'
    } else {
        $('.b_author').text('')
    }


    if ($('span.book_tag.bg--two').length == 0) {
        if (language == 'english')
            $('.b_tag').text('Select some tags').addClass("text-danger");
        else if (language == 'pashto')
            $('.b_tag').text('دا ضروری ده').addClass('text-danger');
        else
            $('.b_tag').text('لطفا از این ها انتخاب کنید').addClass('text-danger');
        window.location.href = '#lbl_b_tag';
        isValid = false;
    } else {
        $('.b_tag').text('');
    }

    if ($('#b_book').val() == '') {
        isValid = false;
        if (language == 'english')
            $('.b_book').text('Please add your Book').addClass('text-danger')
        else if (language == 'pashto')
            $('.b_book').text('کتاب اتنخاب وکړی').addClass('text-danger')
        else
            $('.b_book').text('کتاب را اضافه کنید').addClass('text-danger')
        window.location.href = "#b_book";
    } else {
        let pdf = $('#b_book').val().split('.').pop().toLowerCase();
        if (pdf == 'pdf') {
            let size = $('#b_book')[0].files[0].size;
            if (size > 60000000) {
                if (language == 'english')
                    $('.b_book').text('PDF size should not be more then 60 MB').addClass('test-danger');
                else if (language == 'pashto')
                    $('.b_book').text('PDFسایز له ۶۰ mb زیاد اجازه نه ده').addClass('test-danger');
                else
                    $('.b_book').text('سایز pdf از ۶۰ mb زیاد بوده نمی تواند').addClass('test-danger');
                window.location.href = "#b_book";
                return false
            } else {
                $('.b_book').removeClass('text-danger');
            }
        } else {
            if (language == 'english')
                $('.b_book').text('Only PDF Format is Allowed!').addClass('text-danger');
            else if (language == 'pashto')
                $('.b_book').text('یوازی pdf فارمت اجازه ده').addClass('text-danger');
            else
                $('.b_book').text('تنها pdfفارمت اجازه است').addClass('text-danger');
            window.location.href = "#b_book";
            return false;
        }
        $('.b_book').removeClass('tefxt-danger')
    }

    if ($('#b_cover').val() == '') {
        isValid = false;
        if (language == 'english')
            $('.b_cover').text('Please add cover of your book').addClass('text-danger');
        else if (language == 'pashto')
            $('.b_cover').text('کتاب پوښ اضافه وکړی').addClass('text-danger');
        else
            $('.b_cover').text('لطفا پوش کتاب را اضافه کنید').addClass('text-danger');
        window.location.href = "#b_cover";
    } else {
        let image = $('#b_cover').val().split('.').pop().toLowerCase();
        if ($.inArray(image, ['png', 'jpeg', , 'jpg', ]) != -1) {
            let size = $('#b_cover')[0].files[0].size;
            if (size < 10000 || size > 2000000) {
                if (language == 'english')
                    $('.b_cover').text('Image size should be between 100 kb  - 2 mb');
                else if (language == 'pashto')
                    $('.b_cover').text('دعکس سایز له ۱۰۰ mb کم او له ۲ mb زیاد اجازه نه ده')
                else
                    $('.b_cover').text('سایز عکس باید بین ۱۰۰kb - ۲mb باشد')
                window.location.href = "#b_cover";
                return false
            } else {
                $('.b_cover').text('')
            }
        } else {
            if (language == 'english')
                $('.b_cover').text('Only jpg, png and jpeg Format is Allowed!').addClass('text-danger');
            else if (language == 'pashto')
                $('.b_cover').text('یوازی jpg, jpeg, png اجازه ده').addClass('text-danger');
            else
                $('.b_cover').text('تنها jpg, jpeg, png اجازه است').addClass('text-danger');
            window.location.href = "#b_cover";
            return false;
        }
        $('.b_cover').toggleClass('text-danger')
    }

    if (isValid) {
        isValid = checkBook();
    }
    return isValid;
}


// function for checking whehter book already exist or no
function checkBook() {

    let name = $('#b_name').val();
    let author = $('#b_author').val();
    let edition = $('#b_edition').val();
    let token = $('input[name=_token]').val();

    var temp = true;
    $.ajax({
        url: 'upload-book',
        type: 'POST',
        data: { b_name: name, b_author: author, b_edition: edition, _token: token, validate: true },
        async: false,
        success: (result) => {
            if (result.msg == 'failed') {
                temp = false;
                $('.b_exist_error').removeClass('invisible');
            } else {
                $('.b_exist_error').addClass('invisible');

            }
        }
    });
    return temp;
}


function b_dari(lang) {

    tags = []
    $('#bookform')[0].reset();
    $('#b_language').val(lang)
    $('#booknamelbl').text('')

    $.each(element, (index, span) => {
        $('span.book_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
        $('span#b_tagcounter').text(0)
        span.innerHTML = json_tag[index].dname
    })

    $.each($('#b_catagory>option').not("#b_cat_lbl"), (index, span) => {
        span.innerHTML = json_catagory[index].dname
    })

    $('.b_exist_error').text('این کتاب از قبل موجود است');

    $('#bookform').find("input").css('text-align', 'right');
    $('#bookform').find("textarea").css('text-align', 'right');
    $('#bookform').find("select").css('text-align', 'right').css('direction', 'rtl');

    $('.b_tagcontainer').css('direction', 'rtl');
    $('#bookmodal').addClass('rtl').css('text-align', 'right');
    $('#b_lbl_language').text('زبان')
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
    $('#lbl_b_cover').text('پوش')
    $('#lbl_b_book').text('کتاب')
    $('#b_lbl_finish').text('ثبت')
    $('#lbl_b_publish').text('تاریخ نشر')


    $('.b_name').text('').removeClass('text-danger');
    $('.b_author').text('').removeClass('text-danger');
    $('.b_book').text('').removeClass('text-danger');
    $('.b_cover').text('').removeClass('text-danger');
    $('.b_tag').text('').removeClass('text-danger');
    $('#b_bookbutton').text("آپلود");
    $('#b_coverbutton').text("آپلود");
    $('#b_lblcover').text(": آپلود شده");
    $('#b_lblbook').text(": آپلود شده");
    $('#b_lang').text('انتخاب زبان')
    $('#b_cat_lbl').text('انتخاب کتگوری')
    $('#lbl_b_tag').text('برچسپ')


}



function b_english(lang) {
    $('#bookform')[0].reset();
    $('#b_language').val(lang)
    $('#booknamelbl').text('')
    tags = [];
    $('.b_exist_error').text('This Book has already been registered');

    $.each(element, (index, span) => {
        $('span.book_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
        $('span#b_tagcounter').text(0)
        span.innerHTML = json_tag[index].ename
    })
    $.each($('#b_catagory>option'), (index, span) => {
        span.innerHTML = json_catagory[index].ename
    })

    $('#bookform').find("input").css('text-align', 'left');
    $('#bookform').find("textarea").css('text-align', 'left');
    $('#bookform').find("select").css('text-align', 'left').css('direction', 'ltr');
    $('.b_tagcontainer').css('direction', 'ltr');

    $('#bookmodal').removeClass('rtl').css('text-align', 'left');
    $('#b_lbl_language').text('Language')
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
    $('#lbl_b_catagory').text('Categories')
    $('#lbl_b_cover').text('Cover')
    $('#lbl_b_book').text('Book')
    $('#b_lbl_finish').text('Register')
    $('#lbl_b_publish').text('Year of publish')

    $('.b_name').text('').removeClass('text-danger');
    $('.b_author').text('').removeClass('text-danger');
    $('.b_book').text('').removeClass('text-danger');
    $('.b_cover').text('').removeClass('text-danger');
    $('.b_tag').text('').removeClass('text-danger');

    $('#b_bookbutton').text("Upload");
    $('#b_coverbutton').text("Upload");
    $('#b_lblcover').text("Uploaded : ");
    $('#b_lblbook').text("Uploaded : ");
    $('#b_lang').text('Select Language')
    $('#b_cat_lbl').text('choose category')
    $('#lbl_b_tag').text('Tags')


}



function b_pashto(lang) {

    $('#bookform')[0].reset();
    $('#b_language').val(lang)
    $('#booknamelbl').text('')

    tags = []
    $('span.book_tag.bg--two').removeClass('bg--two').addClass('bg--four').removeClass('text-white')
    $('span#b_tagcounter').text(0)
    $('.b_exist_error').text('دا کتاب مخکی نه ثبت شوی ده');
    $.each(element, (index, span) => {
        span.innerHTML = json_tag[index].pname
    })

    $.each($('#b_catagory>option'), (index, span) => {
        span.innerHTML = json_catagory[index].pname
    })
    $('.b_tagcontainer').css('direction', 'rtl');
    $('#bookform').find("input").css('text-align', 'right');
    $('#bookform').find("textarea").css('text-align', 'right');
    $('#bookform').find("select").css('text-align', 'right').css('direction', 'rtl');
    $('#bookmodal').addClass('rtl').css('text-align', 'right');
    $('#b_lbl_language').text('‌‌ژبه')
    $('#lbl_b_name').text('کتاب نوم')
    $('#b_name').attr('placeholder', ' کتاب نوم');
    $('#lbl_b_author').text('لیکوال')
    $('#b_author').attr('placeholder', 'لیکوال نوم')
    $('#lbl_b_page').text('د فصل او پاڼه نمبر')
    $('#lbl_b_pages').text('پانه')
    $('#lbl_b_chapter').text('فصل')
    $('#lbl_b_edition').text('چاپ')
    $('#lbl_b_publish').text(' دنشر نیټه')
    $('#lbl_b_aboutauthor').text('دلیکوال په اړه');
    $('#b_aboutauthor').attr("placeholder", 'لنډ ژوندلیک په 1000 حروف کې')
    $('#lbl_b_aboutbook').text('دکتاب په اړه');
    $('#b_aboutbook').attr('placeholder', 'کتاب په لنډه توګه په 1000 حروف کې تشریح کړئ')
    $('#lbl_b_catagory').text('برخه')
    $('#lbl_b_cover').text('پوښ')
    $('#lbl_b_book').text('کتاب')
    $('#b_lbl_finish').text('ثبت')
    $('#lbl_b_publish').text('دنشر نیټه')
    $('#lbl_b_tag').text('برچسپ')


    $('.b_name').text('').removeClass('text-danger');
    $('.b_author').text('').removeClass('text-danger');
    $('.b_book').text('').removeClass('text-danger');
    $('.b_cover').text('').removeClass('text-danger');
    $('.b_tag').text('').removeClass('text-danger');
    $('#b_bookbutton').text("آپلود");
    $('#b_coverbutton').text("آپلود");
    $('#b_lblcover').text(": آپلود شوی ده");
    $('#b_lblbook').text(": آپلود شوی ده");
    $('#b_lang').text('دژبی انتخاب')
    $('#b_cat_lbl').text('دکتگوری انتخاب')
}