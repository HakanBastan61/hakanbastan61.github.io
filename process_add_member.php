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

// Formdan gelen veriler
$name = $_POST['name'];
$surname = $_POST['surname'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$expiry_date = $_POST['expiry_date'];
$program_name = $_POST['program'];  // Seçilen program adı

// Program adını alıp, program_id'yi bulma
$program_query = "SELECT id FROM programlar WHERE program_name = '$program_name'";
echo "Program Sorgusu: " . $program_query . "<br>"; // Debug sorgusu
$program_result = $conn->query($program_query);

if ($program_result->num_rows > 0) {
    $program_row = $program_result->fetch_assoc();
    $program_id = $program_row['id'];
    echo "Program ID: " . $program_id . "<br>"; // Debug program_id
} else {
    die("Geçersiz program adı.");
}

// SQL sorgusunu hazırlama
$sql = "INSERT INTO members (name, surname, phone, email, password, expiry_date, program_id)
        VALUES ('$name', '$surname', '$phone', '$email', '$password', '$expiry_date', '$program_id')";

// Sorguyu çalıştırma
if ($conn->query($sql) === TRUE) {
    header("Location: add_member.php?status=success");
} else {
    echo "Hata: " . $conn->error; // Hata mesajı ekleyelim
    header("Location: add_member.php?status=error");
}

// Bağlantıyı kapatma
$conn->close();
?>
