<?php
    include 'polacz_z_baza.php';

    $typ_maszyny = mysqli_real_escape_string($conn, $_POST['typ_maszyny']);

    $sql_model = "SELECT id_maszyny, model FROM maszyna WHERE typ_maszyny = '$typ_maszyny'";
    $result_model = mysqli_query($conn, $sql_model);

    $output = "";
    while ($row_model = mysqli_fetch_assoc($result_model)) {
        $output .= "<option value='" . $row_model['id_maszyny'] . "'>" . $row_model['model'] . "</option>";
    }

    mysqli_close($conn);

    echo $output;
?>
