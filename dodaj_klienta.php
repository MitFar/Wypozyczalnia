<html>
<head>
<meta charset="UTF-8">
    <link href="style2.css" rel="stylesheet">
</head>
<body>
	<nav>
  <ul>
    <li><a href="#">Klienci</a>
      <ul>
        <li><a href="klienci.php">Wyświetl rekordy</a></li>
        <li><a href="dodajklienta.php">Dodaj rekord</a></li>
		<li><a href="usun.php">Usuń rekord</a></li>
      </ul>
    </li>
    <li><a href="#">Maszyny</a>
      <ul>
        <li><a href="maszyny.php">Wyświetl rekordy</a></li>
        <li><a href="dodaj_maszyne.php">Dodaj rekord</a></li>
		<li><a href="usun_maszyne.php">Usuń rekord</a></li>
      </ul>
    </li>
    <li><a href="#">Umowy</a>
      <ul>
        <li><a href="umowy.php">Wyświetl rekordy</a></li>
        <li><a href="dodaj_umowe.php">Dodaj rekord</a></li>
		<li><a href="usun_umowe.php">Usuń rekord</a></li>
      </ul>
    </li>
	<li><a href="umowa_najmu_historia.php">Historia</a></li>
	<li><a href="#">Serwis</a>
      <ul>
        <li><a href="serwis.php">Wyświetl rekordy</a></li>
        <li><a href="dodaj_serwis.php">Dodaj rekord</a></li>
		
      </ul>
    </li>
    <li><a href="main.html">Strona główna</a></li>
  </ul>
</nav>
</body>
</html>


<?php

include 'polacz_z_baza.php';

$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$numer_dowodu_nip = $_POST['numer_dowodu_nip'];
$firma = $_POST['firma'];
$ulica = $_POST['ulica'];
$miejscowosc = $_POST['miejscowosc'];
$kod_pocztowy = $_POST['kod_pocztowy'];
$miasto = $_POST['miasto'];
$numer_tel = $_POST['numer_tel'];
$email = $_POST['email'];
$kto_wydal = $_POST['kto_wydal'];
$uwagi = $_POST['uwagi'];

$sql = "INSERT INTO klient (imie, nazwisko, numer_dowodu_nip, firma, ulica, miejscowosc, kod_pocztowy, miasto, numer_tel, email, kto_wydal, uwagi) VALUES ('$imie', '$nazwisko', '$numer_dowodu_nip', '$firma', '$ulica', '$miejscowosc', '$kod_pocztowy', '$miasto', '$numer_tel', '$email', '$kto_wydal', '$uwagi')";

if ($conn->query($sql) === TRUE) {
  echo "NOWY KLIENT ZOSTAŁ ZAPIANY W BAZIE DANYCH!";
} else {
  echo "Błąd: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
