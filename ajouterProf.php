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

  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- navbar -->
  <?php 
  include 'navbarConnected.php';
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
          <h2>Ajouter un professeur</h2>
          <p>Voici les comptes utilisateurs disponibles pour le passage à la qualification de professeur</p>
        </div>

        <div class="container" data-aos="fade-up">
          <div class="row justify-content-md-center">
            <?php
            $utilisateurs = get_students();
            ?>
            <!-- Formulaire -->
            <section id="formulaire" > 
              <form method="post" action="tt_passageProf.php" enctype="multipart/form-data">
                <div class="row gtr-uniform justify-content-md-center">
                  <div class="input-group mb-3" style="width:60%;">
                    <select class="form-select" id="utilisateurAModifier" name="utilisateurAModifier">
                      <option selected>- Utilisateur à modifier -</option>
                      <?php 
                      foreach($utilisateurs as $utilisateur)
                      {
                        echo '<option value="'.$utilisateur[0].'">'.$utilisateur[1].' '.$utilisateur[2].'</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div  style="width:100%; text-align:center; ">
                    <input type="submit" value="Passer l'utilisateur au statut de professeur" class="btn btn-primary" style="width:60%;"/>
                  </div>
                </div>
              </form>
            </section>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>


</section>
<!-- END Details projets-->

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