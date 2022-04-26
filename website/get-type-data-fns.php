<?php

  // define fetching functions for types' data.

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

  // try to fetch the data of a type.
  function get_type_data ($tid) {
    // try to connect to mysql account.
    if (!db_connect ()) {
      echo clean_for_display ($GLOBALS['sql_database_connect_error']);
      echo "<p>*** get_type_data() : ".mysql_error ()."</p>";
      return false;
    }

    // create a sql query for getting type's data.
    $query = "SELECT * FROM types WHERE id = '".clean ($tid)."'";

    // execute and check the result of the query.
    $result = @mysql_query ($query);
    if (!$result) {
      echo clean_for_display ($GLOBALS['sql_database_select_error']);
      echo "<p>*** get_type_data() : ".mysql_error ()."</p>";
      return false;
    }

    // check that at least one type exists.
    $num = @mysql_num_rows ($result);
    if (!$num) {
      echo "*** get_type_data() : ".clean_for_display ($GLOBALS['sql_database_empty_error']);
      return false;
    }

    // get query result as an array.
    $result = @mysql_fetch_array ($result);

    // return the result.
    return $result;
  }
?>
