<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header("Location: login.php");
    exit;
}

// Veritabanı bağlantısı
include("db.php");

// Programları veritabanından çekme
$sql = "SELECT * FROM programlar";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programları Listele</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 1200px;
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
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #6c63ff;
            color: white;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 8px 16px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #5a54e1;
        }
        .action-btns a {
            margin: 0 5px;
            text-decoration: none;
            color: white;
            background-color: #ff5f5f;
            padding: 6px 12px;
            border-radius: 4px;
        }
        .action-btns a:hover {
            background-color: #e14c4c;
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
        <h1>Programları Listele ve Düzenle</h1>
        <table>
            <tr>
                <th>Program Adı</th>
                <th>Açıklama</th>
                <th>Program ID</th>
				<th>Giriş İd</th>
                <th>İşlemler</th>
            </tr>

            <?php while ($program = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $program['program_name']; ?></td>
                    <td><?php echo $program['program_description']; ?></td>
                    <td><?php echo $program['program_id']; ?></td>
					<td><?php echo $program['id']; ?></td>
                    <td class="action-btns">
                        <!-- Düzenleme linki -->
                        <a href="edit_program.php?edit=<?php echo $program['id']; ?>">Düzenle</a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <div class="back-btn">
            <a href="index.php">Geri Dön</a>
        </div>
    </div>
</body>
</html>
