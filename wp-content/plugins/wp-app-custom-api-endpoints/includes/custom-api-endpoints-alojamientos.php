<?php

function wp_api_get_alojamientos(): array {
    $args = [
      'numberposts' => 9999,
      'post_type' => 'alojamiento'
    ];

    $data = [];
    $i = 0;

    $alojamientos = get_posts( $args );
    write_log($alojamientos);

    foreach( $alojamientos as $alojamiento) {
        $id = $alojamiento->ID;
        $data[$i]['id'] = $alojamiento->ID;
        $data[$i]['title'] = $alojamiento->post_title;
        $data[$i]['comentarios'] = $alojamiento->post_content;
        $data[$i]['slug'] = $alojamiento->post_name;
        $data[$i]['nombre'] = get_field('nombre', $id);
        $data[$i]['direccion'] = get_field('direccion', $id);
        $data[$i]['localidad'] = get_field('localidad', $id);
        $data[$i]['coordenadas'] = get_field('coordenadas', $id);
        $data[$i]['tipo'] = get_field('tipo', $id);
        $data[$i]['puntuacion'] = get_field('puntuacion', $id);
        $data[$i]['foto'] = get_field('foto', $id);
        $data[$i]['web'] = get_field('web', $id);
        $data[$i]['como_llegar'] = get_field('como_llegar', $id);

        $i++;
    }
    return $data;
}

function wp_api_get_alojamiento( $slug ): array {
    $args = [
        'name' => $slug['slug'],
        'post_type' => 'alojamiento'
    ];

    $data = [];
    $i = 0;

    $alojamiento = get_posts( $args );

    $id = $alojamiento[0]->ID;
    $data['id'] = $alojamiento[0]->ID;
    $data['title'] = $alojamiento[0]->post_title;
    $data['comentarios'] = $alojamiento[0]->post_content;
    $data['slug'] = $alojamiento[0]->post_name;
    $data['nombre'] = get_field('nombre', $id);
    $data['direccion'] = get_field('direccion', $id);
    $data['localidad'] = get_field('localidad', $id);
    $data['coordenadas'] = get_field('coordenadas', $id);
    $data['tipo'] = get_field('tipo', $id);
    $data['puntuacion'] = get_field('puntuacion', $id);
    $data['foto'] = get_field('foto', $id);
    $data['web'] = get_field('web', $id);
    $data['como_llegar'] = get_field('como_llegar', $id);

    return $data;
}

function wp_api_get_alojamientos_author( $slug ): array {
    $args = [
        'numberposts' => 9999,
        'post_type' => 'alojamiento',
        'author' => $slug['id'],
    ];

    $data = [];
    $i = 0;

    $alojamientos = get_posts( $args );
    write_log($alojamientos);

    foreach( $alojamientos as $alojamiento) {
        $id = $alojamiento->ID;
        $data[$i]['id'] = $alojamiento->ID;
        $data[$i]['title'] = $alojamiento->post_title;
        $data[$i]['comentarios'] = $alojamiento->post_content;
        $data[$i]['slug'] = $alojamiento->post_name;
        $data[$i]['nombre'] = get_field('nombre', $id);
        $data[$i]['direccion'] = get_field('direccion', $id);
        $data[$i]['localidad'] = get_field('localidad', $id);
        $data[$i]['coordenadas'] = get_field('coordenadas', $id);
        $data[$i]['tipo'] = get_field('tipo', $id);
        $data[$i]['puntuacion'] = get_field('puntuacion', $id);
        $data[$i]['foto'] = get_field('foto', $id);
        $data[$i]['web'] = get_field('web', $id);
        $data[$i]['como_llegar'] = get_field('como_llegar', $id);

        $i++;
    }
    return $data;
}

function wp_api_create_alojamientos( $alojamiento ): string {
    $parameters = $alojamiento->get_params();

    $nuevo_alojamiento = [
        'post_title' => $parameters['post_title'],
        'post_name' => strtolower(str_replace(" ","-", $parameters['post_title'])),
        'post_type' => 'alojamiento',
        'post_content' => empty($parameters['comentario']) ? 'Sin comentarios' : $parameters['comentario'],
        'post_status' => 'publish'
    ];

    $alojamiento_id = wp_insert_post( $nuevo_alojamiento );

    // save ACF fields
    update_field('nombre', !empty($parameters['nombre']) ? ($parameters['nombre']) : $parameters['post_title'] , $alojamiento_id);
    update_field('direccion', !empty($parameters['direccion']) ? ($parameters['direccion']) : 'No hay dirección' , $alojamiento_id);
    update_field('localidad', !empty($parameters['localidad']) ? ($parameters['localidad']) : 'No se ha registrado la localidad' , $alojamiento_id);
    update_field('coordenadas', !empty($parameters['coordenadas']) ? ($parameters['coordenadas']) : ' ' , $alojamiento_id);
    update_field('tipo', !empty($parameters['tipo']) ? ($parameters['tipo']) : 'Hotel' , $alojamiento_id);
    update_field('puntuacion', !empty($parameters['puntuacion']) ? ($parameters['puntuacion']) : 'Sin puntuación' , $alojamiento_id);
    update_field('web', !empty($parameters['web']) ? ($parameters['web']) : 'Sin sitio web' , $alojamiento_id);
    update_field('como_llegar', !empty($parameters['como-llegar']) ? ($parameters['como-llegar']) : ' ' , $alojamiento_id);

    if(empty($parameters['foto'])) {
        // call to API and save the file
        $media_file_url = save_get_media_file();
    } else {
        // save the url passed in the form
        $media_file_url = save_get_media_file($parameters['foto']);
    }

    // if is not a image
    if($media_file_url === false) {
        $media_file_url = save_get_media_file();
    }
    update_field('foto', $media_file_url, $alojamiento_id);


    if( $alojamiento_id != 0 ) {
        return 'Ok';
    }
    return 'KO';
}

add_action( 'rest_api_init' , function() {
    register_rest_route( 'api/v1/', 'alojamientos', [
            'methods' => 'GET',
            'callback' => 'wp_api_get_alojamientos',
        ]
    );

    register_rest_route( 'api/v1/', 'alojamientos/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'wp_api_get_alojamiento',
        )
    );

    register_rest_route( 'api/v1/', 'alojamientos/author/(?P<id>\d+)', [
            'methods' => 'GET',
            'callback' => 'wp_api_get_alojamientos_author',
        ]
    );

    register_rest_route( 'api/v1/' , 'crear-alojamiento', [
            'methods' => 'POST',
            'callback' => 'wp_api_create_alojamientos',
        ]
    );
});
