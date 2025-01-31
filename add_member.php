<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
$servername = "sql303.infinityfree.com";
$username = "if0_38082618";  // XAMPP'de genellikle "root" kullanılır.
$password = "hakanbey1265";      // XAMPP'de şifre boş bırakılır.
$dbname = "if0_38082618_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

$status = isset($_GET['status']) ? $_GET['status'] : '';

// Programları veritabanından al
$program_query = "SELECT * FROM programlar";  // 'programlar' tablosu programları tutan tablo
$program_result = $conn->query($program_query);

// Bağlantıyı kapat
$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Ekle</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start; /* İçeriği üst kısma hizala */
            height: 100vh;
            padding-top: 50px; /* Üst kısma boşluk ekleyelim */
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
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input, select {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus, select:focus {
            border-color: #6c63ff;
            outline: none;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #5a54e1;
        }
        .back-btn {
            margin-top: 10px;
            text-align: center;
        }
        .back-btn a {
            text-decoration: none;
            color: #6c63ff;
        }
        .back-btn a:hover {
            text-decoration: underline;
        }
        
        .success-message {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error-message {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .icon {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Üye Ekle</h1>
        
        <?php if ($status == 'success'): ?>
            <div class="success-message">
                <span class="icon">✔️</span> Üyelik başarıyla eklendi!
            </div>
        <?php elseif ($status == 'error'): ?>
            <div class="error-message">
                <span class="icon">❌</span> Üye eklenirken bir hata oluştu.
            </div>
        <?php endif; ?>
        
        <form method="POST" action="process_add_member.php">
            <div class="form-group">
                <label for="name">Ad</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="surname">Soyad</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefon Numarası</label>
                <input type="text" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Üyelik Şifresi</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Üyelik Bitiş Tarihi</label>
                <input type="date" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group">
                <label for="program">Program</label>
                <select id="program" name="program" required>
                    <?php
                    if ($program_result->num_rows > 0) {
                        while ($program = $program_result->fetch_assoc()) {
                            echo "<option value='" . $program['program_name'] . "'>" . $program['program_name'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Hiç program bulunamadı.</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn">Üye Ekle</button>
        </form>
        <div class="back-btn">
            <a href="index.php">Geri Dön</a>
        </div>
    </div>
</body>
</html>
