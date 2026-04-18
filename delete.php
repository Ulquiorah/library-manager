<?php
require "config/database.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];
    $sql = "DELETE FROM article WHERE id = ?";
    $req = $db->prepare($sql);
    $req->execute([$id]);
}

header("location:article.php");
exit;
