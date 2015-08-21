<?php

/*
	Advance Portfolio Grid
	By WPBean
	
*/


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 


//--------------- Adding Latest jQuery------------//
function wpb_fp_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'wpb_fp_jquery');


//-------------- include js files---------------//
function wpb_fp_adding_scripts() {
	wp_register_script('wpb-fp-magnific-popup', plugins_url('/assets/js/jquery.magnific-popup.min.js', __FILE__),array('jquery'),'1.0', false);
	wp_enqueue_script('wpb-fp-magnific-popup');	
}
add_action( 'wp_enqueue_scripts', 'wpb_fp_adding_scripts' ); 


//------------ include css files-----------------//
function wpb_fp_adding_style() {
	if ( !is_admin() ) {
		wp_register_style('wpb-fp-bootstrap-grid', plugins_url('/assets/css/wpb-custom-bootstrap.css', __FILE__),'','3.2');
		wp_register_style('wpb-fp-main', plugins_url('/assets/css/main.css', __FILE__),'','1.0');
		wp_register_style('wpb-fp-font-awesome', plugins_url('/assets/css/font-awesome.min.css', __FILE__),'','4.2.0');
		wp_register_style('wpb-fp-magnific-popup', plugins_url('/assets/css/magnific-popup.css', __FILE__),'','1.0');
		wp_register_style('wpb-fp-hover-effects', plugins_url('/assets/css/hover-effects.css', __FILE__),'','1.0');

		wp_enqueue_style('wpb-fp-bootstrap-grid');
		wp_enqueue_style('wpb-fp-font-awesome');
		wp_enqueue_style('wpb-fp-magnific-popup');
		wp_enqueue_style('wpb-fp-hover-effects');
		wp_enqueue_style('wpb-fp-main');
	}
}
add_action( 'wp_enqueue_scripts', 'wpb_fp_adding_style' );

/**
 * Adding Custom styles
 */

add_action( 'wpb_fp_after_portfolio','wpb_fp_custom_style' );
function wpb_fp_custom_style(){
	$wpb_fp_custom_style = wpb_fp_get_option( 'wpb_fp_custom_css_', 'wpb_fp_style', '' );
	if( isset($wpb_fp_custom_style) && !empty($wpb_fp_custom_style) ){
		?>
			<style type="text/css">
			<?php echo $wpb_fp_custom_style;?>
			</style>
		<?php
	}
}

