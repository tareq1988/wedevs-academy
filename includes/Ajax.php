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
                'message' => 'Nonce verification failed!'
            ] );
        }

        wp_send_json_success([
            'message' => 'Enquiry has been sent successfully!'
        ]);
    }

    /**
     * Handle contact deletion
     *
     * @return void
     */
    public function delete_contact() {
        wp_send_json_success();
    }
}
