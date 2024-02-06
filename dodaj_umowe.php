<?php include 'menu.php';?>
<form action="dodaj_umowe.php" method="post">
    <label for="klient">Wybierz klienta:</label>
    <select name="klient" id="klient">
        <?php
            include 'polacz_z_baza.php';

            $sql_klient = "SELECT id_klienta, imie, nazwisko FROM klient";
            $result_klient = mysqli_query($conn, $sql_klient);

            // wyświetlenie opcji w rozwijanym menu dla każdego rekordu z tabeli klient
            while ($row_klient = mysqli_fetch_assoc($result_klient)) {
                echo "<option value='" . $row_klient['id_klienta'] . "'>" . $row_klient['imie'] . " " . $row_klient['nazwisko'] . "</option>";
            }
        ?>
    </select>
    <br>
    <label for="typ_maszyny">Wybierz typ maszyny:</label>
    <select name="typ_maszyny" id="typ_maszyny">
        <?php
            // zapytanie o rekordy z tabeli maszyna
            $sql_typ_maszyny = "SELECT DISTINCT typ_maszyny FROM maszyna";
            $result_typ_maszyny = mysqli_query($conn, $sql_typ_maszyny);

            // wyświetlenie opcji w rozwijanym menu dla każdego rekordu z tabeli maszyna
            while ($row_typ_maszyny = mysqli_fetch_assoc($result_typ_maszyny)) {
                echo "<option value='" . $row_typ_maszyny['typ_maszyny'] . "'>" . $row_typ_maszyny['typ_maszyny'] . "</option>";
            }
        ?>
    </select>
    <br>
    <label for="model">Wybierz model maszyny:</label>
    <select name="model" id="model" disabled>
    </select>
    <br>
    <!-- formularz na daty wynajmu i zwrotu -->
    <label for="data_wynajmu">Data wynajmu:</label>
    <input type="date" name="data_wynajmu" id="data_wynajmu" min="<?= date('Y-m-d'); ?>">
    <br>
    <label for="data_zwrotu">Data zwrotu:</label>
    <input type="date" name="data_zwrotu" id="data_zwrotu" min="<?= date('Y-m-d'); ?>">
    <br>
    <input type="submit" value="Dodaj umowę">
</form>


   <?php
    if (isset($_POST['klient']) && isset($_POST['model']) && isset($_POST['data_wynajmu']) && isset($_POST['data_zwrotu'])) {
        include 'polacz_z_baza.php';

        $klient_id = mysqli_real_escape_string($conn, $_POST['klient']);
        $maszyna_id = mysqli_real_escape_string($conn, $_POST['model']);
        $data_wynajmu = mysqli_real_escape_string($conn, $_POST['data_wynajmu']);
        $data_zwrotu = mysqli_real_escape_string($conn, $_POST['data_zwrotu']);

        if ($data_wynajmu < date('Y-m-d') || $data_zwrotu <= $data_wynajmu) {
    echo "Nieprawidłowe daty. Data wynajmu musi być większa lub równa dzisiejszej dacie, a data zwrotu musi być większa niż data wynajmu.";
    exit();
}


        $sql_sprawdz_wypozyczenie = "SELECT * FROM umowa_najmu WHERE maszyna_id = '$maszyna_id' AND data_zwrotu > NOW()";
        $wynik_sprawdz_wypozyczenie = mysqli_query($conn, $sql_sprawdz_wypozyczenie);

        if (mysqli_num_rows($wynik_sprawdz_wypozyczenie) > 0) {
			$row = mysqli_fetch_assoc($wynik_sprawdz_wypozyczenie);
			$data_zwrotu_wyp = $row['data_zwrotu'];
			echo "Maszyna o ID $maszyna_id jest aktualnie wypożyczona. Planowany zwrot: $data_zwrotu_wyp";
			exit();
		}

        $sql_dodaj_umowe = "INSERT INTO umowa_najmu (data_wynajmu, data_zwrotu, klient_id, maszyna_id) VALUES ('$data_wynajmu', '$data_zwrotu', '$klient_id', '$maszyna_id')";
        if (mysqli_query($conn, $sql_dodaj_umowe)) {
            echo "Umowa najmu została dodana.";
        } else {
            echo "Błąd dodawania umowy najmu: " . mysqli_error($conn);
        }

		$sql_aktualizuj_stan = "UPDATE maszyna SET stan_wyp = 'wypożyczony' WHERE id_maszyny = '$maszyna_id'";
		mysqli_query($conn, $sql_aktualizuj_stan);

        mysqli_close($conn);
    }
?>



<script>
    var typ_maszyny = document.getElementById("typ_maszyny");
    var model = document.getElementById("model");

    typ_maszyny.addEventListener("change", function() {
        model.disabled = true;
        model.innerHTML = "<option>Wczytywanie modeli...</option>";

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "pobierz_modele.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                model.innerHTML = xhr.responseText;
                model.disabled = false;
            }
        };
        xhr.send("typ_maszyny=" + encodeURIComponent(typ_maszyny.value));
    });
</script>
	

</html>

	
