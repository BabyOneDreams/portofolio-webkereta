<?php
session_start();

// Cek apakah pengguna sudah login
$username = isset($_SESSION['username']) ? $_SESSION['username'] : "Guest";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Train Ticket Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <h2>Train Ticket Booking</h2>
                <div class="user-info">
                    <p>Welcome, <span id="username"><?php echo htmlspecialchars($username); ?></span></p>
                </div>
                <nav>
                    <ul>
                        <li><a href="#" class="btn">Services</a></li>
                        <li><a href="#" class="btn">Gallery</a></li>
                        <li><a href="tiket.php" class="btn">Testimonials</a></li>
                        <li><a href="profil.php" class="btn">Profil</a></li>
                        <li><a href="about.php" class="btn">About</a></li>
                        <li><a href="contact.php" class="btn">Contact</a></li>
                        <?php if ($username !== "Guest"): ?>
                            <li><a href="logout.php" class="btn">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Main Content -->
    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-text">
                    <h2>Selamat Datang!</h2>
                    <h1>Pesan Tiket Kereta Mudah & Cepat</h1>
                    <p>Temukan tiket terbaik untuk perjalanan Anda.</p>
                    <a href="pemesanan.php" class="btn">Pesan Sekarang</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-left">
                    <p>&copy; 2025 Train Ticket Booking. All rights reserved.</p>
                </div>
                <div class="footer-right">
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
