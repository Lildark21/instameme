<link rel="stylesheet" type="text/css" href="css\index.css">
<?php
session_start();
require_once 'affichage.php';
require_once 'db.php';

function getTotalContenus() {
    $totalStmt = db()->prepare("SELECT COUNT(*) AS total FROM contenus");
    $totalStmt->execute();
    return $totalStmt->fetchColumn();
}


$nombrecontenu = 10; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$totalContenus = getTotalContenus(); 
$totalPages = ceil($totalContenus / $nombrecontenu);


$offset = ($page - 1) * $nombrecontenu;

$stmt = db()->prepare("SELECT
contenus.id,
contenus.chemin_image,
contenus.description,
utilisateurs.pseudo,
likes_par_contenu.nb_likes,
commentaires_par_contenu.nb_commentaires
FROM
contenus
LEFT JOIN utilisateurs ON utilisateurs.id = contenus.id_utilisateur
LEFT JOIN (
    SELECT
        id_contenu,
        COUNT(id_utilisateur) AS nb_likes
    FROM
        likes
    GROUP BY
        id_contenu
) AS likes_par_contenu ON likes_par_contenu.id_contenu = contenus.id
LEFT JOIN (
    SELECT
        id_contenu,
        COUNT(id) AS nb_commentaires
    FROM
        commentaires
    GROUP BY
        id_contenu
) AS commentaires_par_contenu ON commentaires_par_contenu.id_contenu = contenus.id
LIMIT $nombrecontenu OFFSET $offset
");

$stmt->execute();
$contenus = $stmt->fetchAll();
?>

<?php
echo pageHeader("instameme");

?>
<div class="grid grid-cols-3 gap-10">
    <?php
    foreach ($contenus as $contenu) {
        echo '<div class="flex flex-col justify-center items-center space-y-2" id="' . $contenu['id'] . '">'
        .'<a href="composants\profil.php?pseudo=' . urlencode($contenu['pseudo']) . '"><button><p>'. $contenu['pseudo'] . '</p></button></a>'
        .'<a href="visu.php?id_contenu=' . urlencode($contenu['id']) . '"><img src="' . 'images/' . $contenu['chemin_image'] . '" class="h-40" /></a>'
        . '<button><p>Likes: ' . $contenu['nb_likes'] .'</p></button>'
        . '<p>Commentaire: </p>' ;
        
        $commentairesStmt = db()->prepare("SELECT * FROM commentaires WHERE id_contenu = ?");
        $commentairesStmt->execute([$contenu['id']]);
        $commentaires = $commentairesStmt->fetchAll();
        foreach ($commentaires as $commentaire) {
            echo '<p>' . $commentaire['message'] . '</p>';
        }
        
        
        echo '<form action="ajouter_commentaire.php" method="post">';
        echo '<input type="hidden" name="id_contenu" value="' . $contenu['id'] . '">';
        echo '<input type="text" name="message" placeholder="Ajouter un commentaire">';
        echo '<button type="submit">Commenter</button>';
        echo '</form>'
        . '</div>';
    }
    ?>
</div>


<?php
echo '<div class="pagination">';
echo '<span>Page ' . $page . ' sur ' . $totalPages . '</span>';
echo '<ul>';
for ($i = 1; $i <= $totalPages; $i++) {
    echo '<li><a href="?page=' . $i . '">' . $i . '</a></li>';}
?>

<?php echo pageFooter(); ?>