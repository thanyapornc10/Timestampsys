<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <title>Add employee information</title>
    <link rel="stylesheet" href="css/addemst.css" />
    <style>
        .form-container {
            max-width: 500px;
            background: #fff;
            padding: 40px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .1);
            font-family: sans-serif
        }

        .form-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 25px;
            text-align: center
        }

        .form-content .form-group {
            display: flex;
            flex-direction: column;
            margin-bottom: 15px
        }

        .form-group label {
            font-weight: bold;
            margin-bottom: 6px
        }

        .form-input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px
        }

        .form-group.image-preview {
            text-align: center;
            margin-bottom: 20px
        }

        .profile-img {
            width: 80px;
            height: 80px;
            border-radius: 100%;
            object-fit: cover;
            margin-bottom: 5px;
            border: 2px solid #ddd
        }

        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px
        }

        .btn {
            padding: 10px 25px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer
        }

        .btn-green {
            background: #28a745;
            color: #fff
        }

        .btn-red {
            background: #dc3545;
            color: #fff
        }
    </style>
</head>

<body>
    <section>
        <div class="form-container">
            <h2 class="form-title">Add Employee Information</h2>

            <form action="process_add_employee.php" method="POST" enctype="multipart/form-data" class="form-content">
                <div class="form-group image-preview">
                    <div class="img-box">
                        <img id="previewImage" src="uploads/default.jpg" alt="profile" class="profile-img" />
                        <div><small>JPG/PNG (max ~5MB)</small></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="profile">Profile image</label>
                    <input type="file" name="profile_image" id="profile" class="form-input" accept="image/*" onchange="previewImage(event)" />
                </div>

                <div class="form-group">
                    <label for="fname">Firstname</label>
                    <input type="text" name="fname" id="fname" class="form-input" required />
                </div>

                <div class="form-group">
                    <label for="lname">Lastname</label>
                    <input type="text" name="lname" id="lname" class="form-input" required />
                </div>

                <div class="form-group">
                    <label for="dep">Department</label>
                    <select name="dep" id="dep" class="form-input">
                        <option value="1">QA</option>
                        <option value="2">HR</option>
                        <option value="3">CEO</option>
                        <option value="4">SA</option>
                        <option value="5">Supp</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sex">Gender</label>
                    <select name="sex" id="sex" class="form-input">
                        <option value="Female">Female</option>
                        <option value="Male">Male</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="birth">Birth</label>
                    <input type="date" name="birth" id="birth" class="form-input" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input" />
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-input" />
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-input" />
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-input" required />
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-input" required />
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-green">Save</button>
                    <button type="reset" class="btn btn-red">Cancel</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = () => {
                document.getElementById('previewImage').src = reader.result;
            };
            if (event.target.files[0]) reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>