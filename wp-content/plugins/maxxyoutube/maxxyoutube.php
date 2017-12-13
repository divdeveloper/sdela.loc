<?php
/*
Plugin Name: maxxyoutube
Description: maxxyoutube Plugin.
Version: 1.0.0
Author: A.Bodnarashek
License: GPL
*/

function maxx_youtube() {
    @include dirname( __FILE__ ) . '/front.php';
}

if ( is_admin() ) {

}
else
{
    add_shortcode( 'MAXX_YOUTUBE', 'maxx_youtube' );
}


add_action('wp_enqueue_scripts','enqueue_our_required_stylesheets');

function enqueue_our_required_stylesheets(){
    wp_enqueue_style( 'upload_video', plugins_url( '/upload_video.css', __FILE__ ) );
    
    //wp_register_script('plusone', '//apis.google.com/js/client:plusone.js', array('jquery'), '1.0');
    //wp_enqueue_script('plusone');        
    //wp_enqueue_script( 'cors_upload', plugin_dir_url( __FILE__ ) . 'cors_upload.js', array('jquery'), '1.0' );
    //wp_enqueue_script( 'upload_video', plugin_dir_url( __FILE__ ) . 'upload_video.js', array('jquery', 'cors_upload'), '1.0' );
 
}
?>