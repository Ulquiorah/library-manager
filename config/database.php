<?php
$usename ="root";
$pass = "";
try {
    $db = new PDO("mysql:host=localhost;dbname=espic",$usename,$pass);
echo "connecté";
} catch (PDOExeption $th) {
    die("Erreur de connexion".$th->getMessage());
}
?>