<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package bb
 */

get_header(); ?>

<div class="page-content-grid">
<div class="mdl-grid">
	
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
		<section class="error-404 not-found">
			<h3>Кажется, мы потеряли запрошенную страницу</h3>
			<p>Пожалуйста, не беспокойтесь, мы обязательно найдем ее снова.</p>
			
			<div class="search-holder"><?php get_search_form();?></div>
		</section>
	</div>
	
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	
</div><!-- .mdl-grid -->
</div>

<div class="page-footer"><div class="mdl-grid">
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
	<div class="mdl-cell mdl-cell--6-col mdl-cell--8-col-tablet">
<?php
	$r_query = new WP_Query(
	array(
		'post_type' => 'post',
		'posts_per_page' => 3,		
		'tax_query' => array(
			array(
				'taxonomy' => 'category',
				'field' => 'slug',
				'terms' => array('news'),
				'operator' => 'NOT IN'
			)
		)
	)
);
?>
	<aside class="related-posts section">	
		<h5>Почитайте наши новости</h5>
		
		<?php
			foreach($r_query->posts as $rp){
				tst_compact_post_item($rp);
			}	
		?>
	</aside>	
	</div>
	<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
</div></div>


<?php get_footer(); ?>