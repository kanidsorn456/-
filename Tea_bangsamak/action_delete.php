<?php
    include_once('./function.php');
    $objCon = connectDB();
    $t_id = (int) $_GET['t_id'];

    // ลบข้อมูลจากตาราง teacher ที่มี t_id ตรงกับที่ระบุ
    $strSQL = "DELETE FROM teacher WHERE t_id = $t_id";
    
    $objQuery = mysqli_query($objCon, $strSQL);
    if($objQuery) {
        echo '<script>alert("ลบข้อมูลแล้ว");window.location="index_edit.php";</script>';
    } else {
        echo '<script>alert("พบข้อผิดพลาด");window.location="index_edit.php";</script>';
    }
?>
