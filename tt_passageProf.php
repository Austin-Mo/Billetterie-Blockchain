<?php
include 'fonctions.php';
if (isset($_POST['utilisateurAModifier']))
{
    $id =$_POST['utilisateurAModifier'];
    
    update_to_prof($id);
    header('Location: accueilAdmin.php');
}
else{echo 'manque une variable';}

?>