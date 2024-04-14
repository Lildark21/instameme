<?php
include_once 'db.php';
//affiche le contenue de l'utilisateur
$stmt = db()->prepare("SELECT * FROM utilisateurs WHERE pseudo LIKE ?");
$stmt->execute(["%" . $_GET["recherche"] . "%"]);
$contenus = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!empty($contenus)) {
    foreach ($contenus as $contenu) {
        echo  '<h2><a href="?id='.'">'.$contenu['pseudo']." ".'</a></h2>';
    }
}
?>
