let star = '';
let e_star = '';
$(() => {

    // script for Load more Review
    $(document).on('click', '#btn-more', e => {

        $.ajax({
            url: window.location.href,
            type: 'GET',
            data: { book: $('#lang').data('id'), review_id: $('#btn-more').data('review') },
            beforeSend: () => {
                $(e.target).arrt('disabled', true);
            },
            complete: result => {
                if (result.reviews == '') {
                    $('#btn-more').replaceWith(result.responseJSON.button)
                } else {
                    $('div.reviews_container').append(result.responseJSON.reviews);
                    $('#btn-more').replaceWith(result.responseJSON.button)
                }
            }
        })
    })


    // script for displaying toast for add Review
    $(document).on('click', '#toastaddbutton', () => {
            $('.add-review-toast').toast({ delay: 3000 });
            $('.add-review-toast').toast('show');
        })
        // script for adding review

    // script for star coloring
    $(document).on('click', 'label.star', (e) => {
        $(e.target).prevAll('label').removeClass('text-dark');
        $(e.target).removeClass('text-dark');
        $(e.target).nextAll('label').addClass('text-dark');
        star = $(e.target).attr('id');
        switch (star) {
            case '1':
                $('#oneStar').click();
                break;
            case '2':
                $('#twoStar').click();
                break;
            case '3':
                $('#threeStar').click();
                break;
            case '4':
                $('#fourStar').click();
                break;
            case '5':
                $('#fiveStar').click();
                break;
            default:
                break;
        }
    });
    $(document).on('mouseover', 'label.star', e => {
        $(e.target).prevAll('label').removeClass('text-dark');
        $(e.target).removeClass('text-dark');
        $(e.target).nextAll('label').addClass('text-dark');
    })

    $(document).on('mouseleave', 'label.star', e => {
        if (star == '') {
            $('label.star').addClass('text-dark')
            return;
        }
        $(`#${star}`).prevAll('label').removeClass('text-dark');
        $(`#${star}`).removeClass('text-dark');
        $(`#${star}`).nextAll('label').addClass('text-dark');
    })


    // script for recommendation button click
    $(document).on('click', 'input#yes', e => {
        $('#lblNo').removeClass('bg--two').removeClass("text-white");
        $('#lblNo').addClass('bg--four').addClass("text--two");
        $('#lblYes').removeClass('bg--four').removeClass("text--two");
        $('#lblYes').addClass('bg--two').addClass("text-white");
    })

    $(document).on('click', 'input#no', e => {
        $('#lblNo').addClass('bg--two').addClass("text-white");
        $('#lblNo').removeClass('bg--four').removeClass("text--two");
        $('#lblYes').addClass('bg--four').addClass("text--two");
        $('#lblYes').removeClass('bg--two').removeClass("text-white");
    })


    $('#reviewForm').ajaxForm({
        beforeSubmit: validate,
        beforeSend: () => {
            $('button#postbutton').html('<span class="spinner-border spinner-border-sm mr-1 mt-1"> </span> Posting..').attr('disabled', 'true');
        },
        data: {
            id: $('#lang').data('id')
        },
        uploadProgress: (event, position, total, precentComplete) => {

        },
        complete: (result) => {
            $('button#postbutton').text('Post Review').removeAttr('disabled')
            $('#reviewModal').modal('hide');
            $('div#review_title').after(result.responseJSON.Review);
            $("div.modal-backdrop.fade.show").remove();
            $("#addbutton").remove();
            $('#editReviewForm').replaceWith(result.responseJSON.form)
            star = '';
            $.get('/CalculateStarsBook', { id: $('#lang').data('id') })
                .done(result => {
                    $('.StarImg').css('width', (result.average_rate * 100 / 5) + 'px');
                    $('#b_averageRate').text(result.average_rate);
                    $('#averageRate').text(result.average_rate);
                    $('#b_total_rate').text('(' + result.total_review + ')');
                    let percentstars = '';
                    for (x = 1; x <= 5; x++) {
                        if (result.stars[x] != undefined) {
                            percentstars += `
                            <div class="row">
                                <div class="col-1">
                                    <h6 class="text--two "><small>${x}&nbsp;Star</small></h6>                                
                                </div>
                                <div class="col-10">
                                    <div class="progress rounded border  w-100 mx-2">
                                        <div class="progress-bar bg--one" role="progressbar" style="width: ${result.stars[x]}%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-1 pl-2">
                                    <h6 class="text--two"><small> ${result.stars[x]}%</small></h6>
                                </div>
                            </div>`;
                        } else {
                            percentstars += `
                            <div class="row">
                                <div class="col-1">
                                    <h6 class="text--two "><small>${x}&nbsp;Star</small></h6>
                                </div>
                                <div class="col-10">
                                    <div class="progress rounded border  w-100 mx-2">
                                        <div class="progress-bar bg--one" role="progressbar" style="width: 0%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-1">
                                    <h6 class="text--two"><small>0%</small></h6>
                                </div>
                            </div> `;
                        }
                    }
                    $('#StarPercentageWrapper').html(percentstars);
                });
        }
    });



    // script for updating review

    // script for star coloring
    $(document).on('click', 'label.e_star', (e) => {
        $(e.target).prevAll('label').removeClass('text-dark');
        $(e.target).removeClass('text-dark');
        $(e.target).nextAll('label').addClass('text-dark');
        e_star = $(e.target).attr('id');

        switch (e_star) {
            case 'e_1':
                $('#e_oneStar').click();
                break;
            case 'e_2':
                $('#e_twoStar').click();
                break;
            case 'e_3':
                $('#e_threeStar').click();
                break;
            case 'e_4':
                $('#e_fourStar').click();
                break;
            case 'e_5':
                $('#e_fiveStar').click();
                break;
            default:
                break;
        }
    });
    $(document).on('mouseover', 'label.e_star', e => {
        $(e.target).prevAll('label').removeClass('text-dark');
        $(e.target).removeClass('text-dark');
        $(e.target).nextAll('label').addClass('text-dark');
    })

    $(document).on('mouseleave', 'label.e_star', e => {
        if (e_star == '') {
            $('label.e_star').addClass('text-dark')
            return;
        }
        $(`#${e_star}`).prevAll('label').removeClass('text-dark');
        $(`#${e_star}`).removeClass('text-dark');
        $(`#${e_star}`).nextAll('label').addClass('text-dark');
    })


    // script for recommendation button click
    $(document).on('click', 'input#e_yes', e => {
        $('#e_lblNo').removeClass('bg--two').removeClass("text-white");
        $('#e_lblNo').addClass('bg--four').addClass("text--two");
        $('#e_lblYes').removeClass('bg--four').removeClass("text--two");
        $('#e_lblYes').addClass('bg--two').addClass("text-white");
    })

    $(document).on('click', 'input#e_no', e => {
        $('#e_lblNo').addClass('bg--two').addClass("text-white");
        $('#e_lblNo').removeClass('bg--four').removeClass("text--two");
        $('#e_lblYes').addClass('bg--four').addClass("text--two");
        $('#e_lblYes').removeClass('bg--two').removeClass("text-white");
    })

    $(document).on('submit', '#editReviewForm', () => {
        $(this).ajaxForm({
            beforeSubmit: e_validate,
            beforeSend: () => {
                $('button#editbutton').html('<span class="spinner-border spinner-border-sm mr-1 mt-1"> </span> Updating..').attr('disabled', 'true');
            },
            data: {
                id: $('#lang').data('id')
            },
            uploadProgress: (event, position, total, precentComplete) => {

            },
            complete: (result) => {
                $('button#editbutton').text('Update Review').removeAttr('disabled')

                $('#editModal').modal('hide');
                $("div.modal-backdrop.fade.show").remove();

                $('div#r' + result.responseJSON.id).empty();

                $(`#r${result.responseJSON.id}`).prepend(result.responseJSON.Review);
                $('form#editReviewForm').replaceWith(result.responseJSON.form);
                e_star = '';
                $.get('/CalculateStarsBook', { id: $('#lang').data('id') })
                    .done(result => {
                        $('.StarImg').css('width', (result.average_rate * 100 / 5) + 'px');
                        $('#b_averageRate').text(result.average_rate);
                        $('#averageRate').text(result.average_rate);
                        $('#b_total_rate').text('(' + result.total_review + ')');
                        let percentstars = '';
                        for (x = 1; x <= 5; x++) {
                            if (result.stars[x] != undefined) {
                                percentstars += `
                                <div class="row">
                                    <div class="col-1">
                                        <h6 class="text--two "><small>${x}&nbsp;Star</small></h6>                                
                                    </div>
                                    <div class="col-10">
                                        <div class="progress rounded border  w-100 mx-2">
                                            <div class="progress-bar bg--one" role="progressbar" style="width: ${result.stars[x]}%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-1 pl-2">
                                        <h6 class="text--two"><small> ${result.stars[x]}%</small></h6>
                                    </div>
                                </div>
                                `;
                            } else {
                                percentstars += `
                                <div class="row">
                                    <div class="col-1">
                                        <h6 class="text--two "><small>${x}&nbsp;Star</small></h6>
                                    </div>
                                    <div class="col-10">
                                        <div class="progress rounded border  w-100 mx-2">
                                            <div class="progress-bar bg--one" role="progressbar" style="width: 0%" aria-valuenow="69" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <h6 class="text--two"><small>0%</small></h6>
                                    </div>
                                </div> `;
                            }
                        }
                        $('#StarPercentageWrapper').html(percentstars);
                    });
            }
        })
    })


    $(document).on('click', '.help_yes,.help_no', (e) => {
        $(e.target).removeClass('bg--four').removeClass('text--two');
        $(e.target).addClass('bg--two').addClass('text-white');

        $(e.target).siblings('a').addClass('bg--four').addClass('text--two');
        $(e.target).siblings('a').removeClass('bg--two').removeClass('text-white');
        if (e.target.getAttribute('data-type') == 'yes') {
            $(e.target).siblings('a').addClass('help_no');
            let id = e.target.id;
            let token = $('input[name=_token]').val();
            $.post('helpful', { id: id, helpful: 'yes', _token: token, type: 'book' })
                .done(() => {
                    $(e.target).siblings('a').addClass("help_no");
                    $(e.target).removeClass("help_yes");
                });
        } else {
            $(e.target).siblings('a').addClass('help_yes');
            let id = e.target.id;
            let token = $('input[name=_token]').val();
            $.post('helpful', { id: id, helpful: 'no', _token: token, type: 'book' })
                .done(() => {
                    $('.help_no').siblings('a').addClass("help_yes");
                    $('.help_no').removeClass("help_no");
                });
        }
    });


})


function e_validate() {

    let isValid = true;
    let title = $('#eb_title');
    let body = $('#eb_body');
    if ($(title).val() == '') {
        $(title).css('border-color', 'red')
        isValid = false;
    } else {
        $(title).css('border-color', '')
    }
    if ($(body).val() == '') {
        $(body).css('border-color', 'red')
        isValid = false;
    } else {
        $(body).css('border-color', '')

    }
    if (e_star == '') {
        $('.e_star-error').removeClass('invisible');
        isValid = false;
    } else {
        $('.e_star-error').addClass('invisible');
    }
    return isValid;
}

function validate() {

    let isValid = true;
    let title = $('#b_title');
    let body = $('#b_body');
    if ($(title).val() == '') {
        $(title).css('border-color', 'red')
        isValid = false;
    } else {
        $(title).css('border-color', '')
    }
    if ($(body).val() == '') {
        $(body).css('border-color', 'red')
        isValid = false;
    } else {
        $(body).css('border-color', '')

    }
    if (star == '') {
        $('.star-error').removeClass('invisible');
        isValid = false;
    } else {
        $('.star-error').addClass('invisible');
    }
    return isValid;
}