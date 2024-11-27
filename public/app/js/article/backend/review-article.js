$(() => {

    // script for Load more Review
    $(document).on('click', '#btn-more', e => {

        $.ajax({
            url: window.location.href,
            type: 'GET',
            data: { book: $('#lang').data('id'), review_id: $('#btn-more').data('review') },
            beforeSend: () => {
                $(e.target).attr('disabled', true);
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

    // script for deleting review
    $(document).on('click', 'button.yes_delete', e => {
        $.ajax({
            url: 'review/' + e.target.getAttribute('data-id'),
            type: 'DELETE',
            data: {
                _token: $('meta[name=csrf-token]').attr('content')
            },
            beforeSend: () => {
                $(e.target).attr('disabled', true);
                $(e.target).html('<span class="spinner-border spinner-border-sm"> </span> Deleting..');
            },
            complete: result => {
                $(`#r${result.responseJSON.id}`).remove();
                $.get('/CalculateStarsArticle', { id: $('#lang').data('id') })
                    .done(result => {
                        $('.StarImg').css('width', (result.average_rate * 100 / 5) + 'px');
                        $('#a_averageRate').text(result.average_rate);
                        $('#averageRate').text(result.average_rate);
                        $('#a_total_rate').text('(' + result.total_review + ')');
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
                            </div>`;
                            }
                        }
                        $('#StarPercentageWrapper').html(percentstars);
                    });
            }
        })
    })
})