<?php
session_start();

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['nama_level']) || $_SESSION['nama_level'] !== 'admin') {
    header("Location: manage_users.php");
    exit();
}

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
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat_penumpang'];
    $telepon = $_POST['telepon'];

    $insert_query = "INSERT INTO penumpang (nama_penumpang, alamat_penumpang, telepon) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("sss", $nama, $alamat, $telepon);

    if ($stmt->execute()) {
        echo "<script>alert('Penumpang berhasil ditambahkan!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan penumpang!');</script>";
    }
}

// Proses edit penumpang
if (isset($_POST['edit'])) {
    $id = $_POST['id_penumpang'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat_penumpang'];
    $telepon = $_POST['telepon'];

    $update_query = "UPDATE penumpang SET nama_penumpang=?, alamat_penumpang=?, telepon=? WHERE id_penumpang=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssi", $nama, $alamat, $telepon, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Data penumpang berhasil diperbarui!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}

// Proses hapus penumpang
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    $delete_query = "DELETE FROM penumpang WHERE id_penumpang=?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Penumpang berhasil dihapus!'); window.location.href='manage_users.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus penumpang!');</script>";
    }
}

// Ambil semua data penumpang
$result = $conn->query("SELECT * FROM penumpang");
?>

