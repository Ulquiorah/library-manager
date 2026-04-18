<?php
require "config/database.php";
include "partials/header.php";

if(isset($_POST['valider']))
{
if(!empty($_POST['titre'])&& !empty($_POST['description']) && !empty($_POST['photo']))
{
$titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $photo = htmlspecialchars($_POST['photo']);

    $sql = "INSERT INTO article(titre,description,photo) VALUES(?,?,?)";
  // on prepare la req vu que les données vient de l'ut
    $req = $db->prepare($sql);
    $req->execute([$titre,$description,$photo]);
    // redirection vers l'accueil
    header("location:index.php");
  }
}
?>


    <div class="container">
    <h1 class="text-center text-primary">Nouveau article</h1>
    <div class="row">
      <div class="col-md-4"></div>
    <div class="col-md-4">
      <form action="" method="post">
    <div class="mb-3">
    <label for="">Titre:</label>
    <input type="text" name="titre" class="form-control">
    </div>
    <div class="mb-3">
    <label for="">Déscripion:</label>
  <textarea type="text" name="description" id="" class="form-control" cols="30" rows="6"></textarea>
    </div>
    <div class="mb-3">
    <label for="">Photo:</label>
    <input type="text" name="photo" class="form-control">
    </div>
    <button type="submit" name="valider" class="btn btn-primary">Valider</button>
  </div></form>
    </div>
    </div>
    </div>
