<?php

  // define XML document generation functions for markers' data.

  // include core subsystems.
  require_once ("vs-cms-fns.php");

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

  // try to generate a XML document with markers' data.
  function generate_xml_markers () {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      die("<p>*** generate_xml_markers() : ".mysql_error ()."</p>");
    }

    // start a XML document, create parent node.
    $dom = new DOMDocument ("1.0", "UTF-8");
    $node = $dom->createElement ("markers");
    $parnode = $dom->appendChild ($node); 

    // create a sql query for getting markers' data.
    $markers_query = "SELECT m.*, t.letter
                        FROM markers as m
                  INNER JOIN types as t ON m.type = t.id";

    // check for the existence of a HTTP type id.
    if (isset ($_GET['tid']) && !empty ($_GET['tid'])) {
      // get the HTTP type id.
      $type = clean ($_GET['tid']);

      // create a sql query for checking the existence of the type id.
      $query = "SELECT type FROM markers WHERE type = '$type'";

      // execute and check the result of the query.
      $result = @mysql_query ($query);
      if (!$result) {
        echo clean_for_display ($GLOBALS['sql_database_select_error']);
        die("<p>*** generate_xml_markers() : ".mysql_error ()."</p>");
      }

      // check for at least one marker with the given type id.
      $num = @mysql_num_rows ($result);
      if ($num)
        // change the sql query for getting specific markers.
        $markers_query = "SELECT m.*, t.letter
                            FROM markers as m
                      INNER JOIN types as t ON m.type = t.id
                           WHERE m.type = '$type'";
    }

    // execute and check the result of the query.
    $result = @mysql_query ($markers_query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      die("<p>*** generate_xml_markers() : ".mysql_error ()."</p>");
    }

    // get query result as an array.
    $result = db_result_to_array ($result);

    // iterate through the rows, adding XML nodes for each row.
    foreach ($result as $row) {
      // create and add to the XML document a new node.
      $node = $dom->createElement ("marker");  
      $newnode = $parnode->appendChild ($node);   

      // add attributes to the new node.
      $newnode->setAttribute ("mid"     , clean_for_display ($row['id']));
      $newnode->setAttribute ("name"    , clean_for_display ($row['name']));
      $newnode->setAttribute ("address" , clean_for_display ($row['address']));
      $newnode->setAttribute ("lat"     , clean_for_display ($row['lat']));
      $newnode->setAttribute ("lng"     , clean_for_display ($row['lng']));
      $newnode->setAttribute ("letter"  , clean_for_display ($row['letter']));
    }

    // save and return the XML document.
    return $dom->saveXML ();
  }

  // generate a XML document with markers' data.
  $xml_document = generate_xml_markers ();

  // send to the browser the type of the following data.
  header("Content-type: text/xml"); 

  // send to the browser the XML document.
  echo $xml_document;
?>
