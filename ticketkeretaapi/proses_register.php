<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // ganti dengan username database Anda
$password = ""; // ganti dengan password database Anda
$dbname = "penyewaantiket"; // nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hashing password
    $nama_penumpang = $_POST['nama_penumpang'];
    $alamat_penumpang = $_POST['alamat_penumpang'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $telepon = $_POST['telepon'];

    // Gunakan prepared statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("INSERT INTO penumpang (username, password, nama_penumpang, alamat_penumpang, tanggal_lahir, jenis_kelamin, telepon) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $username, $password, $nama_penumpang, $alamat_penumpang, $tanggal_lahir, $jenis_kelamin, $telepon);

    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                if (' . ($stmt->execute() ? 'true' : 'false') . ') {
                    Swal.fire({
                        title: "Registrasi Berhasil!",
                        text: "Penumpang baru telah didaftarkan.",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location = "login.php";
                    });
                } else {
                    Swal.fire({
                        title: "Registrasi Gagal!",
                        text: "Terjadi kesalahan, silakan coba lagi.",
                        icon: "error",
                        confirmButtonColor: "#d33",
                        confirmButtonText: "Coba Lagi"
                    });
                }
            });
          </script>';
    
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>
