<?php if (!empty($listing->post->post_content)): ?>
<div class="row w2dc-field-output-block-<?php echo $content_field->type; ?> w2dc-field-output-block-<?php echo $content_field->id; ?>">
	<div class="col-xs-2">
	<?=__('Детали', 'W2DC'); ?>:
	</div>
	<div class="col-xs-10 w2dc-field-description" itemprop="description">
		<?php add_filter('the_content', 'wpautop'); ?>
		<?php the_content(); ?>
		<?php remove_filter('the_content', 'wpautop'); ?>
	</div>
</div>
<?php endif; ?>