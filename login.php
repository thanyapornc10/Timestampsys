<?php
require("connection.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Emplyeelogin</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="css/loginst.css">
</head>
<div class="overlay">
   <form method="post" action="login_process.php">
      <div class="con">
         <header class="head-form">
            <i class="bi bi-person-fill" style="font-size: 3rem;"></i>
            <h2>LOGIN</h2>
         </header>
         <br>
         <div class="field-set">
            <span class="input-item">
               <i class="fa fa-user-circle"></i>
            </span>
            <input class="form-input" id="txt-input" name="username" type="text" placeholder="Username" required>
            <br>
            <span class="input-item">
               <i class="bi bi-lock"></i>
            </span>
            <input class="form-input" type="password" name="password" placeholder="Password" id="pwd" name="password" required>
            <span>
               <i class="fa fa-eye" aria-hidden="true" type="button" id="eye"></i>
            </span>
            <br>
            <input type="submit" value="Login">
         </div>
         <div class="other">
            <div class="form-check text-start my-3">
               <input class="form-check-input" type="checkbox" value="remember-me" id="flexCheckDefault">
               <label class="form-check-label" for="flexCheckDefault"> Remember me </label>
            </div>
         </div>

   </form>
</div>
</body>

</html>