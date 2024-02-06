<?php include 'menu.php';?>
<?php
	include 'polacz_z_baza.php';

	// sprawdzenie, czy dane zostały przesłane
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// pobranie wartości z formularza
		$id_klienta = isset($_POST['id_klienta']) ? $_POST['id_klienta'] : '';
		$typ_maszyny = isset($_POST['typ_maszyny']) ? $_POST['typ_maszyny'] : '';
		$model_maszyny = isset($_POST['model_maszyny']) ? $_POST['model_maszyny'] : '';
		$uwagi = isset($_POST['uwagi']) ? $_POST['uwagi'] : '';
		$data_przyjecia = isset($_POST['data_przyjecia']) ? $_POST['data_przyjecia'] : '';

		// zapytanie SQL do wstawienia rekordu
		$sql = "INSERT INTO serwis (typ_maszyny, model_maszyny, uwagi, id_klienta, data_przyjecia)
		VALUES ('$typ_maszyny', '$model_maszyny', '$uwagi', $id_klienta, '$data_przyjecia')";

		if ($conn->query($sql) === TRUE) {
		    echo "Dodano nowy rekord do tabeli serwis";
		} else {
		    echo "Błąd: " . $sql . "<br>" . $conn->error;
		}
	}

	$conn->close();
?>

<form method="post">
	<label>Klient:</label>
	<select name="id_klienta">
		<?php
			include 'polacz_z_baza.php';

			// zapytanie SQL
			$sql = "SELECT id_klienta, imie, nazwisko FROM klient";
			$result = $conn->query($sql);

			// wyświetlenie klientów w liście rozwijanej
			if ($result->num_rows > 0) {
			    while($row = $result->fetch_assoc()) {
			        echo "<option value=\"" . $row["id_klienta"] . "\">" . $row["imie"] . " " . $row["nazwisko"] . "</option>";
			    }
			} else {
			    echo "Brak klientów w bazie";
			}
			$conn->close();
		?>
	</select>
	<br><br>
	<label>Typ maszyny:</label>
	<input type="text" name="typ_maszyny">
	<br><br>
	<label>Model maszyny:</label>
	<input type="text" name="model_maszyny">
	<br><br>
	<label>Uwagi:</label>
	<input type="text" name="uwagi">
	<br><br>
	<label>Data przyjęcia:</label>
	<input type="date" name="data_przyjecia">
	<br><br>
	<input type="submit" name="dodaj" value="Dodaj">
</form>
