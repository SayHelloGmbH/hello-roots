<?php

namespace sayhello;

/**
 * Class GoogleAnalytics
 * This class provides an easy way to implement Google Analytics.
 * It adds as well an easy client side Opt-Out.
 */
class GoogleAnalytics {

	private $property_id = '';

	public function __construct() {
		$this->property_id = 'none';
	}

	public function set_property_id( $id ) {
		$this->property_id = $id;
	}

	public function run() {
		add_shortcode( 'gtag_checkbox', [ $this, 'gtag_checkox_func' ] );
		add_action( 'wp_head', [ $this, 'set_analytics_code' ] );
	}

	public function gtag_checkox_func( $atts ) {

		$atts = shortcode_atts( [
			'label' => '',
		], $atts, 'gtag_checkbox' );

		return "<label><input id='gtagOptOut' type='checkbox'>  {$atts['label']}</label>";
	}

	public function set_analytics_code() {

		$id = $this->property_id;
		if ( $this->is_valid_property( $id ) ) {
			$property_id = $id;
		} elseif ( $this->is_valid_property( get_field( $id, 'option' ) ) ) {
			$property_id = get_field( $id, 'option' );
		} elseif ( $this->is_valid_property( get_option( $id ) ) ) {
			$property_id = get_option( $id );
		} else {
			if ( is_user_logged_in() ) {
				echo "<!-- Google Analytics: invalid Property ID: {$id} -->";
			}

			return;
		}

		$script_url = "https://www.googletagmanager.com/gtag/js?id=$property_id";

		if ( is_user_logged_in() ) {
			echo "<!-- Google Analytics: Property ID {$property_id} ({$this->property_id}) -->";
		}
		?>

		<script async src="<?php echo $script_url; ?>"></script>
		<script>

			window.gtagTrackingID = '<?php echo $property_id; ?>';
			window.gtagDisableStr = 'gtag-disable-' + gtagTrackingID;
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}

			function gtagIsDisabled() {
				return (document.cookie.indexOf(gtagDisableStr + '=true') > -1);
			}

			function gtagToggleDisable() {
				if (gtagIsDisabled()) {
					document.cookie = gtagDisableStr + "=-10; path=/";
					window['ga-disable-' + gtagTrackingID] = false;
				} else {
					document.cookie = gtagDisableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
					window['ga-disable-' + gtagTrackingID] = true;
				}
			}

			window['ga-disable-' + gtagTrackingID] = gtagIsDisabled();

			gtag('js', new Date());
			gtag('config', gtagTrackingID, {
				'anonymize_ip': true
			});
		</script>
		<?php
	}

	public function is_valid_property( $id ) {
		return preg_match( '/^ua-\d{4,9}-\d{1,4}$/i', strval( $id ) );
	}
}
