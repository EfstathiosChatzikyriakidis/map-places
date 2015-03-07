<?php

  // define web text messages.

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

  // shared messages.

  // package messages.
  $package_thename = "Map Places";
  $package_version = "Version 1.0";
  $package_message = "Earth Exploring Via Web-Based Geographical Information System!";
  $package_license = "This project is licensed under the GNU General Public License Version 3.";

  // html document head messages.
  $html_window_title  = $package_thename." - ".$package_version;
  $html_meta_descript = $package_message;
  $html_meta_keywords = "map, places, google, gis";

  // sql error messages.
  $sql_database_connect_error = "An error occurred while the application tried to connect to the database.";
  $sql_database_select_error  = "An error occurred while the application tried to execute select query.";
  $sql_database_use_error     = "An error occurred while the application tried to execute use query.";
  $sql_database_insert_error  = "An error occurred while the application tried to execute insert query.";
  $sql_database_update_error  = "An error occurred while the application tried to execute update query.";
  $sql_database_delete_error  = "An error occurred while the application tried to execute delete query.";
  $sql_database_drop_error    = "An error occurred while the application tried to execute drop query.";
  $sql_database_create_error  = "An error occurred while the application tried to execute create query.";
  $sql_database_empty_error   = "The SQL query has returned an empty data set.";

  // security messages.
  $security_file_insuff_params_error = "An error occurred while the file called with insufficient parameters.";
  $security_func_insuff_params_error = "An error occurred while the function called with insufficient parameters.";

  // admin panel message.
  $admin_manage_text = "Administration";

  // general messages.
  $navigate_goto_text   = "Go to :";
  $navigage_goto_home   = "Home Page";
  $navigate_back_text   = "Back";
  $navigate_list_text   = "List";

  $fill_all_form_data   = "Please fill all the fields of the form.";
  $fill_fields_form     = "Please fill the necessary fields of the form.";
  $fill_repeat_form     = "Try again.";

  $there_are_no_types   = "There are no categories.";
  $there_are_no_markers = "There are no places.";
  $the_type_exists      = "The category already exists.";

  $increasing_number    = "A/A";
  $general_toplink      = "^ Top";
  $deletion_yes_no      = "Do you want to delete the item?";

  // google map messages.
  $gmap_error_place  = "Not correct place!";
  $gmap_browser_err  = "Sorry, the Google Maps API is not compatible with this browser.";
  $gmap_rmenu_center = "Center Here";
  $gmap_rmenu_zoomh  = "Zoom Here";
  $gmap_rmenu_zoomi  = "Zoom In";
  $gmap_rmenu_zoomo  = "Zoom Out";
  $gmap_short_info   = "Place Short Information";
  $gmap_more_info    = "More Details";
  $gmap_full_info    = "Place Full Information";
  $gmap_please_wait  = "Please Wait...";
  $gmap_loading_map  = "Loading Map Application";
  $gmap_download_map = "Downloading Map Data";
  $gmap_load_places  = "Loading Map Places";

  // normal messages.

  // select type box messages.
  $select_type_header_title         = "Select Category";
  $select_type_guest_default_option = "Show Everything";
  $select_type_admin_default_option = "Select Category";

  // search address messages.
  $search_address_header_title = "Search Place";

  // marker messages.
  $marker_name    = "Name:";
  $marker_address = "Address:";
  $marker_lat     = "Latitude:";
  $marker_lng     = "Longitude:";
  $marker_type    = "Category:";
  $marker_phone   = "Phone:";
  $marker_text    = "Text:";
  $marker_email   = "Email:";
  $marker_url     = "URL:";

  // highslide messages.
  $highslide_loading = "Loading";

  // admin messages.

  // installation messages.
  $install_title = "Install ".$package_thename." - ".$package_version;

  $install_hostname = "- DB Hostname";
  $install_username = "- DB Username";
  $install_password = "- DB Password";
  $install_database = "- DB Name";
  $install_gmapikey = "- GMap Key";

  $install_success  = "Installation Completed.";
  $install_failure  = "Installation Failed.";

  // menu (sub) operations.
  $admin_op_add_type_marker = "Create categories / places";
  $admin_op_man_type_marker = "Manage categories / places";

  $admin_op_man_type_text   = "Manage categories";
  $admin_op_man_marker_text = "Manage places";

  $admin_op_add_marker_text = "Create a new place";
  $admin_op_add_type_text   = "Create a new category";

  // type/marker management messages.
  $admin_add_marker_form_title   = "Create a new place.";
  $admin_add_marker_form_name    = "- Name";
  $admin_add_marker_form_email   = "- Email";
  $admin_add_marker_form_url     = "- URL";
  $admin_add_marker_form_type    = "- Category";
  $admin_add_marker_form_addr    = "- Address";
  $admin_add_marker_form_lat     = "- Latitude";
  $admin_add_marker_form_lng     = "- Longitude";
  $admin_add_marker_form_phone   = "- Phone";
  $admin_add_marker_form_text    = "- Text";
  $admin_add_marker_form_loc     = "- Location";

  $admin_upd_marker_form_title = "Try to update the place.";
  $admin_upd_marker_form_name    = "- Name";
  $admin_upd_marker_form_email   = "- Email";
  $admin_upd_marker_form_url     = "- URL";
  $admin_upd_marker_form_type    = "- Category";
  $admin_upd_marker_form_addr    = "- Address";
  $admin_upd_marker_form_lat     = "- Latitude";
  $admin_upd_marker_form_lng     = "- Longitude";
  $admin_upd_marker_form_phone   = "- Phone";
  $admin_upd_marker_form_text    = "- Text";
  $admin_upd_marker_form_loc     = "- Location";

  $admin_add_type_form_title   = "Create a new category.";
  $admin_add_type_form_name    = "- Name";
  $admin_add_type_form_symbol  = "- Symbol";

  $admin_upd_type_form_title   = "Try to update the category.";
  $admin_upd_type_form_name    = "- Name";
  $admin_upd_type_form_symbol  = "- Symbol";

  $admin_man_marker_list_title = "Places";
  $admin_man_marker_list_name  = "Name";
  $admin_man_marker_list_type  = "Category";

  $admin_man_type_list_title   = "Categories";
  $admin_man_type_list_name    = "Name";
  $admin_man_type_list_symbol  = "Symbol";

  $admin_upd_type_process = "Trying to update the category.";
  $admin_upd_type_updated = "The category is updated.";

  $admin_add_type_process = "Trying to create a new category.";
  $admin_add_type_created = "The category is created.";

  $admin_upd_marker_process = "Trying to update the place.";
  $admin_upd_marker_updated = "The place is updated.";
  
  $admin_add_marker_process = "Trying to create a new place.";
  $admin_add_marker_created = "The place is created.";

  $admin_del_type_process = "Trying to delete the category.";
  $admin_del_type_contain = "The category contains some places.";
  $admin_del_type_deleted = "The category is deleted.";
  $admin_del_type_missing = "The category does not exist.";

  $admin_del_marker_process = "Trying to delete the place.";
  $admin_del_marker_missing = "The place does not exist.";
  $admin_del_marker_deleted = "The place is deleted.";
?>
