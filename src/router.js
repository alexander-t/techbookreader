var Router = (function () {
    var routes = [];

    var add = function (route, handler) {
        routes.push({route: route, handler: handler});
    };

    var update = function () {
        var fragment = getFragment();
        for (var i = 0; i < routes.length; i++) {
            var match = fragment.match(routes[i].route + '$');
            if (match) {
                match.shift();
                routes[i].handler.apply({}, match);
                return;
            }
        }
    };

    var getFragment = function () {
        var match = window.location.href.match(/(#.*)$/);
        return match ? match[1] : '';
    };

    return {
        add: add,
        update: update
    };
})();

export {Router};
