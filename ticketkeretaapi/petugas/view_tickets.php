<?php
// Termasuk file koneksi ke database
include('koneksi.php'); // Pastikan file ini berisi pengaturan koneksi DB Anda

// Query untuk mengambil data tiket dari database
$query = "SELECT pemesanan.id_pemesanan, pemesanan.tanggal_pemesanan, pembayaran.status_pembayaran, pemesanan.total_bayar
          FROM pemesanan
          INNER JOIN pembayaran ON pemesanan.id_pemesanan = pembayaran.id_pemesanan"; // Join antara tabel pemesanan dan pembayaran

$result = mysqli_query($conn, $query);

// Mengecek apakah ada data tiket yang ditemukan
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Tickets - Petugas Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h2>Data Tiket yang Terdaftar</h2>
            </div>
            <div class="card-body">
                <!-- Tabel untuk menampilkan tiket -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">ID Pemesanan</th>
                            <th scope="col">Tanggal Pemesanan</th>
                            <th scope="col">Status Pembayaran</th>
                            <th scope="col">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Mengecek jika ada data tiket dalam query
                        if (mysqli_num_rows($result) > 0) {
                            // Menampilkan setiap baris data tiket
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>" . htmlspecialchars($row['id_pemesanan']) . "</td>
                                        <td>" . htmlspecialchars($row['tanggal_pemesanan']) . "</td>
                                        <td>" . htmlspecialchars($row['status_pembayaran']) . "</td>
                                        <td>" . number_format($row['total_bayar'], 0, ',', '.') . "</td>
                                      </tr>";
                            }
                        } else {
                            // Menampilkan pesan jika tidak ada data tiket
                            echo "<tr><td colspan='5' class='text-center'>Tidak ada tiket yang ditemukan.</td></tr>";
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
