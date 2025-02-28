<?php
// Mulai sesi (jika butuh sesi)
session_start();

// Koneksi ke database
$host = "localhost";
$user = "root";
$password = "";
$database = "penyewaantiket";

$conn = new mysqli($host, $user, $password, $database);

// Cek koneksi database
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Proses tambah rute
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit_rute"])) {
    $tujuan = clean_input($_POST["tujuan"]);
    $rute_awal = clean_input($_POST["rute_awal"]);
    $rute_akhir = clean_input($_POST["rute_akhir"]);
    $harga = floatval($_POST["harga"]);
    $id_transportasi = intval($_POST["id_transportasi"]);

    // Gunakan prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("INSERT INTO rute (tujuan, rute_awal, rute_akhir, harga, id_transportasi) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdi", $tujuan, $rute_awal, $rute_akhir, $harga, $id_transportasi);

    if ($stmt->execute()) {
        echo '<script>alert("Rute berhasil ditambahkan!"); window.location = "dashboard_admin.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

// Ambil data rute untuk laporan
$result = $conn->query("SELECT * FROM rute");
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Rute</title>
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

        .container {
            max-width: 700px;
            background: white;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Tabel laporan rute */
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
    <div class="main-content">
        <!-- Form Tambah Rute -->
        <div class="container">
            <h2>Form Tambah Rute</h2>
            <form method="POST" action="">
                <label>Tujuan:</label>
                <input type="text" name="tujuan" required>
                <label>Rute Awal:</label>
                <input type="text" name="rute_awal" required>
                <label>Rute Akhir:</label>
                <input type="text" name="rute_akhir" required>
                <label>Harga:</label>
                <input type="number" name="harga" required placeholder="Rp 0">
                <label>ID Transportasi:</label>
                <input type="number" name="id_transportasi" required>
                <button type="submit" name="submit_rute">Tambah Rute</button>
            </form>
        </div>

        <!-- Tabel Laporan Rute -->
        <div class="container">
            <h2>Laporan Rute</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tujuan</th>
                        <th>Rute Awal</th>
                        <th>Rute Akhir</th>
                        <th>Harga</th>
                        <th>ID Transportasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['id_rute'] ?></td>
                        <td><?= htmlspecialchars($row['tujuan']) ?></td>
                        <td><?= htmlspecialchars($row['rute_awal']) ?></td>
                        <td><?= htmlspecialchars($row['rute_akhir']) ?></td>
                        <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                        <td><?= $row['id_transportasi'] ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
