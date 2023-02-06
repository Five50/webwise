<?php
/**
 * Autoload File
 *
 * @author    Karl Adams <karladams@getmediawise.com>
 * @copyright Copyright (c) 2023, GetMediaWise Ltd
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * @package   webwise
 * @since     0.1.0
 */

namespace WebWise\App;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Restricted Access' );
}

spl_autoload_register(
	static function( $file ) {

		$filename = '';
		$path     = explode( '\\', $file );

		if ( isset( $path[ count( $path ) - 1 ] ) ) {
			$filename       = strtolower( $path[ count( $path ) - 1 ] );
			$filename       = str_ireplace( '_', '-', $filename );
			$filename_parts = explode( '-', $filename );
			$index          = $filename_parts[0];

			if ( 'interface' === $index || 'trait' === $index ) {
				unset( $filename_parts[ $index ] );

				// Rebuild the file name.
				$filename = implode( '-', $filename_parts );
				$filename .= '.php';

			} else {
				$filename = "class-$filename.php";
			}
		}

		$count     = count( $path );
		$full_path = trailingslashit( dirname( __FILE__, 2 ) );

		for ( $i = 1; $i < $count - 1; $i++ ) {
			$dir        = strtolower( $path[ $i ] );
			$full_path .= trailingslashit( $dir );
		}

		$full_path .= $filename;

		if ( stream_resolve_include_path( $full_path ) ) {
			include_once $full_path;
		}
	}
);

/**
 * List of whitelisted php files.
 *
 * @since 0.1.0
 *
 * @return array
 */
function whitelisted_files(): array {
	return array(
		'bootstrap',
	);
}

/**
 * Autoload function files.
 *
 * Load required functions files.
 *
 * @since 0.1.0
 */
array_map(
	static function( $file ) {
		require_once get_parent_theme_file_path( 'app/' . $file . '.php' );
	},
	whitelisted_files()
);

