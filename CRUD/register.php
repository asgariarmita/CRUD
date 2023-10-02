<?php
require("includes/conn.inc.php");
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
    <a href="Login.php">LOGIN</a>
    <form action="register.php" method="post">
        <div class="field">
            <label>Username: </label>
            <input type="text" name="u">
        </div>
        <div class="field">
            <label>Email: </label>
            <input type="email" name="e">
        </div>
        <div class="field">
            <label>Password: </label>
            <input type="password" name="p">
        </div>
        <input type="submit" name="submit" value="Register">
    </form>
</body>

<?php
// write php code to handle when form is submitted.
// if (isset($_POST["submit"])){}
if (count($_POST) > 0) {

    // Escape user inputs for security
    $username = $conn->real_escape_string($_POST['u']);
    $email = $conn->real_escape_string($_POST['e']);
    $password = $conn->real_escape_string($_POST['p']);

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO tbl_users(username, email, password)
    VALUES ('" . $username . "' , '" . $email . "' , '" . $hashed_password . "')";

    $result_insert = $conn->query($sql_insert) or die("Fehler in der Query: " . $conn->error);
    if ($result_insert == TRUE) {
        echo "You have succesfully registered!";
    }
}

?>

</html>