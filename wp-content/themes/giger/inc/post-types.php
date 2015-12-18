<?php

add_action('init', 'tst_custom_content', 20);
if( !function_exists('tst_custom_content') ) {
function tst_custom_content(){

    /** Existing post types settings: */
    deregister_taxonomy_for_object_type('post_tag', 'post');
	remove_post_type_support('page', 'thumbnail' );
	
	if(defined('TST_HAS_AUTHORS') && TST_HAS_AUTHORS) {
		register_taxonomy('auctor', array('post',), array(
			'labels' => array(
				'name'                       => 'Авторы',
				'singular_name'              => 'Автор',
				'menu_name'                  => 'Авторы',
				'all_items'                  => 'Все авторы',
				'edit_item'                  => 'Редактировать автора',
				'view_item'                  => 'Просмотреть',
				'update_item'                => 'Обновить автора',
				'add_new_item'               => 'Добавить нового автора',
				'new_item_name'              => 'Название нового автора',
				'parent_item'                => 'Родительский автор',
				'parent_item_colon'          => 'Родительский автор:',            
				'search_items'               => 'Искать авторов',
				'popular_items'              => 'Часто используемые',
				'separate_items_with_commas' => 'Разделять запятыми',
				'add_or_remove_items'        => 'Добавить или удалить авторов',
				'choose_from_most_used'      => 'Выбрать из часто используемых',
				'not_found'                  => 'Не найдено'
			),
			'hierarchical'      => false,
			'show_ui'           => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'     => false,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array('slug' => 'auctor', 'with_front' => false),
			//'update_count_callback' => '',        
		));
	}
	
	register_taxonomy('org_cat', array('org',), array(
		'labels' => array(
			'name'                       => 'Категории организаций',
			'singular_name'              => 'Категория',
			'menu_name'                  => 'Категории',
			'all_items'                  => 'Все категории',
			'edit_item'                  => 'Редактировать категорию',
			'view_item'                  => 'Просмотреть',
			'update_item'                => 'Обновить категорию',
			'add_new_item'               => 'Добавить новую категорию',
			'new_item_name'              => 'Название новой категории',
			'parent_item'                => 'Родительская категория',
			'parent_item_colon'          => 'Родительская категория:',            
			'search_items'               => 'Искать категории',
			'popular_items'              => 'Часто используемые',
			'separate_items_with_commas' => 'Разделять запятыми',
			'add_or_remove_items'        => 'Добавить или удалить категории',
			'choose_from_most_used'      => 'Выбрать из часто используемых',
			'not_found'                  => 'Не найдено'
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => false,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'orgs', 'with_front' => false),
		//'update_count_callback' => '',        
	));
	
	
	register_taxonomy('person_cat', array('person',), array(
		'labels' => array(
			'name'                       => 'Категории персон',
			'singular_name'              => 'Категория',
			'menu_name'                  => 'Категории',
			'all_items'                  => 'Все категории',
			'edit_item'                  => 'Редактировать категорию',
			'view_item'                  => 'Просмотреть',
			'update_item'                => 'Обновить категорию',
			'add_new_item'               => 'Добавить новую категорию',
			'new_item_name'              => 'Название новой категории',
			'parent_item'                => 'Родительская категория',
			'parent_item_colon'          => 'Родительская категория:',            
			'search_items'               => 'Искать категории',
			'popular_items'              => 'Часто используемые',
			'separate_items_with_commas' => 'Разделять запятыми',
			'add_or_remove_items'        => 'Добавить или удалить категории',
			'choose_from_most_used'      => 'Выбрать из часто используемых',
			'not_found'                  => 'Не найдено'
		),
		'hierarchical'      => true,
		'show_ui'           => true,
		'show_in_nav_menus' => true,
		'show_tagcloud'     => false,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array('slug' => 'people', 'with_front' => false),
		//'update_count_callback' => '',        
	));
	
	
    /** Post types: */
    register_post_type('event', array(
        'labels' => array(
            'name'               => 'События',
            'singular_name'      => 'Событие',
            'menu_name'          => 'События',
            'name_admin_bar'     => 'Добавить событие',
            'add_new'            => 'Добавить новое',
            'add_new_item'       => 'Добавить событие',
            'new_item'           => 'Новое событие',
            'edit_item'          => 'Редактировать событие',
            'view_item'          => 'Просмотр события',
            'all_items'          => 'Все события',
            'search_items'       => 'Искать события',
            'parent_item_colon'  => 'Родительское событие:',
            'not_found'          => 'События не найдены',
            'not_found_in_trash' => 'В Корзине события не найдены'
       ),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        //'query_var'           => true,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'event', 'with_front' => false),
        'hierarchical'        => false,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-calendar',
        'supports'            => array('title', 'excerpt', 'editor', 'thumbnail'),
        'taxonomies'          => array(),
    ));
	
	register_post_type('project', array(
        'labels' => array(
            'name'               => 'Проекты',
            'singular_name'      => 'Проект',
            'menu_name'          => 'Проекты',
            'name_admin_bar'     => 'Добавить проект',
            'add_new'            => 'Добавить новый',
            'add_new_item'       => 'Добавить проект',
            'new_item'           => 'Новый проект',
            'edit_item'          => 'Редактировать проект',
            'view_item'          => 'Просмотр проекта',
            'all_items'          => 'Все проекты',
            'search_items'       => 'Искать проект',
            'parent_item_colon'  => 'Родительский проект:',
            'not_found'          => 'Проекты не найдены',
            'not_found_in_trash' => 'В Корзине проекты не найдены'
       ),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        //'query_var'           => true,
        'capability_type'     => 'post',
        'has_archive'         => 'projects',
        'rewrite'             => array('slug' => 'project', 'with_front' => false),
        'hierarchical'        => false,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-category',
        'supports'            => array('title', 'excerpt', 'editor', 'thumbnail'),
        'taxonomies'          => array(),
    ));

	register_post_type('org', array(
        'labels' => array(
            'name'               => 'Организации',
            'singular_name'      => 'Организация',
            'menu_name'          => 'Партнеры',
            'name_admin_bar'     => 'Добавить организацию',
            'add_new'            => 'Добавить новую',
            'add_new_item'       => 'Добавить организацию',
            'new_item'           => 'Новая организация',
            'edit_item'          => 'Редактировать организацию',
            'view_item'          => 'Просмотр организации',
            'all_items'          => 'Все организации',
            'search_items'       => 'Искать организации',
            'parent_item_colon'  => 'Родительская организация:',
            'not_found'          => 'Организации не найдены',
            'not_found_in_trash' => 'В Корзине организации не найдены'
       ),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        //'query_var'           => true,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'org', 'with_front' => false),
        'hierarchical'        => false,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-networking',
        'supports'            => array('title', 'excerpt', 'editor', 'thumbnail'),
        'taxonomies'          => array('org_cat'),
    ));
	
	register_post_type('person', array(
        'labels' => array(
            'name'               => 'Профили людей',
            'singular_name'      => 'Профиль',
            'menu_name'          => 'Люди',
            'name_admin_bar'     => 'Добавить профиль',
            'add_new'            => 'Добавить новый',
            'add_new_item'       => 'Добавить профиль',
            'new_item'           => 'Новый профиль',
            'edit_item'          => 'Редактировать профиль',
            'view_item'          => 'Просмотр профиля',
            'all_items'          => 'Все профили',
            'search_items'       => 'Искать профили',
            'parent_item_colon'  => 'Родительский профиль:',
            'not_found'          => 'Профили не найдены',
            'not_found_in_trash' => 'В Корзине профили не найдены'
       ),
        'public'              => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        //'query_var'           => true,
        'capability_type'     => 'post',
        'has_archive'         => false,
        'rewrite'             => array('slug' => 'profile', 'with_front' => false),
        'hierarchical'        => false,
        'menu_position'       => 5,
		'menu_icon'           => 'dashicons-groups',
        'supports'            => array('title', 'excerpt', 'editor', 'thumbnail'),
        'taxonomies'          => array('person_cat'),
    ));
	
	
}

} // if tst_custom_content


