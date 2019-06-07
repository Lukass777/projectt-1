<?php

session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$rezultat2 = $polaczenie->query("SELECT * FROM klienci"); 
$rezultat3 = $polaczenie->query("SELECT * FROM pracownicy"); 

if(isset($_POST['Projekt']))
{
    //udana walidajca, tak!
    $wszystko_OK=true;
    
    //Sprawdzenie poprzez nazwe Projektu.
    $Projekt = $_POST['Projekt'];
    $ID_Klienta_wybrany = $_POST['klienci'];
    $ID_Pracownik_wybrany = $_POST['pracownicy'];
    $Data_start = $_POST['Data_start'];
    $Data_stop = $_POST['Data_stop'];

    //Sprawdzenie dlugosci usera
    if((strlen($Projekt)<3) || (strlen($Projekt)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_Projekt']="Projekt musi posiadać od 3 do 20 znaków";
    }
    
    if(ctype_alnum($Projekt)==false)
    {
        $wszystko_OK=false;
        $_SESSION['e_Projekt']="Projekt może skłdać się z liter i cyfr (bez polskich znaków)";
    }
    $haslo_hash = password_hash("admin1", PASSWORD_DEFAULT);
    /* robocze wyświtlanie Hasha przez php:
    echo $haslo_hash; exit(); 
    */
    
    // chekbox - czy dane sa poprawne: //
    if(!isset($_POST['akceptacja']))
        {
        $wszystko_OK=false;
        $_SESSION['e_akceptacja']="Zaznacz pole 'Dane są poprawne'";
    }
   
    try{
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name); 
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT * FROM projekty WHERE Projekt='$Projekt'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Projektow = $rezultat->num_rows; //ilosc zwróconych rekordow, stała wartość
            if($ile_takich_Projektow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_Projekt']="Nazwa projektu już istnieje!";
            }
            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO projekty VALUES (NULL, '$Projekt', '$ID_Klienta_wybrany', '$ID_Pracownik_wybrany', '$Data_start', '$Data_stop')"))
                                                          //Null bo jest ustawiony Autoincrement. Funkcja now() INTERVAL - do odlczania czasu - na pożniej.
             { 
               $_SESSION['udanaweryfikacja']=true;
               header('Location: gratulacje.php');
             }
             else
             {
               throw new Exception($polaczenie->error);  
             }
            }
            $polaczenie->close();
        }
        
    } catch (Exception $e) {
echo '<span style="color:red;">Bląd Serwera - juhuu</span>';
echo '<br />Informacja developerska: '.$e;
    }
    
    
       /* if($wszystko_OK==true)
        {
            //udana walidacja
            echo "Udana walidacja!"; exit();
        } */
        }
        
?>

<!DOCTYPE html>
<html lang ="pl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Dodawanie nowego Projektu </title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
        <link href="https://fonts.googleapis.com/css?family=Lobster|Open+Sans:400,700&amp;subset=latin-ext" rel="stylesheet">
    </head>
        <style>
            .error
            {
                color:red;
                margin-top: 10px;
                marginbottom: 10px;
            }
            </style>        
    </head>
    <body>
        <form method="post">
            Nazwa nowego projektu: <br/> <input type="text" name="Projekt" /><br />
            <?php
            if(isset($_SESSION['e_Projekt']))
            {
            echo'<div class="error">'.$_SESSION['e_Projekt'].'</div>';
            unset($_SESSION['e_Projekt']);
                    }
                    ?>
            Projekt dla klienta: <br />
            <select name="klienci" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat2 -> fetch_assoc())
                    {
                        $Klient = $rows['Klient'];  
                        $ID_Klienta = $rows['ID_Klienta'];  
                        echo "<option value='$ID_Klienta'>$Klient</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select>
            <br/><br />
           
            Właściciel projektu: <br />
            <select name="pracownicy" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat3 -> fetch_assoc())
                    {
                        $imie_nazwisko = $rows['imie_nazwisko'];  
                        $ID_Pracownik = $rows['ID_Pracownik'];
                        echo "<option value='$ID_Pracownik'>$imie_nazwisko</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select>
            <br><br />
            
            Data Start: <br/> <input type="date" name="Data_start" required/><br />
            Data Stop: <br/> <input type="date" name="Data_stop" required/><br />     
<!-- Formularz Hashowania hasła: <br/> <input type="password" name="haslo" /><br /> -->
            <?php
            if(isset($_SESSION['e_haslo']))
            {
            echo'<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
                    }
                    ?>
            <br />
            <label>
                <input type="checkbox" name="akceptacja" /> Dane są porawne
            </label><br />
            <?php
            if(isset($_SESSION['e_akceptacja']))
            {
            echo'<div class="error">'.$_SESSION['e_akceptacja'].'</div>';
            unset($_SESSION['e_akceptacja']);
                    }
                    ?>
            <br />
            <input type="submit" value="DODAJ" /><br />
            <br />
            
        </form>
        <a href="strona1.php"</a><input type="submit" value="POWRÓT" />
    </body>
</html>