<?php
/**
 * Plugin Name: Move Ahead Media UTM To Forms
 * Plugin URI: https://github.com/moveaheadmedia/mam-utm-to-forms/
 * Description: The purpose of this plugin is to allow the website owner to track the UTM values of the users who submit the form, jQuery and Quform Hidden Field Names must be labeled `utm_source`, `utm_medium` and `utm_campaign`.
 * Version: 1.3
 * Author: Move Ahead Media
 * Author URI: https://github.com/moveaheadmedia
 * Requires jQuery and Quform Hidden Field Names must be labeled `utm_source`, `utm_medium` and `utm_campaign`.
 */

// Save UTMs in cookies
add_action( 'wp', function () {
	$time = time() + ( 86400 * 30 );
	if ( isset( $_GET['utm_source'] ) && $_GET['utm_source'] != '' ) {
		setcookie( 'user_utm_source', $_GET['utm_source'], $time, "/" );
	} else {
		if ( ! isset( $_COOKIE['user_utm_source'] ) ) {
			setcookie( 'user_utm_source', 'Direct', $time, "/" );
		}
	}
	if ( isset( $_GET['utm_medium'] ) && $_GET['utm_medium'] != '' ) {
		setcookie( 'user_utm_medium', $_GET['utm_medium'], $time, "/" );
	} else {
		if ( ! isset( $_COOKIE['user_utm_medium'] ) ) {
			setcookie( 'user_utm_medium', '-', $time, "/" );
		}
	}
	if ( isset( $_GET['utm_campaign'] ) && $_GET['utm_campaign'] != '' ) {
		setcookie( 'user_utm_campaign', $_GET['utm_campaign'], $time, "/" );
	} else {
		if ( ! isset( $_COOKIE['user_utm_campaign'] ) ) {
			setcookie( 'user_utm_campaign', '-', $time, "/" );
		}
	}
} );

add_action( 'quform_pre_display', function ( Quform_Form $form ) {
	$utm_source   = [];
	$utm_medium   = [];
	$utm_campaign = [];

	/**
	 * @var $element Quform_Element
	 */
	foreach ( $form->getRecursiveIterator( RecursiveIteratorIterator::SELF_FIRST ) as $element ) {
		if ( $element->config( 'label' ) == 'utm_source' ) {
			$utm_source[] = $element->getName();
		}
		if ( $element->config( 'label' ) == 'utm_medium' ) {
			$utm_medium[] = $element->getName();
		}
		if ( $element->config( 'label' ) == 'utm_campaign' ) {
			$utm_campaign[] = $element->getName();
		}
	}
	?>
    <script>
        jQuery(document).ready(function ($) {
            $(window).load(function () {
                const currentDate = new Date();
                const timestamp = currentDate.getTime();
                var data = {
                    'action': 'mam_get_utm_cookies'
                };
                jQuery.post('<?php echo admin_url( 'admin-ajax.php' ); ?>?nocache=' + timestamp, data, function (response) {
                    var data = JSON.parse(response);
					<?php
					foreach ($utm_source as $element_name){
					?>
                    $('input[name="<?php echo $element_name; ?>"]').val(data.utm_source);
					<?php
					}
					foreach ($utm_medium as $element_name){
					?>
                    $('input[name="<?php echo $element_name; ?>"]').val(data.utm_medium);
					<?php
					}
					foreach ($utm_campaign as $element_name){
					?>
                    $('input[name="<?php echo $element_name; ?>"]').val(data.utm_campaign);
					<?php
					}
					?>
                });
            })
        });
    </script>
	<?php
} );


add_action( 'wp_ajax_mam_get_utm_cookies', 'mam_get_utm_cookies' );
add_action( 'wp_ajax_nopriv_mam_get_utm_cookies', 'mam_get_utm_cookies' );

function mam_get_utm_cookies() {
	$results               = [];
	$results['utm_source'] = 'Direct';
	if ( isset( $_COOKIE['user_utm_source'] ) ) {
		$results['utm_source'] = $_COOKIE['user_utm_source'];
	}
	$results['utm_medium'] = '-';
	if ( isset( $_COOKIE['user_utm_medium'] ) ) {
		$results['utm_medium'] = $_COOKIE['user_utm_medium'];
	}
	$results['utm_campaign'] = '-';
	if ( isset( $_COOKIE['user_utm_campaign'] ) ) {
		$results['utm_campaign'] = $_COOKIE['user_utm_campaign'];
	}
	echo json_encode( $results );
	die();
}
