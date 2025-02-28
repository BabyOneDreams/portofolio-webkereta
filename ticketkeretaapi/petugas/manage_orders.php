<?php
// Termasuk file koneksi ke database
include('koneksi.php'); // Pastikan file ini berisi pengaturan koneksi DB Anda

// Query untuk mengambil data pemesanan dari database
$query = "SELECT pemesanan.id_pemesanan, pemesanan.tanggal_pemesanan, pembayaran.status_pembayaran, pemesanan.total_bayar
          FROM pemesanan
          INNER JOIN pembayaran ON pemesanan.id_pemesanan = pembayaran.id_pemesanan"; // Join antara tabel pemesanan dan pembayaran

$result = mysqli_query($conn, $query);

// Mengecek apakah ada data pemesanan yang ditemukan
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}

// Mengubah status pembayaran
if (isset($_GET['update_status']) && isset($_GET['id_pemesanan']) && isset($_GET['new_status'])) {
    $id_pemesanan = $_GET['id_pemesanan'];
    $new_status = $_GET['new_status'];

    $update_query = "UPDATE pembayaran SET status_pembayaran = '$new_status' WHERE id_pemesanan = $id_pemesanan";
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Status pembayaran berhasil diubah.'); window.location='manage_orders.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah status pembayaran.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - Petugas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2>Kelola Pemesanan</h2>
            </div>
            <div class="card-body">
                <!-- Tabel untuk menampilkan pemesanan -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID Pemesanan</th>
                            <th scope="col">Tanggal Pemesanan</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Total Harga</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mengecek jika ada data pemesanan dalam query
                        if (mysqli_num_rows($result) > 0) {
                            // Menampilkan setiap baris data pemesanan
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['id_pemesanan']) . "</td>
                                        <td>" . htmlspecialchars($row['tanggal_pemesanan']) . "</td>
                                        <td>" . htmlspecialchars($row['status_pembayaran']) . "</td>
                                        <td>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
                                        <td>
                                            <a href='?update_status=true&id_pemesanan=" . $row['id_pemesanan'] . "&new_status=Paid' class='btn btn-success btn-sm'>Setujui Pembayaran</a>
                                            <a href='?update_status=true&id_pemesanan=" . $row['id_pemesanan'] . "&new_status=Unpaid' class='btn btn-warning btn-sm'>Tunda Pembayaran</a>
                                        </td>
                                      </tr>";
                            }
                        } else {
                            // Menampilkan pesan jika tidak ada pemesanan
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada pemesanan yang ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-center">
                <a href="petugas_dashboard.php" class="btn btn-danger">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>

    <!-- Menutup koneksi ke database -->
    <?php mysqli_close($conn); ?>
</body>
</html>
