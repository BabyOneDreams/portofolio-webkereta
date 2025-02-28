<?php
session_start(); // Mulai sesi

// Koneksi ke database
$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "penyewaantiket";
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
    echo "<div style='position: fixed; top: 0; left: 0; width: 100%; background: red; color: white; text-align: center; padding: 10px; font-size: 18px;'>Anda harus login terlebih dahulu! <a href='login.php' style='color: yellow; text-decoration: underline;'>Login</a></div>";
    exit;
}

// Ambil data dari form
$kode_pemesanan = $_POST['kode_pemesanan'];
$tanggal_pemesanan = $_POST['tanggal_pemesanan'];
$tempat_pemesanan = $_POST['tempat_pemesanan'];
$nama_penumpang = $_POST['nama_penumpang'];
$id_pelanggan = $_POST['id_pelanggan'];
$kode_kursi = $_POST['kode_kursi'];
$id_rute = $_POST['id_rute'];
$tanggal_berangkat = $_POST['tanggal_berangkat'];
$jam_cekin = $_POST['jam_cekin'];
$jam_berangkat = $_POST['jam_berangkat'];
$total_bayar = $_POST['total_bayar'];
$id_transportasi = $_POST['id_transportasi']; // Menggunakan id_transportasi dari dropdown

// Validasi input (opsional, dapat ditambahkan pengecekan lebih lanjut)
if (empty($kode_pemesanan) || empty($tanggal_pemesanan) || empty($id_rute) || empty($id_transportasi)) {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
            Swal.fire({
                title: "Pemesanan Gagal!",
                text: "Mohon lengkapi semua data sebelum melanjutkan.",
                icon: "warning",
                confirmButtonColor: "#d33",
                confirmButtonText: "OK"
            }).then(() => {
                window.history.back();
            });
          </script>';
    exit;
}

// Masukkan data pemesanan ke dalam database
$stmt = $conn->prepare("INSERT INTO pemesanan (kode_pemesanan, tanggal_pemesanan, tempat_pemesanan, nama_penumpang, id_pelanggan, kode_kursi, id_rute, tanggal_berangkat, jam_cekin, jam_berangkat, total_bayar, id_transportasi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssssss", $kode_pemesanan, $tanggal_pemesanan, $tempat_pemesanan, $nama_penumpang, $id_pelanggan, $kode_kursi, $id_rute, $tanggal_berangkat, $jam_cekin, $jam_berangkat, $total_bayar, $id_transportasi);

// Tampilkan notifikasi berdasarkan hasil eksekusi query
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
            if (' . ($stmt->execute() ? 'true' : 'false') . ') {
                Swal.fire({
                    title: "Pemesanan Berhasil!",
                    text: "Silahkan lanjut ke metode pembayaran.",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location = "pembayaran.php";
                });
            } else {
                Swal.fire({
                    title: "Pemesanan Gagal!",
                    text: "Terjadi kesalahan, silakan coba lagi.",
                    icon: "error",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "Coba Lagi"
                });
            }
        });
      </script>';

$stmt->close();
$conn->close();
?>
