<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // start install process if configuration file is empty.
  if (filesize (FILE_CONFIGURATION) == 0)
    header ("Location: ".DIR_ADMIN.'/'.FILE_INSTALL_FORM);

  // init the selected type to none.
  $selected_type = "";

  // check for the existence of a HTTP type id.
  if (isset ($_POST['type_selection']))
    // get the HTTP type id.
    $selected_type = clean ($_POST['type_selection']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<!--
  Copyright (C) 2010  Efstathios Chatzikyriakidis (contact@efxa.org)
  Copyright (C) 2010  Stefanos Tzagias           (steftzag@gmail.com)

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program. If not, see <http://www.gnu.org/licenses/>.
-->

<html>
  <head>
    <title><?php echo clean_for_display ($html_window_title); ?></title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?php echo clean_for_display ($html_meta_keywords); ?>">
    <meta name="description" content="<?php echo clean_for_display ($html_meta_descript); ?>">

    <link rel="icon" type="image/png" href="<?php echo DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo DIR_CSS.'/'.FILE_CSS_INDEX; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_COMPONENTS."/highslide/highslide.css"; ?>">

    <script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;hl=<?php echo CONF_GAPI_LNG; ?>&amp;key=<?php echo CONF_GAPI_KEY; ?>"></script>
    <script type="text/javascript" src="<?php echo DIR_JS."/marker-clusterer.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo DIR_JS."/key-drag-zoom.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo DIR_JS."/map-icon-maker.js"; ?>"></script>
    <script type="text/javascript" src="<?php echo DIR_COMPONENTS."/highslide/highslide-with-html.js"; ?>"></script>

    <script type="text/javascript">
      //<![CDATA[
      var loading_map_app    = "<b>" + "<?php echo clean_for_display ($gmap_loading_map); ?>"  + "<\/b><br><br>" + "<?php echo clean_for_display ($gmap_please_wait); ?>";
      var download_map_data  = "<b>" + "<?php echo clean_for_display ($gmap_download_map); ?>" + "<\/b><br><br>" + "<?php echo clean_for_display ($gmap_please_wait); ?>";
      var loading_map_places = "<b>" + "<?php echo clean_for_display ($gmap_load_places); ?>"  + "<\/b><br><br>";

      var map = null;
      var markerClusterer = null;
      var geocoder = null;
      var markers = [];

      var timeOuta = 10;
      var timeOutb = 10;
      var ii = 0;

      var iconOptions = {};

      iconOptions.width = 25;
      iconOptions.height = 25;
      iconOptions.primaryColor = "#ff0000";
      iconOptions.labelSize = 12;
      iconOptions.labelColor = "#000000";
      iconOptions.shape = "circle";
      
      function ContextMenu(oMap) {
        this.init_context_menu_(oMap);
      }

      ContextMenu.prototype.init_context_menu_ = function(oMap) {
        this.map_ = oMap;
        var that_ = this;

        this.contextmenu_ = document.createElement("div");
        this.contextmenu_.style.display = "none";
        this.contextmenu_.className = "contextmenu";

        this.ul_container_ = document.createElement("ul");
        this.ul_container_.id = "context_menu_ul";

        this.contextmenu_.appendChild(this.ul_container_);  
        this.initLink_();

        this.map_.getContainer().appendChild(this.contextmenu_);

        GEvent.addListener(oMap, "singlerightclick", function(pixel) {
          that_.clickedPixel_ = pixel;

          var x_ = pixel.x;
          var y_ = pixel.y;

          if (x_ > that_.map_.getSize().width - 115) { x_ = that_.map_.getSize().width - 115 }
          if (y_ >that_.map_.getSize().height - 120) { y_ = that_.map_.getSize().height - 120 }

          var pos_ = new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(x_, y_));
          pos_.apply(that_.contextmenu_);
          that_.contextmenu_.style.display = "";
        });

        GEvent.addListener(oMap, "move", function() {
          that_.contextmenu_.style.display = "none";
        });

        GEvent.addListener(oMap, "mouseout", function() {
          that_.contextmenu_.style.display = "none";
        });

        GEvent.addListener(oMap, "click", function() {
          that_.contextmenu_.style.display = "none";
        });
      }

      ContextMenu.prototype.initLink_ = function(oMap) {
        var that_ = this;

        a_link_ = document.createElement("li");
        a_link_.innerHTML = "<a href='javascript: void(0);'>" + "<?php echo clean_for_display ($gmap_rmenu_zoomi); ?>" + "<\/a>";
        GEvent.addDomListener(a_link_, 'click', function() {
          that_.map_.zoomIn();
          that_.contextmenu_.style.display = 'none';
        });
        this.ul_container_.appendChild(a_link_);

        a_link_ = document.createElement("li");
        a_link_.innerHTML = "<a href='javascript: void(0);'>" + "<?php echo clean_for_display ($gmap_rmenu_zoomo); ?>" + "<\/a>";
        GEvent.addDomListener(a_link_, 'click', function() {
          that_.map_.zoomOut();
          that_.contextmenu_.style.display = 'none';
        });
        this.ul_container_.appendChild(a_link_);

        a_link_ = document.createElement("li");
        a_link_.innerHTML = "<a href='javascript: void(0);'>" + "<?php echo clean_for_display ($gmap_rmenu_zoomh); ?>" + "<\/a>";
        GEvent.addDomListener(a_link_, 'click', function() {
          var point = that_.map_.fromContainerPixelToLatLng(that_.clickedPixel_);
          that_.map_.zoomIn(point, true);
          that_.contextmenu_.style.display = "none";
        });
        this.ul_container_.appendChild(a_link_);

        a_link_ = document.createElement("li");
        a_link_.innerHTML = "<a href='javascript: void(0);'>" + "<?php echo clean_for_display ($gmap_rmenu_center); ?>" + "<\/a>";
        GEvent.addDomListener(a_link_, 'click', function() {
          var point = that_.map_.fromContainerPixelToLatLng(that_.clickedPixel_);
          that_.map_.panTo(point);
          that_.contextmenu_.style.display = "none";
        });
        this.ul_container_.appendChild(a_link_);  
      }

      GMap2.prototype.hoverControls = function() {
        var theMap_ = this;
        theMap_.showControls();
  
        GEvent.addListener(theMap_, "mouseover", function() {
          theMap_.showControls();
        });

        GEvent.addListener(theMap_, "mouseout", function() {
          theMap_.hideControls();
        });
      }

      GMap.prototype.hoverControls = GMap2.prototype.hoverControls;

      function refreshMap() {
        if (markerClusterer != null) {
          markerClusterer.clearMarkers();
        }

        markerClusterer = new MarkerClusterer(map, markers, {gridSize: 50});
      }

      function element_visibility(id, visibility) {
        document.getElementById(id).style.visibility = visibility;
      }

      function set_element(id, html) {
        document.getElementById(id).innerHTML = html;
      }

      function createMarker(mid, point, name, address, letter) {
        var header_ = '<div class="map_info_box"><table class="hundred"><tr><td><table cellspacing="5" align="center"><tbody valign="top">';
        var footer_ = '<\/tbody><\/table><\/td><\/tr><\/table><\/div>';

        var data_ = '<tr><td colspan="2" align="center"><strong>&middot; ' + '<?php echo clean_for_display ($gmap_short_info); ?>' + ' &middot;<\/strong><\/td><\/tr>';

        data_ += '<tr><td colspan="2">&nbsp;<\/tr>';
        data_ += '<tr><td align="right">' + '<?php echo clean_for_display ($marker_name); ?>' + '<\/td><td style="text-align: justify;"><b>' + name + '<\/b>.<\/td><\/tr>' +
                 '<tr><td align="right">' + '<?php echo clean_for_display ($marker_address); ?>' + '<\/td><td style="text-align: justify;"><b>' + address + '<\/b>.<\/td><\/tr>';
        data_ += '<tr><td colspan="2">&nbsp;<\/tr>';

        data_ += '<tr><td colspan="2" align="center">[ <u><a href="' + '<?php echo FILE_SHOW_MARKER; ?>' + '?mid='+mid+'" onclick="return hs.htmlExpand(this, { objectType: \'iframe\', headingText: \'' + '<?php echo clean_for_display ($gmap_full_info); ?>'  + '\' } )">' + '<?php echo clean_for_display ($gmap_more_info); ?>' + '<\/a><\/u> ]<\/td><\/tr>';

        var marker_ = new GMarker(point, {title: name, icon: customIcons[letter]});

        GEvent.addListener(marker_, "click", function() {
          marker_.openInfoWindowHtml(header_ + data_ + footer_);
        });

        return marker_;
      }

      function showAddress(address) {
        if (geocoder)
          geocoder.getLatLng(address, function (point) {
                                        if (point) {
                                          map.setCenter (point, 15);
                                          var marker = new GMarker (point);
                                          map.addOverlay (marker);
                                        }
                                      });
      }

      function init_google_map(typeid) {
        element_visibility("alert_box", "visible");

        if (GBrowserIsCompatible()) {
          set_element("alert_msg", loading_map_app);

          map = new GMap2(document.getElementById('map_canvas'));

          map.setCenter(new GLatLng(40.668178, 22.911115), 2);
          map.setUIToDefault();
          map.enableContinuousZoom();
          map.hoverControls();
          map.enableRotation();
          map.getPane(G_MAP_FLOAT_SHADOW_PANE).style.display = "none";

          G_PHYSICAL_MAP.getMinimumResolution = function () { return 2 };
          G_NORMAL_MAP.getMinimumResolution = function () { return 2 };
          G_SATELLITE_MAP.getMinimumResolution = function () { return 2 };
          G_HYBRID_MAP.getMinimumResolution = function () { return 2 };

          geocoder = new GClientGeocoder();

          var context_menu = new ContextMenu(map);

          map.enableKeyDragZoom({
            key: "shift",
            boxStyle: {border: "1px dashed #000000", backgroundColor: "#ffffff", opacity: 0.5},
            paneStyle: {backgroundColor: "#000000", opacity: 0.1}
          });

          set_element("alert_msg", download_map_data);

          GDownloadUrl("<?php echo FILE_XML_GEN_MARKS; ?>?tid="+typeid, function(data) {
            var xml = GXml.parse(data);
            ms = xml.documentElement.getElementsByTagName("marker");
            window.setTimeout(startmap, timeOutb);
          });
        }
        else {
          set_element("alert_msg", "<?php echo clean_for_display ($gmap_browser_err); ?>");
        }
      }

      function startmap() {
        if (ii < ms.length) {
          var keep = Math.min(ii + 1, ms.length);

          while (ii < keep) {
            var mid = ms[ii].getAttribute("mid");
            var name = ms[ii].getAttribute("name");
            var address = ms[ii].getAttribute("address");
            var letter = ms[ii].getAttribute("letter");
            var point = new GLatLng(parseFloat(ms[ii].getAttribute("lat")),
                                    parseFloat(ms[ii].getAttribute("lng")));

            var marker = createMarker(mid, point, name, address, letter);

            markers.push(marker);
            ii++;
          }

          set_element("alert_msg", loading_map_places + "[ " + ii + " / " + ms.length + " ]");
          window.setTimeout(startmap, timeOuta);
        }
        else {
          map.setMapType(G_NORMAL_MAP);
          refreshMap();
          element_visibility("alert_box", "hidden");
          ii = 0;
        }
      }

      function maximize() {
        window.moveTo(0, 0);
        window.resizeTo(screen.availWidth, screen.availHeight);
      }

