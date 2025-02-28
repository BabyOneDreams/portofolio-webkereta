<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About - Kereta Api Ticketing</title>
    <link rel="stylesheet" href=".css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f8f8;
            color: #333;
            background-image: url('background.jpg'); /* Gambar latar belakang */
            background-size: cover;
            background-position: center;
        }
        .header {
            background-color: rgba(44, 62, 80, 0.7); /* Transparansi untuk background */
            color: white;
            text-align: center;
            padding: 3em;
        }
        .header h1 {
            font-size: 3em;
            margin: 0;
        }
        .about-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3em;
        }
        .about-container h2 {
            font-size: 2.5em;
            margin-bottom: 0.5em;
        }
        .about-container p {
            font-size: 1.1em;
            line-height: 1.6;
            max-width: 900px;
            text-align: justify;
            margin-bottom: 1.5em;
        }
        .features {
            display: flex;
            justify-content: center;
            gap: 3em;
            flex-wrap: wrap;
        }
        .feature {
            background-color: #ecf0f1;
            padding: 2em;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .feature h3 {
            font-size: 1.8em;
            color: #2980b9;
            margin-bottom: 1em;
        }
        .feature p {
            font-size: 1.1em;
            color: #7f8c8d;
        }
        .footer {
            background-color: rgba(44, 62, 80, 0.8);
            color: white;
            text-align: center;
            padding: 1.5em;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        @media (max-width: 1024px) {
            .header h1 {
                font-size: 2.5em;
            }
            .about-container h2 {
                font-size: 2em;
            }
            .about-container p {
                font-size: 1em;
                padding: 1em;
            }
            .features {
                flex-direction: column;
                align-items: center;
                gap: 2em;
            }
            .feature {
                width: 250px;
                padding: 1.5em;
            }
        }
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2em;
            }
            .about-container h2 {
                font-size: 1.8em;
            }
            .about-container p {
                font-size: 0.9em;
            }
            .feature {
                width: 200px;
                padding: 1em;
            }
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Kereta Api Ticketing</h1>
        <p>Pesan tiket kereta api Anda dengan mudah, cepat, dan aman.</p>
    </div>

    <div class="about-container">
        <h2>Tentang Kami</h2>
        <p>
            Selamat datang di Kereta Api Ticketing! Kami adalah platform modern yang menyediakan layanan pemesanan tiket kereta api dengan cara yang praktis, efisien, dan aman. Melalui website ini, kami berkomitmen untuk memberikan pengalaman perjalanan yang menyenangkan bagi Anda. Kami bekerja sama dengan berbagai operator kereta api untuk menawarkan berbagai pilihan tiket dengan harga terbaik, jadwal yang fleksibel, dan layanan pelanggan yang siap membantu kapan saja.
        </p>
        <p>
            Di Kereta Api Ticketing, kami percaya bahwa kenyamanan dan kemudahan adalah prioritas utama. Website kami dirancang dengan antarmuka yang elegan dan responsif, sehingga Anda bisa mengaksesnya dari perangkat apapun, baik itu desktop, tablet, ataupun smartphone.
        </p>
    </div>

    <div class="features">
        <div class="feature">
            <h3>Desain Responsif</h3>
            <p>Website kami dirancang agar tampilan tetap sempurna di berbagai perangkat, baik di desktop maupun smartphone.</p>
        </div>
        <div class="feature">
            <h3>Keamanan Terjamin</h3>
            <p>Proses pembayaran dan transaksi tiket kereta api Anda dilindungi dengan enkripsi tingkat tinggi, memberikan rasa aman setiap kali melakukan pembelian.</p>
        </div>
        <div class="feature">
            <h3>Harga Terbaik</h3>
            <p>Kami menawarkan harga terbaik untuk tiket kereta api, dengan berbagai pilihan rute dan jadwal yang fleksibel.</p>
        </div>
    </div>

    <?php include('footer.php'); ?>
</body>
</html>
