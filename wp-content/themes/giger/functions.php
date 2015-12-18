<?php
/**
 * Functions and definitions
 **/

define('TST_VERSION', '1.1');
define('TST_HAS_AUTHORS', true);
define('TST_DOC_URL', 'https://kms.te-st.ru/site-help/');
define('TST_DONORS_LIST_NUM', 20);
define('TST_PROJECT_SUPPORT_TEXT', 'Ваше пожертвование сделает жизнь детей с ОВЗ лучше и полнее, поможет им лучше адаптироваться в мире и сохранить здоровье.');

if ( ! isset( $content_width ) ) {
	$content_width = 760; /* px */
}

if ( ! function_exists( 'tst_setup' ) ) :
function tst_setup() {

	// Inits
	load_theme_textdomain('tst', get_template_directory() . '/lang');
//	add_theme_support( 'automatic-feed-links' );	
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Thumbnails
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(370, 208, true ); // regular thumbnails 16:9
	add_image_size('embed', 760, 420, true ); // fixed size for embedding 
	add_image_size('thumbnail-embed', 400, 260, true ); // large thumbnail for products
	add_image_size('avatar', 40, 40, true ); // fixed size for embedding
	add_image_size('thumbnail-landscape', 190, 142, true ); // fixed size for embedding
	

	// Menus
	register_nav_menus(array(
		'primary' => __('Primary Menu', 'tst'),				
		'social'  => __('Social Buttons', 'tst'),
		'sitemap' => __('Sitemap', 'tst')
	));

	// Editor style
	//add_editor_style(array('css/editor-style.css'));
}
endif; // tst_setup
add_action( 'after_setup_theme', 'tst_setup' );


/** Custom image size for medialib **/
add_filter('image_size_names_choose', 'tst_medialib_custom_image_sizes');
function tst_medialib_custom_image_sizes($sizes) {
	
	$addsizes = apply_filters('tst_medialib_custom_image_sizes', array(
		"thumbnail-landscape" => __("Landscape mini", 'tst'),
		"embed" => __('Fixed', 'tst')
	));
		
	return array_merge($sizes, $addsizes);
}


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tst_widgets_init() {
	
	$config = array(
		'right' => array(
						'name' => 'Правая колонка',
						'description' => 'Общая боковая колонка справа'
					),				
		'footer_1' => array(
						'name' => 'Футер - 1 кол.',
						'description' => 'Динамическая нижняя область - 1 колонка'
					),
		'footer_2' => array(
						'name' => 'Футер - 2 кол.',
						'description' => 'Динамическая нижняя область - 2 колонка'
					),
		'footer_3' => array(
						'name' => 'Футер - 3 кол.',
						'description' => 'Динамическая нижняя область - 3 колонка'
					),
		//'bottom' => array(
		//				'name' => 'Нижняя панель',
		//				'description' => 'Динамическая область на нижней панели'
		//			)
		
	);
	
	
	foreach($config as $id => $sb) {
		
		$before = '<div id="%1$s" class="widget %2$s">';
		
		if(false !== strpos($id, 'footer')){
			$before = '<div id="%1$s" class="widget-bottom %2$s">';
		}		
		
		register_sidebar(array(
			'name' => $sb['name'],
			'id' => $id.'-sidebar',
			'description' => $sb['description'],
			'before_widget' => $before,
			'after_widget' => '</div>',
			'before_title' => '<h5 class="widget-title">',
			'after_title' => '</h5>',
		));
	}
}
add_action( 'widgets_init', 'tst_widgets_init' );


/**
 * Includes
 */

require get_template_directory().'/inc/class-cssjs.php';
require get_template_directory().'/inc/class-statics.php';
require get_template_directory().'/inc/post-types.php';
require get_template_directory().'/inc/aq_resizer.php';
require get_template_directory().'/inc/extras.php';
require get_template_directory().'/inc/forms.php';
require get_template_directory().'/inc/template-tags.php';
require get_template_directory().'/inc/shortcodes.php';
require get_template_directory().'/inc/widgets.php';
require get_template_directory().'/inc/related.php';

require get_template_directory().'/inc/cards.php';
require get_template_directory().'/inc/events.php';
require get_template_directory().'/inc/calendar.php';


if(is_admin()){
	require get_template_directory() . '/inc/admin.php';
	
}
