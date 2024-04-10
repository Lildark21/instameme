<?php

include_once 'db.php';
require_once '../affichage.php';
// echo pageHeader('Inta');


if(isset($_POST['envoi'])){
    if (isset($_POST['Pseudo'])  AND !empty($_POST['Mot de passe'])){
        $Pseudo = $_POST['Pseudo'];
        $Mot_de_passe = md5($_POST['Mot de passe']);

        $recupUser = $db->prepare('SELECT * FROM utilisateurs WHERE pseudo = ? AND mot_de_passe = ?');
        $recupUser -> execute([$Pseudo, $Mot_de_passe]);

        if($recupUser->rowCount()>0){
            $_SESSION['pseudo']=$Pseudo;
            $_SESSION['Mot de passe']=$Mot_de_passe;
            $_SESSION['id'] = $recupUser->fetch()['id'];
            header('Location: index.php');
        }else{
            echo "Votre mot de passe ou pseudo est incorrect";
        }
    }else{
        echo "Veuillez tout compléter";
    }
}
?>



<html>
<head>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login">
        <form method="POST" action="">
            <h1>Connexion</h1>

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="Pseudo" placeholder="Pseudo" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="Mot de passe" placeholder="Mot de passe" required>

            <button type="submit" name="envoi" class="btn">Connexion</button>

            <p> Vous n'avez pas de compte?<a href="Inscription"> En registrer vous</a></p>
        </form>
    </div>
</body>
</html>