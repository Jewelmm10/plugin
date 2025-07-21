<?php
namespace icon\starter\Admin;

class Menu {
    function __construct() {
        add_action( 'admin_menu', [ $this, 'add_menu' ] );
    }

    public function add_menu() {
        add_menu_page( __( 'Icon Starter', 'iconStarter' ), __( 'Icon Starter', 'iconStarter' ), 'manage_options', 'icon-starter', [ $this, 'callback_function' ], 'dashicons-welcome-learn-more' );
    }
    public function callback_function() {
        echo '<h1>' . esc_html__( 'Welcome to Icon Starter', 'iconStarter' ) . '</h1>';
        
    }
}