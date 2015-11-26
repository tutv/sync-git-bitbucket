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

function thim_sync_git_get_url_git_hook() {
	return plugin_dir_url( __FILE__ ) . 'git-sync/git-hook.php';
}