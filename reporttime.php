<?php
session_start();
if (!isset($_SESSION['useradmin'])) {
  header("Location: selected.php");
  exit();
}

$host = "localhost";
$username = "root";
$password = "";
$database = "data_time";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
  die("Failed to connect to database: " . $conn->connect_error);
}

$start_date = ""; // Initialize the start_date variable

if (isset($_POST['search'])) {
  // If the form is submitted, get the selected start_date
  $start_date = $_POST['start_date'];
  // Add a WHERE clause to the SQL query to filter by start_date
  $sql = "SELECT employee.emp_id, employee.fname, employee.lname, department.dname, time_stamp.timedate, time_stamp.time_in, time_stamp.time_out, reason.rname
    FROM time_stamp
    INNER JOIN employee ON time_stamp.id_time = employee.emp_id
    INNER JOIN department ON employee.dep = department.dep_id
    LEFT JOIN reason ON time_stamp.reason = reason.r_id
    WHERE time_stamp.timedate = '$start_date'
    ORDER BY time_stamp.timedate DESC";
} else {
  // If the form is not submitted, display all records
  $sql = "SELECT employee.emp_id, employee.fname, employee.lname, department.dname, time_stamp.timedate, time_stamp.time_in, time_stamp.time_out, reason.rname
    FROM time_stamp
    INNER JOIN employee ON time_stamp.id_time = employee.emp_id
    INNER JOIN department ON employee.dep = department.dep_id
    LEFT JOIN reason ON time_stamp.reason = reason.r_id
    ORDER BY time_stamp.timedate DESC";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Report time employee</title>
  <link rel="stylesheet" href="css/timeedst.css" />
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <style>
    tr, td {
      border-bottom: 1px solid #ddd;
    }

    table {
      font-size: 18px;
      border-collapse: collapse;
      width: 100%;
    }

    table td, table th {
      border: 1px solid #ddd;
      padding: 20px;
      text-align: center;
    }

    table th {
      background-color: #f2f2f2;
    }

    table td {
      font-size: 18px;
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
                <a href="dashboard.php">
                    <i class="bx bx-grid-alt"></i>
                    <span class="links_name">Attendace</span>
                </a>
                <span class="tooltip">Attendace</span>
            </li>
            <li>
                <a href="reportemployee.php">
                    <i class="bx bx-user"></i>
                    <span class="links_name">Employee</span>
                </a>
                <span class="tooltip">Employee</span>
            </li>
            <li>
                <a href="reporttime.php">
                    <i class="bx bx-pie-chart-alt-2"></i>
                    <span class="links_name">Report</span>
                </a>
                <span class="tooltip">Report</span>
            </li>
            <li class="profile">
                <div class="profile-details">
                    <img src="images/default2.jpg" alt="profileImg" />
                    <div class="name_job">
                        <div class="name">Admin</div>
                        <div class="job">Welcome</div>
                    </div>
                </div>
                <a href="logout.php"><i class="bx bx-log-out" id="log_out"></i></a>
            </li>
        </ul>
    </div>

  <section class="home-section">
    <div class="content">
      <h1>Report all time</h1>
      <form method="POST">
        <label for="start_date">Select date:</label>
        <input type="date" name="start_date" id="start_date" value="<?php echo $start_date; ?>">
        <input type="submit" name="search" value="Search">
      </form><br>
      <div class="tables">
      <table border="1">
        <tr>
          <th>Employee ID</th>
          <th>Firstname</th>
          <th>Lastname</th>
          <th>Department</th>
          <th>Date</th>
          <th>Time in</th>
          <th>Time out</th>
          <th>Reason</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['emp_id'] . "</td>";
            echo "<td>" . $row['fname'] . "</td>";
            echo "<td>" . $row['lname'] . "</td>";
            echo "<td>" . $row['dname'] . "</td>";
            echo "<td>" . $row['timedate'] . "</td>";
            echo "<td>" . $row['time_in'] . "</td>";
            echo "<td>" . $row['time_out'] . "</td>";
            echo "<td>" . ($row['rname'] ? $row['rname'] : 'No reason') . "</td>";
            echo "</tr>";
          }
        } else {
          echo "No information found";
        }
        ?>
      </table>
      </div>
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
  </script>
</body>

</html>
   
