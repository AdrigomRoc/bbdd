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
        }elseif($_POST["type"] === "form"){
            $sql = "SELECT * FROM users where email = '".$_POST["email"]."' ";
            $result = mysqli_fetch_all(mysqli_query($conn, $sql));
            if(isset($_POST["email"])){
                $sqlu="UPDATE users SET email=".$_POST["email"]." ";
                if ($conn->query($sqlu) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
            }
            if(isset($_POST["password"])){
                $sqlu="UPDATE users SET password=".$_POST["password"]." ";
                if ($conn->query($sqlu) === TRUE) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . $conn->error;
                }
                $conn->close();
            }
            if(isset($_POST["telefono"])){
                if($result[0][3]!=null){
                    $sqlu="UPDATE users SET telefono=".$_POST["telefono"]." ";
                    if ($conn->query($sqlu) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                    $conn->close();
                }else{
                    $sqli="INSERT INTO users(telefono) values(".$_POST["telefono"].")";
                    if ($conn->query($sqli) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sqli . "<br>" . $conn->error;
                    }
                    $conn->close();
                }
            }
            if(isset($_POST["nom"])){
                if($result[0][4]!=null){
                    $sqlu="UPDATE users SET nombre=".$_POST["nombre"]." ";
                    if ($conn->query($sqlu) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                    $conn->close();
                }else{
                    $sqli="INSERT INTO users(nombre) values(".$_POST["nombre"].")";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sqli . "<br>" . $conn->error;
                    }
                    $conn->close();
                }
            }
            if(isset($_POST["dni"])){
                if($result[0][5]!=null){
                    $sqlu="UPDATE users SET dni=".$_POST["dni"]." ";
                    if ($conn->query($sqlu) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                    $conn->close();
                }else{
                    $sqli="INSERT INTO users(dni) values(".$_POST["dni"].")";
                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sqli . "<br>" . $conn->error;
                    }
                    $conn->close();
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
        <input type="hidden" name="type" value="form">
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
        <input type="text" name="telefono">
        <br>
        Nom: 
        <input type="text" name="nombre">
        <br>
        DNI: 
        <input type="text" name="dni">
        
    </form>
    <form action="bbdd.php" method="post">
        <input type="hidden" name="type" value="logout">
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