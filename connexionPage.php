<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Billeterie Match</title>
  <!-- Favicons -->
  <link href="assets/img/logoDragon.jpg" rel="icon">
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
<body  style="background-color: rgb(252 190 25);">


 <main>
  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="shadow-lg card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <div class="container-img">
                  <img src="assets/img/logoDragon.png" style=" margin: 7vw 0 0 1vw;" />
                </div>
                <style type="text/css">
                  .container-img{
                   display:block;
                   overflow:hidden;
                 }
                 .container-img img{
                   width:95%;
                   height:95%;
                   -webkit-transition: all 0.2s;
                   -moz-transition: all 0.2s;
                   -ms-transition: all 0.2s;
                   -o-transition: all 0.2s;
                   transition: all 0.2s;
                 }
                 .container-img:hover img{
                   transform:rotate(360deg) scale(1);
                 }
               </style>
             </div>
             <div class="col-md-6 col-lg-7 d-flex align-items-center">
              <div class="card-body p-4 p-lg-5 text-black">





                <form action="tt_connexion.php" method ="POST">

                  <div class="d-flex align-items-center mb-3 pb-1">
                    <span class="h1 fw-bold mb-0">Billeterie Match</span>
                  </div>

                  <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Connectez-vous à votre compte :</h5>

                  <?php 
                  if(isset($_COOKIE['emailSigninError']))
                  {
                    if ($_COOKIE['emailSigninError']==1)
                    {
                      echo "<h6 style='color:red; font-style: italic;'>Pas de compte associé à cet email</h6>";
                    }
                  }
                  if(isset($_COOKIE['passwordSigninError']))
                  {
                    if ($_COOKIE['passwordSigninError']==1)
                    {
                      echo "<h6 style='color:red; font-style: italic;'>Mauvais mot de passe</h6>";
                    }
                  }
                  ?>

                  <div class="form-outline mb-4">
                    <input type="email" id="email" class="form-control form-control-lg" name="email" required/>
                    <label class="form-label" for="email">Email</label>
                  </div>

                  <div class="form-outline mb-4">
                    <input type="password" id="password" class="form-control form-control-lg" name="password" required/>
                    <label class="form-label" for="password">Mot de passe</label>
                  </div>

                  <div class="pt-1 mb-4">
                    <button class="btn btn-dark btn-lg btn-block" type="submit">Se connecter</button>

                  </div>

                  <a class="small text-muted" href="#!">Mot de passe oublié?</a>
                  <p class="mb-5 pb-lg-2" style="color: #393f81;">Vous n'avez pas de compte? <a href="creationCompte.php" style="color: #393f81;">créez-en un !</a></p>
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