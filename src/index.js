import {attachMenus} from './menu.js';
import {Router} from './router.js';

$(document).ready(function () {

    Router.add('#/review/(\\d+)', function (reviewId) {
        $.getJSON('https://techbookreader.com/beta/api/review/' + reviewId, function (review) {
            $('#review_body').show();
            $('#review_title').text(review.title);
            $('#review_author').text('by ' + review.author);
            $('#review_summary').html(review.summary);
            $('#review_opinion').html(review.opinion);
        });
    });
    window.onhashchange = Router.update;
    Router.update();

    attachMenus('#book-menus');
});