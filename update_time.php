<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $time_out = $_POST['time_out'];

    // เช็คว่ามีข้อมูลในวันที่และเวลาออกนี้หรือไม่
    $check_sql = "SELECT * FROM time_stamp WHERE id_time = $user_id AND timedate = '$date' AND time_out IS NULL";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 1) {
        $update_sql = "UPDATE time_stamp SET time_out = '$time_out' WHERE id_time = $user_id AND timedate = '$date' AND time_out IS NULL";

        if (mysqli_query($conn, $update_sql)) {
            echo "อัพเดตเวลาเรียบร้อย";
        } else {
            echo "การอัพเดตเวลาล้มเหลว: " . mysqli_error($conn);
        }
    } else {
        echo "ไม่พบข้อมูลเวลาที่ต้องการอัพเดต";
    }
}
?>
<script>
  // Check if the PHP has echoed a success message
  let successMessage = "<?php echo isset($_POST['date']) ? 'บันทึกเวลาเรียบร้อย' : '' ?>";
  if (successMessage) {
    alert(successMessage); // Optional: Show a message to the user
    window.location.href = 'attendace.php'; // Redirect to the "attendace.php" page
  }
</script>

