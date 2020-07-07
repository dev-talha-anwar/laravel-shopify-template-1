(function() {
    if (
        window.location.href.indexOf("/orders/") > -1 ||
        window.location.href.indexOf("/thank_you") > -1
    ) {
        if (sessionStorage.alphastatus && sessionStorage.alphastatus == 1) {
            if (
                getCookie("user_currency") != getCookie("user_currency_default")
            ) {
                var script = document.createElement("script");
                script.onload = function() {
                    let from = getCookie("user_currency_default");
                    var to = getCookie("user_currency");
                    var code = getCookie("user_currency_symbol");
                    alphachange(from, to, code);
                };
                script.src =
                    "https://cdn.shopify.com/s/javascripts/currencies.js";
                document.head.appendChild(script);
            }
        }
        function alphachange(
            from = undefined,
            to = undefined,
            code = undefined
        ) {
            if (from !== undefined && to !== undefined && code !== undefined) {
                cl = [
                    ".skeleton-while-loading",
                    ".skeleton-while-loading--lg",
                    ".emphasis"
                ];
                elements = document.querySelectorAll(cl);
                for (var i = 0; i < elements.length; i++) {
                    str = elements[i].innerHTML;
                    price = parseFloat(str.substr(str.search(/\d/)));
                    if (typeof price == "number") {
                        price = price.toFixed(2);
                        price = Currency.convert(price, from, to);
                        elements[i].innerHTML = code + " " + price.toFixed(2);
                    }
                }
            }
            document.querySelector(
                ".payment-due__currency"
            ).innerHTML = getCookie("user_currency");
        }
    }
    if (
        getCookie("cart_currency") != null &&
        getCookie("user_currency_default") != null
    ) {
        if (getCookie("cart_currency") != getCookie("user_currency_default")) {
            ajaxfunction();
            function ajaxfunction() {
                let data = {
                    form_type: "currency",
                    utf8: "✓",
                    return_to: "/",
                    currency: getCookie("user_currency_default")
                };
                var xhr = new XMLHttpRequest();
                var url = "/cart/update";
                xhr.open("POST", url, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        if (
                            window.location.href.indexOf("/orders/") == -1 &&
                            window.location.href.indexOf("/thank_you") == -1
                        ) {
                            location.reload();
                        }
                    }
                };
                let URLparams = new URLSearchParams(Object.entries(data));
                xhr.send(URLparams);
            }
        }
    }
    function getCookie(name) {
        var cookieArr = document.cookie.split(";");
        for (var i = 0; i < cookieArr.length; i++) {
            var cookiePair = cookieArr[i].split("=");
            if (name == cookiePair[0].trim()) {
                return decodeURIComponent(cookiePair[1]);
            }
        }
        return null;
    }
})();
