<link rel="stylesheet" type="text/css" href="css\creer.css">
<?php
//verifie si un utilisateur est connecter et le laisse publier sinon renvois a la page de connection ou d'inscrition
// sauvegarde la publication dans la bdd
session_start();
include_once 'db.php';

if(isset($_POST['envoi']))

?>

<div class="card">
    <form method="POST" action="">
        <input type="file" placeholder="Champ de  Fichier" required>
        <input type="text" placeholder="Champ de description" required>
        <input class="submit" type="button" value="Publier">
    </form>
</div>