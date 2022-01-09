<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";                       //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}
?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Crea carrello - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body>
	<div class="wrapper">
		<div class="sticky">
			<div class="stickydiv">
				<a href="carrelli.php" style="float:left;" class="sticky-right">
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




		<div class="crealista">

			<h1 class="bold">Inserisci il nome:</h1>
			<form method="post" action="#">
				<div class="campo">
					<input type="text" name="creare" required style="width: 100%; max-width:300px; margin:0 20px;" placeholder="Nome carrello">
					<?php if ($_POST) {
						$DBhost = "localhost";
						$DBName = "my_easybuy20";

						mysql_connect($DBhost) or die("Impossibile collegarsi al server");
						mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

						$mail = $_COOKIE['u'];
						$nome = $_POST['creare'];
						$sqlquery = "INSERT INTO `CARRELLO` (`Nome`) VALUES ( '$nome');";
						mysql_query($sqlquery);
						$sqlquery = "INSERT INTO `CARRELLO_UTENTE` (`Id_carrello`,`Email`) VALUES ((SELECT MAX(Id_Carrello) FROM CARRELLO LIMIT 1), '$mail');";
						mysql_query($sqlquery);
						echo " <br>
										<br>
										<center><h3 style='color: green;'>Carrello creato correttamente!</h3></center>
										";
					} ?>
				</div>
				<div class="tasto">
					<input name="crea" type="submit" value="Crea" class="logreg">
				</div>

			</form>
		</div>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>

</html>