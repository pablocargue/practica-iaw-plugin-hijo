<?php
/**
 * Plugin Name: pabcar - Utilidades
 * Description: Funcionalidades a medida para el blog de Pablo.
 * Version:     1.1.0
 * Author:      Pablo Carmona
 */

// Evita que se ejecute el archivo directamente desde el navegador
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* =================================================================
   Petición 3: Caja al final de las entradas
================================================================= */

add_filter( 'the_content', 'pabcar_caja_contacto_entrada' );

function pabcar_caja_contacto_entrada( $content ) {
    // Comprueba que estamos en una entrada individual, en la consulta principal y dentro del loop
    if ( is_singular( 'post' ) && is_main_query() && in_the_loop() ) {
        $caja_html = '<div class="caja-contacto-entrada">';
        $caja_html .= '<p>¿Te ha gustado? <a href="' . esc_url( home_url( '/contacto/' ) ) . '">Escríbeme desde Contacto</a></p>';
        $caja_html .= '</div>';

        return $content . $caja_html;
    }

    return $content;
}

/* =================================================================
   Petición 4: Código corto [anio]
================================================================= */

add_shortcode( 'anio', 'pabcar_obtener_anio_actual' );

function pabcar_obtener_anio_actual() {
    return wp_date( 'Y' );
}

/* =================================================================
   Petición 5: Ocultar la versión de WordPress
================================================================= */

// Quita el <meta name="generator"> de la cabecera HTML
remove_action( 'wp_head', 'wp_generator' );

/* =================================================================
   Petición 6: Personalizar la pantalla de acceso (wp-login.php)
================================================================= */

// 1. El logotipo enlaza a la portada del blog
add_filter( 'login_headerurl', 'pabcar_login_logo_url' );

function pabcar_login_logo_url() {
    return home_url();
}

// 2. Texto informativo del logotipo
add_filter( 'login_headertext', 'pabcar_login_logo_texto' );

function pabcar_login_logo_texto() {
    return get_bloginfo( 'name' );
}

// 3. Aviso sobre el formulario de acceso
add_filter( 'login_message', 'pabcar_login_mensaje_aviso' );

function pabcar_login_mensaje_aviso( $message ) {
    $nombre_blog = get_bloginfo( 'name' );
    $aviso_html = '<p class="message mensaje-aviso">Acceso restringido al equipo de <strong>' . esc_html( $nombre_blog ) . '</strong></p>';

    return $message . $aviso_html;
}

