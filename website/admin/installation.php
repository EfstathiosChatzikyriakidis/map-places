<?php
  // include main module.
  require_once ("vs-cms-fns.php");

  // get http host address.
  if (!defined ('CONF_HTTP_HOST'))
    define ('CONF_HTTP_HOST', $_SERVER['HTTP_HOST']);
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
    <link rel="stylesheet" type="text/css" href="<?php echo '../'.DIR_CSS.'/'.FILE_CSS_MAIN; ?>">
  </head>

  <body>
    <table cellpadding="30" cellspacing="0" border="0" class="hundred">
      <tbody>
        <tr>
          <td class="side_box" valign="top">
            <table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td style="padding-left: 12px;"><b><?php echo clean_for_display ($install_title); ?></b></td>
                </tr>
                <tr>
                  <td><?php echo space (1, 15); ?></td>
                </tr>
                <?php
                  // init installation configuration variables.
                  $hostname = $username = $password = $database = $gmapikey = "";

                  // error flag for installation process.
                  $error = true;

                  // start installation process if it is necessary.
                  
                  // check for the form normal submission.
                  if (isset ($_POST['submit_check'])) {
                    echo "<tr><td style='padding-left: 12px; font-weight: bold;'>";

                    // get installation configuration variables.
                    $hostname = clean ($_POST["hostname"]);
                    $username = clean ($_POST["username"]);
                    $password = clean ($_POST["password"]);
                    $database = clean ($_POST["database"]);
                    $gmapikey = clean ($_POST["gmapikey"]);

                    // is there any empty field in the form?
                    if (!filled_out ($_POST))
                      echo "<p>".clean_for_display ($fill_all_form_data)."</p>";
                    else {
                      // mysql server connection.
                      $link = @mysql_pconnect ($hostname, $username, $password);
                      if ($link) {
                        // set encoding for mysql connection.
                        mysql_query ("SET NAMES utf8", $link);

                        // mysql database selection.
                        if (@mysql_select_db ($database, $link)) {
                          // BEGIN a db transaction.
                          mysql_query ("BEGIN");

                          // execute sql queries (create schema & insert data).
                          $query = "DROP TABLE IF EXISTS `contents`;";
                          $r1 = mysql_query ($query, $link);
                          $query = "DROP TABLE IF EXISTS `markers`;";
                          $r2 = mysql_query ($query, $link);
                          $query = "DROP TABLE IF EXISTS `types`;";
                          $r3 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `types` (
                                      `id`     int (11)      NOT NULL AUTO_INCREMENT,
                                      `name`   varchar (256) COLLATE utf8_unicode_ci NOT NULL,
                                      `letter` char (1)      COLLATE utf8_unicode_ci NOT NULL,
                                      PRIMARY KEY (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r4 = mysql_query ($query, $link);
                          $query = "INSERT INTO `types` (`id`, `name`, `letter`) VALUES (1, 'Universities', 'U');";
                          $r5 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `markers` (
                                      `id`      int (11)        NOT NULL auto_increment,
                                      `name`    varchar (256)   collate utf8_unicode_ci NOT NULL,
                                      `address` varchar (256)   collate utf8_unicode_ci NOT NULL,
                                      `lat`     decimal (10, 6) NOT NULL,
                                      `lng`     decimal (10, 6) NOT NULL,
                                      `type`    int (11)        NOT NULL,
                                      PRIMARY KEY (`id`),
                                      FOREIGN KEY (`type`) REFERENCES `types` (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r6 = mysql_query ($query, $link);
                          $query = "INSERT INTO `markers` (`id`, `name`, `address`, `lat`, `lng`, `type`) VALUES (1, 'T.E.I. of Serres', 'Terma Magnisias, Serres, Greece', 41.076751, 23.553384, 1);";
                          $r7 = mysql_query ($query, $link);

                          $query = "CREATE TABLE IF NOT EXISTS `contents` (
                                      `id`     int (11)      NOT NULL auto_increment,
                                      `email`  varchar (256) collate utf8_unicode_ci default NULL,
                                      `url`    varchar (256) collate utf8_unicode_ci default NULL,
                                      `phone`  varchar (256) collate utf8_unicode_ci default NULL,
                                      `text`   longtext      collate utf8_unicode_ci,
                                      `marker` int (11)      NOT NULL,
                                      PRIMARY KEY (`id`),
                                      FOREIGN KEY (`marker`) REFERENCES `markers` (`id`)
                                    ) ENGINE = InnoDB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci;";

                          $r8 = mysql_query ($query, $link);
                          $query = "INSERT INTO `contents` (`id`, `email`, `url`, `phone`, `text`, `marker`) VALUES (1, 'info@teiser.gr', 'www.teiser.gr', '(+30) 23210 49125', '<div align=\"justify\">The T.E.I. of Serres is a new, dynamic and rapidly developing Institute consisting of three Faculties, seven Departments and more than 12000 students.<br /><br />The T.E.I. of Serres meets modern requirements for the provision of high quality educational standards and the encouragement of applied and technological research. It promotes the employment of scientifically distinguished Professors, the cooperation with educational and research Institutes of our country and with those abroad, the connection between education and production and the job market, the further education of its graduates and the creation of post-graduate studies departments in conjunction with Universities.<br /><br />We welcome you to the present website and I invite you to visit its web pages to gain information about the administration and the organization of the Institute, its mission, the staffing and course plans of the faculties and all of the rest relevant services and activities which are offered.</div>', 1);";
                          $r9 = mysql_query ($query, $link);

                          // if any sql query failed.
                          if (!$r1 || !$r2 || !$r3 ||
                              !$r4 || !$r5 || !$r6 ||
                              !$r7 || !$r8 || !$r9) {
                            // ROLLBACK the db transaction.
                            mysql_query ("ROLLBACK");
                          }
                          else {
                            // COMMIT the db transaction.
                            mysql_query ("COMMIT");

                            // create configuration file.
                            if ($handle = fopen ('../'.FILE_CONFIGURATION, 'w')) {
                              $file_content = "<?php\n"                                                                                         . 
                                              "\n"                                                                                              .
                                              "  // define configuration properties.\n"                                                         .
                                              "\n"                                                                                              .
                                              "  /*\n"                                                                                          .
                                              "   *  Copyright (C) 2010  Efstathios Chatzikyriakidis (stathis.chatzikyriakidis@gmail.com)\n"    .
                                              "   *  Copyright (C) 2010  Stefanos Tzagias            (steftzag@gmail.com)\n"                    .
                                              "   *\n"                                                                                          .
                                              "   *  This program is free software: you can redistribute it and/or modify\n"                    .
                                              "   *  it under the terms of the GNU General Public License as published by\n"                    .
                                              "   *  the Free Software Foundation, either version 3 of the License, or\n"                       .
                                              "   *  (at your option) any later version.\n"                                                     .
                                              "   *\n"                                                                                          .
                                              "   *  This program is distributed in the hope that it will be useful,\n"                         .
                                              "   *  but WITHOUT ANY WARRANTY; without even the implied warranty of\n"                          .
                                              "   *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the\n"                            .
                                              "   *  GNU General Public License for more details.\n"                                            .
                                              "   *\n"                                                                                          .
                                              "   *  You should have received a copy of the GNU General Public License\n"                       .
                                              "   *  along with this program. If not, see <http://www.gnu.org/licenses/>.\n"                    .
                                              "   */\n"                                                                                         .
                                              "\n"                                                                                              .
                                              "  // mysql connection account information.\n"                                                    .
                                              "  define ('CONF_MYSQL_HOST' , '$hostname');\n"                                                   .
                                              "  define ('CONF_MYSQL_USER' , '$username');\n"                                                   .
                                              "  define ('CONF_MYSQL_PASS' , '$password');\n"                                                   .
                                              "  define ('CONF_MYSQL_DB'   , '$database');\n"                                                   .
                                              "\n"                                                                                              .
                                              "  // google maps api properties.\n"                                                              .
                                              "  define ('CONF_GAPI_KEY', '$gmapikey');\n"                                                      .
                                              "  define ('CONF_GAPI_LNG', 'en');\n"                                                             .
                                              "\n"                                                                                              .
                                              "  // get http host address.\n"                                                                   .
                                              "  define ('CONF_HTTP_HOST', \$_SERVER['HTTP_HOST']);\n"                                          .
                                              "?>";

                              // write configuration content.
                              if (fwrite ($handle, $file_content)) {
                                echo clean_for_display ($install_success);

                                // the installation completed without errors.
                                $error = false;
                              }
                            }
                          }
                        }
                      }
                    }

                    // check if an error happened in the installation process.
                    if ($error)
                      echo clean_for_display ($install_failure);

                    echo "</td></tr><tr><td>".space (1, 15)."</td></tr>";
                  }
                ?>
                <tr>
                  <td>
                    <form method="post" name="install_form" action="<?php echo FILE_INSTALL_FORM; ?>">
                      <table cellpadding="0" cellspacing="0" class="fieldset" border="0">
                        <tbody>
                          <tr>
                            <td>
                              <table cellpadding="0" cellspacing="0" border="0">
                                <tbody>
                                  <tr>
                                    <td><?php echo clean_for_display ($install_hostname); ?></td>
                                    <td><?php echo input_text ('hostname', 'width: 230px;', $hostname); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($install_username); ?></td>
                                    <td><?php echo input_text ('username', 'width: 230px;', $username); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($install_password); ?></td>
                                    <td><?php echo input_text ('password', 'width: 230px;', $password); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($install_database); ?></td>
                                    <td><?php echo input_text ('database', 'width: 230px;', $database); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 4); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo clean_for_display ($install_gmapikey); ?></td>
                                    <td><?php echo input_text ('gmapikey', 'width: 230px;', $gmapikey); ?></td>
                                  </tr>
                                  <tr>
                                    <td colspan="2"><?php echo space (1, 15); ?></td>
                                  </tr>
                                  <tr>
                                    <td><?php echo space (); ?></td>
                                    <td align="right">
                                      <?php
                                        echo input_button ('image', 'submit', "../".DIR_GRAPHICS."/submit.png", 'border: 0px; background-color: transparent;');
                                        echo space (10, 1);
                                        echo '<a href="'.FILE_INSTALL_FORM.'"><img src="../'.DIR_GRAPHICS."/clear.png".'" border="0" alt=""></a>';
                                      ?>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <input type="hidden" name="submit_check" value="1"> 
                    </form>
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
