<div class="w2dc-content">
	<?php w2dc_renderMessages(); ?>

	<?php if (count($w2dc_instance->levels->levels_array) > 1): ?>
	<h2><?php echo sprintf(apply_filters('w2dc_create_option', __('Create new %s in level "%s"', 'W2DC'), $w2dc_instance->current_listing), $directory->single, $w2dc_instance->current_listing->level->name); ?></h2>
	<?php endif; ?>

	<?php if (w2dc_is_woo_active() && w2dc_is_woo_packages() && count($w2dc_instance->levels->levels_array) == 1): ?>
	<h2><?php echo apply_filters('w2dc_create_option', sprintf(__('Create new %s', 'W2DC'), $directory->single), $w2dc_instance->current_listing); ?></h2>
	<?php
	$packages_manager = new w2dc_listings_packages_manager;
	if (!$packages_manager->can_user_create_listing_in_level($w2dc_instance->current_listing->level->id)): ?>
	<h3><?php _e("Add package to cart, then submit your listing. Listing will become active after payment.", "W2DC"); ?></h3>
	<?php w2dc_renderTemplate(array(W2DC_FSUBMIT_TEMPLATES_PATH, 'listings_packages.tpl.php'), array('frontend_controller' => $frontend_controller, 'hide_navigation' => true)); ?>
	<?php endif; ?>
	<?php endif; ?>

	<form action="<?php echo w2dc_submitUrl(array('level' => $w2dc_instance->current_listing->level->id)); ?>" method="POST" enctype="multipart/form-data">
		<input type="hidden" name="listing_id" value="<?php echo $w2dc_instance->current_listing->post->ID; ?>" />
		<input type="hidden" name="listing_id_hash" value="<?php echo md5($w2dc_instance->current_listing->post->ID . wp_salt()); ?>" />
		<?php wp_nonce_field('w2dc_submit', '_submit_nonce'); ?>

		<?php if (!is_user_logged_in() && (get_option('w2dc_fsubmit_login_mode') == 2 || get_option('w2dc_fsubmit_login_mode') == 3)): ?>
		<div class="w2dc-submit-section-contact-info">
			<h3 class="w2dc-submit-section-label"><?php _e('User info', 'W2DC'); ?></h3>
			<div class="col-xs-12">
				<label class="w2dc-fsubmit-contact"><?php _e('Your Name', 'W2DC'); ?><?php if (get_option('w2dc_fsubmit_login_mode') == 2): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></label>
				<input type="text" name="w2dc_user_contact_name" value="<?php echo esc_attr($frontend_controller->w2dc_user_contact_name); ?>" class="form-control" style="width: 100%;" />

				<label class="w2dc-fsubmit-contact"><?php _e('Your Email', 'W2DC'); ?><?php if (get_option('w2dc_fsubmit_login_mode') == 2): ?><span class="w2dc-red-asterisk">*</span><?php endif; ?></label>
				<input type="text" name="w2dc_user_contact_email" value="<?php echo esc_attr($frontend_controller->w2dc_user_contact_email); ?>" class="form-control" style="width: 100%;" />
			</div>
		</div>
		<?php endif; ?>

		<div class="w2dc-submit-section-title row ">
				<?php echo sdela_select_job_type($w2dc_instance->content_fields->getContentFieldBySlug('job-type')); ?>
            <div class="col-md-7 col-xs-12">
				<input type="text" name="post_title" class="form-control" placeholder="<?php _e('Название', 'W2DC'); ?>" value="<?php if ($w2dc_instance->current_listing->post->post_title != __('Auto Draft', 'W2DC')) echo esc_attr($w2dc_instance->current_listing->post->post_title); ?>" maxlength="90"/>
			</div>
		</div>

		<div class="w2dc-submit-section-description row">
			<div class="col-xs-12">
                <textarea name="post_content" class="w2dc-editor-class form-control" placeholder="<?php echo $w2dc_instance->content_fields->getContentFieldBySlug('content')->description ? $w2dc_instance->content_fields->getContentFieldBySlug('content')->description : $w2dc_instance->content_fields->getContentFieldBySlug('content')->name; ?>" rows="7"><?php echo esc_textarea($w2dc_instance->current_listing->post->post_content)?></textarea>
			</div>
		</div>

		<?php if (post_type_supports(W2DC_POST_TYPE, 'excerpt')): ?>
		<div class="w2dc-submit-section-excerpt row">
			<div class="col-xs-12">
				<textarea name="post_excerpt" class="w2dc-editor-class form-control" placeholder="<?php echo $w2dc_instance->content_fields->getContentFieldBySlug('summary')->description ? $w2dc_instance->content_fields->getContentFieldBySlug('summary')->description : $w2dc_instance->content_fields->getContentFieldBySlug('summary')->name; ?>" rows="4"><?php echo esc_textarea($w2dc_instance->current_listing->post->post_excerpt)?></textarea>
			</div>
		</div>
		<?php endif; ?>
		
		<?php do_action('w2dc_create_listing_metaboxes_pre', $w2dc_instance->current_listing); ?>

		<?php if ($w2dc_instance->current_listing->level->categories_number > 0 || $w2dc_instance->current_listing->level->unlimited_categories): ?>
            <div class="w2dc-submit-section-categories row">
					<?php echo sdela_select_categories(
						$w2dc_instance->content_fields->getContentFieldBySlug('categories_list'),
						$w2dc_instance->content_fields->getContentFieldBySlug('subcategory'),
						$w2dc_instance->current_listing->post->ID
					); ?>
            </div>
		<?php endif; ?>

		<?php if (get_option('w2dc_enable_tags')): ?>
            <div class="w2dc-submit-section-tags row">
                <h3 class="w2dc-submit-section-label"><?php echo $w2dc_instance->content_fields->getContentFieldBySlug('listing_tags')->name; ?> <i>(<?php _e('select existing or type new', 'W2DC'); ?>)</i></h3>
                <div class="col-xs-12">
					<?php w2dc_tags_selectbox($w2dc_instance->current_listing->post->ID); ?>
					<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('listing_tags')->description): ?><p class="description"><?php echo $w2dc_instance->content_fields->getContentFieldBySlug('listing_tags')->description; ?></p><?php endif; ?>
                </div>
            </div>
		<?php endif; ?>

        <?php if (!$w2dc_instance->current_listing->level->eternal_active_period && (get_option('w2dc_change_expiration_date') || current_user_can('manage_options'))): ?>
		<div class="w2dc-submit-section-expiration-date row">
			<h3 class="w2dc-submit-section-label"><?php _e('Listing expiration date', 'W2DC'); ?></h3>
			<div class="col-xs-12">
				<?php $w2dc_instance->listings_manager->listingExpirationDateMetabox($w2dc_instance->current_listing->post); ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if (get_option('w2dc_listing_contact_form') && get_option('w2dc_custom_contact_email')): ?>
		<div class="w2dc-submit-section-contact-email row">
			<h3 class="w2dc-submit-section-label"><?php _e('Contact email', 'W2DC'); ?></h3>
			<div class="col-xs-12">
				<?php $w2dc_instance->listings_manager->listingContactEmailMetabox($w2dc_instance->current_listing->post); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if (get_option('w2dc_claim_functionality') && !get_option('w2dc_hide_claim_metabox')): ?>
		<div class="w2dc-submit-section-claim row">
			<h3 class="w2dc-submit-section-label"><?php _e('Listing claim', 'W2DC'); ?></h3>
			<div class="col-xs-12">
				<?php $w2dc_instance->listings_manager->listingClaimMetabox($w2dc_instance->current_listing->post); ?>
			</div>
		</div>
		<?php endif; ?>

		<?php if ($w2dc_instance->content_fields->getContentFieldBySlug('price')): ?>
            <div class="w2dc-submit-section-price row">
                <div class="col-md-5 col-xs-12 flex">
					<?php echo $w2dc_instance->content_fields->getContentFieldBySlug('price')->renderInput(); ?>
                </div>
                <div class="col-md-4 col-xs-12 flex">
					<?php echo $w2dc_instance->content_fields->getContentFieldBySlug('Price_typ')->renderInput(); ?>
                </div>
            </div>
		<?php endif; ?>

		<?php if ($w2dc_instance->current_listing->level->locations_number > 0): ?>
            <div class="w2dc-submit-section-locations row">
                <div class="col-xs-12">
					<?php $w2dc_instance->locations_manager->listingLocationsMetabox($w2dc_instance->current_listing->post); ?>
                </div>
            </div>
		<?php endif; ?>

        <?php if ($w2dc_instance->content_fields->getContentFieldBySlug('begin')): ?>
		<div class="w2dc-submit-section-date row">
                <?php echo sdela_select_datetime(
                        $w2dc_instance->content_fields->getContentFieldBySlug('begin'),
                        $w2dc_instance->content_fields->getContentFieldBySlug('end')
                ); ?>
		</div>
		<?php endif; ?>
	
		<?php if ($w2dc_instance->current_listing->level->images_number > 0 || $w2dc_instance->current_listing->level->videos_number > 0): ?>
		<div class="w2dc-submit-section-media row">
			<div class="col-xs-12">
				<?php $w2dc_instance->media_manager->mediaMetabox(); ?>
			</div>
		</div>
		<?php endif; ?>
	
		<?php do_action('w2dc_create_listing_metaboxes_post', $w2dc_instance->current_listing); ?>

		<?php if (get_option('w2dc_enable_recaptcha')): ?>
		<div class="w2dc-submit-section-adv">
			<?php echo w2dc_recaptcha(); ?>
		</div>
		<?php endif; ?>

		<?php
		if ($tos_page = w2dc_get_wpml_dependent_option('w2dc_tospage')) : ?>
		<div class="w2dc-submit-section-adv">
			<label><input type="checkbox" name="w2dc_tospage" value="1" /> <?php printf(__('I agree to the ', 'W2DC') . '<a href="%s" target="_blank">%s</a>', get_permalink($tos_page), __('Terms of Services', 'W2DC')); ?></label>
		</div>
		<?php endif; ?>

		<?php require_once(ABSPATH . 'wp-admin/includes/template.php'); ?>
		<?php submit_button(__('Сохранить и посмотреть', 'W2DC'), 'w2dc-btn w2dc-btn-primary')?>
	</form>
</div>