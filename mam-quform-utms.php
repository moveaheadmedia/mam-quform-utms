<?php
/**
 * Plugin Name: Move Ahead Media UTM To Forms
 * Plugin URI: https://github.com/moveaheadmedia/mam-utm-to-forms/
 * Description: This plugin helps users to get utm data into contact forms hidden fields!
 * Version: 1.2
 * Author: Move Ahead Media
 * Author URI: https://github.com/moveaheadmedia
 * Requires jQuery to be installed and ACF Pro plugin
 */

// Save UTMs in session
add_action('wp', function () {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (isset($_GET['utm_source']) && $_GET['utm_source'] != '') {
        $_SESSION['user_utm_source'] = $_GET['utm_source'];
    }else{
        if(!isset($_SESSION['user_utm_source'])){
            $_SESSION['user_utm_source'] = 'Direct';
        }
    }
    if (isset($_GET['utm_medium']) && $_GET['utm_medium'] != '') {
        $_SESSION['user_utm_medium'] = $_GET['utm_medium'];
    }else{
        if(!isset($_SESSION['user_utm_medium'])){
            $_SESSION['user_utm_medium'] = '-';
        }
    }
    if (isset($_GET['utm_campaign']) && $_GET['utm_campaign'] != '') {
        $_SESSION['user_utm_campaign'] = $_GET['utm_campaign'];
    }else{
        if(!isset($_SESSION['user_utm_campaign'])){
            $_SESSION['user_utm_campaign'] = '-';
        }
    }
});

add_action('quform_pre_display', function (Quform_Form $form) {
    if (!isset($_SESSION)) {
        session_start();
    }

    $utm_source = [];
    $utm_medium = [];
    $utm_campaign = [];

    /**
     * @var $element Quform_Element
     */
    foreach ($form->getRecursiveIterator(RecursiveIteratorIterator::SELF_FIRST) as $element) {
        if ($element->config('label') == 'utm_source') {
            $utm_source[] = $element->getName();
        }
        if ($element->config('label') == 'utm_medium') {
            $utm_medium[] = $element->getName();
        }
        if ($element->config('label') == 'utm_campaign') {
            $utm_campaign[] = $element->getName();
        }
    }
    ?>
    <script>
        jQuery(document).ready(function($){
            $(window).load(function(){
                var data = {
                    'action': 'mam_get_session'
                };
                jQuery.post('<?php echo admin_url( 'admin-ajax.php' ); ?>', data, function(response) {
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
});


add_action( 'wp_ajax_mam_get_session', 'mam_get_session' );
add_action( 'wp_ajax_nopriv_mam_get_session', 'mam_get_session' );

function mam_get_session(){
    if (!isset($_SESSION)) {
        session_start();
    }
    $results = [];
    $results['utm_source'] = $_SESSION['user_utm_source'];
    $results['utm_medium'] = $_SESSION['user_utm_medium'];
    $results['utm_campaign'] = $_SESSION['user_utm_campaign'];
    echo json_encode($results);
    die();
}
