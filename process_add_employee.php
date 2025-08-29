<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST['emp_id'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $dep = $_POST['dep'];
    $sex = $_POST['sex'];
    $birth = $_POST['birth'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. อัปโหลดรูปภาพ
    $image = $_FILES['image'];
    $image_name = $image['name'];
    $image_tmp = $image['tmp_name'];
    $image_path = "uploads/" . $image_name;

    if (move_uploaded_file($image_tmp, $image_path)) {
        echo "Image uploaded successfully";
        
        // 2. นำข้อมูลเข้าสู่ฐานข้อมูล
        $servername = "localhost";
        $usersname = "root";
        $password = "";
        $database = "data_time";

        $conn = mysqli_connect($servername, $usersname, $password, $database);

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO employee (emp_id, fname, lname, dep, sex, birth, email, phone, address, image_path)
                VALUES ('$emp_id', '$fname', '$lname', '$dep', '$sex', '$birth', '$email', '$phone', '$address', '$image_path')";

        if (mysqli_query($conn, $sql)) {
            // 3. เพิ่มชื่อผู้ใช้และรหัสผ่าน
            $user_sql = "INSERT INTO users (username, password, users_id)
                         VALUES ('$username', '$password', '$emp_id')";
            if (mysqli_query($conn, $user_sql)) {
                // บันทึกสำเร็จ
                echo "Employee information has been added successfully.";
                
                // แสดง Alert
                echo "<script>alert('Employee information has been added successfully.');</script>";
                
                // กลับไปที่หน้า reportemployee.php
                echo "<script>window.location.href = 'reportemployee.php';</script>";
            } else {
                echo "Failed to add employee information: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to add employee information: " . mysqli_error($conn);
        }

        mysqli_close($conn);
    } else {
        echo "Image upload failed";
    }
}
?>
