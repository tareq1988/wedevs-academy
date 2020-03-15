<?php

namespace WeDevs\Academy\Frontend;

/**
 * Shortcode handler class
 */
class Enquiry {

    /**
     * Initializes the class
     */
    function __construct() {
        add_shortcode( 'academy-enquiry', [ $this, 'render_shortcode' ] );
    }

    /**
     * Shortcode handler class
     *
     * @param  array $atts
     * @param  string $content
     *
     * @return string
     */
    public function render_shortcode( $atts, $content = '' ) {
        wp_enqueue_script( 'academy-enquiry-script' );
        wp_enqueue_style( 'academy-enquiry-style' );

        ob_start();
        include __DIR__ . '/views/enquiry.php';

        return ob_get_clean();
    }
}
