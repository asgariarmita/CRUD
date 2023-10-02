<?php
require("includes/conn.inc.php");
session_start();
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
            display: grid;
            place-items: center;
            height: 100vh;
            width: 100%;
            background-color: #70a979;
        }

        form {
            border: solid lightseagreen 1px;
            opacity: 0.9;
            background: linear-gradient(145deg, #78b581, #65986d);
            box-shadow: 9px 9px 18px #486c4d,
                -9px -9px 18px #98e6a5;
            border-radius: 1em;
            padding: 1em;
            align-items: center;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            width: fit-content;
            gap: 0.5em;
        }

        .field {
            display: flex;
            gap: 0.2em;
        }

        input {
            padding: 0.2em 0.5em;
            border-radius: 5px;
        }

        a {
            position: absolute;
            left: 1em;
            top: 1em;
            color: black;
            background-color: gray;
        }
    </style>
</head>

<body>
    <a href="regsiter.php">Register</a>
    <form action="login.php" method="post">
        <div class="field">
            <label>Username: </label>
            <input type="text" name="u">
        </div>
        <div class="field">
            <label>Password: </label>
            <input type="password" name="p">
        </div>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

<?php
if (isset($_POST["submit"])) {
    $sql_read = "SELECT * FROM tbl_users;";

    $result_read = $conn->query($sql_read) or die("Fehler in der Query: " . $conn->error);

    $account_exists = false;
    while ($row = mysqli_fetch_assoc($result_read)) {
        if ($row["username"] == $_POST["u"]) {
            $account_exists = true;
            if (password_verify($_POST["p"], $row["password"])) {
                // echo "Succesfully Logged In!";
                $_SESSION["users_id"] =  $row["users_id"];
                header('Location: profile.php');
            } else {
                echo "Your email and password aren't matching!";
            }
        }
    }
    if (!$account_exists) {
        echo "This account doesn't exist!";
    }
}
?>

</html>