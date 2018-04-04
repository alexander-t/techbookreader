const Router = (function () {
    let routes = [];

    let add = function (route, handler) {
        routes.push({route: route, handler: handler});
    };

    let update = function () {
        let fragment = getFragment();

        for (let i = 0; i < routes.length; i++) {
            let match = fragment ? fragment.match(routes[i].route + '$') : window.location.href.match(routes[i].route + '$');
            if (match) {
                match.shift();
                routes[i].handler.apply({}, match);
                return;
            }
        }
    };

    let getFragment = function () {
        let match = window.location.href.match(/(#.*)$/);
        return match ? match[1] : '';
    };

    return {
        add: add,
        update: update
    };
})();

export {Router};
