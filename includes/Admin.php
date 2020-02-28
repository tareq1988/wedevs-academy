<?php

namespace WeDevs\Academy;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        $this->dispatch_actions();

        new Admin\Menu();
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions() {
        $addressbook = new Admin\Addressbook();

        add_action( 'admin_init', [ $addressbook, 'form_handler' ] );
    }
}
