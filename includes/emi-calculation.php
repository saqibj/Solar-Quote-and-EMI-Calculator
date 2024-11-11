<?php
/**
 * EMI Calculation Logic for Solar Quote and EMI Calculator
 * 
 * This file contains functions to calculate EMI based on loan tenure, interest rate,
 * system cost, downpayment, and other factors provided by the admin and the user.
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Calculate EMI based on provided parameters.
 * 
 * @param float $loan_amount - Total loan amount after downpayment.
 * @param float $annual_interest_rate - Annual interest rate in percentage.
 * @param int $tenure_years - Loan tenure in years.
 * @return float - Monthly EMI amount.
 */
function sqe_calculate_emi($loan_amount, $annual_interest_rate, $tenure_years) {
    $monthly_interest_rate = ($annual_interest_rate / 100) / 12;
    $num_payments = $tenure_years * 12;

    if ($monthly_interest_rate == 0) {
        return $loan_amount / $num_payments; // No interest case
    }

    // EMI formula: E = P * r * (1 + r)^n / ((1 + r)^n - 1)
    $emi = $loan_amount * $monthly_interest_rate * pow(1 + $monthly_interest_rate, $num_payments) /
           (pow(1 + $monthly_interest_rate, $num_payments) - 1);

    return round($emi, 2);
}

/**
 * Get loan amount after considering downpayment.
 * 
 * @param float $system_cost - Total system cost.
 * @param float $downpayment_percentage - Downpayment percentage provided by user.
 * @return float - Calculated loan amount.
 */
function sqe_get_loan_amount($system_cost, $downpayment_percentage) {
    $downpayment_amount = ($downpayment_percentage / 100) * $system_cost;
    return $system_cost - $downpayment_amount;
}

/**
 * Calculate the total payable amount over the loan tenure.
 * 
 * @param float $emi - Monthly EMI amount.
 * @param int $tenure_years - Loan tenure in years.
 * @return float - Total amount payable over the loan period.
 */
function sqe_calculate_total_payable($emi, $tenure_years) {
    return round($emi * $tenure_years * 12, 2);
}

/**
 * Main function to calculate all financial details for the quote.
 * 
 * @param float $system_cost - System cost including installation and taxes.
 * @param float $annual_interest_rate - Annual interest rate as defined by the admin.
 * @param float $downpayment_percentage - Downpayment percentage from the user input.
 * @param int $tenure_years - Loan tenure in years chosen by the user.
 * @return array - Associative array with EMI, loan amount, and total payable amount.
 */
function sqe_generate_quote_details($system_cost, $annual_interest_rate, $downpayment_percentage, $tenure_years) {
    $loan_amount = sqe_get_loan_amount($system_cost, $downpayment_percentage);
    $emi = sqe_calculate_emi($loan_amount, $annual_interest_rate, $tenure_years);
    $total_payable = sqe_calculate_total_payable($emi, $tenure_years);

    return [
        'loan_amount' => $loan_amount,
        'emi' => $emi,
        'total_payable' => $total_payable
    ];
}
?>