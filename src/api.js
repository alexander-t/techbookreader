const reviewTemplate = require("./review.handlebars");
const bookTemplate = require("./book.handlebars");

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
        if (reviewId) {
            $.getJSON(API_URL + '/reviews/' + reviewId, function (review) {
                renderReview(review);
            });
        }
    };

    let navigateByTitle = function (title) {
        if (title) {
            $.getJSON(API_URL + '/reviews?title=' + title, function (review) {
                renderReview(review);
            });
        }
    };

    let showCategory = function (category) {
        $.getJSON(API_URL + '/categories?name=' + category, function (reviews) {
            if (reviews) {
                let galleryHtml = '<div class="row">';
                for (var i = 1; i <= reviews.length; i++) {
                    let review = reviews[i - 1];
                    let context = {title: review.title, image: 'images/covers/' + review.image};
                    galleryHtml += bookTemplate(context);
                    if (i % 4 === 0) {
                        galleryHtml += '</div><div class="row">';
                    }
                }

                if (i % 4 !== 0) {
                    galleryHtml += '</div>';
                }
                $("#container").html(galleryHtml);
            }
        });
    };

    // ----- PRIVATE -----
    let renderReview = function (review) {
        let context = {
            image: 'images/covers/' + review.image,
            title: review.title,
            author: review.author,
            opinion: review.opinion
        };
        if (review.summary) {
            context['summary'] = review.summary;
        }
        $("#container").html(reviewTemplate(context));
    };

    return {
        showMenu: showMenu,
        showReview: showReview,
        showCategory: showCategory,
        navigateByTitle: navigateByTitle
    }
}
