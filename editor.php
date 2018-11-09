<?php
function return_policy_rh()
	{
		add_meta_box(
		    'returnpolicy_rh_id',
		    'Return Policy',
		    'rh_return_policy',  // Content callback, must be of type callable
		    'product', 
		    'normal',
		    'default'
		);
	}
add_action('add_meta_boxes', 'return_policy_rh');


function rh_return_policy( $post ) {


	wp_nonce_field( 'return_policy_metabox_nonce', 'return_policy_nonce' ); 

    $return_policy_meta_box_editor = get_post_meta( $post->ID, 'return-policy-meta-box', true );

    wp_editor( htmlspecialchars_decode($return_policy_meta_box_editor), 'return-policy-meta-box', $settings = array('textarea_name'=>'return_textarea_rh','textarea_rows'=>'get_option('default_post_edit_rows', 5)') );
}

function return_policy_save_meta($post_id) {



    if( !isset( $_POST['return_policy_nonce'] ) || !wp_verify_nonce( $_POST['return_policy_nonce'],'return_policy_metabox_nonce') )
        return;

    if ( !current_user_can( 'edit_post', $post_id ))
        return;

    if ( isset($_POST['return_textarea_rh']) ) {
        update_post_meta($post_id, 'return-policy-meta-box', sanitize_text_field($_POST['return_textarea_rh']));
    }


}
add_action('save_post', 'return_policy_save_meta');
?>