<?php
/**
 * PDF Generation for Solar Quote and EMI Calculator
 * 
 * This file handles the PDF generation functionality to allow users to download
 * a quote with their selected details and calculated EMI schedule.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include the FPDF library
if (!class_exists('FPDF')) {
    require_once SQE_PLUGIN_PATH . 'includes/fpdf.php'; // Ensure fpdf.php is placed in the includes directory
}

/**
 * Generate PDF for the calculated quote.
 * 
 * @param array $quote_details - Associative array containing quote details.
 * @param array $client_info - Associative array containing client information.
 */
function sqe_generate_quote_pdf($quote_details, $client_info) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Title
    $pdf->Cell(0, 10, 'Solar Project Quote and EMI Schedule', 0, 1, 'C');
    $pdf->Ln(10);

    // Client Details
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(50, 10, 'Client Email:', 0, 0);
    $pdf->Cell(0, 10, $client_info['email'], 0, 1);
    $pdf->Cell(50, 10, 'Contact Number:', 0, 0);
    $pdf->Cell(0, 10, $client_info['contact'], 0, 1);
    $pdf->Ln(10);

    // Quote Details
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'Quote Details', 0, 1);
    $pdf->SetFont('Arial', '', 12);

    $pdf->Cell(50, 10, 'Selected Model:', 0, 0);
    $pdf->Cell(0, 10, ucfirst($client_info['model']), 0, 1);

    $pdf->Cell(50, 10, 'Energy Storage:', 0, 0);
    $pdf->Cell(0, 10, $client_info['storage'], 0, 1);

    $pdf->Cell(50, 10, 'System Size (kW):', 0, 0);
    $pdf->Cell(0, 10, $client_info['system_size'] . ' kW', 0, 1);

    $pdf->Cell(50, 10, 'Loan Amount:', 0, 0);
    $pdf->Cell(0, 10, 'Rs. ' . number_format($quote_details['loan_amount'], 2), 0, 1);

    $pdf->Cell(50, 10, 'Monthly EMI:', 0, 0);
    $pdf->Cell(0, 10, 'Rs. ' . number_format($quote_details['emi'], 2), 0, 1);

    $pdf->Cell(50, 10, 'Total Payable:', 0, 0);
    $pdf->Cell(0, 10, 'Rs. ' . number_format($quote_details['total_payable'], 2), 0, 1);

    // Output PDF
    $pdf->Output('D', 'Solar_Quote_EMI_Schedule.pdf');
}

/**
 * Handle PDF download request.
 */
function sqe_handle_pdf_download() {
    if (isset($_POST['download_quote_pdf'])) {
        // Retrieve quote details and client info from POST data
        $quote_details = [
            'loan_amount' => sanitize_text_field($_POST['loan_amount']),
            'emi' => sanitize_text_field($_POST['emi']),
            'total_payable' => sanitize_text_field($_POST['total_payable'])
        ];
        $client_info = [
            'email' => sanitize_email($_POST['email']),
            'contact' => sanitize_text_field($_POST['contact']),
            'model' => sanitize_text_field($_POST['model']),
            'storage' => sanitize_text_field($_POST['storage']),
            'system_size' => sanitize_text_field($_POST['system_size'])
        ];

        sqe_generate_quote_pdf($quote_details, $client_info);
        exit;
    }
}
add_action('init', 'sqe_handle_pdf_download');
?>
