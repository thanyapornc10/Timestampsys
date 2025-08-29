<?php
session_start();
if (!isset($_SESSION['useradmin'])) {
    header("Location: selected.php");
    exit();
}

$host = "localhost";
$usersname = "root";
$password = "";
$database = "data_time";

$conn = new mysqli($host, $usersname, $password, $database);

if ($conn->connect_error) {
    die("Failed to connect to the database: " . $conn->connect_error);
}

$sql = "SELECT employee.emp_id, employee.fname, employee.lname, department.dname, employee.birth, employee.sex, employee.email, employee.phone, employee.address
        FROM employee
        LEFT JOIN department ON employee.dep = department.dep_id";

if (isset($_GET['department_filter']) && $_GET['department_filter'] !== "") {
    $departmentFilter = $_GET['department_filter'];
    $sql .= " WHERE department.dname = '$departmentFilter'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Reort all employee</title>
    <link rel="stylesheet" href="css/reportemst.css" />
    <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
        tr,
        td {
            border-bottom: 1px solid #ddd;
        }

        table {
            font-size: 18px;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        table th {
            background-color: #f2f2f2;
        }

        table tr,
        table th,
        table td {
            padding: 12px;
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
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="reportemployee.php">
                    <i class="bx bx-pie-chart-alt-2"></i>
                    <span class="links_name">Employee</span>
                </a>
                <span class="tooltip">Employee</span>
            </li>
            <li>
                <a href="reporttime.php">
                    <i class="bx bx-user"></i>
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
            <h1>Report</h1>
            <form method="get">
                <select name="department_filter" id="department_filter">
                    <option value="">All</option>
                    <option value="QA">QA</option>
                    <option value="HR">HR</option>
                    <option value="CEO">CEO</option>
                    <option value="SA">SA</option>
                    <option value="Supp">Supp</option>
                </select>
                <button type="submit">Filter</button>
            </form>
            <a href="add_employee.php" class="add-employee-button">Add new</a>
            <br><br>
            <table>
                <tr>
                    <th>Employee ID</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Department</th>
                    <th>Birthday</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Adress</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['emp_id'] . "</td>";
                        echo "<td>" . $row['fname'] . "</td>";
                        echo "<td>" . $row['lname'] . "</td>";
                        echo "<td>" . $row['dname'] . "</td>";
                        echo "<td>" . $row['birth'] . "</td>";
                        echo "<td>" . $row['sex'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['phone'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td><a href='edit_employee.php?id=" . $row['emp_id'] . "' class='edit-button'>Edit</a></td>";
                        echo "<td><a href='delete_employee.php?id=" . $row['emp_id'] . "' class='delete-button' onclick='return confirmDelete()'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Employee information not found.";
                }
                ?>
            </table>
        </div>
    </section>
    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this information?");
        }
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