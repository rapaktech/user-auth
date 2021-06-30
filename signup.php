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
        p {
            color: green;
        }
    </style>
    <title>Sign Up</title>
</head>
<body>
    <?php
    // define variables and set to empty values
    $firstErr = $emailErr = $passwordErr = $lastErr = $signup = "";
    $first = $email = $password = $last = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["first"])) {
            $firstErr = "First Name is required";
        } else {
            $first = test_input($_POST["first"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$first)) {
                $firstErr = "Only letters and white space allowed";
            } else {
                $_SESSION["first"] = $first;
            }
        }
        
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            } else {
                $_SESSION["email"] = $email;
            }
        }
        
        if (empty($_POST["password"])) {
            $passwordErr = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
            // check if password only contains letters and whitespace
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$password)) {
                $passwordErr = "Password must have at least one number, no special characters and must be more than 8 characters";
            } else {
                $_SESSION["password"] = $password;
            }
        }
        
        if (empty($_POST["last"])) {
            $lastErr = "Last Name is required";
        } else {
            $last = test_input($_POST["last"]);
            // check if last name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z-' ]*$/",$last)) {
                $lastErr = "Only letters and white space allowed";
            } else {
                $_SESSION["last"] = $last;
            }
        }
        if ($_SESSION["first"] && $_SESSION["last"] && $_SESSION["email"] && $_SESSION["password"]) {
            echo "<p>You've successfully registered your data. You can now login at login.php</p>";
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
        First Name: <input type="text" name="first" value="<?php echo $first;?>">
        <span class="error">* <?php echo $firstErr;?></span>
        <br><br>

        Last Name: <input type="text" name="last" value="<?php echo $last;?>">
        <span class="error">* <?php echo $lastErr;?></span>
        <br><br>

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
    echo $first;
    echo "<br>";
    echo $last;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo "You have to remember your password. If you don't, change it by signing up again.";
?>


</body>
</html>