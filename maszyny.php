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
<h1> &nbsp MASZYNY </h1>
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