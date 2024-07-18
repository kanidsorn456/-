<!-- view_teacher.php -->

<?php
function connectDB()
{
    $serverName = "127.0.0.1";
    $userName = "root";
    $userPassword = "";
    $dbName = "watbangsamak";

    $objCon = mysqli_connect($serverName, $userName, $userPassword, $dbName);
    mysqli_set_charset($objCon, "utf8");
    return $objCon;
}

?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลครู</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Mali', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .container {
            flex: 1;
        }

        .footer {
            text-align: center;
        }

        table {
            width: 50%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .center-btn {
            text-align: center;
        }

        img.img-thumbnail {
            max-width: 300px;
            display: block;
            margin: 0 auto; /* ตรงกลาง */
            margin-top: 20px; /* ขึ้นบนเล็กน้อย */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5" style="color: green;">ข้อมูลครู</h1><br>
        <?php
        $objCon = connectDB();

        if (!$objCon) {
            die("การเชื่อมต่อล้มเหลว: " . mysqli_connect_error());
        }

        if (isset($_GET['t_id'])) {
            $t_id = $_GET['t_id'];
            $sql = "SELECT * FROM teacher WHERE t_id = $t_id";
            $result = mysqli_query($objCon, $sql);

            if (!$result) {
                die('เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($objCon));
            }

            $row = mysqli_fetch_assoc($result);

            echo "<img src='./images/" . $row['t_image'] . "' class='img-thumbnail' />";
            echo "<div class='center-btn'>";
            echo "<br/>";

            echo "<table>";
            echo "<tr><th>ข้อมูล</th><th>รายละเอียด</th></tr>";
            echo "<tr><td>คำนำหน้าชื่อ</td><td>" . $row['t_prefix'] . "</td></tr>";
            echo "<tr><td>ชื่อ</td><td>" . $row['t_firstname'] . "</td></tr>";
            echo "<tr><td>สกุล</td><td>" . $row['t_lastname'] . "</td></tr>";
            echo "<tr><td>ตำแหน่ง</td><td>" . $row['t_vac'] . "</td></tr>";
            echo "<tr><td>กลุ่มสาระการเรียนรู้</td><td>" . $row['t_group'] . "</td></tr>";
            echo "<tr><td>ระดับชั้นที่สอน</td><td>" . $row['t_level'] . "</td></tr>";
            echo "<tr><td>ที่อยู่</td><td>" . $row['t_address'] . "</td></tr>";
            echo "<tr><td>เบอร์โทรศัพท์</td><td>" . $row['t_mobile'] . "</td></tr>";
            echo "</table>";

            echo "<a href='index_edit.php' class='btn btn-warning'>กลับ</a><br />";
            echo "</div>";
            
        } else {
            echo "<p>ไม่พบข้อมูลครู</p>";
        }

        mysqli_close($objCon);
        ?>
    </div>

    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span style='font-size:20px;'>&#127804;</span>
            <span class="text-muted">โรงเรียนวัดบางสมัคร สำนักงานเขตพื้นที่การศึกษาประถมศึกษาฉะเชิงเทรา เขต 1</span>
            <span style='font-size:20px;'>&#127804;</span>
        </div>
    </footer>
</body>
</html>