<?php
session_start();

require_once "connect.php";
mysqli_report(MYSQLI_REPORT_STRICT);

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
$rezultat2 = $polaczenie->query("SELECT * FROM roles"); 

if(isset($_POST['user']))
{
    //udana walidacja, tak!
    $wszystko_OK=true;

    //Sprawdzenie User
    $user = $_POST['user'];
    $ImieNazwisko = $_POST['imie_nazwisko'];
    $Email = $_POST['email'];
    $pass = $_POST['pass'];
    $Rola_wybrana = $_POST['roles'];
    
    //Sprawdzenie dlugosci nazwy projektu
    if((strlen($user)<3) || (strlen($user)>10))
    {
        $wszystko_OK=false;
        $_SESSION['e_user']="Login użytkownika musi zawierać od 3 do 10 znaków";
    }
    //sprawdzenie czy wszystkie znaki są alfanumeryczne, polskie ogonki
    if(ctype_alnum($user)==false)
    {
        $wszystko_OK=false;
        $_SESSION['e_user']="Login użytkownika nie moze zawierać polskich znaków, może składać się z liter i cyfr.";
    }
    //walidacja poprawności maila
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) ||($emailB!=$email))
    {
        $wszystko_OK=false;
        $_SESSION['e_email']="Podaj poprawny adres e-mail!";
    }
    
    //sprawdzanie poprawności hasła
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    
    if((strlen($pass1)<6) || (strlen($pass1)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_pass']="Hasło musi posiadać od 6 do 20 znaków";
    }
    
    if($pass1!=$pass2)
    {
        $wszystko_OK=false;
        $_SESSION['e_pass']="Podane hasła nie są identyczne";
    }
    
    $haslo_hash = password_hash("$pass1", PASSWORD_DEFAULT);
    /* robocze wyświetlanie Hasha przez php:
    echo $pass_hash; exit(); 
    */    
    
    try{
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception($polaczenie->connect_errno);
        }
        else
        {
            $rezultat = $polaczenie->query("SELECT * FROM pracownicy WHERE user='$user' or email='$Email'");
            if(!rezultat) throw new Exception($polaczenie->error);
            
            $ile_takich_Userow = $rezultat->num_rows; //ilosc zwroconych rekordow
            if($ile_takich_Userow>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_user']="Taki login/email już istnieje!";
            }
            
            $ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
		$wszystko_OK=false;
		$_SESSION['e_email']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		
            
            if($wszystko_OK==true)
            {
                //umieszenie danych w bazie!!!!!!!!!!!
             if($polaczenie->query("INSERT INTO pracownicy VALUES (NULL, '$user', '$ImieNazwisko', '$Email', '$haslo_hash', '$Rola_wybrana')"))
             {
               $_SESSION['udanaweryfikacja']=true;
               header('Location: pracownicy.php');
             }
             else
             {
               throw new Exception($polaczenie->error);  
             }
            }
            
            $polaczenie->close();
        }
        
    } catch (Exception $e) {
        echo '<span style="color:red;">Bląd Serwera - juhu</span>';
        echo '<br />Informacja developerska: '.$e;
    }
}
    

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" /> 
    <title>Project Tracker | Dodawanie nowego użytkownika</title>
    <meta name="description" content="....">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">

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
                 <a class="navbar-brand" href="#"><h2>Dodaj nowego użytkownika!</h2></a>
</nav>
    
      </header>
    <br>
    <form method="post">
        <label for="user">Login użytkownika: </label><br />
        <input type="text" name="user" placeholder="Podaj login" required>
        <?php
            if(isset($_SESSION['e_user']))
            {
                echo'<div class="error">'.$_SESSION['e_user'].'</div>';
                unset($_SESSION['e_user']);
            }
                    ?>  
        <br> 
        <label for="imie">Imię i nazwisko: </label><br />
        <input type="text" name="imie_nazwisko" placeholder="Podaj imię i nazwisko" required>
        <br> 
        <label for="email">Adres email: </label><br /> 
        <input type="email" name="email" placeholder="Podaj adres email" required>
        <br>
        <?php
            if(isset($_SESSION['e_email']))
            {
                echo'<div class="error">'.$_SESSION['e_email'].'</div>';
                unset($_SESSION['e_email']);
            }
                    ?> 

        <label for="pass">Hasło: </label><br /> 
        <input type="password" name="pass1" placeholder="Podaj hasło" required>
        <br> 
        <?php
            if(isset($_SESSION['e_pass']))
            {
                echo'<div class="error">'.$_SESSION['e_pass'].'</div>';
                unset($_SESSION['e_pass']);
            }
                    ?>
        <label for="pass_repeat">Powtórz hasło: </label><br /> 
        <input type="password" name="pass2" placeholder="Powtórz hasło" required>
        <br> 

        <label for="roles">Wybierz poziom uprawnień: </label>
        <select name="roles" >
                <?php
                    echo "<option value='0'>Wybierz</option>";
                    while($rows = $rezultat2 -> fetch_assoc())
                    {
                        $rolename = $rows['rolename'];  
                        $ID_Roles = $rows['ID_Roles'];
                        echo "<option value='$ID_Roles'>$rolename</option>";
                    }
                    //$polaczenie -> close();
                ?>
            </select>
            <br>
        <br>
        <input type="submit" name="nowyuser" value="DODAJ"> 
        <br><br>
        <a href="index.php" title="Powrót do poprzedniej strony">Powrót</a>
    </form>	  
</body>
</html>