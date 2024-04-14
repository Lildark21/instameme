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
    
    <nav class='navbar'>
        <input type="text" name="search" placeholder="Rechercher...">
        <input href="recherche.php" type="submit" value="Rechercher">
        <a href="#">Accueil</a></li>
        <a href="login.php">Connexion\Inscription</a>
        <a href="creer.php">creer</a>
        <a href="profil.php">Profil</a>


        <?php
session_start();

if(isset($_SESSION['id']) && isset($_SESSION['pseudo'])){
    $user_id = $_SESSION['id'];
$user_pseudo = $_SESSION['pseudo'];
echo "<a href='logout.php'>$user_pseudo (Déconnexion)</a>";
};

?>
    </nav>

</header>

</body>