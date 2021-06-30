<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .error {
            color: #FF0000;
        }
    </style>
    <title>Login</title>
</head>
<body>
    <?php
    // define variables and set to empty values
    $emailErr = $passwordErr = "";
    $email = $password = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
        }
        
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
            // check if password only contains letters and whitespace
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$password)) {
                $passwordErr = "Password must have at least one number, no special characters and must be more than 8 characters";
            }
        }
        if ($_SESSION["email"] == $email && $_SESSION["password"] == $password) {
            echo "<p color=\"green\">You've successfully logged in. You can now register with fresh details at signup.php</p>";
            echo "<br>";
        } else {
            echo "<p class=\"error\">Login failure. Check your email and/or password</p>";
            echo "<br>";
        }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        E-mail: <input type="email" name="email" value="<?php echo $email;?>">
        <span class="error">* <?php echo $emailErr;?></span>
        <br><br>

        Password: <input type="password" name="password" value="<?php echo $password;?>">
        <span class="error">* <?php echo $passwordErr;?></span>
        <br><br>

        <input type="submit" name="submit" value="Submit">
</form>

<?php
    echo "<h2>Your Input:</h2>";
    echo $email;
    echo "<br>";
    echo "You have to remember your password. If you don't, change it by signing up again.";
?>


</body>
</html>