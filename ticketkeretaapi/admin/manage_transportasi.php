<?php
$servername = "localhost";
$username = "root"; // Ganti dengan username MySQL Anda
$password = ""; // Ganti dengan password MySQL Anda
$dbname = "penyewaantiket"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses input data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_kursi = $_POST['kode_kursi']; // Kolom kode kursi
    $jumlah_kursi = $_POST['jumlah_kursi'];
    $keterangan = $_POST['keterangan'];
    $nama_type = $_POST['nama_type']; // Menambahkan nama_type untuk tipe transportasi

    // Sesuaikan query untuk memasukkan data ke tabel transportasi
    $sql = "INSERT INTO transportasii (kode_kursi, jumlah_kursi, keterangan, nama_type) 
            VALUES ('$kode_kursi', '$jumlah_kursi', '$keterangan', '$nama_type')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Data berhasil ditambahkan!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Ambil data transportasi untuk laporan
$transportasi = $conn->query("SELECT * FROM transportasii");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Transportasi</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7F7F7;
        }
        .sidebar {
            background-color: #000957; /* Sidebar background */
            padding: 20px;
            color: white;
            height: 100vh;
        }
        .sidebar h3 {
            color: white;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            margin: 10px 0;
            display: block;
        }
        .sidebar a:hover {
            background-color: #FFEB00;
            padding-left: 10px;
        }
        .content {
            flex: 1;
            padding: 20px;
        }
        form {
            margin-bottom: 20px;
            padding: 20px;
            border: 1px solid #344CB7;
            background-color: #FFFFFF;
            width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #344CB7;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #CCC;
            border-radius: 4px;
        }
        button {
            margin-top: 10px;
            padding: 10px 15px;
            background-color: #FFEB00;
            border: none;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #577BC1;
        }
        h2 {
            color: #344CB7;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #344CB7;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #FFEB00;
            color: #000;
        }
        tr:nth-child(even) {
            background-color: #F7F7F7;
        }
        tr:hover {
            background-color: #FFEB00;
        }
        /* Tombol Logout */
        .btn-logout {
            background: #dc3545;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .btn-logout:hover {
            background: #c82333;
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

            <!-- Content -->
            <div class="col-md-9 content">
                <h2>Form Input Transportasi</h2>
                <form method="POST" action="">
                    <label>Kode Kursi:</label>
                    <input type="text" name="kode_kursi" required>

                    <label>Jumlah Kursi:</label>
                    <input type="number" name="jumlah_kursi" required>

                    <label>Keterangan:</label>
                    <input type="text" name="keterangan">

                    <label>Jenis Transportasi:</label>
                    <select name="nama_type" required>
                        <option value="">Pilih Jenis Transportasi</option>
                        <option value="Eksekutif">Eksekutif</option>
                        <option value="Bisnis">Bisnis</option>
                        <option value="Ekonomi">Ekonomi</option>
                    </select>

                    <button type="submit">Simpan Data</button>
                </form>

                <h2>Laporan Transportasi</h2>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>Kode Kursi</th>
                        <th>Jumlah Kursi</th>
                        <th>Keterangan</th>
                        <th>Jenis Transportasi</th>
                    </tr>
                    <?php while ($row = $transportasi->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id_transportasi'] ?></td>
                            <td><?= $row['kode_kursi'] ?></td>
                            <td><?= $row['jumlah_kursi'] ?></td>
                            <td><?= $row['keterangan'] ?></td>
                            <td><?= $row['nama_type'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
