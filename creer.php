<?php
session_start();
//verifie si un utilisateur est connecter et le laisse publier sinon renvois a la page de connection ou d'inscrition
// sauvegarde la publication dans la bdd
include_once 'affichage.php';
include_once 'composants/header.php';
include_once 'db.php';


?>
<link rel="stylesheet" type="text/css" href="css\creer.css">
<title>Créer</title>
<div class="card">
    <form method="POST" action="">
        <input type="file" placeholder="Champ de  Fichier" required>
        <input type="text" placeholder="Champ de description" required>
        <input class="submit" type="button" value="Publier">
    </form>
</div>