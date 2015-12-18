<?php
/** NINJA FORMS **/
add_action('after_setup_theme', function(){
	
	if(class_exists('Ninja_Forms')) {
		//notices in admin from incorrect post message filterng - remove it
		$nf = Ninja_Forms::instance();
		remove_filter( 'post_updated_messages', array( $nf->subs_cpt, 'post_updated_messages' ) );
		
		//remove CSS
		remove_action( 'ninja_forms_display_css', 'ninja_forms_display_css', 10, 2 );
		
		//remove unsupported fields
		remove_action( 'init', 'ninja_forms_register_field_calc' );	
		remove_action( 'init', 'ninja_forms_register_field_credit_card' );
		remove_action( 'init', 'ninja_forms_register_field_number' );
		remove_action( 'init', 'ninja_forms_register_field_hr' );
		remove_action( 'init', 'ninja_forms_register_field_profile_pass' );
		remove_action( 'init', 'ninja_forms_register_field_rating' );
		remove_action( 'init', 'ninja_forms_register_field_tax' );
		remove_action( 'init', 'ninja_forms_register_field_timed_submit' );
		remove_action( 'init', 'ninja_forms_register_field_spam');
		
		remove_action('admin_init', 'ninja_forms_register_sidebar_payment_fields');
		remove_action('admin_init', 'ninja_forms_register_sidebar_user_info_fields');
		   add_action('admin_init', 'tst_nf_register_sidebar_user_info_fields');
	}
	
});

//to-do deregister unused fields


//wrapper class
add_filter('ninja_forms_display_field_wrap_class', 'tst_nf_field_wrap_class', 2,3);
function tst_nf_field_wrap_class($field_wrap_class, $field_id, $field_row) {
	
	if($field_row['type'] == '_text'){
		$field_wrap_class .= ' mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width';
	}
	elseif($field_row['type'] == '_textarea') {
		$field_wrap_class .= ' mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width';
	}
	elseif($field_row['type'] == '_list' && $field_row['data']['list_type'] == 'dropdown') {
		$field_wrap_class .= ' tst-select';
	}
	
	
	return $field_wrap_class;
}

//form message
add_filter('ninja_forms_display_response_message_class', 'tst_nf_display_response_message_class', 2, 2);
function tst_nf_display_response_message_class($class, $form_id) {
	global $ninja_forms_processing;
		
	if(!is_object($ninja_forms_processing)){
		$class .= ' empty';
	}
	elseif(!$ninja_forms_processing->get_all_errors() AND !$ninja_forms_processing->get_all_success_msgs()){
		$class .= ' empty';
	}
	
	return $class;
}


//classes for labels and inputs
add_action('ninja_forms_field', 'tst_nf_field_data', 2, 2);
function tst_nf_field_data($data, $field_id) {
	
	$field = ninja_forms_get_field_by_id( $field_id );
	
	if($field['type'] == '_text' || $field['type'] == '_textarea' ){
		$data['label_pos'] = 'below';
	}
	elseif($field['type'] == '_checkbox'){
		$data['label_pos'] = 'none';
	}
	
	return $data;
}


add_filter('ninja_forms_label_class', 'tst_nf_label_class', 2, 2);
function tst_nf_label_class($label_class, $field_id) {
	
	$field = ninja_forms_get_field_by_id( $field_id );
	
	if($field['type'] == '_text' || $field['type'] == '_textarea' ){
		$label_class .= " mdl-textfield__label";
	}
	elseif($field['type'] == '_list') {
		
		$label_class .= " tst-inputfix__label";		
	}
	return $label_class;
}


add_filter('ninja_forms_display_field_class', 'tst_nf_input_class', 2, 3);
function tst_nf_input_class($field_class, $field_id, $field_row) {
	
	if($field_row['type'] == '_text'){
		$field_class .= ' mdl-textfield__input';
	}
	elseif($field_row['type'] == '_textarea'){
		$field_class .= ' mdl-textfield__input';
	}
	elseif($field_row['type'] == '_checkbox'){
		$field_class .= ' mdl-checkbox__input';
	}
	elseif($field_row['type'] == '_submit'){
		$field_class .= ' mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect';
	}
	//var_dump($field_row['type']);
	return $field_class;
}

//custom html for checkbox
add_action('ninja_forms_display_before_field_function', 'tst_nf_before_input', 2, 2);
function tst_nf_before_input($field_id, $data){
	$field = ninja_forms_get_field_by_id( $field_id );
	
	if($field['type'] == '_checkbox'){
		echo "<label class='mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect' for='ninja_forms_field_{$field_id}'>";
	}
}

