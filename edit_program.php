<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
include("db.php");

// Düzenleme işlemi
if (isset($_GET['edit'])) {
    $program_id = $_GET['edit'];
    
    // Program bilgilerini veritabanından çekme
    $sql = "SELECT * FROM programlar WHERE id = $program_id";
    $result = mysqli_query($conn, $sql);
    $program = mysqli_fetch_assoc($result);

    // Form gönderildiğinde işlemi yapma
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Formdan gelen verileri temizleyelim
        $program_name = mysqli_real_escape_string($conn, $_POST['program_name']);
        $program_description = mysqli_real_escape_string($conn, $_POST['program_description']);
        $program_id = $_POST['program_id'];  // Program ID bu sayfada değişmemeli, sadece sorgu ile kullanılır.

        // Veritabanında güncelleme
        $sql_update = "UPDATE programlar SET program_name = '$program_name', program_description = '$program_description' WHERE id = $program_id";
        
        if (mysqli_query($conn, $sql_update)) {
            echo "<p>Program başarıyla güncellendi!</p>";
            header("Location: list_programs.php"); // Güncellenmiş programlar sayfasına yönlendirme
            exit;
        } else {
            echo "<p>Hata oluştu: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Düzenle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 12px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Program Düzenle</h1>
        <form method="POST" action="edit_program.php?edit=<?php echo $program['id']; ?>">
            <div class="form-group">
                <label for="program_name">Program Adı</label>
                <input type="text" id="program_name" name="program_name" value="<?php echo $program['program_name']; ?>" required>
            </div>
            <div class="form-group">
                <label for="program_description">Açıklama</label>
                <textarea id="program_description" name="program_description" required><?php echo $program['program_description']; ?></textarea>
            </div>
            <!-- Program ID gizli olarak gönderilecek -->
            <input type="hidden" name="program_id" value="<?php echo $program['id']; ?>">
            <button type="submit">Programı Güncelle</button>
        </form>

        <div class="back-btn">
            <a href="list_programs.php">Geri Dön</a>
        </div>
    </div>
</body>
</html>
