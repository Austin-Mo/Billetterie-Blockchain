<?php
include 'fonctions.php';
session_start();
is_connected('adminPage');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Project Manager</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/logo-esig.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- navbar -->
  <?php 
  include 'navbarAdmin.php';
  ?>

  <!-- END navbar -->


  <main id="main">


    <!-- compteurs -->
    <section id="counts" class="counts">
      <div class="container">

        <div class="row counters">

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo get_nb_etudiants(); ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Étudiants</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo get_nb_projets(); ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Projets</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo get_nb_inscrits(); ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Inscriptions</p>
          </div>

          <div class="col-lg-3 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?php echo get_nb_profs(); ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Professeurs</p>
          </div>

        </div>

      </div>
    </section>
    <!-- END compteurs -->


    <!-- Detail projets -->
    <section id="projects" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Détails des projets</h2>
          <p>Voici un bref récapitulatif des projets étudiants en cours, pour plus d'information, veuillez vous connecter.</p>
        </div>
        <?php 
        $projets = get_projets();
        $nbProjets = count($projets);
        $nbPlaceRestantes = 0;
        $nbLignes = 0;
        $projetSup = 0;
        $idEtudiant = intval($_SESSION['idUser']);
        $idProjetIsInscrit = get_inscriptions_etudiant($idEtudiant);

        if ($nbProjets % 3 == 0)
        {
          $nbLignes = floor($nbProjets/3);
          $projetSup = 0; 
        }
        elseif ($nbProjets % 3 == 1)
        {
          $nbLignes = floor($nbProjets/3);
          $projetSup = 1; 
        }
        elseif ($nbProjets % 3 == 2)
        {
          $nbLignes = floor($nbProjets/3);
          $projetSup = 2;
        }
        echo '<div class="row gy-4 justify-content-md-center">';
        for($i=0; $i<$nbLignes; $i++)
        {
          for($j=0; $j<3; $j++)
          {
            $id = $j+$i*3;
            $realID = $id+1;
            $nbPlaceRestantes = $projets[$id][3]-get_nb_inscrits_by_projet($projets[$id][0]);
            $lienPdf = $projets[$id][4];
            $arrayDesc = explode(' ', trim($projets[$id][2]));
            $arrayDesc = array_slice($arrayDesc, 0, 10, true);
            $arrayDesc = implode(" ", $arrayDesc).'...';
            echo 
            '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue" style="width:100%;">
            <h4><a href="#">'.$projets[$id][1].'</a></h4>
            <p>'.$arrayDesc.'</p>
            <hr>
            <p>Places totales : '.$projets[$id][3].'</p>
            <hr>
            <p>Places restantes : '.$nbPlaceRestantes.'</p>';
            if(isset($lienPdf) AND $lienPdf!="")
            {
              echo'<hr>
              <p><a href='.$lienPdf.'>Lien de la plaquette</a></p>';
            }
            
            echo'<hr><a href="#" onclick="supprimerProjet('.$projets[$id][0].')" class="btn" style="color:white; background-color:#d9534f;">Supprimer</a>';

            echo
            '</div>
            </div>';
          }
        }
        for($i=$projetSup; $i>0; $i--){
          $id = $nbProjets-$i;
          $realID = $id+1;
          $nbPlaceRestantes = $projets[$id][3]-get_nb_inscrits_by_projet($projets[$id][0]);
          $lienPdf = $projets[$id][4];
          $arrayDesc = explode(' ', trim($projets[$id][2]));
          $arrayDesc = array_slice($arrayDesc, 0, 10, true);
          $arrayDesc = implode(" ", $arrayDesc).'...';
          echo 
          '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box iconbox-blue" style="width:100%;">
          <h4><a href="#">'.$projets[$id][1].'</a></h4>
          <p>'.$arrayDesc.'</p>
          <hr>
          <p>Places totales : '.$projets[$id][3].'</p>
          <hr>
          <p>Places restantes : '.$nbPlaceRestantes.'</p>';
          if(isset($lienPdf) AND $lienPdf!="")
          {
            echo'<hr>
            <p><a href='.$lienPdf.'>Lien de la plaquette</a></p>';
          }

          echo'<hr><a href="#" onclick="supprimerProjet('.$projets[$id][0].')" class="btn" style="color:white; background-color:#d9534f;">Supprimer</a>';

          echo
          '</div>
          </div>';
        }

        echo '
        <div class="container" data-aos="fade-up">
        <div class="row justify-content-md-center">
        <button class="btn btn-primary" onclick="window.location.href=\'ajouterProjetAdmin.php\'" style="width:60%;">Nouveau Projet</button>
        </div>
        </div>';
        echo '</div>';
        ?>
      </div>
    </section>
    <!-- END Details projets-->




    <!-- Detail professeurs -->
    <section id="profs" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Détails des professeurs</h2>
          <p>Voici un bref récapitulatif des professeurs.</p>
        </div>
        <?php 
        $profs = get_profs();
        $nbProfs = count($profs);
        $nbLignes = 0;
        $profsSup = 0;

        if ($nbProfs % 3 == 0)
        {
          $nbLignes = floor($nbProfs/3);
          $profsSup = 0; 
        }
        elseif ($nbProfs % 3 == 1)
        {
          $nbLignes = floor($nbProfs/3);
          $profsSup = 1; 
        }
        elseif ($nbProfs % 3 == 2)
        {
          $nbLignes = floor($nbProfs/3);
          $profsSup = 2;
        }
        echo '<div class="row gy-4 justify-content-md-center">';
        for($i=0; $i<$nbLignes; $i++)
        {
          for($j=0; $j<3; $j++)
          {
            $id = $j+$i*3;
            $realID = $id+1;
            $prenom = $profs[$id][1];
            $nom = $profs[$id][2];
            $username = $profs[$id][3];
            $email = $profs[$id][4];
            echo 
            '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue" style="width:100%;">
            <h4><a href="#">'.$prenom.' '.$nom.'</a></h4>
            <hr>
            <p>Username : '.$username.'</p>
            <hr>
            <p>Email : '.$email.'</p>
            <hr>
            <a href="#" onclick="supprimerUtilisateur('.$profs[$id][0].')" class="btn" style="color:white; background-color:#d9534f;">Supprimer</a>
            </div>
            </div>';
          }
        }
        for($i=$profsSup; $i>0; $i--){
          $id = $nbProfs-$i;
          $realID = $id+1;
          $prenom = $profs[$id][1];
          $nom = $profs[$id][2];
          $username = $profs[$id][3];
          $email = $profs[$id][4];
          echo 
          '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box iconbox-blue" style="width:100%;">
          <h4><a href="#">'.$prenom.' '.$nom.'</a></h4>
          <hr>
          <p>Username : '.$username.'</p>
          <hr>
          <p>Email : '.$email.'</p>
          <hr>
          <a href="#" onclick="supprimerUtilisateur('.$profs[$id][0].')" class="btn" style="color:white; background-color:#d9534f;">Supprimer</a>
          </div>
          </div>';
        }

        echo '
        <div class="container" data-aos="fade-up">
        <div class="row justify-content-md-center">
        <button class="btn btn-primary" onclick="window.location.href=\'ajouterProf.php\'" style="width:60%;">Nouveau Professeur</button>
        </div>
        </div>';
        echo '</div>';
        ?>
      </div>


    </section>
    <!-- END Details projets-->


    <!-- Detail eleves -->
    <section id="eleves" class="services section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Détails des élèves</h2>
          <p>Voici un bref récapitulatif des élèves.</p>
        </div>
        <?php 
        $eleves = get_students();
        $nbEleves = count($eleves);
        $nbLignes = 0;
        $elevesSup = 0;

        if ($nbEleves % 3 == 0)
        {
          $nbLignes = floor($nbEleves/3);
          $elevesSup = 0; 
        }
        elseif ($nbEleves % 3 == 1)
        {
          $nbLignes = floor($nbEleves/3);
          $elevesSup = 1; 
        }
        elseif ($nbEleves % 3 == 2)
        {
          $nbLignes = floor($nbEleves/3);
          $elevesSup = 2;
        }
        echo '<div class="row gy-4 justify-content-md-center">';
        for($i=0; $i<$nbLignes; $i++)
        {
          for($j=0; $j<3; $j++)
          {
            $id = $j+$i*3;
            $realID = $id+1;
            $prenom = $eleves[$id][1];
            $nom = $eleves[$id][2];
            $username = $eleves[$id][3];
            $email = $eleves[$id][4];
            echo 
            '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue" style="width:100%;">
            <h4><a href="#">'.$prenom.' '.$nom.'</a></h4>
            <hr>
            <p>Username : '.$username.'</p>
            <hr>
            <p>Email : '.$email.'</p>
            <hr>
            <a href="#" onclick="supprimerUtilisateur('.$eleves[$id][0].')" class="btn" style="color:white; background-color:#d9534f;">Supprimer</a>
            </div>
            </div>';
          }
        }
        for($i=$elevesSup; $i>0; $i--){
          $id = $nbEleves-$i;
          $realID = $id+1;
          $prenom = $eleves[$id][1];
          $nom = $eleves[$id][2];
          $username = $eleves[$id][3];
          $email = $eleves[$id][4];
          echo 
          '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
          <div class="icon-box iconbox-blue" style="width:100%;">
          <h4><a href="#">'.$prenom.' '.$nom.'</a></h4>
          <hr>
          <p>Username : '.$username.'</p>
          <hr>
          <p>Email : '.$email.'</p>
          <hr>
          <a href="#" onclick="supprimerUtilisateur('.$eleves[$id][0].')" class="btn" style="color:white; background-color:#d9534f;">Supprimer</a>
          </div>
          </div>';
        }

        echo '</div>';
        ?>
      </div>


    </section>
    <!-- END Details projets-->
    <style>
    .bouton-rouge{
      -moz-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      -webkit-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      -ms-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      background-color: #d9534f;
      border-radius: 4px;
      border: 0;
      box-shadow: inset 0 0 0 2px #748B97;
      color: #fff;
      cursor: pointer;
      font-size: 0.8vw;
      font-weight: 900;
      line-height: 2.45em;
      padding: 0 0 0 0;
      text-align: center;
      text-transform: uppercase;
    }
    .bouton-rouge:hover {
      background-color: #d9534f !important;
      color: white;
      box-shadow: inset 0 0 0 2px #d9534f;
    }
    .bouton-blanc{
      -moz-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      -webkit-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      -ms-transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
      background-color: transparent;
      border-radius: 4px;
      border: 0;
      box-shadow: inset 0 0 0 2px #748B97;
      color: #748B97 !important;
      cursor: pointer;
      font-size: 0.8vw;
      font-weight: 900;
      line-height: 2.45em;
      padding:  0 5px 0 5px;
      text-align: center;
      text-transform: uppercase;
    }
    .bouton-blanc:hover {
      color: #d9534f !important;
      box-shadow: inset 0 0 0 2px #d9534f;
    }
    .Swal-button-rouge {
      padding: 7px 19px;
      border-radius: 4px;
      background-color: #d9534f;
      border: 0;
      color: #ffffff !important;
    }
    .Swal-button-rouge:hover {
      padding: 7px 19px;
      border-radius: 4px;
      background-color: #d9534f !important;
      border: 0;
      color: #ffffff !important;
    }
    .Swal-button-blanc {
      padding: 7px 19px;
      border-radius: 4px;
      background-color: #ffffff;
      border: 0;
      color: #d9534f !important;
      margin-right: 1vw;
    }
    .Swal-button-blanc:hover {
      padding: 7px 19px;
      border-radius: 4px;
      border: 0;
      color: #d9534f !important;
    }
  </style>
  <script>
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: 'Swal-button-blanc',
        denyButton: 'Swal-button-rouge'
      },
      buttonsStyling: false
    })
        ///////////////////////////////////////////////////////////////////
        function supprimerProjet($id)
        {
          swalWithBootstrapButtons.fire({
            title: "Supprimer ?",
            icon: 'question',
            text: "Voulez-vous réellement supprimer ce projet ?",
            showDenyButton: true,
            confirmButtonText: `Supprimer`,
            denyButtonText: `Ne pas Supprimer`,
          }).then((result) => {
            if (result.isConfirmed) {
              $.post(
                'tt_supprimerProjet.php',
                {
                  id: $id
                },
                'text'
                );
              swalWithBootstrapButtons.fire({
                title:'Supprimé!',
                icon: 'success',
              }).then(()=> {
                location.reload();
              })
            }
          });
        }
        ///////////////////////////////////////////////////////////////////
        function supprimerUtilisateur($id)
        {
          swalWithBootstrapButtons.fire({
            title: "Supprimer ?",
            icon: 'question',
            text: "Voulez-vous réellement supprimer cet utilisateur ?",
            showDenyButton: true,
            confirmButtonText: `Supprimer`,
            denyButtonText: `Ne pas Supprimer`,
          }).then((result) => {
            if (result.isConfirmed) {
              $.post(
                'tt_supprimerUtilisateur.php',
                {
                  id: $id
                },
                'text'
                );
              swalWithBootstrapButtons.fire({
                title:'Supprimé!',
                icon: 'success',
              }).then(()=> {
                location.reload();
              })
            }
          });
        }
        ///////////////////////////////////////////////////////////////////
      </script>
    </main><!-- End #main -->

    <?php include 'footer.php' ?>

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

  </body>

  </html>