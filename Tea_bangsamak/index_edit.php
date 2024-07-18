<?php
include_once('./function.php');
$objCon = connectDB();

// if ($objCon) {
//     echo 'connected';
// } else {
//     // echo mysqli_connect_error();
//     echo 'not connect';
// }
$perpage = 10;
// $page = $_GET['page'];
if (isset($_GET['page']) && (int) $_GET['page'] > 0) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
$start = ($page - 1) * $perpage;

$condition = "";
$search = "";
if (isset($_GET['search']) && $_GET['search'] != '') {
    $search = mysqli_real_escape_string($objCon, $_GET['search']);
    $condition = " AND t_firstname LIKE '%$search%' OR t_lastname LIKE '%$search%' OR t_id = '$search'";
}

// echo $search;

$sql = "SELECT * FROM teacher WHERE t_status = 1$condition ORDER BY t_id ASC LIMIT $start, $perpage";
$objQuery = mysqli_query($objCon, $sql);
// while($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
//     print_r($objResult);
// }
?>

<!DOCTYPE html>
<html lang="th" class="h-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการข้อมูลครู</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Mali:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ใช้แบบอักษร Prompt ทั้งหมดในเว็บ */
        body, input, button, select, textarea {
            font-family: 'Mali', sans-serif;
        }
    </style>
</head>
<body class="d-flex flex-column h-100">
    <!-- Begin page content -->
    <main class="flex-shrink-0">
        <div class="container">
            <div class="text-center mt-5">
                <h1 class="mt-5"><span style='font-size:40px;'>&#128194;</span>ข้อมูลครูโรงเรียนวัดบางสมัคร<span style='font-size:40px;'>&#128194;</span></h1>
            </div>
            <!-- ฟอร์มค้นหา -->
            <div class="mt-4">
                <form>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <label for="search" class="col-form-label">ใส่ข้อมูลเพื่อค้นหา</label>
                        </div>
                        <div class="col-auto">
                            <input type="text" id="search" name="search" value="<?php echo $search; ?>" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">ค้นหา</button>
                        </div>
                        <div class="col-auto">
                            <a href="index_edit.php" class="btn btn-secondary">เคลียร์</a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- ปุ่มเพิ่มข้อมูล -->
            <div class="mt-4">
                <a href="create.php" class="btn btn-success">เพิ่มข้อมูล</a> 
                
                
            </div>
            
            <!-- ตารางข้อมูล -->
            <table class="table  mt-5">
                <thead>
                    <tr>
                        
                        <th class="text-center text-nowrap">คำนำหน้า</th>
                        <th class="text-center text-nowrap">ชื่อ</th>
                        <th class="text-center text-nowrap">สกุล</th>
                        <th class="text-center text-nowrap">ตำแหน่ง</th>
                        <th class="text-center text-nowrap" colspan="3">การจัดการข้อมูล</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($objResult = mysqli_fetch_array($objQuery, MYSQLI_ASSOC)) {
                    ?>
                        <tr>
                            
                            <td class="text-left text-nowrap"><?php echo $objResult['t_prefix']; ?></td>
                            <td class="text-left text-nowrap"><?php echo $objResult['t_firstname']; ?></td>
                            <td class="text-left text-nowrap"><?php echo $objResult['t_lastname']; ?></td>
                            <td class="text-left text-nowrap"><?php echo $objResult['t_vac']; ?></td>
                            <td class="text-center">
                            <a href="view.php?t_id=<?php echo $objResult['t_id']; ?>" class="btn btn-info btn-sm">ดูข้อมูล</a>
                            </td>
                            <td class="text-center">
                                <a href="update.php?t_id=<?php echo $objResult['t_id']; ?>" class="btn btn-warning btn-sm">แก้ไข</a>
                            </td>
                            <td class="text-center">
                                <a href="action_delete.php?t_id=<?php echo $objResult['t_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยัน');">ลบข้อมูล</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <!-- หมายเลขหน้า -->
            <?php
            $strSQL = "SELECT * FROM teacher WHERE t_status = 1$condition ORDER BY t_id DESC";
            $objQuery = mysqli_query($objCon, $strSQL);
            $total_record = mysqli_num_rows($objQuery);
            $total_page = ceil($total_record / $perpage);
            ?>
            <div>
                <ul class="pagination justify-content-end">
                    <?php for ($i = 1; $i <= $total_page; $i++) { ?>
                        <li class="page-item<?php if ($page == $i) { echo ' active'; } ?>">
                            <a class="page-link" href="index_edit.php?search=<?php echo $search; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </main>
    <style>
    .footer {
        text-align: center;
    }
</style>

<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
    <span style='font-size:20px;'>&#127804;</span>
    <span class="text-muted">โรงเรียนวัดบางสมัคร สำนักงานเขตพื้นที่การศึกษาประถมศึกษาฉะเชิงเทรา เขต 1</span>
    <span style='font-size:20px;'>&#127804;</span>
    </div>
</footer>
</body>
</html>
