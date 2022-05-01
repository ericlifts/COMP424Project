<?php
session_start();
include_once 'insert.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
<link href="css/bootstrap.min.css" rel="stylesheet" />
  <title>Register Form</title>
</head>
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
    <svg class="bi me-2" width="40" height="32">
      <use xlink:href="#bootstrap"></use>
    </svg>
    <span class="fs-4">Registration</span>
  </a>
</header>
<main>
<body>
 
  <?php
          // Here we create an error message if the user made an error trying to sign up.
          if (isset($_GET["error"])) {
            if ($_GET["error"] == "emptyfields") {
              echo '<p class="signuperror">Fill in all fields!</p>';
            }
            else if ($_GET["error"] == "invaliduidmail") {
              echo '<p class="signuperror">Invalid username and e-mail!</p>';
            }
            else if ($_GET["error"] == "invaliduid") {
              echo '<p class="signuperror">Invalid username!</p>';
            }
            else if ($_GET["error"] == "invalidmail") {
              echo '<p class="signuperror">Invalid e-mail!</p>';
            }
            else if ($_GET["error"] == "emailexist") {
              echo '<p class="signuperror">This email is taken!</p>';
            }
            else if ($_GET["error"] == "passwordcheck") {
              echo '<p class="signuperror">Your passwords do not match!</p>';
            }
            else if ($_GET["error"] == "usertaken") {
              echo '<p class="signuperror">Username is already taken!</p>';
            }
            else if ($_GET["error"] == "passwordstrength") {
              echo'<p class="signuperror">Password is weak!';
              echo '<p class="signuperror">Your password must be at least 8 characters in length and must contain at least one number, one upper case letter, one lower case letter and one special character!</p>';
            }
          }
          // Here we create a success message if the new user was created.
          else if (isset($_GET["signup"])) {
            if ($_GET["signup"] == "success") {
              echo '<p class="signupsuccess">Signup successful!</p>';
            }
          }
          ?>

<section class="vh-100 bg-image" style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.wep');">
    <div class="mask d-flex align-items-center h-100 gradient-custom-3">
      <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
          <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card" style="border-radius: 15px;">
              <div class="card-body p-5">
                <h2 class="text-uppercase text-center mb-5">New User Sign Up</h2>

                <form class="row g-3" action="signup.php" method="POST">
                  <div class="col-md-6">
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" required>
                  </div>
                  <div class="col-md-6">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" required>
                  </div>
                  <div class="col-md-6">
                    <label for="birthday" class="form-label">Birthday:</label>
                    <input type="date" class="form-control" name="birthday" required>
                  </div>
                  <div class="col-md-6">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" required>
                  </div>
                  <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                  </div>
                  <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                  </div>
                  <div class="col-md-6">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirm_password" required>
                  </div>
                  <div class="d-flex justify-content-center">
                    <!-- <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button> -->
                    <button type="submit" value="Submit" name="submit" class="btn btn-primary">Register</button>
                  </div>
                  <p class="text-center text-muted mt-5 mb-0">Already have an account? <a href="signin.php" class="fw-bold text-body"><u>Sign in</u></a></p>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="js/bootstrap.bundle.js"></script>
 <!-- <form action="login.php" method="POST">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">
            <button type="submit" name="login-submit">Login</button>
  </form>
  <form action="logout.php" method="post">
            <button type="submit" name="login-submit">Logout</button>
          </form> -->
      <div>
        <section>
          <?php
          if(isset($_SESSION['id'])) {
            // echo '<p class = "loggedin"> You are logged in!</p>';
            header("Location: webpage.php");
            exit();
          }
          else {
            echo '<p class = "logout"> You are logged out!</p>';
          }
          ?>
        </section>
      </div>
    </main>
</body>
</html>