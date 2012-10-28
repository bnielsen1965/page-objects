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
 * @brief Manage a user's session on the web server.
 *
 * A session gob at the beginning of a view will establish the user's session
 * and provide some functions to manage the session. The methods in the session
 * object are used from within other gob objects.
 *
 *
 * Copyright 2009 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *  
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */
class session {

/**
 * Object constructor
 *
 * @param Accepts an associative array containing parameters for the object.
 *
 * Parameter values include:
 *
 * logout, destroy or end - If any of these parameters are set then the existing
 * session will be destroyed and a new session started.
 *
 * sessionname - The name to give to the session that is created.
 *
 * sessionconfig - The config file name that holds the session_name element.
 *
 */
  function __construct($parameters = NULL) {
    // session name control
    if( isset($parameters["sessionname"]) && strlen($parameters["sessionname"]) > 0 ) session_name($parameters["sessionname"]);
    else if( isset($parameters["sessionconfig"]) ) {
      // read the configuration file so the session cookie name can be set
      $co = router::loadobject("configfile");
      $config = $co->readconfig($parameters["sessionconfig"]);
      if( array_key_exists('session_name', $config) && strlen($config['session_name']) > 0 ) session_name($config['session_name']);
    }

    session_start();

    // session ending parameters
    if( isset($parameters["logout"]) || isset($parameters["destroy"]) || isset($parameters["end"]) ) {
      $this->endsession();
    }

    if( isset($parameters["set"]) && isset($parameters["value"]) ) {
      session::setvalue($parameters["set"], $parameters["value"]);
    }
  }


/**
 * Destroy the current session.
 */
  static function endsession() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time()-42000, '/');
    }
    session_destroy();
  }


/**
 * Extract a variable value from the session.
 *
 * @param sparam The name of the session parameter to extract from the session.
 *
 * @return A value or NULL if the parameter does not exist in the session.
 */
  static function getvalue($sparam = "") {
    if( isset($_SESSION[$sparam]) ) return $_SESSION[$sparam];
    else return NULL;
  }


/**
 * Set a variable value in the session.
 *
 * @param sparam The name of the session parameter to set.
 *
 * @param svalue The value to set the session parameter to.
 */
  static function setvalue($sparam = "", $svalue = NULL) {
    $_SESSION[$sparam] = $svalue;
  }


/**
 * Get a finger print for the current user's session.
 */
  static function fingerPrint() {
    return md5($_SERVER['HTTP_USER_AGENT'].session_id());
  }


/**
 * Set an encrypted variable value in the session.
 *
 * @param sparam The name of the session parameter to set.
 *
 * @param svalue The value to set the session parameter to.
 */
  static function setCryptValue($sparam = "", $svalue = NULL) {
    // if parameter name is supplied
    if( strlen($sparam) > 0 ) {
      if( ($td = mcrypt_module_open('rijndael-256', '', 'ctr', '')) !== FALSE ) {
        $iv = mcrypt_create_iv(32, MCRYPT_RAND);
        if( mcrypt_generic_init($td, session::fingerPrint(), $iv) == 0 ) {
          $val = serialize($svalue);
          $val = mcrypt_generic($td, $val);
          $val = $iv.$val;
          $val = base64_encode($val);
          mcrypt_generic_deinit($td);
          mcrypt_module_close($td);
          session::setvalue($sparam, $val);
          return TRUE;
        }
      }
    }

    return FALSE;
  }


/**
 * Get an encrypted variable value from the session.
 *
 * @param sparam The session parameter to read and decrypt.
 */
  static function getCryptValue($sparam = "") {
    $val = session::getvalue($sparam);

    if( !is_null($val) && ($td = mcrypt_module_open('rijndael-256', '', 'ctr', '')) !== FALSE ) {
      $val = base64_decode($val);
      $iv = substr($val, 0, 32);
      $val = substr($val, 32, strlen($val) - 32);
      if( mcrypt_generic_init($td, session::fingerPrint(), $iv) == 0 ) {
        $val = mdecrypt_generic($td, $val);
        $val = unserialize($val);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $val;
      }
    }

    return NULL;
  }
}
?>
