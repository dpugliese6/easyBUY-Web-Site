<!doctype html>
<html>
<?php
if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";                       //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}
$ean = $_GET['ean'];            //Estrapolo l'ean del prodotto dalla GET request

$DBhost = "localhost";
$DBName = "my_easybuy20";
mysql_connect($DBhost) or die("Impossibile collegarsi al server");                     //Connessione al DB
mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Confronta - easyBUY</title>
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
					<img src="img/annulla.png" style="float:left;" class="sticky-right">
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
		<div class="confronta">
			<?php

			$sqlquery = "SELECT Nome, Descrizione, Marchio, Categoria, Immagine FROM PRODOTTO WHERE Ean='$ean'";
			$result = mysql_query($sqlquery);              //Query che restituisce le informazioni del prodotto
			$number = mysql_num_rows($result);                //Numero di righe tabella della query
			if ($number < 1) {
				echo "<script type='text/javascript'> alert('Info sul prodotto non disponibili!');
										location.href = 'home.php';
										</script>";          //Se <1 la query non ha restituito le informazioni, avvisp che le info non sono disponibili
			} else {

				$nome = mysql_result($result, 0, "Nome");
				$descr = mysql_result($result, 0, "Descrizione");
				$marc = mysql_result($result, 0, "Marchio");                    //Altrimenti metto le informazioni in variabili php
				$cat = mysql_result($result, 0, "Categoria");
				$imm = mysql_result($result, 0, "Immagine");
			}
			?>

			<div class="infoconfronta">
				<table style="height:80%; width:80%;">
					<tr style="height:30%;">
						<td colspan=2>
							<h1 class='bold'><?php echo $nome; ?></h1>
						</td>
					</tr>
					<tr style="height:25%;">
						<td style="width:50%;">
							<h2 class='bold'><?php echo $marc; ?></h2>
						</td>
						<td style="width:50%;">
							<h2 class='bold'><?php echo $cat; ?></h2>
						</td>
					</tr>
					<tr style="height:35%;">
						<td colspan=2>
							<h2><?php echo $descr; ?></h2>
						</td>
					</tr>
				</table>
			</div>
			<div class="immconfronta">

				<img src='prodotto/<?php echo $imm;?>' class='fotoc'>

			</div>              
		</div>
		<?php $sqlquery = "SELECT s.Piva, sp.Prezzo, s.Nome, s.Immagine FROM PRODOTTO p JOIN SUPERMERCATO_PRODOTTO sp on p.Ean=sp.Ean join SUPERMERCATO s on sp.Piva=s.Piva WHERE p.Ean='$ean' ORDER BY sp.Prezzo";
		$result = mysql_query($sqlquery);                //Query che mi restituisce le informazioni del prodotto nei vari supermercati
		$number = mysql_num_rows($result);               //Numero di righe query
		if ($number < 1) {
			echo '<div class="prodotti"> 
												<div class="prodlist">
													<h2 style="color:red;">Il prodotto non è presente in nessun supermercato...</h2>
												</div>
											</div>';            //Se <1 allora il prodotto non è presente in nessun supermercato, stampo avviso  
		} else { 
			$i = 0;
			echo "<div class='prodotti'>
												<form method='post' action='sceglicarrello.php'>";
			while ($number > $i) {
				$iva = mysql_result($result, $i, "s.Piva");
				$prezzo = mysql_result($result, $i, "sp.Prezzo");
				$nomesup = mysql_result($result, $i, "s.Nome");             //Inserisco informazioni del prodotto in un supermercato in variabili php 
				$immsup = mysql_result($result, $i, "s.Immagine");
				echo "	<div class='prodlist'>
											<div class='immlist'>
												<img src='supermercato/$immsup' class='fotoc'>
											</div>
											<div class='supermercato'>
												<h1 class='bold'>$nomesup</h1>
											</div>
											<div class='prezzo'>
												<h2>$prezzo €</h2>
											</div>
						
											<div class='addcarrello'>
												<button value='$ean $iva' name='aggiungi' type='submit' class='cerca'>
													<img src='img/aggiungi.png' class='imgricerca'>
												</button>
											</div>
										</div>";   
				$i++;
			}
			echo "</form>
											</div>";         //Stampo le varie informazioni del prodotto nei supermercati
		} ?>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>
<?php
@mysqli_free_result($result);

@mysqli_close($conn);                 //Chiudo connessione al DB
?>

</html>