<?php

/**
 * Save message to log file
 */
if (!function_exists('write_log')) {
    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }
}


if ( !function_exists('save_get_media_file' ) ) {
    function save_get_media_file( $url = 'https://source.unsplash.com/800x600/?hotel' ) {
        $arg = array ( 'method' => 'GET');
        $response = wp_remote_request ( $url , $arg );

        // Check for error
        if ( is_wp_error( $response ) ) {
            return false;
        }

        $type = wp_remote_retrieve_header( $response, 'content-type' );
        //$image_name = wp_remote_retrieve_header( $response, 'x-imgix-id' ) . '.jpg';
        $image_type = explode( '/', $type )[1];

        if( check_image_type($image_type) === false ) {
            return false;
        }

        $unique_name = date( 'dmY' ).''.( int ) microtime( true );
        $image_name = $unique_name . '.' . $image_type;

        $data_response = wp_remote_retrieve_body( $response );

        // Check for error
        if ( is_wp_error( $data_response ) ) {
            return false;
        }

        // Mirror this image in your upload dir
        $mirror = wp_upload_bits( basename( $image_name ) , '', $data_response );

        // Attachment options
        $attachment = array(
            'post_title'=> basename( $image_name ),
            'post_mime_type' => $type
        );

        // Add the image to your media library (won't be attached to a post)
        $attach_id = wp_insert_attachment( $attachment, $mirror['file'] );
        $imagenew = get_post( $attach_id );
        $fullsizepath = get_attached_file( $imagenew->ID );

        return wp_get_attachment_url($attach_id);
    }
}

if( !function_exists( 'check_image_type' ) ) {
    function check_image_type( $image_type ) {
        if( $image_type == 'jpg' || $image_type == 'jpeg' || $image_type == 'png' || $image_type == 'gif' ) {
            return true;
        }
        return false;
    }
}
