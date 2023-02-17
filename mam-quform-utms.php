<?php
/**
 * Plugin Name: Move Ahead Media UTM To Forms
 * Plugin URI: https://github.com/moveaheadmedia/mam-utm-to-forms/
 * Description: The purpose of this plugin is to allow the website owner to track the UTM values of the users who submit the form, jQuery and Quform Hidden Field Names must be labeled `utm_source`, `utm_medium` and `utm_campaign`.
 * Version: 1.4
 * Author: Move Ahead Media
 * Author URI: https://github.com/moveaheadmedia
 * Requires jQuery and Quform Hidden Field Names must be labeled `utm_source`, `utm_medium` and `utm_campaign`.
 */

// enqueue plugin scripts
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_script(
		'js-cookie',
		'https://cdn.jsdelivr.net/npm/js-cookie@3.0.1/dist/js.cookie.min.js',
		'',
		'3.0.1'
	);
	wp_enqueue_script(
		'mam_utm_forms',
		plugin_dir_url( __FILE__ ) . '/scripts.js',
		[ 'jquery', 'js-cookie' ],
		'1.4'
	);

    // Send current domain to the scripts.js
    $mam_utm['site_url'] = site_url();
	wp_localize_script( 'mam_utm_forms', 'mam_utm', $mam_utm );

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
                <?php
                foreach ($utm_source as $element_name){
                ?>
                $('input[name="<?php echo $element_name; ?>"]').val(Cookies.get('user_utm_source'));
                <?php
                }
                foreach ($utm_medium as $element_name){
                ?>
                $('input[name="<?php echo $element_name; ?>"]').val(Cookies.get('user_utm_medium'));
                <?php
                }
                foreach ($utm_campaign as $element_name){
                ?>
                $('input[name="<?php echo $element_name; ?>"]').val(Cookies.get('user_utm_campaign'));
                <?php
                }
                ?>
            })
        });
    </script>
	<?php
} );