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
 * @brief Reads a configuration file from the configs directory into an array.
 *
 * The specified configuration file will be read from the config path
 * and processed by creating and returning an array of configuration
 * elements and values or echoing out the configuration file.
 * The configfile gob is usually used within other gobs by a PHP
 * developer. The gob tag that uses configfile should specify the
 * details expected in the configuration file.
 *
 * Each configuration file must have a .php file extension on the name,
 * must have the PHP tags surrounding the configuration parameters and
 * must have the parameters and values surrounded by comment tags, i.e.
 *
@verbatim
<?php
/ *
parameter1="value1"
parameter2="value2"
paraemter3="value3"
* /
?>
@endverbatim
 *
 * In the previous example the configfile object would return an array
 * with the three parameter elements and the three assigned values...
 *
 * array("parameter1" =\> "value1", "parameter2" =\> "value2", "parameter3" =\> "value3")
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */

class configfile {

  private $cn; // configuration name
  private $ca; // configuration array

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * name - (optional) The name a configuration file to read.
 *
 * echo - (optional) If set the configuration settings will be echoed out and
 * displayed in the browser.
 */
  function __construct($parameters = NULL) {
    if( isset($parameters["name"]) ) {
      $this->cn = $parameters["name"];
      $this->ca = $this->readconfig($this->cn);
    }
    else {
      $this->cn = NULL;
      $this->ca = array();
    }

    if( isset($parameters["echo"]) ) $this->echoconfig();
  }


/**
 * Reads the configuration file and returns an array of elements and values based on the 
 * contents of the configuration file.
 *
 * @param configname The filename in the config directory without the extension.
 * @return An associative array with the configuration values.
 */
  public function readconfig($configname = NULL) {
    if( $configname === NULL ) $configname = $this->cn;

    // create an array to return
    $ra = array();

    if( $configname !== NULL && file_exists(CONFIGPATH.$configname.APPEXT) ) {
      // get the config file contents
      $cc = file_get_contents(CONFIGPATH.$configname.APPEXT);

      // explode on spaces
      $va = explode("\n", $cc);
      // process each line looking for a parameter=value pair
      foreach( $va as $vl ) {
        // trim the ends of the line
        $vl = trim($vl);
        // an = means parm=value pair
        if( strpos($vl, "=") !== FALSE ) {
          // split param and value
          $ta = explode("=", $vl);
          // if param and value extracted then process
          if( count($ta) >= 2 ) {
            // if count is greater than 2 then concatentate values
            if( count($ta) > 2 ) {
              for( $i = 2; $i < count($ta); $i++ ) {
                $ta[1] .= '='.$ta[$i];
              }
            }
            // if value wrapped in quotes then remove
            $ta[1] = preg_replace("/^\"|^'|\"$|'$/", "", $ta[1]);
            $ra["$ta[0]"] = $ta[1];
          } // end of param value found if
        } // end of check for = delimiter
      } // end of foreach on lines
    } // end of check for file exists

    return $ra;
  } // end of readconfig function


/**
 * Echos out the configuration array values. This is used to view a configuration file in a view.
 */
  function echoconfig() {
    foreach($this->ca as $k => $v) {
      echo $k."='".$v."'\n";
    }
  }


/**
 * Returns the configuration array.
 * @return The configuration array.
 */
  public function getconfig() {
    return $this->ca;
  }
} // end of class
?>
