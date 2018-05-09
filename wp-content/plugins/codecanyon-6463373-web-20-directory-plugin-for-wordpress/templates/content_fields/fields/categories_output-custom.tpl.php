<?php if (has_term('', W2DC_CATEGORIES_TAX, $listing->post->ID)): ?>
	<?php
	$terms = get_the_terms($listing->post->ID, W2DC_CATEGORIES_TAX);
	foreach ($terms as $key => $term):?>
		<span class="category-item"><a href="<?php echo get_term_link($term, W2DC_CATEGORIES_TAX); ?>"><?php echo $term->name; echo ($key < count($terms) - 1) ? ',' : ''; ?></a> </span>
	<?php endforeach; ?>
<?php endif; ?>