<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";                //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}
?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Condividi carrello - easyBUY</title>
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

			<h2 class="bold">Inserisci l'indirizzo mail di un altro utente:</h2>
			<form method="post" action="#">
				<div class="campo">
					<input type="email" name="condividere" required style="width: 100%; max-width:300px; margin:0 20px;" placeholder="Email">
					<?php
					if ($_POST) {         //Se viene eseguita una POST request
						$DBhost = "localhost";
						$DBName = "my_easybuy20";
						mysql_connect($DBhost) or die("Impossibile collegarsi al server");                  //Connessione al DB
						mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");


						$carrello = $_COOKIE['carr'];             //Estrapolo l'id carrello dal cookie
						$utente = $_POST['condividere'];           //Estrapolo la mail con il quale condividere dal POST

						$sqlquery = "SELECT * FROM UTENTE WHERE Email='$utente'";
						$result = mysql_query($sqlquery);                          //Query che restituisce utenti del DB
						if (mysql_num_rows($result) < 1) {   //Se non ci sono utenti con quella mail
							echo "<br>
										<br>
										<center><h3 style='color: red;'>Email non valida...</h3></center>"; //Avviso che non ci sono
						} else {
							$sqlquery = "INSERT INTO `CARRELLO_UTENTE` (`Id_carrello`,`Email`) VALUES ('$carrello', '$utente');";            //Inserisco quel carrello all'utente con cui condividere
							mysql_query($sqlquery);
							echo "
                                        <br>
										<br>
										<center><h3 style='color: green;'>Carrello condivisa correttamente!</h3></center>
										";
						}
					}
					?>
				</div>
				<div class="tasto">
					<input name="condividi" type="submit" value="Condividi" class="logreg">
				</div>

			</form>
		</div>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>

</html>