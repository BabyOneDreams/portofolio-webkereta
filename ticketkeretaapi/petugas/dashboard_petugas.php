<?php
// Include database connection file
include('koneksi.php'); // Modify this according to your DB connection setup

// Query to get total orders
$totalOrdersQuery = "SELECT COUNT(*) FROM pemesanan";
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrders = mysqli_fetch_row($totalOrdersResult)[0];

// Query to get total tickets sold (assuming total tiket = total order)
$totalTicketsSoldQuery = "SELECT SUM(total_bayar) FROM pemesanan";
$totalTicketsSoldResult = mysqli_query($conn, $totalTicketsSoldQuery);
$totalTicketsSold = mysqli_fetch_row($totalTicketsSoldResult)[0];

// Query to get pending reports (assuming 'status_pembayaran' with 'pending' status indicates pending reports)
$pendingReportsQuery = "SELECT COUNT(*) FROM pembayaran WHERE status_pembayaran = 'pending'";
$pendingReportsResult = mysqli_query($conn, $pendingReportsQuery);
$pendingReports = mysqli_fetch_row($pendingReportsResult)[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petugas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F9E6CF;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #69247C;
            color: white;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: #DA498D;
        }
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }
        .card-header {
            background-color: #DA498D;
            color: white;
        }
        .btn-custom {
            background-color: #FAC67A;
            color: black;
            border: none;
        }
        .btn-custom:hover {
            background-color: #F9E6CF;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h3 class="text-center">Petugas Panel</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_orders.php">Manage Orders</a>
        <a href="view_tickets.php">View Tickets</a>
        <a href="generate_reports.php">Generate Reports</a>
        <a href="logout.php" class="btn btn-custom text-center w-100 mt-3">Logout</a>
    </div>
    
    <div class="main-content">
        <div class="container">
            <div class="card">
                <div class="card-header text-center">
                    <h2>Welcome to Petugas Dashboard</h2>
                </div>
                <div class="card-body">
                    <h4>Quick Stats</h4>
                    <div class="row">
                    <div class="col-md-4">
                        <div class="card text-white bg-info mb-3">
                            <div class="card-header">Total Orders</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $totalOrders; ?></h5>
                                <p class="card-text">Orders processed this month.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="card text-white bg-success mb-3">
                            <div class="card-header">Total Tickets Sold</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $totalTicketsSold; ?></h5>
                                <p class="card-text">Tickets sold this month.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="card text-white bg-warning mb-3">
                            <div class="card-header">Pending Reports</div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $pendingReports; ?></h5>
                                <p class="card-text">Reports pending review.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
