<?php
require_once 'affichage.php';
require_once 'db.php';

$stmt = db()->prepare("SELECT * FROM contenus");
$stmt->execute();
$contenus = $stmt->fetchAll();
?>

<?php
echo pageHeader("Bonjour");
echo "Hello World !";
?>
<div class="grid grid-cols-3 gap-8">
    <?php
    foreach ($contenus as $contenu) {
        echo '<div class="flex flex-col justify-center items-center space-y-2" id="' . $contenu['id'] . '">'
            . '<img src="' . 'images/' . $contenu['chemin_image'] . '" class="h-40" />'
            . $contenu['description']
            . '</div>';
    }
    ?>
</div>
<?php echo pageFooter(); ?>