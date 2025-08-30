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

$sql = "SELECT e.emp_id, e.fname, e.lname, d.dname, e.birth, e.sex, e.address, e.phone, e.email
        FROM employee e
        LEFT JOIN department d ON e.dep = d.dep_id
        WHERE e.emp_id = $user_id";
$result = $conn->query($sql);
$user = ($result && $result->num_rows === 1) ? $result->fetch_assoc() : null;

$imageSql = "SELECT image_path FROM employee WHERE emp_id = $user_id";
$imageResult = $conn->query($imageSql);
if ($imageResult && $imageResult->num_rows > 0) {
  $imgRow    = $imageResult->fetch_assoc();
  $imagePath = !empty($imgRow['image_path']) ? $imgRow['image_path'] : "images/default2.jpg";
} else {
  $imagePath = "images/default2.jpg";
}
/* ---------------------------------------------------------------------- */
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
    body{
      background-image:url("images/natural.png");
      background-size:cover;
      background-position:center;
      font-family:Arial, Helvetica, sans-serif;
    }
    .datatime{
      width:100%; text-align:center; margin-top:24px; color:#fff;
      text-shadow:0 2px 6px rgba(0,0,0,.35);
      display:flex; flex-direction:column; align-items:center;
    }
    .datatime .date{ font-weight:700; font-variant-numeric:tabular-nums; font-size:clamp(16px,1.8vw,22px); margin-bottom:10px; }
    .datatime .time{ font-weight:900; line-height:1.06; font-variant-numeric:tabular-nums; font-size:clamp(48px,7.5vw,96px); letter-spacing:1px; }

    .attendaceform, .attendaceformsec{
      width:360px; font-size:18px; position:absolute; top:45%;
      background:rgba(255,255,255,0.88); border-radius:18px; padding:22px 24px;
      box-shadow:0 12px 24px rgba(0,0,0,0.18); text-align:center; backdrop-filter:blur(2px);
    }
    .attendaceform{ left:33%; transform:translate(-50%,-50%); }
    .attendaceformsec{ left:67%; transform:translate(-50%,-50%); }

    .box-title{ font-weight:900; font-size:26px; margin-bottom:12px; color:#0f172a; }
    .label{ display:block; text-align:left; margin:10px 4px 6px; font-weight:700; color:#222; }
    .display{ background:#fff; border:1px solid #ececec; border-radius:12px; padding:12px 14px; text-align:center; font-size:18px; margin-bottom:12px; }

    select{ width:100%; padding:12px 12px; border:1px solid #d9d9d9; border-radius:12px; background:#fff; font-size:16px; outline:none; }

    .btn-green{
      width:100%; padding:14px 16px; border:none; border-radius:12px; background:#2eae4f; color:#fff;
      font-weight:900; letter-spacing:.2px; cursor:pointer; margin-top:14px;
      transition:transform .05s ease, filter .2s ease, box-shadow .2s ease;
      box-shadow:0 6px 14px rgba(46,174,79,.28);
    }
    .btn-green:hover{ filter:brightness(1.05); }
    .btn-green:active{ transform:translateY(1px); }
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
    <div class="datatime">
      <div class="date" id="bigDate">Monday, 1 January 2000</div>
      <div class="time" id="bigClock">00:00 AM</div>
    </div>

    <div class="attendaceform">
      <div class="box-title">Time In</div>
      <div class="label">Current Time:</div>
      <div class="display" id="showNowIn">--:--:--</div>

      <form id="formIn" method="post" action="add_time.php">
        <input type="hidden" name="date" id="dateIn">
        <input type="hidden" name="time_in" id="timeIn">
        <div class="label">Reason:</div>
        <select name="reason">
          <option value="1">-</option>
          <option value="2">leave</option>
          <option value="3">sick</option>
          <option value="4">other</option>
        </select>
        <button type="submit" class="btn-green">Check In</button>
      </form>
    </div>

    <div class="attendaceformsec">
      <div class="box-title">Time Out</div>
      <div class="label">Current Time:</div>
      <div class="display" id="showNowOut">--:--:--</div>

      <form id="formOut" method="post" action="update_time.php">
        <input type="hidden" name="date" id="dateOut">
        <input type="hidden" name="time_out" id="timeOut">
        <button type="submit" class="btn-green">Check Out</button>
      </form>
    </div>
  </section>

  <script>
    const sidebar = document.querySelector(".sidebar");
    const closeBtn = document.querySelector("#btn");
    const searchBtn = document.querySelector(".bx-search");
    closeBtn && closeBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      menuBtnChange();
    });
    searchBtn && searchBtn.addEventListener("click", () => {
      sidebar.classList.toggle("open");
      menuBtnChange();
    });
    function menuBtnChange(){
      if(!closeBtn) return;
      if(sidebar.classList.contains("open")){
        closeBtn.classList.replace("bx-menu","bx-menu-alt-right");
      }else{
        closeBtn.classList.replace("bx-menu-alt-right","bx-menu");
      }
    }

    const bigClock = document.getElementById('bigClock');
    const bigDate  = document.getElementById('bigDate');
    const showNowIn  = document.getElementById('showNowIn');
    const showNowOut = document.getElementById('showNowOut');

    const headerTimeFmt = new Intl.DateTimeFormat('en-GB',{hour:'2-digit',minute:'2-digit',hour12:true});
    const headerDateFmt = new Intl.DateTimeFormat('en-GB',{weekday:'long',day:'2-digit',month:'long',year:'numeric'});
    const boxTimeFmt    = new Intl.DateTimeFormat('en-GB',{hour:'2-digit',minute:'2-digit',second:'2-digit',hour12:true});

    function updateHeader(){
      const now = new Date();
      bigClock.textContent = headerTimeFmt.format(now);
      bigDate.textContent  = headerDateFmt.format(now);
    }
    function scheduleMinuteTicker(){
      updateHeader();
      const now = new Date();
      const msToNextMinute = (60 - now.getSeconds())*1000 - now.getMilliseconds();
      setTimeout(()=>{
        updateHeader();
        setInterval(updateHeader, 60000);
      }, msToNextMinute);
    }
    scheduleMinuteTicker();

    function updateBoxes(){
      const now = new Date();
      const t = boxTimeFmt.format(now);
      showNowIn.textContent  = t;
      showNowOut.textContent = t;
    }
    updateBoxes();
    setInterval(updateBoxes, 1000);

    function pad(n){ return n.toString().padStart(2,'0'); }
    function nowDate(){
      const d = new Date();
      return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}`;
    }
    function nowTime(){
      const d = new Date();
      return `${pad(d.getHours())}:${pad(d.getMinutes())}:${pad(d.getSeconds())}`;
    }
    document.getElementById('formIn').addEventListener('submit', ()=>{
      document.getElementById('dateIn').value = nowDate();
      document.getElementById('timeIn').value = nowTime();
    });
    document.getElementById('formOut').addEventListener('submit', ()=>{
      document.getElementById('dateOut').value = nowDate();
      document.getElementById('timeOut').value = nowTime();
    });
  </script>
</body>
</html>
