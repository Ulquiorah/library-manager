<?php
require "config/database.php";
include "partials/header.php";

if (isset($_POST['valider'])) {
    if (!empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['photo'])) {
        $titre = htmlspecialchars($_POST['titre']);
        $description = htmlspecialchars($_POST['description']);
        $photo = htmlspecialchars($_POST['photo']);

        $sql = "INSERT INTO article(titre, description, photo) VALUES(?, ?, ?)";
        $req = $db->prepare($sql);
        $req->execute([$titre, $description, $photo]);

        header("location:article.php");
        exit;
    }
}
?>

<div class="container py-4">
    <h1 class="text-center text-primary mb-4">Nouveau livre</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="titre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="text" name="photo" class="form-control" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="valider" class="btn btn-success">Enregistrer</button>
                            <a href="article.php" class="btn btn-outline-secondary">Retour</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
