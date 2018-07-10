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
        $conn = new mysqli($servername, $username, $password, "bd_php");
        if($_POST["type"] === "registre"){
            if(isset($_POST["password"])&&isset($_POST["email"]) ){
                $pasuser = password_hash($_POST["password"], PASSWORD_DEFAULT);
                $usermail = $_POST["email"];
                // $_SESSION["guarda"] = $usermail;
                //fer registre amb bd
               
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "INSERT INTO users (email,password) VALUES ('". $usermail ."', '". $pasuser ."')";
                                
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
                $sql = "SELECT * FROM users where email = '".$guardaemail."' ";
                $result = mysqli_fetch_all(mysqli_query($conn, $sql));
                
                if(count($result)>0){
                    if(password_verify($guardapassword,$result[0][2])){
                        $_SESSION["guarda"] = $result[0][0];
                    }else{
                        echo "contrasenya incorrecta";
                    }
                }else{
                    echo "primer registret";
                }
                
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
        Modifica la teva informació si vols
        <br>
        Correu: 
        <input type="email" name="email">
        <br>
        Password: 
        <input type="password" name="password">
        <br>
        Telefon: 
        <input type="text" name="telefon.">
        <br>
        Nom: 
        <input type="text" name="nom">
        <br>
        DNI: 
        <input type="text" name="dni">
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