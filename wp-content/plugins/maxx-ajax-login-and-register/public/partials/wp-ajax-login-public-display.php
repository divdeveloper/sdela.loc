<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://ptheme.com/
 * @since      1.0.0
 *
 * @package    Wp_Ajax_Login
 * @subpackage Wp_Ajax_Login/public/partials
 */

#   This file should primarily consist of HTML with a little bit of PHP.
# 	
# 	USER REGISTRATION/LOGIN MODAL
# 	========================================================================================
#   Attach this function to the footer if the user isn't logged in
# 	========================================================================================
# 		

function pt_login_register_modal() { ?>
<script>
var cur_page = '<?php echo get_permalink() ?>';
</script>

	<div class="modal fade pt-user-modal" id="pt-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog" data-active-tab="">
			<div class="modal-content">
			<?php 
				if( ! is_user_logged_in() ){ // only show the registration/login form to non-logged-in members ?>	
					<div class="modal-body">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="btn-close" aria-hidden="true"></span></button>
						<div class="pt-register">
							 
<!--							<h3><?php printf( __('Join %s', 'wp-ajax-login'), get_bloginfo('name') ); ?></h3>
							<hr>-->

							<?php if( get_option('users_can_register') ){ ?>

							<form id="pt_registration_form" action="<?php echo home_url( '/' ); ?>" method="POST" autocomplete="off">
                                                                            <p class="cyr700"><?php echo _PLG_MAXX_AJAX_LOGIN_REGISTRATION_ON_SITE?></p>
                                                                            <p ><?php echo _PLG_MAXX_AJAX_LOGIN_WELCOME_TO_SITE?></p>
                                                                            <p><?php echo _PLG_MAXX_AJAX_LOGIN_ACCESS_ALL_DATA?></p>
                                                                            <p class="cyr500"><?php echo _PLG_MAXX_AJAX_LOGIN_TRY_TRIAL?></p>

										<div class="form-field">
											<input class="form-control input-lg" name="pt_user_username" id="pt_user_username" type="text" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_FIO?>" autocomplete="name"/>
										</div>
										<div class="form-field">
											<input class="form-control input-lg" name="phone" id="pt_user_phone" type="text" placeholder="(55) 555-55-55"  autocomplete="tel"/>
										</div>		
<div class="form-field phonetype">										
<label for="phonetype1">
    <input class="checkbox" name="phonetype[]" type="checkbox" id="phonetype1" value="1"> 
    <span class="checkbox-custom"></span>
    <span class="label phonetype1">&nbsp;</span> 
</label>
<label for="phonetype2">
    <input class="checkbox" name="phonetype[]" type="checkbox" id="phonetype2" value="2"> 
    <span class="checkbox-custom"></span>
    <span class="label phonetype2">&nbsp;</span>   
</label>
<label for="phonetype3">
    <input class="checkbox" name="phonetype[]" type="checkbox" id="phonetype3" value="3"> 
    <span class="checkbox-custom"></span>
    <span class="label phonetype3">&nbsp;</span>    
</label>   	
</div>											
										<div class="form-field">
											<input class="form-control input-lg required" name="pt_user_email" id="pt_user_email" type="email" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_REGISTER_EMAIL?>"  autocomplete="email"/>
										</div>								
                                                                                <div class="form-field">
                                                                                <div class="g-recaptcha" data-sitekey="6Ley6AkUAAAAANotNT6Ntagzk2nhmoP97eXDy_o0"></div>    
                                                                                </div>

                                                                            
                                                                                <div class="form-field">
																					<input class="form-control input-lg required" name="pt_user_pass1" id="pt_user_pass1" type="password" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_REGISTER_PASSWORD?>" />
										</div> 
                                                                            
                                                                                <div class="form-field">
																					<input class="form-control input-lg required" name="pt_user_pass2" id="pt_user_pass2" type="password" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_REGISTER_PASSWORD2?>" />
										</div>                                                                             

										<div class="form-field">
											<input type="hidden" name="action" value="pt_register_member"/>
											<button class="btn btn-theme btn-lg" data-loading-text="<?php echo _PLG_MAXX_AJAX_LOGIN_WAIT ?>" type="submit"><?php echo _PLG_MAXX_AJAX_LOGIN_REGISTER?></button>
										</div>
										<?php wp_nonce_field( 'ajax-login-nonce', 'register-security' ); ?>
									</form>
									<div class="pt-errors"></div>

							<?php } else {

								echo '<div class="alert alert-warning">'._PLG_MAXX_AJAX_LOGIN_REGISTRATION_IS_DISABLED.'</div>';

							} ?>

							</div>

								<!-- Login form -->
								<div class="pt-login">
							 
<!--									<h3><?php printf( _PLG_MAXX_AJAX_LOGIN_LOGIN_TO, get_bloginfo('name') ); ?></h3>-->
									<!--<hr>-->
							 
									<form id="pt_login_form" action="<?php echo home_url( '/' ); ?>" method="post">
                                                                            <p class="cyr700"><?php echo _PLG_MAXX_AJAX_LOGIN_ENTER_SITE?></p>
                                                                            <p><?php echo _PLG_MAXX_AJAX_LOGIN_WELCOME_TO_SITE?></p>
                                                                            <p><?php echo _PLG_MAXX_AJAX_LOGIN_ACCESS_ALL_DATA?></p>
										<div class="form-field">
											<input class="form-control input-lg required" name="pt_user_login" type="text" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_EMAIL?>" />
										</div>
										<div class="form-field">
											<input class="form-control input-lg required" name="pt_user_pass" id="pt_user_pass" type="password" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_PASSWORD?>">
										</div>
                                                                            <div class="form-field forgetmenot">
<label for="rememberme">
    <input class="checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever"> 
    <span class="checkbox-custom"></span>
    <span class="label"><?php echo _PLG_MAXX_AJAX_LOGIN_REMEMBER_ME?></span>
    
</label>                                                                                
                                                                                
                                                                            </div>                                                                                                                                                   
                                                                            
										<div class="form-field">
											<input type="hidden" name="action" value="pt_login_member"/>
											<button class="btn btn-theme btn-lg enter" data-loading-text="<?php echo _PLG_MAXX_AJAX_LOGIN_WAIT ?>" type="submit"><?php echo _PLG_MAXX_AJAX_LOGIN_ENTER?></button> <a class="alignright1" href="#pt-reset-password"><?php echo _PLG_MAXX_AJAX_LOGIN_FORGOT_PASSWORD?></a>
										</div>
										<?php wp_nonce_field( 'ajax-login-nonce', 'login-security' ); ?>
									</form>
									<div class="pt-errors"></div>
								</div>
                                                                
                                                                <!-- Info -->
								<div class="pt-info">
							 
                                   <p><?php echo _PLG_MAXX_AJAX_LOGIN_ENTER_EMAIL_LOGIN?></p>
							 
								</div>                                                               
                                                                

								<!-- Lost Password form -->
								<div class="pt-reset-password">
									
                                                                    <p class="cyr700"><?php echo _PLG_MAXX_AJAX_LOGIN_SEND_PASSWORD?></p>
                                                                    <p><?php echo _PLG_MAXX_AJAX_LOGIN_EMAIL_FOR_NEW_PASSWORD?></p>
									<!--<hr>-->
							 
									<form id="pt_reset_password_form" action="<?php echo home_url( '/' ); ?>" method="post">
										<div class="form-field">
											<input class="form-control input-lg required" name="pt_user_or_email" id="pt_user_or_email" type="text" placeholder="<?php echo _PLG_MAXX_AJAX_LOGIN_ENTER_EMAIL_OR_LOGIN?>" />
										</div>
										<div class="form-field">
											<input type="hidden" name="action" value="pt_reset_password"/>
											<button class="btn btn-theme btn-lg" data-loading-text="<?php echo _PLG_MAXX_AJAX_LOGIN_WAIT ?>" type="submit"><?php echo _PLG_MAXX_AJAX_LOGIN_SEND?></button>
										</div>
										<?php wp_nonce_field( 'ajax-login-nonce', 'password-security' ); ?>
									</form>
									<div class="pt-errors"></div>
								</div>

								<div class="pt-loading">
									<p><i class="fa fa-refresh fa-spin"></i><br><?php echo _PLG_MAXX_AJAX_LOGIN_WAIT ?></p>
								</div>
					</div>
					<div class="modal-footer">
							<span class="pt-register-footer"><a href="#pt-register"><?php echo _PLG_MAXX_AJAX_LOGIN_REGISTER_LINK?></a>, <?php echo _PLG_MAXX_AJAX_LOGIN_NO_ACCOUNT?></span>
							<span class="pt-login-footer"><a href="#pt-login"><?php echo _PLG_MAXX_AJAX_LOGIN_ENTER_SITE_LINK?></a>, <?php echo _PLG_MAXX_AJAX_LOGIN_HAVE_ACCOUNT?></span>
					</div>
				<?php } else { ?>
					<div class="modal-body">
						<div class="pt-logout">							
							<div class="alert alert-info"><?php $current_user = wp_get_current_user(); printf( _PLG_MAXX_AJAX_LOGIN_REGISTER_AS, $current_user->user_login );?></div>
							<div class="pt-errors"></div>
						</div>
					</div>
				<?php } ?>		
				</div>
			</div>
		</div>
<?php }
add_action('wp_footer', 'pt_login_register_modal');
function pt_shortcode( $atts ) {

	$atts = shortcode_atts( array(
		'text' => 'Login/Register',
	), $atts, 'wp-ajax-login' );

	return "<a href='#pt-login'>{$atts['text']}</a>";
}
add_shortcode( 'wp-ajax-login', 'pt_shortcode' );