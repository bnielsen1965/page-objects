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
 * @brief Used to request a view to be loaded and processed.
 *
 * The loadview object is used to embed additional views within the current
 * view. The loaded view will be processed like any other view so gob tags
 * will be treated normally.
 *
 *
 * Copyright 2009, 2010, 2011 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */

class loadview {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * name or view - The name of the view to load.
 *
 */
  function __construct($parameters = NULL) {
    if( isset($parameters["name"]) ) {
      router::loadView($parameters["name"]);
    }
    else if( isset($parameters["view"]) ) {
      router::loadView($parameters["view"]);
    }
    else {
      echo "This is the default view content.<br>\n";
      echo "Create new content in an html file in views directory <br>\n";
      echo "and set the gob source parameter to the content filename without an extention.";
    }

  }
}
?>
