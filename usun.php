<html>
<head>
<meta charset="UTF-8">
    <link href="style_usuwanie.css" rel="stylesheet">
</head>
<body>
<?php include 'menu_bez_css.php';?>
<?php
include 'polacz_z_baza.php';

$sql = "SELECT * FROM klient";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // tabela
    echo "<table>";
    echo "<tr><th>ID</th><th>Imię</th><th>Nazwisko</th><th>Email</th><th>Dowód/Nip</th><th>firma</th><th>Ulica</th><th>Miejscowość</th><th>Kod pocztowy</th><th>Miasto</th><th>Numer tel</th><th>Email</th><th>kto wydał?</th><th>uwagii</th><th>Akcja</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["id_klienta"]."</td><td>".$row["imie"]."</td><td>".$row["nazwisko"]."</td><td>".$row["email"]."</td><td>".$row["numer_dowodu_nip"]."</td><td>".$row["firma"]."</td>
		<td>".$row["ulica"]."</td><td>".$row["miejscowosc"]."</td><td>".$row["kod_pocztowy"]."</td><td>".$row["miasto"]."</td><td>".$row["numer_tel"]."</td><td>".$row["email"]."</td><td>".$row["kto_wydal"]."</td><td>".$row["uwagi"]."</td><td><form method='post'><input type='hidden' name='delete' value='".$row["id_klienta"]."'><input type='submit' value='Usuń'></form></td></tr>";
		
    }
    echo "</table>";
} else {
    echo "Brak wyników.";
}

// sprawdzenie czy naciśnięto przycisk "Usuń"
if (isset($_POST['delete'])) {
	usun_klienta($_POST['delete']);
}

mysqli_close($conn);
?>

<?php

function usun_klienta($id) { //usuwa klienta z bazy
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Baza";

    $conn = mysqli_connect($host, $username, $password, $dbname);

    if (!$conn) {
        die("Nie udało się połączyć z bazą danych: " . mysqli_connect_error());
    }

    // wyłączanie sprawdzania kluczy obcych (foreign key checks)
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 0");

    // usuwanie rekordów powiązanych z klientem w tabelach zależnych
    $sql1 = "DELETE FROM umowa_najmu_historia WHERE klient_id = $id";
    $sql2 = "DELETE FROM umowa_najmu WHERE klient_id = $id";
    $sql3 = "DELETE FROM serwis WHERE id_klienta = $id";

    // usuwanie klienta
    $sql4 = "DELETE FROM klient WHERE id_klienta = $id";

    // usuwanie rekordów powiązanych
    mysqli_query($conn, $sql1);
    mysqli_query($conn, $sql2);
    mysqli_query($conn, $sql3);

    // usuwanie klienta i informowanie użytkownika o sukcesie lub błędzie
    if (mysqli_query($conn, $sql4)) {
        echo "Klient o ID $id został pomyślnie usunięty!";
    } else {
        echo "Błąd podczas usuwania klienta: " . mysqli_error($conn);
    }

    // włączanie sprawdzania kluczy obcych (foreign key checks)
    mysqli_query($conn, "SET FOREIGN_KEY_CHECKS = 1");

    mysqli_close($conn);
}
?>

</body>
</html>