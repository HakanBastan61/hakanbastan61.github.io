<?php
// Veritabanı bağlantısı
$servername = "sql303.infinityfree.com";
$username = "if0_38082618";  // XAMPP'de genellikle "root" kullanılır.
$password = "hakanbey1265";      // XAMPP'de şifre boş bırakılır.
$dbname = "if0_38082618_db";

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı hatası: " . $conn->connect_error);
}

// Hata ve başarı mesajlarını saklamak için değişken
$message = "";
$message_class = "error"; // Varsayılan hata sınıfı

// Eğer POST isteği yapılmışsa
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Kullanıcıdan gelen verileri al
    $telefon = isset($_POST['phone']) ? $_POST['phone'] : '';
    $sifre = isset($_POST['password']) ? $_POST['password'] : '';
    $program_id = isset($_POST['program_id']) ? $_POST['program_id'] : '';

    // Eğer tüm alanlar doluysa
    if (!empty($telefon) && !empty($sifre) && !empty($program_id)) {
        // Kullanıcıyı sorgula
        $query = "SELECT * FROM members WHERE phone = ? AND password = ? AND program_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssi", $telefon, $sifre, $program_id);  // Verileri bağla
        $stmt->execute();
        $result = $stmt->get_result();

        // Kullanıcıyı kontrol et
        if ($result->num_rows > 0) {
            $message = "Giriş başarılı!";
            $message_class = "success"; // Başarı sınıfı
        } else {
            $message = "Telefon numarası, şifre veya program ID yanlış.";
        }

        $stmt->close();
    } else {
        $message = "Tüm alanlar doldurulmalıdır.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Sayfası</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"], input[type="password"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }
        .message.success {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Giriş Yap</h2>
    <form method="post" action="">
        <label for="phone">Telefon:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="password">Şifre:</label>
        <input type="password" id="password" name="password" required>

        <label for="program_id">Program ID:</label>
        <input type="number" id="program_id" name="program_id" required>

        <input type="submit" value="Giriş Yap">
    </form>

    <?php if (!empty($message)): ?>
        <div class="message <?= $message_class; ?>">
            <?= htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>
