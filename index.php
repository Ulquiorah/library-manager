<?php
session_start();
require_once "config/database.php";
$css = "style.css";
include "partials/header.php";

if (isset($_POST["login"])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $pass = htmlspecialchars($_POST["password"]);

        $sql = "SELECT * FROM users WHERE email=?";
        $req = $db->prepare($sql);
        $req->execute([$email]);

        // on verifie si les donnees correspondent a celui dans la bdd
        if ($req->rowCount() > 0) {
            $users = $req->fetch(PDO::FETCH_ASSOC);

            // on verifie si le mdp correspond dans la bdd
            if (password_verify($pass, $users['password'])) {
                // on definit une session pour l'user
                $_SESSION['user'] = [
                    'id' => $users['id'],
                    'nom' => $users['nom'],
                    'email' => $users['email'],
                    'contact' => $users['contact'],
                    'password' => $users['password']
                ];

                header("location:article.php");
                exit;
            } else {
                echo "mot de passe incorrect";
            }
        } else {
            echo "email incorrect";
        }
    }
}
?>
<div class="container-fluid h-100 bg-dark py-5">
<div class="row d-flex justify-content-center align-items-center">
<div class="card w-25">
<div class="card-body">
<h3 class="card-title text-center">Se connecter</h3>
<form action="" method="post">
<div class="mb-3">
<input type="email" name="email" class="form-control" placeholder="entrer votre email">
</div>

<div class="mb-3">
<input type="password" name="password" class="form-control" placeholder="Mot de passe">
</div>
<button type="submit" name="login" class="btn btn-primary w-100">se connecter</button>

</form>
</div>
</div>
</div>
</div>
