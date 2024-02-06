<!DOCTYPE html>
<html>
<head>
 <link href="style_umowy.css" rel="stylesheet">
</head>
<body>
<?php include 'menu_bez_css.php'; ?>
  <h1>Lista serwisów</h1>
<?php
 include 'polacz_z_baza.php';

  $sql = "SELECT serwis.id_serwisu, serwis.typ_maszyny, serwis.model_maszyny, serwis.uwagi, serwis.data_przyjecia,
                 klient.imie, klient.nazwisko, klient.numer_tel, klient.email, klient.kod_pocztowy
          FROM serwis 
          INNER JOIN klient ON serwis.id_klienta = klient.id_klienta";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
 
    echo "<table>";
    echo "<tr><th>ID serwisu</th><th>Typ maszyny</th><th>Model maszyny</th><th>Uwagi</th><th>Data przyjęcia</th><th>Klient</th><th></th><th></th><th></th></tr>";
    while($row = $result->fetch_assoc()) {
      echo "<tr><td>" . $row["id_serwisu"]. "</td><td>" . $row["typ_maszyny"]. "</td><td>" . $row["model_maszyny"]. "</td><td>" . $row["uwagi"]. "</td><td>" . $row["data_przyjecia"]. "</td><td><span>" . $row["imie"] . "</span>" . $row["nazwisko"] . " " . $row["numer_tel"] . " (" . $row["email"] . ", " . $row["kod_pocztowy"] . ") </td><td>
      <form method='post'>
        <button type='submit' name='usun' value='". $row["id_serwisu"] . "'>Usuń serwis</button>
      </form></td><td><form method='POST' action='generuj_pdf_serwis.php'><button type='submit' name='drukuj' value='drukuj'>Drukuj</button><input type='hidden' name='id_serwisu' value='" . $row["id_serwisu"] . "'></form></td><td><form method='POST' action='modyfikuj_serwis.php'><button type='submit' name='edytuj' value='". $row["id_serwisu"] ."'>Edytuj</button><input type='hidden' name='id_serwisu' value='" . $row["id_serwisu"] . "'></form></td></tr>";
    }
    echo "</table>";
  } else {
    echo "<p>Brak wyników</p>";
  }

  if(isset($_POST['usun'])){
    $id_serwisu = $_POST['usun'];
    $sql = "DELETE FROM serwis WHERE id_serwisu = " . $id_serwisu;

    if ($conn->query($sql) === TRUE) {
      echo "<p class='message'>Rekord usunięty</p>";
    } else {
      echo "<p class='message'>Błąd usuwania rekordu: " . $conn->error . "</p>";
    }
  }

  $conn->close();
?>
</body>
</html>
