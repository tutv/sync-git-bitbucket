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
					$author     = $commit->author;//Object
					$raw_author = $author->raw;//Tu TV <tutv95@gmail.com>
					$raw_author = str_replace( '<', '&lt;', $raw_author );
					$raw_author = str_replace( '<', '&gt;', $raw_author );

					$message      = $commit->message;//demo 02
					$message      = str_replace( array( "\r\n", "\r", "\n" ), '', $message );//demo 02
					$write_commit = $raw_author . ' - "' . $message . '"' . PHP_EOL;
					$temp_str .= $write_commit;
				}
			}

			/**
			 * Repo
			 */
			$user               = rwmb_meta( 'thim_sync_git_repo_user', [ ], $post_id );
			$repo               = $object_res->repository;
			$link_repo          = $repo->links;
			$url_repo_cloneable = $link_repo->html->href;
			$url_repo_cloneable = str_replace( 'https://', 'https://' . $user . '@',
				$url_repo_cloneable );//https://tutv95@bitbucket.org/tutv95/demo-git-sync.gits
			$url_repo_cloneable .= '.git';

			/**
			 * Update post content
			 */
			$my_post = array(
				'ID'           => $post_id,
				'post_content' => $post_content_old . PHP_EOL . $temp_str . $url_repo_cloneable,
			);
			wp_update_post( $my_post );
		}
	} catch ( Exception $e ) {
		$path_log_txt = 'ok.txt';
		file_put_contents( $path_log_txt, PHP_EOL . sprintf( $e->getMessage() ), FILE_APPEND );
	}
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