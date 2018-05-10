	</div>
</div>
		<div class="w2dc-content w2dc-listing-single">
			<?php w2dc_renderMessages(); ?>

			<?php if ($frontend_controller->listings): ?>
			<?php while ($frontend_controller->query->have_posts()): ?>
				<?php $frontend_controller->query->the_post(); ?>
				<?php $listing = $frontend_controller->listings[get_the_ID()]; ?>
				<?php /*if($listing->status == 'expired'):
					do_action('w2dc_listing_process_activate', $listing, true);
					if($_GET['listing_id'] && $_GET['listing_id'] != '' && $_GET['renew_action'] == 'renew'):
						$listing->processActivate(true);
					endif;
				endif;*/
				?>
				<?php // w2dc_renderTemplate('frontend/frontpanel_buttons.tpl.php', array('listing' => $listing)); ?>
				
				<div class="listing-single" id="<?php echo $listing->post->post_name; ?>" itemscope itemtype="http://schema.org/LocalBusiness">
					<?php if ($listing->title()): ?>
					<div class="container dmbs-container">
						<div class="dmbs-content">
							<header class="w2dc-listing-header">
								<h2 itemprop="name" class="w2dc-pull-left"><?php echo $frontend_controller->getPageTitle(); ?></h2><?php do_action('w2dc_listing_title_html', $listing, true); ?>
								<?php if (!get_option('w2dc_hide_views_counter')): ?>
								<div class="w2dc-meta-data">
									<div class="w2dc-views-counter">
										<span class="w2dc-glyphicon w2dc-glyphicon-eye-open"></span> views: <?php echo get_post_meta($listing->post->ID, '_total_clicks', true); ?>
									</div>
								</div>
								<?php endif; ?>
								<?php if (!get_option('w2dc_hide_listings_creation_date')): ?>
								<div class="w2dc-meta-data">
									<div class="w2dc-listing-date" datetime="<?php echo date("Y-m-d", mysql2date('U', $listing->post->post_date)); ?>T<?php echo date("H:i", mysql2date('U', $listing->post->post_date)); ?>"><?php echo get_the_date(); ?> <?php echo get_the_time(); ?></div>
								</div>
								<?php endif; ?>
								
								<?php if (get_option('w2dc_share_buttons') && get_option('w2dc_share_buttons_place') == 'title'): ?>
								<?php w2dc_renderTemplate('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID)); ?>
								<?php endif; ?>
								<?php if ($frontend_controller->breadcrumbs): ?>
								<ol class="w2dc-breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList">
									<?php echo $frontend_controller->getBreadCrumbs(); ?>
								</ol>
								<?php endif; ?>
							</header>
						</div>
					</div>
					<?php endif; ?>

					<article id="post-<?php the_ID(); ?>" class="w2dc-listing">
						<div class="container dmbs-container">
							<div class="dmbs-content">
								<div class="row">
									<div class="w2dc-attr-data-box">
										<div class="row w2dc-content-field">
											<div class="field-title">
												<?= _e('Категория', 'W2DC'); ?>:
											</div>
											<div class="field-value">
												<?php w2dc_renderTemplate('content_fields/fields/categories_output-custom.tpl.php', array('listing' => $listing)); ?>
											</div>
										</div>
				
										<?php
										$type_price = $listing->getContentField(14);
										$price = $listing->getContentField(11);
										$formatted_price = number_format($price->value, 2, $price->decimal_separator, $price->thousands_separator);
										?>
										<?php w2dc_renderTemplate('content_fields/fields/price_output-custom.tpl.php', array('content_field' => $price, 'formatted_price' => $formatted_price, 'type_price' => $type_price->selection_items[$type_price->value])); ?>
										
										<?php // do_action('w2dc_listing_pre_content_html', $listing); ?>
										<?php // $listing->renderContentFields(true); ?>
										<?php // do_action('w2dc_listing_post_content_html', $listing); ?>
									</div>
									<div class="w2dc-actions-data-box">
										<div class="row">
											<div class="col-xs-12">
												<div class="favorite-box">
													<?php if (get_option('w2dc_favourites_list')): ?>
														<a href="javascript:void(0);" class="status-favorite <?= (w2dc_checkQuickList($listing->post->ID)) ? 'not-favorite' : 'is-favorite'; ?>" rel="nofollow">
														</a>
													<?php endif; ?>
													</div>
													<div class="interest-box">
														<div class="interest-informer">
															<span class="w2dc-interest-count"><?= w2dc_interest_count($listing->post->ID); ?></span> <span class="w2dc-window-interest_action" data-listingid="<?= $listing->post->ID; ?>"><?= _e('интерес', 'W2DC') ?></span>
														</div>
												</div>
											</div>
											<div class="col-xs-12 type-box">
											<?php w2dc_renderTemplate('content_fields/fields/listing_type_output-custom.tpl.php', array('content_field' => $listing->getContentField(12))); ?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="divide-line"></div>
						<div class="row w2dc_no-margin">
							<div class="col-xs-1 col-xs-offset-11">
								<button class="w2dc-listing-controls" data-listingid="<?= $listing->post->ID; ?>"><span class="w2dc-glyphicon w2dc-glyphicon-plus"></span></button>
							</div>
						</div>
						<div class="container dmbs-container">
							<div class="dmbs-content">
								<div class="row">
									<div class="col-xs-12">
										<?php w2dc_renderTemplate('content_fields/fields/datetime_output-custom.tpl.php', array('start_date' => $listing->getContentField(9), 'end_date' => $listing->getContentField(10))); ?>
										<?php w2dc_renderTemplate('content_fields/fields/content_output-custom.tpl.php', array('listing' => $listing)); ?>
									</div>
								</div>
								<div class="row media-box">
								<?php $media_grid = [
									1 => [
										'xs' => 12,
										'sm' => 12,
										'md' => 12,
									],
									2 => [
										'xs' => 12,
										'sm' => 6,
										'md' => 4,
									],
								];?>
								<?php if (count($listing->videos) > 0): ?>
									<div class="col-xs-6 video-box">
										<?php w2dc_renderTemplate('frontend/view_videos.tpl.php', array('listing' => $listing, 'grid' => $media_grid)); ?>
									</div>
								<?php 
								endif;
								if (count($listing->images) > 0):
								?>
									<div class="col-xs-6 photo-box">
										<?php w2dc_renderTemplate('frontend/view_photos.tpl.php', array('listing' => $listing, 'grid' => $media_grid)); ?>
									</div>
								<?php endif; ?>
								</div>
								
								<div class="w2dc-single-listing-text-content-wrap">
									<?php if (get_option('w2dc_share_buttons') && get_option('w2dc_share_buttons_place') == 'before_content'): ?>
									<?php w2dc_renderTemplate('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID)); ?>
									<?php endif; ?>

									<?php if (get_option('w2dc_share_buttons') && get_option('w2dc_share_buttons_place') == 'after_content'): ?>
									<?php w2dc_renderTemplate('frontend/sharing_buttons_ajax_call.tpl.php', array('post_id' => $listing->post->ID)); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
						<div class="divide-line" style="margin-top: 35px;"></div>
						<div class="container dmbs-container">
							<div class="dmbs-content">
								<div class="row w2dc-content-field">
									<div class="col-xs-8">
										<div class="row">
											<div class="col-xs-2 field-title">
												<?=  _e('Где', 'W2DC'); ?>:
											</div>
											<div class="col-xs-10 field-value">
												<span class="address"><?= $listing->getLocation(0)->address_line_1; ?></span>
											</div>
										</div>
									</div>
								</div>
								
								<?php if ($listing->level->google_map && $listing->isMap() && $listing->locations): ?>
									<div class="row" style="margin-top: 20px;">
										<div class="col-xs-12 w2dc_no-padding">
											<?php $listing->renderMap($frontend_controller->hash, get_option('w2dc_show_directions'), false, get_option('w2dc_enable_radius_search_circle'), get_option('w2dc_enable_clusters'), false, false); ?>
										</div>
									</div>
								<?php endif; ?>
							</div>
						</div>
						<div class="divide-line"></div>
						<div class="container dmbs-container">
							<div class="dmbs-content">
								<?php if (!get_option('w2dc_hide_author_link')): ?>
								<div class="w2dc-meta-data">
									<div class="w2dc-author-link">
										<?php w2dc_renderTemplate('frontend/autor_info.tpl.php', array('autor_id' => get_the_author_ID())); ?>
									</div>
								</div>
								<?php endif; ?>
								<?php if (w2dc_comments_open()): ?>
									<div class="row">
										<div class="col-xs-12">
											<?php comments_template('', true); ?>
										</div>
									</div>
								<?php endif; ?>
								<?php if (get_option('w2dc_listing_contact_form') && (!$listing->is_claimable || !get_option('w2dc_hide_claim_contact_form')) && ($listing_owner = get_userdata($listing->post->post_author)) && $listing_owner->user_email): ?>
									<div class="row hidden">
									<?php if (defined('WPCF7_VERSION') && w2dc_get_wpml_dependent_option('w2dc_listing_contact_form_7')): ?>
										<?php echo do_shortcode(w2dc_get_wpml_dependent_option('w2dc_listing_contact_form_7')); ?>
									<?php else: ?>
										<?php w2dc_renderTemplate('frontend/contact_form.tpl.php', array('listing' => $listing)); ?>
									<?php endif; ?>
									</div>
								<?php endif; ?>
								<script>
									(function($) {
										"use strict";
			
										$(function() {
											<?php if (get_option('w2dc_listings_tabs_order')): ?>
											if (1==2) var x = 1;
											<?php foreach (get_option('w2dc_listings_tabs_order') AS $tab): ?>
											else if ($('#<?php echo $tab; ?>').length)
												w2dc_show_tab($('.w2dc-listing-tabs a[data-tab="#<?php echo $tab; ?>"]'));
											<?php endforeach; ?>
											<?php else: ?>
											w2dc_show_tab($('.w2dc-listing-tabs a:first'));
											<?php endif; ?>
										});
									})(jQuery);
								</script>

							</div>
						</div>
					</article>
				</div>
			<?php endwhile; endif; ?>
		</div>
<div class="container dmbs-container">
	<div class="row dmbs-content">