export default function (baseUrl) {

    var API_URL = baseUrl + '/api';

    var showMenu = function (selector) {
        $.getJSON(API_URL + '/menu', function (menus) {
            var menusHtml = '';
            for (var m = 0; m < menus.length; m++) {
                var menuHtml = '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + menus[m].menu + '</a><div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                for (var i = 0; i < menus[m].items.length; i++) {
                    var item = menus[m].items[i];
                    if (item.hasOwnProperty('item')) {
                        menuHtml += '<a class="dropdown-item" href="#/category/' + item.category + '">' + item.item + '</a>'
                    } else if (item.hasOwnProperty("separator")) {
                        menuHtml += '<div class="dropdown-divider"></div>';
                    }
                }
                menuHtml += '</div></li>';
                menusHtml += menuHtml;
            }
            $(selector).replaceWith(menusHtml);
        });
    };

    var showReview = function (reviewId) {
        $.getJSON(API_URL + '/reviews/' + reviewId, function (review) {
            $('#review_body').show();
            $('#review_title').text(review.title);
            $('#review_author').text('by ' + review.author);
            $('#review_summary').html(review.summary);
            $('#review_opinion').html(review.opinion);
        });
    };

    var showCategory = function (category) {
        $.getJSON(API_URL + '/categories?name=' + category, function (reviews) {
            $('#review_body').show().empty();
            for (var i = 0; i < reviews.length; i++) {
                $('#review_body').append('<p><a href="' + API_URL + reviews[i].href + '">' + reviews[i].title + '</a></p>');
            }
        });
    };

    return {
        showMenu: showMenu,
        showReview: showReview,
        showCategory: showCategory
    }
}
