<?php

  // main module which includes core subsystems.

  /*
   *  Copyright (C) 2010  Efstathios Chatzikyriakidis (contact@efxa.org)
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

  // send HTTP instructions to browsers to ensure no-caching.
  header ("Cache-Control: no-store, no-cache, must-revalidate"); // HTTP/1.1
  header ("Cache-Control: post-check=0, pre-check=0", false);
  header ("Cache-Control: private");
  header ("Pragma: no-cache"); // HTTP/1.0
   
  // set error reporting to debugging mode.
  error_reporting (E_ALL & ~E_DEPRECATED);

  // include filenames alternatives.
  require_once ("filenames.php");

  // include core subsystems.
  require_once (FILE_CONFIGURATION);
  require_once (FILE_WEB_MESSAGES);
  require_once (FILE_DATABASE_FNS);
  require_once (FILE_DATA_VALID_FNS);
  require_once (FILE_OUTPUT_FNS);
  require_once (FILE_GET_TYPES_FNS);
  require_once (FILE_GET_MARKER_FNS);
  require_once (FILE_GET_TYPE_FNS);
?>
