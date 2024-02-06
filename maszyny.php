<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link href="style2.css" rel="stylesheet">
	
</head>
<body>
<?php include 'menu_bez_css.php'; ?>
</body>
</html>
<?php
include 'polacz_z_baza.php';

$sql = "SELECT * FROM maszyna";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // tabela
    echo "<table>";
    echo "<tr><th>ID</th><th>Typ Maszyny</th><th>Model/Opis/Cena</th><th>Stan_wyp</th><th>Akcja</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>".$row["id_maszyny"]."</td>";
        echo "<td>".$row["typ_maszyny"]."</td>";
        echo "<td>".$row["model"]."</td>";
        echo "<td>".$row["stan_wyp"]."</td>";
        echo "<td><form method='post'><button type='submit' name='submit' value='".$row["id_maszyny"]."'>Na stanie</button></form></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Brak wyników.";
}

if (isset($_POST['submit'])) {
    $id_maszyny = $_POST['submit'];
    $sql = "UPDATE maszyna SET stan_wyp = 'Na stanie' WHERE id_maszyny = $id_maszyny";
    if (mysqli_query($conn, $sql)) {
        echo "Stan wypożyczenia zmieniony na 'Na stanie'.";
    } else {
        echo "Błąd podczas zmiany stanu wypożyczenia: " . mysqli_error($conn);
    }
}

mysqli_close($conn);


// wywołanie funkcji wyszukaj_klienta_po_imieniu
//wyszukaj_maszyne_po_typie();
//
	function wyszukaj_maszyne_po_typie() {
    
    if (isset($_POST['submit'])) {
        
        $typ_maszyny = $_POST['typ_maszyny'];
        
        $conn = mysqli_connect("localhost", "root", "", "Baza");
        
        if (!$conn) {
            die("Nieudane połączenie: " . mysqli_connect_error());
        }
        
        $sql = "SELECT * FROM maszyna WHERE typ_maszyny = '$typ_maszyny'";
        
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                echo
				"ID: " . $row["id_maszyny"]. " - Typ maszyny: " . $row["typ_maszyny"]. " - Model" . $row["model"]. "- stan_wyp: " . $row["stan_wyp"]."<br>";
            }
        } else {
            echo "Brak wyników";
        }
        
        mysqli_close($conn);
    }
    
    echo '<form method="post">';
    echo '<input type="text" name="typ_maszyny">';
    echo '<input type="submit" name="submit" value="Wyszukaj">';
    echo '</form>';
}
?>
</html>