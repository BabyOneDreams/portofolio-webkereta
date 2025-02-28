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
    

    // Query untuk mencari admin berdasarkan nama_level
    $stmt = $conn->prepare("SELECT * FROM level WHERE nama_level = ? AND email IS NOT NULL");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Ambil data admin
        $row = $result->fetch_assoc();
        
        // Cek apakah password cocok
        if (password_verify($password, $row['password'])) {
            // Mulai sesi
            session_start();
            $_SESSION['admin'] = $row['nama_level'];

            echo '<script>alert("Login berhasil sebagai Admin!"); window.location = "../admin/dashboard.php";</script>';
        } else {
            echo '<script>alert("Password salah!"); window.history.back();</script>';
        }
    } else {
        echo '<script>alert("Username tidak ditemukan atau bukan admin!"); window.history.back();</script>';
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
?>
