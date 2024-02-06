<?php include 'menu.php';?>
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
