<?php
/*
Plugin Name: Video Uploader
Version: 0.1.0
Author: A.Bodnarashek
*/

function su_image_form_html(){
    ob_start();
    ?>

    <?php
    $output = ob_get_clean();
    return $output;
}
add_shortcode('image_form', 'su_image_form_html');

function su_load_scripts() {
    wp_enqueue_style( 'progressbar', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css' );
    wp_enqueue_style( 'progressbartheme', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.css' );
    wp_enqueue_style( 'wp-mediaelement' );
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'jquery-ui-progressbar');
    wp_enqueue_script('wp-mediaelement');
    wp_enqueue_script('image-form-js', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'), '0.1.0', true);

    $data = array(
                'upload_url' => admin_url('async-upload.php'),
                'ajax_url'   => admin_url('admin-ajax.php'),
                'nonce'      => wp_create_nonce('media-form')
            );

    wp_localize_script( 'image-form-js', 'su_config', $data );
}
add_action( 'admin_enqueue_scripts', 'su_load_scripts' );
add_action('wp_enqueue_scripts', 'su_load_scripts');

function su_image_submission_cb() {
    $attachment_id   = filter_var( $_POST['image_id'], FILTER_VALIDATE_INT );
    $file = wp_get_attachment_url( $attachment_id );


        wp_send_json_success( array('file' => $file) );
}
add_action('wp_ajax_image_submission', 'su_image_submission_cb');
