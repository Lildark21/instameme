<?php
session_start();

include_once 'db.php';

if(isset($_POST['envoi'])){
    if (!empty($_POST['Pseudo'])  AND !empty($_POST['Mot_de_passe'])){
        $Pseudo = $_POST['Pseudo'];
        $Mot_de_passe = md5($_POST['Mot_de_passe']);

        $recupUser = db()->prepare('SELECT * FROM utilisateurs WHERE pseudo = ? AND mot_de_passe = ?');
        $recupUser -> execute([$Pseudo, $Mot_de_passe]);

        if($recupUser->rowCount()>0){
            $user = $recupUser->fetch();
            $_SESSION['pseudo']=$Pseudo;
            $_SESSION['Mot_de_passe']=$Mot_de_passe;
            $_SESSION['id'] = $user['id'];
            header('Location: index.php');
        }else{
            echo "Votre mot de passe ou pseudo est incorrect";
        }
    }
    else{
        echo "Veuillez tout compléter";
    }
}
?>

<html>
<head>
    <link rel="stylesheet" href="css\login.css">
</head>
<body>
    <div class="login">
        <form method="POST" action="">
            <h1>Connexion</h1>

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="Pseudo" placeholder="Pseudo" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="Mot_de_passe" placeholder="Mot de passe" required>

            <button type="submit" name="envoi" class="btn">Connexion</button>

            <p> Vous n'avez pas de compte?<a href="Inscription.php"> En registrer vous</a></p>
        </form>
    </div>
</body>
</html>
