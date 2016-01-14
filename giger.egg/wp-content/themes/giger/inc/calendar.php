<?php
/**
 * Calendar funcitons
 **/

class TST_Calendar_Table {
	
	var $week_days = array('Пн','Вт','Ср','Чт','Пт','Сб','Вс');
	var $month;
	var $year;
	var $today = array();
	var $days_in_month;
	
	
	function __construct($month = null, $year = null){
		
		$this->setup_today();
		
		if($month && $year){
			$this->month = $month;
			$this->year =  $year;
		}
		else {
			//get data from today
			$this->month = $this->today['m'];
			$this->year  = $this->today['y'];
		}
		
		$this->days_in_month = date('t',mktime(0,0,0,$month,1,$year));
		
	}
	
	function setup_today() {
       
        $today_exact = strtotime(sprintf('now %s hours', get_option('gmt_offset')));
                
		$this->today['d'] = date('d', $today_exact);
		$this->today['m'] = date('m', $today_exact);
		$this->today['y'] = date('Y', $today_exact);        
    }
	
	
	function prev_month_link(){		
		$text = '&lt;';
		
        // find next month		
		$prev_month_stamp = strtotime("-1 month".$this->year.'-'.$this->month.'-01');
		$limit_stamp = strtotime("-4 months".$this->today['y'].'-'.$this->today['m'].'-01');
		
		// build html
		if($prev_month_stamp > $limit_stamp){
			$m = date('m', $prev_month_stamp);
			$y = date('Y', $prev_month_stamp);
			$nonce = wp_create_nonce( 'calendar_scroll' );
			
			$link = "<a href='#' data-month='{$m}' data-year='{$y}' class='calendar-scroll' data-nonce='{$nonce}'>{$text}</a>";
		}
		else {
			$link = "<span>{$text}</span>";
		}
				
		return $link;
	}
	
	function next_month_link(){		
		$text = '&gt;';
		
        // find next month		
		$next_month_stamp = strtotime("+1 month".$this->year.'-'.$this->month.'-01');
		$limit_stamp = strtotime("+4 months".$this->today['y'].'-'.$this->today['m'].'-01');
		
		// build html
		if($next_month_stamp < $limit_stamp){
			$m = date('m', $next_month_stamp);
			$y = date('Y', $next_month_stamp);
			$nonce = wp_create_nonce( 'calendar_scroll' );
			
			$link = "<a href='#' data-month='{$m}' data-year='{$y}' class='calendar-scroll' data-nonce='{$nonce}'>{$text}</a>";
		}
		else {
			$link = "<span>{$text}</span>";
		}
				
		return $link;
	}
	
	function generate(){
		
		//marks
		$prev_link = $this->prev_month_link();
		$next_link = $this->next_month_link();
		$title = date_i18n('F Y', strtotime($this->year.'-'.$this->month.'-1'));
		
		//  table 
		$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';
		
		//month nav
		$calendar .= "<thead><tr class='calendar-month-nav'>";
		$calendar .= "<th colspan='2' class='prev'>{$prev_link}</th>"; //prev link
		$calendar .= "<th colspan='3' class='current'>{$title}</th>";
		$calendar .= "<th colspan='2' class='next'>{$next_link}</th></tr></thead>"; //next link
				
		// table headings 		
		$calendar.= '<tbody><tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$this->week_days).'</td></tr>';
	
		// days and weeks vars now ... 
		$running_day = date('w',mktime(0,0,0,$this->month,1,$this->year));
		if($running_day == 0)
			$running_day = 7;
			
		$days_in_this_week = 1;
		$day_counter = 0;
		$dates_array = array();
	
		// row for week one 
		$calendar.= '<tr class="calendar-row">';
	
		/* print "blank" days until the first of the current week */
		for($x = 1; $x < $running_day; $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
			$days_in_this_week++;
		endfor;
	
		// keep going with days.... 
		for($list_day = 1; $list_day <= $this->days_in_month; $list_day++):
			$calendar.= '<td class="calendar-day"><div class="calendar-cell">';
			
				//day content 
				$calendar.= '<span class="day-number">'.$list_day.'</span>';
				
				//links of items
				$calendar .= $this->day_content($list_day);
				
			$calendar.= '</div></td>';
			if($running_day == 7):
				$calendar.= '</tr>';
				if(($day_counter+1) != $this->days_in_month):
					$calendar.= '<tr class="calendar-row">';
				endif;
				$running_day = 0;
				$days_in_this_week = 0;
			endif;
			$days_in_this_week++; $running_day++; $day_counter++;
		endfor;
	
		// finish the rest of the days in the week */
		if($days_in_this_week < 8):
			for($x = 1; $x <= (8 - $days_in_this_week); $x++):
				$calendar.= '<td class="calendar-day-np"> </td>';
			endfor;
		endif;
	
		// final row 
		$calendar.= '</tr>';
	
		// end the table 
		$calendar.= '</tbody></table>';	
		
		
		return $calendar;
	}

	function day_content($day){
		//2015-07-03
		$args = array(
			'post_type' => 'event',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'event_date',
					'value' => strtotime($this->year.'-'.$this->month.'-'.zeroise($day, 2)),
					'compare' => '=',
				),
			)
		);
		
		$query = new WP_Query($args); 
		if(!$query->have_posts())
			return '';
		
		$links = array();
		$modals = array();
		
		//@to_do: markup for modals
		foreach($query->posts as $event){
			$title_full = get_the_title($event->ID);
			$icon = '<i class="material-icons">event</i>';
			$m_id = 'e-modal-'.$event->ID;
			
			$links[] = "<a href='".get_permalink($event)."' title='".esc_attr($title_full)."' class='day-link mdl-button mdl-js-button mdl-button--icon' data-emodal='#{$m_id}'>{$icon}</a>";
			
			$modals[] = $this->create_modal($event);
		}
		
		$out = implode('', $links); 
		$out .= implode('', $modals);
		
		return $out;
	}
	
	function create_modal($event){
		
		$m_id = 'e-modal-'.$event->ID;
		
		$out = "<div id='{$m_id}' class='event-modal-content tpl-event'>";
		$out .= tst_event_card($event);		
		$out .= "</div>";
				
		return $out;
	}
	
} //class end


/** Ajax for scrolling */
add_action("wp_ajax_calendar_scroll", "tst_calendar_scroll_screen");
add_action("wp_ajax_nopriv_calendar_scroll", "tst_calendar_scroll_screen");

function tst_calendar_scroll_screen() {
	
	$result = array('type' => 'ok', 'data' => array());
	
	if(!wp_verify_nonce($_REQUEST['nonce'], "calendar_scroll")) {		
		die('nonce error');
	}   
	
	$month = (isset($_REQUEST['month'])) ? trim($_REQUEST['month']) :  false;
	$year  = (isset($_REQUEST['year'])) ?trim($_REQUEST['year']) : false;
	
	if(!$month || !$year){
		$result['type'] = 'error';
		echo json_encode($result);
		die();
	}
	
	$cal = new TST_Calendar_Table($month, $year);	
	$result['data'] = $cal->generate();
	$result['data'] .= tst_loader_panel();
		
	//if(empty($result['data'])){
	//	$result['type'] = 'error';
	//}
	//	
	echo json_encode($result);
	die();
}