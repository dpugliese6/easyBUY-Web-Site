<html>
<?php
if (!isset($_COOKIE['u'])) {
    echo "<script type='text/javascript'> alert('Sessione scaduta!');
    location.href = 'index.php';
    </script>";           //Controllo se il cookie è ancora attivo, diversamente la sessione risulta scaduta e vado al login
} else {
    $email = $_COOKIE['u'];
    setcookie("u", "", time() - 3600);
    $DBhost = "localhost";
    $DBName = "my_easybuy20";
    mysql_connect($DBhost) or die("Impossibile collegarsi al server");
    mysql_select_db($DBName) or die("Impossibile connettersi al database $DBName");
    $sqlquery = "DELETE FROM UTENTE WHERE UTENTE.Email = '$email'";
    $result = mysql_query($sqlquery);
    echo "<script type='text/javascript'> alert('Utente eliminato correttamente...');
            location.href = 'index.php';
            </script>";
    @mysqli_free_result($result);
    @mysqli_close($conn);
}
?>

</html>