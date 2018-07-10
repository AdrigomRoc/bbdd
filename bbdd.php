<!DOCTYPE html>
<html>
<body>
<?php
session_start();

    $servername = "localhost";
    $username = "root";
    $password = "";

    $pasuser = null;
    $usermail = null;

   if(isset($_POST["type"])){
        if($_POST["type"] === "registre"){
            if(isset($_POST["password"])&&isset($_POST["email"]) ){
                $pasuser = password_hash($_POST["password"], PASSWORD_BCRYPT);
                $usermail = $_POST["email"];
                $_SESSION["guarda"] = $usermail;
                //fer registre amb bd
                $conn = new mysqli($servername, $username, $password, "bd_php");
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "INSERT INTO users (email,password) VALUES ('". $usermail ."', '". $pasuser ."')";
                $result = $conn->query($sql);
                
                if (mysqli_query($conn,$sql)) {
                    echo "Usuari registrat en la bbdd";
                } else {
                    echo "Error: ".$sql."<br>".mysqli_error($conn);
                }
            }else{
                echo "Falten dades";
            }

        }elseif($_POST["type"] === "login"){
            if(isset($_POST["password"]) && isset($_POST["email"]) ){
                $guardaemail= $_POST["email"];
                $guardapassword = $_POST["password"];
            }
        }elseif($_POST["type"] === "logout"){
            session_destroy();
            unset($_SESSION["guarda"]);
            session_unset();
        }
    }
    
?>
<?php  
    if(isset($_SESSION["guarda"]) ){
        //mostrare login
?>
    <form action="bbdd.php" method="post">
        <input type="hidden" name="type" value="logout">
        <br>
        Colores:
    <input type="radio" id="color1"
           name="color" value="blu">
    <label for="color1">Blau</label>
    <input type="radio" id="color2"
           name="color" value="gre">
    <label for="color2">Verde</label>
    <input type="radio" id="color3"
           name="color" value="yel">
    <label for="color3">Groc</label>
    <hr/>
        <input type="submit" value="logout">
        <br/>
    </form>
<?php
    }else{
?>
    <h1>LOGIN</h1>
    <form action="bbdd.php" method="post">
        <input type="hidden" name="type" value="login">
        Correu: 
        <input type="email" name="email">
        <br />
        Contrasenya: 
        <input type="password" name="password">
        <br />
        <input type="submit" value="login">
        <br/>
    </form>
    <hr />
    <h1>REGISTRE</h1>
    <form action="bbdd.php" method="post">
        <input type="hidden" name="type" value="registre">
        Correu: 
        <input type="email" name="email">
        <br />
        Contrasenya: 
        <input type="password" name="password">
        <br />
        <input type="submit" value="register">
        <br/>
    </form>
<?php
    }
?>
</body>
</html>