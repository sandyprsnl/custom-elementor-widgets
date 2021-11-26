<?php
/*
Plugin Name: Custom Elementor Widgets
Plugin URI: https://sandyprsnl.github.io/aboutMe/
Author: Sandeep Bhardwaj
Author URI: https://sandyprsnl.github.io/aboutMe/
Description: Add Cusrom widgets in elementor and extend its widgets
Require at


*/

if(!defined('ABSPATH')) exit();

// Plugin URI for adding css and js files
define('CEW_PLUGIN_URI', plugin_dir_url(__FILE__));

//Plugin path for adding files
define('CEW_PLUGIN_PATH',plugin_dir_path(__FILE__));

if(file_exists(CEW_PLUGIN_PATH).'/classes/custom-widgets-loader.php'){
    require_once CEW_PLUGIN_PATH.'/classes/custom-widgets-loader.php';
}

CEW_widgets_Loader::instance();

// register_activation_hook(__FILE__,['CEW_widgets_Loader','instance']);

// function activate_CEW_plugin(){
//     CEW_widgets_Loader::instance();
// }

