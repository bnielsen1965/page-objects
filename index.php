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
 
 /** load the application configuration file */
include('config.php');

/**
 * @brief Defines the router class and initiates the application.
 *
 * The router class takes the URI the user entered to access the web page and breaks it down
 * and begins loading views and objects based on the parameters passed in the URI and the
 * contents of the view.
 *
 * The URI will take the form of http://host/index.php/view/arg1/arg2/arg3/etc...
 *
 * The router class also provides public functions to be used by other objects.
 *
 * Copyright 2012 Bryan Nielsen
 *
 * See the file LICENSE for software licensing terms.
 *
 * @author Bryan Nielsen, bnielsen1965@gmail.com
 */

class router {

	// routing variables
	static $appValues; // an array of values from APPPASSED
	static $appView; // contains the name of the view to be loaded


/**
 * Prepares router to load the view.
 */
	function __construct() {
		// assign the default view in case one is not specified in the URL
		router::$appView = DEFAULT_VIEW;

		// initialize temporary array
		$mv = array();
		
		// if arguements were passed in the URL then process them
		if( strlen(APPPASSED) > 0 ) {
			// separate arguements on slash
			$mv = explode('/', APPPASSED);
			
			// first value is always the view
			if( count($mv) > 0 && file_exists(APPPATH."/views/".$mv[0].".html") ) {
				router::$appView = $mv[0];

				// remove view name from argument values array
				unset($mv[0]);
				$mv = array_values($mv);
			}

			// if anything remains it is left in the array as application argument values
			router::$appValues = &$mv;
		}
	}


/**
 * Retrieve argument values passed in the URL
 */
	static function getAppValues() {
		return router::$appValues;
	}


/**
 * Returns the name of the current view
 */
	static function getAppView() {
		return router::$appView;
	}


/**
 * function to load and process the view
 *
 * @param viewName A string containing the name of the view to load.
 */
	static function loadView($viewName = NULL) {
		// if a view name is not specified then use the router's view
		if( $viewName === NULL ) $viewName = router::$appView;

		// if the view does not exist as an html, css, or js file then we have an error
		if( !($vExt = (file_exists(APPPATH."/views/".$viewName.".html") ? '.html' : FALSE)) &&
			!($vExt = (file_exists(APPPATH."/views/".$viewName.".css") ? '.css' : FALSE)) && 
			!($vExt = (file_exists(APPPATH."/views/".$viewName.".js") ? '.js' : FALSE)) ) {
			// the view was not found so load the error view
			echo "error, view ".$viewName." not found in html, css or js format\r\n";
		}
		else {
			// get the view file contents
			$vc = file_get_contents(APPPATH."/views/".$viewName.$vExt);

			// remove carriage returns
//			$vc = preg_replace("/.*\r.*/", "", $vc);
			$vc = preg_replace("/\r/", "", $vc);

			// if there is content then process gob tags and content
			if( strlen($vc) > 0 ) {
				//reset string offset
				$vo = 0;
	
				// while there is an object tag continue processing
				while( ($op = strpos($vc, "<" . OBJECTTAG . "=", $vo)) !== FALSE ) {
					// if there is content prior to the object then echo it before processing
					if( $vo < $op ) {
						// insert site URL into relative URLs
						if( INSERT_SITE ) {
							$pi = pathinfo("views/".$viewName.$vExt);
							echo router::insertSite(substr($vc, $vo, $op - $vo), $pi['dirname']);
						}
						else echo substr($vc, $vo, $op - $vo);
	
						// set new view string offset value
						$vo = $op + 1;
					}
					else {
						// set new view string offset value
						$vo = $op + 1;
					}
	
					// find the ending of the object tag
					$op = strpos($vc, ">", $vo);
	
					// if the ending tag was not found then produce an error, otherwise process
					if( $op === FALSE ) {
						// serious error, end of the object tag not found
						echo "error, end of " . OBJECTTAG . " tag not found";
					}
					else {
						// create an empty object parameters array
						$oa = array();
	
						// extract the object definition into a string
						$os = substr($vc, $vo, $op - $vo);
	
						// replace carriage returns and new lines with spaces
						$os = preg_replace(array("/\r/", "/\n/"), " ", $os);
	
						// break object parameters up using spaces outside of quotes
						$od = array();
						$ss = 0; // start of current parameter string
						$inq = FALSE; // inside quotes?
						for( $si = 0; $si < strlen($os); $si++ ) {
							// keep track of location in or out of quotes
							if( $inq === FALSE && ($os[$si] == '"' || $os[$si] == "'") ) $inq = TRUE;
							else if( $inq === TRUE && ($os[$si] == '"' || $os[$si] == "'") ) $inq = FALSE;
	
							// if outside quotes and encountered a space then determine how to proceed
							if( $inq === FALSE && $os[$si] == " " && $ss != $si ) {
								$od[] = substr($os, $ss, $si - $ss);
								$ss = $si;
							}
						}
	
						// if it $ss did not make it to the end of the object string then assume we have one last parameter
						if( $ss < strlen($os) ) $od[] = substr($os, $ss, strlen($os) - $ss);
	
						// process each line looking for a parameter=value pair
						foreach( $od as $ol ) {
							// trim the ends of the line
							$ol = trim($ol);
	
							// an = means parm=value pair
							if( ($fe = strpos($ol, "=")) !== FALSE ) {
								// split param and value
								$ta = array();
								$ta[] = substr($ol, 0, $fe);
								$ta[] = substr($ol, $fe + 1, strlen($ol) - $fe);
	
								// if param and value extracted then process
								if( count($ta) == 2 ) {
									// if value wrapped in quotes then remove
									$ta[1] = preg_replace(array("/^\"/", "/^'/", "/\"$/", "/'$/"), "", $ta[1]);
									$oa["$ta[0]"] = $ta[1];
								}
							}
							else {
								// parameter without a value
								$oa[trim($ol)] = TRUE;
							}
						}
	
						// if object was defined then load the object
						if( isset($oa[OBJECTTAG]) ) {
							router::loadObject($oa[OBJECTTAG], $oa);
						}
	
						// set the offset past the object definition
						$vo = $op + 1;
	
						// offset past any immediate linefeeds/carriage returns after the gob tag
						if( $vo < strlen($vc) && ($vc[$vo] == "\r" || $vc[$vo] == "\n") ) $vo += 1;
						if( $vo < strlen($vc) && ($vc[$vo] == "\r" || $vc[$vo] == "\n") ) $vo += 1;
					}
				}
	
				// if the offset point is not at the end of the content then echo the remainder
				if( $vo < strlen($vc) ) {
					if( INSERT_SITE ) {
						$pi = pathinfo("views/".$viewName.$vExt);
						echo router::insertSite(substr($vc, $vo, strlen($vc) - $vo), $pi['dirname']);
					}
					else echo substr($vc, $vo, strlen($vc) - $vo);
				}
			}
		}
	}



/**
 * Replaces relative URLs by inserting an absolute URL.
 *
 * @param content The content to parse and insert site URLs.
 * @param vPath An additiona path value to append to the site path.
 */
	static function insertSite($content, $vPath = '') {
		$patterns = array(
			'/(\<img .*src=["\'])(?!http[s]*\:\/\/)(.*\>)/imU',
			'/(\<link .*href=["\'])(?!http[s]*\:\/\/)(.*\>)/imU',
			'/(url\(["\'])(?!http[s]*\:\/\/)(.*["\']\))/imU',
			'/(\<script .*src=["\'])(?!http[s]*\:\/\/)(.*\>)/imU'
		);

		return preg_replace($patterns, '$1' . APPSITE . $vPath . '/$2', $content);
	}



/**
 * Loads the specified application object from the objects directory.
 *
 * @param m A string containing the name of the object to load.
 * @param d An array of parameters to pass to the object when it is created.
 * @return The new object instance.
 */
	static function loadObject($m, $d = NULL) {
		// check for existence of model file
		if( !file_exists(APPPATH."objects/$m".APPEXT) ) {
			// object file wasn't found, error message
			echo "Error, object ".$m." not found"; 
		} else {
			// model file found, include and create instance
			include_once(APPPATH."objects/$m".APPEXT);

			return new $m($d);
		}
	}


/**
 * Executes an include on an object definition.
 *
 * @param a A string containing the name of object to include
 */
	static function includeObject($a) {
		// check for existence of the file
		if( !file_exists(APPPATH."objects/$a".APPEXT) ) {
			// file wasn't found, run default loaderror with error message
			echo "error, object not found";
		} else {
			// file found, include the addon
			include_once(APPPATH."objects/$a".APPEXT);
		}
	}

}



$approuter = new router(); // create an instance of the router
$approuter->loadView(); // load the view to start the application

?>
