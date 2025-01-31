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

// Silme işlemi
if (isset($_GET['id'])) {
    $member_id = $_GET['id'];

    // Üyeyi silme
    $sql = "DELETE FROM members WHERE id = $member_id";

    if ($conn->query($sql) === TRUE) {
        echo "Üye başarıyla silindi!";
        header("Location: list_members.php");
    } else {
        echo "Hata: " . $conn->error;
    }
}

$conn->close();
?>
