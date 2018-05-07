<div class="row w2dc-field-output-block-<?php echo $content_field->type; ?> w2dc-field-output-block-<?php echo $content_field->id; ?>">
	<?php if ($content_field->icon_image || !$content_field->is_hide_name): ?>
	<span class="col-xs-2">
		<?php if ($content_field->icon_image): ?>
		<span class="w2dc-field-icon w2dc-fa w2dc-fa-lg <?php echo $content_field->icon_image; ?>"></span>
		<?php endif; ?>
		<?php if (!$content_field->is_hide_name): ?>
		<span class=""><?php echo $content_field->name?>:</span>
		<?php endif; ?>
	</span>
	<?php endif; ?>
	<span class="col-xs-10">
		<?php echo $formatted_price; ?> <?php echo $type_price; ?>
	</span>
</div>