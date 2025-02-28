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

// Proses tambah penumpang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat_penumpang'];
    $telepon = $_POST['telepon'];

    $insert_query = "INSERT INTO penumpang (nama_penumpang, alamat_penumpang, telepon) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sss", $nama, $alamat, $telepon);
    $stmt->execute();
}

// Proses edit penumpang
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id_penumpang'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat_penumpang'];
    $telepon = $_POST['telepon'];

    $update_query = "UPDATE penumpang SET nama_penumpang=?, alamat_penumpang=?, telepon=? WHERE id_penumpang=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $nama, $alamat, $telepon, $id);
    $stmt->execute();
}

// Proses hapus penumpang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $delete_query = "DELETE FROM penumpang WHERE id_penumpang=?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    header("Location: manage_users.php");
    exit();
}

// Ambil semua data penumpang
$result = $conn->query("SELECT * FROM penumpang");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Penumpang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .sidebar {
            background-color: #000957;
            height: 100vh;
            padding-top: 20px;
            color: #fff;
        }
        .sidebar h3 {
            color: #FFEB00;
        }
        .sidebar a {
            color: #FFEB00;
            padding: 10px 15px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #344CB7;
            color: #fff;
        }
        .sidebar .btn-logout {
            background-color: #FFEB00;
            color: #000957;
        }
        .sidebar .btn-logout:hover {
            background-color: #344CB7;
            color: #fff;
        }
        .card-header.bg-info {
            background-color: #577BC1;
        }
        .btn-success {
            background-color: #344CB7;
            border: none;
        }
        .btn-success:hover {
            background-color: #577BC1;
        }
        .btn-warning {
            background-color: #FFEB00;
            border: none;
        }
        .btn-warning:hover {
            background-color: #344CB7;
            color: #fff;
        }
        .btn-danger {
            background-color: #FF0000;
            border: none;
        }
        .btn-danger:hover {
            background-color: #344CB7;
            color: #fff;
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
            <div class="col-md-9">
                <div class="container mt-5">
                    <h2 class="text-center mb-4">Kelola Penumpang</h2>

                    <!-- Form Tambah Penumpang -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">Tambah Penumpang</div>
                        <div class="card-body">
                            <form method="POST">
                                <div class="form-group">
                                    <label>Nama Penumpang:</label>
                                    <input type="text" name="nama" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Alamat:</label>
                                    <input type="text" name="alamat_penumpang" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label>Telepon:</label>
                                    <input type="text" name="telepon" class="form-control" required>
                                </div>
                                <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                            </form>
                        </div>
                    </div>

                    <!-- Tabel Data Penumpang -->
                    <div class="card">
                        <div class="card-header bg-info text-white">Daftar Penumpang</div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Telepon</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?= $row['id_penumpang'] ?></td>
                                        <td><?= htmlspecialchars($row['nama_penumpang']) ?></td>
                                        <td><?= htmlspecialchars($row['alamat_penumpang']) ?></td>
                                        <td><?= htmlspecialchars($row['telepon']) ?></td>
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal<?= $row['id_penumpang'] ?>">Edit</button>
                                            <a href="?hapus=<?= $row['id_penumpang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                        </td>
                                    </tr>

                                    <!-- Modal Edit -->
                                    <div class="modal fade" id="editModal<?= $row['id_penumpang'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Penumpang</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="POST">
                                                        <input type="hidden" name="id_penumpang" value="<?= $row['id_penumpang'] ?>">
                                                        <div class="form-group">
                                                            <label>Nama:</label>
                                                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($row['nama_penumpang']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Alamat:</label>
                                                            <input type="text" name="alamat_penumpang" class="form-control" value="<?= htmlspecialchars($row['alamat_penumpang']) ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Telepon:</label>
                                                            <input type="text" name="telepon" class="form-control" value="<?= htmlspecialchars($row['telepon']) ?>" required>
                                                        </div>
                                                        <button type="submit" name="edit" class="btn btn-primary">Simpan Perubahan</button>
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
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
