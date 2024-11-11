<?php
/**
 * Shortcode Registration for Solar Quote and EMI Calculator
 * 
 * This file registers shortcodes that allow the frontend form and PDF download
 * functionality to be used on any page or post.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Register all shortcodes.
 */
function sqe_register_shortcodes() {
    add_shortcode('sqe_frontend_form', 'sqe_frontend_form_shortcode');
    add_shortcode('sqe_download_quote_pdf', 'sqe_download_pdf_shortcode');
}

/**
 * Shortcode to display the frontend form.
 * 
 * Usage: [sqe_frontend_form]
 */
function sqe_frontend_form_shortcode() {
    return sqe_render_frontend_form();
}

/**
 * Shortcode to create a PDF download button.
 * 
 * Usage: [sqe_download_quote_pdf]
 */
function sqe_download_pdf_shortcode() {
    ob_start();
    ?>
    <form method="post" action="">
        <input type="hidden" name="loan_amount" value="<?php echo esc_attr($_POST['loan_amount']); ?>">
        <input type="hidden" name="emi" value="<?php echo esc_attr($_POST['emi']); ?>">
        <input type="hidden" name="total_payable" value="<?php echo esc_attr($_POST['total_payable']); ?>">
        <input type="hidden" name="email" value="<?php echo esc_attr($_POST['email']); ?>">
        <input type="hidden" name="contact" value="<?php echo esc_attr($_POST['contact']); ?>">
        <input type="hidden" name="model" value="<?php echo esc_attr($_POST['model']); ?>">
        <input type="hidden" name="storage" value="<?php echo esc_attr($_POST['storage']); ?>">
        <input type="hidden" name="system_size" value="<?php echo esc_attr($_POST['system_size']); ?>">
        <button type="submit" name="download_quote_pdf">Download Quote PDF</button>
    </form>
    <?php
    return ob_get_clean();
}
?>
