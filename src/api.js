const aboutTemplate = require('./about.handlebars');
const reviewTemplate = require("./review.handlebars");
const bookTemplate = require("./book.handlebars");
const menuTemplate = require("./menu.handlebars");

export default function (initParams) {

    const API_URL = initParams.baseUrl + '/api';
    const CONTAINER_SELECTOR = initParams.containerSelector;

    let navigateToRoot = function () {
        $(CONTAINER_SELECTOR).html(aboutTemplate());
    };

    let showMenu = function (selector) {
        $.getJSON(API_URL + '/menu', function (menus) {
            $(selector).replaceWith(menuTemplate(menus));
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

    let showCategory = function (categoryName) {
        $.getJSON(API_URL + '/categories?name=' + categoryName, function (category) {
            let reviews = category.books;
            if (reviews) {
                let galleryHtml = '<h1>' + category.category + '</h1><div class="row">';
                let i;
                for (i = 1; i <= reviews.length; i++) {
                    let review = reviews[i - 1];
                    let context = {
                        title: review.title,
                        reviewDate: new Date(review.reviewed).toLocaleString('en-us', {month: 'long', year: 'numeric'}),
                        image: 'images/covers/' + review.image,
                        reviewLink: '#/review/' + review.id
                    };
                    galleryHtml += bookTemplate(context);
                    if (i % 4 === 0) {
                        galleryHtml += '</div><div class="row">';
                    }
                }

                if (i % 4 !== 0) {
                    galleryHtml += '</div>';
                }
                $(CONTAINER_SELECTOR).html(galleryHtml);
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
        $(CONTAINER_SELECTOR).html(reviewTemplate(context));
    };

    return {
        navigateToRoot: navigateToRoot,
        showMenu: showMenu,
        showReview: showReview,
        showCategory: showCategory,
        navigateByTitle: navigateByTitle
    }
}
