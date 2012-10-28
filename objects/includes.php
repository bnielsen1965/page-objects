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
 * @brief Executes an include_once() on the specified objects.
 *
 * The includes object takes a comma delimited list of object names
 * in the includes parameter and executes an include_once() on each
 * object class so they will be defined. This is beneficial when a
 * class needs to be defined prior to use, i.e. if an object is stored
 * in the user's session and needs to be defined before it can be
 * used from the session instance.
 *
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */

class includes {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * includes - A comma delimited list of object names to be included
 *
 */

  function __construct($parameters = NULL) {
    if( isset($parameters["includes"]) ) {
      $ia = explode(",", $parameters["includes"]);
      foreach( $ia as $if ) {
        if( file_exists(APPPATH."objects/".$if.APPEXT) ) {
          include_once(APPPATH."objects/".$if.APPEXT);
        }
      }
    }
  }

} // end of class
?>
