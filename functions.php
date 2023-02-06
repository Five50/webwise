<?php
/**
 * Theme functions file
 *
 * The theme functions file which initialises the compatibility check, autoloader and bootstrap files.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @author    Karl Adams <karladams@getmediawise.com>
 * @copyright Copyright (c) 2023, GetMediaWise Ltd
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @package   webwise
 * @since     0.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Restricted Access' );
}

/*
 * Autoload classes and functions related to the theme.
 *
 * @since 0.1.0
 * @var string
*/
$autoload = get_parent_theme_file_path( '/app/autoload.php' );

if ( file_exists( $autoload ) ) {
	require_once $autoload;
}
