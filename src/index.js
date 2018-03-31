import 'bootstrap';
import {Router} from './router';
import Controller from "./api";

function getBaseUrl() {
    var getUrl = window.location;
    var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    if (baseUrl.endsWith('/')) {
        baseUrl = baseUrl.substring(0, -1);
    }
    return baseUrl;
}

$(document).ready(function () {

    var controller = Controller(getBaseUrl());

    Router.add('#', function() {$("#container").html($("#template_narrow").html())});
    Router.add('#/review/(\\d+)', controller.showReview);
    Router.add('#/category/(.*)', controller.showCategory);
    window.onhashchange = Router.update;
    Router.update();

    controller.showMenu('#book-menus');
});
