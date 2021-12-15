<?php
session_start();
include('param.inc.php');
$mysqli = new mysqli($host, $user, $passwd, $dbname);

$idProjet = intval(htmlentities($_POST['idProjet']));
$idUser= intval(htmlentities($_SESSION['idUser']));

if(!($stmt = $mysqli->query("DELETE FROM isinscrit WHERE id_utilisateur='$idUser' AND id_projet='$idProjet' ")))
{
    // Afficher erreur

    echo "error1";
    header('Location: accueilEtudiants.php');
}  
else 
{
    // Afficher suppression réussie
    echo 'ok';
    header('Location: accueilEtudiants.php');
}  
?>