


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" type="text/css" href="css\header.css">
</head>

<body>

<header class="header">
    <a href="#" class='logo'>INSTAMEME</a>
    <?php

if(isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
    $user_id = $_SESSION['id'];
$user_pseudo = $_SESSION['pseudo'];
echo "<a href='logout.php'>$user_pseudo     Déconnexion</a>";
};
?>
    <nav class='navbar'>
        <a href="index.php">Accueil</a></li>
        <a href="login.php">Connexion\Inscription</a>
        <a href="creer.php">creer</a>
        <a href="profil.php">Profil</a>

    <form action="" method="GET">

<label for="name"></label>
<input type="search" name="pseudo" placeholder="Rechercher un compte…" size="30">

<button type="submit">Rechercher</button>

</form>
<?php if(isset($_GET['pseudo']) && !empty($_GET['pseudo'])){

header("location:recherche.php?recherche=". $_GET['pseudo']." ");
}
?>
    </nav>

</header>

</body>