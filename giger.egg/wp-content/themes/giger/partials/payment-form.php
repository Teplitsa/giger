<?php
/**
 * Copy paste whole payment form template - to alter class in favour if MDL
 * be careful on updates
 **/

if(!defined('LEYKA_VERSION'))
	return;

global $leyka_current_pm;	
	
$active_pm = apply_filters('leyka_form_pm_order', leyka_get_pm_list(true));
$agree_link = home_url();

leyka_pf_submission_errors();?>

<div id="leyka-payment-form" class="leyka-custom-template">
<?php
	$counter = 0;
	foreach($active_pm as $i => $pm) {
	leyka_setup_current_pm($pm); 
	$counter++;
?>
<div class="leyka-payment-option toggle <?php if($counter == 1) echo 'toggled';?> <?php echo esc_attr($pm->full_id);?>">
<div class="leyka-toggle-trigger <?php echo count($active_pm) > 1 ? '' : 'toggle-inactive';?>">
    <?php echo leyka_pf_get_pm_label();?>
</div>
<div class="leyka-toggle-area">
<form class="leyka-pm-form" id="<?php echo leyka_pf_get_form_id();?>" action="<?php echo leyka_pf_get_form_action();?>" method="post">
	
	<div class="leyka-pm-fields">
		
	<!-- amount -->
	<?php
		$supported_curr = leyka_get_active_currencies();
		$current_curr = $leyka_current_pm->get_current_currency();
		
		if($leyka_current_pm->is_field_supported('amount') ) {
	?>
	
	<div class="leyka-field amount">
		<div><div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label figure">	
			<input type="text" name="leyka_donation_amount" class="required mdl-textfield__input" id="donate_amount_flex" value="<?php echo esc_attr($supported_curr[$current_curr]['amount_settings']['flexible']);?>">                
			<label for="leyka_donation_amount" class="leyka-screen-reader-text mdl-textfield__label">Сумма</label>			
		</div>
		<div class="currency">
			<?php echo $leyka_current_pm->get_currency_field();?>
		</div>
		</div>
		<span id="leyka_donation_amount-error" class="field-error mdl-textfield__error"></span>
	</div>
		
	<?php } //if amount
		
		echo leyka_pf_get_hidden_fields();	
	?>
	<input name="leyka_payment_method" value="<?php echo esc_attr($pm->full_id);?>" type="hidden" />
	<input name="leyka_ga_payment_method" value="<?php echo esc_attr($pm->label);?>" type="hidden" />
			
	<!-- name -->
	<?php if($leyka_current_pm->is_field_supported('name') ) { ?>
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label leyka-field name">
		<input type="text" class="required mdl-textfield__input" name="leyka_donor_name" id="leyka_donor_name" value="">
		<label for="leyka_donor_name" class="leyka-screen-reader-text mdl-textfield__label"><?php _e('Your name', 'leyka');?></label>		
		<span id="leyka_donor_name-error" class="field-error mdl-textfield__error"></span>
	</div>
	<?php  }?>
	
	<!-- email -->
	<?php if($leyka_current_pm->is_field_supported('email') ) { ?>
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label leyka-field email">
		<input type="text" value="" id="leyka_donor_email" name="leyka_donor_email" class="required email mdl-textfield__input">
		<label class="leyka-screen-reader-text mdl-textfield__label" for="leyka_donor_email">Ваш email</label>
		<span class="field-error mdl-textfield__error" id="leyka_donor_email-error"></span>
	</div>
	<?php  }?>
	
	<!-- pm fields -->
	<?php echo leyka_pf_get_pm_fields(); ?>
	
	<!-- agree -->
	<?php
		if($leyka_current_pm->is_field_supported('agree') ) { 
		$agree_check_id = 'leyka_agree-'.$i; ?>
	<div class="leyka-field agree">
		<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect checkbox" for="<?php echo $agree_check_id;?>">
			<input type="checkbox" name="leyka_agree" id="<?php echo $agree_check_id;?>" class="leyka_agree required mdl-checkbox__input" value="1" />
			<a class="leyka-custom-confirmation-trigger " href="<?php echo $agree_link;?>" data-lmodal="#leyka-agree-text">
                <?php echo leyka_options()->opt('agree_to_terms_text');?>
            </a>
		</label>		
		<p class="field-error mdl-textfield__error" id="<?php echo $agree_check_id;?>-error"></p>
	</div>	
	<?php }?>
	
	<!-- submit -->	
	<div class="leyka-field submit">
	<?php if($leyka_current_pm->is_field_supported('submit') ) { ?>
		<input type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="leyka_donation_submit" name="leyka_donation_submit" value="Пожертвовать" />
	<?php  }

		$icons = leyka_pf_get_pm_icons(); 
		if($icons) {
	
			$list = array();
			foreach($icons as $i) {
				$i = (is_ssl()) ? str_replace('http:', 'https:', $i) : $i;
				$list[] = "<li>{$i}</li>";
			}
	
			echo '<ul class="leyka-pm-icons cf">'.implode('', $list).'</ul>';
		}
	?>
	</div>
	
	
	</div> <!-- .leyka-pm-fields -->	
	
	<div class="leyka-pm-desc">
		<?php echo apply_filters('leyka_the_content', leyka_pf_get_pm_description()); ?>
	</div>
	
</form>
</div>
</div>
<?php }

//add agree modal to footer
add_action('wp_footer', function(){

?>
<div id="leyka-agree-text" class="leyka-oferta-text leyka-custom-modal">
	<div class="leyka-modal-close">		
			<?php echo tst_material_icon('close');?>		
	</div>
	<div class="leyka-oferta-text-frame">
		<div class="leyka-oferta-text-flow">
			<?php echo apply_filters('leyka_terms_of_service_text', leyka_options()->opt('terms_of_service_text'));?>
		</div>
	</div>
</div>
<?php	
});

leyka_pf_footer();?>

</div><!-- #leyka-payment-form -->