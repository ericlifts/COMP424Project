<?php
session_start();
include_once 'insert.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link href="css/bootstrap.min.css" rel="stylesheet" />
</head>
<!-- Header block -->
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
            <use xlink:href="#bootstrap"></use>
        </svg>
        <span class="fs-4">Log In</span>
    </a>

</header>

<body>
<?php
          if(isset($_SESSION['id'])) {
            // echo '<p class = "loggedin"> You are logged in!</p>';
            header("Location: webpage.php");
            exit();
          }
          else {
            echo '<p style = "color: red; text-align: center" class = "logout"> You are logged out!</p>';
          }
          ?>
    <?php 
         if (isset($_GET["error"])) {
            if ($_GET["error"] == "wrongpwd") {
              echo '<p style = "text-align:center; color: red"class="signuperror">Wrong password, please try again!</p>';
            }
            else if ($_GET["error"] == "emptyfields") {
                echo '<p style = "text-align:center; color: red">Please provide all fields!</p>';
              }
            else if ($_GET["error"] == "wronguidpwd") {
            echo '<p style = "text-align:center; color: red">Wrong username and password!</p>';
              }
              else if ($_GET["error"] == "accountnotactivated") {
                echo '<p style = "text-align:center; color: red">Your account has not been activated. Please check your email!</p>';
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
                                <h2 class="text-uppercase text-center mb-5">Login</h2>

                                <form action="login.php" method="POST">

                                    <div class="form-outline mb-4">
                                        <input type="text" name="username" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example1cg">Username or email </label>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" name="password" class="form-control form-control-lg" />
                                        <label class="form-label" for="form3Example4cg">Password</label>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <!-- <button type="button" class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Login</button> -->
                                        <button  type="submit" name = "login-submit"class="btn btn-primary">Log in</button>
                                    </div>
                                    

                                    <p class="text-center text-muted mt-5 mb-0">Don't have an account? <a href="index.php" class="fw-bold text-body"><u>Sign up</u></a></p>
                                    <p class="text-center text-muted mt-5 mb-0">Forgot username or password? <a href="reset-password.php" class="fw-bold text-body"><u>Recover</u></a></p>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="js/bootstrap.bundle.js"></script>
</body>

</html>