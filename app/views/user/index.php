<?php
    include_once __DIR__ . '/../header.php';
?>
		
		<!-- USER_VIEW -->
		
		<p hidden id="nav-current-page" name="bingo-nav-users"></p>
		<section class="container mt-5 mb-5" id="table-container">
			<section class="row justify-content-md-center">				
				<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text">Gebruikers</h2>

				<section class="table-responsive mb-5">
				  <table class="table table-borderless bsb-table-xl text-nowrap align-middle m-0"> <!-- style? border: 1px solid black !important; border-radius: 2em !important; -->
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
					//$_SESSION['user_id'] = "CF3FA866-72A4-476A-9935-7B69AB7DA056";
					//$_SESSION['sportsclub_id'] = "8F8BDDCF-D8FB-4FAB-B305-B82D149569AD";
					//foreach($users as $user) {
					?>
					  <tr> <!--<tr value="<php echo $user->getId();>">-->
						<form name="alter-user-form" action="/user/alter/" method="POST"> <!-- in alter: if ISSET $_POST["wijzigen"] of $_POST["verwijderen"] op pagina's zonder subcategorien dit gewoon met javascript doen, is veel beter namelijk!-->
							<td>
							  <section class="align-items-center"> <!-- d-flex -->
								<textarea class="bingo-table-columns bingo-id-column" name="user-id" id="table-user-id">2D2DF76D-2F3C-4BA0-A3DF-9730D7A8F909</textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns">SanderN</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-email-column">sandernederstigt@gmail.com</textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns">Ja</textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns">Ja</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns">1</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns">0</textarea>
							</td>
							<td>
								<button type="button" class="btn btn-primary bingo-table-buttons" id="bingokaarten-btn" value="<?php echo $_SESSION['user_id']; ?>" onclick="showSubtableSection(this.value, 'bingocard')">Toon bingokaarten</button>
							</td>
							<td>
								<button type="button" class="btn btn-primary bingo-table-buttons" id="sportclubs-btn" value="<?php echo $_SESSION['user_id']?>" onclick="showSubtableSection(this.value, 'sportsclub')">Toon sportclubs</button>
							</td>
							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen">Wijzigen</button><!--bewerken met value="$user->getId();" want dan in de alter function van controller: $_POST["wijzigen"] heeft de waarde van de desbetreffende user id!-->
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php echo $_SESSION['user_id']; ?>" name="verwijderen" onclick="return confirm(`Weet u zeker dat u gebruiker ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
						</form>
					  </tr>
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row"> 
						<form name="create-user-form" action="/user/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe gebruiker:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="John Doe" name="username"></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="JohnDoe@hotmail.com" name="email"></textarea>
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
								<textarea class="bingo-table-columns" placeholder="WelkomBing0123" name="password"></textarea>
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
			
			<!-- Bingokaarten van gebruiker (wederom, JS want sub-tabel en ook zorgen bij aanmaak van nieuwe kaart, dat dit gebeurd voor deze gebruiker!) -->
			
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
					$_SESSION['bingocard_id'] = "212A4C3D-AC4B-4BA4-AC05-F68F4452AC84";
					//VOOR SUB-TABELLEN GAAN WE LOOPEN IN JAVASCRIPT DUS GEEN PHP ARRAYS OF FORMS IN DE TABEL HIER (WANT OOK NAAR API VERSTUREN!!!! NIET DIRECT NAAR DE NORMALE CONTROLLERS?
					?>
					  <tr>
						<td>
						  <section class="align-items-center">
							<textarea class="bingo-table-columns bingo-id-column" name="bingocard-id" id="table-bingocard-id">212A4C3D-AC4B-4BA4-AC05-F68F4452AC84</textarea>
						  </section>
						</td>
						<td>
							<textarea class="bingo-table-columns">0</textarea>
						</td>
						<td>
							<textarea class="bingo-table-columns">25</textarea>
						</td>
						<td>
						  <textarea class="bingo-table-columns">2024-04-15 18:40:07</textarea>
						</td>
						<td>
							<textarea class="bingo-table-columns">2024-04-15 18:40:07</textarea>
						</td>
						<td>
							<button type="button" class="btn btn-primary bingo-table-buttons" id="bingokaarten-btn" value="<?php echo $_SESSION['bingocard_id']; ?>" onclick="showSubtableSection(this.value, 'carditem')">Toon bingokaart-items</button>
						</td>
						<td>
							<button type="button" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $_SESSION['bingocard_id']; ?>" onclick="">Wijzigen</button>
							<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php echo $_SESSION['bingocard_id']; ?>" name="verwijderen" onclick="return confirm(`Weet u zeker dat u bingokaart ${this.value} wilt verwijderen?`);">Verwijderen</button>
						</td>
					  </tr>

					  
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row">
						<td>
                            <h6 class="bingo-nieuw-header-text"><b>Nieuwe bingokaart:</b></h6>
                        </td>
						<td>
							<h6 class="bingo-nieuw-header-text">0</h6>
						</td>
						<td>
							<select name="bingocard-sizes">
								<option name="drie_bij_drie" selected>9</option>
								<option name="vier_bij_vier">16</option>
								<option name="vijf_bij_vijf">25</option>
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
							<button type="button" class="btn btn-success bingo-table-add-button" id="nieuwe-gebruiker-btn" onclick="">Voeg toe</button>
						</td>
					  </tr>
					</tbody>
				  </table>
				</section>
				
				
			</section>
				
			<!-- Bingokaart items van kaarten van een specifieke gebruiker (subtabel, dus Javascript shenanigans met call naar api controller endpoint wat dit item niet alleen nieuw aanmaakt, maar ook toevoegd aan deze bingokaart van de gebruiker!!!-->
				
			<section class="row justify-content-md-center" id="carditems-table-section">
				<section class="container bingo-subtable-text">			
					<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text" id="carditems-table-title-text">Kaart-items van bingokaart: </h2>
					<h2 class="text-center mb-4 mt-4 mr-4 website-logo-text table-title-text" id="carditems-table-title-id-text"></h2>
				</section>
				
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
					$_SESSION['bingocard-item_id'] = "108F4D89-0D1D-4B99-93A9-F2532492ADC0";
					//
					?>
					  <tr>
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" name="bingocard-id" id="table-bingocard-item-id"><?php echo $_SESSION['bingocard-item_id']; ?></textarea>
							  </section>
							</td>
							<td>
								<textarea class="bingo-table-columns bingo-content-column">Het juiste meetinstrument vergeten om nu eindelijk eens die 90 graden kniehoeken goed te kunnen opmeten (verdorie)</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns">2</textarea>
							</td>
							<td>
							  <textarea class="bingo-table-columns">15</textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns">Nee</textarea>
							</td>
							<td>
								<button type="button" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $_SESSION['bingocard-item_id']; ?>" onclick="">Wijzigen</button>
								<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php echo $_SESSION['bingocard-item_id']; ?>" name="verwijderen" onclick="return confirm(`Weet u zeker dat u bingokaart-item ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
					  </tr>
					  
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row">
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
								<button type="button" class="btn btn-success bingo-table-add-button" id="nieuwe-gebruiker-btn">Voeg toe</button>
							</td>
					  </tr>
					</tbody>
				  </table>
				</section>
				
			</section>
			
			<!-- Sportclubs van de gebruiker! -->
			
			<!--(deze subtabel doet via javascript functions calls (apart voor invullen innertext of values van td elements binnen table-row met specifieke id 
			en elementen met specifieke namen naar de api voor ophalen, updaten, verwijderen en toevoegen, in hoofd/eigen pagina hoofdtabel = weer php via forms doen! -->
			
			<!-- ALSO SEE REGEL 40 HIERBOVEN VOOR BEGIN VAN HET STOPPEN/PLAATSEN VAN ID'S IN TABLE ROW ELEMENTS? 
			(OF WAAR IK DIT DAN HET BESTE GEBRUIK VAN KAN MAKEN VOOR DE JAVAVSCRIPT FUNCTIES STRAKS NADAT DE ANDERE PAGINA'S ZIJN UITGEWERKT -->
			
			<section class="row justify-content-md-center" id="sportsclubs-table-section">	
				<section class="container bingo-subtable-text">
					<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text" id="sportsclubs-table-title-text">Sportclubs van gebruiker: </h2>
					<h2 class="text-center mb-4 mt-4 mr-4 website-logo-text table-title-text" id="sportsclubs-table-title-id-text"></h2>
				</section>
				
				
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
						$_SESSION['sportsclub_id'] = "8F8BDDCF-D8FB-4FAB-B305-B82D149569AD";
					?>
					  <tr>
							<td>
							  <section class="align-items-center">
								<textarea class="bingo-table-columns bingo-id-column" name="bingocard-id" id="table-bingocard-item-id"><?php echo $_SESSION['sportsclub_id']; ?></textarea>
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
								<button type="button" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $_SESSION['sportsclub_id']; ?>" onclick="">Wijzigen</button>
								<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php echo $_SESSION['sportsclub_id']; ?>" name="verwijderen" onclick="return confirm(`Weet u zeker dat u de sportclub ${this.value} wilt verwijderen?`);">Verwijderen</button>
							</td>
					  </tr>
					  
					  
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe sportclub:</b></h6></td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Naam van mijn sportclub" name="sportsclub-clubname"></textarea>
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="Omschrijving van mijn eigen sportclub" name="sportsclub-description"></textarea>
							</td>
							<td>
								<input type="date" value="1970-01-01" name="sportsclub-foundedOn">
							</td>
							<td>
								<textarea class="bingo-table-columns" placeholder="1000" name="sportsclub-membersAmount"></textarea>
							</td>
							<td>
								<button type="button" class="btn btn-success bingo-table-add-button" id="nieuwe-gebruiker-btn">Voeg toe</button>
							</td>
					  </tr>
					</tbody>
				  </table>
				</section>
				
			</section>
			
		</section>
		
		<script>
			/*function showUserBingocards(user_id)
			{				
				var bingocards_table_section = document.getElementById("bingocards-table-section");
				bingocards_table_section.style.cssText = 'display: flex !important';

				
				var bingocards_title_id_text = document.getElementById("bingocards-table-title-id-text");
				bingocards_title_id_text.innerText = user_id;
				bingocards_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
			}
			
			function showBingocardItems(bingocard_id)
			{
				var cardditems_table_section = document.getElementById("carditems-table-section");
				cardditems_table_section.style.cssText = 'display: flex !important';

				var carditems_title_id_text = document.getElementById("carditems-table-title-id-text");
				carditems_title_id_text.innerText = bingocard_id;
				carditems_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
			}
			
			function showUserSportsclubs(sportsclub_id)
			{
				var sportsclub_table_section = document.getElementById("sportsclubs-table-section");
				sportsclub_table_section.style.cssText = 'display: flex !important';

				var sportsclub_title_id_text = document.getElementById("sportsclubs-table-title-id-text");
				sportsclub_title_id_text.innerText = sportsclub_id;
				sportsclub_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
			}*/

            function showSubtableSection(item_id, item_name)
			{
                var item_table_section;
                var item_title_id_text;

				switch(item_name)
                {
                    case item_name === "bingocard":
                        item_table_section = document.getElementById("bingocards-table-section");
                        item_title_id_text = document.getElementById("bingocards-table-title-id-text");

                        /*getUserBingocards(item_id);
                        return;*/

                    case item_name === "carditem":
                        item_table_section = document.getElementById("carditems-table-section");
                        item_title_id_text = document.getElementById("carditems-table-title-id-text");
                        
                        /*getBingocardItems(item_id);
                        return;*/

                    case item_name === "sportsclub":
                        item_table_section = document.getElementById("sportsclubs-table-section");
                        item_title_id_text = document.getElementById("sportsclubs-table-title-id-text");

                        /*getUserSportsclubs(item_id);
                        return;*/
                }

                item_title_id_text.innerText = item_id;
                item_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';

                item_table_section.style.cssText = 'display: flex !important';

			}
		</script>
		
<?php
	include_once __DIR__ . '/../footer.php';
?>