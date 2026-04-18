<?php

require "config/database.php";
include "partials/header.php";

$sql = "SELECT * FROM article";
$req = $db->query($sql);
$articles = $req->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Systeme CRUD : Create Read Update Delete -->
    <div class="container">
    <h1 class="text-center ">Listes des articles</h1>
    <a href="register.php?id=<?=$a["id"]?>" class="">S'inscrire</a>
    <a href="logout.php" class="btn btn-primary">Deconnexion</a>
    

    <a href="create.php">Ajout</a>
    <div class="row">
    <div class="col-md-12">
    <table class="table table-light bg-light">
    <thead>
    <tr>
    <td>Id</td>
    <td>Titre</td>
    <td>Description</td>
    <td>Photo</td>
    <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($articles as $a) : ?>
    <tr>
    <!--le ao anaty colonne -->
    <td> <?= $a["id"]?></td>
    <td><?= $a["titre"]?></td>
    <td><?= $a["description"]?></td>
    <td><?= $a["photo"]?></td>
    <td>
    <a href="create.php" class="btn btn-primary">Ajouter</a>
    <a href="delete.php?id=<?=$a["id"]?>" class="btn btn-danger">Supprimer</a>
    <a href="edit.php?id=<?=$a["id"]?>" class="btn btn-info">Editer</a>
   
    </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
    </table>
    </div>
    </div>
    </div>
  
