<?php
/**
 * Admin Settings for Solar Quote and EMI Calculator
 * 
 * This file creates an options page in the WordPress admin where administrators can 
 * input the necessary backend data for EMI calculations, such as loan interest rate, 
 * system cost, and other configuration values.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Registers the admin menu for Solar Quote and EMI Settings.
 */
function sqe_register_admin_menu() {
    add_menu_page(
        'Solar Quote EMI Settings',
        'Solar Quote EMI',
        'manage_options',
        'solar-quote-emi-settings',
        'sqe_render_admin_settings_page',
        'dashicons-admin-generic',
        100
    );
}
add_action('admin_menu', 'sqe_register_admin_menu');

/**
 * Renders the admin settings page for the plugin.
 */
function sqe_render_admin_settings_page() {
    ?>
    <div class="wrap">
        <h1>Solar Quote and EMI Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('sqe_settings_group');
            do_settings_sections('solar-quote-emi-settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}

/**
 * Initializes and registers the plugin settings.
 */
function sqe_initialize_settings() {
    register_setting('sqe_settings_group', 'sqe_system_cost');
    register_setting('sqe_settings_group', 'sqe_interest_rate');
    register_setting('sqe_settings_group', 'sqe_tenure_options');
    register_setting('sqe_settings_group', 'sqe_maintenance_cost');
    register_setting('sqe_settings_group', 'sqe_carbon_offset');

    add_settings_section(
        'sqe_main_settings_section',
        'Main Settings',
        'sqe_main_settings_section_callback',
        'solar-quote-emi-settings'
    );

    add_settings_field(
        'sqe_system_cost',
        'System Cost (Including Installation and Taxes)',
        'sqe_render_system_cost_field',
        'solar-quote-emi-settings',
        'sqe_main_settings_section'
    );

    add_settings_field(
        'sqe_interest_rate',
        'Base Interest Rate',
        'sqe_render_interest_rate_field',
        'solar-quote-emi-settings',
        'sqe_main_settings_section'
    );

    add_settings_field(
        'sqe_tenure_options',
        'Loan Tenure Options (Years, comma-separated)',
        'sqe_render_tenure_options_field',
        'solar-quote-emi-settings',
        'sqe_main_settings_section'
    );

    add_settings_field(
        'sqe_maintenance_cost',
        'Maintenance & Warranty Costs',
        'sqe_render_maintenance_cost_field',
        'solar-quote-emi-settings',
        'sqe_main_settings_section'
    );

    add_settings_field(
        'sqe_carbon_offset',
        'Carbon Offset Information (optional)',
        'sqe_render_carbon_offset_field',
        'solar-quote-emi-settings',
        'sqe_main_settings_section'
    );
}
add_action('admin_init', 'sqe_initialize_settings');

/**
 * Callback for the main settings section.
 */
function sqe_main_settings_section_callback() {
    echo '<p>Enter the values required for EMI calculations and quotes.</p>';
}

/**
 * Renders the System Cost input field.
 */
function sqe_render_system_cost_field() {
    $value = esc_attr(get_option('sqe_system_cost', ''));
    echo '<input type="number" name="sqe_system_cost" value="' . $value . '" step="0.01" />';
}

/**
 * Renders the Interest Rate input field.
 */
function sqe_render_interest_rate_field() {
    $value = esc_attr(get_option('sqe_interest_rate', ''));
    echo '<input type="number" name="sqe_interest_rate" value="' . $value . '" step="0.01" /> %';
}

/**
 * Renders the Tenure Options input field.
 */
function sqe_render_tenure_options_field() {
    $value = esc_attr(get_option('sqe_tenure_options', '1,3,5,10'));
    echo '<input type="text" name="sqe_tenure_options" value="' . $value . '" />';
    echo '<p class="description">Enter tenure options in years, separated by commas (e.g., 1,3,5,10).</p>';
}

/**
 * Renders the Maintenance & Warranty Costs input field.
 */
function sqe_render_maintenance_cost_field() {
    $value = esc_attr(get_option('sqe_maintenance_cost', ''));
    echo '<input type="number" name="sqe_maintenance_cost" value="' . $value . '" step="0.01" />';
}

/**
 * Renders the Carbon Offset Information input field.
 */
function sqe_render_carbon_offset_field() {
    $value = esc_attr(get_option('sqe_carbon_offset', ''));
    echo '<input type="text" name="sqe_carbon_offset" value="' . $value . '" />';
    echo '<p class="description">Optional: Specify the estimated CO₂ offset per year.</p>';
}
?>