<?php
/**
 * Template Name: Homepage
 * 
 */
 
$home_id = $post->ID;

//settings
$profiles_order = get_post_meta($home_id, 'home_profiles_order', true);
$profiles_filter = get_post_meta($home_id, 'home_profiles_cat', true);
$profiles_per_page = ($profiles_order == 'first') ? 6 : 4;

$news_order = get_post_meta($home_id, 'home_news_order', true);
$news_filter = get_post_meta($home_id, 'home_news_cat', true);
$news_per_page = ($news_order == 'first') ? 5 : 3;

$projects_order = get_post_meta($home_id, 'home_projects_order', true);
$projects_per_page = ($projects_order == 'first') ? 2 : 3;

$sections = array();

//profiles
if($profiles_order != 'none'){
	$profiles_args = array(
		'post_type' => 'person',	
		'posts_per_page' => $profiles_per_page,
		'orderby' => 'rand',
		'cache_results' => false
	);
	if(!empty($profiles_filter)){
		$profiles_args['tax_query'] = array(
			array(
				'taxonomy' => 'person_cat',
				'field' => 'term_id',
				'terms' => intval($profiles_filter)
			)
		);
	}

	$profiles = new WP_Query($profiles_args);
	
	if($profiles->have_posts() && $profiles->found_posts > 1){
		$cat = get_term(intval($profiles_filter), 'person_cat');		
		$title = apply_filters('single_term_title', $cat->name)." <a href='".get_term_link($cat)."' title='".__('All', 'tst')."'>(".$profiles->found_posts.")</a>";		
		$sections[$profiles_order] = array('posts' => $profiles->posts, 'title' => $title);
	}
}

//news
if($news_order != 'none'){
	$news_args = array(
		'post_type' => 'post',	
		'posts_per_page' => $news_per_page,
		'cache_results' => false
	);
	if(!empty($news_filter)){
		$news_args['tax_query'] = array(
			array(
				'taxonomy' => 'category',
				'field' => 'term_id',
				'terms' => intval($news_filter)
			)
		);
	}
	
	$news = new WP_Query($news_args);
	
	if($news->have_posts() && $news->found_posts > 1){
		$cat = get_term(intval($news_filter), 'category');		
		$title = __('Our news', 'tst')." <a href='".get_term_link($cat)."' title='".__('All', 'tst')."'>(".$news->found_posts.")</a>";		
		$sections[$news_order] = array('posts' => $news->posts, 'title' => $title);
	}
}

//progs
if($projects_order != 'none') {
	$projects_args = array(
		'post_type' => 'project',
		'posts_per_page' => $projects_per_page,
		'orderby' => 'rand',
		'cache_results' => false
	);
	
	$projects = new WP_Query($projects_args);
	
	if($projects->have_posts() && $projects->found_posts > 1){
		$all = get_post_type_archive_link('project');
		$title = __('Our projects', 'tst')." <a href='".$all."' title='".__('All', 'tst')."'>(".$projects->found_posts.")</a>";		
		$sections[$projects_order] = array('posts' => $projects->posts, 'title' => $title);
	}
}

get_header();
//Att! no support for incorrect section order


if(isset($sections['first']['posts'])) {
	$num = count($sections['first']['posts']);
?>
<section class="home-section first">
	<div class="mdl-grid">
	<?php
		for($i = 0; $i < 2; $i++){
			tst_print_post_card($sections['first']['posts'][$i]);
		}
	?>
		<div class="mdl-cell mdl-cell--4-col mdl-cell--hide-phone mdl-cell--hide-tablet"><?php get_sidebar(); ?></div>
	</div>
	<div class="mdl-grid">
	<?php
		for($i = 2; $i < $num; $i++){
			$cpost = $sections['first']['posts'][$i];
			if($cpost->post_type == 'person'){
				$cpost->grid_css = 'mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone';
			}
			
			tst_print_post_card($cpost);
		}
	?>
	</div>
</section>
<?php } ?>

<!-- second -->
<?php if(isset($sections['second']['posts'])) {
	$num = count($sections['second']['posts']);
?>
<section class="home-section second">
	<div class="mdl-grid">
		<?php if(isset($sections['second']['title']) && !empty($sections['second']['title'])) { ?>
		<header class="mdl-cell mdl-cell--12-col">
			<h3 class="home-section-title"><?php echo $sections['second']['title'];?></h3>
		</header>
		<?php } ?>
		<?php
			for($i = 0; $i < $num; $i++){
				$cpost = $sections['second']['posts'][$i];
				if($cpost->post_type == 'person'){
					$cpost->grid_css = 'mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone';
				}
				tst_print_post_card($cpost);
			}
		?>		
	</div>	
</section>
<?php } ?>

<!-- third -->
<?php if(isset($sections['third']['posts'])) {
	$num = count($sections['third']['posts']);
?>
<section class="home-section third">
	<div class="mdl-grid">
		<?php if(isset($sections['third']['title']) && !empty($sections['third']['title'])) { ?>
		<header class="mdl-cell mdl-cell--12-col">
			<h3 class="home-section-title"><?php echo $sections['third']['title'];?></h3>
		</header>
		<?php } ?>
		<?php
			for($i = 0; $i < $num; $i++){
				$cpost = $sections['third']['posts'][$i];
				if($cpost->post_type == 'person'){
					$cpost->grid_css = 'mdl-cell--3-col mdl-cell--4-col-tablet mdl-cell--4-col-phone';
				}
				tst_print_post_card($cpost);				
			}
		?>		
	</div>	
</section>
<?php } ?>


<!-- partners -->
<?php 
	$part_ids = (get_post_meta($home_id, 'home_partners', true)); 
	$partners = array();
	if($part_ids) {
		$partners  = get_posts(array('post_type' =>'org', 'post__in' => $part_ids, 'post_status' => 'publish', 'cache_results' => false));
	}

	if($partners) { ?>
<section class="home-partners-block">
<div class="mdl-grid">
<div class="mdl-cell mdl-cell--12-col">
	<h5 class="widget-title"><a href="<?php echo home_url('/orgs/partnery/');?>">Нас поддерживают</a></h5>
	<div class="widget-content mdl-shadow--2dp">
		
		<!-- gallery -->
		<?php if(!empty($partners)) { ?>
		<div class="partners-gallery">
		<?php foreach($partners as $org) {

				$title = apply_filters('tst_the_title', $org->post_title);  
				$url = esc_url($org->post_excerpt);								
				$logo = get_the_post_thumbnail($org->ID,'full', array('alt' => $title));?>

			<div class="logo"><div class="logo-frame">			
				<a class="logo-link" title="<?php echo esc_attr($title);?>" target="_blank" href="<?php echo $url;?>"><?php echo $logo;?></a>
			</div></div>
		<?php } ?>
		</div>
		<?php } ?>
	</div>
</div>
</div>
</section>
<?php } ?>

<section class="home-footer-block">
	<div class="mdl-grid">
	
	<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
		<?php dynamic_sidebar('footer_1-sidebar'); ?>	
	</div>
	
	<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
		<?php dynamic_sidebar('footer_2-sidebar'); ?>	
	</div>
	
	<div class="mdl-cell mdl-cell--4-col mdl-cell--8-col-tablet">
		<?php dynamic_sidebar('footer_3-sidebar'); ?>	
	</div>
	
	</div>
</section>

<?php get_footer(); ?>