<html>
<head>
 <link href="style_umowy.css" rel="stylesheet">
</head>
<body>
<?php include 'menu_bez_css.php'; ?>
<?php
$typ_maszyny = $model_maszyny = $uwagi = $data_przyjecia = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["id_serwisu"])) {
    $id_serwisu = $_POST["id_serwisu"];

    if (isset($_POST["typ_maszyny"]) && isset($_POST["model_maszyny"]) && isset($_POST["uwagi"]) && isset($_POST["data_przyjecia"])) {
      include 'polacz_z_baza.php';

      $typ_maszyny = $_POST["typ_maszyny"];
      $model_maszyny = $_POST["model_maszyny"];
      $uwagi = $_POST["uwagi"];
      $data_przyjecia = $_POST["data_przyjecia"];

      $sql = "UPDATE serwis SET typ_maszyny = '$typ_maszyny', model_maszyny = '$model_maszyny', uwagi = '$uwagi', data_przyjecia = '$data_przyjecia' WHERE id_serwisu = $id_serwisu";

      if ($conn->query($sql) === TRUE) {
        echo "<p class='message'>Dane serwisu zostały zaktualizowane</p>";
      } else {
        echo "<p class='message'>Błąd aktualizacji danych serwisu: " . $conn->error . "</p>";
      }

      $conn->close();
    } else {
      echo "<p class='message'>Coś nie ten tego, ale jest git</p>";
    }
  }
} else {
  if (isset($_GET["id_serwisu"])) {
    $id_serwisu = $_GET["id_serwisu"];

    include 'polacz_z_baza.php';

    $sql = "SELECT * FROM serwis WHERE id_serwisu = $id_serwisu";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $typ_maszyny = $row["typ_maszyny"];
      $model_maszyny = $row["model_maszyny"];
      $uwagi = $row["uwagi"];
      $data_przyjecia = $row["data_przyjecia"];
    } else {
      echo "<p class='message'>Nie znaleziono serwisu o danym identyfikatorze</p>";
      exit;
    }

    $conn->close();
  }
}
?>

<html>
<body>
<?php
include 'polacz_z_baza.php';

if (isset($_POST['edytuj'])) {
  $id_serwisu = $_POST['edytuj'];

  $sql = "SELECT * FROM serwis WHERE id_serwisu = " . $id_serwisu;
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $typ_maszyny = $row['typ_maszyny'];
    $model_maszyny = $row['model_maszyny'];
    $uwagi = $row['uwagi'];
    $data_przyjecia = $row['data_przyjecia'];
  }
}

if (isset($_POST['zapisz'])) {
  $id_serwisu = $_POST['id_serwisu'];
  $typ_maszyny = $_POST['typ_maszyny'];
  $model_maszyny = $_POST['model_maszyny'];
  $uwagi = $_POST['uwagi'];
  $data_przyjecia = $_POST['data_przyjecia'];
  $sql = "UPDATE serwis SET typ_maszyny = '$typ_maszyny', model_maszyny = '$model_maszyny', uwagi = '$uwagi', data_przyjecia = '$data_przyjecia' WHERE id_serwisu = " . $id_serwisu;

  if ($conn->query($sql) === TRUE) {
    echo "<p class='message'>Dane serwisu zostały zaktualizowane.</p>";
  } else {
    echo "<p class='message'>Błąd aktualizacji danych serwisu: " . $conn->error . "</p>";
  }
}

$conn->close();
?>

<form method="post" action="">
  <input type="hidden" name="id_serwisu" value="<?php echo $id_serwisu; ?>">
  <label for="typ_maszyny">Typ maszyny:</label>
  <input type="text" name="typ_maszyny" value="<?php echo $typ_maszyny; ?>"><br>
  <label for="model_maszyny">Model maszyny:</label>
  <input type="text" name="model_maszyny" value="<?php echo $model_maszyny; ?>"><br>
  <label for="uwagi">Uwagi:</label>
  <textarea name="uwagi"><?php echo $uwagi; ?></textarea><br>
  <label for="data_przyjecia">Data przyjęcia:</label>
  <input type="text" name="data_przyjecia" value="<?php echo $data_przyjecia; ?>"><br>
  <button type="submit" name="zapisz">Zapisz</button>
</form>
</body>
</html>
