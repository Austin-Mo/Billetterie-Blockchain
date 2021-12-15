<?php
include 'fonctions.php';
session_start();
is_connected('profPage');
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
          <h2>Détails du projet</h2>
          <p>Voici un bref récapitulatif du projet étudiant à modifier.</p>
        </div>

        <div class="container" data-aos="fade-up">
          <div class="row justify-content-md-center">
            <?php
            $idProjet = htmlentities($_POST['idProjet']);
            //on va chercher toutes les info du projet dans la BDD
            $projet = get_projet($idProjet);
            ?>

            <!-- Main -->
            <div id="main">
              <div class="inner">
                <!-- Formulaire -->
                <section id="formulaire" > 
                  <form method="post" action="tt_modifierProjet.php" enctype="multipart/form-data">
                    <input type="hidden" name="idProjet" id="idProjet" value="<?php echo $idProjet; ?>">
                    <div class="row justify-content-md-center">
                      <div class="input-group" style="width:60%; margin-bottom: 1em;">
                        <span class="input-group-text">Titre :</span>
                        <input class="form-control" type="text" name="titre" id="titre" placeholder="<?php echo $projet[1] ?>">
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="input-group" style="width:60%; margin-bottom: 1em;">
                        <span class="input-group-text">Description :</span>
                        <textarea  class="form-control" type="text" name="description" id="description" placeholder="<?php echo $projet[2] ?>"></textarea>
                      </div>
                    </div>
                    <div class="row justify-content-md-center">
                      <div class="input-group" style="width:60%; margin-bottom: 1em;">
                        <span class="input-group-text">Nombre de places disponibles :</span>
                        <input class="form-control" type="text" name="nbPlaceDispo" id="nbPlaceDispo" placeholder="<?php echo $projet[3] ?>">
                      </div>
                    </div>


                    <?php
                    if (isset($projet[4]) AND $projet[4]!="") {
                      echo'
                      <div class="row justify-content-md-center">
                      <div class="input-group justify-content-md-center" style="width:60%; margin-bottom: 1em; text-align:center;">
                      <a class="btn" href="'.$projet[4].'" style="width:50%; background-color:#24a0ed; color:white;">Lien de la plaquette actuelle</a>
                      </div>
                      </div>
                      <div class="row justify-content-md-center">
                      <div class="input-group justify-content-md-center" style="width:60%; margin-bottom: 1em; text-align:center;">
                      <div class="form-check">
                      <input class="form-check-input" type="radio" name="deletePdf" id="deletePdf" value="on">
                      <label class="form-check-label" for="deletePdf">
                      Supprimer le PDF actuel
                      </label>
                      </div>
                      </div>
                      </div>';
                    }
                    else{
                      echo'
                      <div class="row gtr-uniform justify-content-md-center">
                      <div class="col justify-content-md-center" id="divLienPdf"  style="width:60%; text-align:center; margin-bottom: 1em;">
                      Pas de PDF associé au projet...
                      </div>
                      </div>';
                    }
                    ?>
                    <div class="row justify-content-md-center">
                      <!-- nouveau pdf du projet à modifier -->
                      <div class="input-group"  style="width:60%; margin-bottom: 1em;">
                        <input class="form-control" type="file" name="pdf" id="pdf" accept="application/pdf,application/vnd.ms-excel">
                      </div>
                    </div>

                    <?php
                    $listeIdEtudiant = get_inscriptions_projet($idProjet);
                    if(count($listeIdEtudiant)!=0){
                      echo '
                      <div class="row justify-content-md-center">
                      <div class="input-group justify-content-md-center"  style="width:60%; margin-bottom: 1em; text-align:center;">
                      <strong>Étudiants inscrits au projet :</strong>
                      <table class="table">
                      <thead>
                      <tr>
                      <th scope="col">#</th>
                      <th scope="col">Prénom</th>
                      <th scope="col">Nom</th>
                      <th scope="col">Email</th>
                      </tr>
                      </thead>
                      <tbody>';
                      for ($i=0; $i<count($listeIdEtudiant); $i++)
                      {
                        $etu = get_utilisateurs_by_id($listeIdEtudiant[$i]);
                        echo '
                        <tr>
                        <th scope="row">'.$i.'</th>
                        <td>'.$etu[1].'</td>
                        <td>'.$etu[2].'</td>
                        <td>'.$etu[3].'</td>
                        </tr>';
                      }
                      echo '</tbody>
                      </table>
                      </div></div>';
                    }
                    ?>

                    <div class="row justify-content-md-center">
                      <div class="input-group" style="width:30%;">
                        <input class="btn btn-primary mb-3 form-control" type="submit" value="Envoyer"/>
                      </div>
                    </div>
                  </div>

                </form>
              </section>
            </div>
          </div>
        </div>

        
        


        <script>
    ///////////////////////////////////////////////////////////////////
    //script qui vérifie que le pdf uploadé n'est pas trop volumineux
    var uploadField = document.getElementById("pdf");

    uploadField.onchange = function() {
      if(this.files[0].size > 2097152){
        alert("Attention ! Votre fichier est trop volumineux !");
        this.value = "";
      };
    };
    ///////////////////////////////////////////////////////////////////
  </script>


</div>
</div>
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