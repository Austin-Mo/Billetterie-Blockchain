<?php
include 'fonctions.php';
if (isset($_POST['id']))
{
    $id =$_POST['id'];
    
    delete_user($id);
}
else{echo 'manque une variable';}

?>