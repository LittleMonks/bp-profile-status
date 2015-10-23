<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BPPS_Main
 *
 * @author sanket
 */
class BPPS_Main {

    /*
     * variable declaration
     */

    var $bpps_suffix;

    /*
     * Constructor
     */

    public function __construct() {
        // Including functions file
        require_once BPPS_PATH . 'includes/functions/bp-profile-status-functions.php';

        $this->bpps_suffix = ( function_exists( 'bpps_get_script_style_suffix' ) ) ? bpps_get_script_style_suffix() : '.min';

        $this->bpps_load_translation();

        add_action( 'plugins_loaded', array( $this, 'bpps_class_construct' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'bpps_load_styles' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'bpps_load_scripts' ) );
    }

    /*
     * Loading translation
     */

    public function bpps_load_translation() {
        load_plugin_textdomain( 'bp-profile-status', false, basename( BPPS_PATH ) . '/languages/' );
    }

    /*
     * initializing classes
     */

    public function bpps_class_construct() {
        new BPPS_Profile_Status();
        new BPPS_Main_Ajax();
    }

    /*
     * Loading styles
     */

    public function bpps_load_styles() {
        wp_enqueue_style( 'bpps-main', BPPS_URL . 'includes/assets/css/bpps' . $this->bpps_suffix . '.css', '', BPPS_VERSION );
    }

    /*
     * Loading scripts
     */

    public function bpps_load_scripts() {
        wp_enqueue_script( 'bpps-main', BPPS_URL . 'includes/assets/js/bpps' . $this->bpps_suffix . '.js', array( 'jquery' ), BPPS_VERSION );

        $bpps_localize_array = array(
            'bpps_max_character_alert' => __( 'You have reached max character limit. \n\nPlease revise it.!', 'bp-profile-status' ),
            'bpps_update' => __( 'Update', 'bp-profile-status' ),
            'bpps_update_and_set_as_current' => __( 'Update & Set as Current', 'bp-profile-status' ),
            'bpps_delete_current_status_confirm' => __( 'Are you sure you want to delete current status?', 'bp-profile-status' ),
            'bpps_delete_current_status_success' => __( 'Current status deleted successfully.!', 'bp-profile-status' ),
            'bpps_no_current_status_set' => __( 'No current status is set yet.', 'bp-profile-status' ),
            'bpps_delete_status_confirm' => __( 'Are you sure you want to delete this status?', 'bp-profile-status' ),
            'bpps_status_delete_success' => __( 'Status deleted successfully.!', 'bp-profile-status' ),
            'bpps_status_set_success' => __( 'Status set successfully.!', 'bp-profile-status' )
        );

        wp_localize_script( 'bpps-main', 'bpps_main_js', $bpps_localize_array );
    }

}
