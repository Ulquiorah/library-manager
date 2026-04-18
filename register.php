<?php
require"config/database.php";
include "partials/header.php";
$sql ="SELECT * FROM roles";
$req = $db->query ($sql);
$roles = $req->fetchAll(PDO::FETCH_ASSOC);
//  insertion des utilisateurs
if(isset($_POST['register']))
{


if(!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["contact"]) && !empty($_POST["password"]) && !empty($_POST["role"]));
{
     $nom = htmlspecialchars($_POST["nom"]);
     $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
     $contact = htmlspecialchars($_POST["contact"]);
     $pass = password_hash(htmlspecialchars ($_POST["password"]),PASSWORD_BCRYPT);
     $role = htmlspecialchars($_POST["role"]);

     $sql = "INSERT INTO users(nom, email,contact,password,role_id) VALUES (?,?,?,?,?)";
     $req = $db->prepare($sql);
     $req->execute([$nom,$email,$contact,$pass,$role]);
    echo "<script>alert('inscrit')</script>";
}
}
?>
<div class="container">
<div class="row">
<h1 class="text-center">S'inscrire</h1>
<div class="col-md-3"></div>
<div class="col-md-6">
<form action="" method="post">
<div class="mb-3">
<label for="">Nom</label>
<input type="text" name="nom" class="form-control">
</div>
<div class="mb-3">
<label for="">Email</label>
<input type="email" name="email" class="form-control">
</div>
<div class="mb-3">
<label for="">contact</label>
<input type="text" name="contact" class="form-control">
</div>
<div class="mb-3">
<label for="">Mot de passe</label>
<input type="password" name="password" class="form-control">
</div>
<div class="mb-3">
<label for="">Roles</label>
<select name="role" class="form-select" id="">
<option value="">Choisir votre role</option>
<?php  foreach($roles as $role): ?>
<option value="<?role['id']?>"><?=$role['type']?></option>
<?php endforeach;?>
</select>
</div>
<button type="submit" name="register" class="btn btn-primary w-100">S'inscrire</button>
</form>
</div>
<div class="col-md-3"></div>


</div></div>