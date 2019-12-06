<?php
require 'config/database.php';

if (isset($_GET['token'])) {
    $vkey = $_GET['token'];

    if (!empty($_POST['pwd'])) {

        $password = trim(htmlspecialchars($_POST['pwd']));
        $hasspass = password_hash($password, PASSWORD_BCRYPT);

        try {
            $con = new PDO("mysql:host=$DB_DSN;dbname=$DB_NAME", $DB_USER, $DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


            $sql = "SELECT token FROM users WHERE active = 1 AND token = :vkey LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(':vkey', $vkey);
            $stmt->execute();

            if(count($stmt->fetchALL()) ==1)
            {
            $update = "UPDATE users SET Passwrd = :passwords WHERE token = :vkey";
            $stmtup = $con->prepare($update);
            

            $stmtup->bindParam(':passwords', $hasspass);
            $stmtup->bindParam(':vkey', $vkey);

             if($stmtup->execute()) {
                echo "<p>Password has been updated</p>";
            } else {
                echo "Something went wrong try again";
            }
        }
        } catch (Exception $e) {
            echo $stmt . "<br>" . $e->getMessage();
        }
        $con = null;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>User management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
    </style>
</head>
<body>
<h1>Update Passwords</h1>

<form method = "post" action = "">
    <table>
        <tr><td>Password:</td> <td><input type = "password" value = "" name = "pwd"></td></tr>
        <div class ="form-group">
        <tr><td></td><td><input style = "float: right;" type = "submit" class="btn btn-primary" value = "Update" >
        <input type="reset" class="btn btn-primary" value="Reset">
        </td></tr>
    </table>
</form>
</body>
</html>