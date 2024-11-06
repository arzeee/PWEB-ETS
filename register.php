<?php
include 'db.php';
session_start();

// Cek jika pengguna sudah login
if (isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect ke halaman utama jika sudah login
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Memastikan password cocok
    if ($password !== $confirm_password) {
        echo "<script>alert('Password tidak cocok!');</script>";
    } else {
        // Hash password sebelum menyimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Cek apakah username sudah ada
        $sql = "SELECT * FROM pengguna WHERE username='$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<script>alert('Username sudah terdaftar, silakan gunakan yang lain.');</script>";
        } else {
            // Insert pengguna baru
            $sql = "INSERT INTO pengguna (username, password) VALUES ('$username', '$hashed_password')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
            } else {
                echo "<script>alert('Error: " . $sql . " " . $conn->error . "');</script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            background-color: #121212;
            color: #E0E0E0;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            color: #BB86FC;
        }
        form {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #1E1E1E;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #BB86FC;
            border-radius: 4px;
            background-color: #2C2C2C;
            color: #E0E0E0;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #BB86FC;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #9B59B6;
        }
        .login-link {
            text-align: center;
            margin-top: 10px;
            /* color: #BB86FC; */
        }
        .login-link a {
            text-decoration: none;
            color: #BB86FC;
        }
        .login-link a:hover {
            color: #03DAC6;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" required id="username">
        
        <label for="password">Password:</label>
        <input type="password" name="password" required id="password">
        
        <label for="confirm_password">Konfirmasi Password:</label>
        <input type="password" name="confirm_password" required id="confirm_password">
        
        <input type="submit" value="Register">
    </form>
    <div class="login-link">
        <p>Sudah punya akun? <a href="login.php">Masuk di sini</a></p>
    </div>
</body>
</html>
