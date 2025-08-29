<?php
session_start();

$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

// Create connection
$conn = mysqli_connect($servername, $usersname, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ส่วนของคิวรีอ่านข้อมูลผู้ใช้
$user_id = $_SESSION['user_id'];
$sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, e.birth, e.sex, e.address, e.phone, e.email
        FROM employee e
        LEFT JOIN department d ON e.dep = d.dep_id
        WHERE e.emp_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Editprofile</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/profileedit.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>

<body>
    
    <section>
        <div class="container">
        <p id="successMessage" style="color: green; display: none;">The recording was successful</p>
            <h1>แก้ไขข้อมูล</h1>
            <form method="post" action="edit_profile_process.php" enctype="multipart/form-data">
                <!-- เพิ่มฟิลด์สำหรับอัปโหลดรูปภาพ -->
                <label for="profile_image">Profile:</label>
                <input type="file" name="profile_image"><br><br>
                <label for="dep">Employee ID:</label>
                <input type="text" name="emp_id" value="<?php echo $row['emp_id']; ?>" disabled='disabled'><br><br>
                <label for="fname">Firstname:</label>
                <input type="text" name="fname" value="<?php echo $row['fname']; ?>"><br><br>
                <label for="lname">Lastname:</label>
                <input type="text" name="lname" value="<?php echo $row['lname']; ?>"><br><br>
                <label for="dep">Department:</label>
                <input type="text" name="dep" value="<?php echo $row['dname']; ?>" disabled='disabled'><br><br>
                <label for="birth">Birthday:</label>
                <input type="date" name="birth" value="<?php echo $row['birth']; ?>"><br><br>
                <label for="birth">Gender:</label>
                <input type="text" name="sex" value="<?php echo $row['sex']; ?>"><br><br>
                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo $row['address']; ?>"><br><br>
                <label for="phone">Phone:</label>
                <input type="text" name="phone" value="<?php echo $row['phone']; ?>"><br><br>
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo $row['email']; ?>"><br><br>
                <p id="successMessage" style="color: green;"></p>
                <input type="submit" value="Save" id="saveButton">
                <button type="button" id="cancelButton" onclick="cancelEdit()">Cancel</button>
            </form>
        </div>
    </section>
    <script>
        var saveButton = document.getElementById("saveButton");
        var successMessage = document.getElementById("successMessage");

        saveButton.addEventListener("click", function(event) {
            event.preventDefault();
            var formData = new FormData(document.querySelector("form"));
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "edit_profile_process.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    if (xhr.responseText == "success") {
                        successMessage.textContent = "The recording was successful";
                        successMessage.style.color = "green";
                        successMessage.style.display = "block";
                        // เรียก redirectToProfile() เพื่อนำผู้ใช้กลับไปยังหน้าโปรไฟล์
                        redirectToProfile();
                    } else {
                        alert("Data editing failed: " + xhr.responseText);
                    }
                }
            };
            xhr.send(formData);
        });

        function cancelEdit() {
            window.location.href = "profile.php";
        }

        function redirectToProfile() {
            setTimeout(function() {
                window.location.href = "profile.php";
            }, 2000);
        }
    </script>
</body>

</html>