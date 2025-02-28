<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi database sudah benar

// Cek apakah admin sudah login
if (!isset($_SESSION['nama_level']) || $_SESSION['nama_level'] !== 'admin') 

// Query untuk mendapatkan jumlah total penumpang
$queryPenumpang = mysqli_query($conn, "SELECT COUNT(*) AS total FROM penumpang");
$dataPenumpang = mysqli_fetch_assoc($queryPenumpang);
$totalPenumpang = $dataPenumpang['total'];

// Query untuk mendapatkan jumlah total pemesanan
$queryPemesanan = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pemesanan");
$dataPemesanan = mysqli_fetch_assoc($queryPemesanan);
$totalPemesanan = $dataPemesanan['total'];

// Query untuk mendapatkan jumlah total rute
$queryRute = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rute");
$dataRute = mysqli_fetch_assoc($queryRute);
$totalRute = $dataRute['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/styled.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 sidebar">
                <h3 class="text-center mb-4">Admin Panel</h3>
                <ul class="nav flex-column">
                    <li><a href="dashboard_admin.php"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="manage_users.php"><i class="fas fa-users"></i> Kelola Penumpang</a></li>
                    <li><a href="manage_transportasi.php"><i class="fas fa-bus"></i> Kelola Transportasi</a></li>
                    <li><a href="rute.php"><i class="fas fa-route"></i> Kelola Rute</a></li>
                    <li><a href="hasil_pembayaran.php"><i class="fas fa-credit-card"></i> Pembayaran</a></li>
                </ul>
                <div class="mt-4 text-center">
                    <a href="logout.php" class="btn btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 main-content">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">Dashboard Admin</h1>
                    </div>
                    <div class="card-body">
                        <!-- Profil Admin -->
                        <div class="admin-profile d-flex align-items-center mb-4">
                            <img src="../assets/img/2.jpeg" alt="Admin Profile" class="rounded-circle" width="60" height="60">
                            <div class="ml-3">
                                <h4>Admin: <?php echo $_SESSION['username']; ?></h4>
                                <p class="text-muted">Dashboard Administrator</p>
                            </div>
                        </div>

                        <!-- Statistik -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-users fa-3x mb-3 text-primary"></i>
                                        <h5 class="card-title">Total Penumpang</h5>
                                        <p class="card-text"><?php echo $totalPenumpang; ?> Orang</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-ticket-alt fa-3x mb-3 text-success"></i>
                                        <h5 class="card-title">Total Pemesanan</h5>
                                        <p class="card-text"><?php echo $totalPemesanan; ?> Tiket</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-route fa-3x mb-3 text-warning"></i>
                                        <h5 class="card-title">Total Rute</h5>
                                        <p class="card-text"><?php echo $totalRute; ?> Rute</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Menu Cepat -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-users fa-3x mb-3"></i>
                                        <h5 class="card-title">Kelola Penumpang</h5>
                                        <p class="card-text">Manajemen data penumpang sistem.</p>
                                        <a href="manage_users.php" class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-bus fa-3x mb-3"></i>
                                        <h5 class="card-title">Kelola Transportasi</h5>
                                        <p class="card-text">Manajemen data transportasi.</p>
                                        <a href="manage_transportasi.php" class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-route fa-3x mb-3"></i>
                                        <h5 class="card-title">Kelola Rute</h5>
                                        <p class="card-text">Manajemen data rute perjalanan.</p>
                                        <a href="rute.php" class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card text-center">
                                    <div class="card-body">
                                        <i class="fas fa-money-check-alt fa-3x mb-3"></i>
                                        <h5 class="card-title">Kelola Pembayaran</h5>
                                        <p class="card-text">Manajemen transaksi pembayaran.</p>
                                        <a href="hasil_pembayaran.php" class="btn btn-primary">Lihat Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>  
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
