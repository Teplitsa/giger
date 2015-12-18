<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bb
 */

/* CPT Filters */
//add_action('parse_query', 'tst_request_corrected');
function tst_request_corrected($query) {
	
	if(is_admin())
		return;
	
	if(!$query->is_main_query())
		return;
	
	if(is_search()){
		
		$per = get_option('posts_per_page');
		if($per < 25) {
			$query->query_vars['posts_per_page'] = 15; // 25
		}
	}
	
	
} 

function tst_has_authors(){
		
	if(defined('TST_HAS_AUTHORS') && TST_HAS_AUTHORS && function_exists('get_term_meta'))
		return true;
	
	return false;
}

function tst_get_post_id_from_posts($posts){
		
	$ids = array();
	if(!empty($posts)){ foreach($posts as $p) {
		$ids[] = $p->ID;
	}}
	
	return $ids;
}

/* Custom conditions */
function is_about(){
	global $post;
		
	if(is_page_branch(2))
		return true;
	
	if(is_post_type_archive('org'))
		return true;
	
	if(is_post_type_archive('org'))
		return true;
	
	return false;
}

function is_page_branch($pageID){
	global $post;
	
	if(empty($pageID))
		return false;
		
	if(!is_page() || is_front_page())
		return false;
	
	if(is_page($pageID))
		return true;
	
	if($post->post_parent == 0)
		return false;
	
	$parents = get_post_ancestors($post);
	
	if(is_string($pageID)){
		$test_id = get_page_by_path($pageID)->ID;
	}
	else {
		$test_id = (int)$pageID;
	}
	
	if(in_array($test_id, $parents))
		return true;
	
	return false;
}


function is_tax_branch($slug, $tax) {
	global $post;
	
	$test = get_term_by('slug', $slug, $tax);
	if(empty($test))
		return false;
	
	if(is_tax($tax)){
		$qobj = get_queried_object();
		if($qobj->term_id == $test->term_id || $qobj->parent == $test->term_id)
			return true;
	}
	
	if(is_singular() && is_object_in_term($post->ID, $tax, $test->term_id))
		return true;
	
	return false;
}


function is_posts() {
	
	if(is_home() || is_category())
		return true;	
	
	if(tst_has_authors() && is_tax('auctor'))
		return true;
	
	if(is_singular('post'))
		return true;
	
	return false;
}

function is_events() {	
		
	if(is_post_type_archive('event') || is_page('calendar'))
		return true;
		
	if(is_singular('event'))
		return true;
	
	return false;
}

function is_projects() {	
		
	if(is_post_type_archive('project'))
		return true;
		
	if(is_singular('project'))
		return true;
		
	return false;
}


/** Menu filter sceleton **/
add_filter('wp_nav_menu_objects', 'tst_custom_menu_items', 2, 2);
function tst_custom_menu_items($items, $args){			
	
	if(empty($items))
		return;	
	
	//var_dump($args);
	if($args->theme_location =='primary'){
		
		foreach($items as $index => $menu_item){
			if(in_array('current-menu-item', $menu_item->classes))
				$items[$index]->classes[] = 'active';
		}
	}
	
	
	return $items;
}
 
/** HTML with meta information for the current post-date/time and author **/
function tst_posted_on($cpost) {
			
	if(is_int($cpost))
		$cpost = get_post($cpost);
			
	$meta = array();
	$sep = '';
	
	if('post' == $cpost->post_type){
		$label = __('in the category', 'tst');
		$meta[] = "<time class='date'>".esc_html(get_the_date('d.m.Y', $cpost))."</time>";
		$meta[] = get_the_term_list($cpost->ID, 'category', '<span class="category">'.$label.' ', ', ', '</span>');
		$sep = ' ';
	}
	if('project' == $cpost->post_type){
		
		$meta[] = "<time class='date'>".esc_html(get_the_date('d.m.Y', $cpost))."</time>";		
	}
		
	return implode($sep, $meta);		
}

/** Logo **/
function tst_site_logo($size = 'regular') {

	switch($size) {
		case 'context':
			$file = 'plain-logo-accent';
			break;
		case 'small':
			$file = 'plain-logo-small';
			break;
		default:
			$file = 'pic-logo';
			break;	
	}
	
	$file = esc_attr($file);	
?>
<svg class="logo <?php echo $file;?>">
	<use xlink:href="#<?php echo $file;?>" />
</svg>
<?php
}


/** Separator **/
function tst_get_sep($mark = '//') {
	
	return "<span class='sep'>".$mark."</span>";
}

/** CPT archive title **/
function tst_get_post_type_archive_title($post_type) {
	
	$pt_obj = get_post_type_object( $post_type );	
	$name = $pt_obj->labels->menu_name;
	
	
	return $name;
}

