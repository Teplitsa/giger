<?php
/**
 * The template for displaying search forms 
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="searchform" method="get">
	
	<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--align-right">		
		<input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" id="s" class="mdl-textfield__input">
		<label for="s" class="mdl-textfield__label">Поиск...</label>
		<button type="submit" class="mdl-button mdl-js-button mdl-button--icon">
			<i class="material-icons">search</i>
		</button>
	</div>
	
</form>