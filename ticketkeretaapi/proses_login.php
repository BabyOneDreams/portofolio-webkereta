<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penyewaantiket";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Cek di tabel user (untuk admin dan petugas)
    $stmt = $conn->prepare("SELECT id_user, username, password, role FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { // Jika ditemukan di tabel user
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id_user'] = $row['id_user'];
            $_SESSION['role'] = $row['role'];

            // Redirect berdasarkan role
            if ($row['role'] == 'admin') {
                $redirect_url = "./admin/dashboard_admin.php";
            } elseif ($row['role'] == 'petugas') {
                $redirect_url = "./petugas/dashboard_petugas.php";
            } elseif ($row['role'] == 'penumpang') {
                $redirect_url = "index.php";
            }

            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Login Berhasil!',
                        text: 'Selamat datang, " . $row['username'] . "!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = '$redirect_url';
                        }
                    });
                });
            </script>";
            exit();
        }
    } 

    // Jika tidak ditemukan di tabel user, cek di tabel penumpang
    $stmt = $conn->prepare("SELECT id_penumpang, username, password, nama_penumpang FROM penumpang WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) { // Jika ditemukan di tabel penumpang
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id_penumpang'] = $row['id_penumpang'];
            $_SESSION['nama_penumpang'] = $row['nama_penumpang'];
            $_SESSION['role'] = 'penumpang'; // Set role penumpang

            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Login Berhasil!',
                        text: 'Selamat datang, " . $row['username'] . "!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'index.php';
                        }
                    });
                });
            </script>";
            exit();
        }
    }

    // Jika tidak ditemukan di kedua tabel
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Login Gagal!',
                text: 'Username atau password salah!',
                icon: 'error',
                confirmButtonText: 'Coba Lagi'
            }).then(() => {
                window.history.back();
            });
        });
    </script>";

    $stmt->close();
}

$conn->close();
?>
