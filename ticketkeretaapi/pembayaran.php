<?php
session_start(); // Start the session

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db = "penyewaantiket";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Anda harus login terlebih dahulu!'); window.location.href = 'login.php';</script>";
    exit;
}

$username_login = $_SESSION['username'];

// Ambil data penumpang berdasarkan username yang login
$penumpang_query = $conn->prepare("SELECT id_penumpang, nama_penumpang FROM penumpang WHERE username = ?");
$penumpang_query->bind_param("s", $username_login);
$penumpang_query->execute();
$penumpang_result = $penumpang_query->get_result();
$penumpang = $penumpang_result->fetch_assoc();

if (!$penumpang) {
    die("Data penumpang tidak ditemukan.");
}

$id_pelanggan = $penumpang['id_penumpang'];
$nama_penumpang = $penumpang['nama_penumpang'];

// Ambil data pemesanan terbaru yang terkait dengan penumpang
$pemesanan_query = $conn->prepare("
    SELECT id_pemesanan, kode_pemesanan, total_bayar 
    FROM pemesanan 
    WHERE id_pelanggan = ? 
    ORDER BY id_pemesanan DESC 
    LIMIT 1
");
$pemesanan_query->bind_param("i", $id_pelanggan);
$pemesanan_query->execute();
$pemesanan_result = $pemesanan_query->get_result();
$pemesanan = $pemesanan_result->fetch_assoc();

if (!$pemesanan) {
    die("Data pemesanan tidak ditemukan.");
}

// Ambil data terbaru
$id_pemesanan = $pemesanan['id_pemesanan'];
$kode_pemesanan = $pemesanan['kode_pemesanan'];
$total_bayar = $pemesanan['total_bayar'];


// Proses form saat dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form
    $id_pemesanan = $_POST['id_pemesanan'];
    $kode_pemesanan = $_POST['kode_pemesanan'];
    $tanggal_pembayaran = $_POST['tanggal_pembayaran'];
    $jumlah_bayar = $_POST['jumlah_bayar'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    $status_pembayaran = "pending"; // Default pending

    // Menangani file upload bukti bayar
    $bukti_bayar = null;
    if (isset($_FILES['bukti_bayar']) && $_FILES['bukti_bayar']['error'] == 0) {
        // Tentukan lokasi penyimpanan file
        $target_dir = "uploads/"; // Folder untuk menyimpan file
        $target_file = $target_dir . uniqid() . basename($_FILES["bukti_bayar"]["name"]); // Add unique ID to filename

        // Pastikan file adalah gambar atau PDF
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
        if (in_array($_FILES["bukti_bayar"]["type"], $allowed_types)) {
            if (move_uploaded_file($_FILES["bukti_bayar"]["tmp_name"], $target_file)) {
                $bukti_bayar = basename($target_file); // Menyimpan nama file yang terupload
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengunggah bukti bayar.');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Format file tidak valid. Hanya gambar dan PDF yang diterima.');</script>";
            exit;
        }
    } else {
        echo "<script>alert('Tidak ada file yang diunggah.');</script>";
        exit;
    }

    // Query untuk menyimpan data ke tabel pembayaran
    $query = "INSERT INTO pembayaran (id_pemesanan, kode_pemesanan, tanggal_pembayaran, jumlah_bayar, metode_pembayaran, status_pembayaran, bukti_bayar) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ississs", $id_pemesanan, $kode_pemesanan, $tanggal_pembayaran, $jumlah_bayar, $metode_pembayaran, $status_pembayaran, $bukti_bayar);

    // Menjalankan query dan memeriksa apakah query berhasil
    if ($stmt->execute()) {
        // Jika berhasil, ambil ID pemesanan baru yang sudah ditambahkan
        $last_id = $conn->insert_id; // Mendapatkan id pemesanan terbaru

        // Tampilkan pesan sukses dan redirect ke halaman dengan ID pemesanan yang baru
        echo "<script>alert('Pembayaran berhasil ditambahkan!'); window.location.href = 'profil.php?id_pemesanan=$last_id';</script>";
    } else {
        // Jika gagal, tampilkan pesan error
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    // Menutup prepared statement
    $stmt->close();
    $conn->close(); // Close the database connection
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pembayaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            width: 50%;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px gray;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background: #218838;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Menetapkan nilai input tanggal dengan tanggal saat ini
            var today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
            document.getElementsByName('tanggal_pembayaran')[0].value = today;
        });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let jumlahBayar = <?= $total_bayar ?>;

        // Format angka ke dalam Rupiah
        let formattedHarga = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(jumlahBayar);

        // Tampilkan dalam input yang hanya untuk tampilan
        document.getElementById("jumlah_bayar_display").value = formattedHarga;
    });
</script>
</head>
<body>

<div class="container">
    <h2>Form Pembayaran</h2>
    <form method="POST" enctype="multipart/form-data">
        <!-- Autocomplete fields based on session and database -->
        <label for="id_pemesanan">ID Pemesanan:</label>
        <input type="text" name="id_pemesanan" value="<?= $id_pemesanan ?>" readonly required>

        <label for="kode_pemesanan">Kode Pemesanan:</label>
        <input type="text" name="kode_pemesanan" value="<?= $kode_pemesanan ?>" readonly required>

        <label for="tanggal_pembayaran">Tanggal Pembayaran:</label>
        <input type="date" name="tanggal_pembayaran" required>

        <label for="nama_penumpang">Nama Penumpang:</label>
        <input type="text" name="nama_penumpang" value="<?= $nama_penumpang ?>" readonly required>

        <label for="jumlah_bayar">Jumlah Bayar:</label>
        <input type="text" id="jumlah_bayar_display" readonly required>
        <input type="hidden" id="jumlah_bayar" name="jumlah_bayar" value="<?= $total_bayar ?>" required>

        <label for="bukti_bayar">Bukti Bayar:</label>
        <input type="file" name="bukti_bayar" accept="image/*,application/pdf" required>

        <label for="metode_pembayaran">Metode Pembayaran:</label>
        <select name="metode_pembayaran" required>
            <option value="Transfer Bank">Transfer Bank</option>
            <option value="E-Wallet">E-Wallet</option>
            <option value="Kartu Kredit">Kartu Kredit</option>
        </select>
        <button type="submit" name="simpan_pembayaran">Simpan</button>
    </form>
</div>

</body>
</html>
