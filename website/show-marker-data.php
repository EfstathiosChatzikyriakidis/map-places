<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // check for the existence of a HTTP marker id.
  if (isset ($_GET['mid']) && !empty ($_GET['mid'])) {
    // get the HTTP marker id.
    $mid = clean ($_GET['mid']);

    // try to get the marker's data.
    $mdata = get_marker_data ($mid);
    
    // if there was an error while getting marker's data.
    if (!$mdata) die ();
  }
  else
    die (clean_for_display ($security_file_insuff_params_error));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<!--
  Copyright (C) 2010  Efstathios Chatzikyriakidis (stathis.chatzikyriakidis@gmail.com)
  Copyright (C) 2010  Stefanos Tzagias            (steftzag@gmail.com)

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
    <link rel="stylesheet" type="text/css" href="<?php echo DIR_CSS.'/'.FILE_CSS_MAIN; ?>">
  </head>

  <body>
    <table cellpadding="10" cellspacing="0" border="0" class="hundred">
      <tbody>
        <tr>
          <td>
            <table cellspacing="5" cellpadding="0" border="0" class="hundred">
              <tbody valign="top">
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_name); ?></td>
                  <td style="text-align: justify;" class="width_hundred"><b><?php echo clean_for_display ($mdata['name']); ?></b>.</td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_address); ?></td>
                  <td style="text-align: justify;"><b><?php echo clean_for_display ($mdata['address']); ?></b>.</td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_lat); ?></td>
                  <td><?php echo clean_for_display ($mdata['lat']); ?>.</td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_lng); ?></td>
                  <td><?php echo clean_for_display ($mdata['lng']); ?>.</td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_phone); ?></td>
                  <td><?php echo clean_for_display ($mdata['phone']); ?>.</td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_type); ?></td>
                  <td style="text-align: justify;"><?php echo clean_for_display ($mdata['type']); ?>.</td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_email); ?></td>
                  <td style="text-align: justify;"><b><a href="mailto:<?php echo clean_for_display ($mdata['email']); ?>"><?php echo clean_for_display ($mdata['email']); ?></a></b></td>
                </tr>
                <tr>
                  <td align="right"><?php echo clean_for_display ($marker_url); ?></td>
                  <td style="text-align: justify;"><b><a href="http://<?php echo clean_for_display ($mdata['url']); ?>" target="_blank"><?php echo clean_for_display ($mdata['url']); ?></a></b></td>
                </tr>
                <tr>
                  <td colspan="2"><?php echo space (1, 1); ?></td>
                </tr>
                <tr>
                  <td class="height_hundred" colspan="2" style="text-align: justify;">
                    <p><?php echo clean_for_display ($marker_text); ?></p>
                    <?php echo pretty_for_display ($mdata['text']); ?>
                  </td>
                </tr>
                <tr>
                  <td colspan="2"><?php echo space (1, 5); ?></td>
                </tr>
                <tr>
                  <td colspan="2"><b><a href="#top"><?php echo clean_for_display ($general_toplink); ?></a></b></td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
  </body>
</html>
