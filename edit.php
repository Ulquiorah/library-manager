<?php
require "config/database.php";
include "partials/header.php";
$id = $_GET['id'];

if(isset($_GET['id'])){
    $id = $_GET["id"];
    $sql = "SELECT* FROM article WHERE id=$id";
    $req = $db->query($sql);
    $article =$req->fetch(PDO::FETCH_ASSOC);
  
}
if(isset($_POST['modifier']))
{
    if(!empty($_POST['titre'])&& !empty($_POST['description']) && !empty($_POST['photo']))
    {
    $titre = htmlspecialchars($_POST['titre']);
        $description = htmlspecialchars($_POST['description']);
        $photo = htmlspecialchars($_POST['photo']);
    
        $sql = "UPDATE article SET titre=?,description=?,photo=? WHERE id ";
        $req = $db->prepare($sql);
        $req->execute([$titre,$description,$photo]);
        header("location:index.php");
      }
}

?>


    <div class="container">
    <h1 class="text-center text-danger">Modifier</h1>
    <div class="row">
      <div class="col-md-4"></div>
    <div class="col-md-4">
      <form action="" method="post">
    <div class="mb-3">
    <label for="">Titre:</label>
    <input type="text" name="titre" value="" class="form-control">
    </div>
    <div class="mb-3">
    <label for="">Déscripion:</label>
  <textarea type="text" name="description" id="" class="form-control" cols="30" rows="6"></textarea>
    </div>
    <div class="mb-3">
    <label for="">Photo:</label>
    <input type="text" name="photo" class="form-control">
    </div>
    <button type="submit" name="valider" class="btn btn-primary">modifier</button>
  </div></form>
    </div>
    </div>
    </div>

