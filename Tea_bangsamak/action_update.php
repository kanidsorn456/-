<?php
include_once('./function.php');
$objCon = connectDB();

$data = $_POST;
$t_id = $data['t_id'];
// print_r($data);

$output_dir = 'images'; // folder
$uploadSuccess = true; // Flag ในการตรวจสอบว่าการอัปโหลดสำเร็จหรือไม่

$t_image = null; // กำหนดตัวแปรเก็บชื่อไฟล์รูปภาพเริ่มต้นเป็น null

if ($_FILES["t_image"]["name"]) {
    if (!is_array($_FILES["t_image"]["name"])) {
        $exts = explode('.', $_FILES["t_image"]["name"]);
        $ext = $exts[count($exts) - 1]; // get ext image ex. jpeg, jpg, png
        $fileName = date("YmdHis") . '_' . randomString() . "." . $ext;
        if (file_exists($output_dir . $fileName)) {
            $fileName = $fileName = date("YmdHis") . '_' . randomString() . "." . $ext;
        }
        $t_image = $fileName; // set image value
        move_uploaded_file($_FILES["t_image"]["tmp_name"], $output_dir . '/' . $fileName);
    } else {
        $t_image = null;
    }
} else {
    $t_image = null;
}

$t_prefix = $data['t_prefix'];
$t_firstname = $data['t_firstname'];
$t_lastname = $data['t_lastname'];
$t_vac = $data['t_vac'];
$t_mobile = $data['t_mobile'];
$t_group = $data['t_group'];
$t_level = $data['t_level'];
$t_address = $data['t_address'];

// ตรวจสอบว่ามีการอัพโหลดรูปภาพหรือไม่
if ($t_image !== null) {
    $strSQL = "UPDATE teacher SET 
        t_prefix = '$t_prefix',
        t_firstname = '$t_firstname',
        t_lastname = '$t_lastname',
        t_id = '$t_id',
        t_vac = '$t_vac',
        t_mobile = '$t_mobile',
        t_group = '$t_group',
        t_level = '$t_level',
        t_address = '$t_address',
        t_image = '$t_image'
    WHERE t_id = '$t_id';";
} else {
    // ถ้าไม่มีการอัพโหลดรูปภาพใหม่ ให้ใช้รูปภาพเดิม
    $strSQL = "UPDATE teacher SET 
        t_prefix = '$t_prefix',
        t_firstname = '$t_firstname',
        t_lastname = '$t_lastname',
        t_id = '$t_id',
        t_vac = '$t_vac',
        t_mobile = '$t_mobile',
        t_group = '$t_group',
        t_level = '$t_level',
        t_address = '$t_address'
    WHERE t_id = '$t_id';";
}

if ($t_image !== null) {
    $strSQL .= ", t_image = '$t_image'";
}

$objQuery = mysqli_query($objCon, $strSQL);

if ($objQuery) {
    echo '<script>alert("บันทึกการแก้ไขแล้ว");window.location="index_edit.php";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด!!");window.location="update.php?t_id=' . $t_id . '";</script>';
}
?>
