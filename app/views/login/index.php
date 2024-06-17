<!DOCTYPE=html>
<html lang="en">
  <head>
    <title>Schaatsbingo.nl | CMS - Login</title> 

    <!-- metadata -->
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Bingokaarten maken en invullen rondom schaatsen, sportclubs en andere (winter)sportactiviteiten binnen jouw sportieve leven" />
    <meta name="author" content="Sander Nederstigt" />
    <meta name="keywords" content="bingo, bingokaarten, gebeurtenissen, Haarlem, Haarlem-Noord, Hogeschool, ijsverenigingen, Inholland Hogeschool, kaarten, Nederland, persoonlijke ervaringen, schaatsen, sport, sportclubs, winter, wintersport, woorden" />

    <!-- javascript -->
    <script src="js/functions.js"></script>

    <!-- bootstrap v5.3.3 -->
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style/style.scss">
    <link rel="icon" href="assets/schaatsbingo-logo.svg" sizes="any" type="image/svg">
  </head>
  <body style="display: block !important;">
    <section class="container" id="logincontainer">
      <section class="row justify-content-center">
        <section class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
          <section class="card border border-light-subtle rounded-3 shadow-sm">
            <section class="card-body p-3 p-md-4 p-xl-5">
              <section class="text-center mb-3">
                  <img src="assets/schaatsbingo-logo.svg" class="website-logo-image" alt="Schaatsbingo.nl Logo" width="200" height="190">
              </section>
              <h1 class="website-logo-text">Schaatsbingo.nl</h1>
              <h2 class="text-center text-secondary mb-4 website-logo-text">CMS - login</h2>
              <form name="login-form" action="/home/login/" method="POST" onsubmit="apiLogin()">
                <section class="row gy-2 overflow-hidden">
                  <section class="col-12">
                    <section class="form-floating mb-3">
                      <input type="text" class="form-control" name="form-username" id="form-username" placeholder="John Doe" required <?php if (isset($_SESSION["loginError"]) == true){ echo 'style="border-color: #E80F0F;"';} ?>>
                      <label for="form-username" class="form-label">Username</label>
                    </section>
                  </section>
                  <section class="col-12">
                    <section class="form-floating mb-3">
                      <input type="password" class="form-control" name="form-password" id="form-password" value="" placeholder="Password" required <?php if (isset($_SESSION["loginError"]) == true){ echo 'style="border-color: #E80F0F;"';} ?>>
                      <label for="password" class="form-label">Password</label>
                    </section>
                  </section>

                  <?php
                    if(isset($_SESSION['loginError']) == true) 
                    {
                      echo '<section class="col-12">';
                      echo '<p class="m-0 text-secondary text-center warningtext">' . $_SESSION['loginError'] . '</p>';
                      echo '</section class="col-12">';
                      
                      unset($_SESSION['loginError']);
                      unset($_SESSION[ 'userIsAdmin']);
                    }
                  ?>

                  <section class="col-12">
                    <p class="m-0 text-secondary text-center warningtext">Let Op: Alleen voor beheerders!</p>
                  </section>
                  </section>
                  <section class="col-12">
                    <section class="d-grid my-3">
                      <button class="btn btn-primary btn-lg" type="submit">Log in</button> <a></a>
                    </section>
                  </section>
                </section>
              </form>
            </section>
          </section>
        </section>
      </section>
    </section>
  </body>
</html>