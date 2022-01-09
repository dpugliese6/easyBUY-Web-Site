<!doctype html>
<html>
<?php if (!isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Sessione scaduta!');
location.href = 'index.php';
</script>";
}

if (isset($_POST['addcarrelli'])) {
	$eanprod = $_POST['addcarrelli'];
	header("location:confronta.php?ean=$eanprod");
}
if (isset($_POST['addlista'])) {
	$eanprod = $_POST['addlista'];
	header("location:sceglilista.php?ean=$eanprod");
}


?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Risultati - easyBUY</title>
	<script src="//unpkg.com/string-similarity/umd/string-similarity.min.js"></script>
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
		<div class="email">
			<h1 class='bold'>Risultati:</h1>

		</div>
		<div class="prodotti">
			<script>
				function fetchProdotti() { //magari non serve manco la funzione, o comunque può essere scritta altrove
					<?php
					$cercato = ucfirst(strtolower($_POST['cercato']));
					echo "var cercato='$cercato';"; //prelevo e stampo come variabile javascript la parola cercata nella home
					$DBhost = "localhost";
					$DBName = "my_easybuy20";
					$table = "PRODOTTO";
					$con = new mysqli($DBhost, 'easybuy20', '', $DBName); //la password root va bene sul mio xampp, su altervista diventerà easybuy20, qui e ovunque
					$sqlquery = "SELECT * FROM $table";
					$stmt = $con->prepare($sqlquery);
					if ($stmt->execute()) {
						$result = $stmt->get_result();
						$vett = [];
						while ($row = mysqli_fetch_assoc($result)) {
							$vett[] = $row;
						}
						$tabellajson = json_encode($vett); //bla bla bla, prendo la tabella e la formatto come stringa in formato json
					}
					?>
					var tabella = unescape('<?php echo rawurlencode(str_replace("\'", "'", $tabellajson)) ?>'); //una serie di comandi per passare la stringa $tabellajson alla variabile javascript tabella
					//senza questi comandi i doppi apici della formattazione json vanno in conflitto con i delimiter delle stringhe
					var tabjson = JSON.parse(tabella); //trasformo da stringa a JSON
					var nomatch = 0;
					for (i = 0; i < tabjson.length; i++) {
						var nome = tabjson[i].Nome; //prelevo il nome della riga i-esima
						var punteggio = stringSimilarity.compareTwoStrings(cercato, nome); //comparo
						if (punteggio > 0.3) {
							nomatch = 1;
							document.write("<form method='post' action='#'><div class='prodrisultati'><div class='datirisultati'><div class='nomerisultati'><h1 class='bold'>" + nome + "</h1></div>");
							document.write("<div class='marrisultati'><h2 class='bold'>" + tabjson[i].Marchio + "</h2></div><div class='catrisultati'><h2 class='bold'>" + tabjson[i].Categoria + "</h2></div>");
							document.write("</div><div class='bottonirisultati'><button value='" + tabjson[i].Ean + "' name='addlista' type='submit' class='cerca1'><img src='img/buttliste.png' class='imgricerca'></button>");
							document.write("<button value='" + tabjson[i].Ean + "' name='addcarrelli' type='submit' class='cerca1'><img src='img/buttcarrelli.png' class='imgricerca'></button></div></div></form> ");

						}
					}
					if (!nomatch) {
						document.write("<div class='prodlist'><h2 style='color:red;'>Nessun prodotto corrisponde con la ricerca...</h2></div>");
					}
				}

				fetchProdotti();
			</script>

		</div>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>

</html>