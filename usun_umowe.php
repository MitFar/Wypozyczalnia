<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'menu.php';?>
<?php
 include 'polacz_z_baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $sql = "DELETE FROM umowa_najmu WHERE id_umowy = $id";

    if ($conn->query($sql) === TRUE) {
      echo "Rekord został usunięty";
    } else {
      echo "Błąd: " . $conn->error;
    }
  } else {
    echo "Nieprawidłowe żądanie";
  }
}

$sql = "SELECT umowa_najmu.id_umowy, klient.imie, klient.nazwisko, klient.numer_tel, maszyna.typ_maszyny, maszyna.model 
        FROM umowa_najmu
        INNER JOIN klient ON umowa_najmu.klient_id = klient.id_klienta
        INNER JOIN maszyna ON umowa_najmu.maszyna_id = maszyna.id_maszyny";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
  echo "<table>";
  echo "<tr><th>ID umowy</th><th>Imię</th><th>Nazwisko</th><th>Numer telefonu</th><th>Typ maszyny</th><th>Model</th><th>Akcja</th></tr>";
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["id_umowy"] . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["numer_tel"] . "</td><td>" . $row["typ_maszyny"] . "</td><td>" . $row["model"] . "</td><td><form action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'><input type='hidden' name='id' value='" . $row["id_umowy"] . "'><input type='submit' value='Usuń'></form></td></tr>";
  }
  echo "</table>";
} else {
  echo "Brak wyników";
}

$conn->close();
?>

