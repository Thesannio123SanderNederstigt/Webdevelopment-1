<?php
    include_once __DIR__ . '/../header.php';
?>
		
		<!-- HOMEPAGE_VIEW -->
		
		<p hidden id="nav-current-page" name="bingo-nav-home"></p>
		<section class="container mt-5">
			<section class="row justify-content-md-center">
			    <section class="text-center mb-3">
					<img src="../assets/schaatsbingo-logo.svg" class="website-logo-image" alt="Schaatsbingo.nl Logo" width="250" height="240">
				</section>
				
				<h1 class="website-logo-text">Schaatsbingo.nl</h1>
                <h2 class="text-center text-secondary mb-4 website-logo-text">Content Management Systeem</h2>
				
				<h2 class="text-center text-secondary mb-4 mt-4 website-logo-text">Kies een onderstaande categorie om inhoud te beheren</h2>
				
				<section class="row gy-2 gy-xxl-2 mt-2 mb-5 flex-categories-container">

				  <section class="col-12 col-md-6 col-lg-4 col-xxl-6 mb-3">
					<a href="/user" class="anchor-tag">
						<section class="card text-center border-dark overflow-hidden">
							<section class="card-body position-relative card-categories">
								<figure class="m-0 p-0">
									<img class="img-fluid" loading="lazy" src="../assets/categorie-gebruikers.svg" alt="Users categorie" width="172">
									<figcaption class="mb-0 mt-4 p-0">
										<h4 class="categorie-text mb-2">Gebruikers</h4>
									</figcaption>
								</figure>
							</section>
						</section>
					</a>
				  </section>
				  
				  <section class="col-12 col-md-6 col-lg-4 col-xxl-6 mb-3">
					<a href="/sportsclub" class="anchor-tag">
						<section class="card text-center border-dark overflow-hidden">
							<section class="card-body position-relative card-categories">
								<figure class="m-0 p-0">
									<img class="img-fluid" loading="lazy" src="../assets/categorie-sportclubs.svg" alt="Users categorie" width="172">
									<figcaption class="mb-0 mt-4 p-0">
										<h4 class="categorie-text mb-2">Sportclubs</h4>
									</figcaption>
								</figure>
							</section>
						</section>
					</a>
				  </section>
				  
				  <section class="col-12 col-md-6 col-lg-4 col-xxl-6 mb-3">
					<a href="/bingocard" class="anchor-tag">
						<section class="card text-center border-dark overflow-hidden">
							<section class="card-body position-relative card-categories">
								<figure class="m-0 p-0">
									<img class="img-fluid" loading="lazy" src="../assets/categorie-bingokaarten.svg" alt="Users categorie" width="172">
									<figcaption class="mb-0 mt-4 p-0">
										<h4 class="categorie-text mb-2">Bingokaarten</h4>
									</figcaption>
								</figure>
							</section>
						</section>
					</a>
				  </section>
				  
				  <section class="col-12 col-md-6 col-lg-4 col-xxl-6 mb-3">
					<a href="/carditem" class="anchor-tag">
						<section class="card text-center border-dark overflow-hidden">
							<section class="card-body position-relative card-categories">
								<figure class="m-0 p-0">
									<img class="img-fluid" loading="lazy" src="../assets/categorie-kaart-items.svg" alt="Users categorie" width="172">
									<figcaption class="mb-0 mt-4 p-0">
										<h4 class="categorie-text mb-2">Kaart-items</h4>
									</figcaption>
								</figure>
							</section>
						</section>
					</a>
				  </section>  
				  
				</section>
				
			</section>
		</section>
		
<?php
    include_once __DIR__ . '/../footer.php';
?>