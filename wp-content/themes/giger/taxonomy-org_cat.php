<?php
/**
 * Partners
 **/

get_header(); ?>
<div class="mdl-grid">
	
	<?php
		if(have_posts()){
			while(have_posts()){
				the_post();
				tst_org_card($post);
			}  		
		}		
	?>	
</div>

<?php
	$p = tst_paging_nav();
	if(!empty($p)) {
?>
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--12-col"><?php echo $p; ?></div>
	</div>
<?php } ?>

<?php get_footer(); ?>