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
                        foreach($models as $sportsclub) 
                        {
					?>
					  <tr>
					  	<form name="alter-sportsclub-form" action="/sportsclub/alter/" method="POST">
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" id="table-bingocard-item-id" name="sportsclub-id"><?php echo $sportsclub->getId(); ?></textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-clubname-column" name="sportsclub-clubname"><?php echo $sportsclub->getClubname(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-club-description-column" name="sportsclub-description"><?php echo $sportsclub->getDescription(); ?></textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns" name="sportsclub-foundedOn"><?php echo $sportsclub->getFoundedOn(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="sportsclub-membersAmount"><?php echo $sportsclub->getMembersAmount(); ?></textarea>
							</td>
							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $sportsclub->getId(); ?>">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" name="verwijderen" value="<?php echo $sportsclub->getId(); ?>" onclick="return confirm(`Weet u zeker dat u deze sportclub met id ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
						</form>
					  </tr>
					  
					<?php
					    }
					?>
					  <tr class="bingo-table-bottom-row">
					  	<form name="create-sportsclub-form" action="/sportsclub/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe sportclub:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Naam van mijn sportclub" name="nieuwe-sportsclub-clubname"></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Omschrijving van mijn eigen sportclub" name="nieuwe-sportsclub-description"></textarea>
							</td>
							<td>
								<input type="date" value="1970-01-01" name="nieuwe-sportsclub-foundedOn">
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="1000" name="nieuwe-sportsclub-membersAmount"></textarea>
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