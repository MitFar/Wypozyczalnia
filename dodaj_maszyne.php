<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link href="style_dodaj_maszyne.css" rel="stylesheet">
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
</html>

<!-- Formularz HTML do dodawania rekordów -->
<form method="POST" action="dodaj_maszyne.php">
	<label>Typ maszyny:</label><br>
	<input type="text" name="typ_maszyny"><br>
	<label>Model:</label><br>
	<input type="text" name="model"><br>
	<label>Stan:</label><br>
	<input type="text" name="stan_wyp"><br>
	<input type="submit" value="Dodaj maszyne">
</form>

<?php
include 'polacz_z_baza.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $typ_maszyny = $_POST['typ_maszyny'];
  $model = $_POST['model'];
  $stan_wyp = $_POST['stan_wyp'];

  
  $sql = "INSERT INTO maszyna (typ_maszyny, model, stan_wyp) VALUES ('$typ_maszyny', '$model', '$stan_wyp')";

  if ($conn->query($sql) === TRUE) {
    echo "Nowa maszyna została dodana do bazy danych";
  } else {
    echo "Błąd: " . $sql . "<br>" . $conn->error;
  }
}

$conn->close();
?>
  </body>
</html>