<?php
/**
 * Plugin Name: WP App Plugin Custom API Endpoints
 * Description: Create custom endpoints for Wordpress REST API
 * Version: 1.0
 * Author: Jose Andreu
 * Author URI:  https://www.josandreu.com/
 * Text Domain: PCTT
 * Domain Path: /lang
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 **/

if( !defined( 'ABSPATH' ) ) {
    exit();
}

if( !class_exists( 'Wp_App_Custom_Api_Endpoints' ) ) {
    class Wp_App_Custom_Api_Endpoints {

        /**
         * Wp_App_Custom_Api_Endpoints constructor.
         */
        public function __construct() {
            require dirname( __FILE__ ) . '/includes/helpers.php';
            require dirname( __FILE__ ) . '/includes/custom-api-endpoints-alojamientos.php';
        }
    }
    $Wp_App_Custom_Api_Endpoints = new Wp_App_Custom_Api_Endpoints();
}

