<?php

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['Pseudo']) && !empty($_POST['Mot_de_passe'])) {

        $pseudo = htmlspecialchars($_POST['Pseudo']);
        $Mot_de_passe = md5(htmlspecialchars($_POST['Mot_de_passe']));

        $sqlQuery = 'SELECT pseudo FROM utilisateurs WHERE pseudo = :pseudo';
        $stm = db()->prepare($sqlQuery);
        $stm->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stm->execute();
        $recipes = $stm->fetch(PDO::FETCH_ASSOC);

        if (!$recipes) { 

            $sql = 'INSERT INTO utilisateurs(pseudo, mot_de_passe, date_inscription) VALUES (:pseudo, :mot_de_passe, :date_inscription)';
            $stm = db()->prepare($sql);
            $stm->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
            $stm->bindParam(':mot_de_passe', $Mot_de_passe, PDO::PARAM_STR); // Correction de la variable
            $date_inscription = date('Y-m-d H:i:s');
            $stm->bindParam(':date_inscription', $date_inscription, PDO::PARAM_STR);
            $stm->execute();
            $_SESSION['isConnect'] = $_POST['Pseudo'];
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <div class="inscription">
        <form method="POST" action="">
            <h1>Inscription</h1>

            <label for="pseudo">Pseudo</label>
            <input type="text" id="pseudo" name="Pseudo" placeholder="Pseudo" required>

            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="Mot_de_passe" placeholder="Mot de passe" required>

            <button type="submit" name="envoi" class="btn">S'inscrire</button>

        </form>
    </div>
</body>
</html>
