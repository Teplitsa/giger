<?php
/**
 * Events related functions and template tags
 **/

function tst_event_meta($cpost = null) {
	global $post;
		
	if(!$cpost)
		$cpost = $post; 
	
	
	$date = get_post_meta($cpost->ID, 'event_date', true); 
	$time = get_post_meta($cpost->ID, 'event_time', true);
	$lacation = get_post_meta($cpost->ID, 'event_location', true);
	$addr  = get_post_meta($cpost->ID, 'event_address', true);
	
	if(!empty($date)){
		echo "<div class='em-field date-field'>";
		echo "<div class='em-label mdl-typography--caption'>".__('Event date', 'tst').":</div>";
		echo "<div class='em-date mdl-typography--body-1'>".date('d.m.Y', $date)."</div>";
		tst_add_to_calendar_link($cpost);
		echo "</div>";
	}
	if(!empty($time)){
		echo "<div class='em-field'>";
		echo "<div class='em-label mdl-typography--caption'>".__('Time', 'tst').":</div>";
		echo "<div class='em-time mdl-typography--body-1'>".apply_filters('tst_the_title', $time)."</div>";
		echo "</div>";
	}
	if(!empty($lacation)){
		echo "<div class='em-field'>";
		echo "<div class='em-label mdl-typography--caption'>".__('Location', 'tst').":</div>";
		echo "<div class='em-location mdl-typography--body-1'>".apply_filters('tst_the_title', $lacation)."</div>";
		echo "</div>";
	}
	if(!empty($addr)){
		echo "<div class='em-field'>";
		echo "<div class='em-label mdl-typography--caption'>".__('Address', 'tst').":</div>";
		echo "<div class='em-addr mdl-typography--body-1'>".apply_filters('tst_the_title', $addr)."</div>";
		echo "</div>";
	}
	
}

function tst_is_future_event($date) {
	
	$today_exact = strtotime(sprintf('now %s hours', get_option('gmt_offset')));
	$today_mark = date('Y', $today_exact).'-'.date('m', $today_exact).'-'.date('d', $today_exact);
	$stamp = date('Y-m-d', $date);
		
	
	if((string)$stamp >= (string)$today_exact) {
		return true;
	}
	else {
		return false;
	}
}

function tst_event_card($event){
	
	$img_id = get_post_thumbnail_id($event->ID);
	$img = wp_get_attachment_image_src($img_id, 'post-thumbnail');
		
	$date = get_post_meta($event->ID, 'event_date', true); 
	$time = get_post_meta($event->ID, 'event_time', true);
	$location = get_post_meta($event->ID, 'event_location', true);
	$addr  = get_post_meta($event->ID, 'event_address', true);
	
	$pl = get_permalink($event);
	
	$e = (!empty($event->post_excerpt)) ? $event->post_excerpt : wp_trim_words(strip_shortcodes($event->post_content), 20);
	
	ob_start();
?>	
	<div class="mdl-card__media" style="background-image: url(<?php echo (isset($img[0])) ? $img[0] : '';?>);?>">
		
	</div>
	
	<div class="event-content-frame">
		<div class="mdl-card__title">
			<h4 class="mdl-card__title-text"><a href="<?php echo $pl;?>"><?php echo get_the_title($event);?></a></h4>
		</div>	
		<div class="event-meta">
			<div class="pictured-card-item event-date">
				<div class="em-icon pci-img"><?php echo tst_material_icon('schedule'); ?></div>				
				<div class="em-content pci-content">
					<h5 class="mdl-typography--body-1"><?php echo date('d.m.Y', $date);?></h5>
					<p class="mdl-typography--caption"><?php echo apply_filters('tst_the_title', $time); ?></p>
					<?php
						if(tst_is_future_event($date)){
							tst_add_to_calendar_link_in_modal($event, true, 'in-modal-add-tip');
						}
					?>
				</div>
			</div>
			<div class="pictured-card-item event-location">
				<div class="em-icon pci-img"><?php echo tst_material_icon('room'); ?></div>				
				<div class="em-content pci-content">
					<h5 class="mdl-typography--body-1"><?php echo apply_filters('tst_the_title', $location); ?></h5>
					<p class="mdl-typography--caption"><?php echo apply_filters('tst_the_title', $addr); ?></p>
				</div>
			</div>	
		</div>	
		<div class="mdl-card__supporting-text"><?php echo apply_filters('tst_the_title', $e);?></div>
	</div>	
	
	<div class="mdl-card__actions mdl-card--border">		
		<a href="<?php echo $pl;?>" class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect"><?php _e('Participate', 'tst');?></a>
	</div>
	
<?php
	$out = ob_get_contents();
	ob_end_clean();
	
	return $out;
}


