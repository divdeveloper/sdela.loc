<?php if (count($content_field->selection_items)): ?>
	<label class="col-md-5 control-label"><?php echo $content_field->description ? $content_field->description : $content_field->name; ?></label>
	<div class="w2dc-col-md-7">
		<select name="w2dc-field-input-<?php echo $content_field->id; ?>" class="w2dc-field-input-select form-control">
			<?php foreach ($content_field->selection_items AS $key=>$item): ?>
			<option value="<?php echo esc_attr($key); ?>" <?php selected($content_field->value, $key, true); ?>><?php echo $item; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
<?php endif; ?>