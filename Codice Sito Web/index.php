<!doctype html>
<html>
<?php if (isset($_COOKIE['u'])) {
	echo "<script type='text/javascript'> alert('Accesso eseguito automaticamente...');
location.href = 'home.php';
</script>";                        //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
} ?>

<head>
	<link rel="icon" href="img/icon.png" />
	<title>Login - easyBUY</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/reset.css" type="text/css">
	<link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body>
	<div class="testa">
		<img src="css/logo.png" class="foto" />
	</div>
	<div class="corpo">
		<div class="sinistra">
			<img src="css/foto1.jpg" class="foto" />
		</div>
		<div class="destra">
			<div class="login">
				<div class="titlogin">
					<img src="css/Login.gif" class="foto">

				</div>
				<div class="campi">
					<form method="post" action="#" style="height:100%;">

						<table border="0" class="clogin" style="height:100%; margin: 0 auto;">
							<tr style="height:16.66%;">
								<td>

									<h2 class="bold">Email</h2>
								</td>
							</tr>
							<tr style="height:16.66%;">
								<td>
									<input type="email" required size="30" name="Email">
								</td>
							</tr>
							<tr style="height:16.66%;">
								<td>
									<h2 class="bold">Password</h2>
								</td>
							</tr>
							<tr style="height:16.66%;">
								<td>
									<input type="password" required size="30" name="Pass">
								</td>
							</tr>
							<tr style="height:16.66%;">
								<td> <?php


										if ($_POST) {

											$DBhost = "localhost";
											$DBName = "my_easybuy20";
											mysql_connect($DBhost) or die("Impossibile collegarsi al server");
											mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

											$mail = $_POST["Email"];
											$pass = $_POST["Pass"];
                                            $pcrypt=md5($pass);
											$sqlquery = "SELECT * FROM UTENTE WHERE Email='$mail' AND Password='$pcrypt'";
											$result = mysql_query($sqlquery);
											if (mysql_num_rows($result) < 1) {
												echo "<center><h3 style='color: red;'>Email o password errate!</h3></center><br>";
											} else {
												setcookie("u", $mail, time() + 3600);
												header("location:home.php");
											}
											@mysqli_free_result($result);

											@mysqli_close($conn);
										}
										?>
									<center>
										<input type="submit" name="Login" value="Accedi" class="logreg">
									</center>
								</td>
							</tr>
							<tr style="height:16.66%;">
								<td style="padding-top:10px;">
									<center><a href="registrazione.php">
											<h3 class="giallo click">Non sei ancora registrato?</h3>
										</a></center>
								</td>
							</tr>
						</table>

					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="piede">
		<h3 class="giallo">easyWEB srl - Via Edoardo Orabona 4 Bari 70126</h3>
	</div>
</body>

</html>