<?php
// Include database connection
include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $kode = $_POST['kode'];
    $jumlah_kursi = $_POST['jumlah_kursi'];
    $keterangan = $_POST['keterangan'];
    $id_type_transportasi = $_POST['id_type_transportasi'];
    
    $nama_type = $_POST['nama_type'];
    $keterangan_type = $_POST['keterangan_type'];

    // Insert into type_transportasi
    $sql_type = "INSERT INTO type_transportasi (nama_type, keterangan) VALUES ('$nama_type', '$keterangan_type')";
    if (mysqli_query($conn, $sql_type)) {
        echo "Data Type Transportasi berhasil disimpan.<br>";
    } else {
        echo "Error: " . $sql_type . "<br>" . mysqli_error($conn);
    }

    // Get the ID of the recently inserted type_transportasi
    $id_type_transportasi = mysqli_insert_id($conn);

    // Insert into transportasi
    $sql_transportasi = "INSERT INTO transportasi (kode, jumlah_kursi, keterangan, id_type_transportasi) 
                         VALUES ('$kode', '$jumlah_kursi', '$keterangan', '$id_type_transportasi')";

    if (mysqli_query($conn, $sql_transportasi)) {
        echo "Data Transportasi berhasil disimpan.";
    } else {
        echo "Error: " . $sql_transportasi . "<br>" . mysqli_error($conn);
    }
}
?>
