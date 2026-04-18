<?php
require "config/database.php";
include "partials/header.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("location:article.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM article WHERE id = ?";
$req = $db->prepare($sql);
$req->execute([$id]);
$article = $req->fetch(PDO::FETCH_ASSOC);

if (!$article) {
    header("location:article.php");
    exit;
}

if (isset($_POST['modifier'])) {
    if (!empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['photo'])) {
        $titre = htmlspecialchars($_POST['titre']);
        $description = htmlspecialchars($_POST['description']);
        $photo = htmlspecialchars($_POST['photo']);

        $sql = "UPDATE article SET titre = ?, description = ?, photo = ? WHERE id = ?";
        $req = $db->prepare($sql);
        $req->execute([$titre, $description, $photo, $id]);

        header("location:article.php");
        exit;
    }
}
?>

<div class="container py-4">
    <h1 class="text-center text-danger mb-4">Modifier le livre</h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" name="titre" value="<?= htmlspecialchars($article['titre']) ?>" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($article['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Photo</label>
                            <input type="text" name="photo" value="<?= htmlspecialchars($article['photo']) ?>" class="form-control" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="modifier" class="btn btn-primary">Mettre a jour</button>
                            <a href="article.php" class="btn btn-outline-secondary">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
