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
    $time_in = $_POST['time_in'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO time_stamp (id_time, timedate, time_in, reason)
            VALUES ($user_id, '$date', '$time_in', $reason)";

    if (mysqli_query($conn, $sql)) {
        echo "Time recorded successfully";
    } else {
        echo "Time recording failed: " . mysqli_error($conn);
    }
}
?>
<script>
    // Check if the PHP has echoed a success message
let successMessage = "<?php echo isset($_POST['date']) ? 'Time recorded successfully' : '' ?>";
if (successMessage) {
  alert(successMessage); // Optional: Show a message to the user
  window.location.href = 'attendace.php'; // Redirect to the "attendace.php" page
}

</script>