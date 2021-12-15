<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Project Manager</title>
  <!-- Favicons -->
  <link href="assets/img/logo-esig.png" rel="icon">
  <!-- Bootstrap CSS -->
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css'>
  <!-- Font Awesome CSS -->
  <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.3.1/css/all.css'>
  <!-- Style CSS -->
  <link rel="stylesheet" href="css/style.css">
  <!-- Demo CSS -->
  <link rel="stylesheet" href="css/demo.css">
  <!-- Login CSS -->
  <link rel="stylesheet" href="css/login.css">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

</head>
<body  style="background-color: #563cec;">


 <main>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="shadow-lg card" style="border-radius: 1rem; width:100%;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="assets/img/logo-esig.png" style="width:80%; margin:33% 0 0 15%;" />
              </div>
              <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">





                  <form action="tt_creationCompte.php" method ="POST">

                    <div class="d-flex align-items-center mb-3 pb-1">
                      <span class="h1 fw-bold mb-0">Project Manager</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Créez un compte :</h5>

                    <!--traitement de l'erreur si un username existe deja-->
                    <?php 
                    if (isset($_COOKIE['emailRegisterError']))
                    {
                      if ($_COOKIE['emailRegisterError'] == 1){                   
                        echo "<h6 style='color:red; font-style: italic;'>Email déjà associé à un compte</h6> ";
                      } 
                    }
                    ?>


                    <div class="row justify-content-md-center" style="margin-bottom: 2%;">
                      <div class="input-group" role="group">
                        <input type="" class="form-control form-control-lg" name="firstname" placeholder="Prénom" required>
                        <input type="" class="form-control form-control-lg" name="lastname" placeholder="Nom de famille" required>
                      </div>
                    </div>

                    <div class="row justify-content-md-center" style="margin-bottom: 2%;">
                      <div class="input-group" role="group">
                        <input type="" id="username" class="form-control form-control-lg" name="username" placeholder="username" required/>
                        <input type="email" id="inputEmail" class="form-control form-control-lg" name="email" placeholder="email" required/>
                      </div>
                    </div>

                    <div class="row justify-content-md-center"  style="margin-bottom: 2%;">
                        <input type="password" class="form-control form-control-lg" name="password" placeholder="Mot de passe" required>
                    </div>


                    <div class="row justify-content-md-center" style="margin-bottom: 2%;">
                      <button class="btn btn-dark btn-lg btn-block" type="submit">Créer un compte</button>
                    </div>

                    <a class="small text-muted" href="#!">Mot de passe oublié?</a>
                    <p class="" style="color: #393f81;">Vous avez déjà un compte? <a href="connexionPage.php" style="color: #393f81;">Connectez-vous y !</a></p>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
</body>
</html>