<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
include("db.php");

$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $program_name = $_POST['program_name'];
    $program_description = $_POST['program_description'];
    $program_id = $_POST['program_id'];

    // Veritabanına program ekleme
    $sql = "INSERT INTO programlar (program_name, program_description, program_id) 
            VALUES ('$program_name', '$program_description', '$program_id')";

    if (mysqli_query($conn, $sql)) {
        $success_message = "Program başarıyla eklendi!";
    } else {
        $error_message = "Program eklenirken bir hata oluştu: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Ekle</title>
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
        }
        h1 {
            color: #333;
            font-size: 24px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus, textarea:focus {
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
            text-align: center;
            margin-top: 20px;
        }
        .back-btn a {
            text-decoration: none;
            color: #6c63ff;
        }
        .back-btn a:hover {
            text-decoration: underline;
        }

        /* Success and error messages */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .alert i {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Program Ekle</h1>

        <?php if ($success_message): ?>
            <div class="alert success">
                <i class="fa fa-check-circle"></i> <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        <?php if ($error_message): ?>
            <div class="alert error">
                <i class="fa fa-times-circle"></i> <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="add_program.php">
            <div class="form-group">
                <label for="program_name">Program Adı</label>
                <input type="text" id="program_name" name="program_name" required>
            </div>
            <div class="form-group">
                <label for="program_description">Program Açıklaması</label>
                <textarea id="program_description" name="program_description" required></textarea>
            </div>
            <div class="form-group">
                <label for="program_id">Program ID Numarası</label>
                <input type="text" id="program_id" name="program_id" required>
            </div>
            <button type="submit" class="btn">Programı Ekle</button>
        </form>

        <div class="back-btn">
            <a href="index.php">Geri Dön</a>
        </div>
    </div>

    <!-- FontAwesome for icons (Optional) -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
