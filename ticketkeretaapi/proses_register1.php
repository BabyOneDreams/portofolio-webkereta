<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penyewaantiket";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT); // Hash password
    $role = $_POST['role'];

    // Query insert data ke tabel users
    $stmt = $conn->prepare("INSERT INTO user (nama_lengkap, username, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $username, $password, $role);

    if ($stmt->execute()) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Pendaftaran Berhasil!',
                    text: 'Silakan login dengan akun Anda.',
                    icon: 'success',
                    confirmButtonText: 'Login'
                }).then(() => {
                    window.location = 'login.php';
                });
            });
        </script>";
    } else {
        echo "<script>alert('Pendaftaran gagal. Silakan coba lagi.'); window.history.back();</script>";
    }

    $stmt->close();
}

$conn->close();
?>
