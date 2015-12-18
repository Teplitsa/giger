<?php
/**
 * Cards and Listings' items templates
 **/

/** General selection **/
function tst_print_post_card($cpost) {

	if($cpost->post_type == 'post'){
		$tax = (tst_has_authors()) ? 'auctor' : 'category';
		tst_post_card($cpost, $tax);
	}
	else {
		$callback = "tst_".$cpost->post_type."_card";
		if(is_callable($callback)) {
			call_user_func($callback, $cpost);
		}
		else {
			tst_post_card($cpost);
		}	
	}
}

/** == Cards in loop == **/

/** Post card content **/
function tst_post_card($cpost, $tax = 'auctor'){
	
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$pl = get_permalink($cpost);
	$e = tst_get_post_excerpt($cpost, 30, true);
	$date = "<time>".get_the_date('d.m.Y.', $cpost->ID)."</time> - ";
	
	
	$css = 'mdl-cell--4-col';
	if(isset($cpost->grid_css))
		$css = $cpost->grid_css;
	
?>
<article <?php post_class('mdl-cell masonry-item '.$css); ?>>
<div class="tpl-card-blank mdl-card mdl-shadow--2dp">
	
	<?php if(has_post_thumbnail($cpost->ID)){ ?>
		<div class="mdl-card__media"><a href="<?php echo $pl;?>">
			<?php echo get_the_post_thumbnail($cpost->ID, 'post-thumbnail', array('alt' => __('Thumbnail', 'tst'))); ?>
		</a></div>			
	<?php } ?>
	
	<?php
		if($tax == 'auctor' && tst_has_authors()) {
			$author = tst_get_post_author($cpost);
			$name = ($author) ? $author->name : '';
			$desc = ($author) ? wp_trim_words($author->description, 20) : '';
			$avatar = ($author) ? tst_get_author_avatar($author->term_id) : '';
	?>
		<div class="entry-author mdl-card__supporting-text">		
			<div class="pictured-card-item">
				<div class="author-avatar round-image pci-img"><?php echo $avatar;?></div>
					
				<div class="author-content card-footer-content pci-content">
					<h5 class="author-name mdl-typography--body-1"><?php echo apply_filters('tst_the_title', $name);?></h5>
					<?php if(!empty($desc)) { ?>
						<p class="author-role mdl-typography--caption"><?php echo apply_filters('tst_the_title', $desc);?></p>
					<?php } ?>
				</div>
			</div>
		</div>
	<?php
		} elseif($tax != 'auctor')  {			
			echo get_the_term_list($cpost->ID, $tax, '<div class="entry-tax mdl-card__supporting-text">', ', ', '</div>');	
		}
	?>
	<div class="mdl-card__title">
		<h4 class="mdl-card__title-text"><a href="<?php echo $pl;?>"><?php echo get_the_title($cpost->ID);?></a></h4>
	</div>
	
	<?php echo tst_card_summary($date.$e); ?>
	<div class="mdl-card--expand"></div>
	<div class="mdl-card__actions mdl-card--border">
		<a href="<?php echo $pl;?>" class="mdl-button mdl-js-button"><?php _e('Details', 'tst');?></a>
	</div>
</div>
</article>
<?php
}

/** Project card content **/
function tst_project_card($cpost){
		
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = tst_get_post_excerpt($cpost, 30, true);	
	$pl = get_permalink($cpost);
	
	$css = 'mdl-cell--4-col';
	if(isset($cpost->grid_css))
		$css = $cpost->grid_css;
?>
<article <?php post_class('mdl-cell masonry-item '.$css); ?>>
<div class="tpl-card-color mdl-card mdl-shadow--2dp">
	
	<?php if(has_post_thumbnail($cpost->ID)){ ?>
	<div class="mdl-card__media">
		<a href="<?php echo $pl;?>"><?php echo get_the_post_thumbnail($cpost->ID, 'post-thumbnail', array('alt' => __('Thumbnail', 'tst'))); ?></a>
	</div>			
	<?php } ?>
		
	<div class="mdl-card__title">
		<h4 class="mdl-card__title-text"><a href="<?php echo $pl;?>"><?php echo get_the_title($cpost->ID);?></a></h4>
	</div>
	
	<?php echo tst_card_summary($e); ?>
	
	<div class="mdl-card__actions mdl-card--border">
		<a href="<?php echo $pl;?>" class="mdl-button mdl-js-button"><?php _e('Details', 'tst');?></a>
	</div>
</div>	
</article>
<?php
}


