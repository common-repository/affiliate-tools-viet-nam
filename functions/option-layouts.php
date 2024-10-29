<?php
if (!defined('DB_NAME'))
    die('Error: Plugin "affiliate-tools" does not support standalone calls, damned hacker.');

function check_AP( $val_string, $ap_string ) {

    if($val_string === $ap_string) {
        return "selected =`selected`";
    } else {
        return "";
    }

}

function get_chk_option($options = array(), $option = '') {

	$layout = '';
	$layout .= '<br><input type="checkbox" name="options[' . $option['new_name'] . ']" value="1"';
    if ($options[$option['new_name']]) 
    	$layout .= ' checked';
    $layout .= '>' . $option['name'];
    return $layout;
}

function get_txt_option($options = array(), $option = '') {

	$layout = '';
	$layout .= '<br>' . $option['name'] . ':<br><input type="text" name="options[' . $option['new_name'] . ']" value="' . $options[$option['new_name']] . '">';
	return $layout;
}

function get_text_option($options = array(), $option = '') {

	$layout = '';
	$layout .= '<p>' . $option['name'] . ':</p>';
    $layout .= '<textarea name="options[' . $option['new_name'] . ']" class="large-text code" rows="6" cols="50">' . $options[$option['new_name']] . '</textarea>';
	return $layout;
}

function get_slt_option($options = array(), $option = '') {

	$layout = '';
	$layout .= $option['name'].":</br>";
    $layout .= ' <select id="'.$option['name'].'_select" onchange="" name="options['.$option['new_name'].']" value="' . $options[$option['new_name']] .'">

        <option name="options['.$option['new_name'].']" value="masoffer" '. check_AP($options[$option['new_name']],'masoffer') .'>MasOffer</option>
        
        <option name="options['.$option['new_name'].']" value="accesstrade" '. check_AP($options[$option['new_name']],'accesstrade') .'  >AccessTrade</option>
        </select>';
	return $layout;
}
function get_custom_site_slt_option($options = array(), $option = ''){
    $layout = '';
    $layout .= "<br><strong>".$option['name'].":</strong></br>";
    $layout .= '
        <input id="aff_custom_ap_slt_val_'.$option['new_name'].'" type="hidden" value="'.$options[$option['new_name']].'" name="options['.$option['new_name'].']" >
        <select class="aff_custom_ap_slt_'.$option['new_name'].'"  style="width: 50%" multiple="multiple"></select>
    ';

    $layout .= '<script>
            val = jQuery("#aff_custom_ap_slt_val_'.$option['new_name'].'").val();
            var data = [];
            if (val != "")
                val = val.split(",");
            jQuery(val).each(function(index, value){
                data.push({
                    id: value, text: value,selected:"selected" 
                });
            });
            jQuery(".aff_custom_ap_slt_'.$option['new_name'].'").select2({
                tags: true,
                placeholder: "Type in name",
                data:data,
                minimumResultsForSearch: Infinity
            }).on("change", function (evt) {
                vals = jQuery(this).select2("val");
                if (vals != null)
                    vals = vals.join(",");
                else
                    vals = "";
                jQuery("#aff_custom_ap_slt_val_'.$option['new_name'].'").val(vals);
            })
            

            </script>';
    return $layout;
}


function get_aff_plat_key_option($options = array(), $option = '') {

	$layout = '';
	$layout .= $option['name'].":</br>";
    $layout .= '<input type="text" name="options[' . $option['new_name'] . ']" value="' . $options[$option['new_name']] . '">';
	return $layout;
}

?>