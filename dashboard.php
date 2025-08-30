<?php
session_start();
if (!isset($_SESSION['useradmin'])) {
    header("Location: selected.php");
    exit();
}

$servername = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = mysqli_connect($servername, $usersname, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT COUNT(*) AS employee_count FROM employee";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Dashbord</title>
    <link rel="stylesheet" href="css/dashst.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        body {
            background-image: url("images/hill.jpg");
            background-size: cover;
            background-position: center;
        }

        .employee-count {
            position: fixed;
            left: 0;
            top: 0;
            width: 78px;
            height: 100%;
            background-color: #4CAF50;
            color: white;
            text-align: center;
            font-size: 24px;
            padding-top: 20px;
            z-index: 99;
        }

        .count {
            font-size: 36px;
        }

        .home-section {
            position: relative;
            background: #e4e9f7;
            min-height: 100vh;
            top: 0;
            left: 78px;
            width: calc(100% - 78px);
            transition: all 0.5s ease;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sidebar.open~.home-section {
            left: 250px;
            width: calc(100% - 250px);
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
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
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
                    <span class="links_name">Reort</span>
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
            <div class="alert alert-primary" role="alert">
                <?php if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $employeeCount = $row["employee_count"];
                    echo "Total Employee: " . $employeeCount;
                } else {
                    echo "Employee information not found";
                } ?></span>
            </div>
        </div>
    </section>
    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");
        let searchBtn = document.querySelector(".bx-search");
        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange();
        });
        searchBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange();
        });

        function menuBtnChange() {
            if (sidebar.classList.contains("open")) {
                closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
            } else {
                closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
            }
        }
    </script>
</body>

</html>