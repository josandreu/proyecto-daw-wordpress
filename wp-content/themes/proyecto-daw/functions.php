<?php
define( 'THEME_DIR', get_stylesheet_directory() );
define( 'THEME_URI', get_stylesheet_directory_uri() );
define('THEME_VERSION', time());

function get_current_user_id_jwt() {
    if (!class_exists('Jwt_Auth_Public'))
        return false;

    $jwt = new \Jwt_Auth_Public('jwt-auth', '1.1.0');
    $token = $jwt->validate_token(false);
    if (\is_wp_error($token))
        return false;
    return $token->data->user->id;
}

function jwt_auth_function($data, $user) {
    $data['user_role'] = $user->roles;
    $data['user_id'] = $user->ID;
    $data['avatar']= get_avatar_url($user->ID);
    return $data;
}
add_filter( 'jwt_auth_token_before_dispatch', 'jwt_auth_function', 10, 2 );
