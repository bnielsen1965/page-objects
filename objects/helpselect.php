<?php
/* Copyright 2009 - 2012 Bryan Nielsen <bnielsen1965@gmail.com>
 * 
 * This file is part of Page Objects.
 *
 * Page Objects is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Page Objects is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Page Objects.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

/**
 * @brief Displays a list of objects with help available.
 *
 * Lists installed GOBs with links that will display a help GOB on a selected
 * object.
 *
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */

class helpselect {


/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * linkview - The view that the help links should call, if one is not passed in
 * the parameters then the calling view will be used by default.
 *
 */

  function __construct($parameters = NULL) {
    // if the link view was not specified in the parameters then use the current view that called helpselect
    $linkView = router::getAppView();
    if( isset($parameters["linkview"]) ) $linkView = $parameters["linkview"];

    // get the values passed in the URL to see if an object was selected
    $av = router::getAppValues();
    if( isset($av[0]) ) {
      $oa = array("object" => "help", "name" => $av[0]);
      router::loadObject("help", $oa);
      echo "<br>";
    }

    // build a list of links based on the PHP files in the objects path
    if ($handle = opendir(APPPATH."objects/")) {
      $fa = array();
      while( ($file = readdir($handle)) !== FALSE ) $fa[] = $file;
      sort($fa);

      echo "<div style='float:left; clear:left;'>";
      foreach($fa as $file) {
        if( ($xp = strpos(strtolower($file), ".php")) !== FALSE && preg_match("/.php$/", strtolower($file)) > 0 ) {
          echo "<a href='" . APPSITE . (SHORT_URLS ? "" : "index.php/") . $linkView . "/" . substr($file, 0, $xp) . "'>" . $file . "</a><br>\n";
        }
      }
    echo "</div>";
    }

    closedir($handle);
  }
}
?>
