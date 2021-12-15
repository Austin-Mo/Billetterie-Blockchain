<?php
include 'fonctions.php';
if (isset($_POST['idProjet']) AND isset($_POST['titre']) AND isset($_POST['description']) AND isset($_POST['nbPlaceDispo']) AND isset($_FILES['pdf'])) 
{
    $id = $_POST['idProjet'];
    $projetBefore = get_projet($id);

    $titre = $_POST['titre'];
    if($titre == ""){
        $titre = $projetBefore[1];
    }

    $description = $_POST['description'];
    if($description == ""){
        $description = $projetBefore[2];
    }

    $nbPlaceDispo = $_POST['nbPlaceDispo'];
    if($nbPlaceDispo == ""){
        $nbPlaceDispo = $projetBefore[3];
    }

    $pdf = $_FILES['pdf'];
    if($pdf['name'] == ""){
        $pdf = $projetBefore[4];
        if(isset($_POST['deletePdf']))
        {
            $pdf = "";
        }
    }

    update_projet($id, $titre, $description, $nbPlaceDispo, $pdf);
    header('Location: accueilProf.php');
}
else{echo 'manque une variable';}

?>