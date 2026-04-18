<?php

require "config/database.php";
include "partials/header.php";

$sql = "SELECT * FROM article";
$req = $db->query($sql);
$articles = $req->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Systeme CRUD : Create Read Update Delete -->
<div class="container py-4">
    <h1 class="text-center mb-4">Listes des articles</h1>

    <div class="d-flex flex-wrap gap-2 mb-3 justify-content-center justify-content-md-start">
        <a href="register.php" class="btn btn-outline-secondary">S'inscrire</a>
        <a href="create.php" class="btn btn-success">Ajouter</a>
        <a href="logout.php" class="btn btn-primary">Deconnexion</a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-light bg-light table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Titre</th>
                            <th>Description</th>
                            <th>Photo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($articles as $a) : ?>
                        <tr>
                            <td><?= $a["id"] ?></td>
                            <td><?= $a["titre"] ?></td>
                            <td><?= $a["description"] ?></td>
                            <td><?= $a["photo"] ?></td>
                            <td class="d-flex flex-wrap gap-2">
                                <a href="edit.php?id=<?= $a["id"] ?>" class="btn btn-sm btn-info">Editer</a>
                                <a href="delete.php?id=<?= $a["id"] ?>" class="btn btn-sm btn-danger">Supprimer</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
