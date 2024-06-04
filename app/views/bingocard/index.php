<?php
    include_once __DIR__ . '/../header.php';
?>

		<!-- BINGOCARD_VIEW -->

		<p hidden id="nav-current-page" name="bingo-nav-bingocards"></p>
		<section class="container mt-5 mb-5" id="table-container">
			<section class="row justify-content-md-center">				
				<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text">Bingokaarten</h2>

				<!-- tabel (php forms met refresh in gedachten voor de hoofd-items van deze views)-->
				
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
					?>
					  <tr>
						<form name="alter-bingocard-form" action="/bingocard/alter/" method="POST">
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
								<button type="button" class="btn btn-primary bingo-table-buttons" id="bingokaarten-btn" value="<?php echo $_SESSION['bingocard_id']; ?>" onclick="showBingocardItems(this.value)">Toon bingokaart-items</button>
							</td>

							<td>
								<button type="submit" class="btn btn-warning bingo-table-buttons" name="wijzigen" value="<?php echo $_SESSION['bingocard_id']; ?>">Wijzigen</button>
								<button type="submit" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php echo $_SESSION['bingocard_id']; ?>" name="verwijderen">Verwijderen</button>
							</td>
						</form>
					  </tr>
					  
					<?php
					//}
					 ?>
					  <tr class="bingo-table-bottom-row">
						<form name="create-bingocard-form" action="/bingocard/create/" method="POST">
							<td><h6 class="bingo-nieuw-header-text"><b>Nieuwe bingokaart:</b></h6></td>
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
								<button type="submit" class="btn btn-success bingo-table-add-button" id="nieuwe-gebruiker-btn">Voeg toe</button>
							</td>
						</form>
					  </tr>
					</tbody>
				  </table>
				</section>
			
			</section>
		
			<!-- Bingokaart items van kaarten van een specifieke bingokaart (subtabel, dus Javascript shenanigans met call naar api controller endpoint, etc.) -->
				
			<section class="row justify-content-md-center" id="carditems-table-section">
				<section class="container bingo-subtable-text">			
					<h2 class="text-center mb-4 mt-4 website-logo-text table-title-text" id="carditems-table-title-text">Kaart-items van bingokaart: </h2>
					<h2 class="text-center mb-4 mt-4 mr-4 website-logo-text table-title-text" id="carditems-table-title-id-text"></h2>
				</section>
				
				<!-- tabel (js functie aanroepingen voor het sturen en ophalen van data naar en van api endpoints en weergegeven hier zonder refresh, net als op de sub-tabellen van de user pagina (voor bingokaarten, kaart-items en sportclubs daar))-->
				
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
								<button type="button" class="btn btn-danger bingo-danger-btn bingo-table-buttons" value="<?php echo $_SESSION['bingocard-item_id']; ?>" name="verwijderen" onclick="if(confirm(`Weet u zeker dat u bingokaart-item ${this.value} wilt verwijderen?`)){deleteBingocardItem(this.value);}">Verwijderen</button>
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
								<button type="button" class="btn btn-success bingo-table-add-button" id="nieuwe-gebruiker-btn" onclick="">Voeg toe</button>
							</td>
					  </tr>
					</tbody>
				  </table>
				</section>
				
			</section>


		</section>
		
		<script>
			function showBingocardItems(bingocard_id)
			{
				var cardditems_table_section = document.getElementById("carditems-table-section");
				cardditems_table_section.style.cssText = 'display: flex !important';

				var carditems_title_id_text = document.getElementById("carditems-table-title-id-text");
				carditems_title_id_text.innerText = bingocard_id;
				carditems_title_id_text.style.cssText = 'margin-left: 0.5rem !important; color: #2F5597 !important';
			}
			
			function deleteBingocardItem(bingocard_item_id)
			{
				alert(`hallo wereld: ${bingocard_item_id}`);
			}
		</script>

<?php
	include_once __DIR__ . '/../footer.php';
?>