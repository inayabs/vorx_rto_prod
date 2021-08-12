<?php

return [

    /*
     * A cors profile determines which origins, methods, headers are allowed for
     * a given requests. The `DefaultProfile` reads its configuration from this
     * config file.
     *
     * You can easily create your own cors profile.
     * More info: https://github.com/spatie/laravel-cors/#creating-your-own-cors-profile
     */

     /*
     * You can enable CORS for 1 or multiple paths.
     * Example: ['api/*']
     */
    'paths' => [ 'api/*','login','logout','sanctum/csrf-cookie'],

    /*
    * Matches the request method. `['*']` allows all methods.
    */
    'allowed_methods' => ['*'],

    /*
     * Matches the request origin. `['*']` allows all origins. Wildcards can be used, eg `*.mydomain.com`
     */
    'allowed_origins' => ['*'],

    /*
     * Patterns that can be used with `preg_match` to match the origin.
     */
    'allowed_origins_patterns' => [],

    /*
     * Sets the Access-Control-Allow-Headers response header. `['*']` allows all headers.
     */
    'allowed_headers' => ['*'],

    /*
     * Sets the Access-Control-Expose-Headers response header with these headers.
     */
    'exposed_headers' => [],

    /*
     * Sets the Access-Control-Max-Age response header when > 0.
     */
    'max_age' => 0,

    /*
     * Sets the Access-Control-Allow-Credentials header.
     */
    'supports_credentials' => true,



    // 'cors_profile' => Spatie\Cors\CorsProfile\DefaultProfile::class,

    /*
     * This configuration is used by `DefaultProfile`.
     */
    // 'default_profile' => [

    //     'allow_credentials' => false,

    //     'allow_origins' => [
    //         '*',
    //     ],

    //     'allow_methods' => [
    //         'POST',
    //         'GET',
    //         'OPTIONS',
    //         'PUT',
    //         'PATCH',
    //         'DELETE',
    //     ],

    //     'allow_headers' => [
    //         'Content-Type',
    //         'X-Auth-Token',
    //         'Origin',
    //         'Authorization',
    //     ],

    //     'expose_headers' => [
    //         'Cache-Control',
    //         'Content-Language',
    //         'Content-Type',
    //         'Expires',
    //         'Last-Modified',
    //         'Pragma',
    //     ],

    //     'forbidden_response' => [
    //         'message' => 'Forbidden (cors).',
    //         'status' => 403,
    //     ],

    //     /*
    //      * Preflight request will respond with value for the max age header.
    //      */
    //     'max_age' => 60 * 60 * 24,
    // ],
];