add_action('ninja_forms_display_after_field_function', 'tst_nf_after_input', 2, 2);
function tst_nf_after_input($field_id, $data){
	$field = ninja_forms_get_field_by_id( $field_id );
	
	if($field['type'] == '_checkbox'){
		echo "<span class='mdl-checkbox__label'>".$data['label']."</span></label>";		
	}
}

//filter html for list-type fields
add_filter('ninja_forms_display_fields_array', 'tst_nf_display_fields_array', 2, 2);
function tst_nf_display_fields_array($field_results, $form_id){
	global $ninja_forms_fields;
	
	$ninja_forms_fields['_list']['display_function'] = 'tst_nf_field_list_display';
	
	return $field_results;
}


function tst_nf_field_list_display($field_id, $data, $form_id = ''){
	global $wpdb, $ninja_forms_fields;

	if(isset($data['show_field'])){
		$show_field = $data['show_field'];
	}else{
		$show_field = true;
	}

	$field_class = ninja_forms_get_field_class( $field_id, $form_id );
	$field_row = ninja_forms_get_field_by_id($field_id);

	$type = $field_row['type'];
	$type_name = $ninja_forms_fields[$type]['name'];

	if ( isset( $data['list_type'] ) ) {
		$list_type = $data['list_type'];
	} else {
		$list_type = '';
	}

	if(isset($data['list_show_value'])){
		$list_show_value = $data['list_show_value'];
	}else{
		$list_show_value = 0;
	}

	if( isset( $data['list']['options'] ) AND $data['list']['options'] != '' ){
		$options = $data['list']['options'];
	}else{
		$options = array();
	}

	if(isset($data['label_pos'])){
		$label_pos = $data['label_pos'];
	}else{
		$label_pos = 'left';
	}

	if(isset($data['label'])){
		$label = $data['label'];
	}else{
		$label = $type_name;
	}

	if( isset( $data['multi_size'] ) ){
		$multi_size = $data['multi_size'];
	}else{
		$multi_size = 5;
	}

	if( isset( $data['default_value'] ) AND !empty( $data['default_value'] ) ){
		$selected_value = $data['default_value'];
	}else{
		$selected_value = '';
	}

	$list_options_span_class = apply_filters( 'ninja_forms_display_list_options_span_class', '', $field_id );

	switch($list_type){
		case 'dropdown':
			?>
			<select name="ninja_forms_field_<?php echo $field_id;?>" id="ninja_forms_field_<?php echo $field_id;?>" class="<?php echo $field_class;?>" rel="<?php echo $field_id;?>">
				<?php
				if($label_pos == 'inside'){
					?>
					<option value=""><?php echo $label;?></option>
					<?php
				}
				foreach($options as $option){

					if(isset($option['value'])){
						$value = $option['value'];
					}else{
						$value = $option['label'];
					}

					$value = htmlspecialchars( $value, ENT_QUOTES );

					if(isset($option['label'])){
						$label = $option['label'];
					}else{
						$label = '';
					}

					if(isset($option['display_style'])){
						$display_style = $option['display_style'];
					}else{
						$display_style = '';
					}

					if ( isset( $option['disabled'] ) AND $option['disabled'] ){
						$disabled = 'disabled';
					}else{
						$disabled = '';
					}

					$label = htmlspecialchars( $label, ENT_QUOTES );

					$label = stripslashes( $label );

					$label = str_replace( '&amp;', '&', $label );

					$field_label = $data['label'];

					if($list_show_value == 0){
						$value = $label;
					}


					if ( $selected_value == $value OR ( is_array( $selected_value ) AND in_array( $value, $selected_value ) ) ) {
						$selected = 'selected';
					}else if( ( $selected_value == '' OR $selected_value == $field_label ) AND isset( $option['selected'] ) AND $option['selected'] == 1 ){
						$selected = 'selected';
					}else{
						$selected = '';
					}

					?>
					<option value="<?php echo $value;?>" <?php echo $selected;?> style="<?php echo $display_style;?>" <?php echo $disabled;?>><?php echo $label;?></option>
				<?php
				}
				?>
			</select>
			<?php
			break;
		case 'radio':
			$x = 0;
			if( $label_pos == 'left' OR $label_pos == 'above' ){
				?><?php

			}
			?><input type="hidden" name="ninja_forms_field_<?php echo $field_id;?>" value=""><span id="ninja_forms_field_<?php echo $field_id;?>_options_span" class="<?php echo $list_options_span_class;?>" rel="<?php echo $field_id;?>"><ul><?php
			foreach($options as $option){

				if(isset($option['value'])){
					$value = $option['value'];
				}else{
					$value = $option['label'];
				}

				$value = htmlspecialchars( $value, ENT_QUOTES );

				if(isset($option['label'])){
					$label = $option['label'];
				}else{
					$label = '';
				}

				if(isset($option['display_style'])){
					$display_style = $option['display_style'];
				}else{
					$display_style = '';
				}

				//$label = htmlspecialchars( $label, ENT_QUOTES );

				$label = stripslashes($label);

				if($list_show_value == 0){
					$value = $label;
				}

				if ( $selected_value == $value OR ( is_array( $selected_value ) AND in_array( $value, $selected_value ) ) ) {
					$selected = 'checked';
				}else if( $selected_value == '' AND isset( $option['selected'] ) AND $option['selected'] == 1 ){
					$selected = 'checked';
				}else{
					$selected = '';
				}
				?><li><label id="ninja_forms_field_<?php echo $field_id;?>_<?php echo $x;?>_label" class="ninja-forms-field-<?php echo $field_id;?>-options mdl-radio mdl-js-radio mdl-js-ripple-effect " style="<?php echo $display_style;?>" for="ninja_forms_field_<?php echo $field_id;?>_<?php echo $x;?>"><input id="ninja_forms_field_<?php echo $field_id;?>_<?php echo $x;?>" name="ninja_forms_field_<?php echo $field_id;?>" type="radio" class="<?php echo $field_class;?> mdl-radio__button" value="<?php echo $value;?>" <?php echo $selected;?> rel="<?php echo $field_id;?>" /><span class="mdl-radio__label"><?php echo $label;?></span></label></li><?php
				$x++;
			}
			?></ul></span><li style="display:none;" id="ninja_forms_field_<?php echo $field_id;?>_template"><label><input id="ninja_forms_field_<?php echo $field_id;?>_" name="" type="radio" class="<?php echo $field_class;?>" value="" rel="<?php echo $field_id;?>" /></label></li>
			<?php
			break;
		case 'checkbox':
			$x = 0;
			?><input type="hidden" id="ninja_forms_field_<?php echo $field_id;?>" name="ninja_forms_field_<?php echo $field_id;?>" value=""><span id="ninja_forms_field_<?php echo $field_id;?>_options_span" class="<?php echo $list_options_span_class;?>" rel="<?php echo $field_id;?>"><ul><?php
			foreach($options as $option){

				if(isset($option['value'])){
					$value = $option['value'];
				}else{
					$value = $option['label'];
				}

				$value = htmlspecialchars( $value, ENT_QUOTES );

				if(isset($option['label'])){
					$label = $option['label'];
				}else{
					$label = '';
				}

				if(isset($option['display_style'])){
					$display_style = $option['display_style'];
				}else{
					$display_style = '';
				}

				//$label = htmlspecialchars( $label, ENT_QUOTES );

				$label = stripslashes( $label) ;

				if($list_show_value == 0){
					$value = $label;
				}

				if( isset( $option['selected'] ) AND $option['selected'] == 1 ){
					$checked = 'checked';
				}

				if( is_array( $selected_value ) AND in_array($value, $selected_value) ){
					$checked = 'checked';
				}else if($selected_value == $value){
					$checked = 'checked';
				}else if( $selected_value == '' AND isset( $option['selected'] ) AND $option['selected'] == 1 ){
					$checked = 'checked';
				}else{
					$checked = '';
				}

				?><li><label id="ninja_forms_field_<?php echo $field_id;?>_<?php echo $x;?>_label" class="ninja-forms-field-<?php echo $field_id;?>-options mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" style="<?php echo $display_style;?>"><input id="ninja_forms_field_<?php echo $field_id;?>_<?php echo $x;?>" name="ninja_forms_field_<?php echo $field_id;?>[]" type="checkbox" class="<?php echo $field_class;?> ninja_forms_field_<?php echo $field_id;?> mdl-checkbox__input" value="<?php echo $value;?>" <?php echo $checked;?> rel="<?php echo $field_id;?>"/><span class="mdl-checkbox__label"><?php echo $label;?></span></label></li><?php
				$x++;
			}
			?></ul></span><li style="display:none;" id="ninja_forms_field_<?php echo $field_id;?>_template"><label><input id="ninja_forms_field_<?php echo $field_id;?>_" name="" type="checkbox" class="<?php echo $field_class;?>" value="" rel="<?php echo $field_id;?>" /></label></li>
			<?php
			break;
		case 'multi':
			?>
			<select name="ninja_forms_field_<?php echo $field_id;?>[]" id="ninja_forms_field_<?php echo $field_id;?>" class="<?php echo $field_class;?>" multiple size="<?php echo $multi_size;?>" rel="<?php echo $field_id;?>" >
				<?php
				if($label_pos == 'inside'){
					?>
					<option value=""><?php echo $label;?></option>
					<?php
				}
				foreach($options as $option){

					if(isset($option['value'])){
						$value = $option['value'];
					}else{
						$value = $option['label'];
					}

					$value = htmlspecialchars( $value, ENT_QUOTES );

					if(isset($option['label'])){
						$label = $option['label'];
					}else{
						$label = '';
					}

					if(isset($option['display_style'])){
						$display_style = $option['display_style'];
					}else{
						$display_style = '';
					}

					$label = htmlspecialchars( $label, ENT_QUOTES );

					$label = stripslashes($label);

					if($list_show_value == 0){
						$value = $label;
					}

					if(is_array($selected_value) AND in_array($value, $selected_value)){
						$selected = 'selected';
					}else if( $selected_value == '' AND isset( $option['selected'] ) AND $option['selected'] == 1 ){
						$selected = 'selected';
					}else{
						$selected = '';
					}

					if( $display_style == '' ){
					?>
					<option value="<?php echo $value;?>" <?php echo $selected;?>><?php echo $label;?></option>
					<?php
					}
				}
				?>
			</select>
			<select id="ninja_forms_field_<?php echo $field_id;?>_clone" style="display:none;" rel="<?php echo $field_id;?>" >
				<?php
				$x = 0;
				foreach($options as $option){

					if(isset($option['value'])){
						$value = $option['value'];
					}else{
						$value = $option['label'];
					}

					$value = htmlspecialchars( $value, ENT_QUOTES );

					if(isset($option['label'])){
						$label = $option['label'];
					}else{
						$label = '';
					}

					if(isset($option['display_style'])){
						$display_style = $option['display_style'];
					}else{
						$display_style = '';
					}

					$label = htmlspecialchars( $label, ENT_QUOTES );

					$label = stripslashes( $label );

					if($list_show_value == 0){
						$value = $label;
					}

					if(is_array($selected_value) AND in_array($value, $selected_value)){
						$selected = 'selected';
					}else{
						$selected = '';
					}

					if( $display_style != '' ){
					?>
					<option value="<?php echo $value;?>" title="<?php echo $x;?>" <?php echo $selected;?>><?php echo $label;?></option>
					<?php
					}
					$x++;
				}
				?>
			</select>
			<?php
			break;
	}
}


