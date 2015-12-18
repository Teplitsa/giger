<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package bb
 */

$cc_link = '<a href="http://creativecommons.org/licenses/by-sa/3.0/" target="_blank">Creative Commons СС-BY-SA 3.0</a>';
$tst = __("Teplitsa of social technologies", 'tst');
$banner = get_template_directory_uri().'/assets/images/te-st-logo-10x50';
$footer_text = get_theme_mod('footer_text');

?>

</div><!-- .page-content -->

<footer id="colophon" class="site-footer" role="contentinfo">	

	
	<div class="mdl-grid full-width">
		<div class="mdl-cell mdl-cell--8-col mdl-cell--8-col-tablet">
			<div class="credits">
			<!--<div class="bottom-logo"><?php tst_site_logo('context');?></div>-->
			<div class="copy">
				<?php echo apply_filters('tst_the_content', $footer_text); ?>
				
				<div class="footer-buttons">
					<?php tst_get_social_menu(); ?>
					<!-- Search -->					
					<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable">
						<label class="mdl-button mdl-js-button mdl-button--icon" for="sample6">
						  <i class="material-icons">search</i>
						</label>
						<div class="mdl-textfield__expandable-holder">
						  <input class="mdl-textfield__input" type="text" id="sample6" name="s">
						  <label class="mdl-textfield__label" for="sample-expandable">Expandable Input</label>
						</div>
					  </div>
					</form>					
				</div>
				
				<p><?php printf(__('All materials of the site are avaliabe under license %s.', 'tst'), $cc_link);?></p>
			</div>
			</div>
		</div><!-- .col -->
		
		<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
			<div class="te-st-bn">
				<span class="support">Сайт сделан <br>при поддержке</span>
				<a title="<?php echo $tst;?>" href="http://te-st.ru/" class="tst-banner">
					<!-- <img alt="<?php echo $tst;?>" src="<?php echo $banner;?>.svg" onerror="this.onerror=null;this.src=<?php echo $banner;?>.png;">-->
					<svg class="tst-icon"><use xlink:href="#pic-te-st" /></svg>
				</a>
			</div>
		</div><!-- .col -->
	</div>

</footer>



</main><!-- mdl-layout__content -->
</div><!-- .mdl-layout -->
<?php do_action('tst_footer_position');?>
<?php wp_footer(); ?>
<?php if(!is_singular('leyka_campaign')) { ?>
<a id="fab-mobile" class="mdl-button mdl-js-button mdl-button--fab mdl-button--colored mdl-js-ripple-effect" href="<?php echo home_url('campaign/help-us');?>"><i class="material-icons">favorite_border</i></a>
<?php }?>


</body>
</html>
