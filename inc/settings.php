<?php
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
define('DECLUTTER_THUMBS_ON_LOAD', false); //Can create slow page loading times, best via cron
define('CREATE_NULL_INDEX_ON_LOAD', true);
