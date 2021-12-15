<?php
session_start();

if (isset($_POST['firstname']) AND isset($_POST['lastname']) AND isset($_POST['username']) AND isset($_POST['password']) AND isset($_POST['email'])) {
    $options = ['cost' => 10];

    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);


    $firstname = htmlentities($_POST['firstname']);
    $lastname = htmlentities($_POST['lastname']);
    $username = htmlentities($_POST['username']);
    $mdp = htmlentities($_POST['password']);
    $email = htmlentities($_POST['email']);
    $isAdmin = 0;
    $isProf = 0;


    if (!($requete = $mysqli->query("SELECT * From utilisateur WHERE email = '$email'" )))
    {
                    // Afficher erreur
        printf("Erreur : %s.\n", $requete->error);
        header('Location: register.php');
    }
    else {
        $resultat = $requete->fetch_all();
        if (count($resultat)==0) 
        {
            if(!($stmt = $mysqli->prepare("INSERT INTO utilisateur(firstname, lastname, username, mdp, email, is_admin, is_prof) VALUES (?, ?, ?, ?, ?, ?, ?)"))) 
            {
                                // Afficher erreur
                echo "error1";
                header('Location: register.php');
            }  
            else 
            {
                $passcrypt = password_hash($mdp, PASSWORD_BCRYPT, $options);
                $stmt->bind_param('sssssii',$firstname, $lastname, $username, $passcrypt, $email, $isAdmin, $isProf);
                if(!$stmt->execute()) 
                {
                                    // Afficher erreur
                    echo "error";
                    header('Location: creationCompte.php');
                } 
                else 
                {
                                    // Afficher enregistrement réussi

                    if(!($stmt2 = $mysqli->query("SELECT id, firstname, lastname, username, email, is_admin, is_prof FROM utilisateur WHERE (firstname='$firstname' AND lastname='$lastname' AND username='$username' AND email='$email' )")))
                    {
                                        // Afficher erreur
                        echo "error112354684";
                        printf("Erreur : %s.\n", $stmt2->error);
                        return 0;
                    }  
                    else 
                    {
                        setcookie ('emailRegisterError', 0, time()+1);
                        $result2 = $stmt2->fetch_all();
                        $_SESSION['idUser']=$result2[0][0];
                        $_SESSION['firstname']=$result2[0][1];
                        $_SESSION['lastname']=$result2[0][2];
                        $_SESSION['username']=$result2[0][3];
                        $_SESSION['email']=$result2[0][4];
                        $_SESSION['isadmin']=$result2[0][5];
                        $_SESSION['isprof']=$result2[0][6];
                    }

                    echo "ok";
                    header('Location: accueilEtudiants.php');
                }
            }
        }
        else{
            setcookie ('emailRegisterError', 1, time()+1);
            header ('location: creationCompte.php');
        }
    }
}  
?>