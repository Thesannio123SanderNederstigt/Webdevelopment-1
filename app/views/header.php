<!DOCTYPE=html>
<html lang="en">
    <head>
        <title>Schaatsbingo.nl | CMS</title>

        <!-- metadata -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Bingokaarten maken en invullen rondom schaatsen, sportclubs en andere (winter)sportactiviteiten binnen jouw sportieve leven" />
        <meta name="author" content="Sander Nederstigt" />
        <meta name="keywords" content="bingo, bingokaarten, gebeurtenissen, Haarlem, Haarlem-Noord, Hogeschool, ijsverenigingen, Inholland Hogeschool, kaarten, Nederland, persoonlijke ervaringen, schaatsen, sport, sportclubs, winter, wintersport, woorden" />

        <!-- scripts & links -->
        <script src="../js/functions.js"></script>

		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" rel="stylesheet">

        <link rel="stylesheet" href="style/style.scss">
        <link rel="icon" href="assets/schaatsbingo-logo.svg" sizes="any" type="image/svg">
    </head>
	<body onload="highlightActivePage()">
        <section class="container headerfooter">
            <section class="row">
                <section class="col-12">
                    <nav class="navbar navbar-expand-lg bsb-navbar bsb-navbar-hover bsb-navbar-caret bsb-tpl-navbar-sticky bg-white border border-dark px-xl-3 headernavbar" data-bsb-sticky-target="#header">
                        <section class="container headerfooter">
                            <h2 class="headernavbar">Schaatsbingo.nl</h2>
                            <h3 class="headernavbar" id="header-login-info">Welkom <?php if(ISSET($_SESSION['user'])){ echo $_SESSION['user']['username']; }?></h3>
                            <button class="navbar-toggler border-0 headernavbar" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"></path>
                                </svg>
                            </button>
                            <section class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <section class="offcanvas-header" id="offcanvas-bar-header">
                                    <h5 class="offcanvas-title navbar-linkitems" id="offcanvasNavbarLabel">CMS pagina's</h5>
                                    <button type="button" class="btn-close" id="close-button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </section>
                                <section class="offcanvas-body" id="offcanvas-bar-body">
                                    <ul class="navbar-nav justify-content-start flex-grow-1" id="navbarlinks">
                                        <li class="nav-item">
                                            <a class="nav-link navbar-linkitems active" aria-current="page" id="bingo-nav-home" href="/">Start</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link navbar-linkitems" id="bingo-nav-users" href="/user">Gebruikers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link navbar-linkitems" id="bingo-nav-sportsclubs" href="/sportsclub">Sportclubs</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link navbar-linkitems" id="bingo-nav-bingocards" href="/bingocard">Bingokaarten</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link navbar-linkitems" id="bingo-nav-carditems" href="/carditem">Kaart-items</a>
                                        </li>
                                    </ul>
                                    <form name="logout-form" action="/home/logout/" method="POST">
                                        <button type="submit" class="btn btn-danger bingo-danger-btn" id="logout-button" name="logout">Uitloggen</button>
                                    </form>
                                </section>
                            </section>
                        </section>
                    </nav>
                </section>
            </section>
        </section>