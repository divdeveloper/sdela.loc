<label class="control-label"><?php echo $content_field->description ? $content_field->description : $content_field->name; ?></label>
<input type="number" min="0" step="0.01" max="1000000" name="w2dc-field-input-<?php echo $content_field->id; ?>" class="w2dc-field-input-price form-control" value="<?php echo esc_attr($content_field->value); ?>" size="4" />
