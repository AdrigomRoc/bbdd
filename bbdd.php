<!DOCTYPE html>
<html>
<body>
<?php
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $conn = new mysqli($servername, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    echo password_hash($password, PASSWORD_DEFAULT)."\n";
?>
<form action="cookies.php" method="post">
        <input type="hidden" name="type" value="create">
        Correu: 
        <input type="text" name="email">
        <br />
        Contrasenya: 
        <input type="password" name="password">
        <br />
        <input type="submit">
        <br/>
</form>
</body>
</html>