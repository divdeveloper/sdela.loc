<?php
/*
Plugin Name: Video Uploader
Version: 0.1.0
Author: A.Bodnarashek
*/

function su_image_form_html(){
	session_start();
//	$a = file_get_contents('the_key.txt');
	$key = json_decode(file_get_contents(site_url().'/the_key.txt'), true);
	if(is_array($key)){
		$_SESSION['token'] = $key['refresh_token'];
		@include dirname( __FILE__ ) . '/front.php';
	}
	
}
add_shortcode('image_form', 'su_image_form_html');

function su_load_scripts() {
    wp_enqueue_style( 'progressbar', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css' );
    wp_enqueue_style( 'progressbartheme', plugin_dir_url( __FILE__ ) . 'css/jquery-ui.theme.css' );
    wp_enqueue_style( 'wp-mediaelement' );
    wp_enqueue_script('jquery');
    wp_enqueue_script( 'jquery-ui-progressbar');
//    wp_enqueue_script('wp-mediaelement');
    wp_enqueue_script('image-form-js', plugin_dir_url( __FILE__ ) . 'js/script.js', array('jquery'), '0.1.0', true);

    $data = array(
                'upload_url' => admin_url('admin-ajax.php')
            );

    wp_localize_script( 'image-form-js', 'su_config', $data );
}
add_action( 'admin_enqueue_scripts', 'su_load_scripts' );
add_action('wp_enqueue_scripts', 'su_load_scripts');


add_action('wp_ajax_maxx_youtube_upload', 'maxx_youtube_upload');
add_action('wp_ajax_nopriv_maxx_youtube_upload', 'maxx_youtube_upload');
function maxx_youtube_upload() {
//	session_start();	
	//$a = file_get_contents(site_url().'/the_key.txt');
	$key = json_decode(file_get_contents(site_url().'/the_key.txt'), true);
	if(!isset($_FILES['youfile'])){
		echo 0;
		wp_die();
	}
	include dirname(__FILE__).'/upload.php';  
	wp_die();	

}
