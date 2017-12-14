<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ptheme.com/
 * @since      1.0.0
 *
 * @package    Wp_Ajax_Login
 * @subpackage Wp_Ajax_Login/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Ajax_Login
 * @subpackage Wp_Ajax_Login/public
 * @author     Leo <newbiesup@gmail.com>
 */
class Wp_Ajax_Login_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
                add_filter( 'random_password',array( $this, 'set_password' ) );
                add_filter( 'registration_errors', array( &$this, 'password_errors' ) );
                remove_action( 'tml_new_user_registered',   'wp_new_user_notification', 10, 2 );
				add_filter( 'wp_mail_from',         array( $this, 'mail_from_filter'         ) );
				add_filter( 'wp_mail_from_name',    array( $this, 'mail_from_name_filter'    ) );				

	}
	
	public function mail_from_filter( $from_email ) {
		return 'ivanov@sdela.com';
		//return empty( $this->mail_from ) ? $from_email : $this->mail_from;
	}
	
	public function mail_from_name_filter( $from_name ) {
		return 'Модератор Иванов Иван Петрович';
		//return empty( $this->mail_from_name ) ? $from_name : $this->mail_from_name;
	}	


	public function password_errors( $errors = '' ) {
		// Make sure $errors is a WP_Error object
		if ( empty( $errors ) )
			$errors = new WP_Error();

		// Make sure passwords aren't empty
		if ( empty( $_POST['pt_user_pass1'] ) || empty( $_POST['pt_user_pass2'] ) ) {
			$errors->add( 'empty_password', _PLG_MAXX_AJAX_LOGIN_ERROR_ENTER_PASSWORD_TWICE );

		// Make sure there's no "\" in the password
		} elseif ( false !== strpos( stripslashes( $_POST['pt_user_pass1'] ), "\\" ) ) {
			$errors->add( 'password_backslash', _PLG_MAXX_AJAX_LOGIN_ERROR_PASSWORD_WRONG_SYMBOLS );

		// Make sure passwords match
		} elseif ( $_POST['pt_user_pass1'] != $_POST['pt_user_pass2'] ) {
			$errors->add( 'password_mismatch', _PLG_MAXX_AJAX_LOGIN_ERROR_PASSWORD_DONT_MATCH );

		// Make sure password is long enough
		} elseif ( strlen( $_POST['pt_user_pass1'] ) < 8 ) {
			$errors->add( 'password_length', _PLG_MAXX_AJAX_LOGIN_ERROR_PASSWORD_AT_LEAST_8_SYMBOLS );

		// All is good, assign password to a friendlier key
		} else {
			$_POST['user_pass'] = $_POST['pt_user_pass1'];
		}

		return $errors;
	}        
        
	public function set_password( $password ) {
		global $wpdb;

		// Remove filter as not to filter User Moderation activation key
		//remove_filter( 'random_password', array( $this, 'set_password' ) );
                // Make sure password isn't empty
                if ( ! empty( $_POST['user_pass'] ) )
                        $password = $_POST['user_pass'];
		return $password;
	}        

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Ajax_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Ajax_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-ajax-login-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'telmask', plugin_dir_url( __FILE__ ) . 'css/intlteinput.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Ajax_Login_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Ajax_Login_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.js', array( 'jquery' ), '3.3.4', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-ajax-login-public.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'jsmask', plugin_dir_url( __FILE__ ) . 'js/jquery-mask-min.js', array( 'jquery' ), '5.0', true );
		wp_enqueue_script( 'telmask', plugin_dir_url( __FILE__ ) . 'js/intltelinput.min.js', array( 'jquery' ), '5.0', true );
                wp_enqueue_script( 'recaptcha', 'https://www.google.com/recaptcha/api.js' );
		
		wp_localize_script( $this->plugin_name, 'ptajax', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		));

	}


	// LOGIN
	public function pt_login_member(){

  		// Get variables
		$user_login		= $_POST['pt_user_login'];	
		$user_pass		= $_POST['pt_user_pass'];


		// Check CSRF token
		if( !check_ajax_referer( 'ajax-login-nonce', 'login-security', false) ){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_SESSION_TOKEN_EXPIRED.'</div>'));
		}
	 	
	 	// Check if input variables are empty
	 	elseif( empty($user_login) || empty($user_pass) ){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_PLEASE_FILL_ALL_FORM_FIELDS.'</div>'));
	 	} else { // Now we can insert this account

	 		$user = wp_signon( array('user_login' => $user_login, 'user_password' => $user_pass), false );

		    if( is_wp_error($user) ){
				echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'.$user->get_error_message().'</div>'));
			} else{
				echo json_encode(array('error' => false, 'message'=> '<div class="alert alert-success">'._PLG_MAXX_AJAX_LOGIN_LOGIN_SUCCESSFUL_RELOADING_PAGE.'</div>'));
			}
	 	}

	 	die();
	}
        
        
        function verify_captcha( $parameter = true )
        {
            if( isset( $_POST['g-recaptcha-response'] ) )
            {
                $response = json_decode(wp_remote_retrieve_body( wp_remote_get( "https://www.google.com/recaptcha/api/siteverify?secret=6Ley6AkUAAAAAGn9hvX2r3GT5bfPt35tjauh8Bb4&response=" .$_POST['g-recaptcha-response'] ) ), true );

                if( $response["success"] )
                {
                    return $parameter;
                }
            }

            return false;
        }        
               

	// REGISTER
	public function pt_register_member(){
            global $wpdb;

            // Get variables
		$user_login	= $_POST['pt_user_email'];	
		$user_email	= $_POST['pt_user_email'];
		
		// Check CSRF token
		if( !check_ajax_referer( 'ajax-login-nonce', 'register-security', false) ){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_SESSION_TOKEN_EXPIRED.'</div>'));
			die();
		}
	 	
	 	// Check if input variables are empty
	 	elseif( empty($user_login) || empty($user_email) ){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_PLEASE_FILL_ALL_FORM_FIELDS.'</div>'));
			die();
	 	}
                
                if(!$this->verify_captcha()){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_ERROR_CAPTCHA.'</div>'));
			die();                    
                }
		
		$errors = register_new_user($user_login, $user_email);	
		
		if( is_wp_error($errors) ){

			$registration_error_messages = $errors->errors;

			$display_errors = '<div class="alert alert-danger">';
			
				foreach($registration_error_messages as $error){
					$display_errors .= '<p>'.$error[0].'</p>';
				}

			$display_errors .= '</div>';

			echo json_encode(array('error' => true, 'message' => $display_errors));

		} else {
    //send email                
    if ( $errors && !is_wp_error( $errors ) ) {
        $user_id = wp_update_user( array( 'ID' => $errors, 'display_name' => $_POST['pt_user_username'] ) );
        $code = sha1( $errors . time() );
        $user = new WP_User( $errors );
        $user->set_role( 'pending' );
        $activation_link = add_query_arg( array( 'key' => $code, 'user' => $errors ), get_permalink(576));
        
        $blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
        $title    = sprintf( _PLG_MAXX_AJAX_LOGIN_ACTIVATE_ACCOUNT, $blogname );
        
        $message  = sprintf( _PLG_MAXX_AJAX_LOGIN_ACTIVATE_ACCOUNT_LINK, $blogname ) . "\r\n\r\n";
        $message .=  $activation_link . "\r\n";        
        
        add_user_meta( $errors, 'has_to_be_activated', $code, true );
        wp_mail( $user_email, $title, $message );
    
        $wpdb->update( $wpdb->users, array( 'user_activation_key' => $code ), array( 'user_login' => $errors ) );
        
        
        //clear
//        $wpdb->update( $wpdb->users, array( 'user_activation_key' => '' ), array( 'user_login' => $errors ) );
//        $user_object = new WP_User( $user->ID );
//	$user_object->set_role( get_option( 'default_role' ) );        
        
        
    }                    
                    
                    
			echo json_encode(array('error' => false, 'message' => '<div class="alert alert-success">'._PLG_MAXX_AJAX_LOGIN_REGISTRATION_COMPLETE_PLEASE_CHECK_YOUR_E_MAIL.'</p>'));
		}
	 

	 	die();
	}

	// LOGIN
	public function pt_logout(){
		wp_logout();
		echo json_encode(array('error' => false, 'message'=> '<div class="alert alert-success">'._PLG_MAXX_AJAX_LOGIN_LOGOUT_SUCCESSFUL_RELOADING_PAGE.'</div>'));
		die();
	}

	// RESET PASSWORD
	function pt_reset_password(){

		
  		// Get variables
		$username_or_email = $_POST['pt_user_or_email'];

		// Check CSRF token
		if( !check_ajax_referer( 'ajax-login-nonce', 'password-security', false) ){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_SESSION_TOKEN_EXPIRED.'</div>'));
		}		

	 	// Check if input variables are empty
	 	elseif( empty($username_or_email) ){
			echo json_encode(array('error' => true, 'message'=> '<div class="alert alert-danger">'._PLG_MAXX_AJAX_LOGIN_PLEASE_FILL_ALL_FORM_FIELDS.'</div>'));
	 	} else {

			$username = is_email($username_or_email) ? sanitize_email($username_or_email) : sanitize_user($username_or_email);

			$user_forgotten = $this->pt_lostPassword_retrieve($username);
			
			if( is_wp_error($user_forgotten) ){
			
				$lostpass_error_messages = $user_forgotten->errors;

				$display_errors = '<div class="alert alert-warning">';
				foreach($lostpass_error_messages as $error){
					$display_errors .= '<p>'.$error[0].'</p>';
				}
				$display_errors .= '</div>';
				
				echo json_encode(array('error' => true, 'message' => $display_errors));
			}else{
				echo json_encode(array('error' => false, 'message' => '<p class="alert alert-success">'._PLG_MAXX_AJAX_LOGIN_PASSWORD_RESET_PLEASE_CHECK_YOUR_EMAIL.'</p>'));
			}
	 	}

	 	die();
	}

	private function pt_lostPassword_retrieve( $user_input ) {
		
		global $wpdb, $wp_hasher;

		$errors = new WP_Error();

		if ( empty( $user_input ) ) {
			$errors->add('empty_username',_PLG_MAXX_AJAX_LOGIN_ERROR_ENTER_USERNAME_OR_EMAIL_ADDRESS);
		} elseif ( strpos( $user_input, '@' ) ) {
			$user_data = get_user_by( 'email', trim( $user_input ) );
			if ( empty( $user_data ) )
				$errors->add('invalid_email', _PLG_MAXX_AJAX_LOGIN_ERROR_INVALID_EMAIL);
		} else {
			$login = trim($user_input);
			$user_data = get_user_by('login', $login);
		}

		/**
		 * Fires before errors are returned from a password reset request.
		 *
		 *
		 * @param WP_Error $errors A WP_Error object containing any errors generated
		 *                         by using invalid credentials.
		 */
		do_action( 'lostpassword_post', $errors );

		if ( $errors->get_error_code() )
			return $errors;

		if ( !$user_data ) {
			$errors->add('invalidcombo', _PLG_MAXX_AJAX_LOGIN_ERROR_WRONG_EMAIL);
			return $errors;
		}
                $password = wp_generate_password( 20, false );
                
                wp_set_password( $password, $user_data->ID );

		// Redefining user_login ensures we return the right case in the email.
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		$key = get_password_reset_key( $user_data );

		if ( is_wp_error( $key ) ) {
			return $key;
		}
		

		$message = 'Ваш новый пароль:' . $password. "\r\n\r\n";
//		$message .= network_home_url( '/' ) . "\r\n\r\n";
//		$message .= sprintf(__('Username: %s', 'wp-ajax-login'), $user_login) . "\r\n\r\n";
//		$message .= __('If this was a mistake, just ignore this email and nothing will happen.', 'wp-ajax-login') . "\r\n\r\n";
//		$message .= __('To reset your password, visit the following address:', 'wp-ajax-login') . "\r\n\r\n";
//		$message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";
		

			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

		$title = sprintf('[%s] Новый пароль', $blogname );

		/**
		 * Filter the subject of the password reset email.
		 *
		 *
		 * @param string  $title      Default email title.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$title = apply_filters( 'retrieve_password_title', $title, $user_login, $user_data );

		/**
		 * Filter the message body of the password reset mail.
		 *
		 *
		 * @param string  $message    Default mail message.
		 * @param string  $key        The activation key.
		 * @param string  $user_login The username for the user.
		 * @param WP_User $user_data  WP_User object.
		 */
		$message = apply_filters( 'retrieve_password_message', $message, $key, $user_login, $user_data );
		wp_mail( $user_email, $title, $message );

		//if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
		//	$errors->add('mailfailed', __('<strong>ERROR</strong>: The email could not be sent.Possible reason: your host may have disabled the mail() function.', 'wp-ajax-login'));

		return true;
	}

}