/** Partner card content **/
function tst_org_card($cpost, $ext_link = true){
		
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	if($ext_link) {
		$label = __('Website', 'tst');
		$url = $cpost->post_excerpt ? esc_url($cpost->post_excerpt) : '';
		$target = " target='_blank'";
	}
	else {
		$label = __('Details', 'tst');
		$url = get_permalink($cpost);
		$target = "";
	}
	
	$logo = get_the_post_thumbnail($cpost->ID, 'full');
	$text = apply_filters('tst_the_content', $cpost->post_content);	
	
	$css = 'mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone';
	if(isset($cpost->grid_css))
		$css = $cpost->grid_css;
?>
<article <?php post_class('mdl-cell '.$css); ?>>
<div class="tpl-card-mix mdl-card mdl-shadow--2dp">
	
	<div class="mdl-card__media">
		<a class="logo-link" href="<?php echo $url;?>"<?php echo $target;?>><?php echo $logo; ?></a>
	</div>
			
	<div class="mdl-card__title">
		<h4 class="mdl-card__title-text"><a href="<?php echo $url;?>"><?php echo get_the_title($cpost->ID);?></a></h4>
	</div>
			
	<?php echo tst_card_summary($text); ?>
	
	<?php if(!empty($url)) { ?>
	<div class="mdl-card__actions mdl-card--border">
		<a href="<?php echo $url;?>"<?php echo $target;?> class="mdl-button mdl-js-button"><?php echo $label;?></a>
	</div>
	<?php } ?>
</div>	
</article>
<?php
}

/** Person profile card content **/
function tst_person_card($cpost){
		
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = tst_get_post_excerpt($cpost, 30, true);	
	$pl = get_permalink($cpost);
	
	$css = 'mdl-cell--4-col';
	if(isset($cpost->grid_css))
		$css = $cpost->grid_css;
?>
<article <?php post_class('mdl-cell masonry-item '.$css); ?>>
<div class="tpl-card-color mdl-card mdl-shadow--2dp">
	
	<?php if(has_post_thumbnail($cpost->ID)){ ?>
	<div class="mdl-card__media">
		<a href="<?php echo $pl;?>"><?php echo get_the_post_thumbnail($cpost->ID, 'post-thumbnail', array('alt' => __('Thumbnail', 'tst'))); ?></a>
	</div>			
	<?php } ?>
		
	<div class="mdl-card__title">
		<h4 class="mdl-card__title-text"><a href="<?php echo $pl;?>"><?php echo get_the_title($cpost->ID);?></a></h4>
	</div>
	
	<?php echo tst_card_summary($e); ?>
	
	<div class="mdl-card__actions mdl-card--border">
		<a href="<?php echo $pl;?>" class="mdl-button mdl-js-button"><?php _e('Details', 'tst');?></a>
	</div>
</div>	
</article>
<?php
}


/** Person short profile card content **/
function tst_person_short_card($cpost, $ext_link = true){
		
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	if($ext_link) {
		$label = __('Website', 'tst');
		$url = $cpost->post_excerpt ? esc_url($cpost->post_excerpt) : '';
		$target = " target='_blank'";
	}
	else {
		$label = __('Details', 'tst');
		$url = get_permalink($cpost);
		$target = "";
	}
	
	$logo = get_the_post_thumbnail($cpost->ID, 'full');
	$text = apply_filters('tst_the_content', $cpost->post_content);	
	
	$css = 'mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone';
	if(isset($cpost->grid_css))
		$css = $cpost->grid_css;
?>
<article <?php post_class('mdl-cell '.$css); ?>>
<div class="tpl-card-mix mdl-card mdl-shadow--2dp">
	
	<div class="mdl-card__media">
		<span class="logo-link"><?php echo $logo; ?></span>
	</div>
			
	<div class="mdl-card__title">
		<h4 class="mdl-card__title-text"><?php echo get_the_title($cpost->ID);?></h4>
	</div>
			
	<?php echo tst_card_summary($text); ?>
	
	<?php if(!empty($url)) { ?>
	<div class="mdl-card__actions mdl-card--border">
		<a href="<?php echo $url;?>"<?php echo $target;?> class="mdl-button mdl-js-button"><?php echo $label;?></a>
	</div>
	<?php } ?>
</div>	
</article>
<?php
}

/** Page card content **/
function tst_page_card($cpost){
		
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = tst_get_post_excerpt($cpost, 30, true);	
	$pl = get_permalink($cpost);
	
	$img = (function_exists('get_field')) ? get_field('header_img', $cpost->ID) : 0;
	$img = wp_get_attachment_image($img, 'post-thumbnail', false, array('alt' => __('Thumbnail', 'tst')));
	
	$css = 'mdl-cell--4-col';
	if(isset($cpost->grid_css))
		$css = $cpost->grid_css;
?>
<article <?php post_class('mdl-cell masonry-item '.$css); ?>>
<div class="tpl-card-color mdl-card mdl-shadow--2dp">
	
	<?php if($img){ ?>
	<div class="mdl-card__media">
		<a href="<?php echo $pl;?>"><?php echo $img; ?></a>
	</div>			
	<?php } ?>
		
	<div class="mdl-card__title">
		<h4 class="mdl-card__title-text"><a href="<?php echo $pl;?>"><?php echo get_the_title($cpost->ID);?></a></h4>
	</div>
	
	<?php echo tst_card_summary($e); ?>
	
	<div class="mdl-card__actions mdl-card--border">
		<a href="<?php echo $pl;?>" class="mdl-button mdl-js-button"><?php _e('Details', 'tst');?></a>
	</div>
</div>	
</article>
<?php
}



