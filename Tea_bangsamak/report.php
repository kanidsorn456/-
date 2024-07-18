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
    <style>
        body {
            font-family: 'Mali', sans-serif;
            background-color: #ffffff;
            min-height: 99vh;
            display: flex;
            flex-direction: column;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 50px;
        }

        .about-boss {
            width: 200px;
            margin-bottom: 10px;
            text-align: center; /* ให้ข้อมูลตรงกลาง */
        }

        .col {
            margin-bottom: 20px;
        }

        .card {
            height: 385px;
        }

        .card-image img {
            max-height: 240px;
        }

        .card-content {
            text-align: center; /* ให้ข้อมูลตรงกลาง */
        }
    </style>
</head>

<body>

    <div class="col s12 m12 l9">
        <div class="about-text">
            
            <div class="divider"></div>
            <div class="row">
                <?php
                
                $objCon = connectDB();

                if (!$objCon) {
                    die("การเชื่อมต่อล้มเหลว: " . mysqli_connect_error());
                }

                $sql = "SELECT * FROM teacher";
                $result = mysqli_query($objCon, $sql);

                if (!$result) {
                    die('เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($objCon));
                }

                $counter = 0;

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col s3">';
                    echo '<div class="about-boss" style="width: 250px">';
                    echo '<div class="card" style="height: 385px;">';
                    echo '<div class="card-image">';
                    echo '<img src="./images/' . $row['t_image'] . '" class="responsive-img img-head" style="height:240px" />';
                    echo '</div>';
                    echo '<div class="card-content">';
                    echo '<p style="font-size:16px"><strong>' . $row['t_prefix'] . ' ' . $row['t_firstname'] . ' ' . $row['t_lastname'] . '</strong></p>';
                    echo '<p style="font-size:16px"><strong>ตำแหน่ง &nbsp;' . $row['t_vac'] . '</strong></p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $counter++;

                    // เมื่อแสดงข้อมูลครูครบ 1 รายการในแถว ให้ปิดแถวแรกและเปิดแถวถัดไป
                    if ($counter === 1) {
                        echo '</div>'; // ปิดแถวแรก
                        echo '<div class="row">'; // เริ่มแถวถัดไป
                    }

                    // เมื่อแสดงข้อมูลครูครบ 3 รายการในแถวถัดไป ให้ปิดแถวและเปิดแถวใหม่
                    if ($counter === 3) {
                        
                        $counter = 0; // รีเซ็ตค่า counter เพื่อนับในแถวถัดไป
                    }
                }

                echo '</div>'; // ปิดแถวท้ายสุด

                mysqli_close($objCon);
                ?>
            </div>
        </div>
    </div>
    
</body>

</html>
