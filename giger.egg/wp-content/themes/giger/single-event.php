<?php
/** Event **/

get_header();
?>
<div class="page-content-grid">
<div class="mdl-grid">
	
<?php while(have_posts()){ the_post(); ?>
	<div class="mdl-cell mdl-cell--2-col mdl-cell--4-col-phone mdl-cell--hide-tablet">
		<?php tst_event_meta();?>		
	</div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">	
		<article id="post-<?php the_ID(); ?>" <?php post_class('tpl-event-full'); ?>>
			
			<div class="entry-meta"><?php tst_event_meta();?></div>
				
			<div class="entry-summary"><?php the_excerpt();?></div>
			<div class="sharing-on-top"><?php tst_social_share_no_js();?></div>
			
		<?php  
			if(has_post_thumbnail()) {
				echo "<div class='entry-media'>";
				the_post_thumbnail('embed', array('alt' => __('Thumbnail', 'tst')));
				echo "</div>";
			}
		?>
			
			<div class="entry-content"><?php the_content(); ?></div>
		<!-- panel -->
		<?php
			add_action('wp_footer', function(){
				get_template_part('partials/panel', 'float');	
			});
		?>
		</article>	
	
	</div>	
	<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet"><?php get_sidebar(); ?></div>
	
<?php }	//endwhile ?>

</div><!-- .row -->
</div>

<div class="page-footer"><div class="mdl-grid">
	<div class="mdl-cell mdl-cell--2-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
	<?php
		$today = strtotime(sprintf('now %s hours', get_option('gmt_offset'))); 
		$r_query = new WP_Query(
			array(
				'post_type' => 'event',
				'posts_per_page' => 4,
				'orderby' => 'rand',
				'post__not_in' => array($post->ID),
				'meta_query' => array(
					array(
						'key' => 'event_date',
						'value' => strtotime(date('Y', $today).date('m', $today).date('d', $today)),
						'compare' => '>=',
					),
				)
			)
		);
		
		if($r_query->have_posts()) {
		?>
		<aside class="related-posts ev-future section">	
			<h5><?php _e('More events', 'tst');?></h5>
			
		<?php
			foreach($r_query->posts as $rp){							
				tst_compact_event_item($rp);				
			}				
		?>
		</aside>
		<?php } //have posts?>
	</div>
	<div class="mdl-cell mdl-cell--4-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
</div></div>

<?php get_footer(); ?>
