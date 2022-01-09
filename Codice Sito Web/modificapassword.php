<!doctype html>
<html>
<?php 

if (!isset($_COOKIE['u'])) {
    echo "<script type='text/javascript'> alert('Sessione scaduta!');
    location.href = 'index.php';
    </script>";                                                            //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
}

$stampaok = 0;                               //Flag per stampare che la modifica è andata a buon fine                
$nocorrispondenza = 0;                       //Flag per stampare che le password non corrispondono  
$passworderrata = 0;                         //Flag per stampare che la password non è valida

if ($_POST) {                   //Entro nel'if se avviene una richiesta POST (ad esempio quando premo il tasto nel form)

    $mailutente = $_COOKIE['u'];       //Recupero la mail dal cookie
    $pass = $_POST['pass'];            //Recupero la password dal campo Password attuale
    $pcrypt= md5($pass);               //Calcolo l'md5

    $DBhost = "localhost";
    $DBName = "my_easybuy20";
    mysql_connect($DBhost) or die("Impossibile collegarsi al server");                    //Apro la connessione al DB
    mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");

    $sqlquery = "SELECT * FROM  UTENTE  WHERE Email='$mailutente' AND Password='$pcrypt'";
    $result = mysql_query($sqlquery);                                                           //Eseguo la query di estrarre gli utenti con quella password e mail

    if (mysql_num_rows($result) > 0) {                         //Se il numero di righe è maggiore di 0 c'è almeno un utente che corrisponde

        if ($_POST['newpass1'] == $_POST['newpass2']) {         //Controllo se le password corrispondono
            $newpass = $_POST['newpass1'];
            $npcrypt=md5($newpass);
            $sqlquery = "UPDATE UTENTE SET Password = '$npcrypt' WHERE UTENTE.Email = '$mailutente'";    //Se le due password corrispondono modifico la password con il nuovo md5
            $result = mysql_query($sqlquery);
            $stampaok = 1;     //Flag settato a 1 per stampare il messaggio di conferma
        } else {
            $nocorrispondenza = 1;      //Se non corrispondono setto a 1 il Flag per stampare il messaggio di errore
        }

    } else {
        $passworderrata = 1;            //Se il numero di righe è 0 allora setto a 1 il Flag per stampare l'errore di password errata
    }
}
?>

<head>
    <link rel="icon" href="img/icon.png" />    
    <title>Modifica password - easyBUY</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">              
    <link rel="stylesheet" href="css/reset.css" type="text/css">
    <link rel="stylesheet" href="css/stile.css" type="text/css">
</head>

<body> 
    <div class="wrapper">      

        <div class="sticky">         
            <div class="stickydiv">
                <a href="profilo.php" style="float:left;" class="sticky-right">
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
           
            </div>
        </div>


        <div class="email">
            <h1 class='bold'>Modifica password:</h1>    
        </div>

        <div class="contenutoprofilo">              

            <form method='post' action='#'>      

                <div class="campiprofilo">             

                    <div class="campopass">
                        <input type="password" size="30" name="pass" class="campopass" required placeholder="Password attuale">      
                    </div>

                    <div class="campopass">
                        <input type="password" size="30" name="newpass1" class="campopass" required placeholder="Nuova password">      
                    </div>

                    <div class="campopass">
                        <input type="password" size="30" name="newpass2" class="campopass" required placeholder="Ripeti nuova password">     
                    </div>

                </div>

                <div class="tastiprofilo">

                    <?php
                    if ($stampaok) {
                        echo "<h3 style='color: green;'>Password modificata!</h3>";
                    }
                    if ($passworderrata) {
                        echo "<h3 style='color: red;'>Password errata!</h3>";                    //Stampa messaggi di errore/conferma in base ai flag
                    }
                    if ($nocorrispondenza) {
                        echo "<h3 style='color: red;'>Le password non corrispondono!</h3>";
                    }
                    ?>

                    <input name='modifica' type='submit' value='Modifica' class='logreg' style="margin:10px;">           

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
                                           //Chiudo la connessione al DB
@mysqli_close($conn); ?>

</html>