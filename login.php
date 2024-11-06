<?php
include 'db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM pengguna WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username;

            // Set cookie untuk "remember me"
            if (isset($_POST['remember'])) {
                setcookie('username', $username, time() + (86400 * 30), "/"); // 30 hari
            }

            header("Location: index.php");
        } else {
            echo "<p style='color: red;'>Password salah</p>";
        }
    } else {
        echo "<p style='color: red;'>Username tidak ditemukan</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            background-color: #121212;
            color: #E0E0E0;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #1E1E1E;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #BB86FC;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #2E2E2E;
            color: #E0E0E0;
        }
        input[type="checkbox"] {
            margin: 10px 0;
        }
        input[type="submit"] {
            background-color: #BB86FC;
            color: #1E1E1E;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #03DAC6;
        }
        a {
            color: #BB86FC;
            text-decoration: none;
        }
        a:hover {
            color: #03DAC6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="">
            <input type="text" name="username" value="<?= isset($_COOKIE['username']) ? htmlspecialchars($_COOKIE['username']) : '' ?>" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="checkbox" name="remember"> Ingat saya<br>
            <input type="submit" value="Login">
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
