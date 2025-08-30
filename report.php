<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$usersname  = "root";
$password   = "";
$database   = "data_time";

$conn = mysqli_connect($servername, $usersname, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = (int)$_SESSION['user_id'];

$sqlUser = "SELECT e.emp_id, e.fname, e.lname, d.dname, e.birth, e.sex, e.address, e.phone, e.email
            FROM employee e
            LEFT JOIN department d ON e.dep = d.dep_id
            WHERE e.emp_id = ?";

$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("i", $user_id);
$stmtUser->execute();
$user = $stmtUser->get_result()->fetch_assoc();
$stmtUser->close();

$imagePath = "images/default2.jpg";
$sqlImg = "SELECT image_path FROM employee WHERE emp_id = ?";
$stmtImg = $conn->prepare($sqlImg);
$stmtImg->bind_param("i", $user_id);
$stmtImg->execute();
$imgRes = $stmtImg->get_result();
if ($imgRes && $imgRes->num_rows > 0) {
    $imgRow = $imgRes->fetch_assoc();
    if (!empty($imgRow['image_path'])) {
        $imagePath = $imgRow['image_path'];
    }
}

$stmtImg->close();

$hasRange = isset($_POST['start_date']) && isset($_POST['end_date']) && $_POST['start_date'] !== "" && $_POST['end_date'] !== "";

if ($hasRange) {
    $start_date = $_POST['start_date'];
    $end_date   = $_POST['end_date'];

    $sqlReport = "SELECT e.emp_id, e.fname, e.lname, d.dname, t.timedate, t.time_in, t.time_out, r.rname
                  FROM employee e
                  LEFT JOIN department d ON e.dep = d.dep_id
                  LEFT JOIN time_stamp t ON e.emp_id = t.id_time
                  LEFT JOIN reason r ON t.reason = r.r_id
                  WHERE e.emp_id = ?
                    AND t.timedate BETWEEN ? AND ?
                  ORDER BY t.timedate";
    $stmtReport = $conn->prepare($sqlReport);
    $stmtReport->bind_param("iss", $user_id, $start_date, $end_date);
} else {
    $sqlReport = "SELECT e.emp_id, e.fname, e.lname, d.dname, t.timedate, t.time_in, t.time_out, r.rname
                  FROM employee e
                  LEFT JOIN department d ON e.dep = d.dep_id
                  LEFT JOIN time_stamp t ON e.emp_id = t.id_time
                  LEFT JOIN reason r ON t.reason = r.r_id
                  WHERE e.emp_id = ?
                  ORDER BY t.timedate";
    $stmtReport = $conn->prepare($sqlReport);
    $stmtReport->bind_param("i", $user_id);
}

$stmtReport->execute();
$reportResult = $stmtReport->get_result();

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="css/reportst.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Report</title>

    <style>
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
                    <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Employee Image" />
                    <div class="name_job">
                        <div class="name"><?php echo htmlspecialchars($user['fname'] ?? 'Employee'); ?></div>
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

            <form method="post" action="report.php">
                <label for="start_date">Start:</label>
                <input type="date" name="start_date" value="<?php echo htmlspecialchars($_POST['start_date'] ?? ""); ?>" required>
                <label for="end_date">End:</label>
                <input type="date" name="end_date" value="<?php echo htmlspecialchars($_POST['end_date'] ?? ""); ?>" required>
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
                <?php if ($reportResult && $reportResult->num_rows > 0): ?>
                    <?php while ($row = $reportResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['emp_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['fname']); ?></td>
                            <td><?php echo htmlspecialchars($row['lname']); ?></td>
                            <td><?php echo htmlspecialchars($row['dname']); ?></td>
                            <td><?php echo htmlspecialchars($row['timedate']); ?></td>
                            <td><?php echo htmlspecialchars($row['time_in']); ?></td>
                            <td><?php echo htmlspecialchars($row['time_out']); ?></td>
                            <td><?php echo htmlspecialchars($row['rname']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Report data not found</td>
                    </tr>
                <?php endif; ?>
            </table>
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
        if (searchBtn) {
            searchBtn.addEventListener("click", () => {
                sidebar.classList.toggle("open");
                menuBtnChange();
            });
        }

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