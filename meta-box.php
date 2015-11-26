<?php
/**
 * Created by PhpStorm.
 * User: Tu TV
 * Date: 26/11/2015
 * Time: 7:24 PM
 */

require_once __DIR__ . '/meta-box/meta-box.php';

add_filter( 'rwmb_meta_boxes', 'fituet_register_meta_boxes_event' );
function fituet_register_meta_boxes_event( $meta_boxes ) {
	$prefix = 'thim_sync_git_';

	$meta_boxes[] = array(
		'id'         => $prefix . 'git_hook',
		'title'      => __( 'Git Hook', 'fituet' ),
		'post_types' => array( 'thim_git_sync_server' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'id'         => $prefix . 'url_git_hook',
				'name'       => 'URL',
				'desc'       => 'URL Web hook',
				'type'       => 'textarea',
				'std'        => thim_sync_git_get_url_git_hook( get_the_ID() ),
				'attributes' => array(
					'readonly' => true,
				),
			),
			array(
				'id'         => $prefix . 'dir_git_hook',
				'name'       => 'URL',
				'desc'       => 'URL Web hook',
				'type'       => 'textarea',
				'std'        => plugin_dir_url( __FILE__ ),
				'attributes' => array(
					'readonly' => true,
				),
			),
		),
	);

	$meta_boxes[] = array(
		'id'         => $prefix . 'repo',
		'title'      => __( 'Detail Repo', 'fituet' ),
		'post_types' => array( 'thim_git_sync_server' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'id'   => $prefix . 'repo_url',
				'name' => 'URL',
				'desc' => 'URL repo',
				'type' => 'text',
				'std'  => 'https://tutv95@bitbucket.org/tutv95/demo-git-sync.git',
			),
			array(
				'id'   => $prefix . 'repo_user',
				'name' => 'Username repo',
				'desc' => 'Username repo',
				'type' => 'text',
				'std'  => 'tutv95',
			),
			array(
				'id'   => $prefix . 'repo_password',
				'name' => 'Passwrod user',
				'desc' => 'Passwrod user',
				'type' => 'password',
			),
		),
	);

	$meta_boxes[] = array(
		'id'         => $prefix . 'server',
		'title'      => __( 'Detail server', 'fituet' ),
		'post_types' => array( 'thim_git_sync_server' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'fields'     => array(
			array(
				'id'   => $prefix . 'server_user',
				'name' => 'user',
				'desc' => 'user',
				'type' => 'text',
			),
			array(
				'id'   => $prefix . 'server_password',
				'name' => 'Passwrod server',
				'desc' => 'Passwrod server',
				'type' => 'password',
			),
			array(
				'id'   => $prefix . 'server_dir_repo',
				'name' => 'Dir',
				'desc' => 'Dir',
				'type' => 'text',
			),
			array(
				'id'   => $prefix . 'server_re_password',
				'name' => 'Passwrod server',
				'desc' => 'Passwrod server',
				'type' => 'password',
			),
		),
	);

	return $meta_boxes;
}