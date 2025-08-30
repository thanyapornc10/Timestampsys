<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
}

$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = mysqli_connect($servername, $usersname, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $date = $_POST['date'];
    $time_out = $_POST['time_out'];

    $check_sql = "SELECT * FROM time_stamp WHERE id_time = $user_id AND timedate = '$date' AND time_out IS NULL";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows == 1) {
        $update_sql = "UPDATE time_stamp SET time_out = '$time_out' WHERE id_time = $user_id AND timedate = '$date' AND time_out IS NULL";

        if (mysqli_query($conn, $update_sql)) {
            echo "Time recorded successfully";
        } else {
            echo "Time recording failed: " . mysqli_error($conn);
        }
    } else {
        echo "No attendance data";
    }
}
?>
<script>
    let successMessage = "<?php echo isset($_POST['date']) ? 'Time recorded successfully' : '' ?>";
    if (successMessage) {
        alert(successMessage);
        window.location.href = 'attendace.php';
    }
</script>