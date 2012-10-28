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
 * @brief Displays help for a specified object.
 *
 * Reads the comments directly from the specified object PHP file and formats
 * them for viewing.
 *
 * Copyright 2009, 2010, 2011 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */

class help {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * name - The name the object file to read.
 */
  function __construct($parameters = NULL) {
    if( isset($parameters["name"]) ) $helpName = $parameters["name"];
    else $helpName = "help";

    echo "<div style='clear:left; float:left; border:1px dashed blue; margin:10px 0px 0px 0px;'>\n";
    echo "<b>.: Help ".$helpName." :.</b><br>\n";

    if( file_exists(APPPATH."objects/".$helpName.APPEXT) ) {
      $vc = htmlspecialchars(file_get_contents(APPPATH."objects/".$helpName.APPEXT));

      $va = explode("\n", $vc);
      $oc = FALSE; // outside comment?
      $ll = FALSE; // last line?
      foreach( $va as $vl ) {
        // look for beginning of comment
        if( $oc === FALSE && preg_match("/^\/\*\*/", $vl) > 0 ) {
          $oc = TRUE;
          $ll = FALSE;
        }

        // if inside comment the display line and look for end
        if( $oc === TRUE ) {
          if( preg_match("/^ \*\//", $vl) > 0 ) {
            $oc = FALSE;
            $ll = TRUE;
          }
          else echo $vl."<br>\n";
        }

        if( $ll === TRUE ) {
          if( ($ep = strpos($vl, "{")) !== FALSE ) {
            $ll = FALSE;
            echo substr($vl, 0, $ep - 1)."<br><br><br>\n";
          }
          else if( ($ep = strpos($vl, ";")) !== FALSE ) {
            $ll = FALSE;
            echo $vl."<br><br></pre>\n";
          }
          else echo $vl."<br>\n";
        }
      }
    }
    else {
      echo "Object ".$helpName.". not found.<br>\n";
    }
    echo "</div>\n";
  }
}
?>
