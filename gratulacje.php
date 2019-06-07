<?php

session_start();

if(!isset($_SESSION['udanaweryfikacja']))
{
    header('Location: index.php');
    exit();
}
 else    
 {
     unset($_SESSION['udanaweryfikacja']);
 }
 
?>
<!DOCTYPE html>
<html lang ="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>ProjectTracker</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    </head>
    <body>
        <div><br />
            <h2>Dziękujemy za poprawne wprowadzenie nowego klienta! <b><br />Project Tracker!</b></h2><br />
        
            <a href="index.php">Powrót na strone główną!</a>
            <br /><br />
        </div>
    </body>
</html>