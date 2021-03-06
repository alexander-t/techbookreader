EDITOR = (function () {

        var getBaseUrl = function () {
            var getUrl = window.location;
            var baseUrl = getUrl.protocol + "//" + getUrl.host;
            if (baseUrl.endsWith('/')) {
                baseUrl = baseUrl.substring(0, -1);
            }
            return baseUrl;
        };

        var apiUrl = getBaseUrl() + '/api';
        var reviewId;

        var init = function () {

            // Currently inlined like this because it's not trivial to set CSS on an iframe.
            var iFrameCss = {
                'font-family': '"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif',
                'color': 'rgb(73, 80, 87)'
            };

            $('#summary').contents().get(0).designMode = 'on';
            $('#summary').contents().find("body").css(iFrameCss);

            $('#opinion').contents().get(0).designMode = 'on';
            $('#opinion').contents().find("body").css(iFrameCss);

            $('#clear-summary-button').click(function () {
                $('#summary').contents().find("body").html('')
            });
        };

        var loadReview = function (id) {
            $.ajax({
                url: apiUrl + '/reviews/' + id,
                contentType: "application/json; charset=utf-8",
                dataType: "json"
            }).done(function (review) {
                reviewId = review.id;
                displayReview(review);
                feedbackSuccess('Load successful.');
            }).fail(function () {
                feedbackError('Failed to load review!');
            });
        };

        var saveReview = function () {
            var review = {
                id: reviewId,
                title: $('#title').val().trim(),
                author: $('#author').val().trim(),
                publication_year: $('#publication_year').val().trim(),
                reviewed: $('#reviewed').val().trim(),
                is_classic: $('#is_classic').is(":checked"),
                summary: $('#summary').contents().find("body").html().trim(),
                opinion: $('#opinion').contents().find("body").html().trim()
            };

            $.ajax({
                url: apiUrl + '/cms',
                method: 'POST',
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: JSON.stringify(review)
            }).done(function (data) {
                feedbackSuccess('Save successful.');
            }).fail(function () {
                feedbackError('Save failed!');
            });
        };

        // --------- Private ---------- //

        var displayReview = function (review) {
            $('#title').val(review.title);
            $('#author').val(review.author);
            $('#publication_year').val(review.publication_year);
            $('#reviewed').val(review.reviewed);
            $('#is_classic').prop('checked', review.is_classic);
            $('#summary').contents().find("body").html(review.summary);
            $('#opinion').contents().find("body").html(review.opinion);
        };


        var feedbackSuccess = function (message) {
            $('#opStatus')
                .attr('class', 'alert alert-success')
                .html(message).slideUp(0).slideDown(300).delay(1000).slideUp(300);
        };

        var feedbackError = function (message) {
            $('#opStatus')
                .attr('class', 'alert alert-danger')
                .html(message).slideUp(0).slideDown(300);
        };

        return {
            init: init,
            loadReview: loadReview,
            saveReview: saveReview
        };
    }
)();

$(function () {
    EDITOR.init();

    $('#loadButton').click(function () {
        EDITOR.loadReview(prompt('id'));
    });

    $('#saveButton').click(function () {
        EDITOR.saveReview();
    });
});
