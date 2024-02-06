<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link href="style2.css" rel="stylesheet">
</head>
<body>
<?php include 'menu_bez_css.php';?>
</body>
</html>
<?php
include 'polacz_z_baza.php';
// zapytanie SQL łączące trzy tabele i wybierające odpowiednie kolumny
$sql = "SELECT umowa_najmu_historia.id_umowy_historia, klient.imie, klient.nazwisko, klient.numer_tel, klient.email, klient.firma, maszyna.typ_maszyny, maszyna.model, umowa_najmu_historia.data_wynajmu, umowa_najmu_historia.data_zwrotu
        FROM umowa_najmu_historia
        JOIN klient ON umowa_najmu_historia.klient_id = klient.id_klienta
        JOIN maszyna ON umowa_najmu_historia.maszyna_id = maszyna.id_maszyny";



$result = $conn->query($sql);

// tabela
if ($result->num_rows > 0) {
    echo "<table><tr><th>ID umowy</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Numer telefonu klienta</th><th>Email klienta</th><th>Firma klienta</th><th>Typ maszyny</th><th>Model maszyny</th><th>Data wynajmu</th><th>Data zwrotu</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>" . $row["id_umowy_historia"] . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["numer_tel"] . "</td><td>" . $row["email"] . "</td><td>" . $row["firma"] . "</td><td>" . $row["typ_maszyny"] . "</td><td>" . $row["model"] . "</td><td>" . $row["data_wynajmu"] . "</td><td>" . $row["data_zwrotu"] . "</td></tr>";
  }
  
    echo "</table>";
} else {
    echo "Brak wyników";
}
$conn->close();

?>