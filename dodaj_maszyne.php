<?php include 'menu.php';
?>

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