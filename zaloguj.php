<?php

session_start();

if((!isset($_POST['login'])) ||(!isset($_POST['haslo'])))
{
    header('Location: index.php');
    exit();
}

require_once "connect.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno!=0)
{
 echo "Error: ".$polaczenie->connect_errno . " Opis: ". $polaczenie->connect_error;
}
 else {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
  
    /* sprawdzenie czy dziala mozna sobie wpisac:
     * echo "It works";
     */
    
    /* zabezpieczenie przed wtryskiwaniem obcego mysql: */
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");
       //rezultat=objekt         //kwerdena
    if($rezultat = @$polaczenie->query(
    sprintf("SELECT * FROM pracownicy, projekty, klienci, zadania WHERE user='%s'",
    mysqli_real_escape_string($polaczenie,$login))))
    {
      $ilu_userow = $rezultat->num_rows;
      if($ilu_userow>0)
      {
          $wiersz = $rezultat->fetch_assoc();
          
          if(password_verify($haslo, $wiersz['pass']))
          {
                $_SESSION['zalogowany'] = true;
                $_SESSION['user'] = $wiersz['user'];
                $_SESSION['Projekt'] = $wiersz['Projekt'];
                $_SESSION['Klient'] = $wiersz['Klient'];
                $_SESSION['Pracownik'] = $wiersz['imie_nazwisko'];
                $_SESSION['Zadanie'] = $wiersz['opis'];
                $_SESSION['Data_start'] = $wiersz['Data_start'];
                $_SESSION['Data_stop'] = $wiersz['Data_stop'];

                unset($_SESSION['blad']);
                $rezultat->free_result();
                /*przekierowanie do innego dokumnetu po logowaniu*/
                header('Location: strona1.php');
          }
          else 
          {
          $_SESSION['blad'] = '<span style="color:red">Nieprawidlowe hasło!</span>';
          header('Location: index.php');
          }
      } else {
          $_SESSION['blad'] = '<span style="color:red">Nieprawidlowy login lub hasło!</span>';
          header('Location: index.php');
    }

}
   $polaczenie->close();
 }
/* 
sprawdzenie, czy skrypt poprawnie czyta dane:
echo $login."<br />";
echo $haslo; 
*/
?>
