<?php

if (isset($_POST['login-submit'])) {

  require 'insert.php';
  
  $mailuid = $_POST['username'];
  $password = $_POST['password'];

  
  if (empty($mailuid) || empty($password)) {
    header("Location: signin.php?error=emptyfields&mailuid=".$mailuid);
    exit();
  }
  else {
    $sql = "SELECT * FROM users WHERE username=? OR email=?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("Location: signin.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);


      if ($row = mysqli_fetch_assoc($result)) {
        $pwdCheck = password_verify($password, $row['password']);
       // $pwdCheck = $row['password'];//replace with above code for hasing password
        if ($pwdCheck == false) { // if ($pwdCheck == false)
          // Update loginAttempts database to store unsuccessfull login attempt
          $username = $row["username"];
          // Get the current date
          date_default_timezone_set('America/Los_Angeles');
          $date = date("Y/m/d H:i:s");

          $loginSQL = "INSERT INTO loginAttempts(username, successful, loginDate) VALUES ('$username', 0, '$date')";
          mysqli_query($conn, $loginSQL);

          header("Location: signin.php?error=wrongpwd");
          exit();
        }
        else if ($pwdCheck == true) {

          $verified = $row['verified'];

          if($verified == 1) {

          session_start();
          $_SESSION['id'] = $row['username'];
          $_SESSION['email'] = $row['email'];
          $_SESSION['firstname'] = $row['firstName'];
          $_SESSION['lastname'] = $row['lastName'];
          $_SESSION['numLogins'] = $row['numLogins'];

          // Get the current date
          date_default_timezone_set('America/Los_Angeles');
          $date = date("Y/m/d H:i:s");
          $_SESSION['loginDate'] = $date;

          // Update the number of logins and last login date for the user
          $email = $row["email"];
          $username = $row["username"];
          $updateSQL = "UPDATE users SET numLogins=numLogins + 1, loginDate=\"$date\" WHERE username=\"$username\" OR email=\"$email\"";
          mysqli_query($conn, $updateSQL);

          // Update loginAttmpts database to store successful login attempt
          $loginSQL = "INSERT INTO loginAttempts(username, successful, loginDate) VALUES ('$username', 1, '$date')";
          mysqli_query($conn, $loginSQL);

         
          header("Location: webpage.php?login=success");
          exit();
          }
          else {
            header("Location: signin.php?error=accountnotactivated");
            exit();
          }
        }
      }
      else {
        header("Location: signin.php?error=wronguidpwd");
        exit();
      }
    }
  }
  
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  header("Location: index.php");
  exit();
}
//if ($_POST['password'] === $row['Password'])