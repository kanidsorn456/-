<?php
include_once('./function.php');
$objCon = connectDB();

$data = $_POST;
// print_r($data);
$t_prefix = $data['t_prefix'];
$t_firstname = $data['t_firstname'];
$t_lastname = $data['t_lastname'];
$t_id = $data['t_id'];
$t_birthdate = $data['t_birthdate'];
$t_mobile = $data['t_mobile'];
$t_group = $data['t_group'];
$t_vac = $data['t_vac'];
$t_level = $data['t_level'];
$t_address = $data['t_address'];
$t_image = 'noimg.png'; // Default image

if (!is_array($_FILES["t_image"]["name"])) {
    // Check if an image is uploaded
    if (!empty($_FILES["t_image"]["name"])) {
        $exts = explode('.', $_FILES["t_image"]["name"]);
        $ext = $exts[count($exts) - 1]; // Get image extension (e.g., jpeg, jpg, png)
        $fileName = date("YmdHis") . '_' . randomString() . "." . $ext;
        if (file_exists($output_dir . $fileName)) {
            $fileName = date("YmdHis") . '_' . randomString() . "." . $ext;
        }
        $t_image = $fileName; // Set image value
        @move_uploaded_file($_FILES["t_image"]["tmp_name"], $output_dir . '/' . $fileName);
    }
}

$strSQL = "INSERT INTO 
teacher(
    `t_prefix`,
    `t_firstname`,
    `t_lastname`, 
    `t_id`, 
    `t_birthdate`, 
    `t_mobile`, 
    `t_group`, 
    `t_vac`, 
    `t_level`, 
    `t_address`, 
    `t_image`
) VALUES (
    '$t_prefix', 
    '$t_firstname', 
    '$t_lastname', 
    '$t_id', 
    '$t_birthdate', 
    '$t_mobile', 
    '$t_group',
    '$t_vac',
    '$t_level',
    '$t_address',
    '$t_image'
)";

$objQuery = mysqli_query($objCon, $strSQL) or die(mysqli_error($objCon));
if ($objQuery) {
    echo '<script>alert("เพิ่มข้อมูลแล้ว");window.location="index_edit.php";</script>';
} else {
    echo '<script>alert("พบข้อผิดพลาด");window.location="create.php";</script>';
}
