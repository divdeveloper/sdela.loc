<?php if (has_term('', W2DC_CATEGORIES_TAX, $listing->post->ID)): ?>
<div class="w2dc-field-output-block w2dc-field-output-block-<?php echo $content_field->type; ?> w2dc-field-output-block-<?php echo $content_field->id; ?>">
	<span class="w2dc-field-content">
		<?php
		$terms = get_the_terms($listing->post->ID, W2DC_CATEGORIES_TAX);
		foreach ($terms as $key => $term):?>
			<span class="w2dc-label"><a href="<?php echo get_term_link($term, W2DC_CATEGORIES_TAX); ?>" rel="tag"><?php echo $term->name; echo ($key < count($terms) - 1) ? ',' : ''; ?></a> </span>
		<?php endforeach; ?>
	</span>
</div>
<?php endif; ?>