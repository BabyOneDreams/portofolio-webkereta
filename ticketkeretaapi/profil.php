<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penyewaantiket";

$koneksi = new mysqli($servername, $username, $password, $dbname);

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

if (!isset($_SESSION['id_penumpang'])) {
    header("Location: login.php");
    exit();
}

$id_penumpang = $_SESSION['id_penumpang'];
$query = "SELECT * FROM penumpang WHERE id_penumpang = '$id_penumpang'";
$result = mysqli_query($koneksi, $query);
$user = mysqli_fetch_assoc($result);

$query_pemesanan = "SELECT * FROM pemesanan WHERE id_pelanggan = '$id_penumpang'";
$result_pemesanan = mysqli_query($koneksi, $query_pemesanan);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Profil Pengguna</h2>
        <table class="table table-bordered">
            <tr><th>Nama</th><td><?php echo $user['nama_penumpang']; ?></td></tr>
            <tr><th>Alamat</th><td><?php echo $user['alamat_penumpang']; ?></td></tr>
            <tr><th>Tanggal Lahir</th><td><?php echo $user['tanggal_lahir']; ?></td></tr>
            <tr><th>Jenis Kelamin</th><td><?php echo $user['jenis_kelamin']; ?></td></tr>
            <tr><th>Telepon</th><td><?php echo $user['telepon']; ?></td></tr>
        </table>
        
        <h3>Riwayat Pembayaran</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Kode Pemesanan</th>
                    <th>Rute</th>
                    <th>Status Pembayaran</th>
                    <th>Bukti Bayar</th>
                    <th>Jumlah Bayar</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result_pemesanan)) { 
                    $id_pemesanan = $row['id_pemesanan'];
                    
                    // Ambil data pembayaran berdasarkan pemesanan
                    $pembayaran_query = "SELECT * FROM pembayaran WHERE id_pemesanan = '$id_pemesanan'";
                    $pembayaran_result = mysqli_query($koneksi, $pembayaran_query);
                    
                    while ($pembayaran = mysqli_fetch_assoc($pembayaran_result)) {
                        // Ambil data rute
                        $id_rute = $row['id_rute'];
                        $rute_query = "SELECT * FROM rute WHERE id_rute = '$id_rute'";
                        $rute_result = mysqli_query($koneksi, $rute_query);
                        $rute = mysqli_fetch_assoc($rute_result);
                ?>
                    <tr>
                        <td><?php echo $row['kode_pemesanan']; ?></td>
                        <td><?php echo $rute['rute_awal'] . " - " . $rute['rute_akhir']; ?></td>
                        <td><?php echo $pembayaran['status_pembayaran']; ?></td>
                        <td>
                            <?php if ($pembayaran['bukti_bayar']) { ?>
                                <img src="uploads/<?php echo $pembayaran['bukti_bayar']; ?>" alt="Bukti Bayar" width="200">
                            <?php } else { ?>
                                <p>Tidak ada bukti bayar</p>
                            <?php } ?>
                        </td>
                        <td>Rp <?php echo number_format($pembayaran['jumlah_bayar'], 0, ',', '.'); ?></td>
                        <td><?php echo $pembayaran['tanggal_pembayaran']; ?></td>
                    </tr>
                <?php } } ?>
            </tbody>
        </table>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>
