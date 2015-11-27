<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 26/11/2015
 * Time: 7:23 PM
 */

/**
 * Add meta box
 */
require_once __DIR__ . '/meta-box.php';
require_once __DIR__ . '/helpers/functions.php';

function thim_sync_git_get_url_git_hook( $post_id ) {
	return plugin_dir_url( __FILE__ ) . 'git-sync/git-hook.php?repo=' . $post_id . '&token='
	       . str_rot13( base64_encode( 'thim_git_sync_server' . get_home_path() ) . 'thim_git_sync_server' ) . '&key='
	       . base64_encode( 'thim_git_sync_server' );
}

function thim_thim_sync_git_update_url_git_hook( $post_id ) {
	update_post_meta( $post_id, 'thim_sync_git_url_git_hook', thim_sync_git_get_url_git_hook( $post_id ) );
}

add_filter( 'rwmb_after_save_post', 'thim_thim_sync_git_update_url_git_hook' );

$user = new Bitbucket\API\User();
$user->getClient()->addListener( new Bitbucket\API\Http\Listener\BasicAuthListener( 'tutv95', 'hhw95mrT0313' ) );

// now you can access protected endpoints as $bb_user
$response = $user->get();

print_r( $response );