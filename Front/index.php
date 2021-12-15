<?php
include 'fonctions.php';
session_start();
if(isset($_SESSION['idUser']))
{
  header('Location: accueilAdmin.php');
}
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

  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  
<!-- navbar -->
  <?php 
  include 'navbar.php';
  ?>
<!-- END navbar -->


<!-- debut -->
  <section id="hero" class="d-flex align-items-center">

    <div class="container-fluid" data-aos="fade-up">
      <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 pt-3 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center">
          <h1>Connectez-vous pour accéder à plus d'informations !</h1>
          <div><a href="connexionPage.php" class="btn-get-started scrollto">Se connecter</a></div>
        </div>
        <div class="col-xl-4 col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="150">
          <img src="assets/img/logo-esig.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section>
<!-- END debut -->



  <main id="main">



<!-- a propos -->
    <section id="about" class="about">
      <div class="container">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="zoom-in" data-aos-delay="150">
            <img src="assets/img/about.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right">
            <h3>Project Manager</h3>
            <p class="fst-italic">
              Une plateforme de centralisation de l'information pour les projets étudiant.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> Permet de consulter les informations relatives à chaque projet.</li>
              <li><i class="bi bi-check-circle"></i> Permet à 3 types d'utilisateurs différents de se connecter.</li>
              <li><i class="bi bi-check-circle"></i> Permet à un étudiant de s'inscrire dans un projet.</li>
            </ul>
            <a href="#" class="read-more">En savoir plus</a>
          </div>
        </div>

      </div>
    </section>
<!-- END a propos-->



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
        echo '<div class="row gy-4">';
        for($i=0; $i<$nbLignes; $i++)
        {
          for($j=0; $j<3; $j++)
          {
            $c = $j+$i*3;
            $nbPlaceRestantes = $projets[$c][3]-get_nb_inscrits_by_projet($projets[$c][0]);
            $lienPdf = $projets[$c][4];
            $arrayDesc = explode(' ', trim($projets[$c][2]));
            $arrayDesc = array_slice($arrayDesc, 0, 10, true);
            $arrayDesc = implode(" ", $arrayDesc).'...';
            echo 
            '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue">
            <h4><a href="#">'.$projets[$c][1].'</a></h4>
            <p>'.$arrayDesc.'</p>
            <hr>
            <p>Places totales : '.$projets[$c][3].'</p>
            <hr>
            <p>Places restantes : '.$nbPlaceRestantes.'</p>';
            if(isset($lienPdf) AND $lienPdf!="")
            {
              echo'<hr>
              <p><a href='.$lienPdf.'>Lien de la plaquette</a></p>';
            }
            echo
            '</div>
            </div>';
          }
        }
        for($i=$projetSup; $i>0; $i--){
          $c = $nbProjets-$i;
          $nbPlaceRestantes = $projets[$c][3]-get_nb_inscrits_by_projet($projets[$c][0]);
            $lienPdf = $projets[$c][4];
            $arrayDesc = explode(' ', trim($projets[$c][2]));
            $arrayDesc = array_slice($arrayDesc, 0, 10, true);
            $arrayDesc = implode(" ", $arrayDesc).'...';
            echo 
            '<div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-box iconbox-blue">
            <h4><a href="#">'.$projets[$c][1].'</a></h4>
            <p>'.$arrayDesc.'</p>
            <hr>
            <p>Places totales : '.$projets[$c][3].'</p>
            <hr>
            <p>Places restantes : '.$nbPlaceRestantes.'</p>';
            if(isset($lienPdf) AND $lienPdf!="")
            {
              echo'<hr>
              <p><a href='.$lienPdf.'>Lien de la plaquette</a></p>';
            }
            echo
            '</div>
            </div>';
        }

        echo '</div>';
        ?>
      </div>
    </section>
    <!-- END Details projets-->



    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact section-bg">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contacts</h2>
        </div>

        <div class="row">
          <div class="col-lg-6">
            <div class="info-box mb-4">
              <i class="bx bx-map"></i>
              <h3>Adresse</h3>
              <p>Technopôle du Madrillet, Av. Galilée, 76800 Saint-Étienne-du-Rouvray</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email</h3>
              <p>contact@esigelec.fr</p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Téléphone</h3>
              <p>+33 XX XX XX XX</p>
            </div>
          </div>

        </div>
      </div>
    </section><!-- End Contact Section -->

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