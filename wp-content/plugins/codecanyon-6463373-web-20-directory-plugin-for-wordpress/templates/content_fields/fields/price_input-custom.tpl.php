	<label class="col-md-5 control-label"><?php echo $content_field->description ? $content_field->description : $content_field->name; ?></label>
	<div class="col-md-7">
		<input type="text" name="w2dc-field-input-<?php echo $content_field->id; ?>" class="w2dc-field-input-price form-control" value="<?php echo esc_attr($content_field->value); ?>" size="4" />
	</div>
