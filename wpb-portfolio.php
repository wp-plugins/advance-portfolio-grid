<?php

/*
    Advance Portfolio Grid
    By WPBean
    
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 



if ( ! function_exists('wpb_fp_post_type_select') ) {

	// Getting all custom post type avaiable for portfolio plugin

	function wpb_fp_post_type_select(){

		$args = array(
		   	'public'   => true,
   			'_builtin' => false
		);

		$rerutn_object = get_post_types( $args );
		//$rerutn_object['post'] = 'Post';

		return $rerutn_object;
	}

}

if ( ! function_exists('wpb_fp_taxonomy_select') ) {

	// Getting all custom taxonomy avaiable for portfolio plugin

	function wpb_fp_taxonomy_select(){
		$taxonomy = array();
		$wpb_fp_post_type = wpb_fp_get_option( 'wpb_post_type_select_', 'wpb_fp_advanced', 'wpb_fp_portfolio' );
		$taxonomy_objects = get_object_taxonomies( $wpb_fp_post_type, 'objects' );
		foreach ($taxonomy_objects as $taxonomy_object) {
			$taxonomy[$taxonomy_object->name] = $taxonomy_object->label;
		}

		return $taxonomy;
	}

}


if ( ! function_exists('wpb_fp_exclude_categories') ) {

	// Exclude selected categiry form portfolio.

	function wpb_fp_exclude_categories(){
		$terms = $category_link = array();
		$wpb_fp_post_type = wpb_fp_get_option( 'wpb_post_type_select_', 'wpb_fp_advanced', 'wpb_fp_portfolio' );
		$taxonomy_objects = get_object_taxonomies( $wpb_fp_post_type, 'objects' );

		if( isset($taxonomy_objects) && !empty($taxonomy_objects) ){
		 	$wpb_fp_taxonomy = wpb_fp_get_option( 'wpb_taxonomy_select_', 'wpb_fp_advanced', 'wpb_fp_portfolio_cat' );
		    $terms = get_terms($wpb_fp_taxonomy);
		    foreach ( $terms as $term ) {
		        $category_link[$term->term_id] = $term->name;
		    }                                         
	      
	    }
	    return $category_link;
	}

}