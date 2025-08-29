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

$user_id = $_SESSION['user_id'];

// คำสั่ง SQL ที่ใช้เรียกดูข้อมูล
$sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, t.timedate, t.time_in, t.time_out, r.rname
        FROM employee e
        LEFT JOIN department d ON e.dep = d.dep_id
        LEFT JOIN time_stamp t ON e.emp_id = t.id_time
        LEFT JOIN reason r ON t.reason = r.r_id
        WHERE e.emp_id = $user_id
        ORDER BY t.timedate";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<!-- Created by CodingLab |www.youtube.com/CodingLabYT-->
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/reportst.css" />
    <!-- Boxicons CDN Link -->
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>
    <style>
        /* CSS สำหรับการพิมพ์ */
        @media print {
            body {
                font-size: 12px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #000;
                text-align: left;
                padding: 6px;
            }
        }

        /* CSS สำหรับการแสดงผลบนหน้าเว็บ */
        body {
            font-size: 16px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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
        <div class="content">
            <h1>Report</h1>
            <!-- เพิ่มแบบฟอร์มสำหรับเลือกวันที่ -->
            <form method="post" action="report.php">
                <label for="start_date">Start:</label>
                <input type="date" name="start_date" required>
                <label for="end_date">End:</label>
                <input type="date" name="end_date" required>
                <input type="submit" value="Report">
            </form>
            
            <br><br>
            <table>
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
                // เพิ่มโค้ด PHP เพื่อรับวันที่เริ่มต้นและสิ้นสุดจากแบบฟอร์ม
                if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
                    $start_date = $_POST['start_date'];
                    $end_date = $_POST['end_date'];

                    // สร้างคำสั่ง SQL ที่ใช้วันที่เป็นเงื่อนไข
                    $sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, t.timedate, t.time_in, t.time_out, r.rname
                    FROM employee e
                    LEFT JOIN department d ON e.dep = d.dep_id
                    LEFT JOIN time_stamp t ON e.emp_id = t.id_time
                    LEFT JOIN reason r ON t.reason = r.r_id
                    WHERE e.emp_id = $user_id
                    AND t.timedate BETWEEN '$start_date' AND '$end_date'
                    ORDER BY t.timedate";
                } else {
                    // คำสั่ง SQL เดิมที่ใช้รหัสพนักงานเท่านั้น
                    $sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, t.timedate, t.time_in, t.time_out, r.rname
                    FROM employee e
                    LEFT JOIN department d ON e.dep = d.dep_id
                    LEFT JOIN time_stamp t ON e.emp_id = t.id_time
                    LEFT JOIN reason r ON t.reason = r.r_id
                    WHERE e.emp_id = $user_id
                    ORDER BY t.timedate";
                }

                // ดำเนินการคิวรีดึงข้อมูล
                $result = $conn->query($sql);

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
                        echo "<td>" . $row['rname'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Report data not found";
                }
                ?>
            </table>
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