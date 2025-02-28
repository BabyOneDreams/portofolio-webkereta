<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Login </title>
    
    <!-- Link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: url('./assets/img/j.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            max-width: 400px;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 3px solid #854836;
        }
        .btn-custom {
            background-color: #FFB22C;
            border: none;
            transition: 0.3s;
            color: #000000;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #854836;
            color: #FFFFFF;
        }
        .btn-register {
            background-color: #854836;
            color: #FFFFFF;
            margin-top: 10px;
        }
        .btn-register:hover {
            background-color: #FFB22C;
            color: #000000;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #854836;
        }
        .form-control {
            border: 2px solid #FFB22C;
        }
        .form-control:focus {
            border-color: #854836;
            box-shadow: none;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login</h2>
    <form action="proses_login.php" method="post" class="form-login">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <button type="submit" class="btn btn-custom w-100">Login</button>
        <a href="register.php" class="btn btn-register w-100">Daftar</a>
    </form>
</div>

<!-- Link ke Bootstrap JS dan Popper -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>