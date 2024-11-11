<?php
/**
 * Plugin Name: Solar Quote and EMI Calculator
 * Description: A WordPress plugin for generating solar project quotes and EMI schedules for different solar deployment models.
 * Version: 1.0
 * Author: Saqib Jawaid
 * License: MIT
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

ob_start(); // Start output buffering to handle any potential issues with output

// Define constants for plugin paths
define('SQE_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SQE_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once SQE_PLUGIN_PATH . 'includes/admin-settings.php';
require_once SQE_PLUGIN_PATH . 'includes/emi-calculation.php';
require_once SQE_PLUGIN_PATH . 'includes/frontend-form.php';
require_once SQE_PLUGIN_PATH . 'includes/pdf-generation.php';
require_once SQE_PLUGIN_PATH . 'includes/shortcodes.php';

/**
 * Activation hook - Runs when the plugin is activated
 */
function sqe_activate_plugin() {
    // Actions to perform upon plugin activation, if any
}
register_activation_hook(__FILE__, 'sqe_activate_plugin');

/**
 * Deactivation hook - Runs when the plugin is deactivated
 */
function sqe_deactivate_plugin() {
    // Actions to perform upon plugin deactivation, if any
}
register_deactivation_hook(__FILE__, 'sqe_deactivate_plugin');

/**
 * Initialize the plugin - Load assets and register shortcodes
 */
function sqe_initialize_plugin() {
    // Enqueue styles and scripts for frontend
    wp_enqueue_style('sqe-style', SQE_PLUGIN_URL . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'sqe_initialize_plugin');
add_action('admin_enqueue_scripts', 'sqe_initialize_plugin'); // Enqueue styles for admin as well

// Register shortcodes
sqe_register_shortcodes();

?>