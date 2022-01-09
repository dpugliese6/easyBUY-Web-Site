<!doctype html>
<html>

<head>
	<?php if (!isset($_COOKIE['u'])) {
		echo "<script type='text/javascript'> alert('Sessione scaduta!');
		location.href = 'index.php';
		</script>";                //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
	}

	$DBhost = "localhost";
	$DBName = "my_easybuy20";
	mysql_connect($DBhost) or die("Impossibile collegarsi al server");                 //Apro la connessione al DB
	mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName"); 
	?>
	<link rel="icon" href="img/icon.png" />
	<title>Info Supermercati - easyBUY</title>
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


		<?php
		if (isset($_GET['info_super'])) {
			$piva = $_GET['info_super'];              //Recupero la partita iva dalla pagina precedente 
		}

		$sqlquery = "SELECT Nome, Mappa, Immagine, Citta, Via, Civico    FROM SUPERMERCATO   WHERE Piva = '$piva' ";
		$result = mysql_query($sqlquery);                                            //Eseguo la query per estrarre le informazioni sul supermercato

		$nome = mysql_result($result, 0, "Nome");
		$mappa = mysql_result($result, 0, "Mappa");
		$immagine = mysql_result($result, 0, "Immagine");                 //Inserisco le informazioni in variabili php
		$citta = mysql_result($result, 0, "Citta");
		$via = mysql_result($result, 0, "Via");
		$civico = mysql_result($result, 0, "Civico");

		echo "  <div class='intest_sup'>
		<div class='immsuper'>
			<img src='supermercato/$immagine' class='foto'>
		</div>
		<div class='infosuper'>
			<div class='nomesuper'>
				<h1 class='bold'>$nome</h1>
			</div>
			<div class='paesesuper'>
				<h2> $citta </h2>
			</div>
			<div class='viasuper'>
				<h2> $via $civico </h2>
			</div>
		</div>
	</div>
	<div class='mappa'>
	<div class='mappa_sup'>

		<img src='mappa/$mappa' class='foto'>
	</div>
	</div>";                                                //Stampo le informazioni in HTML
		?>


	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>
<?php
@mysqli_free_result($result);

@mysqli_close($conn); //Chiudo la connessione al server
?>

</html>