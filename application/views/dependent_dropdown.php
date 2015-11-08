<?php
if(isset($dd_state) && ($dd_state == 'add' || $dd_state == 'edit')) {
echo '<script type="text/javascript">';
echo '$(document).ready(function() {';
for($i = 0; $i <= sizeof($dd_dropdowns)-1; $i++):
	echo 'var '.$dd_dropdowns[$i].' = $(\'select[name="'.$dd_dropdowns[$i].'"]\');';

	if($i != sizeof($dd_dropdowns)-1) {
		echo '$(\'#'.$dd_dropdowns[$i].'_input_box\').append(\'<img src="'.$dd_ajax_loader.'" border="0" id="'.$dd_dropdowns[$i].'_ajax_loader" class="dd_ajax_loader" style="display: none;">\');';
	}
endfor;

for($i = 1; $i <= sizeof($dd_dropdowns)-1; $i++):
	echo $dd_dropdowns[$i-1].'.change(function() {';
	echo 'var select_value = this.value;';
	echo '$(\'#'.$dd_dropdowns[$i-1].'_ajax_loader\').show();';
	echo $dd_dropdowns[$i].'.find(\'option\').remove();';
        echo $dd_dropdowns[2].'.find(\'option\').remove();';
       // echo 'alert("'.$dd_url[$i].'");';
	echo 'var myOptions = "";';
	echo '$.getJSON(\''.$dd_url[$i].'\'+select_value, function(data) {';
	echo $dd_dropdowns[$i].'.append(\'<option value=""></option>\');';
	echo '$.each(data, function(key, val) {';
	echo $dd_dropdowns[$i].'.append(';
	echo '$(\'<option></option>\').val(val.value).html(val.property)';
	echo ');';
	echo '});';

	echo '$(\'#'.$dd_dropdowns[$i].'_input_box\').show();';
	echo $dd_dropdowns[$i-1].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
	echo $dd_dropdowns[$i].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
        echo $dd_dropdowns[2].'.each(function(){';
	echo '$(this).trigger("liszt:updated");';
	echo '});';
        
	echo '$(\'#'.$dd_dropdowns[$i-1].'_ajax_loader\').hide();';
	echo '});';
	echo '});';
endfor;
echo '});';
echo '</script>';
}
?>