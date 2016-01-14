<?php
/**
 * The template for displaying all pages.
 */

$post_id = '';
get_header();
?>
<div class="page-content-grid">
<div class="mdl-grid">
		
	<div class="mdl-cell mdl-cell--8-col mdl-cell--6-col-phone">
		<?php		
			while(have_posts()){
				the_post();				
				$post_id = get_the_ID();
		?>
			<article <?php post_class('tpl-page'); ?>>
				<div class="entry-content">
					<?php the_content(); ?>		
				</div>				
			</article>
		<?php }	?>		
	</div>
	
	<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet mdl-cell--6-col-phone"><?php get_sidebar(); ?></div>
	
</div><!-- .row -->
</div>

<div class="page-footer"><div class="mdl-grid">
<?php
	$embeds = get_post_meta($post_id, 'embed_posts', true);
	if(!empty($embeds)){
		$title = get_post_meta($post_id, 'embed_posts_title', true);
		if(!empty($title)){
	?>
		<div class="mdl-cell mdl-cell--12-col"><h5><?php echo $title; ?></h5></div>
	<?php
		}
		foreach($embeds as $ep) {
			$ep = intval($ep);
			$callback = "tst_".get_post_type($ep)."_card";
			if(is_callable($callback)) {
				call_user_func($callback, $ep);
			}
			else {
				tst_post_card($ep);
			}	
		}
	}
	else {
?>		
<div class="mdl-cell mdl-cell--5-col mdl-cell--6-col-tablet">
	<?php	
		$r_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 3)); 
		if($r_query->have_posts()){					
	?>
		<aside class="related-posts section">	
			<h5>Последние новости</h5>	
			<?php
				foreach($r_query->posts as $rp){
					tst_compact_post_item($rp, true, 'category');
				}	
			?>
		</aside>
	<?php } ?>
</div>
<div class="mdl-cell mdl-cell--7-col mdl-cell--2-col-tablet mdl-cell--hide-phone"></div>
<?php } ?>
</div></div>
<?php get_footer(); ?>
