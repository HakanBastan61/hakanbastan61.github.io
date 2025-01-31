<?php
session_start();
session_destroy();  // Oturum sonlandırılır
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çıkış Yapıldı</title>
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
            text-align: center;
        }
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        .message {
            margin: 20px 0;
            font-size: 20px;
            font-weight: bold;
            color: #6c63ff;
        }
        .redirect {
            margin-top: 20px;
            font-size: 16px;
            color: #6c63ff;
        }
        .redirect a {
            text-decoration: none;
            color: #6c63ff;
            font-weight: bold;
        }
        .redirect a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Çıkış Yapıldı</h1>
        <p class="message">Başarıyla çıkış yaptınız!</p>
        <p>Şimdi, birkaç saniye içinde ana sayfaya yönlendirileceksiniz...</p>

        <div class="redirect">
            <p>Yönlendirilmiyorsanız, <a href="login.php">buraya tıklayarak giriş yapabilirsiniz.</a></p>
        </div>
    </div>

    <script>
        // Yönlendirme işlemi 3 saniye sonra yapılacak
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 3000);
    </script>
</body>
</html>
