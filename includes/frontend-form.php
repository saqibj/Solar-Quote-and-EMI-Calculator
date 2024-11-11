<?php
/**
 * Frontend Form and Quote Display for Solar Quote and EMI Calculator
 * 
 * This file renders a form on the frontend where clients can input their desired options
 * for the solar installation. It then displays the calculated quote and EMI schedule.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Render the frontend form.
 */
function sqe_render_frontend_form() {
    // Get admin-configured values
    $system_cost = get_option('sqe_system_cost');
    $interest_rate = get_option('sqe_interest_rate');
    $tenure_options = explode(',', get_option('sqe_tenure_options'));

    // HTML Form
    ob_start();
    ?>
    <div class="sqe-quote-form">
        <form method="post" action="">
            <h2>Solar Project Quote and EMI Calculator</h2>
            <label for="model">Select Model:</label>
            <select name="model" id="model" required>
                <option value="off-grid">Off Grid</option>
                <option value="net-metering">Net Metering</option>
                <option value="hybrid">Hybrid</option>
            </select>

            <label for="storage">Energy Storage (Batteries):</label>
            <input type="checkbox" name="storage" id="storage" value="yes"> Yes

            <label for="system_size">System Size (kW):</label>
            <input type="number" name="system_size" id="system_size" step="0.1" required>

            <label for="downpayment">Downpayment Percentage:</label>
            <input type="number" name="downpayment" id="downpayment" step="0.1" required>

            <label for="tenure">Loan Tenure (Years):</label>
            <select name="tenure" id="tenure" required>
                <?php foreach ($tenure_options as $tenure) : ?>
                    <option value="<?php echo esc_attr(trim($tenure)); ?>"><?php echo esc_html(trim($tenure)); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="email">Email Address:</label>
            <input type="email" name="email" id="email" required>

            <label for="contact">Contact Number:</label>
            <input type="text" name="contact" id="contact" required>

            <button type="submit" name="sqe_calculate_quote">Get Quote</button>
        </form>
    </div>

    <?php
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sqe_calculate_quote'])) {
        $model = sanitize_text_field($_POST['model']);
        $storage = isset($_POST['storage']) ? 'Yes' : 'No';
        $system_size = floatval($_POST['system_size']);
        $downpayment = floatval($_POST['downpayment']);
        $tenure = intval($_POST['tenure']);

        // Calculate quote details using EMI functions
        $quote_details = sqe_generate_quote_details($system_cost, $interest_rate, $downpayment, $tenure);

        ?>
        <div class="sqe-quote-result">
            <h3>Your Quote Details</h3>
            <p><strong>Selected Model:</strong> <?php echo esc_html(ucfirst($model)); ?></p>
            <p><strong>Energy Storage:</strong> <?php echo esc_html($storage); ?></p>
            <p><strong>System Size:</strong> <?php echo esc_html($system_size); ?> kW</p>
            <p><strong>Loan Amount:</strong> Rs. <?php echo number_format($quote_details['loan_amount'], 2); ?></p>
            <p><strong>Monthly EMI:</strong> Rs. <?php echo number_format($quote_details['emi'], 2); ?></p>
            <p><strong>Total Payable:</strong> Rs. <?php echo number_format($quote_details['total_payable'], 2); ?></p>
        </div>
        <?php
    }
    return ob_get_clean();
}

/**
 * Shortcode to display the frontend form.
 */
function sqe_frontend_form_shortcode() {
    return sqe_render_frontend_form();
}
add_shortcode('sqe_frontend_form', 'sqe_frontend_form_shortcode');
?>
