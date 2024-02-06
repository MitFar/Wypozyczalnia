<?php include 'menu.php';?>
<?php
include 'polacz_z_baza.php';

//dodaj dane
function dodaj_rekordy($imie, $nazwisko, $email) {
    global $conn;
    $sql = "INSERT INTO klienci (imie, nazwisko, email) VALUES ('$imie', '$nazwisko', '$email')";
    if (mysqli_query($conn, $sql)) {
        echo "Rekord dodany pomyślnie.";
    } else {
        echo "Błąd: " . $sql . "<br>" . mysqli_error($conn);
    }
}

// sprawdzenie czy formularz został wysłany
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $imie = $_POST["imie"];
    $nazwisko = $_POST["nazwisko"];
    $email = $_POST["email"];
    
    dodaj_rekordy($imie, $nazwisko, $email);
}

mysqli_close($conn);
?>

<!-- Formularz HTML do dodawania rekordów -->
    <form method="POST" action="dodaj_klienta.php">
		<label>Imię:</label><br>
		<input type="text" name="imie"><br>
		<label>Nazwisko:</label><br>
		<input type="text" name="nazwisko"><br>
		<label>Numer dowodu/NIP:</label><br>
		<input type="text" name="numer_dowodu_nip"><br>
		<label>Firma:</label><br>
		<input type="text" name="firma"><br>
		<label>Ulica:</label><br>
		<input type="text" name="ulica"><br>
		<label>Miejscowość:</label><br>
		<input type="text" name="miejscowosc"><br>
		<label>Kod pocztowy:</label><br>
		<input type="text" name="kod_pocztowy"><br>
		<label>Miasto:</label><br>
		<input type="text" name="miasto"><br>
		<label>Numer telefonu:</label><br>
		<input type="text" name="numer_tel"><br>
		<label>Adres e-mail:</label><br>
		<input type="email" name="email"><br>
		<label>Kto dodał:</label><br>
		<input type="text" name="kto_wydal"><br>
		<label>Uwagi:</label><br>
		<input type="text" name="uwagi"><br>
		<input type="submit" value="Dodaj klienta">
	</form>