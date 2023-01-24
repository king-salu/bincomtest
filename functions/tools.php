<?php

function createDropBox($name, $id, $_array, $value, $_code = 'code', $_desc = 'info', $default = true)
{
    $html = "   <select name='$name' id='$id'>" .
        (($default) ?   "<option value = 'NONE'>Select an item</option>" : '');
    if (!empty($_array) && is_array($_array)) {
        foreach ($_array as $element) {
            $opt_code = (isset($element[$_code])) ? $element[$_code] : '';
            $opt_desc = (isset($element[$_desc])) ? $element[$_desc] : $opt_code;
            $attrib = '';
            if ($value === $opt_code) $attrib = ' selected ';

            if ($opt_code != '') {
                $html .= "<option value='$opt_code' $attrib>$opt_desc</option>";
            }
        }
    }
    $html .= "  </select>";

    echo $html;
}
