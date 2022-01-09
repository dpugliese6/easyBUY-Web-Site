<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";
}
$DBhost = "localhost";
$DBName = "my_easybuy20";

mysql_connect($DBhost) or die("Impossibile collegarsi al server");
mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");
if (!isset($_GET['ean'])) {
	echo "<script type='text/javascript'> 
location.href = 'home.php';
</script>";
} else {
	$ean = $_GET['ean'];
}
if ($_POST) {
	$idscelto = $_POST['scelto'];
	$sqlquery = "INSERT INTO `LISTA_PRODOTTI` (`Id_lista`,`Ean`) VALUES ('$idscelto','$ean');";
	$result = mysql_query($sqlquery);
	echo "<script type='text/javascript'> alert('Prodotto inserito correttamente...');
	location.href = 'liste.php';
	</script>";
}


$utente = $_COOKIE['u'];

?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Scegli Lista - easyBUY</title>
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
		<br>
		<center>
			<h1 class="bold">Scegli lista:</h1>
		</center>
		<?php $sqlquery = "SELECT lu.Id_lista, l.Nome FROM LISTA_UTENTE lu, LISTA l WHERE lu.Email='$utente' AND lu.Id_lista=l.Id_lista";
		$result = mysql_query($sqlquery);
		$number = mysql_num_rows($result);
		if ($number < 1) {
			echo "<script type='text/javascript'> alert('Non hai ancora creato una lista!');
location.href = 'crealista.php';
</script>";
		} else {
			$i = 0;
			echo "<div class='prodotti'>
<form method='post' action='#'>";
			while ($number > $i) {
				$id = mysql_result($result, $i, "lu.Id_lista");
				$nome = mysql_result($result, $i, "l.Nome");

				echo "		<div class='prodlist'>
				<div class='nomescelta'>
					<h1 class='bold'>$nome</h1>
				</div>
				<div class='tastoscegli'>
				<button value='$id' name='scelto' type='submit' class='cerca'>
				<img src='img/aggiungi.png' class='imgricerca'>
			</button>
				</div>
			</div>";
				$i++;
			}
			echo "</form>
											</div>";
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