<?php
/**
 * Template Name: Calendar
 */

$today = strtotime(sprintf('now %s hours', get_option('gmt_offset'))); 

add_action('wp_footer', function(){
?>
	<div id="modal-card" class="event-modal mdl-card mdl-shadow--6dp"></div>
<?php
});

get_header(); ?>
<div class="calendar-content" id="calendar_content">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--9-col">			
			<div class="mdl-shadow--2dp calendar-card">
				
				<div class="calendar-block">
					<div class="cb-caption">
					<?php
						$today_exact = strtotime(sprintf('now %s hours', get_option('gmt_offset')));
						
					?>
						<div class="mdl-typography--subhead"><?php echo date_i18n('Y', $today_exact);?></div>
						<div class="mdl-typography--headline">
						<?php
							echo date_i18n('l, j', $today_exact);
							echo '&nbsp;';
							echo date_i18n('M.', $today_exact);
						?>
						</div>
					</div>				
					<div class="cb-grid">
						<div id="calendar-place">
						<?php
							$cal = new TST_Calendar_Table();
							echo $cal->generate();
							
							echo tst_loader_panel();
						?>						
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="mdl-cell mdl-cell--3-col mdl-cell--hide-phone mdl-cell--hide-tablet">
			<?php get_sidebar(); ?>
		</div>
	
	</div><!-- .mdl-grid -->
	
</div>
<!-- <div id="modal-card" class="event-modal mdl-card mdl-shadow--6dp"></div>-->

<div class="calendar-footer">
	<div class="mdl-grid">
		<div class="mdl-cell mdl-cell--4-col ev-future cf-widget">
			<h5 class="widget-title">Анонсы</h5>
		<?php
			
			$query = new WP_Query(
				array(
					'post_type' => 'event',
					'posts_per_page' => 4,
					'meta_query' => array(
						array(
							'key' => 'event_date',
							'value' => strtotime(date('Y', $today).date('m', $today).date('d', $today)),
							'compare' => '>=',
						),
					)
				)
			);
			
			if($query->have_posts()){
				foreach($query->posts as $ev){
					tst_compact_event_item($ev);
				}
			}
		?>		
		</div>
				
		<div class="mdl-cell mdl-cell--1-col mdl-cell--hide-phone mdl-cell--hide-tablet"></div>
			
		<div class="mdl-cell mdl-cell--4-col ev-past cf-widget">
			<h5 class="widget-title">Прошедшие</h5>
		<?php
			
			$query = new WP_Query(
				array(
					'post_type' => 'event',
					'posts_per_page' => 4,
					'meta_query' => array(
						array(
							'key' => 'event_date',
							'value' => strtotime(date('Y', $today).date('m', $today).date('d', $today)),
							'compare' => '<',
						),
					)
				)
			);
			
			if($query->have_posts()){
				foreach($query->posts as $ev){
					tst_compact_event_item($ev);
				}
			}
		?>
		</div>
		
	</div>		
</div>


<?php get_footer(); ?>
