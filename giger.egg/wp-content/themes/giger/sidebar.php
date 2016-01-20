<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package bb
 */


?>

<div class="sidebar<?php if(is_front_page()) echo " no-spacing-correct-left";?>" role="complementary">	
	<?php dynamic_sidebar( 'right-sidebar' ); ?>	
</div>
