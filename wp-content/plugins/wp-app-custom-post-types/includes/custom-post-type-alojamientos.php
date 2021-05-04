<?php

add_action( 'init', 'create_alojamiento_cpt', 0 );

add_action( 'admin_menu', 'add_delete_alojamientos_submenu' );

add_action( 'admin_menu', 'add_import_alojamientos_submenu' );

// Add shortcut to the top admin bar menu
add_action ( 'admin_bar_menu', function( $barra_admin ) {
    $barra_admin -> add_menu( array(
        'id'    => 'importar-alojamientos',
        'title' => 'Importar Alojamientos',
        'href'  => 'admin.php?import=csv',
        'meta'  => array(
            'title' => 'Importar alojamientos',
        ),
    ));
}, 100, 1);

// Register Custom Post Type Alojamiento
function create_alojamiento_cpt() {

    $labels = array(
        'name' => _x( 'Alojamientos', 'Post Type General Name', 'cpt_alojamientos' ),
        'singular_name' => _x( 'Alojamiento', 'Post Type Singular Name', 'cpt_alojamientos' ),
        'menu_name' => _x( 'Alojamientos', 'Admin Menu text', 'cpt_alojamientos' ),
        'name_admin_bar' => _x( 'Alojamiento', 'Add New on Toolbar', 'cpt_alojamientos' ),
        'archives' => __( 'Archivos Alojamiento', 'cpt_alojamientos' ),
        'attributes' => __( 'Atributos Alojamiento', 'cpt_alojamientos' ),
        'parent_item_colon' => __( 'Padres Alojamiento:', 'cpt_alojamientos' ),
        'all_items' => __( 'Listado de Alojamientos', 'cpt_alojamientos' ),
        'add_new_item' => __( 'Añadir nuevo Alojamiento', 'cpt_alojamientos' ),
        'add_new' => __( 'Añadir nuevo', 'cpt_alojamientos' ),
        'new_item' => __( 'Nuevo Alojamiento', 'cpt_alojamientos' ),
        'edit_item' => __( 'Editar Alojamiento', 'cpt_alojamientos' ),
        'update_item' => __( 'Actualizar Alojamiento', 'cpt_alojamientos' ),
        'view_item' => __( 'Ver Alojamiento', 'cpt_alojamientos' ),
        'view_items' => __( 'Ver Alojamientos', 'cpt_alojamientos' ),
        'search_items' => __( 'Buscar Alojamiento', 'cpt_alojamientos' ),
        'not_found' => __( 'No se encontraron Alojamientos.', 'cpt_alojamientos' ),
        'not_found_in_trash' => __( 'Ningún Alojamiento encontrado en la papelera.', 'cpt_alojamientos' ),
        'featured_image' => __( 'Imagen destacada', 'cpt_alojamientos' ),
        'set_featured_image' => __( 'Establecer imagen destacada', 'cpt_alojamientos' ),
        'remove_featured_image' => __( 'Borrar imagen destacada', 'cpt_alojamientos' ),
        'use_featured_image' => __( 'Usar como imagen destacada', 'cpt_alojamientos' ),
        'insert_into_item' => __( 'Insertar en Alojamiento', 'cpt_alojamientos' ),
        'uploaded_to_this_item' => __( 'Subido a este Alojamiento', 'cpt_alojamientos' ),
        'items_list' => __( 'Lista de Alojamientos', 'cpt_alojamientos' ),
        'items_list_navigation' => __( 'Navegación por el listado de Alojamientos', 'cpt_alojamientos' ),
        'filter_items_list' => __( 'Lista de Alojamientos filtrados', 'cpt_alojamientos' ),
    );
    $args = array(
        'label' => __( 'Alojamiento', 'cpt_alojamientos' ),
        'description' => __( 'Alojamientos: hoteles, hostales, bed&breakfast...', 'cpt_alojamientos' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-palmtree',
        'supports' => array('title', 'editor', 'excerpt', 'thumbnail', 'author', 'page-attributes', 'post-formats', 'custom-fields'),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type( 'alojamiento', $args );

}

function add_delete_alojamientos_submenu() {
    add_submenu_page(
        'edit.php?post_type=alojamiento', //$parent_slug
        'Eliminar listado de Alojamientos',  //$page_title
        'Eliminar Alojamientos',        //$menu_title
        'manage_options',           //$capability
        'eliminar-alojamientos',//$menu_slug
        'delete_all_alojamientos'//$function
    );
}

function delete_all_alojamientos() {
    $allposts = get_posts( array( 'post_type' => 'alojamiento', 'numberposts' => -1 ) );
    foreach ( $allposts as $eachpost ) {
        wp_delete_post( $eachpost->ID, true );
    }
    echo '<h1 style="font-size: 28px;color: #2271b1;padding-top: 2rem;padding-left: 2rem;"> Listado de Alojamientos borrado </h1>';
}

function add_import_alojamientos_submenu() {
    add_submenu_page(
        'edit.php?post_type=alojamiento', //$parent_slug
        'Importar listado de Alojamientos',  //$page_title
        'Importar Alojamientos',        //$menu_title
        'manage_options',           //$capability
        'importar-alojamientos', //$menu_slug
        'import_all_alojamientos' //$function
    );
}

function import_all_alojamientos() {
    $csv_importer_url = admin_url() . 'admin.php?import=csv';
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <a href=<?php echo $csv_importer_url ?>>Importar Alojamientos</a>
    </div>
    <?php
}
