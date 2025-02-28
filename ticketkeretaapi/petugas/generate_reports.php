<?php
// Include database connection file
include('koneksi.php'); // Modify this according to your DB connection setup

// Function to generate and download report in CSV format
function generateOrderReport($conn) {
    // Query to fetch all orders
    $query = "SELECT * FROM pemesanan";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Start output buffering to capture CSV content
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="order_report.csv"');
        
        $output = fopen('php://output', 'w');
        // Column headers
        fputcsv($output, ['Order ID', 'Customer Name', 'Total Price', 'Order Date']);
        
        // Fetch rows and write to CSV
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        
        fclose($output);
        exit();
    } else {
        echo "No orders found!";
    }
}

// Trigger report generation if the button is clicked
if (isset($_POST['generate_report'])) {
    generateOrderReport($conn);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2>Generate Reports</h2>
            </div>
            <div class="card-body">
                <h3>Select a Report to Generate</h3>
                <form method="POST">
                    <div class="mb-3">
                        <button type="submit" name="generate_report" class="btn btn-primary">Generate Orders Report (CSV)</button>
                    </div>
                </form>

                <!-- You can add more report options here -->
                <hr>
                <h5>Other Report Options</h5>
                <ul>
                    <li><a href="generate_payment_report.php" class="btn btn-secondary">Generate Payment Status Report</a></li>
                    <!-- Add more reports as needed -->
                </ul>
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
