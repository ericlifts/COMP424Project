<?php
use PHPMailer\PHPMailer\PHPMailer;

if(isset($_POST["reset-request-submit"])) {

    //tokens 
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "localhost/COMP424Project/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require '../insert.php';

    //for sending email 
    require_once "../PHPMailer/src/PHPMailer.php";
    require_once "../PHPMailer/src/SMTP.php";
    require_once "../PHPMailer/src/Exception.php";

    $userEmail = $_POST["email"];

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error!";
        exit();
    
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error!";
        exit();
    
    } else {
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $mail = new PHPMailer();
    $name = "COMP440";
    $from = "systemsecur1ty440@gmail.com";  // you mail
    $password = "Computer440";  // your mail password


    $to = $userEmail;
    $subject = 'Reset your password';
    // $message = '<p>We recieved a password reset request. The link to reset your password is below. If you did not make this request ignore this email</p>';
    // $message .= '<p>Here is your password reset link: </br>';
    // $message .= '<a href="' . $url . '">' . $url . '</a></p>';

    // $headers = "From: localhost <systemsecur1ty440@gmail.com>\r\n";
    // $headers .= "Reply-To systemsecur1ty440@gmail.com\r\n";
    // $headers .= "Content-type: text/html\r\n";

    // mail($to, $subject,$message, $headers);

    //SMTP Settings
    $mail->isSMTP();
    $mail->SMTPDebug = 3;                      
    $mail->Host = "smtp.gmail.com"; // smtp address of your email
    $mail->SMTPAuth = true;
    $mail->Username = $from;
    $mail->Password = $password;
    $mail->Port = 587;  // port
    $mail->SMTPSecure = "tls";  // tls or ssl
    $mail->smtpConnect([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
        ]
    ]);
    $mail->isHTML(true);
    $mail->setFrom($from, $name);
    $mail->addAddress($to); // enter email address whom you want to send
    $mail->Subject = ("$subject");
    $mail->Body = '<p>Here is your password reset link: <a href="' . $url . '">' . $url . '</a></p>';
    $mail-> send();

    header("Location: ../reset-password.php?reset=success");



} else {
    header("Location:../index.php");
}