function tst_compact_event_item($cpost){
	
	$pl = get_permalink($cpost);	
	$e_date = get_post_meta($cpost->ID, 'event_date', true); 
	$thumb = get_the_post_thumbnail($cpost->ID, 'avatar');
	if(empty($thumb))
		$thumb = tst_get_default_post_thumbnail('avatar');
?>
<div class="tpl-compact-event">	
	<div class="pictured-card-item">
		<div class="event-avatar round-image pci-img">
			<?php echo $thumb; ?>
		</div>
			
		<div class="event-content pci-content">
			<h5 class="event-title mdl-typography--body-1"><a href="<?php echo $pl; ?>">
				<?php echo get_the_title($cpost);?>
			</a></h5>
			<p class="event-date mdl-typography--caption"><time><?php echo date_i18n('d.m.Y', $e_date);?></time></p>
			<div class="add-to-calendar">
				<?php tst_add_to_calendar_link($cpost);?>
			</div>
		</div>		
	</div>	
</div>
<?php
}


//Details at http://addtocalendar.com/
function tst_add_to_calendar_link($event, $echo = true, $container_class = 'tst-add-calendar') {	
	
	$date = get_post_meta($event->ID, 'event_date', true);
	$time = get_post_meta($event->ID, 'event_time', true);
	$loct = get_post_meta($event->ID, 'event_location', true);
	$addr = get_post_meta($event->ID, 'event_address', true);
	
	if(empty($time))
		$time = '12.00';
	
	if(empty($date))
		return;
	
	wp_enqueue_script(
		'atc',
		get_template_directory_uri().'/assets/js/atc.min.js',
		array(),
		null,
		true
	);
		
	$start = date('d.m.Y', $date).' '.$time;	
	$start_mark = date_i18n('Y-m-d H:i:00', strtotime($start));
	$end_mark = date_i18n('Y-m-d H:i:00', strtotime('+2 hours '.$start));
	$e = (!empty($event->post_excerpt)) ? wp_trim_words($event->post_excerpt, 20) : wp_trim_words(strip_shortcodes($event->post_content), 20);
	$id = 'tst-'.uniqid();
?>
	<span id="<?php echo esc_attr($id);?>"  class="<?php echo esc_attr($container_class);?>">
		<span class="addtocalendar">			
			<var class="atc_event">
				<var class="atc_date_start"><?php echo $start_mark;?></var>
				<var class="atc_date_end"><?php echo $end_mark;?></var>
				<var class="atc_timezone">Europe/Moscow</var>
				<var class="atc_title"><?php echo esc_attr($event->post_title);?></var>
				<var class="atc_description"><?php echo apply_filters('tst_the_title', $e);?></var>
				<var class="atc_location"><?php echo esc_attr($loct).' '.esc_attr($addr);?></var>          
			</var>		
		</span>			
	</span>
	<span class="tst-tooltip" for="<?php echo esc_attr($id);?>">Добавить в календарь</span>
<?php	
}


function tst_add_to_calendar_link_in_modal($event, $echo = true, $container_class = 'in-modal-add-tip') {
	
	$date = get_post_meta($event->ID, 'event_date', true);
	$time = get_post_meta($event->ID, 'event_time', true);
	$loct = get_post_meta($event->ID, 'event_location', true);
	$addr = get_post_meta($event->ID, 'event_address', true);
		
	if(empty($time))
		$time = '12.00';
	
	$start = date('d.m.Y', $date).' '.$time;	
	$start_mark = date_i18n('Y-m-d H:i:00', strtotime($start));
	$end_mark = date_i18n('Y-m-d H:i:00', strtotime('+2 hours '.$start));
	$e = (!empty($event->post_excerpt)) ? wp_trim_words($event->post_excerpt, 20) : wp_trim_words(strip_shortcodes($event->post_content), 20);
	$id = 'tst-'.uniqid();
?>
	<span id="<?php echo esc_attr($id);?>"  class="<?php echo esc_attr($container_class);?>">
		<span class="addtocalendar">
			<var class="atc_event">
				<var class="atc_date_start"><?php echo $start_mark;?></var>
				<var class="atc_date_end"><?php echo $end_mark;?></var>
				<var class="atc_timezone">Europe/Moscow</var>
				<var class="atc_title"><?php echo esc_attr($event->post_title);?></var>
				<var class="atc_description"><?php echo apply_filters('tst_the_title', $e);?></var>
				<var class="atc_location"><?php echo esc_attr($loct).' '.esc_attr($addr);?></var>          
			</var>		
		</span>
		<span class="tst-inmodal-tooltip" for="<?php echo esc_attr($id);?>">Добавить в календарь</span>
	</span>	
<?php	
}
