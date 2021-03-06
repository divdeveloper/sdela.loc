<?php 

class w2dc_content_field_content extends w2dc_content_field {
	protected $can_be_ordered = false;
	protected $is_categories = false;
	protected $is_slug = false;
	
	public function isNotEmpty($listing) {
		if (post_type_supports(W2DC_POST_TYPE, 'editor') && !empty($listing->post->post_content))
			return true;
		else
			return false;
	}

	public function validateValues(&$errors, $data) {
		$listing = w2dc_getCurrentListingInAdmin();
		if (post_type_supports(W2DC_POST_TYPE, 'editor') && $this->is_required && (!isset($data['post_content']) || !$data['post_content']))
			$errors[] = __('Listing content is required', 'W2DC');
		else
			return $listing->post->post_content;
	}
	
	public function renderOutput($listing) {
		if (!($template = w2dc_isTemplate('content_fields/fields/content_output_'.$this->id.'.tpl.php'))) {
			$template = 'content_fields/fields/content_output.tpl.php';
		}
		
		$template = apply_filters('w2dc_content_field_output_template', $template, $this, $listing);
			
		w2dc_renderTemplate($template, array('content_field' => $this, 'listing' => $listing));
	}
	
	public function renderOutputForMap($location, $listing) {
		return wpautop($listing->post->post_content);
	}
}
?>