<?php

/*
Plugin Name: Sync Git Bitbucket
Plugin URI: http://tutran.me
Description: A brief description of the Plugin.
Version: 1.0
Author: tutv95
Author URI: http://tutran.me
License: A "Slug" license name e.g. GPL2
*/

// Register Custom Post Type
function thim_init_git_sync_server() {

    $labels = array(
        'name'                  => _x( 'Sync Git', 'Post Type General Name', 'thimpress' ),
        'singular_name'         => _x( 'Sync Git', 'Post Type Singular Name', 'thimpress' ),
        'menu_name'             => __( 'Sync Git', 'thimpress' ),
        'name_admin_bar'        => __( 'Sync Git', 'thimpress' ),
        'parent_item_colon'     => __( 'Parent Sync:', 'thimpress' ),
        'all_items'             => __( 'All Syncs', 'thimpress' ),
        'add_new_item'          => __( 'Add New Sync', 'thimpress' ),
        'add_new'               => __( 'Add Sync', 'thimpress' ),
        'new_item'              => __( 'New Sync', 'thimpress' ),
        'edit_item'             => __( 'Edit Sync', 'thimpress' ),
        'update_item'           => __( 'Update Sync', 'thimpress' ),
        'view_item'             => __( 'View Sync', 'thimpress' ),
        'search_items'          => __( 'Search Sync', 'thimpress' ),
        'not_found'             => __( 'Not found', 'thimpress' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'thimpress' ),
        'items_list'            => __( 'Syncs list', 'thimpress' ),
        'items_list_navigation' => __( 'Syncs list navigation', 'thimpress' ),
        'filter_items_list'     => __( 'Syncs items list', 'thimpress' ),
    );
    $args = array(
        'label'                 => __( 'Sync Git', 'thimpress' ),
        'description'           => __( 'Sync Git', 'thimpress' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor' ),
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 10,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
    );
    register_post_type( 'thim_git_sync_server', $args );

}
add_action( 'init', 'thim_init_git_sync_server', 0 );

require_once __DIR__ . '/functions.php';