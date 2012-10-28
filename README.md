# Page Objects web application framework

Page Objects is a simple web application framework that uses custom HTML tags to load PHP objects into web pages.
The HTML pages have no PHP code at all, only custom tags to call the PHP objects.

-----------------------------

# Installation

1. Copy the Page Objects files and directories to your web page hosting path.
2. Edit the config.php file and adjust settings as needed for your site.
	* SITE_ROOT - If the application is installed in the root then this should be "/", otherwise it should be the path, i.e. "/page-objects/".
	* DEFAULT_VIEW - Change to the base name of your default application view if it is different from index.html.
	* SHORT_URLS - Set to TRUE if you want URLs without index.php. This also requires mod_rewrite rules, see below.
	* INSERT_SITE - If you have relative URLs in your views then set this to TRUE to have them replaced with absolute URLs.
3. Open your site in a browser and verify that you get the Page Objects view.


---------------------------------

# Developing Web Pages


---------------------------------

# Developing Objects



----------------------------------


# Configuration Settings

The config.php file contains the main application settings.


## SITE_ROOT


## DEFAULT_VIEW


## SHORT_URLS

Aesthetic URLs can be used by setting the SHORT_URLS setting to TRUE and creating a set of mod_rewrite rules to enable the short urls.

The following is an example .htaccess file with the required mod_rewrite rules. Note the RewriteBase setting may need to be changed for your site.

	RewriteEngine On
	RewriteBase /page-objects/
	
	# finished if URL is already index.php
	RewriteRule ^index\.php.*$ - [L]
	
	#if not a file or directory then rewrite
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php/$1 [QSA,L]

