<?php
    include_once __DIR__ . '/../header.php';
?>
		<!-- USER_VIEW -->
		
		<p hidden id="nav-current-page" name="bingo-nav-users"></p>

		<section class="container mt-5 mb-5" id="table-container">
			<section class="row justify-content-md-center">				
				<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text">Gebruikers</h2>

				<section class="table-responsive mb-5">
				  <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0">
					<thead class="bingo-table-header-row">
					  <tr>
						<th>Id</th>
						<th>Gebruikersnaam</th>
						<th>Email adres</th>
						<th>Beheerder?</th>
						<th>Premium?</th>
						<th>Aantal bingokaarten</th>
						<th>Aantal gedeelde bingokaarten</th>
						<th>Bingokaarten</th>
						<th>Sportclubs</th>
						<th></th>
					  </tr>
					</thead>
					<tbody>
					<?php
					    foreach($models as $user)
                        {
					?>
					  <tr>
						<form name="alter-user-form" action="/user/alter/" method="POST">
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" name="user-id" id="table-user-id"><?php echo $user->getId(); ?></textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="user-username"><?php echo $user->getUsername(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-email-column" name="user-email"><?php echo $user->getEmail(); ?></textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns" name="user-isAdmin"><?php if($user->getIsAdmin()){echo "Ja"; } else {echo "Nee"; }; ?></textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns" name="user-isPremium"><?php if($user->getIsPremium()){echo "Ja"; } else {echo "Nee"; }; ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="user-cardsAmount"><?php echo $user->getCardsAmount(); ?></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" name="user-sharedCardsAmount"><?php echo $user->getSharedCardsAmount(); ?></textarea>
							</td>
							<td>
								<button type="button" class="btn btn-primary bingo-table-buttons" id="bingokaarten-btn" value="<?php echo $user->getId(); ?>" onclick="showSubtableSection(this.value, 'bingocard')">Toon bingokaarten</button>
							</td>
							<td>
								<button type="button" class="btn btn-primary bingo-table-buttons" id="sportclubs-btn" value="<?php echo $user->getId(); ?>" onclick="showSubtableSection(this.value, 'sportsclub')">Toon sportclubs</button>
							</td>
							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" name="verwijderen" value="<?php echo $user->getId(); ?>" onclick="return confirm(`Weet u zeker dat u deze gebruiker met id ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
						</form>
					  </tr>
					<?php
					    }
					?>
					  <tr class="bingo-table-bottom-row"> 
						<form name="create-user-form" action="/user/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe gebruiker:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="John Doe" name="nieuwe-user-username"></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="JohnDoe@hotmail.com" name="nieuwe-user-email"></textarea>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text">Nee</h6>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text">Nee</h6>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text">0</h6>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text">0</h6>
							</td>
							<td>
								<h6 class="bingo-nieuw-header-text">nieuw wachtwoord:</h6>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="WelkomBingo123!" name="nieuwe-user-password"></textarea>
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
			
			<!-- Bingokaarten van gebruiker -->
			
			<section class="row justify-content-md-center" id="bingocards-table-section">
				<section class="container bingo-subtable-text">
					<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text" id="bingocards-table-title-text">Bingokaarten voor gebruiker: </h2>
					<h2 class="text-center mb-4 mt-4 mr-4 website-logo-text table-title-text" id="bingocards-table-title-id-text"></h2>
				</section>
				
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
					<tbody id="bingocard-subtable-body">
					  <tr class="bingocard-subtable-rows">
						<td>
						  <section class="align-items-center">
							<textarea class="bingo-table-columns bingo-id-column table-bingocard-id"></textarea>
						  </section>
						</td>
                        <td>
                            <section class="align-items-center">
                                <textarea class="bingo-table-columns bingo-id-column table-bingocard-userId"></textarea>
                            </section>
                        </td>
						<td>
							<textarea class="bingo-table-columns table-bingocard-score"></textarea>
						</td>
						<td>
							<textarea class="bingo-table-columns table-bingocard-size"></textarea>
						</td>
						<td>
						  <textarea class="bingo-table-columns table-bingocard-creationDate"></textarea>
						</td>
						<td>
							<textarea class="bingo-table-columns table-bingocard-lastAccessedOn"></textarea>
						</td>
						<td>
							<button type="button" class="btn btn-primary bingo-table-buttons table-bingocard-cardItems-button" onclick="showSubtableSection(this.value, 'carditem')">Toon bingokaart-items</button>
						</td>
						<td>
							<button type="button" class="btn btn-warning bingo-table-buttons table-bingocard-edit-button" name="wijzigen" onclick="editBingocard(this.value)">Wijzigen</button>
							<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons table-bingocard-remove-button" name="verwijderen" onclick="if(confirm(`Weet u zeker dat u bingokaart ${this.value} wilt verwijderen?`)){deleteBingocard(this.value)};">Verwijderen</button>
						</td>
					  </tr>
					  
					  <tr class="bingocard-table-bottom-row">
						<td>
                            <h6 class="bingo-nieuw-header-text"><b>Nieuwe bingokaart:</b></h6>
                        </td>
                        <td>
                            <textarea class="bingo-table-columns new-bingocard-user-id" name="new-bingocard-userId"></textarea>
                        </td>
						<td>
							<h6 class="bingo-nieuw-header-text">0</h6>
						</td>
						<td>
							<select name="new-bingocard-sizes">
								<option name="drie_bij_drie" value="9" selected>3x3</option>
								<option name="vier_bij_vier" value="16">4x4</option>
								<option name="vijf_bij_vijf" value="25">5x5</option>
							</select>
						</td>
						<td>
							<h6 class="bingo-nieuw-header-text"><?php echo date("Y-m-d H:i:s"); ?></h6>
						</td>
						<td>
							<h6 class="bingo-nieuw-header-text"><?php echo date("Y-m-d H:i:s"); ?></h6>
						</td>
						<td>
							<h6 class="bingo-nieuw-header-text">0</h6>
						</td>
						<td>
							<button type="button" class="btn btn-success bingo-table-add-button" onclick="createNewBingocard()">Voeg toe</button>
						</td>
					  </tr>
					</tbody>
				  </table>
				</section>
				
			</section>
				

			<!-- Bingokaart items van kaarten van een specifieke gebruiker -->
				
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
			
			<!-- Sportclubs van de gebruiker -->
			
			<section class="row justify-content-md-center" id="sportsclubs-table-section">	
				<section class="container bingo-subtable-text">
					<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text" id="sportsclubs-table-title-text">Sportclubs van gebruiker: </h2>
					<h2 class="text-center mb-4 mt-4 mr-4 website-logo-text table-title-text" id="sportsclubs-table-title-id-text"></h2>
				</section>

                <!-- tabel -->
				
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
					<tbody id="sportsclub-subtable-body">
					  <tr class="sportsclub-subtable-rows">
						<td>
						  <section class="align-items-center">
							<textarea class="bingo-table-columns bingo-id-column table-sportsclub-id"></textarea>
						  </section>
						</td>
						<td>
							<textarea class="bingo-table-columns bingo-clubname-column table-sportsclub-clubname"></textarea>
						</td>
						<td>
							<textarea class="bingo-table-columns bingo-club-description-column table-sportsclub-description"></textarea>
						</td>
						<td>
						  <textarea class="bingo-table-columns table-sportsclub-foundedOn"></textarea>
						</td>
						<td>
							<textarea class="bingo-table-columns table-sportsclub-membersAmount"></textarea>
						</td>
						<td>
							<button type="button" class="btn btn-warning bingo-table-buttons table-sportsclub-edit-button" name="wijzigen" onclick="editSportsclub(this.value)">Wijzigen</button>
							<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons table-sportsclub-remove-button" name="verwijderen" onclick="if (confirm(`Weet u zeker dat u de sportclub ${this.value} van deze gebruiker wilt verwijderen?`)){deleteUserSportsclub(this.value);}">Verwijderen</button>
						</td>
					  </tr>
					  
					  <tr class="sportsclub-table-bottom-row">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe sportclub:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Naam van mijn sportclub" name="new-sportsclub-clubname"></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Omschrijving van mijn eigen sportclub" name="new-sportsclub-description"></textarea>
							</td>
							<td>
								<input type="date" value="1970-01-01" name="new-sportsclub-foundedOn">
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="1000" name="new-sportsclub-membersAmount"></textarea>
							</td>
							<td>
								<button type="button" class="btn btn-success bingo-table-add-button" onclick="createUserSportsclub()">Voeg toe</button>
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