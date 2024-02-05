<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <link href="style2.css" rel="stylesheet">
	<style>
	nav {
background-color: #f7f7f7;
display: flex;
justify-content: space-between;
align-items: center;
padding: 1em;
font-family: Arial, sans-serif;
font-weight: bold;
}

nav a {
color: #333;
text-decoration: none;
margin: 0 1em;
transition: color 0.3s ease-in-out;
}

nav a:hover {
color: #555;
}

nav ul {
list-style: none;
margin: 0;
padding: 0;
display: flex;
align-items: center;
}

nav ul li {
position: relative;
}

nav ul li a {
display: block;
padding: 0.5em 1em;
}

nav ul li:hover > ul {
display: block;
}

nav ul ul {
display: none;
position: absolute;
top: 100%;
left: 0;
background-color: #fff;
padding: 0.5em 0;
box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

nav ul ul li {
display: block;
width: 200px;
}

nav ul ul li a {
display: block;
padding: 0.25em 1em;
}

nav ul ul li a:hover {
background-color: #f7f7f7;
}


</style>
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
    <li><a href="main.html">Strona główna</a></li>
  </ul>
</nav>
</body>
</html>
<h1> &nbsp HISTORIA </h1>
<?php
include 'polacz_z_baza.php';
// zapytanie SQL łączące trzy tabele i wybierające odpowiednie kolumny
$sql = "SELECT umowa_najmu_historia.id_umowy_historia, klient.imie, klient.nazwisko, klient.numer_tel, klient.email, klient.firma, maszyna.typ_maszyny, maszyna.model, umowa_najmu_historia.data_wynajmu, umowa_najmu_historia.data_zwrotu
        FROM umowa_najmu_historia
        JOIN klient ON umowa_najmu_historia.klient_id = klient.id_klienta
        JOIN maszyna ON umowa_najmu_historia.maszyna_id = maszyna.id_maszyny";



$result = $conn->query($sql);

// tabela
if ($result->num_rows > 0) {
    echo "<table><tr><th>ID umowy</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Numer telefonu klienta</th><th>Email klienta</th><th>Firma klienta</th><th>Typ maszyny</th><th>Model maszyny</th><th>Data wynajmu</th><th>Data zwrotu</th></tr>";
    while ($row = $result->fetch_assoc()) {
      echo "<tr><td>" . $row["id_umowy_historia"] . "</td><td>" . $row["imie"] . "</td><td>" . $row["nazwisko"] . "</td><td>" . $row["numer_tel"] . "</td><td>" . $row["email"] . "</td><td>" . $row["firma"] . "</td><td>" . $row["typ_maszyny"] . "</td><td>" . $row["model"] . "</td><td>" . $row["data_wynajmu"] . "</td><td>" . $row["data_zwrotu"] . "</td></tr>";
  }
  
    echo "</table>";
} else {
    echo "Brak wyników";
}
$conn->close();

?>