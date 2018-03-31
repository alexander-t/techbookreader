import 'bootstrap';
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

    Router.add('#/review/(\\d+)', api.showReview);
    window.onhashchange = Router.update;
    Router.update();

    api.showMenu('#book-menus');
});
