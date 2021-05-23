<?php
define( 'THEME_DIR', get_stylesheet_directory() );
define( 'THEME_URI', get_stylesheet_directory_uri() );
define('THEME_VERSION', time());

add_action('init', 'handle_preflight');
function handle_preflight() {
    $origin = get_http_origin();
    var_dump($origin);
    if ($origin === 'https://www.proyecto-wp-api.tk') {
        header("Access-Control-Allow-Origin: " . HEADLESS_FRONTEND_URL);
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
        if ('OPTIONS' == $_SERVER['REQUEST_METHOD']) {
            status_header(200);
            exit();
        }
    }
}
