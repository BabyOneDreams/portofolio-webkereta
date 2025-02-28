<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Registrasi Multi Level</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: url('./assets/img/67.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 450px;
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #000000;
        }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #854836;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: 0.3s;
        }
        .form-group input:focus, .form-group select:focus {
            border-color: #FFB22C;
            outline: none;
        }
        .form-group input[type="submit"] {
            background-color: #FFB22C;
            color: #000000;
            cursor: pointer;
            border: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .form-group input[type="submit"]:hover {
            background-color: #E09E2C;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Form Registrasi Penumpang</h2>
        <form action="proses_register.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="nama_penumpang">Nama Penumpang:</label>
                <input type="text" id="nama_penumpang" name="nama_penumpang" required>
            </div>
            <div class="form-group">
                <label for="alamat_penumpang">Alamat Penumpang:</label>
                <input type="text" id="alamat_penumpang" name="alamat_penumpang" required>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="telepon">Telepon:</label>
                <input type="text" id="telepon" name="telepon" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Daftar">
            </div>
        </form>
    </div>
</body>
</html>
