<?php

  // define output functions.

  /*
   *  Copyright (C) 2010  Efstathios Chatzikyriakidis (stathis.chatzikyriakidis@gmail.com)
   *  Copyright (C) 2010  Stefanos Tzagias            (steftzag@gmail.com)
   *
   *  This program is free software: you can redistribute it and/or modify
   *  it under the terms of the GNU General Public License as published by
   *  the Free Software Foundation, either version 3 of the License, or
   *  (at your option) any later version.
   *
   *  This program is distributed in the hope that it will be useful,
   *  but WITHOUT ANY WARRANTY; without even the implied warranty of
   *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
   *  GNU General Public License for more details.
   *
   *  You should have received a copy of the GNU General Public License
   *  along with this program. If not, see <http://www.gnu.org/licenses/>.
   */

  // try to get a transparent graphical blank space.
  function space ($width = 1, $height = 1) {
    return '<img src="http://'.CONF_HTTP_HOST.'/'.DIR_GRAPHICS.'/pixel.png" width="'.$width.'" height="'.$height.'" border="0" alt="">';
  }

  // try to get a single-line text box.
  function input_text ($name, $style, $value = '', $attrs = '') {
    $element = '<input type="text" name="'.$name.'" style="'.$style.'" value="'.$value.'"';

    if ($attrs != '')
      $element .= ' '.$attrs;

    $element .= '>';
    return $element;
  }

  // try to get a textarea box.
  function input_textarea ($name, $style, $value = '') {
    return '<textarea style="'.$style.'" name="'.$name.'" cols="0" rows="0">'.$value.'</textarea>';
  }
  
  // try to get a submit or reset button.
  function input_button ($type, $name, $value = '', $style = '', $action = '') {
    $element = '<input type="'.$type.'" name="'.$name.'"';

    if ($type != "image")
      $element .= ' value="'.$value.'"';
    else
      $element .= ' src="'.$value.'"';

    if ($style != '')
      $element .= ' style="'.$style.'"';

    if ($action != '')
      $element .= ' '.$action;

    $element .= '>';
    return $element;
  }

  // try to get markers' types select box.
  function select_type ($selected, $select_name, $style, $admin, $action = '') {
    // fetch the markers' types.
    $types = get_markers_types ();

    // if it's not possible to get markers' types.
    if (!$types) return false;

    // create the open select box tag.
    $stype = '<select style="'.$style.'" name="'.$select_name.'"';
    if ($action != '')
      $stype .= ' '.$action;
    $stype .= '>';

    // add the appropriate default option tag.
    $stype .= '<option value="">';
    if (!$admin)
      $stype .= clean_for_display ($GLOBALS['select_type_guest_default_option']);
    else
      $stype .= clean_for_display ($GLOBALS['select_type_admin_default_option']);
    $stype .= '</option>';

    // iterate through the rows, display option tags.
    foreach ($types as $row) {
      // get current appropriate values from the row.
      $name = clean_for_display ($row['name']);
      $letter = clean_for_display ($row['letter']);
      $id = clean_for_display ($row['id']);

      // add the current option tag.
      $stype .= '<option value="'.$id.'"';
      if ($id == $selected)
        $stype .= ' selected';
      $stype .= '>'.$letter.' - '.$name.'</option>';
    }

    // add the close select box tag.
    $stype .= '</select>';

    return $stype;
  }

  // try to get a html link.
  function do_html_URL ($url, $text, $title, $target, $attrs = '') {
    $element = '<a href="'.$url.'" title="'.$title.'" target="'.$target.'"';

    if ($attrs != '')
      $element .= ' '.$attrs;

    $element .= '>'.$text.'</a>';
    return $element;
  }

  // try to get a javascript associative array according to the php given.
  function js_associative_array ($phpArray, $jsArrayName) {
    $length = count ($phpArray); $ii = 0;

    $html = "var " . $jsArrayName . " = {";
    foreach ($phpArray as $key => $value) {
      $html .= "'" . $key . "': ";
      if (is_string ($value))
        $html .= "'" . $value."'";
      else if ($value === false)
        $html .= "false";
      else if ($value === NULL)
        $html .= "null";
      else if ($value === true)
        $html .= "true";
      else
        $html .= $value;

      if (++$ii < $length)
        $html .= ", ";
    }
         
    return $html."};\n";
  }
?>
