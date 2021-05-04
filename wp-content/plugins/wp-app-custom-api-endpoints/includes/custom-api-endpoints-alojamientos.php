<?php

function wp_appi_get_alojamientos(): array {
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

function wp_appi_get_alojamiento( $slug ): array {
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

add_action( 'rest_api_init' , function() {
    register_rest_route( 'wp/v2/', 'alojamientos', [
            'methods' => 'GET',
            'callback' => 'wp_appi_get_alojamientos',
        ]
    );

    register_rest_route( 'wp/v2/', 'alojamientos/(?P<slug>[a-zA-Z0-9-]+)', array(
        'methods' => 'GET',
        'callback' => 'wp_appi_get_alojamiento',
    ) );
});
