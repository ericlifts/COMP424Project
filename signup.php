<?php


if (isset($_POST['submit'] && $_POST['g-recaptcha-response'] != "")) {

  
  require 'insert.php';
  $Secret = '6LdEKLgfAAAAANyk-By0CYFwOGj_7Z2Gh6zqqhSD';
  $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $Secret . '&response=' . $_POST['g-recaptcha-response']);
  $responseData = json_decode($verifyResponse);
  if($responseData-> success) {

  

  
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 
    $confirm_password = $_POST['confirm_password'];
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']); 
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']); 
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);

    //for password strength 
    $number = preg_match('@[0-9]@', $password);
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);

  
    if (!preg_match("/^[a-zA-Z0-9]*$/", $username) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?error=invaliduidmail");
    exit();
    }
 
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    header("Location: index.php?error=invaliduid&mail=".$email);
    exit();
  }
  
  else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: index.php?error=invalidmail&uid=".$username);
    exit();
  }

  else if (strlen($password) < 8 || !$number || !$uppercase || !$lowercase || !$specialChars) {
    header("Location: index.php?error=passwordstrength&uid=");
    exit();
  }
  
  else if ($password !== $confirm_password) {
    header("Location: index.php?error=passwordcheck&uid=".$username."&mail=".$email);
    exit();
  }
  
  else {
    $sql = "SELECT username FROM users WHERE username=?;";
    $stmt = mysqli_stmt_init($conn);
    
    if (!mysqli_stmt_prepare($stmt, $sql)) {
     header("Location: index.php?error=sqlerror");
      exit();
    }
    else {
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $resultCount = mysqli_stmt_num_rows($stmt);
      mysqli_stmt_close($stmt);
  
      if ($resultCount > 0) {
        header("Location: index.php?error=usertaken&mail=".$email);
        exit();
      }
      else {
        //Check if the email already exist
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
   
        if ($resultCheck > 0) {
         header("Location: index.php?error=emailexist&first=$first&last=$last&uid=$uid");
         exit();
        }
      else {
        $sql = "INSERT INTO users(username, password, firstName, lastName, birthday, email) VALUES (?, ?, ?, ?, ?, ?);";
        $stmt = mysqli_stmt_init($conn);
        
        if (!mysqli_stmt_prepare($stmt, $sql)) {
          
          header("Location: index.php?error=sqlerror");
          exit();
        }
        else {//below commented code is for hashed passwords 
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          mysqli_stmt_bind_param($stmt, "ssssss",  $username, $hashedPwd, $firstname, $lastname, $birthday, $email );
          mysqli_stmt_execute($stmt);
          header("Location: index.php?signup=success");
          exit();
          $hashedPwd = password_hash($password, PASSWORD_DEFAULT);
          // mysqli_stmt_bind_param($stmt, "sssss",  $username, $password, $firstname, $lastname, $email );
          // mysqli_stmt_execute($stmt);
          // header("Location: index.php?signup=success");
          // exit();

        }
      }
    }
    }
  }
  
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else {
  // If the user tries to access this page an inproper way, we send them back to the signup page.
  header("Location: index.php");
  exit();
}

