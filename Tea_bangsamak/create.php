<!doctype html>
<html lang="th" class="h-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>เพิ่มข้อมูลครู</title>
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
            <h1 class="mt-5">เพิ่มข้อมูลครู</h1>
            <!-- ฟอร์มเพิ่มข้อมูล -->
            <form action="action_create.php" id="form_create" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                <div class="row">
                    <div class="col-md-9">
                        <!-- ข้อมูลเนื้อหา -->
                        <div class="row mt-4">
                            <!-- แถวที่ 1 -->
                            <div class="col-md-4 mt-3">
                                <label for="t_prefix" class="form-label">คำนำหน้าชื่อ <span class="text-danger">*</span></label>
                                <select id="t_prefix" name="t_prefix" class="form-select">
                                    <option value="o1">กรุณาเลือก</option>
                                    <option value="นาย">นาย</option>
                                    <option value="นางสาว">นางสาว</option>
                                    <option value="นาง">นาง</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_firstname" class="form-label">ชื่อ <span class="text-danger">*</span></label>
                                <input type="text" id="t_firstname" name="t_firstname" class="form-control" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_lastname" class="form-label">สกุล <span class="text-danger">*</span></label>
                                <input type="text" id="t_lastname" name="t_lastname" class="form-control" required>
                            </div>
                            <!-- แถวที่ 2 -->
                            <div class="col-md-4 mt-3">
                                <label for="t_vac" class="form-label">ตำแหน่ง <span class="text-danger">*</span></label>
                                <select id="t_vac" name="t_vac" class="form-select">
                                    <option value="กรุณาเลือก">กรุณาเลือก</option>
                                    <option value="ผู้อำนวยการ">ผู้อำนวยการ</option>
                                    <option value="รองผู้อำนวยการ">รองผู้อำนวยการ</option>
                                    <option value="ครู">ครู</option>
                                    <option value="ครูชำนาญการ">ครูชำนาญการ</option>
                                    <option value="ครูชำนาญการพิเศษ">ครูชำนาญการพิเศษ</option>
                                    <option value="ครูผู้ช่วย">ครูผู้ช่วย</option>
                                    <option value="พนักงานธุรการ">พนักงานธุรการ</option>
                                    <option value="นักการ-ภารโรง">นักการ-ภารโรง</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_group" class="form-label">กลุ่มสาระการเรียนรู้ <span class="text-danger">*</span></label>
                                <select id="t_group" name="t_group" class="form-select">
                                    <option value="กรุณาเลือก">กรุณาเลือก</option>
                                    <option value="-">-</option>
                                    <option value="คณิตศาตร์">คณิตศาตร์</option>
                                    <option value="วิทยาศาสตร์">วิทยาศาสตร์</option>
                                    <option value="การงานอาชีพฯ">การงานอาชีพฯ</option>
                                    <option value="ภาษาต่างประเทศ">ภาษาต่างประเทศ</option>
                                    <option value="ภาษาไทย">ภาษาไทย</option>
                                    <option value="สุขศึกษาและพละศึกษา">สุขศึกษาและพละศึกษา</option>
                                    <option value="สังคมศึกษาฯ">สังคมศึกษาฯ</option>
                                </select>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="t_level" class="form-label">ระดับชั้นที่สอน <span class="text-danger">*</span></label>
                                <input type="text" id="t_level" name="t_level" class="form-control" required>
                            </div>                          
                            <!-- แถวที่ 3 -->
                            <div class="col-md-8 mt-3">
                                <label for="t_address" class="form-label">ที่อยู่<span class="text-danger">*</span></label>
                                <input type="text" id="t_address" name="t_address" class="form-control" required>
                            </div> 
                            <div class="col-md-4 mt-3">
                                <label for="t_mobile" class="form-label">เบอร์โทรศัพท์<span class="text-danger">*</span></label>
                                <input type="text" id="t_mobile" name="t_mobile" class="form-control" required>
                            </div> 
                                                        <!-- ปุ่มบันทึก -->
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">บันทึกข้อมูล</button>
                                <button type="reset" class="btn btn-light">เคลียร์ข้อมูล</button>
                                <a href="index_edit.php" class="btn btn-warning">กลับหน้าหลัก</a>
                            </div>
                        </div>
                    </div>
                    <duv class="col-md-3">
                        <!-- ข้อมูลรูปภาพ -->
                        <div class="row mt-4">
                            <div class="col-md-12 mt-3">
                                <label for="t_image" class="form-label">รูปภาพ</label>
                                <input class="form-control" id="t_image" name="t_image" type="file" onchange="loadFile(event)">
                            </div>
                            <div class="col-md-12 mt-3" style="border: 3px dashed #f08080;background-color:#FFFFE0">
                                <img src="./images/noimg.png" class="img-thumbnail" id="t_image_preview" />
                            </div>
                        </div>
                    </duv>
                </div>
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