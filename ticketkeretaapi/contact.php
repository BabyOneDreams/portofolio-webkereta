<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penyewaantiket";

// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    // Prepare and execute insert query
    $sql = "INSERT INTO contact (name, email, phone_number, message) 
            VALUES ('$name', '$email', '$phone', '$message')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Terima Kasih Atas Pesan Dan Sarannya!'); window.location.href = 'index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<form method="POST" action="contact.php">
    <div class="container">
        <div class="row">
            <h1>Contact Us</h1>
        </div>
        <div class="row">
            <h4 style="text-align:center">We'd love to hear from you!</h4>
        </div>
        <style>
        body {
            background-color: #F7F7F7;
            padding-top: 85px;
        }

        h1 {
            font-family: 'Poppins', sans-serif, 'arial';
            font-weight: 600;
            font-size: 72px;
            color: #000000;
            text-align: center;
        }

        h4 {
            font-family: 'Roboto', sans-serif, 'arial';
            font-weight: 400;
            font-size: 20px;
            color: #854836;
            line-height: 1.5;
        }

        /* ///// inputs /////*/

        input:focus ~ label, textarea:focus ~ label, 
        input:valid ~ label, textarea:valid ~ label {
            font-size: 0.75em;
            color: #854836;
            top: -5px;
            transition: all 0.225s ease;
        }

        .styled-input {
            float: left;
            width: 293px;
            margin: 1rem 0;
            position: relative;
            border-radius: 4px;
        }

        @media only screen and (max-width: 768px) {
            .styled-input {
                width: 100%;
            }
        }

        .styled-input label {
            color: #854836;
            padding: 1.3rem 30px 1rem 30px;
            position: absolute;
            top: 10px;
            left: 0;
            transition: all 0.25s ease;
            pointer-events: none;
        }

        .styled-input.wide {
            width: 650px;
            max-width: 100%;
        }

        input, textarea {
            padding: 30px;
            border: 0;
            width: 100%;
            font-size: 1rem;
            background-color: #FFF;
            color: #854836;
            border: 2px solid #854836;
            border-radius: 4px;
        }

        input:focus, textarea:focus {
            outline: 0;
            border-color: #FFB22C;
        }

        textarea {
            width: 100%;
            min-height: 15em;
        }

        .input-container {
            width: 650px;
            max-width: 100%;
            margin: 20px auto 25px auto;
        }

        .submit-btn {
            float: right;
            padding: 7px 35px;
            border-radius: 60px;
            display: inline-block;
            background-color: #FFB22C;
            color: #000000;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.06),
                        0 2px 10px 0 rgba(0, 0, 0, 0.07);
            transition: all 300ms ease;
        }

        .submit-btn:hover {
            background-color: #854836;
            color: #F7F7F7;
        }

        @media (max-width: 768px) {
            .submit-btn {
                width: 100%;
                float: none;
                text-align: center;
            }
        }

        input[type=checkbox] + label {
            color: #854836;
            font-style: italic;
        }

        input[type=checkbox]:checked + label {
            color: #FFB22C;
            font-style: normal;
        }
    </style>
        <div class="row input-container">
            <div class="col-xs-12">
                <div class="styled-input wide">
                    <input type="text" name="name" required />
                    <label>Name</label>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="styled-input">
                    <input type="email" name="email" required />
                    <label>Email</label>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="styled-input" style="float:right;">
                    <input type="text" name="phone_number" required />
                    <label>Phone Number</label>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="styled-input wide">
                    <textarea name="message" required></textarea>
                    <label>Message</label>
                </div>
            </div>
            <div class="col-xs-12">
                <button type="submit" class="btn-lrg submit-btn">Send Message</button>
            </div>
        </div>
    </div>
</form>