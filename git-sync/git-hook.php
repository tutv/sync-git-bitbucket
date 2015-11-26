<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 26/11/2015
 * Time: 7:41 PM
 */

echo 'hello world';

try {
	$server   = $_SERVER;
	$response = file_get_contents( 'php://input' );

	$object_res = json_decode( $response );
	/**
	 * Push
	 */
	$push    = $object_res->push;
	$changes = $push->changes[0];
	$commits = $changes->commits;

	$temp_str = '';
	if ( count( $commits ) > 0 ) {
		foreach ( $commits as $index => $commit ) {
			$now        = date_create()->setTimezone( new DateTimeZone( 'Asia/Ho_Chi_Minh' ) )->format( 'H:i:s d/m/Y' );
			$author     = $commit->author;//Object
			$raw_author = $author->raw;//Tu TV <tutv95@gmail.com>
			$message    = $commit->message;//demo 02
			$message    = str_replace( '\n', '', $message );//demo 02

			$write_commit = $now . PHP_EOL . $raw_author . ' - "' . $message . '"' . PHP_EOL;
			$temp_str .= $write_commit;
		}
	}


	file_put_contents( 'ok.txt', $temp_str );
} catch ( Exception $e ) {
	file_put_contents( 'ok.txt', $e->getMessage() );
}
