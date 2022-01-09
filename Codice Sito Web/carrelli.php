<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";                         //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}

$DBhost = "localhost";
$DBName = "my_easybuy20";

mysql_connect($DBhost) or die("Impossibile collegarsi al server");
mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");
if ($_GET) {
	$idcarrello = $_GET['carrello'];
	$ean = $_GET['elimina'];

	$sqlquery = "DELETE FROM CARRELLO_PRODOTTI WHERE Id_carrello='$idcarrello' AND Ean='$ean';";
	mysql_query($sqlquery);
}
if ($_POST) {
	if (isset($_POST['condividi'])) {
		$idcarrello = $_POST['carrelli'];
		setcookie("carr", $idcarrello, time() + 900);
		header("location:condividicarrello.php");
	}
	if (isset($_POST['crea'])) {
		header("location:creacarrello.php");
	}

	if (isset($_POST['elimina'])) {
		$idcarrello = $_POST['carrelli'];
		$mail = $_COOKIE['u'];
		$sqlquery = "DELETE FROM CARRELLO_UTENTE WHERE Id_carrello='$idcarrello' AND Email='$mail';";
		mysql_query($sqlquery);
	}
} ?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Carrelli - easyBUY</title>
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
				<a href="home.php" class="sticky-right">
					<img src="img/profilo.png" class="sticky-right">
				</a>
			</div>
		</div>
		<?php
		$mail = $_COOKIE['u'];
		if (isset($_POST['carrelli'])) {
			$id = $_POST['carrelli'];
		} else {
			if (isset($_GET['carrello'])) {

				$id = $_GET['carrello'];
			} else {
				$id = "";
			}
		}
		$sqlquery = "SELECT Id_carrello, Nome FROM CARRELLO_UTENTE NATURAL JOIN CARRELLO  WHERE Email='$mail' AND Id_carrello = '$id' 
									             UNION
												 SELECT Id_carrello, Nome FROM CARRELLO_UTENTE NATURAL JOIN CARRELLO  WHERE Email='$mail' AND Id_carrello != '$id'";

		$result = mysql_query($sqlquery);
		$number = mysql_num_rows($result);
		if ($number < 1) {
			echo "<div class='scegli'>
												
																	<div class='scelta'>
																		<fieldset>
																			<center>
																				<legend>
																					<h1 class='bold'>Scegli un carrello:</h1>
																				</legend>
																				<br>
																					<h2 style='color:red;'>Non hai ancora creato nessun carrello!</h2>
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
																						<a href='creacarrello.php'>
																							<input type='submit' value='Crea' class='logreg'>
																							</a>
																							</div>
																						</div>
																				</div>";
		} else {
			$id = mysql_result($result, 0, "Id_carrello");
			$nome = mysql_result($result, 0, "Nome");
			echo "<div class='scegli'>
                                        
											<form method='post' action='#'>
												<div class='scelta'>
													<fieldset>
														<center>
															<legend>
																<h1 class='bold'>Scegli un carrello:</h1>
															</legend>
															<br>
																<select name='carrelli' class='tendina'>
                                                                <option value='$id' selected='selected'>$nome</option>";
			$i = 1;
			while ($number > $i) {
				$id = mysql_result($result, $i, "Id_carrello");
				$nome = mysql_result($result, $i, "Nome");
				echo "<option value='$id'>$nome </option>";
				$i++;
			}
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
															</div>";
		}

		if ($_POST || $_GET) {
			if (isset($_POST['mostra']) || isset($_GET['elimina'])) {

				if ($_GET) {
					$idcarrello = $_GET['carrello'];
				} else {
					$idcarrello = $_POST['carrelli'];
				}
				$sqlquery = "SELECT P.Ean, P.Nome, P.Descrizione, P.Marchio, P.Categoria, P.Immagine, S.Immagine, S.Nome FROM  (SELECT * FROM SUPERMERCATO NATURAL JOIN CARRELLO_PRODOTTI) AS S JOIN PRODOTTO AS P  ON S.Ean=P.Ean  WHERE Id_carrello='$idcarrello'";
				$result = mysql_query($sqlquery);
				$number = mysql_num_rows($result);
				if ($number < 1) {
					echo '<div class="prodotti">
												<div class="prodlist">
													<h2 style="color:red;">Nessun prodotto presente in questa lista</h2>
												</div>
											</div>';
				} else {
					$i = 0;
					echo "<div class='prodotti'>
										<form method='get'
										      action='#'>
                                              <input type='text' name='carrello' value='$idcarrello' style='display:none;'>";
					while ($number > $i) {
						$ean = mysql_result($result, $i, "P.Ean");
						$nome = mysql_result($result, $i, "P.Nome");
						$descr = mysql_result($result, $i, "P.Descrizione");
						$marc = mysql_result($result, $i, "P.Marchio");
						$cat = mysql_result($result, $i, "P.Categoria");
						$imm = mysql_result($result, $i, "P.Immagine");
						$immsup = mysql_result($result, $i, "S.Immagine");
						$nomesup = mysql_result($result, $i, "S.Nome");
						echo "			<div class='prodlist'>
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
														<button value='$ean' name='elimina'
														        type='submit'
														        class='cerca'>
															<img src='img/cestino.png'
															     class='imgricerca'>
																										</button>
														</div>
                                                        </div>
														<div class='prodlist' style='height:50px;'>
												<div class='immlist'>
													<img src='supermercato/$immsup'
													     class='foto'>
													</div>
													<div class='nomesup'>
													<h2>$nomesup</h2>
													</div>
												
                                                        </div>";
						$i++;
					}

					echo "</form>
											</div>
                                            
                                            ";
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

@mysqli_close($conn); ?>

</html>