<?php
  // fetch the markers' types.
  $types = get_markers_types ();

  // create associative array with types' letters as keys.
  $letters = array();
  foreach ($types as $type)
    $letters[$type['letter']] = NULL;

  // display javascript associative array according to the php given.
  echo js_associative_array ($letters, "customIcons");
?>

      // create the map icons (for each type) of the markers.  
      for (var letter in customIcons) {
        iconOptions.label = letter;
        customIcons[letter] = MapIconMaker.createFlatIcon (iconOptions);
      }

      hs.graphicsDir = '<?php echo DIR_COMPONENTS."/highslide/graphics/"; ?>';
      hs.outlineType = 'rounded-white';
      hs.wrapperClassName = 'draggable-header no-footer';
      hs.showCredits = false;
      hs.fadeInOut = true;
      hs.align = 'center';
      hs.width = 500;
      hs.height = 300;
      hs.loadingText = '<?php echo clean_for_display ($highslide_loading); ?>';
      hs.allowMultipleInstances = false;
      hs.dragByHeading = false;
      //]]>
    </script>
  </head>

  <body onload="maximize (); init_google_map (<?php echo "'".$selected_type."'"; ?>);" onunload="GUnload ();">

    <div id="upper_left"></div>
    <div id="upper_right"></div>
    <div id="lower_left"></div>
    <div id="lower_right"></div>

    <table cellpadding="0" cellspacing="30" border="0" class="hundred">
      <tbody>
        <tr>
          <td class="side_box" colspan="2">
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td style="padding: 8px;" class="nowrap">
                    <b><?php echo clean_for_display ($package_message); ?></b>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td id="map_box">
            <div id="alert_box">
              <div id="alert_msg"></div>
            </div>
            <div id="map_canvas"></div>
          </td>
          <td>
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td class="side_box" height="1">
                    <table cellpadding="20" cellspacing="0" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td align="center">
                            <table cellpadding="0" cellspacing="0" border="0">
                              <tbody>
                                <tr>
                                  <td style="padding-right: 40px;" class="nowrap"><b><?php echo clean_for_display ($package_thename); ?></b></td>
                                </tr>
                                <tr>
                                  <td align="center"><img src="<?php echo DIR_GRAPHICS."/logo-image-1.png"; ?>" vspace="10" width="40" alt=""></td>
                                </tr>
                                <tr>
                                  <td style="padding-left: 40px;" class="nowrap"><b><?php echo clean_for_display ($package_version); ?></b></td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td height="1"><?php echo space (1, 30); ?></td>
                </tr>
                <tr>
                  <td class="side_box">
                    <table cellpadding="0" cellspacing="20" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td height="1">
                            <p><b>[ <?php echo clean_for_display ($select_type_header_title); ?> ]</b></p>
                            <form method="post" id="select_type_form" action="<?php echo FILE_INDEX; ?>">
                              <?php echo select_type ($selected_type, "type_selection", 'width: 140px;', false, 'onchange="this.form.submit ();"'); ?>
                            </form>
                          </td>
                        </tr>
                        <tr>
                          <td height="1">
                            <p><b>[ <?php echo clean_for_display ($search_address_header_title); ?> ]</b></p>
                            <form action="#" name="search_form" onsubmit="showAddress(document.search_form.search_address.value); return false;">
                              <table cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                  <tr>
                                    <td><?php echo input_text ('search_address', 'width: 138px;'); ?></td>
                                    <td><?php echo space (10, 1); ?></td>
                                    <td><?php echo input_button ('image', 'submit', DIR_GRAPHICS."/submit.png", 'border: 0px; width: 20px; height: 20px; background-color: transparent;'); ?></td>
                                  </tr>
                                </tbody>
                              </table>
                            </form>
                          </td>
                        </tr>
                        <tr>
                          <td class="nowrap" align="center" valign="bottom">
                            <strong>[ <a href="<?php echo DIR_ADMIN; ?>/" target="_blank"><?php echo clean_for_display ($admin_manage_text); ?></a> ]</strong>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="side_box">
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td style="padding: 8px;" class="nowrap">
                    <b><?php echo clean_for_display ($package_license); ?></b>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
          <td class="side_box">
            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
              <tbody>
                <tr>
                  <td style="padding: 8px;" align="center">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tbody>
                        <tr>
                          <td><a href="http://validator.w3.org/check/referer" target="_blank"><img src="<?php echo DIR_GRAPHICS."/html-valid.png"; ?>" alt=""></a></td>
                          <td width="1"><?php echo space (10, 1); ?></td>
                          <td><a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" target="_blank"><img src="<?php echo DIR_GRAPHICS."/css-valid.png"; ?>" alt=""></a></td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
