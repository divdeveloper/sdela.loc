<div class="w2dc-title clearfix">
<?php
$interest_users = unserialize(get_post_meta($listing->post->ID, 'interest_users', true));

if (!$interest_users) {
	$interest_users = [];
}
?>
	<?php _e('Интересуется', 'W2DC'); ?>
	<b class="w2dc-interest-count-window"><?= count($interest_users); ?></b> 
	<a href="javascript:void(0);" class="w2dc-window-interest_action" data-listingid="<?= $listing->post->ID; ?>"><?php _e('показать всех', 'W2DC'); ?></a>
</div>
<?php
if(is_array($interest_users) && !empty($interest_users)){
?>
	<div class="w2dc-user-list-avatar clearfix">
<?php
	foreach($interest_users as $key => $user){
?>
		<div class="col-xs-3 w2dc-user-<?= $user['user_id']; ?>">
			<?= get_avatar($user['user_id'], 96, '', false); ?>
		</div>
<?php
		if ($key == 3) {
			break;
		}
	}
?>
<?php
}
?>
</div>

<?php do_action('w2dc_directory_frontpanel', (isset($listing)) ? $listing : null, (isset($frontend_controller)) ? $frontend_controller : null); ?>

<div class='skype-share' data-href='' data-lang='' data-text='' data-style='circle' ></div>

<?php
	var_dump(get_user_meta(0, 'tel', true));
	var_dump(get_user_meta(5, 'tel', true));
?>

<a href="mailto:?&subject=Sdela share&body=http%3A//sdela.loc/jobs/business-listing/26-03-18-%25D0%25BE%25D1%2582-%25D0%25BF%25D0%25B5%25D1%2582%25D1%2580%25D0%25BE%25D0%25B2%25D0%25B0-%25D0%25B7%25D0%25B0%25D0%25BA%25D0%25B0%25D0%25B7-azzy/">Send Email</a>
<?php if (get_option('w2dc_favourites_list') && $w2dc_instance->action != 'myfavourites'): ?>
<a class="w2dc-favourites-link w2dc-btn w2dc-btn-primary" href="<?php echo w2dc_directoryUrl(array('w2dc_action' => 'myfavourites')); ?>" rel="nofollow"><span class="w2dc-glyphicon w2dc-glyphicon-star"></span> <?php _e('My bookmarks', 'W2DC'); ?></a>
<?php endif; ?>

<?php if (isset($listing)): ?>
	<?php if (w2dc_show_edit_button($listing->post->ID)): ?>
	<a class="w2dc-edit-listing-link w2dc-btn w2dc-btn-primary" href="<?php echo w2dc_get_edit_listing_link($listing->post->ID); ?>" rel="nofollow"><span class="w2dc-glyphicon w2dc-glyphicon-pencil"></span> <?php _e('Edit listing', 'W2DC'); ?></a>
	<?php endif; ?>

	<?php if (get_option('w2dc_print_button')): ?>
	<script>
		var window_width = 860;
		var window_height = 800;
		var leftPosition, topPosition;
		(function($) {
			"use strict";

			$(function() {
				leftPosition = (window.screen.width / 2) - ((window_width / 2) + 10);
				topPosition = (window.screen.height / 2) - ((window_height / 2) + 50);
			});
		})(jQuery);
	</script>
	<a href="javascript:void(0);" class="w2dc-print-listing-link w2dc-btn w2dc-btn-primary" onClick="window.open('<?php echo add_query_arg('w2dc_action', 'printlisting', get_permalink($listing->post->ID)); ?>', 'print_window', 'height='+window_height+',width='+window_width+',left='+leftPosition+',top='+topPosition+',menubar=yes,scrollbars=yes');" rel="nofollow"><span class="w2dc-glyphicon w2dc-glyphicon-print"></span> <?php _e('Print listing', 'W2DC'); ?></a>
	<?php endif; ?>

	<?php if (get_option('w2dc_favourites_list')): ?>
	<a href="javascript:void(0);" class="add_to_favourites w2dc-btn w2dc-btn-primary" listingid="<?php echo $listing->post->ID; ?>" rel="nofollow"><span class="w2dc-glyphicon w2dc-glyphicon-<?php if (w2dc_checkQuickList($listing->post->ID)) echo 'heart-empty'; else echo 'heart'; ?>"></span> <span class="w2dc-bookmark-button"><?php if (w2dc_checkQuickList(get_the_ID())) _e('Удалить из ИЗБРАННОГО', 'W2DC'); else _e('Добавить в ИЗБРАННОЕ', 'W2DC'); ?></span></a>
	<?php endif; ?>

	<?php if(get_option('w2dc_24h_button')) { ?>
		<a class="set_24h w2dc-btn w2dc-btn-primary" data-action="<?= w2dc_show_24h_button($listing->post->ID, $listing->status) ? 'w2dc_renew_listing' : 'no-action' ?>" data-listingid="<?php echo $listing->post->ID; ?>" rel="nofollow"><span class="w2dc-glyphicon"></span><?php w2dc_show_24h_button($listing->post->ID, $listing->status) ? _e('Renew listing', 'W2DC') : _e('Public', 'W2DC'); ?></span></a>
	<?php } ?>
	<?php if(get_option('w2dc_interest_button')) { ?>
		<a class="interest_button w2dc-btn w2dc-btn-primary <?= w2dc_interest_check($listing->post->ID) ? 'interested' : ''; ?>" data-listingid="<?php echo $listing->post->ID; ?>" rel="nofollow"><span><?= w2dc_interest_check($listing->post->ID) ? __('Удалить из ИНТЕРЕС', 'W2DC') : __('Мне это интересно', 'W2DC'); ?></span></a>
	<?php } ?>
	<?php if (get_option('w2dc_pdf_button')): ?>
	<a href="javascript:void(0);" class="w2dc-pdf-listing-link w2dc-btn w2dc-btn-primary" onClick="window.open('http://pdfmyurl.com/?url=<?php echo urlencode(add_query_arg('w2dc_action', 'pdflisting', get_permalink($listing->post->ID))); ?>');" rel="nofollow"><span class="w2dc-glyphicon w2dc-glyphicon-save"></span> <?php _e('Save listing in PDF', 'W2DC'); ?></a>
	<?php endif; ?>
	<a href="viber://send?text=http://sdela.com/jobs/business-listing/26-03-18-%D0%BE%D1%82-%D0%BF%D0%B5%D1%82%D1%80%D0%BE%D0%B2%D0%B0-%D0%B7%D0%B0%D0%BA%D0%B0%D0%B7-azzy/">share viber</a>
	<a href="whatsapp://send">share WhatsApp</a>
<?php endif; ?>
