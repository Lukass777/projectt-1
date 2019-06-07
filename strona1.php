<?php

session_start();

if(!isset($_SESSION['zalogowany']))
{
    header('Location: index.php');
    exit();
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Project Tracker - Aleksandra i Łukasz</title>
         <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <title>Witaj w aplikacji</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
    </head>
    <body>
        <header>
            <nav class="navbar bg-primary navbar-light">
                <a class="navbar-brand" href="#"><img src="kotek.jpg" width="30" height="30" alt=""> Projekty</a>
            <a class="navbar-brand" href="#">Klient</a>
            <a class="navbar-brand" href="dodajnowyuser.php">Pracownicy</a>
            <a class="navbar-brand" href="#">Zadania</a>
            <a class="navbar-brand" href="logout.php"><input type="button" value="Wylogowanie"</a>
            </nav>
             <nav class="navbar2 navbar-expand-lg navbar-light bg-light">
                 <a class="navbar-brand" href="#"><h2>Projekty w bazie</h2></a>
</nav>

        </header>
        <div id="pierwszy">
        <br />
<table width="90%" align="left" border="1" bordercolor="#d5d5d5" cellpadding="0" cellspacing="0">     
<tr>
        
        <?php
        echo "<p><h3>Witaj ".$_SESSION['user']."!</h3></p>";
        echo "<p><b>|Projekt</b>: ".$_SESSION['Projekt'];
        echo " <br /><b>|Klient</b>: ".$_SESSION['Klient'];
        echo " <br /><b>|Pracownik</b>: ".$_SESSION['Pracownik'];
        echo " <br /><b>|Zadanie</b>: ".$_SESSION['Zadanie'];
        echo " <br /><b>|Start</b>: ".$_SESSION['Data_start'];
        echo " <br /><b>|Stop</b>: ".$_SESSION['Data_stop']."</p>";
              
             
        //nawigacja za pomocą: json
        /*       
        function parseNodes($nodes) {
        $ul = "<ul>\n";
        foreach ($nodes as $node) {
                $ul .= parseNode($node);
        }
        $ul .= "</ul>\n";
        return $ul;
}

function parseNode($node) {
        $li = "\t<li>";
        $li .= '<a href="'.$node->url.'">'.$node->title.'</a>';
        if (isset($node->nodes)) $li .= parseNodes($node->nodes);
        $li .= "</li>\n";
        return $li;
}
$json = '[{
"title":"About",
"url":"/about",
"nodes":[
    {"title":"Staff","url":"/about/staff"},
    {"title":"Location","url":"/about/location"}
]},{
"title":"Contact",
"url":"/contact"
}]';
$nodes = json_decode($json);

$html = parseNodes($nodes);
echo $html;
*/

        ?>
    </tr>
        <br /><br />
        <a href="dodajnowyp.php"><input type="submit" value="Dodaj nowy Projekt!"></a>
        <br /><br />
        
        </tr></table>
        </div>
    </body>
</html>
