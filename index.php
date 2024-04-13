<?php
require_once 'affichage.php';
require_once 'db.php';

$stmt = db()->prepare("SELECT
contenus.id,
contenus.chemin_image,
commentaires.description,
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
");
$stmt->execute();
$contenus = $stmt->fetchAll();
?>


<?php
echo pageHeader("Instameme");
?>



<div class="grid grid-cols-3 gap-8">
    <?php
    foreach ($contenus as $contenu) {
        echo '<div class="flex flex-col justify-center items-center space-y-2" id="' . $contenu['id'] . '">'
        . '<a href="composants\profil.php?pseudo=' . urlencode($contenu['pseudo']) . '"><button><p>'. $contenu['pseudo'] . '</p></button></a>'
        . '<img src="' . 'images/' . $contenu['chemin_image'] . '" class="h-40" />'
        . '<button><p>Likes: ' . $contenu['nb_likes'] .'</p></button>'
        . '<p>Commentaire: </p>';
    }
    ?>
</div>
<?php echo pageFooter(); ?>