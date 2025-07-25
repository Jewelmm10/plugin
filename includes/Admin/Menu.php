<?php
namespace icon\starter\Admin;

class Menu {
    function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
    }

    public function add_menu() {
        add_menu_page( __( 'Header & Footer', 'iconStarter' ), __( 'Header & Footer', 'iconStarter' ), 'manage_options', 'ed', [ $this, 'callback_function' ], 'dashicons-welcome-learn-more', 3 );
    }
    public function callback_function() {
        echo '<h1>' . esc_html__( 'Welcome to Icon Starter', 'iconStarter' ) . '</h1>';
        
    }
}