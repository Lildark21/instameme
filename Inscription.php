<?php
session_start();
include_once 'db.php';

if(isset($_POST['envoi'])){
    if (isset($_POST['Pseudo']) && !empty($_POST['mdp'])){
        $pseudo = htmlspecialchars($_POST['Pseudo']);
        $mdp = md5($_POST['mdp']);
        $insertuser = $db->prepare('INSERT INTO utilisateurs(pseudo,mdp) VALUES(?,?)');
        $insertuser->execute(array($pseudo,$mdp));
        }
    else{
        echo "Veuillez tout compléter ...";
    }
}
?>




<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <form method="POST" action="" align="center">
        <input type="text" name="pseudo" placeholder="Pseudo">
        <br>
        <input type="password" name="mdp" placeholder="Mot de passe">
        <br>
        <input type="submit" name="envoi" value="S'inscrire">
    </form>
</body>
</html>