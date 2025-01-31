<?php
session_start();

// Eğer admin oturumu yoksa, kullanıcıyı giriş sayfasına yönlendir
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Paneli</title>
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
        .container {
            background-color: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        h1 {
            color: #333;
            font-size: 24px;
        }
        .welcome {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .btn {
            padding: 14px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #5a54e1;
        }
        .logout {
            margin-top: 30px;
            font-size: 16px;
        }
        .logout a {
            color: #6c63ff;
            text-decoration: none;
        }
        .logout a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Yönetim Paneli</h1>
        <p class="welcome">Hoş geldin, <?php echo $_SESSION['admin_name']; ?> nasılsın?</p>

        <div class="buttons">
            <a href="add_member.php" class="btn">Üye Ekle</a>
            <a href="list_members.php" class="btn">Üyeleri Listele</a>
            <a href="add_program.php" class="btn">Program Ekle</a>
            <a href="list_programs.php" class="btn">Programları Listele</a>
        </div>

        <div class="logout">
            <p><a href="logout.php">Çıkış Yap</a></p>
        </div>
    </div>
</body>
</html>
