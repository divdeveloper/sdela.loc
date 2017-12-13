<?php

/**
 *
 *
 * @since             3.0
 * @package           Wp_Ajax_Login_Register
 *
 * @wordpress-plugin
 * Plugin Name:       MAXX AJAX Login and Register
 * Version:           1.0
 * Author:            A.Bodnarashek
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-ajax-login-register
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-ajax-login-activator.php
 */
function activate_wp_ajax_login() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ajax-login-activator.php';
	Wp_Ajax_Login_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-ajax-login-deactivator.php
 */
function deactivate_wp_ajax_login() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-ajax-login-deactivator.php';
	Wp_Ajax_Login_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_ajax_login' );
register_deactivation_hook( __FILE__, 'deactivate_wp_ajax_login' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-ajax-login.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_ajax_login() {

	$plugin = new Wp_Ajax_Login();
	$plugin->run();

}
run_wp_ajax_login();

// Fix New User Email Notification
if( !function_exists ( 'wp_new_user_notification')){
function wp_new_user_notification ( $user_id, $notify = '' ) { }
}

// override core function
if ( !function_exists('wp_authenticate') ) :
function wp_authenticate($username, $password) {
    $username = sanitize_user($username);
    $password = trim($password);

    $user = apply_filters('authenticate', null, $username, $password);

    if ( $user == null ) {
        // TODO what should the error message be? (Or would these even happen?)
        // Only needed if all authentication handlers fail to return anything.
        $user = new WP_Error('authentication_failed', __('<strong>ОШИБКА</strong>: Неверный email или пароль.'));
    } elseif ( get_user_meta( $user->ID, 'has_to_be_activated', true ) != false ) {
        $user = new WP_Error('activation_failed', __('<strong>ОШИБКА</strong>: Пользователь не активирован.'));
    }

    $ignore_codes = array('empty_username', 'empty_password');

    if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes) ) {
        do_action('wp_login_failed', $username);
    }

    return $user;
}
endif;

add_action( 'template_redirect', 'wpse8170_activate_user' );
function wpse8170_activate_user() {
    if ( is_page() && get_the_ID() == 576 ) {
        $user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
        if ( $user_id ) {
            // get user meta activation hash field
            $code = get_user_meta( $user_id, 'has_to_be_activated', true );
            if ( $code == filter_input( INPUT_GET, 'key' ) ) {
                delete_user_meta( $user_id, 'has_to_be_activated' );
            }
        }
        wp_redirect( home_url() ); exit; 
    }
                  

}