<?php
//verifie si un utilisateur est connecter sinon renvoi vers login ou inscription 
//like rajoute +1 si l'utilisateur n'a pas like le poste sinon rien

session_start();

if ($_SERVER['REQUEST_METHOD']=== 'POST' AND isset($_POST['contenu_id'])){
    
    if(isset($_SESSION["est_connecte"]) AND $_SESSION["est_connecte"]){
        $userId = $_SESSION ["id_user"];
        $contenuId = $_POST ["id_contenu"];

        $stmt = db()-> prepare("SELECT COUNT(*) as cnt FROM likes WHERE id_utilisateurs = ? AND id_contenu = ?");
        $stmt ->execute([$userId, $contenuId]);
        $row = $stmt -> fetch(PDO::FETCH_ASSOC);
        $like = ($row['cnt'] > 0); 

        if (!$like){
            $insertstm = db()->prepare("INSERT INTO likes (id_utilisateur, id_contenu) VALUES (?, ?)");
            $insertstm->execute([$userId, $contentId]);
        } else {
            $supprimelike = db()-> prepare("DELETE FROM likes WHERE id_utilisateur = ? AND id_contenu = ? ");
            $supprimelike -> execute([$userId, $contentId]);
        }
        header ("location: index.php");
    } 
}
?>