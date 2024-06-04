<?php
    include_once __DIR__ . '/../header.php';
?>
		
		<!-- BINGOCARD_ITEM_VIEW -->
		
		<p hidden id="nav-current-page" name="bingo-nav-carditems"></p>
		<section class="container mt-5 mb-5" id="table-container">
			<section class="row justify-content-md-center">				
				<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text">Bingokaart-items</h2>
		
				<!-- tabel (php forms hier gebruikt)-->
				
				<section class="table-responsive mb-5">
				  <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
					<thead class="bingo-table-header-row">
					  <tr>
						<th>Id</th>
						<th>Inhoud</th>
						<th>Categorie</th>
						<th>Punten</th>
						<th>Premium Item?</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					<?php
					//foreach($cardItems as $cardItem) {
					?>
					  <tr>
					  	<form name="alter-carditem-form" action="/carditem/alter/" method="POST">
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" name="bingocard-id" id="table-bingocard-item-id"><?php //echo $cardItem->getId(); ?>108F4D89-0D1D-4B99-93A9-F2532492ADC0</textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-content-column"><?php //echo $cardItem->getContent(); ?>Het juiste meetinstrument vergeten om nu eindelijk eens die 90 graden kniehoeken goed te kunnen opmeten (verdorie)</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns"><?php //echo $cardItem->getCategory(); //js function schrijven met switch voor case = bepaalde string teruggeven (besloten om geen enum te gebruiken I guess) ?> 2</textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns"><?php //echo $cardItem->getPoints(); ?>15</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns"><?php //echo $cardItem->getIsPremiumItem(); //ook hier js functie voor weergeven 'Ja' of 'Nee' voor boolean waarden die hier worden teruggegeven ?>Nee</textarea>
							</td>
							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php //echo $cardItem->getId(); ?>">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php //echo $cardItem->getId(); ?>" name="verwijderen">Verwijderen</button>
							</td>
						</form>
					  </tr>
					  
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row">
					  	<form name="create-carditem-form" action="/carditem/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuw bingokaart-item:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Iets leuks, grappigs of opmerkelijks gerelateerd aan sport wat op een bingokaart kan worden gezet" name="bingocard-item-content"></textarea>
							</td>
							<td>
								<select name="bingocard-content-categories">
									<option name="category_0" selected>standaard tekst</option>
									<option name="category_1">speciaal font of effect</option>
									<option name="category_2">afbeelding</option>
									<option name="category_3">geluidseffect</option>
									<option name="category_4">video</option>
									<option name="category_5">animatie</option>
								</select>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="10" name="bingocard-item-points"></textarea>
							</td>
							<td>
								<select name="premium-bingocard-items">
									<option name="true">Ja</option>
									<option name="false" selected>Nee</option>
								</select>
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