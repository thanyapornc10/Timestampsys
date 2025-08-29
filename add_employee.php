<!DOCTYPE html>
<html>
<head>
    <title>Add employee information</title>
    <meta charset="UTF-8" />
  <title>Attendace</title>
  <link rel="stylesheet" href="css/addemst.css" />
</head>
<body>
    <section>
        <div class="content">
    <h1>Add employee information</h1>
    <form method="post" action="process_add_employee.php" enctype="multipart/form-data">
        Employee ID: <input type="text" name="emp_id" required><br>
        Firstname: <input type="text" name="fname" required><br>
        Lastname: <input type="text" name="lname" required><br>
        Department:
        <select name="dep">
            <option value="1">QA</option>
            <option value="2">HR</option>
            <option value="3">CEO</option>
            <option value="4">SA</option>
            <option value="5">Sup</option>
        </select><br>
        Gender: <input type="text" name="sex" required><br>
        Birthday: <input type="date" name="birth" required><br>
        Email: <input type="email" name="email" required><br>
        Phone: <input type="text" name="phone" required><br>
        Adress: <input type="text" name="address" required><br>
        Profile: <input type="file" name="image" accept="image/*" required><br>
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" id="saveButton">Save</button>
        <button type="button" id="cancelButton" onclick="cancelEdit()">Cancel</button>
    </form>
    </div>
    </section>
    <script>
         function cancelEdit() {
            window.location.href = "reportemployee.php";
        }
    </script>
</body>
</html>