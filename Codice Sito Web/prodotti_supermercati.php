<!doctype html>
<html>

<?php 
if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
	location.href = 'index.php';
	</script>";                          //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}

$DBhost = "localhost";
$DBName = "my_easybuy20";                                                            //Apro la connessione al DB
mysql_connect($DBhost) or die("Impossibile collegarsi al server");
mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Prodotti Supermercati - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">       
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body>

	<div class="wrapper">

		<div class="sticky">           
			<div class="stickydiv">
				<a href="supermercati.php" style="float:left;" class="sticky-right">
					<img src="img/indietro.png" style="float:left;" class="sticky-right">      
				</a>
			</div>
			<div class="stickydiv">
				<center>
					<a href="home.php" class="sticky-centro">                            
						<img src="img/home.png" class="sticky-centro">                   
					</a>
				</center>
			</div>
			<div class="stickydiv">
				<a href="profilo.php" class="sticky-right">
					<img src="img/profilo.png" class="sticky-right">                  
				</a>
			</div>
		</div>

		<div class="email">
			<h1 class='bold'>Prodotti del supermercato</h1>            
		</div>

		<?php
		if (isset($_GET['visualizza_prod_super'])) {
			$piva = $_GET['visualizza_prod_super'];            //Recupero la partita iva dalla richiesta GET che mi ha rimandato a questa pagina
		}

		if (isset($_POST['categorie'])) {
			$categoria = $_POST['categorie'];
		} else {                                              //Se è stata scelta una categoria la recupero dalla richiesta POST, la lascio vuota diversamente
			$categoria = "";
		}

		$sqlquery = "SELECT DISTINCT Categoria FROM PRODOTTO p,SUPERMERCATO_PRODOTTO sp WHERE p.Ean = sp.Ean AND sp.Piva = '$piva' AND Categoria = '$categoria' 
	                 UNION 
					 SELECT DISTINCT Categoria FROM PRODOTTO p, SUPERMERCATO_PRODOTTO sp WHERE p.Ean = sp.Ean AND sp.Piva = '$piva' AND Categoria != '$categoria' ";   //Query la quale prima riga è sempre la categoria precedentemente selezionata

		$result = mysql_query($sqlquery);                          //Eseguo la query
		$number = mysql_num_rows($result);                         //Conto le righe 

		if ($number < 1) {
			echo "<div class='scegli'>
									<div class='scelta'>
										<fieldset>
											<center>
												<legend>
													<h2 class='bold'>Filtra per categoria:</h2>
												</legend>
												<br>
												<h2 style='color:red;'>Non ci sono categorie!</h2>
											</center>
										</fieldset>
									</div>
										<div class='opzioni_cat'>
												<div class='opzione'>
													<input type='submit' value='Mostra' class='logreg' disabled style='background-color:#aaa;'>
												</div>
										</div>
								</div>";                             //Stampo il messaggio di errore che non ci sono categorie 
		} else {
			$categoria = mysql_result($result, 0, "Categoria");
			echo "<div class='scegli'>
									<form method='post' action='#'>
										<input type='text' name='categoria' value='$categoria' style='display:none;'>
										<div class='scelta'>
											<fieldset>
												<center>
													<legend>
														<h2 class='bold'>Filtra per categoria:</h2>
													</legend>
													<br>
													<select name='categorie' class='tendina'>
														<option value='$categoria' selected='selected'>$categoria</option>";
			$i = 1;
			while ($number > $i) {
				$categoria = mysql_result($result, $i, "Categoria");
				echo "<option value='$categoria'>$categoria </option>";         //Stampo le varie categorie nel menù a tendina
				$i++;
			}
			echo "					</select>
												</center>
											</fieldset>
										</div>
										<div class='opzioni_cat'>
												<div class='opzione'>
													<input name='mostra' type='submit' value='Mostra' class='logreg'>
													<input type='text' name='categoria' value='$categoria' style='display:none;'>
													
												</div>	
										</div>
									 </form>
								</div>"; //Stampo il codice HTML per menù a tendina e bottoni
		}




		if ($_POST) {
			if (isset($_POST['mostra'])) {
				$categoria = $_POST['categorie'];
				$sqlquery = "SELECT p.Ean, Nome, Descrizione, Marchio, Immagine FROM PRODOTTO p, SUPERMERCATO_PRODOTTO sp WHERE p.Ean=sp.Ean AND Categoria='$categoria' AND sp.Piva='$piva'";
				$result = mysql_query($sqlquery);
				$number = mysql_num_rows($result);
				if ($number < 1) {
					echo '<div class="prodotti">
									<div class="prodlist">
										<h2 style="color:red;">Nessun prodotto di questa categoria</h2>
									</div>
								</div>';
				} else {
					$i = 0;
					echo "<div class='prodotti'>";


					while ($number > $i) {
						$ean = mysql_result($result, $i, "Ean");
						$nome = mysql_result($result, $i, "Nome");
						$descr = mysql_result($result, $i, "Descrizione");
						$marc = mysql_result($result, $i, "Marchio");
						$imm = mysql_result($result, $i, "Immagine");
						echo "<div class='prodlist'>
									<div class='immlist'>
										<img src='prodotto/$imm'
											 class='foto'>
										</div>
										<div class='datilist'>
											<div class='nome'>
												<h2 class='bold'>$nome</h2>
											</div>
											<div class='mar-cat'>
												<h2 class='bold'>$marc </h2>
											</div>
											<div class='descrizione'>
												<h2>$descr</h2>
											</div>
										</div>
										
										<div class='elimina'>
										<form method='get' action='sceglilista.php'>	
											<button value='$ean'name='ean'
													type='submit'
													class='cerca'>
												<img src='img/buttliste.png'
													 class='imgricerca'>
																							</button>
																							</form></div>
											
											
										
											<div class='elimina'>
											<form method='get' action='confronta.php'>
											<button value='$ean'name='ean'
													type='submit'
													class='cerca'>
												<img src='img/buttcarrelli.png'
													 class='imgricerca'>
																							</button>
											
											</form>												</div>
											
											</div>";
						$i++;
					}

					echo "</form>
								</div>
								
								";
				}
			}
		}






		?>


	</div>

	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>
<?php
@mysqli_free_result($result);

@mysqli_close($conn); ?>

</html>