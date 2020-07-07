<?php
return [
    //apis used for the app
    'apis' => [
        //get shop settings i.e. shop api
        'shopApi' => [
            '/admin/api/2020-04/shop.json'
        ],
        //get all themes api
        'getAllThemes' => [
            '/admin/api/2020-04/themes.json'
        ],
        // //save script tag api
        // 'saveScriptTag' => [
        //     '/admin/api/2020-04/script_tags.json'
        // ],
        // //get single asset of a theme
        // 'getSingleAsset' => [
        //     '/admin/api/2020-04/themes/',
        //     '/assets.json'
        // ],
        // //save single asset of a theme
        // 'saveSingleAsset' => [
        //     '/admin/api/2020-04/themes/',
        //     '/assets.json'
        // ],
        // //delete asset of a theme
        // 'deleteAsset' => [
        //     '/admin/api/2020-04/themes/',
        //     '/assets.json'
        // ],
        //apis for testing purpose

        // get all webhooks
        // 'getWebhooks' => [
        //     '/admin/api/2020-04/webhooks.json'
        // ]

    ],
    // constant string used in the app
    'strings' => [
        // 'app_snippet' => "snippets/alphacurrencyconverter.liquid",
        // 'app_include' => "\n{% comment %}//alpha currency snippet start{% endcomment %}\n {% capture snippet_content %}\n {% include 'alphacurrencyconverter' %} \n{% endcapture %} \n{% unless snippet_check contains 'Liquid error' %}\n {{ snippet_content }}\n {% endunless %}\n {% comment %}//alpha currency snippet end{% endcomment %}\n",
        // 'app_start_identifier' => "\n{% comment %}//alpha currency snippet start{% endcomment %}",
        // 'app_end_identifier' => "{% comment %}//alpha currency snippet end{% endcomment %}\n",
        // 'app_include_before_tag' => "</body>",
        'theme_liquid_file' => "layout/theme.liquid",
        // 'filename' => "assets/alpha_checkout.js",
    ]
];
