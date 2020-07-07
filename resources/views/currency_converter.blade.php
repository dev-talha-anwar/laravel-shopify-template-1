<select name="currency" id="alphaselect" style="position: fixed;bottom: 0;left: 0;display: none;">
    @foreach($countries as $country)
    <option value="{{ $country->name }}" data-symbol="{{ $country->currency_symbol }}"
        data-code="{{ $country->currency_code }}">
        {{ $country->name }}
    </option>
    @endforeach
</select>
<script class="alphaCurrencyScript">
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("localization_form").remove();
        if (sessionStorage.alphastatus) {
            run();
        } else {
            var xhr = new XMLHttpRequest();
            var url = "{{ route('status','') }}/";
            url += Shopify.shop;
            xhr.open("GET", url, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    let response = JSON.parse(this.responseText);
                    if (response.status) {
                        sessionStorage.alphastatus = 1;
                        run();
                    }
                }
            };
            xhr.send();
        }
    });

    function run() {
        count = 0;
        let files = [{
                key: "jQuery",
                src: "https://code.jquery.com/jquery-3.5.1.min.js"
            },
            {
                key: "Cookies",
                src: "https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"
            },
            {
                key: "Currency",
                src: "https://cdn.shopify.com/s/javascripts/currencies.js"
            }
        ];
        files.forEach(function (element, index) {
            let key = element.key;
            if (!window.hasOwnProperty(key)) {
                loadJs(
                    element.src,
                    document.getElementsByClassName("alphaCurrencyScript")[0],
                    "beforeBegin"
                );
            } else {
                count++;
            }
        });
        let inter = setInterval(checkcount, 1000);

        function checkcount() {
            if (count == files.length) {
                let count = 0;
                files.forEach(function (element, index) {
                    let key = element.key;
                    if (window.hasOwnProperty(key)) {
                        count++;
                    }
                });
                if (count == files.length) {
                    clearInterval(inter);
                    geolocation();
                }
            }
        }

        function geolocation() {
            if (!Cookies.get("user_currency_country")) {
                $.get("{{ route('geolocationstatus','') }}/" + Shopify.shop, function (response) {
                    if (response.status) {
                        $.get("https://ipapi.co/json/", function (response) {
                            afterload({
                                country_name: response.country_name,
                                currency: response.currency
                            });
                        });
                    } else {
                        afterload();
                    }
                });
            }else{
                afterload();
            }
        }

        function afterload(geoloc = undefined) {
            jQuery(document).ready(function ($) {
                geoflag = false;
                if (geoloc) {
                    if($(`#alphaselect option[value="${geoloc.country_name}"]`).length > 0){
                        geoflag = true; 
                    }
                }
                if (!Cookies.get("user_currency_country")) {
                    if(geoflag){
                        Cookies.set("user_currency_country", geoloc.country_name);
                        Cookies.set("user_currency", geoloc.currency);
                        Cookies.set("user_currency_default", "{{ $currency }}");
                    }else{
                        Cookies.set("user_currency_country", "{{ $country_name }}");
                        Cookies.set("user_currency", "{{ $currency }}");
                        Cookies.set("user_currency_default", "{{ $currency }}");
                    }
                }
                $("#alphaselect").val(Cookies.get("user_currency_country"));
                $("#alphaselect").show();
                if (!Cookies.get("user_currency_symbol")) {
                    Cookies.set(
                        "user_currency_symbol",
                        $("#alphaselect option:selected").data("symbol")
                    );
                }
                if (Cookies.get("user_currency_country")) {
                    $("#alphaselect option").each(function (index, e) {
                        if ($(this).val() == Cookies.get("user_currency_country")) {
                            $(e).prop("selected", true);
                        }
                    });
                }
                if (Cookies.get("user_currency") != Cookies.get("cart_currency")) {
                    let from = Cookies.get("cart_currency");
                    var to = Cookies.get("user_currency");
                    $("#alphaselect").val(Cookies.get("user_currency_country"));
                    var code = $("#alphaselect option:selected").data("symbol");
                    alphachange(from, to, code);
                }
                $(document).on(
                    "DOMNodeInserted",
                    'form[action="/cart"],.product-recommendations,button[data-testid="Checkout-button"]',
                    function (e) {
                        alphaotherchange(e);
                    }
                );
                $(document).on(
                    "DOMSubtreeModified",
                    'form[action="/cart"],.product-single__meta .product__price',
                    function (e) {
                        alphaotherchange(e);
                    }
                );

                function alphaotherchange(e) {
                    let from = Cookies.get("user_currency_default");
                    var to = Cookies.get("user_currency");
                    var code = Cookies.get("user_currency_symbol");
                    $(e.target)
                        .find(".alphamoney")
                        .each(function () {
                            str = $(this).html();
                            price = parseFloat(str.substr(str.search(/\d/)));
                            str = str.replace(price, "");
                            str = str.trim();
                            price = parseFloat(price);
                            if (typeof price == "number") {
                                price = price.toFixed(2);
                                price = Currency.convert(price, from, to);
                                if (str != code) {
                                    $(this).html(code + " " + price.toFixed(2));
                                }
                            }
                        });
                }
                // on load change currency
                $("#alphaselect").on("change", function () {
                    let from = Cookies.get("user_currency");
                    var to = $("#alphaselect option:selected").data("code");
                    var code = $("#alphaselect option:selected").data("symbol");
                    alphachange(from, to, code);
                    Cookies.set(
                        "user_currency",
                        $("#alphaselect option:selected").data("code"), {
                            expires: 20,
                            path: "/"
                        }
                    );
                    Cookies.set(
                        "user_currency_symbol",
                        $("#alphaselect option:selected").data("symbol"), {
                            expires: 20,
                            path: "/"
                        }
                    );
                    Cookies.set(
                        "user_currency_country",
                        $("#alphaselect option:selected").val(), {
                            expires: 20,
                            path: "/"
                        }
                    );
                });

                function alphachange(
                    from = undefined,
                    to = undefined,
                    code = undefined
                ) {
                    if (
                        from != undefined &&
                        to != undefined &&
                        code != undefined
                    ) {
                        $(".alphamoney").each(function () {
                            str = $(this).html();
                            price = parseFloat(str.substr(str.search(/\d/)));
                            if (typeof price == "number") {
                                price = price.toFixed(2);
                                price = Currency.convert(price, from, to);
                                $(this).html(code + " " + price.toFixed(2));
                            }
                        });
                    }
                }
                $(window).on("load", function () {
                    setTimeout(function () {
                        let str =
                            '<button type="button" id="alphabuyitnowbutton" class="shopify-payment-button__button shopify-payment-button__button--unbranded" >Buy it now</button>';
                        $('button[data-testid="Checkout-button"]').after(str);
                        $('button[data-testid="Checkout-button"]').remove();
                        $("#alphabuyitnowbutton").on("click", function () {
                            $("#alphabuyitnowbutton").addClass("disabled");
                            $.post(
                                "/cart/add.js",
                                $('form[action="/cart/add"]').serialize(),
                                function (response) {
                                    ajaxfunction($(this), 3);
                                },
                                "json"
                            );
                        });
                    }, 2000);
                });
                $(document).on("click", "form[action='/checkout']", function (
                    e
                ) {
                    e.preventDefault();
                    ajaxfunction($(this), 1);
                });
                $(document).on("click", "[name='checkout']", function (e) {
                    e.preventDefault();
                    ajaxfunction($(this), 2);
                });
                $(document).on("click", "a[href='/checkout']", function (e) {
                    e.preventDefault();
                    ajaxfunction($(this), 3);
                });

                function ajaxfunction(e, type) {
                    let data = {
                        form_type: "currency",
                        utf8: "✓",
                        return_to: "/",
                        currency: Cookies.get("user_currency")
                    };
                    $.ajax({
                        type: "POST",
                        url: "/cart/update",
                        data: $.param(data),
                        success: function (data) {
                            switch (type) {
                                case 1:
                                    $("form[action='/checkout']").submit();
                                case 2:
                                    location.href = "/checkout";
                                case 3:
                                    location.href = "/checkout";
                            }
                        }
                    });
                }
                if (
                    getCookie("cart_currency") != null &&
                    getCookie("user_currency_default") != null
                ) {
                    if (
                        getCookie("cart_currency") !=
                        getCookie("user_currency_default")
                    ) {
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
                            xhr.onreadystatechange = function () {
                                if (
                                    xhr.readyState === 4 &&
                                    xhr.status === 200
                                ) {
                                    if (
                                        window.location.href.indexOf(
                                            "/orders/"
                                        ) == -1 &&
                                        window.location.href.indexOf(
                                            "/thank_you"
                                        ) == -1
                                    ) {
                                        location.reload();
                                    }
                                }
                            };
                            let URLparams = new URLSearchParams(
                                Object.entries(data)
                            );
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
            });
        }

        function loadJs(url, element = document.body, position) {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.src = url;
            script.load = count++;
            element.insertAdjacentElement(position, script);
        }
    }

</script>