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

// Ambil data rute dan transportasi untuk dropdown
$rute_result = $conn->query("SELECT id_rute, tujuan, harga FROM rute");
$kereta_result = $conn->query("SELECT id_transportasi, keterangan, nama_type FROM transportasii");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Pemesanan Tiket</title>
    <link rel="stylesheet" href="assets/css/pemesanan.css">
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Generate random booking code
            document.getElementById("kode_pemesanan").value = "KT-" + Math.floor(100000 + Math.random() * 900000);
            
            // Generate random seat code
            document.getElementById("kode_kursi").value = "K-" + Math.floor(100 + Math.random() * 900);
            
            // Update total bayar berdasarkan rute yang dipilih
            document.getElementById("id_rute").addEventListener("change", function() {
            let selectedOption = this.options[this.selectedIndex];
            let harga = selectedOption.getAttribute("data-harga");

            // Format angka ke Rupiah
            let formattedHarga = new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(harga);

            // Tampilkan harga dalam format Rupiah
            document.getElementById("total_bayar_display").value = formattedHarga;
            document.getElementById("total_bayar").value = harga; // Simpan dalam format angka untuk diproses di server
            });
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Form Pemesanan Tiket</h1>
        <form method="POST" action="proses_pemesanan.php">
            <label for="kode_pemesanan">Kode Pemesanan:</label>
            <input type="text" id="kode_pemesanan" name="kode_pemesanan" required readonly><br><br>

            <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
            <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" required><br><br>

            <label for="tempat_pemesanan">Tempat Pemesanan:</label>
            <input type="text" id="tempat_pemesanan" name="tempat_pemesanan" required><br><br>

            <label for="nama_penumpang">Nama Penumpang:</label>
            <input type="text" id="nama_penumpang" name="nama_penumpang" value="<?= $nama_penumpang ?>" readonly>
            <input type="hidden" name="id_pelanggan" value="<?= $id_pelanggan ?>"><br><br>

            <label for="kode_kursi">Kode Kursi:</label>
            <input type="text" id="kode_kursi" name="kode_kursi" required readonly><br><br>

            <label for="id_rute">Rute:</label>
            <select id="id_rute" name="id_rute" required>
                <option value="" disabled selected>Pilih Rute</option>
                <?php while ($row = $rute_result->fetch_assoc()): ?>
                    <option value="<?= $row['id_rute'] ?>" data-harga="<?= $row['harga'] ?>">
                        <?= $row['tujuan'] ?> (Rp <?= number_format($row['harga'], 0, ',', '.') ?>)
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="tanggal_berangkat">Tanggal Berangkat:</label>
            <input type="date" id="tanggal_berangkat" name="tanggal_berangkat" required><br><br>

            <label for="jam_cekin">Jam Cekin:</label>
            <input type="time" id="jam_cekin" name="jam_cekin" required><br><br>

            <label for="jam_berangkat">Jam Berangkat:</label>
            <input type="time" id="jam_berangkat" name="jam_berangkat" required><br><br>

            <label for="total_bayar">Total Bayar:</label>
            <input type="text" id="total_bayar_display" readonly required> 
            <input type="hidden" id="total_bayar" name="total_bayar" required> 
            <br><br>

            <label for="id_transportasi">Keterangan Kereta:</label>
            <select id="id_transportasi" name="id_transportasi" required>
                <option value="" disabled selected>Pilih Kereta</option>
                <?php while ($row = $kereta_result->fetch_assoc()): ?>
                    <option value="<?= $row['id_transportasi'] ?>">
                        <?= $row['keterangan'] ?> - <?= ucfirst($row['nama_type']) ?>
                    </option>
                <?php endwhile; ?>
            </select><br><br>

            <button type="submit">Simpan Pemesanan</button>
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>









