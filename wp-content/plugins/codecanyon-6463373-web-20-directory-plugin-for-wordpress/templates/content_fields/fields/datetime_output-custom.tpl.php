<?php if ($start_date && $end_date): 
	$formatted_start_date = mysql2date(get_option('date_format'), date('Y-m-d', $start_date->value['date']));	
	$formatted_start_time = mysql2date(get_option('time_format'), date('H:i:s', $start_date->value['date']));	
	
	$formatted_end_date = mysql2date(get_option('date_format'), date('Y-m-d', $end_date->value['date']));	
	$formatted_end_time = mysql2date(get_option('time_format'), date('H:i:s', $end_date->value['date']));	
?>
<div class="row w2dc-field-output-block-<?php echo $content_field->type; ?> w2dc-field-output-block-<?php echo $content_field->id; ?>">
	<div class="col-xs-2"><?= _e('Время', 'W2DC') ?>:</div>

<div class="col-xs-10">
c <?= $formatted_start_date; ?> по <?= $formatted_end_date; ?> &nbsp;&nbsp;
c <?= $formatted_start_time; ?> до <?= $formatted_end_time; ?>
</div>
</div>
<?php endif; ?>

<!-- <?php //if ($content_field->icon_image || !$content_field->is_hide_name): ?>
	<span class="w2dc-field-caption">
		<?php //if ($content_field->icon_image): ?>
		<span class="w2dc-field-icon w2dc-fa w2dc-fa-lg <?php //echo $content_field->icon_image; ?>"></span>
		<?php //endif; ?>
		<?php //if (!$content_field->is_hide_name): ?>
		<span class="w2dc-field-name"><?php //echo $content_field->name?>:</span>
		<?php //endif; ?>
	</span>
	<?php //endif; ?>
	<span class="w2dc-field-content">
		<?php// echo $formatted_date; ?> <?php //if($content_field->is_time) echo $content_field->value['hour'] . ':' . $content_field->value['minute']; ?>
	</span> -->