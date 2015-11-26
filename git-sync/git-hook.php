<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 26/11/2015
 * Time: 7:41 PM
 */

$p                   = $_GET['token'];
$key                 = $_GET['key'];
$path_home           = _____( $p, $key );
$file_wp_blog_header = $path_home . '/wp-blog-header.php';

if ( is_dir( $path_home ) && is_file( $file_wp_blog_header ) ) {
	require( $file_wp_blog_header );

	$post_id          = $_GET['repo'];
	$post_content_old = get_post_field( 'post_content', $post_id );

	echo $post_content_old;

	try {
		$server = $_SERVER;
		if ( $server['REQUEST_METHOD'] == 'POST' ) {
			$response = file_get_contents( 'php://input' );

			$object_res = json_decode( $response );
			/**
			 * Push
			 */
			$push    = $object_res->push;
			$changes = $push->changes[0];
			$commits = $changes->commits;

			$now      = date_create()->setTimezone( new DateTimeZone( 'Asia/Ho_Chi_Minh' ) )->format( 'H:i:s d/m/Y' );
			$temp_str = '<strong>' . $now . '</strong>' . PHP_EOL;
			if ( count( $commits ) > 0 ) {
				foreach ( $commits as $index => $commit ) {
					$author       = $commit->author;//Object
					$raw_author   = $author->raw;//Tu TV <tutv95@gmail.com>
					$message      = $commit->message;//demo 02
					$message      = str_replace( array( "\r\n", "\r", "\n" ), '', $message );//demo 02
					$write_commit = $raw_author . ' - "' . $message . '"' . PHP_EOL;
					$temp_str .= $write_commit;
				}
			}

			$temp_str = str_replace( '<', '&lt;', $temp_str );
			$temp_str = str_replace( '<', '&gt;', $temp_str );

			$path_log_txt = 'ok.txt';

			/**
			 * Update post content
			 */
			$my_post = array(
				'ID'           => $post_id,
				'post_content' => $post_content_old . PHP_EOL . $temp_str,
			);
			wp_update_post( $my_post );


			if ( countLineTextFile( $path_log_txt ) > 1000 ) {
				file_put_contents( $path_log_txt, PHP_EOL . sprintf( $temp_str ), FILE_TEXT );
			} else {
				file_put_contents( $path_log_txt, PHP_EOL . sprintf( $temp_str ), FILE_APPEND );
			}
		}
	} catch ( Exception $e ) {
		file_put_contents( $path_log_txt, PHP_EOL . sprintf( $e->getMessage() ), FILE_APPEND );
	}
}

function countLineTextFile( $path ) {
	$count  = 0;
	$handle = fopen( $path, 'r' );
	while ( ! feof( $handle ) ) {
		$line = fgets( $handle );
		$count ++;
	}

	fclose( $handle );

	return $count;
}

function _____( $f, $k ) {
	try {
		$key = base64_decode( $k );
		$f   = str_rot13( $f );
		$f   = str_replace( $key, '', $f );
		$f   = base64_decode( $f );
		$f   = str_replace( $key, '', $f );

		return $f;
	} catch ( Exception $e ) {
		return null;
	}
}