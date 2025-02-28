<?php
session_start();

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .main-content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h3 class="text-center mb-4">Admin Panel</h3>
                <ul class="nav flex-column">
                    <li><a href="manage_users.php"><i class="fas fa-users"></i> Kelola Pengguna</a></li>
                    <li><a href="manage_transportasi.php"><i class="fas fa-bus"></i> Kelola Transportasi</a></li>
                    <li><a href="rute.php"><i class="fas fa-route"></i> Kelola Rute</a></li>
                    <li><a href="hasil_pembayaran.php"><i class="fas fa-credit-card"></i> Pembayaran</a></li>
                    <li><a href="reports.php"><i class="fas fa-chart-line"></i> Reports</a></li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Admin - Reports</h1>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center">Report Overview</h2>
                        <p>Here, the Admin can view various system reports such as transport usage, financial reports, and user activities.</p>
                        <!-- Add Dynamic Report Content Here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
