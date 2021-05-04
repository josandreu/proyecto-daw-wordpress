<?php
/**
 * Plugin Name: WP App Plugin Custom Post Types
 * Description: Create custom post types
 * Version: 1.0
 * Author: Jose Andreu
 * Author URI:  https://www.josandreu.com/
 * Text Domain: PCTT
 * Domain Path: /lang
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 **/

// Abort if this file is accessed directly.
if(!defined('ABSPATH')) {
    exit;
}

if(!class_exists('Wp_App_Custom_Post_Types')) {
    class Wp_App_Custom_Post_Types {

        /**
         * Wp_App_Custom_Post_Types constructor.
         */
        public function __construct() {
            require dirname(__FILE__ ) . '/includes/helpers.php';
            require dirname( __FILE__ ) . '/includes/custom-post-type-alojamientos.php';
        }
    }
    $Wp_App_Custom_Post_Types = new Wp_App_Custom_Post_Types();
}
