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

				<?php // var_dump($listing); ?>
				<?php var_dump($listing->getContentField(12)); ?>
				<?php $listing->renderContentField(12); ?>
				<?php w2dc_renderTemplate('frontend/frontpanel_buttons.tpl.php', array('listing' => $listing)); ?>

				<div id="<?php echo $listing->post->post_name; ?>" itemscope itemtype="http://schema.org/LocalBusiness">
					<?php if ($listing->title()): ?>
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
					<?php endif; ?>

					<article id="post-<?php the_ID(); ?>" class="w2dc-listing">
						<div class="row">
							<div class="col-xs-12 attr-data">
								<?php do_action('w2dc_listing_pre_content_html', $listing); ?>
								<?php $listing->renderContentFields(true); ?>
								<?php do_action('w2dc_listing_post_content_html', $listing); ?>
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
						<?php if ($listing->level->google_map && $listing->isMap() && $listing->locations): ?>
							<div class="row">
								<div class="col-xs-12">
									<?php $listing->renderMap($frontend_controller->hash, get_option('w2dc_show_directions'), false, get_option('w2dc_enable_radius_search_circle'), get_option('w2dc_enable_clusters'), false, false); ?>
								</div>
							</div>
						<?php endif; ?>
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

						
					</article>
				</div>
			<?php endwhile; endif; ?>
		</div>