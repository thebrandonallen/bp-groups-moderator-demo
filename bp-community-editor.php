<?php

/*
Plugin Name: BP Groups Moderator Demo
Plugin URI:  https://github.com/thebrandonallen/bp-groups-moderator-demo/
Description: A demo plugin utilizing new roles proposed in https://buddypress.trac.wordpress.org/ticket/5121.
Version:     0.1-alpha-bleeding-edge-alpha
Author:      Brandon Allen
Author URI:  https://github.com/thebrandonallen/
License:     GPL2+
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: bp-groups-moderator-demo
*/

function ba_allow_editors_to_manage_groups( $caps, $cap, $user_id, $args ) {

	switch ( $cap ) {

		case 'create_group'   :
		case 'edit_group'     :
		case 'delete_group'   :
		case 'view_group'     :
		case 'moderate_group' :
			if ( in_array( 'manage_options', $caps ) ) {
				$caps = array( 'delete_others_posts' );
			}
			break;

		case 'manage_groups' :
			$user = get_userdata( $user_id );
			if ( ! is_admin() && in_array( 'editor', $user->roles ) && in_array( 'manage_options', $caps ) ) {
				$caps = array( 'delete_others_posts' );
			}
			break;
	}

	return $caps;
}
add_filter( 'bp_groups_map_meta_caps', 'ba_allow_editors_to_manage_groups', 10, 4 );
