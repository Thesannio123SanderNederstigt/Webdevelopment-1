<?php
    include_once __DIR__ . '/../header.php';
?>
		<!-- BINGOCARD_VIEW -->

		<p hidden id="nav-current-page" name="bingo-nav-bingocards"></p>
        
		<section class="container mt-5 mb-5" id="table-container">
			<section class="row justify-content-md-center">				
				<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text">Bingokaarten</h2>

				<!-- tabel -->

				<section class="table-responsive mb-5">
				  <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
					<thead class="bingo-table-header-row">
					  <tr>
						<th>Id</th>
                        <th>Gebruikers Id</th>
						<th>Score</th>
						<th>Formaat</th>
						<th>Aanmaakdatum</th>
						<th>Laatst bekeken</th>
						<th>Kaart-items</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					<?php
					    foreach($models as $bingocard)
                        {
					?>
					  <tr>
						<form name="alter-bingocard-form" action="/bingocard/alter/" method="POST">
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" name="bingocard-id" id="table-bingocard-id"><?php echo $bingocard->getId(); ?></textarea>
							  </section>
							</td>
                            <td>
                                <section class="align-items-center">
                                    <textarea class="bingo-table-columns bingo-id-column" name="bingocard-userId" id="table-bingocard-userId"><?php echo $bingocard->getUserId(); ?></textarea>
                                </section>
                            </td>
							<td>
								<textarea class="bingo-table-columns" name="bingocard-score"><?php echo $bingocard->getScore(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="bingocard-size"><?php switch($bingocard->getSize()){case(9): echo "3x3"; break; case(16): echo "4x4"; break; case(25): echo "5x5"; break;};?></textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns" name="bingocard-creationDate"><?php echo $bingocard->getCreationDate(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="bingocard-lastAccessedOn"><?php echo $bingocard->GetLastAccessedOn(); ?></textarea>
							</td>
							<td>
								<button type="button" class="btn btn-primary bingo-table-buttons" id="bingokaarten-btn" value="<?php echo $bingocard->getId(); ?>" onclick="showSubtableSection(this.value, 'carditem')">Toon bingokaart-items</button>
							</td>

							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $bingocard->getId(); ?>">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" name="verwijderen" value="<?php echo $bingocard->getId(); ?>" onclick="return confirm(`Weet u zeker dat u deze bingokaart met id ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
						</form>
					  </tr>
					  
					<?php
					    }
					?>
					  <tr class="bingo-table-bottom-row">
						<form name="create-bingocard-form" action="/bingocard/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe bingokaart:</b></h6></td>
                            <td>
                                <textarea class="bingo-table-columns" placeholder="<?php if(isset($_SESSION['user'])){ echo $_SESSION['user']['id'];}?>" name="nieuwe-bingocard-userId"></textarea>
                            </td>
							<td>
								<h6 class="bingo-nieuw-header-text">0</h6>
							</td>
							<td>
								<select name="nieuwe-bingocard-size">
									<option name="drie_bij_drie" selected>3x3</option>
									<option name="vier_bij_vier">4x4</option>
									<option name="vijf_bij_vijf">5x5</option>
								</select>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text"><?php echo date("Y-m-d H:i:s"); ?></h6>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text"><?php echo date("Y-m-d H:i:s"); ?></h6>
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
		
			<!-- Bingokaart items van kaarten van een specifieke bingokaart -->
				
			<section class="row justify-content-md-center" id="carditems-table-section">
				<section class="container bingo-subtable-text">			
					<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text" id="carditems-table-title-text">Kaart-items van bingokaart: </h2>
					<h2 class="text-center mb-4 mt-4 mr-4 website-logo-text table-title-text" id="carditems-table-title-id-text"></h2>
				</section>
				
				<!-- tabel -->
				
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
					<tbody id="bingocard-item-subtable-body">
					    <tr class="bingocard-item-subtable-rows">
					        <td>
					    	  <section class="align-items-center">
					    		<textarea class="bingo-table-columns bingo-id-column table-bingocard-item-id"></textarea>
					    	  </section>
					    	</td>
					    	<td>
					    		<textarea class="bingo-table-columns bingo-content-column table-bingocard-item-content"></textarea>
					    	</td>
					    	<td>
					    		<textarea class="bingo-table-columns table-bingocard-item-category"></textarea>
					    	</td>
					    	<td>
					    	  <textarea class="bingo-table-columns table-bingocard-item-points"></textarea>
					    	</td>
					    	<td>
					    		<textarea class="bingo-table-columns table-bingocard-item-isPremiumItem"></textarea>
					    	</td>
					    	<td>
					    		<button type="button" class="btn btn-warning bingo-table-buttons table-bingocard-item-edit-button" name="wijzigen" onclick="editBingocardItem(this.value)">Wijzigen</button>
					    		<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons table-bingocard-item-remove-button" name="verwijderen" onclick="if(confirm(`Weet u zeker dat u bingokaart-item ${this.value} van deze bingokaart wilt verwijderen?`)){deleteBingocardItem(this.value);}">Verwijderen</button>
					        </td>
					    </tr>
					  
					    <tr class="bingocard-item-table-bottom-row">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuw bingokaart-item:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Iets leuks, grappigs of opmerkelijks gerelateerd aan sport wat op een bingokaart kan worden gezet" name="new-bingocard-item-content"></textarea>
							</td>
							<td>
								<select name="new-bingocard-item-content-categories" id="new-bingocard-item-content-select">
									<option name="category_0" value="0" selected>standaard tekst</option>
									<option name="category_1" value="1">speciaal font of effect</option>
									<option name="category_2" value="2">afbeelding</option>
									<option name="category_3" value="3">geluidseffect</option>
									<option name="category_4" value="4">video</option>
									<option name="category_5" value="5">animatie</option>
								</select>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="10" name="new-bingocard-item-points"></textarea>
							</td>
							<td>
								<select name="new-premium-bingocard-items" id="new-bingocard-item-premium-select">
									<option name="true" value="1">Ja</option>
									<option name="false" value="0" selected>Nee</option>
								</select>
							</td>
							<td>
								<button type="button" class="btn btn-success bingo-table-add-button" onclick="createBingocardItem()">Voeg toe</button>
							</td>
					    </tr>
				    </tbody>
				  </table>
				</section>
				
			</section>

		</section>

<?php
	include_once __DIR__ . '/../footer.php';
?>