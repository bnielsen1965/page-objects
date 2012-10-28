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
 * @brief Returns the value of specified application parameters.
 *
 * The parameters object will look for the specified parameter and echo out
 * the value of that parameter. This is used to include the value of application
 * parameters directly in a web page or javascript.
 *
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */
class parameters {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * appview - Show the name of the current view.
 *
 * appvalue - Returns the specified URL argument value if set, i.e. appvalue='2'
 * will return the second URL application value if it was set in the URL.
 */
  function __construct($parameters = NULL) {
    if( isset($parameters['appview']) ) {
      echo router::getAppView();
    }

    if( isset($parameters['appvalue']) ) {
      $args = router::getAppValues();
      if( isset($args[$parameters['appvalue']]) ) return $args[$parameters['appvalue']];
    }

    if( isset($parameters['post']) && isset($_POST[$parameters['post']]) ) {
      echo $_POST[$parameters['post']];
    }
  }
}
?>
