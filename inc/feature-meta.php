<?php

// Feature Meta
function event_conference_bn_custom_meta_feature() {
    add_meta_box( 'bn_meta', __( 'Custom fields for Features', 'event-conference' ), 'event_conference_meta_callback_feature', 'post', 'normal', 'high' );
}

if (is_admin()){
  add_action('admin_menu', 'event_conference_bn_custom_meta_feature');
}

function event_conference_meta_callback_feature( $post ) {
    wp_nonce_field( basename( __FILE__ ), 'event_conference_feature_meta_nonce' );
    $bn_stored_meta = get_post_meta( $post->ID );
    $text1 = get_post_meta( $post->ID, 'event_conference_text_1', true );
    ?>
    <div id="feature">
        <table id="list">
            <tbody id="the-list" data-wp-lists="list:meta">
                <tr id="meta-1">
                    <td class="left">
                        <?php esc_html_e( 'Designation', 'event-conference' )?>
                    </td>
                    <td class="left">
                        <input type="text" name="event_conference_text_1" id="event_conference_text_1" value="<?php echo esc_attr($text1); ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
}

/* Saves the custom meta input */
function event_conference_bn_metadesig_save( $post_id ) {
    if (!isset($_POST['event_conference_feature_meta_nonce']) || !wp_verify_nonce( strip_tags( wp_unslash( $_POST['event_conference_feature_meta_nonce']) ), basename(__FILE__))) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Save
    if( isset( $_POST[ 'event_conference_text_1' ] ) ) {
        update_post_meta( $post_id, 'event_conference_text_1', strip_tags( wp_unslash( $_POST[ 'event_conference_text_1' ]) ) );
    }

}
add_action( 'save_post', 'event_conference_bn_metadesig_save' );