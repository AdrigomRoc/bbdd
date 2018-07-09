<!DOCTYPE html>
<html>
<body>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $conn = new mysqli($servername, $username, $password, "bd_php");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $pasuser = null;
    $user = null;
   if(isset($_POST["type"])){
        if($_POST["type"] === "login"){
            if(isset($_POST["password"])){
                $pasuser = $_POST["password"];
                echo password_hash($pasuser, PASSWORD_BCRYPT)."\n";
            }
            if(isset($_POST["email"])){
                $user = $_POST["email"];
            }
            if(isset($pasuser) && isset($user)){
                $_SESSION["guarda"] = $user;
                header("Location: bbddbe.php");
            }else{
                header("Location: bbdd.php");
            }

        }   
    }
    $sql = "INSERT INTO users (email,password)
    VALUES ('".$user."', '".$pasuser."')";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Usuari registrat en la bbdd";
    } else {
        echo "Error: ".$sql."<br>".mysqli_error($conn);
    }
?>
<form action="bbdd.php" method="post">
        <input type="hidden" name="type" value="login">
        Correu: 
        <input type="email" name="email">
        <br />
        Contrasenya: 
        <input type="password" name="password">
        <br />
        <input type="submit">
        <br/>
</form>
</body>
</html>