<?php
// การเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "employee_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("SET NAMES utf8");
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายชื่อพนักงาน</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .add-button {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <h2>รายชื่อพนักงาน</h2>
    <a href="add_employee.php" class="add-button">เพิ่มพนักงานใหม่</a>

    <table>
        <tr>
            <th>รหัสพนักงาน</th>
            <th>ชื่อ</th>
            <th>นามสกุล</th>
            <th>ตำแหน่ง</th>
            <th>อีเมล</th>
            <th>การจัดการ</th>
        </tr>
        <?php
        // ดึงข้อมูลพนักงาน
        $stmt = $conn->prepare("SELECT * FROM employees");
        $stmt->execute();
        $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($employees as $employee) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($employee['id']) . "</td>";
            echo "<td>" . htmlspecialchars($employee['first_name']) . "</td>";
            echo "<td>" . htmlspecialchars($employee['last_name']) . "</td>";
            echo "<td>" . htmlspecialchars($employee['position']) . "</td>";
            echo "<td>" . htmlspecialchars($employee['email']) . "</td>";
            echo "<td>
                <a href='edit_employee.php?id=" . $employee['id'] . "'>แก้ไข</a> |
                <a href='delete_employee.php?id=" . $employee['id'] . "' onclick='return confirm(\"ยืนยันการลบ?\")'>ลบ</a>
            </td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
// ปิดการเชื่อมต่อ
$conn = null;
?>
