<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> 
	alert('Sessione scaduta!');
location.href = 'index.php';
</script>";
}
$mailutente = $_COOKIE['u'];
if ($_GET) {
	setcookie("u", "", time() - 3600);
	echo "<script type='text/javascript'>
location.href = 'index.php';
</script>";
}

$DBhost = "localhost";
$DBName = "my_easybuy20";
mysql_connect($DBhost) or die("Impossibile collegarsi al server");
mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

$sqlquery = "SELECT  Nome, Cognome, Sesso, Data_Nascita FROM  UTENTE  WHERE Email='$mailutente'";
$result = mysql_query($sqlquery);
if (mysql_num_rows($result) > 0) {
	$Nome = mysql_result($result, 0, "Nome");
	$Cognome = mysql_result($result, 0, "Cognome");
	$Sesso = mysql_result($result, 0, "Sesso");
	$Data_Nascita = mysql_result($result, 0, "Data_Nascita");
} else {
	echo "<script type='text/javascript'> alert('Si è verificato un problema!');
	location.href = 'home.php';
	</script>";
}

?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Profilo - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
	<script type="text/javascript">
		function ConfermaEliminazione() {
			var richiesta = window.confirm("Confermi di eliminare il profilo?");
			if (richiesta) {
				location.href = 'elimina.php';
			}
		}
	</script>
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
				<form method='get' action='#'>
					<button value='$ean' name='esci' type='submit' class='sticky-right' style="border:0; background-color:#ffd800;">
						<img src="img/esci.png" class="sticky-right">
					</button>
				</form>
			</div>
		</div>
		<div class="contenutoprofilo">

			<div class="email">

				<?php echo "<h2 class='profilo'>$mailutente</h2>";
				$stampaok = 0;
				if ($_POST) {
					if (isset($_POST['modifica'])) {
						$Nome = $_POST['nome'];
						$Cognome = $_POST['cognome'];
						$Sesso = $_POST['sesso'];
						$Data_Nascita = $_POST['data'];

						$sqlquery = "UPDATE UTENTE SET Nome = '$Nome', Cognome = '$Cognome', Sesso = '$Sesso', Data_Nascita = '$Data_Nascita' WHERE UTENTE.Email = '$mailutente'";
						mysql_query($sqlquery);
						$stampaok = 1;
					}
					if (isset($_POST['elimina'])) {
						echo "<script type='text/javascript'> ConfermaEliminazione();
			</script>";
					}
				}


				?>

			</div>
			<form method='post' action='#'>
				<div class="campiprofilo">
					<div class="titoloprof">
						<h2 class="bold">Nome</h2>
					</div>
					<div class="campoprof">
						<input type="text" size="30" name="nome" class="campoprof" required value="<?php echo $Nome; ?>">
					</div>
					<div class="titoloprof">
						<h2 class="bold">Cognome</h2>
					</div>
					<div class="campoprof">
						<input type="text" size="30" name="cognome" class="campoprof" required value="<?php echo $Cognome; ?>">
					</div>
					<div class="titoloprof">
						<h2 class="bold">D. di nascita</h2>
					</div>
					<div class="campoprof">
						<input type="date" name="data" class="campoprof" required value="<?php echo $Data_Nascita; ?>">
					</div>
					<div class="titoloprof">
						<h2 class="bold">Sesso</h2>
					</div>
					<div class="campoprof">
						<h3 style="height: 19px;">
							<label><input type="radio" name="sesso" value="M" required <?php if ($Sesso == 'M') echo 'checked'  ?>> M </label>
							<label><input type="radio" name="sesso" value="F" required <?php if ($Sesso == 'F') echo 'checked'  ?>> F </label>
						</h3>
					</div>



				</div>
				<div class="tastiprofilo">
					<?php if ($stampaok) {
						echo "<h3 style='color: green;'>Dati modificati correttamente!</h3>";
					} ?>
					<input name='modifica' type='submit' value='Modifica' class='logreg' style="margin:10px;">

					<a href="modificapassword.php">
						<h3 class="giallo click">Modifica password</h3>
					</a>

					<input name='elimina' type='submit' value='Elimina profilo' class='eliminaprof' style="margin:10px;">


				</div>
			</form>


		</div>



	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>
<?php
@mysqli_free_result($result);

@mysqli_close($conn); ?>

</html>