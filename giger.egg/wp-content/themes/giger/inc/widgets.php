<?php
/**
 * Widgets
 **/

 
add_action('widgets_init', 'tst_custom_widgets', 20);
function tst_custom_widgets(){

	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Calendar');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Tag_Cloud');
	unregister_widget('WP_Widget_RSS');
	unregister_widget('WP_Widget_Search');
	unregister_widget('FrmListEntries');
	unregister_widget('FrmShowForm');
	
	//Most of widgets do not perform well with MDL as for now
	unregister_widget('Leyka_Donations_List_Widget');
	unregister_widget('Leyka_Campaign_Card_Widget');
	unregister_widget('Leyka_Campaigns_List_Widget');
	unregister_widget('Su_Widget');
	unregister_widget('Ninja_Forms_Widget');	
	
	//register_widget('BB_RSS_Widget');
	//register_widget('BB_Recent_Posts_Widget');
	register_widget('TST_Featured_Product_Widget');
	register_widget('TST_Social_Links');
	//register_widget('TST_Related_Widget');
	
}

/** Featured Product **/
class TST_Featured_Product_Widget extends WP_Widget {
	
	/** Widget setup */
	function __construct() {
        		
		WP_Widget::__construct('widget_featured_product',  'Рекомендуемый товар', array(
			'classname'   => 'widget_featured_product',
			'description' => 'Рекомендуемые товар из каталога для приобретения'
		));	
	}
	
	
	/** Display widget */
	function widget($args, $instance) {
		global $post;
		
		extract($args, EXTR_SKIP);
		
		$cpost = get_post($instance['post_id']);
		if(empty($cpost))
			return;
		
		
		//markup
		echo $before_widget;
		
		tst_product_banner($cpost);
	
		echo $after_widget;
	}
	
	
	/** Update widget */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
				
		$instance['post_id']  = intval($new_instance['post_id']);
				
		return $instance;
	}
		

	/** Widget setting */
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array(					
			'post_id' => 0
		);

		$instance = wp_parse_args((array)$instance, $defaults);				
		$post_id = intval($instance['post_id']);
		
		$products = new WP_Query(array(
			'post_type' => 'product',
			'posts_per_page' => -1,
			'orderby' => 'title',
			'order' => 'ASC'
		));
		
	?>		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_id')); ?>">ID записи:</label>
			<select class="widefat" name="<?php echo $this->get_field_name('post_id'); ?>" id="<?php echo $this->get_field_id('post_id'); ?>">
				<option value="0">Выберите товар</option>
				<?php if(!empty($products->posts)) { foreach($products->posts as $pp) { ?>
					<option <?php selected($pp->ID, $post_id) ?> value="<?php echo intval($pp->ID); ?>"><?php echo esc_attr($pp->post_title); ?></option>
				<?php }} ?>
			</select>			
		</p>	
		
	<?php
	}
	
} // class end

// product banner markup
function tst_product_banner($cpost){
	
	
	$price = (function_exists('get_field')) ? get_field('product_price', $cpost->ID) : '';
	$img = tst_get_post_thumbnail_src($cpost, 'post-thumbnail');
?>

<div class="tpl-product-banner mdl-card mdl-shadow--2dp">
	<div class="mdl-card__title">
		<div class="mdl-card__title-text">
			<a href="<?php echo get_permalink($cpost);?>"><?php echo apply_filters('tst_the_title', $cpost->post_title);?></a>
		</div>		
	</div>
	<?php if(!empty($price)) { ?>
		<div class="price-mark"><?php echo number_format ((int)$price , 0 , "." , " " );?> руб.</div>
	<?php } ?>
	
	<div class="mdl-card__media mdl-card--expand" style="background-image: url(<?php echo $img;?>);">
		<?php //echo tst_get_post_thumbnail($cpost, 'post-thumbnail'); ?>
	</div>
	
	<div class="mdl-card__supporting-text">Средства пойдут на борьбу с инсультом</div>
	<div class="mdl-card__actions">
		<a href="<?php echo get_permalink($cpost);?>" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">Купить</a>	
	</div>
</div>

<?php	
}



/** Featured Post **/
class BB_Featured_Post_Widget extends WP_Widget {
	
	/** Widget setup */
	function __construct() {
        
		$widget_ops = array(
			'classname'   => 'widget_featured_post',
			'description' => 'Рекомендуемый отдельный материал'
		);
		$this->WP_Widget('widget_featured_post',  'Рекомендация', $widget_ops);	
	}

	
	/** Display widget */
	function widget($args, $instance) {
		global $post;
		
		extract($args, EXTR_SKIP);

		$title = apply_filters('widget_title', $instance['title']);
		$cpost = get_post($instance['post_id']);
		if(empty($cpost))
			return;
		
		
		//markup
		echo $before_widget;
		
		if($title)
			echo $before_title.$title.$after_title;
			
	?>
		<div class="fw-item">
			<div class="entry-thumbnail">
				<a href="<?php echo get_the_permalink($cpost);?>">
					<?php echo get_the_post_thumbnail($cpost->ID, 'post-thumbnail');?>
				</a>
				<?php echo get_the_term_list($cpost->ID, 'topic', '<div class="entry-topics">', ', ', '</div>');?>
			</div>
			
			<h1 class="entry-title">
				<a href="<?php echo get_the_permalink($cpost);?>"><?php echo get_the_title($cpost); ?></a>
			</h1>
			
			<div class="entry-summary"><?php echo apply_filters('tst_the_content', apl_get_excerpt_with_link($cpost));?></div>
		</div>
		
	<?php	
		echo $after_widget;
	}
	
	

	/** Update widget */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		
		$instance['title']  = sanitize_text_field($new_instance['title']);			
		$instance['post_id']  = intval($new_instance['post_id']);
				
		return $instance;
	}
	
	

	/** Widget setting */
	function form($instance) {

		/* Set up some default widget settings. */
		$defaults = array(
			'title'   => '',				
			'post_id' => 0
		);

		$instance = wp_parse_args((array)$instance, $defaults);
		
		$title = esc_attr($instance['title']);				
		$post_id = intval($instance['post_id']);				
	?>	
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Заголовок:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo $title; ?>">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('post_id')); ?>">ID записи:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('post_id')); ?>" name="<?php echo esc_attr($this->get_field_name('post_id')); ?>" type="text" value="<?php echo $post_id; ?>">
		</p>	
		
	<?php
	}
	
	
} // class end


/** Social Links Widget **/
class TST_Social_Links extends WP_Widget {
		
    function __construct() {
        WP_Widget::__construct('widget_socila_links', __('Social Buttons', 'tst'), array(
            'classname' => 'widget_socila_links',
            'description' => __('Social links menu with optional text', 'tst'),
        ));
    }

    
    function widget($args, $instance) {
        extract($args); 
		
        echo $before_widget;
       
		tst_get_social_menu();
				
		echo $after_widget;
    }
	
	
	
    function form($instance) {
	?>
        <p>Виджет не имеет настроек</p>
    <?php
    }

    
    function update($new_instance, $old_instance) {
        $instance = $new_instance;
		
		
        return $instance;
    }
	
} //class end