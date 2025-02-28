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
    $nama_level = trim($_POST['username']); // Gunakan username sebagai nama_level
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $level = "admin"; // Level hanya untuk admin

    // Validasi input
    if (empty($nama_level) || empty($email) || empty($password) || empty($confirm_password)) {
        die("<script>alert('Semua kolom harus diisi!'); window.history.back();</script>");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("<script>alert('Format email tidak valid!'); window.history.back();</script>");
    }
    
    if ($password !== $confirm_password) {
        die("<script>alert('Password dan konfirmasi password tidak cocok!'); window.history.back();</script>");
    }
    
    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email sudah digunakan
    $check_email = $conn->prepare("SELECT id_level FROM level WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();
    
    if ($check_email->num_rows > 0) {
        die("<script>alert('Email sudah digunakan!'); window.history.back();</script>");
    }

    // Query untuk memasukkan data ke dalam tabel level
    $stmt = $conn->prepare("INSERT INTO level (nama_level, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama_level, $email, $hashed_password);

    if ($stmt->execute()) {
        echo '<script>alert("Admin Baru Telah Didaftarkan");window.location="login.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $check_email->close();
}

$conn->close();
?>