// loader panel
function tst_loader_panel(){

	return '<div class="loader-panel"><div class="spinner"></div></div>';

}


function tst_material_icon($icon){
	
	$icon = esc_attr($icon);
	return "<i class='material-icons'>{$icon}</i>";
}


/** Header image **/
function tst_header_image_url(){
	
	$img = '';
	if(is_tax()){
		$qo = get_queried_object();
		$img = (function_exists('get_field')) ? get_field('header_img', $qo->taxonomy.'_'.$qo->term_id) : 0;
		$img = wp_get_attachment_url($img);
	}
	elseif(is_single() || is_page()){
		$qo = get_queried_object();
		$img = get_post_meta($qo->ID,'header_img', true);		
		//$img = wp_get_attachment_url($img);
	}
	
	if(empty($img)){ // fallback
		
		$img = tst_get_default_header_img();
	}
	
	return $img;
}

/** Deafult thumbnail for posts **/
function tst_get_default_header_img(){
		
	$img = get_theme_mod('default_header');
	if(empty($img)){
		$color = get_theme_mod('color_scheme', 'default');
		$img = get_template_directory_uri()."/assets/images/header-{$color}.jpg";
	}
	
	return $img;
}



/** == NAVs == **/

/* Nav in loops */
function tst_paging_nav($query = null) {
	global $wp_query;
	
	if(!$query)
		$query = $wp_query;
	
	
	// Don't print empty markup if there's only one page.
	if ($query->max_num_pages < 2 ) {
		return;
	}
		
	$p = tst_load_more_link($query, false);	
	if(!empty($p)) {
		$p = "<div class='paging-navigation'>$p</div>";
	}

	return $p;
}

add_filter('next_posts_link_attributes', 'tst_load_more_link_css');
function tst_load_more_link_css($attr){
	
	$attr = " class='mdl-button mdl-js-button mdl-js-ripple-effect'";
	
	return $attr;
}

function tst_load_more_link($query = null, $echo = true) {
	global $wp_query;
	
	if(!$query)
		$query = $wp_query;
	
	$label = __('More entries', 'tst');
	if(is_search()){
		$label = __('More results', 'tst');
	}
	elseif(isset($query->posts[0])){
		switch($query->posts[0]->post_type){
			case 'post':
				$label = __('More news', 'tst');
				break;
			case 'project':
				$label = __('More projects', 'tst');
				break;
			case 'org':
				$label = __('More orgs', 'tst');
				break;	
		}
	}
	
	$l = get_next_posts_link($label, $query->max_num_pages);
	if(empty($l) && $query->get('paged') > 1){ //last page
		$link = get_pagenum_link(0);
		$l = "<a href='{$link}' ".tst_load_more_link_css('').">".__('To the beginning', 'tst')."</a>";
	}
	
	if($echo){
		echo $l;
	}
	else {
		return $l;
	}	
}


/** Breadcrumbs  **/
function tst_breadcrumbs(){
	global $post;
		
	$links = array();
	if(is_front_page()){
		$links[] = "<span class='crumb-name'>".get_bloginfo('name')."</span>";
	}
	elseif(is_singular('post')) {
		
		$cat = get_the_terms($post->ID, 'category');
		if(!empty($cat)){
			$links[] = "<a href='".get_term_link($cat[0])."' class='crumb-link'>".apply_filters('tst_the_title', $cat[0]->name)."</a>";
		}			
	}
	elseif(is_singular('event')) {
		
		$p = get_page_by_path('calendar');
		$links[] = "<a href='".get_permalink($p)."' class='crumb-link'>".get_the_title($p)."</a>";		
	}
	elseif(is_page() || is_singular('leyka_campaign')){
		//@to-do - if treee ?
		$links[] = "<span class='crumb-name'>".get_the_title($post)."</span>";
	}
	elseif(is_home()){
		$p = get_post(get_option('page_for_posts'));
		if($p)
			$links[] = "<span class='crumb-name'>".get_the_title($p)."</span>";
	}
	elseif(is_category()){	
			
		$links[] = "<span class='crumb-name'>".single_cat_title('', false)."</span>";
	}
	elseif(is_post_type_archive('project')) {
		$links[] = "<span class='crumb-name'>".tst_get_post_type_archive_title('project')."</span>";
		
	}
	elseif(is_post_type_archive('org')) {
		$links[] = "<span class='crumb-name'>".tst_get_post_type_archive_title('org')."</span>";
		
	}
	elseif(is_singular('project')) {		
		$links[] = "<a href='".get_post_type_archive_link('project')."' class='crumb-link'>".tst_get_post_type_archive_title('project')."</a>";
		
	}
	
	$sep = '';
	
	return "<div class='crumbs'>".implode($sep, $links)."</div>";	
}


