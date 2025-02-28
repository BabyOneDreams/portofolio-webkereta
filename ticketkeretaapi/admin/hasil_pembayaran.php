<?php
session_start();

// Koneksi ke database
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "penyewaantiket";
$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses update status pembayaran
if (isset($_POST['update_status'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $status_pembayaran = $_POST['status_pembayaran'];
    $metode_pembayaran = $_POST['metode_pembayaran']; // Menyertakan metode pembayaran

    $update_query = "UPDATE pembayaran SET status_pembayaran=?, metode_pembayaran=? WHERE id_pembayaran=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("ssi", $status_pembayaran, $metode_pembayaran, $id_pembayaran);
    $stmt->execute();
}

// Proses hapus pembayaran
if (isset($_GET['hapus'])) {
    $id_pembayaran = $_GET['hapus'];

    $delete_query = "DELETE FROM pembayaran WHERE id_pembayaran=?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id_pembayaran);
    $stmt->execute();
    
    header("Location: hasil_pembayaran.php");
    exit();
}

// Ambil semua data pembayaran
$query = "SELECT pembayaran.*, pemesanan.kode_pemesanan, pembayaran.bukti_bayar
          FROM pembayaran
          JOIN pemesanan ON pembayaran.id_pemesanan = pemesanan.id_pemesanan";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #000957;
            padding-top: 20px;
            position: fixed;
            top: 0;
            left: 0;
            color: #FFEB00;
            text-align: center;
        }

        .sidebar a {
            color: #FFEB00;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
            margin: 10px 0;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background: #344CB7;
            color: #fff;
        }

        .sidebar .btn-logout {
            background-color: #FFEB00;
            color: #000957;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 20px;
        }

        .card {
            margin-top: 30px;
        }

        /* Tabel laporan pembayaran */
        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #577BC1;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Admin Panel</h3>
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_users.php">Kelola Penumpang</a>
        <a href="manage_transportasi.php">Kelola Transportasi</a>
        <a href="rute.php">Kelola Rute</a>
        <a href="hasil_pembayaran.php">Pembayaran</a>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container mt-5">
            <h2 class="text-center mb-4">Hasil Pembayaran</h2>

            <div class="card">
                <div class="card-header bg-info text-white">Daftar Pembayaran</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Kode Pemesanan</th>
                                <th>Tanggal Pembayaran</th>
                                <th>Jumlah Bayar</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Bukti Bayar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?= $row['id_pembayaran'] ?></td>
                                <td><?= htmlspecialchars($row['kode_pemesanan']) ?></td>
                                <td><?= $row['tanggal_pembayaran'] ?></td>
                                <td>Rp <?= number_format($row['jumlah_bayar'], 0, ',', '.') ?></td>
                                <td><?= htmlspecialchars($row['metode_pembayaran']) ?></td>
                                <td>
                                    <span class="badge <?= ($row['status_pembayaran'] == 'Lunas') ? 'badge-success' : 'badge-warning' ?>">
                                        <?= $row['status_pembayaran'] ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($row['bukti_bayar']) : ?>
                                        <a href="../uploads/<?= $row['bukti_bayar'] ?>" target="_blank">Lihat Bukti Bayar</a>
                                    <?php else : ?>
                                        Tidak ada bukti bayar
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editStatusModal<?= $row['id_pembayaran'] ?>">Edit Status</button>
                                    <a href="?hapus=<?= $row['id_pembayaran'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                </td>
                            </tr>

                            <!-- Modal Edit Status -->
                            <div class="modal fade" id="editStatusModal<?= $row['id_pembayaran'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Status Pembayaran</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST">
                                                <input type="hidden" name="id_pembayaran" value="<?= $row['id_pembayaran'] ?>">
                                                <div class="form-group">
                                                    <label>Status Pembayaran:</label>
                                                    <select name="status_pembayaran" class="form-control" required>
                                                        <option value="Pending" <?= ($row['status_pembayaran'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                                        <option value="Lunas" <?= ($row['status_pembayaran'] == 'Lunas') ? 'selected' : '' ?>>Lunas</option>
                                                    </select>
                                                </div>
                                                <button type="submit" name="update_status" class="btn btn-primary">Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