//add_action( 'p2p_init', 'apl_connection_types' );
//function apl_connection_types() {
//	p2p_register_connection_type( array(
//		'name' => 'project_post',
//		'from' => 'project',
//		'to'   => 'post',
//		'sortable'   => true,
//		'reciprocal' => false,
//		'prevent_duplicates' => true,
//		'admin_box' => array(
//			'show' => 'any',
//			'context' => 'normal',
//			'can_create_post' => true
//		),
//		'admin_column' => 'to'
//	) );
//}


/** Metaboxes **/
add_action( 'cmb2_admin_init', 'tst_custom_metaboxes' );
function tst_custom_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_tst_';

    /** Page **/
    $page_cmb = new_cmb2_box( array(
        'id'            => 'page_settings_metabox',
        'title'         => __( 'Page Settings', 'tst' ),
        'object_types'  => array( 'page', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		'show_on_cb'    => 'tst_show_on_general_pages',		
        //'cmb_styles'    => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    // Image
	$page_cmb->add_field( array(
		'name'    => __('Header Image', 'tst'),
		//'desc'    => 'Upload an image or enter an URL.',
		'id'      => 'header_img',
		'type'    => 'file',		
		'options' => array(
			'url' => false, // Hide the text input for the url
			'add_upload_file_text' => __('Add Image', 'tst') // Change upload button text. Default: "Add or Upload File"
		),
	));
	
	
	
	/** Attached Elements **/
	$att_cmb = new_cmb2_box( array(
        'id'            => 'attach_metabox',
        'title'         => __( 'Attached elements', 'tst' ),
        'object_types'  => array( 'page' ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		'show_on'       => array( 'key' => 'page-template', 'value' => 'default' ),	
        //'cmb_styles'  => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
	
	$att_cmb->add_field( array(
		'name'       => __( 'Attached Elements Title', 'tst' ),		
		'id'         => 'embed_posts_title',
		'type'       => 'text'		
	) );
	
	$att_cmb->add_field( array(
		'name'    => __( 'Post types', 'tst' ),		
		'id'      => 'embed_posts',
		'type'    => 'custom_attached_posts',
		'options' => array(
			'show_thumbnails' => false, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array('post_type'=> array('post', 'project', 'page', 'org')), // paging?
		)
	) );
	
	
	
	/** Post **/
    $post_cmb = new_cmb2_box( array(
        'id'            => 'post_settings_metabox',
        'title'         => __( 'Post Settings', 'tst' ),
        'object_types'  => array( 'post', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		//'show_on_cb'    => 'tst_show_on_general_pages',		
        //'cmb_styles'    => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    // Image
	$post_cmb->add_field( array(
		'name'    => __('Header Image', 'tst'),
		//'desc'    => 'Upload an image or enter an URL.',
		'id'      => 'header_img',
		'type'    => 'file',		
		'options' => array(
			'url' => false, // Hide the text input for the url
			'add_upload_file_text' => __('Add Image', 'tst') // Change upload button text. Default: "Add or Upload File"
		),
	));
	
	
	/** Project **/
    $project_cmb = new_cmb2_box( array(
        'id'            => 'project_settings_metabox',
        'title'         => __( 'Project Settings', 'tst' ),
        'object_types'  => array( 'project', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		//'show_on_cb'    => 'tst_show_on_general_pages',		
        //'cmb_styles'    => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    // Image
	$project_cmb->add_field( array(
		'name'    => __('Header Image', 'tst'),
		//'desc'    => 'Upload an image or enter an URL.',
		'id'      => 'header_img',
		'type'    => 'file',		
		'options' => array(
			'url' => false, // Hide the text input for the url
			'add_upload_file_text' => __('Add Image', 'tst') // Change upload button text. Default: "Add or Upload File"
		),
	));
	
	$project_cmb->add_field( array(
		'name'    => __( 'Text for support block', 'tst' ),		
		'id'      => 'support_block_text',
		'type'    => 'textarea_small',
		'desc'    => __( 'This will overrride default text', 'tst' ),
		'default' => TST_PROJECT_SUPPORT_TEXT,
	) );
	
	
	/** Events **/
	$event_cmb = new_cmb2_box( array(
        'id'            => 'event_settings_metabox',
        'title'         => __( 'Event Settings', 'tst' ),
        'object_types'  => array( 'event', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		//'show_on_cb'    => 'tst_show_on_general_pages',		
        //'cmb_styles'    => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );
		
	$event_cmb->add_field( array(
		'name' => __('Event Date', 'tst'),
		'id'   => 'event_date',
		'type' => 'text_date_timestamp',
		// 'timezone_meta_key' => 'wiki_test_timezone',
		'date_format' => 'd.m.Y',
	) );
	
	$event_cmb->add_field( array(
		'name' => __('Event Time', 'tst'),
		'id'   => 'event_time',
		'type' => 'text',		
		'desc' => __('Specify event time, ex. 16.30', 'tst')
	) );
	
	$event_cmb->add_field( array(
		'name' => __('Event Location', 'tst'),
		'id'   => 'event_location',
		'type' => 'text',		
		'desc' => __('Specify city and place of event', 'tst')
	) );
	
	$event_cmb->add_field( array(
		'name' => __('Event Addres', 'tst'),
		'id'   => 'event_address',
		'type' => 'text',		
		'desc' => __('Specify addres (without city)', 'tst')
	) );
	
	$event_cmb->add_field( array(
		'name'    => __('Header Image', 'tst'),
		//'desc'    => 'Upload an image or enter an URL.',
		'id'      => 'header_img',
		'type'    => 'file',		
		'options' => array(
			'url' => false, // Hide the text input for the url
			'add_upload_file_text' => __('Add Image', 'tst') // Change upload button text. Default: "Add or Upload File"
		),
	));
	
	
	
	/** Homepage **/	
    $home_cmb = new_cmb2_box( array(
        'id'            => 'home_settings_metabox',
        'title'         => __( 'Homepage Settings', 'tst' ),
        'object_types'  => array( 'page', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
		'show_on_cb'    => 'tst_show_on_home_page',		
        //'cmb_styles'    => false, // false to disable the CMB stylesheet
        // 'closed'     => true, // Keep the metabox closed by default
    ) );

    
	$home_cmb->add_field( array(
		'name'    => __('Header Image', 'tst'),
		//'desc'    => 'Upload an image or enter an URL.',
		'id'      => 'header_img',
		'type'    => 'file',		
		'options' => array(
			'url' => false, // Hide the text input for the url
			'add_upload_file_text' => __('Add Image', 'tst') // Change upload button text. Default: "Add or Upload File"
		),
	));
	
	//sections	
	$home_cmb->add_field( array(
		'name'    => __( 'Profiles - Order', 'tst' ),		
		'id'      => 'home_profiles_order',
		'type'    => 'select',		
		'default' => 'first',		
		'options' => array(
			'none' => __('Don\'t show', 'tst'),
			'first' => __('First section', 'tst'),
			'second' => __('Second section', 'tst'),
			'third' => __('Third section', 'tst'),
		)
	));
	
	$cats = get_terms('person_cat', array('hide_empty' => 0));
	$options = array();
	
	if(!empty($cats)){
		foreach($cats as $c){
			$options[$c->term_id] = esc_attr($c->name);
		}
		
		$home_cmb->add_field( array(
			'name'     => __('Profiles - Filter', 'tst'),		
			'id'       => 'home_profiles_cat',		
			'type'     => 'select',
			'show_option_none' => true,
			'options' => $options
		));
	}
	
	
	$home_cmb->add_field( array(
		'name'    => __( 'News - Order', 'tst' ),		
		'id'      => 'home_news_order',
		'type'    => 'select',		
		'default' => 'second',		
		'options' => array(
			'none' => __('Don\'t show', 'tst'),
			'first' => __('First section', 'tst'),
			'second' => __('Second section', 'tst'),
			'third' => __('Third section', 'tst'),
		)
	));
	
	$cats = get_terms('category', array('hide_empty' => 0));
	$options = array();
	
	if(!empty($cats)){
		foreach($cats as $c){
			$options[$c->term_id] = esc_attr($c->name);
		}
		
		$home_cmb->add_field( array(
			'name'     => __('News - Filter', 'tst'),		
			'id'       => 'home_news_cat',		
			'type'     => 'select',
			'show_option_none' => true,
			'options' => $options
		));
	}
		
	$home_cmb->add_field( array(
		'name'    => __( 'Projects section - Order', 'tst' ),		
		'id'      => 'home_projects_order',
		'type'    => 'select',		
		'default' => 'third',		
		'options' => array(
			'none' => __('Don\'t show', 'tst'),
			'first' => __('First section', 'tst'),
			'second' => __('Second section', 'tst'),
			'third' => __('Third section', 'tst'),
		)
	));
	
	//partners
	$home_cmb->add_field( array(
		'name'    => __( 'Partners', 'tst' ),		
		'id'      => 'home_partners',
		'type'    => 'custom_attached_posts',
		'options' => array(
			'show_thumbnails' => true, // Show thumbnails on the left
			'filter_boxes'    => true, // Show a text box for filtering the results
			'query_args'      => array('post_type'=> 'org'), // paging?
		)
	) );
}

/* callbacks */
function tst_show_on_general_pages($meta_box){
	global $post;
	
	$screen = get_current_screen();
	
	if($screen->post_type != 'page')
		return false;
	
	if(!isset($post->ID))
		return true;
	
	if($post->ID != get_option('page_on_front'))
		return true;
	
	return false;
}

function tst_show_on_home_page($meta_box){
	global $post;
	
	$screen = get_current_screen();
	
	if($screen->post_type != 'page')
		return false;
	
	if(!isset($post->ID))
		return false;
	
	if($post->ID == get_option('page_on_front'))
		return true;
	
	return false;
}


//add_action('all_admin_notices', function(){
//	var_dump(get_current_screen()->id);
//});