<?php
/**
 * Owner information (used for copyright text)
 */
define('COPYRIGHT_HOLDER','F13Dev');

/**
 * Set site language
 */
 define('SITE_LANG', 'en');

/**
 * Site title (shown at the top of page)
 */
 define('SITE_TITLE', 'Photo archive');

/**
 * Define the CSS files to use
 */
define('CSS_MAIN','style.php');
define('CSS_MOBILE','mobile.css');

/**
 * Define the maximum dimensions of thumbs
 */
define('THUMB_MAX_WIDTH', 150);
define('THUMB_MAX_HEIGHT', 150);
define('GD_THUMBS', false); //Set to true to use GD library or false to use ImageMagick

/**
 * Define the images and thumbs directories,
 * relative to the root of PHP-Photo-Archive.
 */
define('ARCHIVE_MAIN', 'archive/images/');
define('ARCHIVE_THUMBS', 'archive/thumbs/');

/**
 * On load rules
 */
define('CREATE_THUMBS_ON_LOAD', true); // Can create excessively slow page loads on new galleries

/**
 * Pagination
 */
define('FILES_PER_PAGE', 50); // Does not include navigation items

/**
 * Cron log file name
 */
define('CRON_LOG', 'cron.log'); // The name of the log file
