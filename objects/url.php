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
 * @brief Creates an URL to a given file on the server.
 *
 * The url object will create an URL using the site URL and the specified
 * path appended to the site URL. This is an important gob tag for HTML
 * developers as it ensures links use properly formed URLs no matter
 * where the application is installed.
 *
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */
class url {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * path - The path to append to the site URL.
 *
 */
  function __construct($parameters = NULL) {
    if( isset($parameters["path"]) ) echo APPSITE.$parameters["path"];
    else echo APPSITE;
  }
}
?>