/** Next link **/
function tst_next_link($cpost){	
	
	if($cpost->post_type == 'event'){
		
		//get next event
		$news_query = new WP_Query(array(
			'post_type' => 'event',			
			'meta_key' => 'event_date',
			'orderby' => 'meta_value',
			'order' => 'ASC', 
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key'     => 'event_date',
					'value'   => get_post_meta($cpost->ID, 'event_date', true),
					'compare' => '>', // '>' to get a chronologically next event
				),
			),
		));
		
		if(!$news_query->have_posts()){
			$news_query = new WP_Query(array(
				'post_type' => 'event',			
				'meta_key' => 'event_date',
				'orderby' => 'meta_value',
				'order' => 'ASC', 
				'posts_per_page' => 1				
			));
		}
		$next = '';
		
		if(isset($news_query->posts[0]) && $news_query->posts[0]->ID != $cpost->ID){
			$label = __('Next item', 'tst');
			$next = "<a href='".get_permalink($news_query->posts[0])."' rel='next'>".$label." &raquo;</a>";
		}
	}
	else {
		$label = __('Next item', 'tst');
		$next =  get_next_post_link('%link', $label.' &raquo;', true);
		if(empty($next)) {
			$next = tst_next_fallback_link($cpost);
		}
	}
		
	return $next;				
}

function tst_next_fallback_link($cpost){	
			
	$args = array(
		'post_type' => $cpost->post_type,
		'posts_per_page' => 1,
		'orderby' => 'date',
		'order' => 'ASC'
	);
		
	$query = new WP_Query($args);
	$link = '';
	
	if(isset($query->posts[0]) && $query->posts[0]->ID != $cpost->ID){
		$label = __('Next item', 'tst');
		$link = "<a href='".get_permalink($query->posts[0])."' rel='next'>{$label}&nbsp;&raquo;</a>";
	}
	
	return $link;
}





/** == Summary helpers == **/

/** Excerpt  **/
function tst_get_post_excerpt($cpost, $l = 30, $force_l = false){
	
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = (!empty($cpost->post_excerpt)) ? $cpost->post_excerpt : wp_trim_words(strip_shortcodes($cpost->post_content), $l);
	if($force_l)
		$e = wp_trim_words($e, $l);	
	
	return $e;
}

function tst_card_summary($summary_content){
			
	$text = apply_filters('tst_the_content', $summary_content);
	$text = '<div class="card-summary mdl-card__supporting-text mdl-card--expand">'.$text.'</div>';
		
	return $text;
}

/** Deafult thumbnail for posts **/
function tst_get_default_post_thumbnail($size){
		
	$default_thumb_id = attachment_url_to_postid(get_theme_mod('default_thumbnail'));
	$img = '';
	if($default_thumb_id){
		$img = wp_get_attachment_image($default_thumb_id, $size);	
	}
	
	return $img;
}





/** == Authors == **/

/** Default author avatar **/
function tst_get_default_author_avatar(){
	
	$alt = __('Author', 'tst');
	$img = '';
	
	$def_img_id = attachment_url_to_postid(get_theme_mod('default_avatar'));
	if(!empty($def_img_id)){
		$img = 	wp_get_attachment_image($def_img_id, 'thumbnail', array('alt' => $alt));
	}
	else {		
		$img = "<img src='".get_template_directory_uri()."/assets/images/author-default.jpg' alt='{$alt}'>";
	}
		
	return $img;
}

/** Author **/
function tst_get_post_author($cpost) {
	
	if(!tst_has_authors())
		return false;
		
	$author = get_the_terms($cpost->ID, 'auctor');
	if(!empty($author) && !is_wp_error($author))
		$author = $author[0];
	
	return $author;
}

function tst_get_author_avatar($author_term_id) {

	$avatar = get_term_meta($author_term_id, 'auctor_photo', true);

    return $avatar ? wp_get_attachment_image($avatar, 'avatar') : tst_get_default_author_avatar();
}



/** Newsletter modal **/
add_action('tst_footer_position', 'tst_newsletter_modal');
function tst_newsletter_modal(){
	
	$id = get_theme_mod('newsletter_form_id');
	
	if(!$id)
		return;
?>
	<div class="nl-modal mdl-shadow--6dp" id="modal-newsletter">
	<?php
		if ( function_exists( 'ninja_forms_display_form' ) )
			ninja_forms_display_form( $id );
	?>
	</div>
<?php
}