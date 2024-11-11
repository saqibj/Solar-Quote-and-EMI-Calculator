**Solar Quote and EMI Calculator**

**Version:** 1.0  
**Author:** Saqib Jawaid  
**License:** MIT

**Description**

The **Solar Quote and EMI Calculator** is a WordPress plugin that enables site administrators to generate detailed solar project quotes and EMI schedules for different solar deployment models: Off Grid, Net Metering, and Hybrid. Clients can fill out a form with their requirements and receive a customized quote, including an EMI schedule and the option to download the quote as a PDF.

**Installation**

1.  **Download or Clone** the plugin into the WordPress plugins directory:

    -   Path: wp-content/plugins/solar-quote-emi

2.  **Activate the Plugin**:

    -   Go to **WordPress Dashboard** \> **Plugins**.

    -   Find **Solar Quote and EMI Calculator** in the list and click **Activate**.

3.  **Dependencies**:

    -   The plugin uses the FPDF library for PDF generation. Ensure fpdf.php is in the includes folder.

**Usage Manual**

**1. Admin Setup**

Once the plugin is activated, you'll need to configure it via the admin settings.

-   Navigate to **Solar Quote EMI** in the WordPress admin sidebar.

-   Fill in the required settings for EMI and quote generation:

    -   **System Cost**: The total cost of the solar panel system, including installation and taxes.

    -   **Interest Rate**: The base interest rate to be applied to financing.

    -   **Loan Tenure Options**: Define loan tenures in years, separated by commas (e.g., 1,3,5,10).

    -   **Maintenance & Warranty Costs**: Any additional maintenance costs for the project.

    -   **Carbon Offset Information**: Optional environmental impact assessment (CO₂ offset per year).

Click **Save** when done. These values will be used as the basis for client quotes.

**2. Adding the Frontend Form**

Add the client-facing form to any page or post using the following shortcode:

[sqe_frontend_form]

This will display a form where clients can input the following details:

-   **Model Type**: Select from Off Grid, Net Metering, or Hybrid.

-   **Energy Storage**: Option to include batteries.

-   **System Size**: Define the system's size in kW.

-   **Downpayment**: Specify downpayment percentage.

-   **Tenure**: Choose the desired loan tenure.

-   **Contact Information**: Provide email and phone number.

Once submitted, the form will display a quote including:

-   **Loan Amount**

-   **Monthly EMI**

-   **Total Payable**

**3. PDF Download**

To enable clients to download their quote as a PDF, add the following shortcode:

[sqe_download_quote_pdf]

This will add a **Download Quote PDF** button, allowing users to save the quote with EMI details in a PDF format.

**Additional Shortcodes**

1.  **Quote Form**: [sqe_frontend_form]

2.  **PDF Download Button**: [sqe_download_quote_pdf]

**Troubleshooting**

-   **No PDF Download**: Ensure fpdf.php is included in the includes folder and is accessible.

-   **Output Display Issues**: The plugin uses ob_start() to handle potential buffering issues. If problems persist, check theme and other plugin compatibility.

**License**

This plugin is licensed under the MIT License. See LICENSE for more details.
