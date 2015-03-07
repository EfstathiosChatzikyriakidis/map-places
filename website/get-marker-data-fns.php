<?php

  // define fetching functions for markers' data.

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

  // try to fetch the data of a marker.
  function get_marker_data ($mid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** get_marker_data() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for getting marker's data.
    $query = "SELECT m.*, c.*, t.*,
                     m.name as name,
                     m.type as tid,
                     t.name as type
                FROM markers as m
          INNER JOIN contents as c ON m.id = c.marker
          INNER JOIN types as t ON m.type = t.id
               WHERE c.marker = '".clean ($mid)."'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** get_marker_data() : ".mysql_error ()."</p>";
      return false;
    }

    // check that at least one marker exists.
    $num = @mysql_num_rows ($result);
    if (!$num) {
      echo "*** get_marker_data() : ".clean_for_display ($GLOBALS['sql_database_empty_error']);
      return false;
    }

    // get query result as an array.
    $result = @mysql_fetch_array ($result);

    // return the result.
    return $result;
  }
?>
