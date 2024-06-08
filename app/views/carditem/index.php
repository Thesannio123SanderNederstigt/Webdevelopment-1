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
					    foreach($models as $cardItem)
                        {
					?>
					  <tr>
					  	<form name="alter-carditem-form" action="/carditem/alter/" method="POST">
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" id="table-bingocard-item-id" name="cardItem-id"><?php echo $cardItem->getId(); ?></textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-content-column" name="cardItem-content"><?php echo $cardItem->getContent(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="cardItem-category"><?php switch($cardItem->getCategory()){case(0): echo "standaard tekst"; break; case(1): echo "speciaal font of effect"; break; case(2): echo "afbeelding"; break; case(3): echo "geluidseffect"; break; case(4): echo "video"; break; case(5): echo "animatie"; break;};?></textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns" name="cardItem-points"><?php echo $cardItem->getPoints(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="cardItem-isPremiumItem"><?php if($cardItem->getIsPremiumItem()){echo "Ja"; } else {echo "Nee"; }; ?></textarea>
							</td>
							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $cardItem->getId(); ?>">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" name="verwijderen" value="<?php echo $cardItem->getId(); ?>" onclick="return confirm(`Weet u zeker dat u dit kaart-item met id ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
						</form>
					  </tr>
					  
					<?php
					    }
					?>
					  <tr class="bingo-table-bottom-row">
					  	<form name="create-carditem-form" action="/carditem/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuw bingokaart-item:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Iets leuks, grappigs of opmerkelijks gerelateerd aan sport wat op een bingokaart kan worden gezet" name="nieuwe-cardItem-content"></textarea>
							</td>
							<td>
								<select name="nieuwe-cardItem-content-categories">
									<option name="category_0" selected>standaard tekst</option>
									<option name="category_1">speciaal font of effect</option>
									<option name="category_2">afbeelding</option>
									<option name="category_3">geluidseffect</option>
									<option name="category_4">video</option>
									<option name="category_5">animatie</option>
								</select>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="10" name="nieuwe-cardItem-points"></textarea>
							</td>
							<td>
								<select name="nieuwe-cardItem-premium-items">
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