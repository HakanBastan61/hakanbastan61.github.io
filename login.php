<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Admin bilgilerini kontrol et
    $admin_user = 'Hako';  // Admin kullanıcı adı
    $admin_pass = '6134_hako@';  // Admin şifresi (güvenlik için şifreyi daha iyi korumalısınız)

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username == $admin_user && $password == $admin_pass) {
        $_SESSION['admin_name'] = $username;
        header('Location: index.php');  // Başarılı giriş sonrası admin paneline yönlendir
        exit;
    } else {
        echo "<p style='color: red;'>Hatalı kullanıcı adı veya şifre!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakan Baştan - Giriş</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        .login-container h2 {
            text-align: center;
            color: #333;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .input-field:focus {
            border-color: #6c63ff;
            outline: none;
        }
        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #5a54e1;
        }
        .error-message {
            color: red;
            text-align: center;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .footer a {
            text-decoration: none;
            color: #6c63ff;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Panel Giriş</h2>
        <form method="post">
            <input type="text" name="username" class="input-field" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" class="input-field" placeholder="Şifre" required><br>
            <input type="submit" value="Giriş Yap" class="submit-btn">
        </form>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['admin_name'])) {
            echo "<p class='error-message'>Hatalı kullanıcı adı veya şifre!</p>";
        }
        ?>
        <div class="footer">
            <p>&copy; 2025 © Hakan Baştan</p>
        </div>
    </div>
</body>
</html>
