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

    // Query untuk mencari petugas berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM petugas WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data petugas
        $row = $result->fetch_assoc();
        
        // Cek apakah password cocok (asumsikan password disimpan dengan hash)
        if (password_verify($password, $row['password'])) {
            // Mulai sesi
            session_start();
            $_SESSION['petugas'] = $row['username']; // Simpan username petugas

            echo '<script>alert("Login berhasil!"); window.location = "dashboard.php";</script>';
        } else {
            echo '<script>alert("Password salah!"); window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Username tidak ditemukan!"); window.history.back();</script>';
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>
