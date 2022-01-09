<!doctype html>
<html>
<?php if (isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Accesso eseguito automaticamente...');
location.href = 'home.php';
</script>";
} ?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Registrazione - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body>
	<div class="testa">
		<img src="css/logo.png" class="foto" />
	</div>
	<div class="corpo1">
		<div class="titregistrazione">
			<img src="css/Registrazione.gif" class="foto" />
		</div>
		<div class="campiregistrazione">

			<form method="post" action="#" name="form" style="width:100%;">
				<div class="sinistra1">

					<table border="0" style="height:100%; margin: 0 auto;">
						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Nome</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<input type="text" size="30" name="nome" style="width: 230px;" required value="<?php if (isset($_POST['nome'])) echo $_POST['nome'];  ?>">
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Cognome</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<input type="text" size="30" style="width: 230px;" name="cognome" required value="<?php if (isset($_POST['cognome'])) echo $_POST['cognome'];  ?>">
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Sesso</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">

							<td>
								<h3> <label> <input type="radio" name="sesso" value="M" required <?php if (isset($_POST['sesso']) && $_POST['sesso'] == 'M') echo 'checked'  ?>> M </label>
									<label><input type="radio" name="sesso" value="F" required <?php if (isset($_POST['sesso']) && $_POST['sesso'] == 'F') echo 'checked'  ?>> F </label>
								</h3>
							</td>
						</tr>

						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Data di nascita</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<input type="date" name="data" required value="<?php if (isset($_POST['data'])) echo $_POST['data'];  ?>">
							</td>
						</tr>



					</table>

				</div>
				<div class="destra1">

					<table border="0" style="height:100%; margin: 0 auto;">

						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Email</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<input type="email" size="30" style="width: 230px;" name="email" required value="<?php if (isset($_POST['email'])) echo $_POST['email'];  ?>">
							</td>
						</tr>

						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Password</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<input type="password" minlength="8" size="16" style="width: 230px;" name="pass1" required>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<h2 class="bold">Ripeti Password</h2>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td>
								<input type="password" minlength="8" size="16" style="width: 230px;" name="pass2" required>
							</td>
						</tr>

						<tr style="height:12.5%;">
							<td><?php
								if ($_POST) {
									$DBhost = "localhost";
									$DBName = "my_easybuy20";

									mysql_connect($DBhost) or die("Impossibile collegarsi al server");
									mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");



									if ($_POST['pass1'] == $_POST['pass2']) {
										$mail = $_POST['email'];
										$psw = $_POST['pass1'];
										$name = $_POST['nome'];
										$surname = $_POST['cognome'];
										$gender = $_POST['sesso'];
										$dnascita = $_POST['data'];


										$sqlquery = "SELECT * FROM UTENTE WHERE Email='$mail'";
										$result = mysql_query($sqlquery);
										if (mysql_num_rows($result) < 1) {
											$cond = 1;
										} else {
											$cond = 0;
										}

										if ($cond == 1) {
                                            $pcrypt=md5($psw);
											$sqlquery = "INSERT INTO `UTENTE` (`Email`, `Password`, `Nome`, `Cognome`, `Sesso`,`Data_Nascita`) VALUES ('$mail', '$pcrypt', '$name', '$surname', '$gender','$dnascita')";
											mysql_query($sqlquery);


											echo "<script type='text/javascript'> alert('Registrato con successo, effettua il login!');	
		          location.href='index.php';</script>";
										} else {
											echo "   <center><h3 style='color: red;'>Email già registrata!</h3></center><br>";
										}
										@mysqli_free_result($result);

										@mysqli_close($conn);
									} else {
										echo "   <center><h3 style='color: red;'>Le password non corrispondono!</h3></center><br>";
									}
								}


								?>

								<center>
									<input type="submit" name="Registrati" value="Registrati" class="logreg">
								</center>
							</td>
						</tr>
						<tr style="height:12.5%;">
							<td style="padding-top:10px;">
								<center>

									<a href="index.php">
										<h3 class="giallo click">Sei già registrato?</h3>
									</a>
								</center>
							</td>
						</tr>
					</table>

				</div>
			</form>
		</div>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>

</html>