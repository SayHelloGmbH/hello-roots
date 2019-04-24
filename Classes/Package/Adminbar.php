<?php

namespace SayHello\Theme\Package;

/**
 * Admin bar stuff
 *
 * @author Joel Stüdle <joel@sayhello.ch>
 */
class Adminbar {


	public function run() {
		add_action( 'get_header', [ $this, 'removeAdminBarStyles' ] );
		add_action( 'wp_head', [ $this, 'customAdminBarStyles' ] );
	}

	/**
	 * Removes admin bar styles
	 */
	public function removeAdminBarStyles() {
		remove_action( 'wp_head', '_admin_bar_bump_cb' );
	}

	/**
	 * adds custom admin bar styles
	 */
	public function customAdminBarStyles() {
		if ( is_user_logged_in() ) {
			echo '<style>
			#wpadminbar {
				top: -30px;
				height: 40px;
				background: none;
				transition: top 0.1s ease-out;
			}

			#wpadminbar:hover {
				top: 0;
			}

			#wp-toolbar {
				background: #23282d;
				height: 32px;
			}

			@media screen and (max-width: 782px) {
				html #wpadminbar {
					top: -46px;
					height: 50px;
				}

				html #wp-toolbar {
					height: 46px;
				}
			}
		</style>';
		}
	}
}
