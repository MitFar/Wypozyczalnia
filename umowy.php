<!DOCTYPE html>
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
    <li><a href="main.html">Main</a></li>
  </ul>
</nav>
</body>
<h1> &nbsp UMOWY </h1>
</html>
<?php
 include 'polacz_z_baza.php';

// jeśli przycisk "przenieś do historii" został naciśnięty
if(isset($_POST['przenies'])) {
    $id = $_POST['id_umowy'];
    
    // zapytanie SQL przenoszące rekord z tabeli umowa_najmu do tabeli umowa_najmu_historia
    $sql_przenies = "INSERT INTO umowa_najmu_historia (data_wynajmu, data_zwrotu, klient_id, maszyna_id) SELECT data_wynajmu, data_zwrotu, klient_id, maszyna_id FROM umowa_najmu WHERE id_umowy = '$id';";

    // wykonanie zapytania SQL
    if ($conn->query($sql_przenies) === TRUE) {
        // zapytanie SQL usuwające rekord z tabeli umowa_najmu
        $sql_usun = "DELETE FROM umowa_najmu WHERE id_umowy = '$id';";

        // wykonanie zapytania SQL
        if ($conn->query($sql_usun) === TRUE) {
            echo "Rekord został przeniesiony do tabeli umowa_najmu_historia.";
        } else {
            echo "Błąd usuwania rekordu: " . $conn->error;
        }
    } else {
        echo "Błąd przenoszenia rekordu: " . $conn->error;
    }
}

// zapytanie SQL łączące trzy tabele i wybierające odpowiednie kolumny
$sql = "SELECT umowa_najmu.id_umowy, klient.imie, klient.nazwisko, klient.numer_tel, maszyna.typ_maszyny, maszyna.model, umowa_najmu.data_wynajmu, umowa_najmu.data_zwrotu
        FROM umowa_najmu
        JOIN klient ON umowa_najmu.klient_id = klient.id_klienta
        JOIN maszyna ON umowa_najmu.maszyna_id = maszyna.id_maszyny";

// wykonanie zapytania SQL
$result = $conn->query($sql);

// wyświetlenie wyników w tabeli
if ($result->num_rows > 0) {
    echo "<table><tr><th>ID umowy</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Numer telefonu klienta</th><th>Typ maszyny</th><th>Model maszyny</th><th>Data wynajmu</th><th>Data zwrotu</th><th></th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["id_umowy"] . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["numer_tel"] . "</td><td>" . $row["typ_maszyny"] . "</td><td>" . $row["model"] . "</td><td>" . $row["data_wynajmu"] . "</td><td>" . $row["data_zwrotu"] . "</td><td><table><tr><td><form method='POST' action='generuj_pdf.php'><button type='submit' name='drukuj' value='drukuj'>Drukuj</button><input type='hidden' name='id_umowy' value='" . $row["id_umowy"] . "'></form></td><td><form method='POST'><button type='submit' name='przenies' value='przenies'>Przenieś do historii</button><input type='hidden' name='id_umowy' value='" . $row["id_umowy"] . "'></form></td></tr></table></td></tr>";
    }
    echo "</table>";
} else {
    echo "Brak wyników";
}

// zamknięcie połączenia z bazą danych
$conn->close();
?>