<?php

////////////////////////////////////////////////////////////////////
// Theme Information
////////////////////////////////////////////////////////////////////

    $themename = "DevDmBootstrap3";
    $developer_uri = "http://devdm.com";
    $shortname = "dm";
    $version = '1.80';
    load_theme_textdomain( 'devdmbootstrap3', get_template_directory() . '/languages' );

////////////////////////////////////////////////////////////////////
// include Theme-options.php for Admin Theme settings
////////////////////////////////////////////////////////////////////

   include 'theme-options.php';


////////////////////////////////////////////////////////////////////
// Enqueue Styles (normal style.css and bootstrap.css)
////////////////////////////////////////////////////////////////////
    function devdmbootstrap3_theme_stylesheets()
    {
        wp_register_style('bootstrap.css', get_template_directory_uri() . '/css/bootstrap.css', array(), '1', 'all' );
        wp_enqueue_style( 'bootstrap.css');
        //zk: дополнительные стили
        wp_enqueue_style( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css' );
        wp_enqueue_style( 'stylesheet', get_stylesheet_uri(), array(), '1', 'all' );
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css');
        wp_enqueue_style('files', get_template_directory_uri() . '/css/fileinput.min.css');
    }
    add_action('wp_enqueue_scripts', 'devdmbootstrap3_theme_stylesheets');

//Editor Style
add_editor_style('css/editor-style.css');

////////////////////////////////////////////////////////////////////
// Register Bootstrap JS with jquery
////////////////////////////////////////////////////////////////////
    function devdmbootstrap3_theme_js()
    {
        global $version;
        wp_enqueue_script('theme-js', get_template_directory_uri() . '/js/bootstrap.js',array( 'jquery' ),$version,true );
        wp_enqueue_script('files-js', get_template_directory_uri() . '/js/fileinput.min.js',array( 'jquery' ),$version,true );
        wp_enqueue_script('ru-js', get_template_directory_uri() . '/js/ru.js',array( 'files-js' ),$version,true );

	    //zk: дополнительные скрипты
        wp_enqueue_script( 'select2', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js', false, null, true );
        wp_enqueue_script( 'sdela', get_template_directory_uri() . '/js/sdela.js', array('select2', 'jquery'), $version, true);
        wp_enqueue_script( 'myuploadscript', get_template_directory_uri() . '/js/upload.js', array('jquery'), null, false );
	 	// подключаем все необходимые скрипты: jQuery, jquery-ui, datepicker
		//wp_enqueue_script('jquery-ui-datepicker');
		// подключаем нужные css стили
		//wp_enqueue_style('jqueryui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css', false, null );
    }
    add_action('wp_enqueue_scripts', 'devdmbootstrap3_theme_js');

////////////////////////////////////////////////////////////////////
// Add Title Tag Support with Regular Title Tag injection Fall back.
////////////////////////////////////////////////////////////////////

function devdmbootstrap3_title_tag() {
    add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'devdmbootstrap3_title_tag' );

if(!function_exists( '_wp_render_title_tag')) {

    function devdmbootstrap3_render_title() {
        ?>
        <title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php
    }
    add_action( 'wp_head', 'devdmbootstrap3_render_title' );

}

////////////////////////////////////////////////////////////////////
// Register Custom Navigation Walker include custom menu widget to use walkerclass
////////////////////////////////////////////////////////////////////

    require_once('lib/wp_bootstrap_navwalker.php');
    require_once('lib/bootstrap-custom-menu-widget.php');

////////////////////////////////////////////////////////////////////
// Register Menus
////////////////////////////////////////////////////////////////////

        register_nav_menus(
            array(
                'main_menu' => 'Main Menu',
                'footer_menu' => 'Footer Menu'
            )
        );

////////////////////////////////////////////////////////////////////
// Register the Sidebar(s)
////////////////////////////////////////////////////////////////////

        register_sidebar(
            array(
            'name' => 'Right Sidebar',
            'id' => 'right-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

        register_sidebar(
            array(
            'name' => 'Left Sidebar',
            'id' => 'left-sidebar',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(
            array(
            'name' => 'Footer Menu 1',
            'id' => 'footer-menu1',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(
            array(
            'name' => 'Footer Menu 2',
            'id' => 'footer-menu2',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(
            array(
            'name' => 'Footer Menu 3',
            'id' => 'footer-menu3',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(
            array(
            'name' => 'Register PopUp',
            'id' => 'register-popup',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));
        
        register_sidebar(
            array(
            'name' => 'Login PopUp',
            'id' => 'login-popup',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
        ));

////////////////////////////////////////////////////////////////////
// Register hook and action to set Main content area col-md- width based on sidebar declarations
////////////////////////////////////////////////////////////////////

add_action( 'devdmbootstrap3_main_content_width_hook', 'devdmbootstrap3_main_content_width_columns');

function devdmbootstrap3_main_content_width_columns () {

    global $dm_settings;

    $columns = '12';

    if ($dm_settings['right_sidebar'] != 0) {
        $columns = $columns - $dm_settings['right_sidebar_width'];
    }

    if ($dm_settings['left_sidebar'] != 0) {
        $columns = $columns - $dm_settings['left_sidebar_width'];
    }

    echo $columns;
}

function devdmbootstrap3_main_content_width() {
    do_action('devdmbootstrap3_main_content_width_hook');
}

////////////////////////////////////////////////////////////////////
// Add support for a featured image and the size
////////////////////////////////////////////////////////////////////

    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size(300,300, true);

////////////////////////////////////////////////////////////////////
// Adds RSS feed links to for posts and comments.
////////////////////////////////////////////////////////////////////

    add_theme_support( 'automatic-feed-links' );


////////////////////////////////////////////////////////////////////
// Set Content Width
////////////////////////////////////////////////////////////////////

if ( ! isset( $content_width ) ) $content_width = 800;

add_filter( 'geo_mashup_load_location_editor', 'filter_geo_mashup_load_location_editor' );

function filter_geo_mashup_load_location_editor( $load_flag ) {
	return true;
}

////////////////////////////////////////////////////////////////////
// Register check-date.jd
////////////////////////////////////////////////////////////////////
//function check_date_js()
//{
//    if ( is_page('119') ) {
//        global $version;
//        wp_enqueue_script('check-date-js', get_template_directory_uri() . '/js/check-date.js',array( 'jquery' ),$version,true );
//    }
//}
//add_action('wp_enqueue_scripts', 'check_date_js');


function bal_filter_users( $query ) {
	global $wpdb;
	$us = wp_get_current_user();
	if(current_user_can('administrator')){
		return 1;
	}
	if(!current_user_can('moderator_role')){
		return 1;
	}
	$group = $wpdb->get_var( "SELECT `group_id` FROM `".$wpdb->prefix."groups_user_group` WHERE `user_id` = '$us->ID'" );
	if($group){
		$users = $wpdb->get_col( "SELECT `user_id` FROM `".$wpdb->prefix."groups_user_group` WHERE `group_id` = '$group'" );
		if(is_array($users) && count($users)){
			foreach ($users as $value) {
				$query->query_vars['include'][] = $value;
			}
		}
	}else{
		$query->query_vars['include'][] = 0;
	}
	
	//$role = $us->roles ? $us->roles[0] : false;
//    $screen = get_current_screen();
//    if( is_admin() && 'users' == $screen->base ){
//        $query->set( 'role', 'Subscriber' );
//    }
}
add_action( 'pre_get_users', 'bal_filter_users' );

function bal_pre_get_posts( $query ) {
    if ( ! is_admin() ) {
        return;
    }

    global $wpdb, $pagenow;


    if ( 'edit.php' === $pagenow && 'w2dc_listing' === $query->query['post_type'] ) {
		$us = wp_get_current_user();
		if(current_user_can('administrator')){
			return 1;
		}
		if(!current_user_can('moderator_role')){
			return 1;
		}
		$group = $wpdb->get_var( "SELECT `group_id` FROM `".$wpdb->prefix."groups_user_group` WHERE `user_id` = '$us->ID'" );
		if($group){
			$users = $wpdb->get_col( "SELECT `user_id` FROM `".$wpdb->prefix."groups_user_group` WHERE `group_id` = '$group'" );
			if(is_array($users) && count($users)){
				$query->set( 'author__in', $users );
//				foreach ($users as $value) {
//					$query->query_vars['include'][] = $value;
//				}
			}
		}else{
			$query->set( 'author__in', array(0) );
		}		



    }

}
add_action( 'pre_get_posts', 'bal_pre_get_posts' );

function sdela_select_job_type($job_type_field) {
    $html = '';
    if (count($job_type_field->selection_items)) {
        $html .= '<div class="srs-filter-checks col-md-5 col-xs-12">';
        foreach ($job_type_field->selection_items as $key=>$item) {
            $html .= '<div class="col-md-6 col-xs-12 srs-filter-check-'.($key==1?'order':'service').'">';
            $html .= '<label class="control control--radio">'.$item;
            $html .= '<input type="radio" name="w2dc-field-input-'.$job_type_field->id.'" value="'.esc_attr($key).'" '.checked($job_type_field->value, $key, true).' />';
            $html .= '<div class="control__indicator"></div>';
            $html .= '</label>';
            $html .= '</div>';
        }
        $html .= '</div>';
    }
    return $html;
}
function sdela_select_categories($category_field, $subcategory_field, $post_id) {
    $html = '';
	if ($terms = sdela_get_w2dc_categories()) {
		$placeholder = $category_field->description ? $category_field->description : $category_field->name;

		$checked_categories_ids = array();
		$checked_categories = wp_get_object_terms($post_id, W2DC_CATEGORIES_TAX);
		foreach ($checked_categories AS $term)
			$checked_categories_ids[] = $term->term_id;

		$html .= '<div class="col-md-5 col-xs-12">';
		$html .= '<select id="w2dc-category" class="w2dc-field-input-select" data-placeholder="'.$placeholder.'" name="tax_input[' . W2DC_CATEGORIES_TAX . '][]">';
		$html .= '<option value=""></option>';
		$subcat_options = array('<option value=""></option>');
		foreach ($terms AS $term) {
			if (in_array($term->term_id, $checked_categories_ids))
				$selected = 'selected';
			else
				$selected = '';
			$subcategories = array();
            foreach (sdela_get_w2dc_categories($term->term_id) as $subterm) {
                $subcategories[] = $subterm->term_id;
                $subcat_options[] = '<option value="' . $subterm->term_id . '">' . $subterm->name . '</option>';
            }
			$html .= '<option ' . $selected . ' value="' . $term->term_id . '" data-children="'.json_encode($subcategories).'">' . $term->name . '</option>';
		}
		$html .= '</select>';
		$html .= '</div><div class="col-md-5 col-xs-12">';
		$placeholder = $subcategory_field->description ? $subcategory_field->description : $subcategory_field->name;
		$html .= '<select id="w2dc-field-input-subcategory" data-placeholder="'.$placeholder.'" name="tax_input[' . W2DC_CATEGORIES_TAX . '][]">';
		$html .= implode($subcat_options);
		$html .= '</select>';
		$html .= '</div>';
	}
    return $html;
}
function sdela_get_w2dc_categories($parent = 0) {
    return get_categories(array('taxonomy' => W2DC_CATEGORIES_TAX, 'pad_counts' => true, 'hide_empty' => false, 'parent' => $parent));
}

function sdela_select_datetime($field_start, $field_finish = null) {
	wp_enqueue_script( 'airdatepicker', get_template_directory_uri() . '/lib/airdatepicker/js/datepicker.js', array('jquery'), null, true);
	wp_enqueue_style( 'airdatepicker', get_template_directory_uri() . '/lib/airdatepicker/css/datepicker.css');
	wp_enqueue_script( 'clockpicker', get_template_directory_uri() . '/lib/clockpicker/bootstrap-clockpicker.js', array('jquery'), null, true);
	wp_enqueue_style( 'clockpicker', get_template_directory_uri() . '/lib/clockpicker/bootstrap-clockpicker.css');
    $html = <<<DATETIME
	<div class="col-md-6 col-xs-12">
	    <div class="srs-filter-date srs-filter-date-from">
	        <label>$field_start->name с </label>
			<input type="text" class="form-control">
			<i class="srs-filter-date-btn"></i>
		</div>
	    <div class="srs-filter-date srs-filter-date-to">
    		<label> по </label>
		    <input type="text" class="form-control">
		    <i class="srs-filter-date-btn"></i>
		</div>
	</div>	
	<div class="col-md-6 col-xs-12">
	    <div class="srs-filter-time srs-ft-from">
		    <label>Время от </label>
			<input type="text" class="form-control">
			<i class="srs-filter-time-btn"></i>
		</div>
	    <div class="srs-filter-time srs-ft-to">
    	    <label> до </label>
		    <input type="text" class="form-control">
	        <i class="srs-filter-time-btn"></i>
		</div>
	</div>
DATETIME;
    return $html;
}
