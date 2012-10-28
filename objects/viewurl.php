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
 * @brief Creates an URL to load a specific view.
 *
 * The url object will create an URL using the site URL that is used
 * to load the specified view. This is an important gob for HTML
 * developers to ensure URLs are properly formed to load a view.
 *
 *
 * Copyright 2009, 2010, 2011 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */
class viewurl {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * viewname, name, or view - The view to load with the URL.
 *
 * this - Use the current view for the URL. Useful for forms
 *
 * withvalues - Appends the current URL values to the generated view URL.
 *
 */
  function __construct($parameters = NULL) {
    if( isset($parameters["viewname"]) ) $name = $parameters["viewname"];
    else if( isset($parameters["name"]) ) $name = $parameters["name"];
    else if( isset($parameters["view"]) ) $name = $parameters["view"];
    else $name = "";

    if( isset($parameters["this"]) ) {
      $name = router::getAppView();
      if( isset($parameters['withvalues']) ) {
        foreach( router::getAppValues() as $val ) $name .= '/'.$val;
      }
    }
    if( strlen($name) > 0 ) echo APPSITE . (SHORT_URLS ? "" : "index.php/") . $name;
    else echo APPSITE;
  }
}
?>
