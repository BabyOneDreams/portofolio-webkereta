<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "penyewaantiket"; // Nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $nama_petugas = trim($_POST['nama_petugas']);
    $level = trim($_POST['level']);

    // Hash password sebelum disimpan
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah ada
    $stmt = $conn->prepare("SELECT * FROM petugas WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<script>alert("Username sudah terdaftar!"); window.history.back();</script>';
    } else {
        // Insert data ke dalam database
        $stmt = $conn->prepare("INSERT INTO petugas (username, password, nama_petugas, id_level) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $hashed_password, $nama_petugas, $level);
        if ($stmt->execute()) {
            echo '<script>alert("Registrasi berhasil! Silakan login."); window.location = "login.php";</script>';
        } else {
            echo '<script>alert("Terjadi kesalahan saat registrasi!"); window.history.back();</script>';
        }
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>
