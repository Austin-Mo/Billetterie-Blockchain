<?php
    include('param.inc.php');
    $mysqli = new mysqli($host, $user, $passwd, $dbname);


    $email = htmlentities($_POST['email']);
    $password = htmlentities($_POST['password']);
    
    
    if(!($requete = $mysqli->query("SELECT id, firstname, lastname, username, email, mdp, is_admin, is_prof FROM utilisateur WHERE email= '$email'")))
                    {
                        // Afficher erreur de connexion bdd
                        printf("Erreur : %s.\n", $requete->error);
                        header('Location: connexionPage.php');
                    }  
    else 
                    {   
                        $resultat = $requete->fetch_all();
                        if (count($resultat)==0) {
                            // Erreur email
                            echo 'email non valide';
                            setcookie('emailSigninError', 1, time()+1);
                            header('Location: connexionPage.php');
                        }
                        elseif (password_verify ( $password , $resultat[0][5] )){
                            session_start();
                            echo 'email valide';
                            setcookie('usernameSigninError',0);
                            echo 'le mot de passe est valide';
                            setcookie('passwordSigninError',0);
                            $_SESSION['idUser']=$resultat[0][0];
                            $_SESSION['firstname']=$resultat[0][1];
                            $_SESSION['lastname']=$resultat[0][2];
                            $_SESSION['username']=$resultat[0][3];
                            $_SESSION['email']=$resultat[0][4];
                            $_SESSION['isadmin']=$resultat[0][6];
                            $_SESSION['isprof']=$resultat[0][7];
                            header('Location: accueilEtudiants.php');
                        } else{
                            // Erreur mdp
                            echo 'mot de passe non valide';
                            setcookie('passwordSigninError', 1, time()+1);
                            header('Location: connexionPage.php');
                        }   
                    }
?>