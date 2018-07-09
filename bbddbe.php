<!DOCTYPE html>
<html>
<body>
<?php
session_start();
    /*if(!isset($_SESSION["guarda"])){
        return;
    }*/
    if(isset($_POST["type"])){
        if($_POST["type"] === "delete"){
            if(isset($_SESSION["guarda"])){
                session_destroy(); 
                return;
            }
        }
        }
?>
<form action="formulari.php" method="post">
    <input type="hidden" name="type" value="form">
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
    <br />
    <input type="submit">
</form>
<hr>
<form action="bbddbe.php" method="post">
        <input type="hidden" name="type" value="delete">
        <input type="submit" value="Logout">
        <br/>
    </form>
</body>
</html>