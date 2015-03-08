<?php 

/*
  Advance Portfolio Grid
  By WPBean
  
*/

/* Fire our meta box setup function on the post editor screen. */
add_action( 'load-post.php', 'wpb_fp_meta_boxes_setup' );
add_action( 'load-post-new.php', 'wpb_fp_meta_boxes_setup' );

/* Meta box setup function. */
function wpb_fp_meta_boxes_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'wpb_fp_add_portfolio_meta_boxes' );

  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'wpb_fp_save_portfolio_class_meta', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function wpb_fp_add_portfolio_meta_boxes() {
  $wpb_post_type_select = wpb_fp_get_option( 'wpb_post_type_select_', 'wpb_fp_advanced', 'wpb_fp_portfolio' );
  add_meta_box(
    'wpb_fp_portfolio_ex_link',      // Unique ID
    esc_html__( 'Portfolio External link', 'wpb_fp' ),    // Title
    'wpb_fp_portfolio_class_meta_box',   // Callback function
    $wpb_post_type_select, // Admin page (or post type)
    'side',          // Context
    'default'         // Priority
  );
}


/* Display the logo meta box. */
function wpb_fp_portfolio_class_meta_box( $object, $box ) { ?>
  <?php wp_nonce_field( basename( __FILE__ ), 'wpb_fp_portfolio_ex_link_nonce' ); ?>
  <p>
    <label for="wpb-fp-portfolio-url"><?php _e( "Portfolio external link, If not provided it will linking to single portfolio.", 'wpb_fp' ); ?></label>
  </p>
  <p>
    <input style="max-width:470px;" class="widefat" type="text" name="wpb-fp-portfolio-url" id="wpb-fp-portfolio-url" value="<?php echo esc_attr( get_post_meta( $object->ID, 'wpb_fp_portfolio_ex_link', true ) ); ?>"/>
  </p>
<?php }



/* Save the meta box's post metadata. */
function wpb_fp_save_portfolio_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['wpb_fp_portfolio_ex_link_nonce'] ) || !wp_verify_nonce( $_POST['wpb_fp_portfolio_ex_link_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  /* Get the posted data and sanitize it for use as an HTML class. */
  $new_meta_value = $_POST['wpb-fp-portfolio-url'];

  /* Get the meta key. */
  $meta_key = 'wpb_fp_portfolio_ex_link';

  /* Get the meta value of the custom field key. */
  $meta_value = get_post_meta( $post_id, $meta_key, true );

  /* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );
}

