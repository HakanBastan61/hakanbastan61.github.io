<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    // Veritabanı bağlantısı
$servername = "sql303.infinityfree.com";
$username = "if0_38082618";  // XAMPP'de genellikle "root" kullanılır.
$password = "hakanbey1265";      // XAMPP'de şifre boş bırakılır.
$dbname = "if0_38082618_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Bağlantı hatası: " . $conn->connect_error);
    }

    // Üye bilgilerini sorgulama
    $sql = "SELECT * FROM members WHERE id = $member_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $member = $result->fetch_assoc();
    } else {
        echo "Üye bulunamadı.";
        exit;
    }

    // Programları dinamik olarak çekme
    $program_query = "SELECT DISTINCT program FROM members";
} else {
    echo "Geçersiz ID.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Üye güncelleme işlemi
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $expiry_date = $_POST['expiry_date'];
    $program = $_POST['program'];

    $update_sql = "UPDATE members SET 
                   name = '$name',
                   surname = '$surname',
                   phone = '$phone',
                   email = '$email',
                   password = '$password',
                   expiry_date = '$expiry_date',
                   program = '$program' 
                   WHERE id = $member_id";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: edit_member.php?id=$member_id&status=success");
        exit;
    } else {
        header("Location: edit_member.php?id=$member_id&status=error");
        exit;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üye Düzenle</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
            padding-top: 50px;
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
        
        .success-message, .error-message {
            background-color: #28a745;
            color: white;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error-message {
            background-color: #dc3545;
        }

        .icon {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Üye Düzenle</h1>
        
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="success-message">
                <span class="icon">✔️</span> Güncelleme başarılı!
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <div class="error-message">
                <span class="icon">❌</span> Güncelleme sırasında bir hata oluştu.
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Ad</label>
                <input type="text" id="name" name="name" value="<?php echo $member['name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="surname">Soyad</label>
                <input type="text" id="surname" name="surname" value="<?php echo $member['surname']; ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Telefon Numarası</label>
                <input type="text" id="phone" name="phone" value="<?php echo $member['phone']; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-posta</label>
                <input type="email" id="email" name="email" value="<?php echo $member['email']; ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Üyelik Şifresi</label>
                <input type="password" id="password" name="password" value="<?php echo $member['password']; ?>" required>
            </div>
            <div class="form-group">
                <label for="expiry_date">Üyelik Bitiş Tarihi</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?php echo $member['expiry_date']; ?>" required>
            </div>
            <button type="submit" class="btn">Güncelle</button>
        </form>
        
        <div class="back-btn">
            <a href="list_members.php">Geri Dön</a>
        </div>
    </div>
</body>
</html>
