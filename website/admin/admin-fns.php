<?php

  // define administration functions.

  /*
   *  Copyright (C) 2010  Efstathios Chatzikyriakidis (contact@efxa.org)
   *  Copyright (C) 2010  Stefanos Tzagias           (steftzag@gmail.com)
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

  // try to create a new type.
  function add_new_type ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** add_new_type() : ".mysql_error ()."</p>";
      return false;
    }
    
    // create short variable names.
    $type_name   = clean ($_POST['type_name']);
    $type_symbol = clean ($_POST['type_symbol']);

    // is there any empty field in the form?
    if (!filled_out ($_POST)) {
      echo clean_for_display ($GLOBALS['fill_all_form_data']);
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // try to add the new type if does not exist.
    if (type_exists ($type_name)) {
      echo clean_for_display ($GLOBALS['the_type_exists']);
      return false;
    }
    else {
      // create a sql query for adding the new type.
      $query = "INSERT INTO types VALUES (NULL, '$type_name', '$type_symbol')";

      // execute and check the result of the query.
      $result = @mysql_query ($query);
      if (!$result) {
        echo clean_for_display ($GLOBALS['sql_database_insert_error']);
        echo "<p>*** add_new_type() : ".mysql_error ()."</p>";
        return false;
      }
    }

    // the new type is created.
    echo clean_for_display ($GLOBALS['admin_add_type_created']);
    return true;
  }

  // try to create a new marker.
  function add_new_marker ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** add_new_marker() : ".mysql_error ()."</p>";
      return false;
    }

    // create short variable names.
    $marker_name  = clean ($_POST['marker_name']);
    $marker_type  = clean ($_POST['marker_type']);
    $marker_email = clean ($_POST['marker_email']);
    $marker_url   = clean ($_POST['marker_url']);
    $marker_addr  = clean ($_POST['marker_addr']);
    $marker_lat   = clean ($_POST['marker_lat']);
    $marker_lng   = clean ($_POST['marker_lng']);
    $marker_phone = clean ($_POST['marker_phone']);
    $marker_text  = pretty ($_POST['marker_text']);

    // if any of the necessary fields is empty.
    if ((!isset ($marker_name) || empty ($marker_name)) ||
        (!isset ($marker_type) || empty ($marker_type)) ||
        (!isset ($marker_addr) || empty ($marker_addr)) ||
        (!isset ($marker_lat)  || empty ($marker_lat))  ||
        (!isset ($marker_lng)  || empty ($marker_lng))) {
      echo clean_for_display ($GLOBALS['fill_fields_form']);
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // BEGIN a db transaction.
    mysql_query ("BEGIN");
    
    // create a sql query for adding the new marker.
    $query = "INSERT INTO markers VALUES (NULL, '$marker_name', '$marker_addr', '$marker_lat', '$marker_lng', '$marker_type')";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_insert_error']);
      echo "<p>*** add_new_marker() : ".mysql_error ()."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }
    else {
      // create a sql query for adding the new content.
      $query = "INSERT INTO contents VALUES (NULL, '$marker_email', '$marker_url', '$marker_phone', '$marker_text', '".mysql_insert_id ()."')";

      // execute and check the result of the query.
      $result = @mysql_query ($query);
      if (!$result) {
        echo clean_for_display ($GLOBALS['sql_database_insert_error']);
        echo "<p>*** add_new_marker() : ".mysql_error ()."</p>";

        // ROLLBACK the db transaction.
        mysql_query ("ROLLBACK");
        return false;
      }
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    // the new marker is created.
    echo clean_for_display ($GLOBALS['admin_add_marker_created']);
    return true;
  }
  
  // try to check if a type exists.
  function type_exists ($type_name) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** type_exists() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for checking for a type.
    $query = "SELECT COUNT(*) FROM types WHERE name = '$type_name'"; 

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** type_exists() : ".mysql_error ()."</p>";
      return false;
    }

    // check to see if the type exists.
    if (mysql_result ($result, 0, 0) > 0)
      return true;

    return false;
  }
  
  // try to display markers types.
  function display_types ($types) {
    // if there are no types.
    if (!is_array ($types)) {
      echo "*** display_types() : ".clean_for_display ($GLOBALS['there_are_no_types']);
      return false;
    }

    $value  = '<table style="background-color: #b9e8f0;" cellpadding="5" cellspacing="0" border="1">';
    $value .= ' <tbody style="font-weight: bold;">';
    $value .= '  <tr>';
    $value .= '   <td align="center">'.clean_for_display ($GLOBALS['increasing_number']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_type_list_name']).'</td><td align="center">X</td>';
    $value .= '  </tr>';

    // the following var is used for looping.
    $i = '';

    $del_target = $show_target = "main_column";

    $del_text   = "[ <b>x</b> ]";

    // create each url link for each type.
    foreach ($types as $row) {
      // update link.
      $show_url  = FILE_UPD_TYPE_FORM.'?tid='.clean_for_display ($row['id']);
      $show_text = clean_for_display ($row['name']); 

      // remove link.
      $del_url = FILE_DEL_TYPE_PROC.'?tid='.clean_for_display ($row['id']);

      // print type details.
      $value .= ' <tr>';
      $value .= '  <td align="center" width="40">'. ++$i.'</td>';
      $value .= '  <td class="nowrap">'.do_html_url ($show_url, $show_text, '', $show_target).'</td>';
      $value .= '  <td align="center" class="nowrap">'.do_html_url ($del_url, $del_text, '', $del_target, 'onclick="return confirm ('."'".clean_for_display ($GLOBALS['deletion_yes_no'])."'".');"').'</td>';
      $value .= ' </tr>';
    }

    $value .= ' </tbody>';
    $value .= '</table>';

    return $value;
  }

  // try to delete a marker type.
  function delete_type ($tid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** delete_type() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for checking the existence of the type id.
    $query = "SELECT id FROM types WHERE id = '$tid'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** delete_type() : ".mysql_error ()."</p>";
      return false;
    }

    // check for a type with the given id.
    $num = @mysql_num_rows ($result);
    if (!$num) {
      echo clean_for_display ($GLOBALS['admin_del_type_missing']);
      return false;
    }

    // create a sql query for checking for markers.
    $query = "SELECT COUNT(*) FROM markers WHERE type = '$tid'"; 

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** delete_type() : ".mysql_error ()."</p>";
      return false;
    }

    // check to see there are any marker in the type.
    if (mysql_result ($result, 0, 0) > 0) {
      echo clean_for_display ($GLOBALS['admin_del_type_contain']);
      return false;
    }

    // create a sql query for deleting the type.
    $query = "DELETE FROM types WHERE id = '$tid'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_delete_error']);
      echo "<p>*** delete_type() : ".mysql_error ()."</p>";
      return false;
    }

    echo clean_for_display ($GLOBALS['admin_del_type_deleted']);
    return true;
  }

  // try to update a marker type.
  function update_type ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** update_type() : ".mysql_error ()."</p>";
      return false;
    }

    // create short variable names.
    $type_id     = clean ($_POST['type_id']);
    $type_name   = clean ($_POST['type_name']);
    $type_iname  = clean ($_POST['type_iname']);
    $type_symbol = clean ($_POST['type_symbol']);

    // is there any empty field in the form?
    if (!filled_out ($_POST)) {
      echo clean_for_display ($GLOBALS['fill_all_form_data']);
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // if there was a change in the type name.
    if ($type_name != $type_iname) {
      // check if the type exists.
      if (type_exists ($type_name)) {
        echo clean_for_display ($GLOBALS['the_type_exists']);
        return false;
      }
    }

    // create a sql query for updating a type.
    $query = "UPDATE types SET name = '$type_name', letter = '$type_symbol' WHERE id = '$type_id'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_update_error']);
      echo "<p>*** update_type() : ".mysql_error ()."</p>";
      return false;
    }

    echo clean_for_display ($GLOBALS['admin_upd_type_updated']);
    return true;
  }

  // try to update a marker.
  function update_marker ($_POST) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** update_marker() : ".mysql_error ()."</p>";
      return false;
    }

    // create short variable names.
    $marker_id    = clean ($_POST['marker_id']);
    $marker_name  = clean ($_POST['marker_name']);
    $marker_type  = clean ($_POST['marker_type']);
    $marker_email = clean ($_POST['marker_email']);
    $marker_url   = clean ($_POST['marker_url']);
    $marker_addr  = clean ($_POST['marker_addr']);
    $marker_lat   = clean ($_POST['marker_lat']);
    $marker_lng   = clean ($_POST['marker_lng']);
    $marker_phone = clean ($_POST['marker_phone']);
    $marker_text  = pretty ($_POST['marker_text']);

    // if any of the necessary fields is empty.
    if ((!isset ($marker_id)   || empty ($marker_id))   ||
        (!isset ($marker_type) || empty ($marker_type)) ||
        (!isset ($marker_addr) || empty ($marker_addr)) ||
        (!isset ($marker_lat)  || empty ($marker_lat))  ||
        (!isset ($marker_lng)  || empty ($marker_lng))) {
      echo clean_for_display ($GLOBALS['fill_fields_form']);
      echo "<p>".clean_for_display ($GLOBALS['fill_repeat_form'])."</p>";
      return false;
    }

    // BEGIN a db transaction.
    mysql_query ("BEGIN");

    // create a sql query for updating the marker.
    $query = "UPDATE markers SET name = '$marker_name', address = '$marker_addr', lat = '$marker_lat', lng = '$marker_lng', type = '$marker_type' WHERE id = '$marker_id'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_update_error']);
      echo "<p>*** update_marker() : ".mysql_error ()."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }
    else {
      // create a sql query for updating marker's content.
      $query = "UPDATE contents SET email = '$marker_email', url = '$marker_url', phone = '$marker_phone', text = '$marker_text' WHERE marker = '$marker_id'";

      // execute and check the result of the query.
      $result = @mysql_query ($query);
      if (!$result) {
        echo clean_for_display ($GLOBALS['sql_database_update_error']);
        echo "<p>*** update_marker() : ".mysql_error ()."</p>";

        // ROLLBACK the db transaction.
        mysql_query ("ROLLBACK");
        return false;
      }
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    // the marker is updated.
    echo clean_for_display ($GLOBALS['admin_upd_marker_updated']);
    return true;
  }
  
  // try to fetch the markers' data.
  function get_markers_data () {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** get_markers_data() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for getting markers' data.
    $query = "SELECT m.*,
                     t.name as type
                FROM markers as m
          INNER JOIN types as t ON m.type = t.id
            ORDER BY t.name, m.name";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** get_markers_data() : ".mysql_error ()."</p>";
      return false;
    }

    // check that at least one marker exists.
    $num = @mysql_num_rows ($result);
    if (!$num) {
      echo "*** get_markers_data() : ".clean_for_display ($GLOBALS['sql_database_empty_error']);
      return false;
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // return the result.
    return $result;
  }

  // try to display markers.
  function display_markers ($markers) {
    // if there are no markers.
    if (!is_array ($markers)) {
      echo "*** display_markers() : ".clean_for_display ($GLOBALS['there_are_no_markers']);
      return false;
    }

    $del_target = $show_target = "main_column";
    $del_text   = "[ <b>x</b> ]";
    $old_type = $value = '';

    echo '<table style="background-color: #b9e8f0;" cellpadding="5" cellspacing="0" border="1">';
    echo ' <tbody style="font-weight: bold;">';
    echo '  <tr>';
    echo '   <td align="center">'.clean_for_display ($GLOBALS['increasing_number']).'</td><td>'.clean_for_display ($GLOBALS['admin_man_marker_list_name']).'</td><td align="center">X</td>';
    echo '  </tr>';

    // create each url link for each type.
    foreach ($markers as $row) {
      // print table html tags.
      if (clean_for_display ($row['type']) != $old_type) {
        $value .= '  <tr>';
        $value .= '   <td style="padding: 10px;" class="nowrap" valign="middle" align="center" colspan="3">- '.clean_for_display ($row['type']).' -</td>';
        $value .= '  </tr>';

        $i = '';
      }

      $old_type = clean_for_display ($row['type']);
      
      // update link.
      $show_url   = FILE_UPD_MARKER_FORM.'?mid='.clean_for_display ($row['id']);
      $show_title = clean_for_display ($row['address']);
      $show_text  = clean_for_display ($row['name']); 

      // remove link.
      $del_url = FILE_DEL_MARKER_PROC.'?mid='.clean_for_display ($row['id']);

      $value .= ' <tr>';
      $value .= '  <td align="center" width="40">'. ++$i.'</td>';
      $value .= '  <td class="nowrap">'.do_html_url ($show_url, $show_text, $show_title, $show_target).'</td>';
      $value .= '  <td align="center" class="nowrap">'.do_html_url ($del_url, $del_text, '', $del_target, 'onclick="return confirm ('."'".clean_for_display ($GLOBALS['deletion_yes_no'])."'".');"').'</td>';
      $value .= ' </tr>';
    }

    $value .= ' </tbody>';
    $value .= '</table>';

    return $value;
  }

  // try to delete a marker.
  function delete_marker ($mid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** delete_marker() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for checking the existence of the marker id.
    $query = "SELECT id FROM markers WHERE id = '$mid'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** delete_marker() : ".mysql_error ()."</p>";
      return false;
    }

    // check for a marker with the given id.
    $num = @mysql_num_rows ($result);
    if (!$num) {
      echo clean_for_display ($GLOBALS['admin_del_marker_missing']);
      return false;
    }

    // BEGIN a db transaction.
    mysql_query ("BEGIN");

    // create a sql query for deleting any content of the marker.
    $query = "DELETE FROM contents WHERE marker = '$mid'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_delete_error']);
      echo "<p>*** delete_marker() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for deleting the marker.
    $query = "DELETE FROM markers WHERE id = '$mid'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_delete_error']);
      echo "<p>*** delete_marker() : ".mysql_error ()."</p>";

      // ROLLBACK the db transaction.
      mysql_query ("ROLLBACK");
      return false;
    }

    // COMMIT the db transaction.
    mysql_query ("COMMIT");

    echo clean_for_display ($GLOBALS['admin_del_marker_deleted']);
    return true;
  }
?>
