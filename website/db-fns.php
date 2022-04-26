<?php

  // define database functions.

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

  // try to connect to mysql and select db.
  function db_connect () {
    // get mysql connection account information.
    $host = CONF_MYSQL_HOST;
    $user = CONF_MYSQL_USER;
    $pass = CONF_MYSQL_PASS;
    $db   = CONF_MYSQL_DB;
 
    // try to connect to mysql.
    $conn = @mysql_pconnect ($host, $user, $pass); 
    if (!$conn)
      return false;

    // set UTF-8 collation encoding.
    mysql_query ("SET NAMES 'utf8'", $conn);
  
    // try to select database.
    if (! @mysql_select_db ($db))
      return false;

    // return the connection.
    return $conn;
  }

  // try to transform a query result to an array.
  function db_result_to_array ($result) {
    // create an empty array.
    $res_array = array ();

    // fill the array with rows from the query result.
    for ($count = 0;
         $row = @mysql_fetch_array ($result);
         $count++)
      $res_array[$count] = $row;

    // return the array.
    return $res_array;
  }
?>
