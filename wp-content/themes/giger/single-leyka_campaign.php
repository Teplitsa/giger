<?php
/**
 * Single template for donation page
 **/

$campaign_id = $post->ID;

get_header(); ?>
<div class="page-content-grid">
<div class="mdl-grid">
	
	<div class="mdl-cell mdl-cell--2-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	<div class="mdl-cell mdl-cell--8-col mdl-cell--8-col-tablet">
		<?php		
			while(have_posts()){
				the_post();
		?>
			<article id="post-<?php the_ID(); ?>" <?php post_class('tpl-page'); ?>>
				<div class="entry-content">
					<?php the_content(); ?>		
				</div>
				<div class="payment-form">
					<?php get_template_part('partials/payment', 'form');?>
				</div>
			</article>
		<?php } ?>
		
		
	</div>
	
	<div class="mdl-cell mdl-cell--2-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	
</div><!-- .mdl-grid -->
</div>

<div class="page-footer"><div class="mdl-grid">
	<div class="mdl-cell mdl-cell--2-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	<div class="mdl-cell mdl-cell--8-col mdl-cell--8-col-tablet">
		<aside class="donation-history section">
		<?php
			$l = leyka_get_donors_list($campaign_id, array('num' => TST_DONORS_LIST_NUM));
			if(!empty($l)) {
		?>
			<h5>Спасибо за вашу помощь!</h5>
			<?php echo strip_tags($l, '<div><span><time>'); ?>
			
		<?php } ?>
		</aside>
	</div>
	<div class="mdl-cell mdl-cell--2-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
</div></div>

<?php get_footer(); ?>