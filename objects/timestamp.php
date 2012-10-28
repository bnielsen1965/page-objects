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
 * @brief Display the current date and time on the server.
 *
 * The object will display the current time on the server and will adjust
 * for the timezone if specified and use the specified formatting. See the PHP
 * date documentation for formatting strings.
 *
 *
 * Copyright 2009, 2010, 2011 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */
class timestamp {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * timezone - The timezone to set before displaying time, i.e. timezone='America/New_York'
 * or timezone='UTC'. See the PHP timezone documentation for valid timezones.
 *
 * format - The PHP format string to use for the display.
 *
 */
  function __construct($parameters = NULL) {
    $timeint = time();

    if( isset($parameters['timezone']) ) {
      if( date_default_timezone_set($parameters['timezone']) === FALSE ) echo "Bad timezone identifier!";
    }

    if( isset($parameters["format"]) ) {
      echo date($parameters["format"], $timeint);
    }
    else {
      echo date("l F j, Y H:i:s T", $timeint);
    }
  }
}
?>
