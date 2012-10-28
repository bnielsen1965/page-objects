<?php
/**
 * @file config.php
 * @brief User defined and auto generated application constants.
 *
 * Important settings:
 * SITE_ROOT
 * DEFAULT_VIEW
 * SHORT_URLS
 * INSERT_SITE
 */

/**
* The root of the application. This will be only a slash if installed
* in the domain's root. This will be the subdirectory name in the URL if
* the application is not installed in the domain's root path.
*/
define('SITE_ROOT', '/page-objects/');



/** Set the application time zone or use system default */
date_default_timezone_set(@date_default_timezone_get());



/** The default view that will be loaded if one is not specified in the URL. */
define('DEFAULT_VIEW', 'index');


/** Define if short URLs will be used with mod_rewrite to eliminate index.php from the URL, requires a .htaccess file. */
define('SHORT_URLS', TRUE);


/** Define if relative URLs should be replaced by inserting site address to create absolute URLs. */
define('INSERT_SITE', TRUE);




/**
 * application constants
 */
define('FRAMEWORKVERSION', '1.0rc'); // set the framework version
define('OBJECTTAG', 'ob'); // NOTE: unlike the HTML tags, the object tag is case sensitive!

define('APPPATH', dirname(__FILE__).'/'); // system path to the framework
define('OBJECTPATH', APPPATH.'objects/'); // path to application objects
define('CONFIGPATH', APPPATH.'configs/'); // miscellaneous configuration file path
define('VIEWPATH', APPPATH.'views/'); // path to application views


define('APPEXT', '.'.pathinfo(__FILE__, PATHINFO_EXTENSION)); // file extension used for php files
define('APPPASSED', preg_replace(array('|^/|', '|/$|'), '', trim(str_replace(SITE_ROOT, '', $_SERVER['REQUEST_URI']))));



// if this is a web request then define web constants
if( isset($_SERVER['HTTP_HOST']) ) {
  define('APPURL', (isset($_SERVER['HTTPS'])?'https://':'http://').$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']); // URL used to call app
  define('APPSITE', ($indexpos = strpos(APPURL, "index.php")) !== FALSE?substr(APPURL, 0, $indexpos):APPURL); // define base application URL
}

?>
