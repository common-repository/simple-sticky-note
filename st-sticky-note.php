<?php
/**
 * Plugin Name: Simple Sticky Note
 * Plugin URI: https://www.sharkthemes.com
 * Description: Add a instant short note, quote or any sensative short data for your self or everyone from frontend.
 * Version: 1.0.7
 * Author: Shark Themes
 * Author URI: https://sharkthemes.com
 * Requires at least: 5.0
 * Tested up to: 6.3
 *
 * Text Domain: sticky-note
 * Domain Path: /languages/
 *
 * @package Sticky Note
 * @category Core
 * @author Shark Themes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class ST_Sticky_Note {

	public function __construct()
	{
		$this->st_sticky_note_constant();
		$this->st_sticky_note_register();
		add_action( 'wp_enqueue_scripts', array( $this, 'st_sticky_note_enqueue' ) );
	}

	public function st_sticky_note_constant()
	{
		define( 'ST_STICKY_NOTE_BASE_PATH', dirname(__FILE__ ) );
		define( 'ST_STICKY_NOTE_URL_PATH', plugin_dir_url(__FILE__ ) );
		define( 'ST_STICKY_NOTE_PLUGIN_BASE_PATH', plugin_basename(__FILE__) );
		define( 'ST_STICKY_NOTE_PLUGIN_FILE_PATH', (__FILE__) );
	}


    private function st_sticky_note_register()
    {
    	include_once ST_STICKY_NOTE_BASE_PATH . '/include/post-type-sticky.php';
    	include_once ST_STICKY_NOTE_BASE_PATH . '/include/sticky-controls.php';
    	include_once ST_STICKY_NOTE_BASE_PATH . '/include/sticky-shortcode.php';
    }

    public function st_sticky_note_enqueue()
	{
		/*
		 * Enqueue scripts
		 */

        // Load style
        wp_enqueue_style( 'st-sticky-note', ST_STICKY_NOTE_URL_PATH . 'assets/css/style.css' );

        // Load script
        wp_enqueue_script( 'imagesloaded', '', array( 'jquery' ), '', true );

        // packery
        wp_enqueue_script( 'jquery-packery', ST_STICKY_NOTE_URL_PATH . 'assets/js/packery-mode.min.js', array( 'jquery' ), '2.1.1', true );

        // custom
        wp_enqueue_script( 'st-sticky-note-custom', ST_STICKY_NOTE_URL_PATH . 'assets/js/custom.min.js', array( 'jquery', 'imagesloaded', 'jquery-packery' ), '', true );

	}

}

new ST_Sticky_Note();
