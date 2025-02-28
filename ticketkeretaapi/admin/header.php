<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'level') {
    header("Location: ../admin/dashboard.php");
    exit();
}

// Ambil data admin dari database
$id_admin = $_SESSION['id'];
$query = "SELECT nama_level FROM level WHERE id_level = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_admin);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$nama_admin = $row['nama_level'] ?? "Admin";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Admin Panel</a>
        <div class="ml-auto">
            <span class="navbar-text text-white mr-3">Halo, <?= htmlspecialchars($nama_admin); ?>!</span>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </nav>
