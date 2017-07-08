

(function($) {
    $.fn.goTo = function () {
        $('html, body').animate({
            scrollTop: $(this).offset().top + 'px'
        }, 'slow');
        return this; // for chaining...
    };
})(jQuery);


$(function () {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
});

$('.remote-selector').selectize({
    plugins: ['remove_button'],
    valueField: 'PlaceId',
    labelField: 'PlaceName',
    searchField: ['PlaceId', 'CountryName', 'CityId', 'PlaceName'],
    options: [],
    persist: false,
    loadThrottle: 300,
    create: false,
    allowEmptyOption: false,
    preload: 'focus',
    render: {
        option: function(item, escape) {
            console.log(item);
            return '<div class="question-selector">' +
                '<span class="title">' +
                '<span class="name"><i style="color: #2b1bb9" class="fa fa-fighter-jet"></i> <b>' + escape(item.CountryName) + '</b>,  ' + escape(item.PlaceName) + '</span>' +
                '</span>' +
                '</div>';
        }
    },
    load: function (query, callback) {

        $.ajax({
            url: '/api/search-destination',
            type: 'GET',
            dataType: 'json',
            data: {
                q: query,
            },
            error: function () {
                callback();
            },
            success: function (res) {
                callback(res);
            }
        });
    }
});


$(document).on('click', '[data-upvote]', function () {
    $.ajax({
        url: '/api/add-vote',
        type: 'POST',
        dataType: 'json',
        data: {
            flight_id: $(this).attr('data-upvote'),
        },
        success: function(data) { // 200 Status Header
            document.dispatchEvent(new CustomEvent('updateView'));
        },
        error: function(data) { // 500 Status Header

            console.log(data.status);
            if (data.status == 200) {
                document.dispatchEvent(new CustomEvent('updateView'));
            } else {

                console.log('error');
                alert('Woops, you already voted for this');
            }
        },
    });
});


$(document).on('click', '[data-downvote]',  function () {
    $.ajax({
        url: '/api/add-vote',
        type: 'POST',
        dataType: 'json',
        data: {
            flight_id: $(this).attr('data-downvote'),
            negative: $(this).attr('data-downvote'),
        },
        success: function(data) { // 200 Status Header
        },
        error: function(data) { // 500 Status Header

            if (data.status == 200) {
                document.dispatchEvent(new CustomEvent('updateView'));
            } else {

                console.log('error');
                alert('Woops, you already voted for this');
            }

        },
    });
});

setInterval(updateView,15000);
document.addEventListener('updateView', updateView, false);


function updateView()
{
    if ($('[data-group]').length) {

        $.ajax({
            url: '/api/refresh',
            type: 'POST',
            dataType: 'json',
            data: {
                pid: $('[data-group]').attr('data-group'),
            },
            error: function () {
            },
            success: function (res) {

                console.log(res);
                $('#body').empty().prepend((res.html));
            }
        });
    }
}