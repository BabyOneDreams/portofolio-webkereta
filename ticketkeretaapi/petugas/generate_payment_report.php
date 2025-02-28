<?php
// Include database connection file
include('koneksi.php'); // Make sure this file contains your DB connection settings

// Function to generate and download the payment status report as CSV
function generatePaymentStatusReport($conn) {
    // Query to fetch payment data from the database (adjusted column names)
    $query = "SELECT id_pembayaran, id_pemesanan, tanggal_pembayaran, jumlah_bayar, metode_pembayaran, status_pembayaran, kode_pemesanan FROM pembayaran";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Set the headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="payment_status_report.csv"');

        // Open the output stream for CSV
        $output = fopen('php://output', 'w');
        
        // Column headers for the CSV file
        fputcsv($output, ['Payment ID', 'Order ID', 'Status', 'Amount Paid', 'Payment Date']);
        
        // Fetch and write each row of payment data to the CSV file
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }

        // Close the output stream
        fclose($output);
        exit();
    } else {
        echo "No payment records found!";
    }
}

// Trigger the report generation if the button is clicked
if (isset($_POST['generate_payment_report'])) {
    generatePaymentStatusReport($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Payment Status Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2>Generate Payment Status Report</h2>
            </div>
            <div class="card-body">
                <h3>Select a Report to Generate</h3>
                <form method="POST">
                    <div class="mb-3">
                        <!-- Button to trigger payment report generation -->
                        <button type="submit" name="generate_payment_report" class="btn btn-primary">Generate Payment Status Report (CSV)</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="petugas_dashboard.php" class="btn btn-danger">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
