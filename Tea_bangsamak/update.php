<?php
include_once('./function.php');
$objCon = connectDB();

// ตรวจสอบว่ามีการส่ง t_id มาหรือไม่
if(isset($_GET['t_id'])) {
    $t_id = (int) $_GET['t_id'];
    
    // ดึงข้อมูลครูจากฐานข้อมูล
    $stmt = $objCon->prepare("SELECT * FROM teacher WHERE t_status = 1 AND t_id = ?");
    $stmt->bind_param("i", $t_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $objResult = $result->fetch_assoc();

    // ถ้าไม่พบข้อมูลให้แจ้งเตือนและ redirect
    if ($objResult == null) {
        echo '<script>alert("ไม่พบข้อมูล!!");window.location="index.php";</script>';
    }

    $stmt->close();
}

// ตรวจสอบการส่งข้อมูลแบบ POST
if(isset($_POST['submit'])) {
    // ตรวจสอบการอัพโหลดไฟล์ภาพ
    if(isset($_FILES['t_image']) && $_FILES['t_image']['error'] == 0) {
        // ตรวจสอบชนิดของไฟล์ภาพ
        $allowed_types = array('jpg', 'jpeg', 'png');
        $exts = explode('.', $_FILES['t_image']['name']);
        $ext = strtolower(end($exts));
        
        if(in_array($ext, $allowed_types) && $_FILES['t_image']['size'] <= 2097152) {
            $image_name = $_FILES['t_image']['name'];
            $temp_name = $_FILES['t_image']['tmp_name'];
            $folder = "./images/";

            // ตรวจสอบว่ามีไฟล์ภาพที่มีชื่อเดียวกันอยู่แล้วหรือไม่
            if(file_exists($folder.$image_name)) {
                echo '<script>alert("มีไฟล์ภาพที่มีชื่อเดียวกันอยู่แล้ว");</script>';
            } else {
                move_uploaded_file($temp_name, $folder.$image_name);
            }
        } else {
            echo '<script>alert("ขนาดไฟล์ภาพต้องไม่เกิน 2 MB และเฉพาะไฟล์ภาพชนิด jpg, jpeg, หรือ png เท่านั้น");</script>';
        }
    }

    // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
    if(isset($_POST['t_prefix']) && isset($_POST['t_firstname']) && isset($_POST['t_lastname']) && isset($_POST['t_id']) && isset($_POST['t_vac']) && isset($_POST['t_group']) && isset($_POST['t_level']) && isset($_POST['t_address']) && isset($_POST['t_mobile'])) {
        $t_id = $_POST['t_id'];
        $t_prefix = $_POST['t_prefix'];
        $t_firstname = $_POST['t_firstname'];
        $t_lastname = $_POST['t_lastname'];
        $t_vac = $_POST['t_vac'];
        $t_group = $_POST['t_group'];
        $t_level = $_POST['t_level'];
        $t_address = $_POST['t_address'];
        $t_mobile = $_POST['t_mobile'];

        // อัพเดตข้อมูลครูในฐานข้อมูล
        $update_stmt = $objCon->prepare("UPDATE teacher SET t_prefix=?, t_firstname=?, t_lastname=?, t_vac=?, t_group=?, t_level=?, t_address=?, t_mobile=?, t_image=? WHERE t_id=?");
        $update_stmt->bind_param("sssssssssi", $t_prefix, $t_firstname, $t_lastname, $t_vac, $t_group, $t_level, $t_address, $t_mobile, $image_name, $t_id);
        
        if($update_stmt->execute()) {
            echo '<script>alert("อัพเดตข้อมูลเรียบร้อยแล้ว"); window.location="index_edit.php";</script>';
        } else {
            echo '<script>alert("เกิดข้อผิดพลาดในการอัพเดตข้อมูล");</script>';
        }

        $update_stmt->close();
    }
}
?>
<!doctype html>
<html lang="th" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ข้อมูลครู</title>
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
    <main class="flex-shrink-0">
        <div class="container">
            <h1 class="mt-5">ข้อมูลครู</h1>
            <!-- ฟอร์มเพิ่มข้อมูล -->
            <form action="action_update.php" id="form_update" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row mt-4">
                            <!-- แถวที่ 1 -->
                            <div class="col-md-4 mt-3">
                                <label for="t_prefix" class="form-label fw-bold">คำนำหน้าชื่อ<span class="text-danger">*</span></label>
                                <select id="t_prefix" name="t_prefix" class="form-select">
                                    <option value="o1">กรุณาเลือก</option>
                                    <option value="นาย" <?php if(isset($objResult['t_prefix']) && $objResult['t_prefix'] == 'นาย') echo 'selected'; ?>>นาย</option>
                                    <option value="นางสาว" <?php if(isset($objResult['t_prefix']) && $objResult['t_prefix'] == 'นางสาว') echo 'selected'; ?>>นางสาว</option>
                                    <option value="นาง" <?php if(isset($objResult['t_prefix']) && $objResult['t_prefix'] == 'นาง') echo 'selected'; ?>>นาง</option>
                                </select>                             
                            <input type="hidden" name="t_id" value="<?php echo $objResult['t_id']; ?>">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_firstname" class="form-label fw-bold">ชื่อ<span class="text-danger">*</span></label>
                                <input type="text" id="t_firstname" name="t_firstname" class="form-control" value="<?php echo $objResult['t_firstname']; ?>">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_lastname" class="form-label fw-bold">สกุล<span class="text-danger">*</span></label>
                                <input type="text" id="t_lastname" name="t_lastname" class="form-control" value="<?php echo $objResult['t_lastname']; ?>">
                            </div>                           
                            <!-- แถวที่ 2 -->
                            <div class="col-md-4 mt-3">
                                <label for="t_vac" class="form-label fw-bold">ตำแหน่ง<span class="text-danger">*</span></label>
                                <select id="t_vac" name="t_vac" class="form-select">
                                    <option value="กรุณาเลือก">กรุณาเลือก</option>
                                    <option value="ผู้อำนวยการ" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'ผู้อำนวยการ') echo 'selected'; ?>>ผู้อำนวยการ</option>
                                    <option value="รองผู้อำนวยการ" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'รองผู้อำนวยการ') echo 'selected'; ?>>รองผู้อำนวยการ</option>
                                    <option value="ครู" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'ครู') echo 'selected'; ?>>ครู</option>
                                    <option value="ครูชำนาญการ" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'ครูชำนาญการ') echo 'selected'; ?>>ครูชำนาญการ</option>
                                    <option value="ครูชำนาญการพิเศษ" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'ครูชำนาญการพิเศษ') echo 'selected'; ?>>ครูชำนาญการพิเศษ</option>
                                    <option value="ครูผู้ช่วย" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'ครูผู้ช่วย') echo 'selected'; ?>>ครูผู้ช่วย</option>
                                    <option value="พนักงานธุรการ" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'พนักงานธุรการ') echo 'selected'; ?>>พนักงานธุรการ</option>
                                    <option value="นักการ-ภารโรง" <?php if(isset($objResult['t_vac']) && $objResult['t_vac'] == 'นักการ-ภารโรง') echo 'selected'; ?>>นักการ-ภารโรง</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_group" class="form-label fw-bold">กลุ่มสาระการเรียนรู้<span class="text-danger">*</span></label>
                                <select id="t_group" name="t_group" class="form-select">
                                    <option value="กรุณาเลือก">กรุณาเลือก</option>
                                    <option value="-" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == '-') echo 'selected'; ?>>-</option>
                                    <option value="คณิตศาตร์" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'คณิตศาตร์') echo 'selected'; ?>>คณิตศาตร์</option>
                                    <option value="วิทยาศาสตร์" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'วิทยาศาสตร์') echo 'selected'; ?>>วิทยาศาสตร์</option>
                                    <option value="การงานอาชีพฯ" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'การงานอาชีพฯ') echo 'selected'; ?>>การงานอาชีพฯ</option>
                                    <option value="ภาษาต่างประเทศ" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'ภาษาต่างประเทศ') echo 'selected'; ?>>ภาษาต่างประเทศ</option>
                                    <option value="ภาษาไทย" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'ภาษาไทย') echo 'selected'; ?>>ภาษาไทย</option>
                                    <option value="สุขศึกษาและพละศึกษา" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'สุขศึกษาและพละศึกษา') echo 'selected'; ?>>สุขศึกษาและพละศึกษา</option>
                                    <option value="สังคมศึกษาฯ" <?php if(isset($objResult['t_group']) && $objResult['t_group'] == 'สังคมศึกษาฯ') echo 'selected'; ?>>สังคมศึกษาฯ</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_level" class="form-label fw-bold">ระดับชั้นที่สอน<span class="text-danger">*</span></label>
                                <input type="text" id="t_level" name="t_level" class="form-control" value="<?php echo $objResult['t_level']; ?>">
                            </div>                       
                            <!-- แถวที่ 3 -->
                            <div class="col-md-8 mt-3">
                                <label for="t_address" class="form-label fw-bold">ที่อยู่<span class="text-danger">*</span></label>
                                <input type="text" id="t_address" name="t_address" class="form-control" value="<?php echo $objResult['t_address']; ?>">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_mobile" class="form-label fw-bold">เบอร์โทรศัพท์<span class="text-danger">*</span></label>
                                <input type="text" id="t_mobile" name="t_mobile" class="form-control" value="<?php echo $objResult['t_mobile']; ?>">
                            </div> 
                            
                            <!-- ปุ่มบันทึก -->
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                                <button type="reset" class="btn btn-light">เคลียร์ข้อมูล</button>
                                <a href="index_edit.php" class="btn btn-warning">กลับ</a>
                                
                            </div>
                        </div>
                    </div>
                    <duv class="col-md-3">
                        <!-- ข้อมูลรูปภาพ -->
                        <div class="row mt-4">
                            <div class="col-md-12 mt-3">
                                <label for="t_image" class="form-label fw-bold">รูปภาพนักเรียน</label>
                                <input class="form-control" id="t_image" name="t_image" type="file" onchange="loadFile(event)">
                            </div>
                            <div class="col-md-12 mt-3" style="border: 3px dashed #f08080;background-color:#FFFFE0">
                                <?php
                                if ($objResult['t_image'] != '') {
                                    ?>
                                    <img src="./images/<?php echo $objResult['t_image']; ?>" class="img-thumbnail" id="t_image_preview" />
                                <?php
                                } else {
                                    ?>
                                    <img src="./images/baby.jpg" class="img-thumbnail" id="t_image_preview" />
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                        <script>
                            function loadFile(event) {
                                var image_preview = document.getElementById('t_image_preview');
                                image_preview.src = URL.createObjectURL(event.target.files[0]);
                            }
                        </script>

                    </duv>
            </form>
        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <span class="text-muted">&copy; 2021</span>
        </div>
    </footer>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/script.js"></script>
    <script>
        var loadFile = function(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('t_image_preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>