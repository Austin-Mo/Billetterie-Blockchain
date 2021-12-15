<?php
include 'fonctions.php';
if (isset($_POST['id']))
{
    $id =$_POST['id'];
    
    delete_projet($id);
}
else{echo 'manque une variable';}

?>