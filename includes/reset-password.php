<?php

// First we check if the form was submitted.
if (isset($_POST['reset-password-submit'])) {

  // Here we grab the data from the form.
  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['pwd'];
  $passwordRepeat = $_POST['pwd-repeat'];

  //grab security question answer from form
  $secquestion = $_POST['question'];

  //for password strength 
    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

  //get security question from table
  $userEmail = $_POST['email'];
  require '../insert.php';
  $sql = "SELECT question FROM users WHERE email='$userEmail'";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);

  //UNHASH QUESTION
  $qCheck = password_verify($secquestion, $row['question']);
  

  if (empty($password) || empty($passwordRepeat)) {
    header("Location: ../index.php?error=newpwd=empty");
    exit();
  } else if ($password != $passwordRepeat) {
    header("Location: ../index.php?error=newpwd=pwdnotsame");
    exit();
  }
  else if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
    header("Location: ../index.php?error=passwordstrength&uid=");
    exit();
  }
  else if ($qCheck == false) {
    header("Location: ../index.php?error=wrong");
    exit();
  }

  // We get the current date and time.
  $currentDate = date('U');

  // We get the database connection.
  require '../insert.php';


  $sql = "SELECT * FROM pwdReset WHERE pwdResetSelector=? AND pwdResetExpires >= $currentDate";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "There was an error!";
    exit();
  } else {
    mysqli_stmt_bind_param($stmt, "s", $selector);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$row = mysqli_fetch_assoc($result)) {
      echo "You need to re-submit your reset request.";
      exit();
    } else {

      // Now we need to check if the token from the URL matches the token from the database.

      // First we convert the "token" from the URL back into binary.
      $tokenBin = hex2bin($validator);

      // Then we check if it matches the one from the database.
      $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

      // Then if they match we grab the users e-mail from the database.
      if ($tokenCheck === false) {
        echo "There was an error!";
      } elseif ($tokenCheck === true) {

        // Before we get the users info from the user table we need to store the token email for later.
        $tokenEmail = $row['pwdResetEmail'];

        // Here we query the user table to check if the email we have in our pwdReset table exists.
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          echo "There was an error!";
          exit();
        } else {
          mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if (!$row = mysqli_fetch_assoc($result)) {
            echo "There was an error!";
            exit();
          } else {

            // Finally we update the users table with the newly created password.
            $sql = "UPDATE users SET password =? WHERE email=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
              echo "There was an error!";
              exit();
            } else {
              $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
              mysqli_stmt_bind_param($stmt, "ss", $newPwdHash, $tokenEmail);
              mysqli_stmt_execute($stmt);

              // Then we delete any leftover tokens from the pwdReset table.
              $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
              $stmt = mysqli_stmt_init($conn);
              if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo "There was an error!";
                exit();
              } else {
                mysqli_stmt_bind_param($stmt, "s", $tokenEmail);
                mysqli_stmt_execute($stmt);
                header("Location: ../index.php?newpwd=passwordupdated");
              }

            }

          }
        }

      }

    }
  }

} else {
  header("Location: index.php");
  exit();
}
