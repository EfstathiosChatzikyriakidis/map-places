<?php

  // define altenative constants for filenames.

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

  // directories.

  // shared directories.
  
  // stylesheets directory.
  define ('DIR_CSS', 'stylesheets');

  // components directory.
  define ('DIR_COMPONENTS', 'components');

  // graphics directory.
  define ('DIR_GRAPHICS', 'graphics');

  // javascripts directory.
  define ('DIR_JS', 'javascripts');

  // admin directories.

  // control panel.
  define ('DIR_ADMIN', 'admin');

  // types, markers.
  define ('DIR_TYPE_MARKER', 'type-marker');
  
  // files.

  // normal files.
  
  // core subsystems.
  define ('FILE_DATA_VALID_FNS'  , 'data-valid-fns.php');
  define ('FILE_DATABASE_FNS'    , 'db-fns.php');
  define ('FILE_OUTPUT_FNS'      , 'output-fns.php');
  define ('FILE_GET_TYPES_FNS'   , 'get-marker-types-fns.php');
  define ('FILE_GET_MARKER_FNS'  , 'get-marker-data-fns.php');
  define ('FILE_GET_TYPE_FNS'    , 'get-type-data-fns.php');
  define ('FILE_XML_GEN_MARKS'   , 'generate-markers-xml.php');
  define ('FILE_WEB_MESSAGES'    , 'web-messages.php');
  define ('FILE_CONFIGURATION'   , 'configuration.php');
  define ('FILE_SHOW_MARKER'     , 'show-marker-data.php');

  // shared files.
  
  // css stylesheets.
  define ('FILE_CSS_INDEX' , 'index-stylesheet.css');
  define ('FILE_CSS_MAIN'  , 'main-stylesheet.css');
  
  // index page.
  define ('FILE_INDEX', 'index.php');

  // welcome page.
  define ('FILE_WELCOME' , 'welcome-page.php');
  
  // favicon image.
  define ('FILE_FAVICON', 'favicon.png');
  
  // admin files.

  // types, markers.
  define ('FILE_ADD_TYPE_MARKER' , 'add-type-marker.php');
  define ('FILE_MAN_TYPE_MARKER' , 'man-type-marker.php');

  define ('FILE_ADD_MARKER_FORM' , 'add-marker-form.php');
  define ('FILE_ADD_MARKER_PROC' , 'add-marker-proc.php');

  define ('FILE_ADD_TYPE_FORM' , 'add-type-form.php');
  define ('FILE_ADD_TYPE_PROC' , 'add-type-proc.php');

  define ('FILE_UPD_MARKER_FORM' , 'upd-marker-form.php');
  define ('FILE_UPD_MARKER_PROC' , 'upd-marker-proc.php');
  
  define ('FILE_UPD_TYPE_FORM' , 'upd-type-form.php');
  define ('FILE_UPD_TYPE_PROC' , 'upd-type-proc.php');

  define ('FILE_DEL_MARKER_PROC' , 'del-marker-proc.php');
  define ('FILE_DEL_TYPE_PROC'   , 'del-type-proc.php');

  define ('FILE_MAN_MARKER_LIST' , 'man-marker-list.php');
  define ('FILE_MAN_TYPE_LIST'   , 'man-type-list.php');

  // installation.
  define ('FILE_INSTALL_FORM' , 'installation.php');

  // administration functions.
  define ('FILE_ADMIN_FNS' , 'admin-fns.php');
?>
