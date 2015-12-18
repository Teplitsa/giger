<?php
/**
 * Text PM Customisation Example
 **/

/** Custom donation functions */

add_filter('leyka_icons_text_text_box', 'tst_text_pm_icon');
function tst_text_pm_icon($icons){
	//size 155x80 px
	
	$icons = array(get_template_directory_uri().'/assets/images/text-box.png');
		
	return $icons;
}

/** Additionsl text PM */
class Leyka_Sms_Box extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'sms_box';
        $this->_gateway_id = 'text';

        $this->_label_backend = 'Платеж по СМС';
        $this->_label = 'Платеж по СМС';

        // The description won't be setted here - it requires the PM option being configured at this time (which is not)

        $this->_support_global_fields = false;

        $this->_icons = array(get_template_directory_uri().'/assets/images/sms-box.png');

        $this->_supported_currencies[] = 'rur';

        $this->_default_currency = 'rur';
    }

    protected function _set_dynamic_attributes() {

        $this->_custom_fields = array(
            'sms_details' => apply_filters('leyka_the_content', leyka_options()->opt_safe('sms_box_details')),
        );
    }

    protected function _set_options_defaults() {

        if($this->_options){
            return;
        }

        $this->_options = array(
            $this->full_id.'_description' => array(
                'type' => 'html',
                'default' => '',
                'title' => 'Описание платежа по СМС',
                'description' => __('Please, set a text of comment to describe an additional ways to donate.', 'leyka'),
                'required' => 0,
                'validation_rules' => array(), // List of regexp?..
            ),
            'sms_box_details' => array(
                'type' => 'html',
                'default' => '',
                'title' => 'Инструкция к платежу по СМС',
                'description' => __('Please, set a text to describe an additional ways to donate.', 'leyka'),
                'required' => 1,
                'validation_rules' => array(), // List of regexp?..
            )
        );
    }
}



add_action('leyka_init_pm_list', 'tst_add_sms_pm');
function tst_add_sms_pm($gateway){
	
	if($gateway->__get('id') == 'text'){		
		$gateway->add_payment_method(Leyka_Sms_Box::get_instance());
	}
}
