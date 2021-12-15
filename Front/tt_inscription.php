<?php
    session_start();
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $idProjet = intval(htmlentities($_POST['idProjet']));
    $idUser= intval(htmlentities($_SESSION['idUser']));

    if(!($stmt = $mysqli->prepare("INSERT INTO isinscrit(id_utilisateur, id_projet) VALUES (?,?) ")))
    {
        // Afficher erreur
        echo "error1";
        header('Location: accueilEtudiants.php');
    }  
    else 
    {
        $stmt->bind_param('ii', $idUser, $idProjet);
        if(!$stmt->execute()) 
        {
            // Afficher erreur
            echo $idUser, $idProjet;
            header('Location: accueilEtudiants.php');
        } 
        else 
        {
            // Afficher enregistrement réussi
            echo "ok";
            header('Location: accueilEtudiants.php');
        }
    }  
?>