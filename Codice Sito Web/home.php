<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";                   //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
} ?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Home - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body>
	<div class="wrapper">
		<div class="sticky">
			<div class="stickydiv">
				<a href="download/easyBUY.apk" style="float:left;" class="sticky-right" download>
					<img src="img/download.png" style="float:left;" class="sticky-right">
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
		<div class="ricerca">
			<form method="post" action="risultati.php" style="height:100%;">
				<div class="camporic">
					<input type="text" name="cercato" style="width: 100%; margin:0 20px;" placeholder="Cerca un prodotto...">
				</div>
				<div class="tastoric">
					<button name="cerca" type="submit" class="cerca">
						<img src="img/ricerca.png" class="imgricerca">
					</button>
				</div>
			</form>
		</div>
		<div class="categorie">
			<a href="liste.php">
				<div class="categoria">
					<div class="imcat">
						<img src="img/liste1.png" class="foto">
					</div>
					<div class="titcat">
						<img src="img/titlist.png" class="foto">
					</div>
					<div class="overlay">
						<div class="testooverlay">Mostra, elimina e condividi le tue liste</div>
					</div>
				</div>
			</a>
			<a href="carrelli.php">
				<div class="categoria">
					<div class="imcat">
						<img src="img/carrelli.png" class="foto">
					</div>
					<div class="titcat">
						<img src="img/titcarr.png" class="foto">
					</div>
					<div class="overlay">
						<div class="testooverlay">Mostra, elimina e condividi i tuoi carrelli</div>
					</div>
				</div>
			</a>
			<a href="supermercati.php">
				<div class="categoria">
					<div class="imcat">
						<img src="img/supermercati.png" class="foto">
					</div>
					<div class="titcat">
						<img src="img/titsup.png" class="foto">
					</div>
					<div class="overlay">
						<div class="testooverlay">Visualizza informazioni e prodotti dei supermercati</div>
					</div>
				</div>
			</a>
		</div>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>

</html>