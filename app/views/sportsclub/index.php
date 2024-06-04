<?php
    include_once __DIR__ . '/../header.php';
?>
		
		<!-- BINGOCARD_ITEM_VIEW -->
		
		<p hidden id="nav-current-page" name="bingo-nav-sportsclubs"></p>
		<section class="container mt-5 mb-5" id="table-container">
			<section class="row justify-content-md-center">
				<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text">Sportclubs</h2>
				
				<!-- tabel (php forms hier gebruikt)-->
				
				<section class="table-responsive mb-5">
				  <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
					<thead class="bingo-table-header-row">
					  <tr>
						<th>Id</th>
						<th>Clubnaam</th>
						<th>Omschrijving</th>
						<th>Oprichtingsdatum</th>
						<th>Aantal leden</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					<?php
						//$_SESSION['sportsclub_id'] = "8F8BDDCF-D8FB-4FAB-B305-B82D149569AD";
					?>
					  <tr>
					  	<form name="alter-sportsclub-form" action="/sportsclub/alter/" method="POST">
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" name="bingocard-id" id="table-bingocard-item-id"><?php //echo $_SESSION['sportsclub_id']; ?> 8F8BDDCF-D8FB-4FAB-B305-B82D149569AD</textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-clubname-column">IJsclub voor Haarlem en omstreken</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-club-description-column">De IJsclub voor Haarlem en Omstreken is een schaatsvereniging in Haarlem-Noord. Deze club organiseert schaatstrainingen, wedstrijden, marathons en meer van September tot Maart van elk jaar.</textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns">1869-01-22 00:00:00</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns">3500</textarea>
							</td>
							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php //echo $_SESSION['sportsclub_id']; ?>">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php //echo $_SESSION['sportsclub_id']; ?>" name="verwijderen">Verwijderen</button>
							</td>
						</form>
					  </tr>
					  
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row">
					  	<form name="create-sportsclub-form" action="/sportsclub/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe sportclub:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Naam van mijn sportclub" name="sportsclub-clubname"></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Omschrijving van mijn eigen sportclub" name="sportsclub-description"></textarea>
							</td>
							<td>
								<input type="date" value="1970-01-01" name="sportsclub-foundedOn">
								<!--<textarea class="bingo-table-columns" placeholder="" name="sportsclub-foundedOn"></textarea>-->
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="1000" name="sportsclub-membersAmount"></textarea>
							</td>
							<td>
								<button type="submit" class="btn btn-success bingo-table-add-button" id="nieuwe-gebruiker-btn">Voeg toe</button>
							</td>
						</form>
					  </tr>
					</tbody>
				  </table>
				</section>
				
			</section>
			
		</section>
		
<?php
	include_once __DIR__ . '/../footer.php';
?>