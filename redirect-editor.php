<?php
/*
Plugin Name: Redirect Editor
Version: 1.3
Plugin URI: http://justinsomnia.org/2012/09/redirect-editor-plugin-for-wordpress/
Description: Centrally edit and manage <code>.htaccess</code>-style 301 redirects. Go to <a href="options-general.php?page=redirect-editor">Settings &gt; Redirect Editor</a> to configure.
Author: Justin Watt
Author URI: http://justinsomnia.org/

LICENSE
Copyright 2012 Justin Watt justincwatt@gmail.com

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

new Redirect_Editor_Plugin();
class Redirect_Editor_Plugin {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'save_data' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		add_action( 'pre_get_posts', array( $this, 'redirect' ) );
	}

	public function add_admin_menu() {
		add_options_page( 'Redirect Editor', 'Redirect Editor', 'manage_options', 'redirect-editor', array( $this, 'admin_page' ) );
	}

	public function admin_page() {
		$redirects = $this->get_setting('redirects_raw');
		require_once( 'form.php' );
	}

	function get_setting( $name, $default = '') {
		$settings = get_option( 'redirect_editor', array() );

		if ( !is_array( $settings ) ) {
			$settings = array();
		}

		if ( array_key_exists( $name, $settings ) ) {
			return $settings[$name];
		} else {
			return $default;
		}
	}

	// transform POSTed string data into array and save
	// format: /2012/09/old-post/ http://www.example.com/2012/09/new-post/
	function save_data() {
		// since this gets called in the admin_init action, we only want it to 
		// run if we're actually processing data for the redirect_editor
		if ( !isset( $_POST['function'] ) || $_POST['function'] != 'redirect-editor-save' ) {
			return;
		}

		if ( isset( $_POST['redirects'] ) && check_admin_referer( 'redirect-editor' ) ) {
			$redirects_raw = stripslashes( $_POST['redirects'] );

			# explode textarea on newline
			$redirect_lines = explode( "\n", $redirects_raw );

			$redirects = array();
			foreach ( $redirect_lines as $redirect_line ) {
				# clean up any extraneous spaces
				$redirect_line = preg_replace( '/\s+/', ' ', trim( $redirect_line ) );

				# skip lines that begin with '#' (hash), treat a comments
				if ( substr( $redirect_line, 0, 1 ) == '#' ) {
					continue;
				}

				# explode each line on space (there should only be one:
				# between the path to match and the destination url)
				$redirect_line = explode( " ", $redirect_line );

				# skip lines that aren't made up of exactly 2 strings, separated by a space
				# other than this, we don't do any validation
				if ( count( $redirect_line ) != 2 ) {
					continue;
				}
				$redirects[$redirect_line[0]] = $redirect_line[1];
			}

			$settings = array();
			$settings['redirects_raw'] = $redirects_raw;
			$settings['redirects'] = $redirects;

			update_option( 'redirect_editor', $settings );
		}

		// we can redirect here because save_data() is called in admin_init action
		wp_redirect( admin_url( 'options-general.php?page=redirect-editor' ) );
	}

	// it all comes down to this
	function redirect( $query ) {
		if ( $query->is_main_query() && ! is_admin() ) {
			$request_url = $_SERVER["REQUEST_URI"];
			$redirects = $this->get_setting( 'redirects', array() );

			if ( array_key_exists( $request_url, $redirects ) ) {
				wp_redirect( $redirects[$request_url], 301 );
				exit;
			}
		}
	}
}
