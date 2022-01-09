<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";           //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}

$DBhost = "localhost";
$DBName = "my_easybuy20";
mysql_connect($DBhost) or die("Impossibile collegarsi al server");                //Apro la connessione al DB
mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

if ($_GET) {       //Se viene eseguita una GET request vuol dire che sto eliminando un prodotto dalla lista
	$idlista = $_GET['lista'];
	$ean = $_GET['elimina'];                    //Recupero id della Lista e ean del prodotto
	$sqlquery = "DELETE FROM LISTA_PRODOTTI WHERE Id_lista='$idlista' AND Ean='$ean';";
	mysql_query($sqlquery);                                  //Eeguo la query per eliminare il prodotto
}

if ($_POST) {                  //Se viene eseguita una POST request vuol dire che ho premuto uno dei tasti
	if (isset($_POST['condividi'])) {
		$idlista = $_POST['liste'];
		setcookie("list", $idlista, time() + 900);
		header("location:condividilista.php");                 //Se premo condividi passo l'id Lista con un cookie e vado alla pagina condividilista.php
	}
	if (isset($_POST['crea'])) {
		header("location:crealista.php");           //Se premo crea vado alla pagina crealista.php
	}

	if (isset($_POST['elimina'])) {              //Se premo elimina
		$idlista = $_POST['liste'];
		$mail = $_COOKIE['u'];                   //Recupero email utente e id della Lista
		$sqlquery = "DELETE FROM LISTA_UTENTE WHERE Id_lista='$idlista' AND Email='$mail';";
		mysql_query($sqlquery);                     //La elimino dal DB
	}
} ?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Liste - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body>
	<div class="wrapper">
		<div class="sticky">
			<div class="stickydiv">
				<a href="home.php" style="float:left;" class="sticky-right">
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
		<?php
		$mail = $_COOKIE['u'];             //Recupero la mail dal cookie
		if (isset($_POST['liste'])) {
			$id = $_POST['liste'];              //Recupero l'id della lista che si vuole mostrare
		} else {
			if (isset($_GET['lista'])) {

				$id = $_GET['lista'];            //Recupero l'id della lista quando elimino un prodotto dalla lista
			} else {
				$id = "";
			}
		}
		$sqlquery = "SELECT Id_lista, Nome FROM LISTA_UTENTE NATURAL JOIN LISTA  WHERE Email='$mail' AND Id_lista = '$id' 
									             UNION
												 SELECT Id_lista, Nome FROM LISTA_UTENTE NATURAL JOIN LISTA  WHERE Email='$mail' AND Id_lista != '$id'";        //Query mettendo come prima riga la lista precedentemente selezionata

		$result = mysql_query($sqlquery);            //Eseguo la query
		$number = mysql_num_rows($result);           //Estraggo il numero di righe 
		if ($number < 1) {
			echo "<div class='scegli'>
												
																	<div class='scelta'>
																		<fieldset>
																			<center>
																				<legend>
																					<h1 class='bold'>Scegli una lista:</h1>
																				</legend>
																				<br>
																					<h2 style='color:red;'>Non hai ancora creato nessuna lista!</h2>
																				</center>
																			</fieldset>
																		</div>
																		<div class='opzioni'>
																			<div class='opzione'>
																				<input type='submit' value='Mostra' class='logreg' disabled style='background-color:#aaa;'>
																				</div>
																				<div class='opzione'>
																					<input type='submit' value='Elimina' class='logreg' disabled style='background-color:#aaa;'>
																					</div>
																					<div class='opzione'>
																	  <input type='submit' value='Condividi' class='logreg' disabled style='background-color:#aaa;'>
																						</div>
																						<div class='opzione'>
																						<a href='crealista.php'>
																							<input type='submit' value='Crea' class='logreg'>
																							</a>
																							</div>
																						</div>
																				</div>";       //Stampo che non ci sono liste se numrighe<1
		} else {
			$id = mysql_result($result, 0, "Id_lista");
			$nome = mysql_result($result, 0, "Nome");
			echo "<div class='scegli'>
                                        
											<form method='post' action='#'>
												<div class='scelta'>
													<fieldset>
														<center>
															<legend>
																<h1 class='bold'>Scegli una lista:</h1>
															</legend>
															<br>
																<select name='liste' class='tendina'>
                                                                <option value='$id' selected='selected'>$nome</option>";
			$i = 1;
			while ($number > $i) {
				$id = mysql_result($result, $i, "Id_lista");
				$nome = mysql_result($result, $i, "Nome");
				echo "<option value='$id'>$nome </option>";
				$i++;
			}              //Stampo le varie liste di questo account nel menù a tendina
			echo "</select>
															</center>
														</fieldset>
													</div>
													<div class='opzioni'>
														<div class='opzione'>
															<input name='mostra' type='submit' value='Mostra' class='logreg'>
															</div>
															<div class='opzione'>
																<input name='elimina' type='submit' value='Elimina' class='logreg'>
																</div>
																<div class='opzione'>
												<input name='condividi' type='submit' value='Condividi' class='logreg'>
																	</div>
                                                                   
																	<div class='opzione'>
														
																<input name='crea' type='submit'  value='Crea' class='logreg'>
																
																		</div>
																	</div>
																 </form>
															</div>"; //Stampo tag di chiusura e bottoni
		}
		if ($_POST || $_GET) {
			if (isset($_POST['mostra']) || isset($_GET['elimina'])) {

				if ($_GET) {
					$idlista = $_GET['lista'];
				} else {
					$idlista = $_POST['liste'];
				}
				$sqlquery = "SELECT Ean, Nome, Descrizione, Marchio, Categoria, Immagine FROM PRODOTTO NATURAL JOIN LISTA_PRODOTTI WHERE Id_lista='$idlista'";        //Query per recuperare prodotti dalla lista
				$result = mysql_query($sqlquery);      //Eseguo la query	
				$number = mysql_num_rows($result);       //Estraggo il numero di righe
				if ($number < 1) {                   //Numero di righe <1 = non ci sono prodotti
					echo '<div class="prodotti">
												<div class="prodlist">
													<h2 style="color:red;">Nessun prodotto presente in questa lista</h2>
												</div>
											</div>';         //Avviso che non ci sono prodotti
				} else {
					$i = 0;
					echo "<div class='prodotti'>
										<form method='get'
										      action='#'>
                                              <input type='text' name='lista' value='$idlista' style='display:none;'>";
					while ($number > $i) {
						$ean = mysql_result($result, $i, "Ean");
						$nome = mysql_result($result, $i, "Nome");
						$descr = mysql_result($result, $i, "Descrizione");
						$marc = mysql_result($result, $i, "Marchio");
						$cat = mysql_result($result, $i, "Categoria");
						$imm = mysql_result($result, $i, "Immagine");     //Inserisco le informazioni del singolo prodotto in variabili php
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
															<h2 class='bold'>$marc   $cat</h2>
														</div>
														<div class='descrizione'>
															<h2>$descr</h2>
														</div>
													</div>
													<div class='elimina'>
														<button value='$ean'name='elimina'
														        type='submit'
														        class='cerca'>
															<img src='img/cestino.png'
															     class='imgricerca'>
																										</button>
														</div>
                                                        </div>";
						$i++;
					}

					echo "</form></div>";       //Stampo i vari proddotti
				}
			}
		} ?>





	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>
<?php
@mysqli_free_result($result);

@mysqli_close($conn);      //Chiudo la connessione al DB
?>

</html>