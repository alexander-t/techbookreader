function attachMenus(selector) {
    $.getJSON('https://techbookreader.com/beta/api/menu', function (menus) {
        var menusHtml = '';
        for (var m = 0; m < menus.length; m++) {
            var menuHtml = '<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + menus[m].menu + '</a><div class="dropdown-menu" aria-labelledby="navbarDropdown">';
            for (var i = 0; i < menus[m].items.length; i++) {
                var item = menus[m].items[i];
                if (item.hasOwnProperty('item')) {
                    menuHtml += '<a class="dropdown-item" href="#">' + item.item + '</a>'
                } else if (item.hasOwnProperty("separator")) {
                    menuHtml += '<div class="dropdown-divider"></div>';
                }
            }
            menuHtml += '</div></li>';
            menusHtml += menuHtml;
        }
        $(selector).replaceWith(menusHtml);
    });
}