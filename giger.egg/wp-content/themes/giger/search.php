<?php
/** Search **/


get_header(); ?>
<div class="mdl-grid">
	
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
	
		<div class="search-holder">
			<?php get_search_form();?>
		</div>
		
		<?php
			if(have_posts()){
				while(have_posts()){
					the_post();
		?>
			<article <?php post_class('tpl-search'); ?>>
			
				<header class="search-header">
					<h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>				
					<cite class="mdl-typography--caption"><?php the_permalink();?></cite>		
				</header>
			
				<div class="search-summary"><?php the_excerpt(); ?></div>
			</article>
		<?php	
				} //endwhile 
			} else {
				get_template_part('partials/content', 'none');			
			}
			
			echo tst_paging_nav();
		?>
	</div>
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
</div>
<?php get_footer(); ?>