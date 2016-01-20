<?php
/**
 * @package bb
 */

$show_thumb = (function_exists('get_field')) ? (bool)get_field('show_thumb') : true;
$author = tst_get_post_author($post);
$avatar = '';

?>

<article <?php post_class('tpl-post-full'); ?>>

	<div class="entry-meta">
		<div class="mdl-grid mdl-grid--no-spacing">
			<?php if($author) { ?>
			<div class="mdl-cell mdl-cell--4-col">
				<div class="captioned-text">
					<div class="caption"><?php _e('Author', 'tst');?></div>
					<div class="text"><?php echo get_the_term_list(get_the_ID(), 'auctor', '', ', ', '');?></div>
				</div>
			</div>
			<?php } ?>
			<div class="mdl-cell <?php echo ($author) ? 'mdl-cell--8-col' : 'mdl-cell--12-col';?>">
				<div class="captioned-text">
					<div class="caption"><?php _e('Published', 'tst');?></div>
					<div class="text"><?php echo tst_posted_on($post);?></div>
				</div>
			</div>
		</div>
	</div>
		
	<div class="entry-summary"><?php the_excerpt();?></div>
	<div class="sharing-on-top"><?php tst_social_share_no_js();?></div>
	
	<?php
		if($show_thumb && has_post_thumbnail()) {
			echo "<div class='entry-media'>";
			the_post_thumbnail('embed', array('alt' => __('Thumbnail', 'tst')));
			echo "</div>";
		}
	?>
	
	<div class="entry-content">		
		<?php the_content(); ?>
	</div>
		
	<div class="entry-footer">	
	<?php		
		if(!empty($author)) {			
			$avatar = tst_get_author_avatar($author->term_id) ;
	?>
		<div class="entry-meta-bottom">
			<div class="mdl-grid mdl-grid--no-spacing">
				
				<div class="mdl-cell mdl-cell--9-col">
					<div class="entry-author pictured-card-item">
						<div class="author-avatar round-image pci-img"><?php echo $avatar;?></div>
						
						<div class="author-content pci-content">
							<h5 class="author-name mdl-typography--body-1"><?php echo apply_filters('tst_the_title', $author->name);?></h5>
							<p class="author-role mdl-typography--caption">
								<?php echo apply_filters('tst_the_title', $author->description);?>
							</p>
						</div>
					</div>
				</div>				
				
				<div class="mdl-cell mdl-cell--3-col mdl-cell--6-col-phone mdl-cell--8-col-tablet">
					<a href="<?php echo get_term_link($author);?>" class="author-link mdl-button mdl-js-button mdl-button--primary"><?php _e('All author\'s articles', 'tst');?></a>
				</div>
				
			</div>
		</div><!-- .entry-meta -->
	<?php } ?>		
		
	</div>	
</article><!-- #post-## -->

<!-- panel -->
<?php
	add_action('tst_footer_position', function(){
		get_template_part('partials/panel', 'float');	
	});
?>

