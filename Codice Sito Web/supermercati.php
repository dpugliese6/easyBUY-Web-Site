<!doctype html>
<html>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Supermercati - easyBUY</title>
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
		<div class="email">
			<h1 class='bold'>Supermercati:</h1>

		</div>

		<?php
		$DBhost = "localhost";
		$DBName = "my_easybuy20";

		mysql_connect($DBhost) or die("Impossibile collegarsi al server");
		mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

		$sqlquery = "SELECT Piva, Nome, Immagine FROM SUPERMERCATO";

		$result = mysql_query($sqlquery);
		$number = mysql_num_rows($result);
		if ($number < 1) {

			echo "<div class='prodotti'>
												<div class='prodlist'>
													<h2 style='color:red;'>Non ci sono ancora supermecati disponibili!</h2>
												</div>
											</div>";
		} else {
			$id = mysql_result($result, 0, "Piva");
			$nome = mysql_result($result, 0, "Nome");
			echo "<div class='prodotti'>";


			$i = 0;
			while ($number > $i) {
				$id = mysql_result($result, $i, "Piva");
				$nome = mysql_result($result, $i, "Nome");
				$imm = mysql_result($result, $i, "Immagine");
				echo "  <div class='prodlist'>	
													
													<div class='immlist'>
															<img src='supermercato/$imm' class='foto'>
														
													</div>
												
													<div class='nomesup'>
														
																<h1 class='bold'>$nome</h1>
														
													</div>
													
												
													<div class='infosup'>
													<form method='get' action='info_supermercati.php'>
														<button value='$id' name='info_super' type='submit' class='info'>
															<img src='img/info.png' class='foto'>
														</button>
														</form>
													</div>
													
													
													
													<div class='prodsup'>
													<form method='get' action='prodotti_supermercati.php'>
														<button value='$id' name='visualizza_prod_super' type='submit' class='cerca'>
															<h2 class='bold'> Prodotti</h2>
														</button>
														</form>
													</div>
													
													
													
													
												</div>";
				$i++;
			}
			echo "
										</div>";
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