/** == Compact Items for posts in widgets and related section == **/

/** Compact post item **/
function tst_compact_post_item($cpost, $show_thumb = true, $tax = 'category'){
			
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	if($tax == 'auctor'){
		$author = tst_get_post_author($cpost);
		$name = ($author) ? $author->name : '';
		$avatar = ($show_thumb && $author) ? tst_get_author_avatar($author->term_id) : '';
	}
	else { //category
		$cat = get_the_terms($cpost->ID, $tax);
		$name = (isset($cat[0])) ? $cat[0]->name : '';
		$avatar = ($show_thumb) ? tst_get_default_author_avatar() : '';
	}
	
?>
	<div class="tpl-related-post"><a href="<?php echo get_permalink($cpost);?>">
	
	<div class="mdl-grid mdl-grid--no-spacing">
		<div class="mdl-cell mdl-cell--9-col mdl-cell--5-col-tablet mdl-cell--4-col-phone">
			<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
			
		<?php if($show_thumb) { ?>	
			<div class="entry-author pictured-card-item">
				<div class="author-avatar round-image pci-img"><?php echo $avatar;?></div>
					
				<div class="author-content card-footer-content pci-content">
					<h5 class="author-name mdl-typography--body-1"><?php echo apply_filters('tst_the_title', $name);?></h5>
					<p class="post-date mdl-typography--caption"><time><?php echo get_the_date('d.m.Y.', $cpost);?></time></p>
				</div>
				
			</div>	
		<?php } else { ?>
			<div class="entry-author plain-card-item">
				<h5 class="author-name mdl-typography--body-1"><?php echo apply_filters('tst_the_title', $name);?></h5>
				<p class="post-date mdl-typography--caption"><time><?php echo get_the_date('d.m.Y.', $cpost);?></time></p>				
			</div>	
		<?php } ?>
		</div>
		
		<div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--hide-phone">
		<?php
			$thumb = get_the_post_thumbnail($cpost->ID, 'thumbnail-landscape', array('alt' => __('Thumbnail', 'tst')) ) ;
			if(empty($thumb)){
				$thumb = tst_get_default_post_thumbnail('thumbnail-landscape');
			}
			
			echo $thumb;
		?>
		</div>
	</div>	
	
	</a></div>
<?php
}

/** Compact project item **/
function tst_compact_project_item($cpost){
	
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = tst_get_post_excerpt($cpost, 30, true);	
?>
	<div class="tpl-related-project"><a href="<?php echo get_permalink($cpost);?>">
	
	<div class="mdl-grid mdl-grid--no-spacing">
		<div class="mdl-cell mdl-cell--9-col mdl-cell--5-col-tablet mdl-cell--4-col-phone">
			<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
				
			<!-- summary -->
			<p class="entry-summary">
				<?php echo apply_filters('tstpsk_the_tite', $e); ?>
			</p>
		</div>
		
		<div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--hide-phone">
		<?php
			$thumb = get_the_post_thumbnail($cpost->ID, 'thumbnail-landscape', array('alt' => __('Thumbnail', 'tst')) ) ;
			if(empty($thumb)){
				$thumb = tst_get_default_post_thumbnail('thumbnail-landscape');
			}
			echo $thumb;
		?>
		</div>
	</div>	
	
	</a></div>
<?php
}

/** Compact person item **/
function tst_compact_person_item($cpost){
	
	if(is_int($cpost))
		$cpost = get_post($cpost);
	
	$e = tst_get_post_excerpt($cpost, 30, true);	
?>
	<div class="tpl-related-project"><a href="<?php echo get_permalink($cpost);?>">
	
	<div class="mdl-grid mdl-grid--no-spacing">
		<div class="mdl-cell mdl-cell--9-col mdl-cell--5-col-tablet mdl-cell--4-col-phone">
			<h4 class="entry-title"><?php echo get_the_title($cpost);?></h4>
				
			<!-- summary -->
			<p class="entry-summary">
				<?php echo apply_filters('tst_the_tite', $e); ?>
			</p>
		</div>
		
		<div class="mdl-cell mdl-cell--3-col mdl-cell--3-col-tablet mdl-cell--hide-phone">
		<?php
			$thumb = get_the_post_thumbnail($cpost->ID, 'thumbnail-landscape', array('alt' => __('Thumbnail', 'tst')) ) ;
			if(empty($thumb)){
				$thumb = tst_get_default_post_thumbnail('thumbnail-landscape');
			}
			echo $thumb;
		?>
		</div>
	</div>	
	
	</a></div>
<?php
}
