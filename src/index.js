import 'bootstrap';
import {Router} from './router';
import Controller from "./api";

function getBaseUrl() {
    let getUrl = window.location;
    let baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
    if (baseUrl.endsWith('/')) {
        baseUrl = baseUrl.substring(0, -1);
    }
    return baseUrl;
}

$(document).ready(function () {

    let controller = Controller({baseUrl: getBaseUrl(), containerSelector: '#container'});
    Router.add('/', controller.navigateToRoot);
    Router.add('#/title/([a-z0-9_]+)', controller.navigateByTitle);
    Router.add('#/review/(\\d+)', controller.showReview);
    Router.add('#/category/(.*)', controller.showCategory);
    window.onhashchange = Router.update;
    Router.update();

    controller.showMenu('#book-menus');
});
