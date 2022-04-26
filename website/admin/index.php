<?php
  // include main module.
  require_once ("vs-cms-fns.php");
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

    <link rel="icon" type="image/png" href="<?php echo '../'.DIR_GRAPHICS.'/'.FILE_FAVICON; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo '../'.DIR_CSS.'/'.FILE_CSS_INDEX; ?>">
  </head>

  <body>

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
          <td id="admin_box">
            <iframe class="hundred" src="<?php echo FILE_WELCOME; ?>" name="main_column" frameborder="0"></iframe>
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
                                  <td align="center"><img src="<?php echo '../'.DIR_GRAPHICS."/logo-image-1.png"; ?>" vspace="10" width="40" alt=""></td>
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
                    <table cellpadding="20" cellspacing="0" border="0" class="hundred">
                      <tbody>
                        <tr>
                          <td>
                            <table cellpadding="0" cellspacing="0" border="0" class="hundred">
                              <tbody valign="top">
                                <tr>
                                  <td align="center" class="nowrap" height="1">
                                    <strong>[ <?php echo clean_for_display ($admin_manage_text); ?> ]</strong>
                                  </td>
                                </tr>
                                <tr>
                                  <td height="1"><?php echo space (1, 16); ?></td>
                                </tr>
                                <tr>
                                  <td class="nowrap">
                                    <strong>
                                      - <a href="<?php echo DIR_TYPE_MARKER.'/'.FILE_ADD_TYPE_MARKER; ?>" target="main_column"><?php echo clean_for_display ($admin_op_add_type_marker); ?></a><br>
                                      - <a href="<?php echo DIR_TYPE_MARKER.'/'.FILE_MAN_TYPE_MARKER; ?>" target="main_column"><?php echo clean_for_display ($admin_op_man_type_marker); ?></a><br>
                                    </strong>
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
                          <td><a href="http://validator.w3.org/check/referer" target="_blank"><img src="<?php echo '../'.DIR_GRAPHICS."/html-valid.png"; ?>" alt=""></a></td>
                          <td width="1"><?php echo space (10, 1); ?></td>
                          <td><a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3" target="_blank"><img src="<?php echo '../'.DIR_GRAPHICS."/css-valid.png"; ?>" alt=""></a></td>
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
