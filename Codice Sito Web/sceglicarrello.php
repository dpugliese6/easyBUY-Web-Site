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

if ($_POST) {
	$post = $_POST['aggiungi'];
}



if ($_GET) {
	$info = $_GET['info'];
	$split = split(" ", $info);
	$ean = $split[0];
	$iva = $split[1];
	$idscelto = $_GET['scelto'];
	$sqlquery = "INSERT INTO `CARRELLO_PRODOTTI` (`Id_carrello`,`Ean`,`Piva`) VALUES ('$idscelto','$ean','$iva')";
	$result = mysql_query($sqlquery);
	echo "<script type='text/javascript'> alert('Prodotto inserito correttamente...');
	location.href = 'carrelli.php';
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
			<h1 class="bold">Scegli carrello:</h1>
		</center>
		<?php $sqlquery = "SELECT cu.Id_carrello, c.Nome FROM CARRELLO_UTENTE cu, CARRELLO c WHERE cu.Email='$utente' AND cu.Id_carrello=c.Id_carrello ";
		$result = mysql_query($sqlquery);
		$number = mysql_num_rows($result);
		if ($number < 1) {
			echo "<script type='text/javascript'> alert('Non hai ancora creato una carrello!');
location.href = 'creacarrello.php';
</script>";
		} else {
			$i = 0;
			echo "<div class='prodotti'>
           
<form method='get' action='#'>
<input type='text' name='info' value='$post' style='display:none;'>";

			while ($number > $i) {
				$id = mysql_result($result, $i, "cu.Id_carrello");
				$nome = mysql_result($result, $i, "c.Nome");

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