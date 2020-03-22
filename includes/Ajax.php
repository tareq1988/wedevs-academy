<?php

namespace WeDevs\Academy;

/**
 * Ajax handler class
 */
class Ajax {

    /**
     * Class constructor
     */
    function __construct() {
        add_action( 'wp_ajax_wd_academy_enquiry', [ $this, 'submit_enquiry'] );
        add_action( 'wp_ajax_nopriv_wd_academy_enquiry', [ $this, 'submit_enquiry'] );

        add_action( 'wp_ajax_wd-academy-delete-contact', [ $this, 'delete_contact'] );
    }

    /**
     * Handle Enquiry Submission
     *
     * @return void
     */
    public function submit_enquiry() {

        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-ac-enquiry-form' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'wedevs-academy' )
            ] );
        }

        wp_send_json_success([
            'message' => __( 'Enquiry has been sent successfully!', 'wedevs-academy' )
        ]);
    }

    /**
     * Handle contact deletion
     *
     * @return void
     */
    public function delete_contact() {
        if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'wd-ac-admin-nonce' ) ) {
            wp_send_json_error( [
                'message' => __( 'Nonce verification failed!', 'wedevs-academy' )
            ] );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_send_json_error( [
                'message' => __( 'No permission!', 'wedevs-academy' )
            ] );
        }

        $id = isset( $_REQUEST['id'] ) ? intval( $_REQUEST['id'] ) : 0;
        wd_ac_delete_address( $id );

        wp_send_json_success();
    }
}
