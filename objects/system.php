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
 * @brief Echos out system parameters.
 *
 * The system object is useful for developers when troubleshooting an 
 * installation or simply to review the current system settings.
 *
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */
class system {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * None
 */
  function __construct($parameters = NULL) {
    echo "<b>.:System Values:.</b><br>\n";
    echo "FRAMEWORKVERSION : ".FRAMEWORKVERSION."<br>\n";
    echo "APPPATH : ".APPPATH."<br>\n";
    echo "APPEXT : ".APPEXT."<br>\n";
    echo "APPPASSED : ".APPPASSED."<br>\n";
    echo "APPURL : ".APPURL."<br>\n";
    echo "APPSITE : ".APPSITE."<br>\n";
    echo "DEFAULT_VIEW : ".DEFAULT_VIEW."<br>\n";
  }
}
?>
