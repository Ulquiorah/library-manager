<?php
require "config/database.php";

if(isset($_GET['id']))
{
    $id = $_GET["id"];
    $sql = "DELETE FROM article WHERE id = ?";
    $req = $db->prepare($sql);
    $req->execute([$id]);
    header("location:header.php");
}
else{
    echo "aucun id";
}