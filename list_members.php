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

// Arama işlemi
$phone_filter = isset($_POST['phone']) ? $_POST['phone'] : '';

// SQL sorgusunu oluşturma
$sql = "SELECT * FROM members"; // 'members' tablosu üyeleri saklayan tablo
$conditions = [];

if ($phone_filter) {
    $conditions[] = "phone LIKE '%$phone_filter%'"; // Telefon numarasına göre filtreleme
}

// Koşul eklenmişse, WHERE ifadesi ekle
if (count($conditions) > 0) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Üyeleri Listele</title>
    <style>
        body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f7fc;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Sayfa içeriğini üstte hizala */
    height: 100vh;
    box-sizing: border-box;
    overflow: auto; /* Taşmayı engelle */
}

.container {
    background-color: white;
    padding: 40px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 1100px;
    overflow-x: hidden;
    box-sizing: border-box;
    margin-top: 20px; /* Üst boşluk ekleyelim */
}

h1 {
    color: #333;
    font-size: 24px;
    text-align: center;
}

.table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    table-layout: fixed; /* Fixed layout to prevent text overflow */
}

.table, th, td {
    border: 1px solid #ccc;
}

th, td {
    padding: 15px;
    text-align: left;
    word-wrap: break-word;
    max-width: 220px;
}

th {
    background-color: #6c63ff;
    color: white;
}

td {
    background-color: #f9f9f9;
}

.action-btn {
    padding: 8px 12px;
    background-color: #6c63ff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.action-btn:hover {
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
        <h1>Üyeleri Listele</h1>
        
        <form method="POST" action="">
            <label for="phone">Telefon Numarası</label>
            <input type="text" id="phone" name="phone" value="<?php echo $phone_filter; ?>" placeholder="Telefon numarasını girin">

            <button type="submit" class="action-btn">Ara</button>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Telefon</th>
                    <th>E-posta</th>
                    <th>Program İd</th>
                    <th>Üyelik Bitiş Tarihi</th>
                    <th>Üyelik Durumu</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Tarih hesaplama
                        $expiry_date = new DateTime($row['expiry_date']);
                        $current_date = new DateTime();
                        $remaining_days = $expiry_date->diff($current_date)->days;
                        $status = $expiry_date > $current_date ? "Aktif" : "Pasif";

                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['surname'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['program_id'] . "</td>";
                        echo "<td>" . $row['expiry_date'] . "</td>";
                        echo "<td>" . ($status == "Aktif" ? "<span style='color: green;'>$status</span>" : "<span style='color: red;'>$status</span>") . "</td>";
                        echo "<td>
                            <a href='edit_member.php?id=" . $row['id'] . "'><button class='action-btn'>Düzenle</button></a>
                            <a href='delete_member.php?id=" . $row['id'] . "'><button class='action-btn'>Sil</button></a>
                        </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Üye bulunamadı.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="back-btn">
            <a href="index.php">Geri Dön</a>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
