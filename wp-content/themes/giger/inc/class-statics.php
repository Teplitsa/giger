<?php
class TST_Social_Menu {
	
	private static $_menu = null;
	
	function __construct() {		
		
	}
		
	public static function get_menu() {		
		
        if( !self::$_menu ) {
            self::$_menu = wp_nav_menu(array(
						'theme_location'  => 'social',
						//'menu'          => ,
						'menu_class'      => 'social-menu',
						//'menu_id'         => 'social',
						'echo'            => false,                
						'depth'           => 0,
						'fallback_cb'     => ''
					));;
        }
		
        return self::$_menu;
	}
	
}

function tst_get_social_menu(){
	
	echo TST_Social_Menu::get_menu();	
}