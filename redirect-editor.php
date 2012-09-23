<?php
/*
Plugin Name: Redirect Editor
Version: 1.0
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

		add_action( 'admin_init', array( &$this, 'save_data' ) );

		add_action( 'admin_menu', array( &$this, 'add_admin_menu' ) );

		add_action( 'pre_get_posts', array( &$this, 'redirect_editor' ) );
	}

	public function add_admin_menu() {
		add_options_page( 'Redirect Editor', 'Redirect Editor', 'manage_options', 'redirect-editor', array( &$this, 'admin_page' ) );
	}

	public function admin_page() {
		$redirects = $this->load_data();
		require_once( 'form.php' );
	}

	// get saved data and transform into string
	function load_data() {
		$redirects_array = get_option( 'redirect_editor' );
		$redirects = '';
		foreach ( $redirects_array as $key => $value ) {
			$redirects .= $key . ' ' . $value . "\n";
		}
		return $redirects;
	}

	// transform POSTed string data in array and save
	// format: /2012/09/old-post/ http://www.example.com/2012/09/new-post/
	function save_data() {
		if ( !isset( $_POST['function'] ) || !check_admin_referer( 'redirect-editor' ) ) {
			return false;
		}

		if ( isset( $_POST['redirects']) ) {
			# explode textarea on newline
			$redirect_lines = explode( "\n", $_POST['redirects'] );

			# explode each line on space
			$redirects_array = array();
			foreach ( $redirect_lines as $redirect_line ) {
				$redirect_line = explode( " ", preg_replace( '/\s+/', ' ', trim( $redirect_line ) ), 2 );
				if ( count( $redirect_line ) != 2 ) {
					continue;
				}
				$redirects_array[$redirect_line[0]] = $redirect_line[1];
			}

			update_option( 'redirect_editor', $redirects_array );
		}

		// we can redirect here because save_data is called in admin_init action
		wp_redirect( admin_url( 'options-general.php?page=redirect-editor' ) );
	}

	// it all comes down to this
	function redirect_editor( $query ) {
		$request_url = $_SERVER["REQUEST_URI"];
		$redirects = get_option( 'redirect_editor' );

		if ( array_key_exists( $request_url, $redirects ) ) {
			wp_redirect( $redirects[$request_url], 301 );
			exit;
		}
	}
}
