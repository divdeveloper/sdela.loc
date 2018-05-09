<div class="row w2dc-content-field">
	<?php if ($content_field->icon_image || !$content_field->is_hide_name): ?>
	<div class="field-title">
		<?php if ($content_field->icon_image): ?>
		<span class="w2dc-field-icon w2dc-fa w2dc-fa-lg <?php echo $content_field->icon_image; ?>"></span>
		<?php endif; ?>
		<?php if (!$content_field->is_hide_name): ?>
		<span class=""><?php echo $content_field->name?>:</span>
		<?php endif; ?>
</div>
	<?php endif; ?>
	<div class="field-value">
		<span class="price"><?php echo $formatted_price; ?> <?php echo $type_price; ?></span>
	</div>
</div>