<?php
/**
 * @package Magicdust Simple Buttons
 * @version 0.1
 */
/**
 * Plugin Name: Magicdust Simple Buttons
 * Plugin URI: https://github.com/ajhyndman/magicdust-simple-buttons
 * Description: A very basic button widget for WordPress. This widget is designed for the express purpose of making adding and removing simple, stylized links (links with a class) to sidebars more convenient for non-technical users.
 * Author: Andrew Hyndman
 * Version: 0.1
 * Author URI: https://github.com/ajhyndman
 */

namespace magicdust;

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );





/* Define and register the Magicdust Button widget. */

require_once( plugin_dir_path( __FILE__ ).'button-widget.php' );

add_action( 'widgets_init', function(){
	register_widget( 'magicdust\Button_Widget' );
});


/* Include the bundled CSS. */

function enqueue_button_scripts() {
	wp_enqueue_style( 'magicdust_button_stylesheet', plugins_url( 'buttons.css', __FILE__ ), '', 0.1 );
}
add_action( 'wp_enqueue_scripts', 'magicdust\enqueue_button_scripts' );