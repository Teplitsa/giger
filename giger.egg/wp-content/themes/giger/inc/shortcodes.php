<?php
/**
 * Shortcodes
 **/

add_filter('widget_text', 'do_shortcode');

add_shortcode('tst_sitemap', 'tst_sitemap_screen');
function tst_sitemap_screen($atts){
		
	$out =  wp_nav_menu(array('theme_location' => 'sitemap', 'container' => false, 'menu_class' => 'sitemap', 'echo'=> false));
	
	return $out;
}


/** Clear **/
add_shortcode('clear', 'tst_clear_screen');
function tst_clear_screen($atts){

	return '<div class="clear"></div>';
}

/** lead **/
add_shortcode('lead', 'tst_lead_screen');
function tst_lead_screen($atts, $content){
	
	if(empty($content))
		return '';
	
	return '<div class="entry-summary">'.apply_filters('the_content', $content).'</div>';
}

/** Buttons **/
add_shortcode('fab', 'tst_fab_screen');
function tst_fab_screen($atts){
	
	extract(shortcode_atts(array(				
		'url'  => ''
	), $atts));
	
	if(empty($url))
		return '';
	
	ob_start();
?>
<div class="fab"><a href="<?php echo $url;?>" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored"><svg class="mi"><use xlink:href="#pic-favorite_border" /></svg></a></div>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}

add_shortcode('tst_btn', 'tst_btn_screen');
function tst_btn_screen($atts){
	
	extract(shortcode_atts(array(				
		'url'  => '',
		'txt'  => ''
	), $atts));
	
	if(empty($url))
		return '';
	
	$url = esc_url($url);
	$txt = apply_filters('frl_the_title', $txt);
	
	ob_start();
?>
<span class="tst-btn"><a href="<?php echo $url;?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored"><?php echo $txt;?></a></span>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}



/** Partners gallery **/
add_shortcode('tst_partners_gallery', 'tst_partners_gallery_screen');
function tst_partners_gallery_screen($atts){
	
	extract(shortcode_atts(array(				
		'css'  => ''
	), $atts));
		
	$size = 'full'; // logo size
	
	$partners = new WP_Query(array(
		'post_type' => 'org',
		'posts_per_page' => -1,
		'orderby' => 'rand'
	));
		
	if(!$partners->have_posts())
		return '';
	
	ob_start();
	
	foreach($partners->posts as $p){
		tst_org_card($p);
	}
	
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}

add_shortcode('tst_cards_from_posts', 'tst_cards_from_posts');
function tst_cards_from_posts($atts) {

    extract(shortcode_atts(array(
        'ids' => '',
        'css'  => '',
        'pic_size' => 'full',
        'link_text' => 'Веб-сайт',
    ), $atts));

    /** @var $ids */
    /** @var $css */
    /** @var $pic_size */
    /** @var $link_text */

    $posts = get_posts(array(
        'post__in' => array_map('trim', explode(',', $ids)),
        'post_type' => 'any',
        'orderby' => array('menu_order' => 'DESC')
    ));

    ob_start();
?>

    <section class="embed-cards-gallery" <?php echo $css;?>>
    <div class="mdl-grid">
    <?php
		foreach($posts as $item) {
			$callback = "tst_".get_post_type($item)."_card";
			if(is_callable($callback)) {
				call_user_func($callback, $item);
			}
			else {
				tst_post_card($item);
			}	
		}
	?>
    </div>
    </section>

    <?php $out = ob_get_contents();
    ob_end_clean();

    return $out;
}


/** Toggle **/
if(!shortcode_exists( 'su_spoiler' ))
	add_shortcode('su_spoiler', 'tst_su_spoiler_screen');

function tst_su_spoiler_screen($atts, $content = null){
	
	extract(shortcode_atts(array(
        'title' => 'Подробнее',
        'open'  => 'no',
		'class' => ''
    ), $atts));
	
	if(empty($content))
		return '';
	
	$title = apply_filters('tst_the_title', $title);
	$class = (!empty($class)) ? ' '.esc_attr($class) : '';
	if($open == 'yes')
		$class .= ' toggled';
	
	ob_start();
?>
<div class="su-spoiler<?php echo $class;?>">
	<div class="su-spoiler-title"><span class="su-spoiler-icon"></span><?php echo $title;?></div>
	<div class="su-spoiler-content"><?php echo apply_filters('tst_the_content', $content);?></div>
</div>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}

/** Quote **/
add_shortcode('tst_quote', 'tst_quote_screen');
function tst_quote_screen($atts, $content = null) {
	
	extract(shortcode_atts(array(
        'name' => '',        
		'class' => ''
    ), $atts));
	
	if(empty($content))
		return '';
	
	$name = apply_filters('tst_the_title', $name);
	$class = (!empty($class)) ? ' '.esc_attr($class) : '';
	ob_start();
?>
<div class="tst-quote <?php echo $class;?>">	
	<div class="tst-quote-content"><?php echo apply_filters('tst_the_content', $content);?></div>
	<?php if(!empty($name)) { ?>
		<div class="tst-quote-cite"><?php echo $name;?></div>
	<?php } ?>
</div>
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}



/** Tabs */
add_shortcode('tst_tabs', 'tst_tabs_screen');
function tst_tabs_screen($atts, $content = null) {	
	
	$defaults = array('class' => 'default');

	extract(shortcode_atts($defaults, $atts ));

	$css = esc_attr("mdl-tabs mdl-js-tabs mdl-js-ripple-effect ".$class);

	/* Extract the tab titles */
	preg_match_all( '/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE );

	$tab_titles = array();
	$titles_html = '';
	if(isset($matches[1]))
		$tab_titles = $matches[1];
	
	/* Build tabs reference list */
	if(!empty($tab_titles)){ 
		
		$list = array();
		foreach($tab_titles as $i => $t){
			$tab_id = sanitize_title($t[0]);
			$active = ($i == 0) ? ' is-active' : '';
			
			$list[$i] = "<a href='#{$tab_id}' class='mdl-tabs__tab{$active}'>";
			$list[$i] .= apply_filters('tst_the_title', $t[0])."</a>\n";
		}
		
		$titles_html = "<div class='mdl-tabs__tab-bar'>".implode('', $list)."</div>";
	}
	

	$out ="<div class='{$css}'>";
	$out .= $titles_html;	
	$out .= do_shortcode(shortcode_unautop(trim($content)));
	$out .= "</div>";	
	
	$out = preg_replace('!<br />(\s*<?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $out);
	$out = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $out);
	
	return  $out;
} 

add_shortcode('tab', 'tst_tab_screen');
function tst_tab_screen($atts, $content = null) {
		
	$defaults = array('title' => 'Tab');
	extract(shortcode_atts($defaults, $atts));
	
	$tab_id = esc_attr(sanitize_title($title));			
	
	$out = "<div class='mdl-tabs__panel' id='{$tab_id}'>".apply_filters('tst_the_content', $content)."</div>";
	
	return $out;
}
