<?php

//rajoute un nouveau commentaire dans la bdd
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!empty($_POST['commentaires']))
    { 
        $id_contenu = $_POST['id_contenu'];
        $message =htmlspecialchars($_POST['commentaire']);
        $date_publication = date('Y-m-d H:i:s');
    
        $sql = ("SELECT commentaires FROM message WHERE message = :message");
        $stmt = db()->prepare($sql);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->execute();
        $commentaire = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if(!$commentaire){
    
        $sql = ("INSERT INTO commentaires (id_contenu, message, date_publication) VALUES (:id_contenu, :message, :date_publication)");
        $stmt = db()->prepare($sql);
        $stmt->bindParam(':id_contenu', $id_contenu, PDO::PARAM_INT);
        $stmt->bindParam(':message', $message, PDO::PARAM_STR);
        $stmt->bindParam(':date_publication', $date_publication, PDO::PARAM_STR);
        $stm->execute();
        $_SESSION['isConnect'] = $_POST['Pseudo'];
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit;
        }    
    }
}
?>