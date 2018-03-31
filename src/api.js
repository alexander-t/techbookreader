export default function (baseUrl) {

    const API_URL = baseUrl + '/api';

    let showMenu = function (selector) {
        $.getJSON(API_URL + '/menu', function (menus) {
            let menusHtml = '';
            for (let m = 0; m < menus.length; m++) {
                let menuHtml = '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + menus[m].menu + '</a><div class="dropdown-menu" aria-labelledby="navbarDropdown">';
                for (let i = 0; i < menus[m].items.length; i++) {
                    let item = menus[m].items[i];
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

    let showReview = function (reviewId) {
        $.getJSON(API_URL + '/reviews/' + reviewId, function (review) {
            $('#review_body').show();
            $('#review_title').text(review.title);
            $('#review_author').text('by ' + review.author);
            $('#review_summary').html(review.summary);
            $('#review_opinion').html(review.opinion);
        });
    };

    let showCategory = function (category) {
        $.getJSON(API_URL + '/categories?name=' + category, function (reviews) {
            $('#review_body').show().empty();
            for (let i = 0; i < reviews.length; i++) {
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
