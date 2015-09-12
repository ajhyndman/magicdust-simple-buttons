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


require_once( plugin_dir_path( __FILE__ ).'/magicdust-button-widget.php' );


add_action( 'widgets_init', function(){
     register_widget( 'magicdust\Magicdust_Button_Widget' );
});