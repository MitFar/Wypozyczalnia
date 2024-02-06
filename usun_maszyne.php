<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link href="style_umowy.css" rel="stylesheet">
	
</head>
<body>
<?php include 'menu_bez_css.php';?>
<head>
</head>
<body>
	<form method="post">
		<label>Typ maszyny:</label>
		<input type="text" name="imie">
		<input type="submit" name="submit" value="Wyszukaj">
	</form>

<?php
include 'polacz_z_baza.php';

$sql = "SELECT * FROM maszyna";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) > 0) {
    // tabela
    echo "<table>";
    echo "<tr><th>ID</th><th>Typ maszyny</th><th>Model</th><th>Stan</th><th>Akcja</th></tr>";
        while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["id_maszyny"]."</td><td>".$row["typ_maszyny"]."</td><td>".$row["model"]."</td><td>".$row["stan_wyp"]."</td><td><form method='post'><input type='hidden' name='delete' value='".$row["id_maszyny"]."'><input type='submit' value='Usuń maszynę'></form></td></tr>";
		
    }
    echo "</table>";
} else {
    echo "Brak wyników.";
}

mysqli_close($conn);
?>

<?php
// wywołanie funkcji wyszukaj_klienta_po_imieniu() i usun_klienta()
if (isset($_POST['submit'])) {
    wyszukaj_maszyne_po_typie();
}

if (isset($_POST['delete'])) {
    usun_klienta($_POST['delete']);
}
?>

<?php
// funkcja wyszukaj_klienta_po_imieniu() z dodanym przyciskiem "Usuń" przy każdym rekordzie
function wyszukaj_maszyne_po_typie() {
 
    include 'polacz_z_baza.php';

    $typ_maszyny = $_POST['imie'];

    $sql = "SELECT * FROM maszyna WHERE typ_maszyny = '$typ_maszyny'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Typ maszyny</th><th>Model</th><th>Stan</th><th>Akcja</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["typ_maszyny"]."</td>";
            echo "<td>".$row["model"]."</td>";
            echo "<td>".$row["stan_wyp"]."</td>";
            echo "<td><form method='post'><input type='hidden' name='delete' value='".$row["id_maszyny"]."'><input type='submit' value='Usuń maszynę'></form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Brak wyników wyszukiwania";
    }

    $conn->close();
}

function usun_klienta($id_maszyny) {

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "Baza";
    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // sprawdź czy maszyna o podanym ID istnieje w tabeli umowa_najmu_historii
    $sql_check = "SELECT * FROM umowa_najmu_historia WHERE maszyna_id = '$id_maszyny'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // jeśli istnieją powiązane rekordy w tabeli umowa_najmu_historii, usuń je
        $sql_delete = "DELETE FROM umowa_najmu_historia WHERE maszyna_id = '$id_maszyny'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Usunięto powiązane rekordy z tabeli umowa_najmu_historia.<br>";
        } else {
            echo "Błąd podczas usuwania powiązanych rekordów: " . $conn->error . "<br>";
        }
    }

    // usuń rekord z tabeli maszyna
    $sql = "DELETE FROM maszyna WHERE id_maszyny = '$id_maszyny'";

    if ($conn->query($sql) === TRUE) {
        echo "Rekord o id = $id_maszyny został usunięty.";
    } else {
        echo "Błąd: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
</body>
</html>