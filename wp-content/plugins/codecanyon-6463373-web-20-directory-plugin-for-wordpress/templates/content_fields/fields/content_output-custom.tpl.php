<?php if (!empty($listing->post->post_content)): ?>
<div class="row w2dc-content-field">
	<div class="field-title">
	<?=__('Детали', 'W2DC'); ?>:
	</div>
	<div class="field-value" itemprop="description">
		<?php add_filter('the_content', 'wpautop'); ?>
		<?php the_content(); ?>
		<?php remove_filter('the_content', 'wpautop'); ?>
	</div>
</div>
<?php endif; ?>