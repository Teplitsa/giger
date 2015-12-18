<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package bb
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset');?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php wp_head();?>
</head>

<body id="top" <?php body_class(); ?>>
<?php include_once(get_template_directory()."/assets/svg/svg.svg");  //all svgs ?>

<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'tst' ); ?></a>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--overlay-drawer-button">

<header class="mdl-layout__header ontop">
	<div class="mdl-layout__header-row">
		<noscript><a href="<?php echo home_url('sitemap');?>" class="nojs-menu"><?php echo tst_material_icon('menu'); ?></a></noscript>
		<!-- Crumb -->
		<span class="mdl-layout-title"><?php echo tst_breadcrumbs();?></span>
		
		<!-- Logo -->
		<span class="site-logo"><a href="<?php echo home_url();?>"><?php tst_site_logo('small');?></a></span>
		
		<!-- Spacer -->
		<div class="mdl-layout-spacer"> </div>
		
		<!-- Newsletter -->
		<button id="newsletter" title="Подписка на новости" class="mdl-button mdl-js-button mdl-button--icon" data-emodal="#modal-newsletter"><i class="material-icons">email</i></button>
		
    </div><!-- .mdl-layout__header-row -->	
</header>

<div id="site_nav" class="mdl-layout__drawer">
    <span class="mdl-layout-title"><a href="<?php echo home_url();?>" class="navigation-logo"><?php tst_site_logo('context');?></a></span>
	<?php wp_nav_menu(array('theme_location' => 'primary', 'container' => false, 'menu_class' => 'mdl-navigation')); ?>
	<?php tst_get_social_menu(); ?>
</div>


<main class="mdl-layout__content">
	
<?php $bg = tst_header_image_url();?>
<header id="page_header" class="page-header" <?php echo " style='background-image: url({$bg})'";?>>
	<?php get_template_part('partials/title', 'section');?>	
</header>

<div id="page_content" class="page-content">