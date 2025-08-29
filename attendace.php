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

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Attendace</title>
  <link rel="stylesheet" href="css/attenst.css" />
  <script src="js/main.js" defer></script>
  <script src="js/addtendace.js"></script>
  <script src="js/submit.js" defer></script>
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      background-image: url("images/natural.png");
      background-size: cover;
      background-position: center;
    }

    .attendaceform {
      font-size: 20px;
      position: absolute;
      top: 45%;
      left: 40%;
      transform: translate(-50%, -50%);
      background-color: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      text-align: center;
    }

    .attendaceformsec {
      font-size: 20px;
      position: absolute;
      top: 45%;
      left: 60%;
      transform: translate(-50%, -50%);
      background-color: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class="bx bxl-c-plus-plus icon"></i>
      <div class="logo_name">CodingLab</div>
      <i class="bx bx-menu" id="btn"></i>
    </div>
    <ul class="nav-list">
      <li>
        <a href="attendace.php">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">Attendace</span>
        </a>
        <span class="tooltip">Attendace</span>
      </li>
      <li>
        <a href="report.php">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">History</span>
        </a>
        <span class="tooltip">History</span>
      </li>
      <li>
        <a href="profile.php">
          <i class="bx bx-user"></i>
          <span class="links_name">Profile</span>
        </a>
        <span class="tooltip">Profile</span>
      </li>
      <li class="profile">
        <div class="profile-details">
          <img src="images/default2.jpg" />
          <div class="name_job">
            <div class="name">Employee</div>
            <div class="job">Welcome</div>
          </div>
        </div>
        <a href="logout.php"><i class="bx bx-log-out" id="log_out"></i></a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <div class="datatime">
      <div class="time">00:00 AM</div>
      <div class="date">Monday, 1 January 2000</div>
    </div>
    <div class="attendaceform">
      <h1>Time in</h1>
      <form method="post" action="add_time.php">
        <label for="date">Date:</label>
        <input type="date" name="date" required><br><br>
        <label for="time_in">Time in:</label>
        <input type="time" name="time_in" required><br><br>
        <label for="reason">Reason:</label>
        <select name="reason">
          <option value="1">-</option>
          <option value="2">leave</option>
          <option value="3">sick</option>
          <option value="4">other</option>
        </select><br><br>
        <input type="submit" value="บันทึกเวลา">
      </form>
    </div>
    <div class="attendaceformsec">
      <h1>Time out</h1>
      <form method="post" action="update_time.php">
        <label for="date">Date:</label>
        <input type="date" name="date" required><br><br>
        <label for="time_out">Time out:</label>
        <input type="time" name="time_out" required><br><br>
        <input type="submit" value="Save">
      </form>
    </div>
  </section>

  <script>
    //slidebar
    let sidebar = document.querySelector(".sidebar");
    let closeBtn = document.querySelector("#btn");
    let searchBtn = document.querySelector(".bx-search");
    closeBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      menuBtnChange(); //calling the function(optional)
    });
    searchBtn.addEventListener("click", () => {
      // Sidebar open when you click on the search iocn
      sidebar.classList.toggle("open");
      menuBtnChange(); //calling the function(optional)
    });
    // following are the code to change sidebar button(optional)
    function menuBtnChange() {
      if (sidebar.classList.contains("open")) {
        closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
      } else {
        closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
      }
    }
    // Check if the PHP has echoed a success message
    let successMessage = "<?php echo isset($_POST['date']) ? 'Time recorded successfully' : '' ?>";
    if (successMessage) {
      alert(successMessage); // Optional: Show a message to the user
      window.location.href = 'attendace.php'; // Redirect to the "attendace.php" page
    }

    // Check if the PHP has echoed a success message
    let successMessage = "<?php echo isset($_POST['date']) ? 'Time recorded successfully' : '' ?>";
    if (successMessage) {
      alert(successMessage); // Optional: Show a message to the user
      window.location.href = 'attendace.php'; // Redirect to the "attendace.php" page
    }
  </script>

</body>

</html>