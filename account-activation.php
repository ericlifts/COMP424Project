<?php

    if(isset($_GET['vkey'])) {
        $vkey = $_GET['vkey'];

        require 'insert.php';
        $sql = "SELECT verified, vkey FROM users WHERE verified = 0 AND vkey = '$vkey' LIMIT 1;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1) {
            //validate email
            $update = "UPDATE users SET verified = 1 WHERE vkey = '$vkey' LIMIT 1";
            $stmt2 = mysqli_prepare($conn, $update);
            mysqli_stmt_execute($stmt2);

            if($update) {
                echo "Your account has been activated! You may now login!";
            }
            else {
                echo "mysql error";
            }

        }
        else {
            echo"This account is invalid or already verified!";
        }

    }
    else {
        die("Something went wrong");
    }

?>