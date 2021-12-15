<?php

function get_nb_inscrits()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT COUNT(*) FROM isInscrit")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0][0]);

    }
}
function get_nb_inscrits_by_projet($id_projet)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT COUNT(*) FROM isInscrit WHERE id_projet='$id_projet'")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0][0]);

    }
}
function get_projets()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT * FROM projet")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result);

    }
}
function get_projet($j)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT *  FROM projet WHERE id= '$j' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0]);

    }
}

function update_projet($id, $titre, $description, $nbPlaceDispo, $pdf)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $id = intval($id);
    $nbPlaceDispo =intval($nbPlaceDispo);

    if(!is_string($pdf))
    {
        if ($pdf['error'] == 0)
        {
        // Testons si le fichier n'est pas trop gros
            if ($pdf['size'] <= 8000000)
            {
            // Testons si l'extension est autorisée
                $extension_upload = pathinfo($pdf['name'], PATHINFO_EXTENSION);
                $extensions_autorisees = array('pdf');
                if (in_array($extension_upload, $extensions_autorisees))
                {
                    move_uploaded_file($pdf['tmp_name'], 'pdfs/' .utf8_encode(str_replace(' ', '', $pdf['name'])));
                    $pdf = 'pdfs/' . utf8_encode(str_replace(' ', '', $pdf['name']));
                }
                else
                {
                    return('extension non autorisée');
                }

            }
            else
            {
                return('image trop volumineuse');
            }
        }
        else
        {
            return ($pdf['error']);
        }
    }
    if(!($stmt = $mysqli->prepare("UPDATE projet SET titre= ?, description = ?, lien_pdf = ?, nb_place_total = ? WHERE id = ?")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $stmt->bind_param('sssii',$titre, $description, $pdf, $nbPlaceDispo, $id);
        if(!$stmt->execute())
        {
            // Afficher erreur
            var_dump($titre, $description, $nbPlaceDispo, $pdf, $id);
            //header('Location: accueilProf.php');
        } 
        else 
        {
            $result = $stmt->fetch();
            return ($result);
        }

    }
}


function update_to_prof($id)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $id = intval($id);
    $is_admin = 1;

    if(!($stmt = $mysqli->prepare("UPDATE utilisateur SET is_prof= ? WHERE id = ?")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $stmt->bind_param('ii',$is_admin, $id);
        if(!$stmt->execute())
        {
            // Afficher erreur
            header('Location: accueilAdmin.php');
            return 0;
        } 
        else 
        {
            $result = $stmt->fetch();
            return ($result);
        }

    }
}

function get_nb_projets()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT COUNT(*) FROM projet")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0][0]);

    }
}

function get_nb_etudiants()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 0;

    if(!($stmt = $mysqli->query("SELECT COUNT(*) FROM utilisateur WHERE is_admin='$j' AND is_prof='$j' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0][0]);

    }
}

function get_utilisateurs_by_id($j)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT * FROM utilisateur WHERE id= '$j' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0]);

    }
}

function get_utilisateurs_by_email($j)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("SELECT * FROM utilisateur WHERE email= '$j' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result);

    }
}
function get_students()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 0;
    $i = 0;

    if(!($stmt = $mysqli->query("SELECT * FROM utilisateur WHERE is_admin = '$j' AND is_prof= '$i'")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result);
    }
}
function get_admins()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 1;

    if(!($stmt = $mysqli->query("SELECT * FROM utilisateur WHERE is_admin = '$j' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result);
    }
}

function get_profs()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 0;
    $i = 1;

    if(!($stmt = $mysqli->query("SELECT * FROM utilisateur WHERE is_admin = '$j' AND is_prof= '$i'")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result);
    }
}

function get_nb_profs()
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 1;

    if(!($stmt = $mysqli->query("SELECT COUNT(*) FROM utilisateur WHERE is_prof = '$j' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        return ($result[0][0]);
    }
}
function post_inscrit($id_utilisateur, $id_projet)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->prepare("INSERT INTO isinscrit(id_utilisateur, id_projet) VALUES (?, ?)")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $stmt->bind_param('ii', $id_utilisateur, $id_projet);
        if(!$stmt->execute()) 
        {
            // Afficher erreur
            echo "error";
            header('Location: creationCompte.php');
        } 
        else 
        {
            $result = $stmt->fetch_all();
            return ($result[0][0]);
        }

    }
}
function get_inscriptions_etudiant($id)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 1;

    if(!($stmt = $mysqli->query("SELECT id_projet FROM isinscrit WHERE id_utilisateur = '$id' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        $listIdProjet = array();
        for($i=0; $i <count($result); $i++){
            array_push($listIdProjet, intval($result[$i][0]));
        }
        return ($listIdProjet);
    }
}

function get_inscriptions_projet($id)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    $j = 1;

    if(!($stmt = $mysqli->query("SELECT id_utilisateur FROM isinscrit WHERE id_projet = '$id' ")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $result = $stmt->fetch_all();
        $listIdEtudiant = array();
        for($i=0; $i <count($result); $i++){
            array_push($listIdEtudiant, intval($result[$i][0]));
        }
        return ($listIdEtudiant);
    }
}
function is_connected($pageState)
{
    if(!isset($_SESSION['idUser']))
    {
        if($_SERVER['PHP_SELF'])
      header ('Location: connexionPage.php');
  }
  else 
  {
    if($_SESSION['isadmin']==1)
    {
        if($pageState == 'studentPage')
        {
            header ('Location: accueilAdmin.php');
        }
        elseif($pageState == 'profPage')
        {
            header ('Location: accueilAdmin.php');
        }
    }
    elseif($_SESSION['isprof']==1)
    {
        if($pageState == 'studentPage')
        {
            header ('Location: accueilProf.php');
        }
        if($pageState == 'adminPage')
        {
            header ('Location: accueilProf.php');
        }
    }
    else
    {
        if($pageState == 'adminPage')
        {
            header ('Location: accueilEtudiants.php');
        }
        if($pageState == 'profPage')
        {
            header ('Location: accueilEtudiants.php');
        }
    }
}
}

function delete_user($id){
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("DELETE FROM utilisateur WHERE id='$id'; ")))
    {
        // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        // Afficher suppression réussie
        $result = $stmt->fetch_all();
        return ($result);
    }  
}

function delete_projet($id){
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->query("DELETE FROM projet WHERE id='$id';")))
    {
        // Afficher erreur
       echo "error1";
       printf("Erreur : %s.\n", $stmt->error);
       return 0;
    }  
    else 
    {
        // Afficher suppression réussie
        $result = $stmt->fetch_all();
        return ($result);
    }  
}

function post_projet($titre, $description, $nb_place_total, $pdf)
{
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);

    if(!($stmt = $mysqli->prepare("INSERT INTO projet(titre, description, nb_place_total, lien_pdf) VALUES (?, ?, ?, ?)")))
    {
                    // Afficher erreur
        echo "error1";
        printf("Erreur : %s.\n", $stmt->error);
        return 0;
    }  
    else 
    {
        $stmt->bind_param('ssis', $titre, $description, $nb_place_total, $pdf);
        if(!$stmt->execute()) 
        {
            // Afficher erreur
            echo "error";
            header('Location: accueilProf.php');
        } 
        else 
        {
            $result = $stmt->fetch();
            return ($result);
        }

    }
}
?>