//filter user related fields in admin
function tst_nf_register_sidebar_user_info_fields(){
	$args = array(
		'name' => __( 'User Information', 'ninja-forms' ),
		'page' => 'ninja-forms',
		'tab' => 'builder',
		'display_function' => 'tst_nf_sidebar_user_info_fields'
	);
	ninja_forms_register_sidebar('user_info', $args);
}

function tst_nf_sidebar_user_info_fields(){
	global $wpdb, $ninja_forms_fields;
	$field_results = ninja_forms_get_all_defs();

	if(is_array($field_results)){
		foreach($field_results as $field){
			if(false !== strpos($field['name'], 'Email')){
				$data = $field['data'];
				if ( isset ( $data['user_info_field_group'] ) AND $data['user_info_field_group'] == 1 ) {
					$name = $field['name'];
					$field_id = $field['id'];
					$type = $field['type'];
					$reg_field = $ninja_forms_fields[$type];
					$limit = '';
	
					?>
					<p class="button-controls" id="ninja_forms_insert_def_field_<?php echo $field_id;?>_p">
						<a class="button-secondary ninja-forms-insert-def-field" id="ninja_forms_insert_def_field_<?php echo $field_id;?>" data-limit="<?php echo $limit; ?>" data-field="<?php echo $field_id; ?>" data-type="<?php echo $type; ?>" href="#"><?php _e($name, 'ninja-forms');?></a>
					</p>
					<?php				
				}
			}
		}
	}

	
}

