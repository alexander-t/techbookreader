import {Router} from './router.js';
import API from "./api";

function getBaseUrl() {
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    if (baseUrl.endsWith('/')) {
        baseUrl = baseUrl.substring(0, -1);
    }
    return baseUrl;
}

$(document).ready(function () {

    var api = API(getBaseUrl());

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

    api.attachMenus('#book-menus');
});