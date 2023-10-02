<?php
require("includes/conn.inc.php");
session_start();
if ($_SESSION["users_id"] == "") {
    // echo "Go back to where you came from";
    header('Location: login.php');
}

// echo "<pre>";
// var_dump($_SESSION);
// echo "</pre>";

$sql_profile = "SELECT * FROM tbl_users WHERE users_id = " . $_SESSION["users_id"];
$result_read = $conn->query($sql_profile) or die("Fehler in der query:" . $conn->error);

while ($row = mysqli_fetch_assoc($result_read)) {
    echo  "<h1> Profile </h1> <br>";
    echo "Hello " . $row["username"];
    $user = $row["username"];
    $mail = $row["email"];
    $pass = $row["password"];
    $id = $_SESSION["users_id"];
}

// create a form and put all the current info of the user in it. 
// when submitted they'll be updated.

// add two buttons too; one for logging out and one for deleting the user 

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <style>
        body {
            display: grid;
            place-items: center;
            gap: 3em;
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
    </style>
</head>

<body>
    <form action="profile.php" method="post">
        <div class="field">
            <label>Username: </label>
            <input type="text" name="u" value="<?php echo $user ?>">
        </div>
        <div class=" field">
            <label>Email: </label>
            <input type="email" name="e" value="<?php echo $mail ?>">
        </div>
        <div class="field">
            <label>New Password: </label>
            <input type="password" name="p">
        </div>
        <input type="submit" name="submit" value="Save Changes">
        <input type="submit" name="delete" value="Delete Profile">
    </form>
</body>
<?php
if (isset($_POST["submit"])) {
    $password = $conn->real_escape_string($_POST['p']);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_update = "UPDATE tbl_users SET username = '" . $_POST["u"] . "' , email = '" . $_POST["e"] . "' , password = ' " . $hashed_password . "' WHERE tbl_users.users_id = " . $id;
    $result_update = $conn->query($sql_update) or die("Fehler in der Query: " . $conn->error);
    if ($result_update) {
        echo "Your changes have been saved successfully";
    }
} else if (isset($_POST["delete"])) {
    $sql_delete = "DELETE FROM tbl_users WHERE tbl_users.users_id = " . $id;
    $result_delete = $conn->query($sql_delete) or die("Fehler in der Query: " . $conn->error);
    if ($result_delete) {
        echo "Your Profile has been deleted successfully";
        $_SESSION["users_id"] = "";
        header('Location: register.php');
    }
}
?>

</html>