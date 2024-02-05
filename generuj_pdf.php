<?php
header('Content-Type: text/html; charset=utf-8');
require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu','',10);

// dane firmy
$nazwa_firmy = 'Wynajmix S.A.';
$adres = 'Wrocław 32, 32-421';
$telefony = '+999 999 999';
$nip = '9999999999';
$godziny_pracy = 'Godziny pracy: 9:00 - 10:00, Sobota 10:00 - 11:00';
$email = 'prawdziwyemail.@małpa.pl';

// tabela wynajmujący
$wynajmujacy = array(
    'Firma' => 'Wynajmix S.A.',
    'Adres' => 'Wrocław 32, 32-421',
    'Telefon' => '+999 999 999',
    'NIP' => '9999999999',
    'Godziny pracy' => 'Godziny pracy: 9:00 - 10:00, Sobota 10:00 - 11:00',
    'Email' => 'prawdziwyemail.@małpa.pl'
);

include 'polacz_z_baza.php';

$id = $_POST['id_umowy'];

// pobranie danych z bazy
$sql = "SELECT umowa_najmu.id_umowy, klient.imie, klient.nazwisko, klient.numer_dowodu_nip, klient.firma, klient.ulica, klient.miejscowosc, klient.kod_pocztowy, klient.miasto, klient.numer_tel, klient.email, maszyna.typ_maszyny, maszyna.model, maszyna.stan_wyp, umowa_najmu.data_wynajmu, umowa_najmu.data_zwrotu
        FROM umowa_najmu
        JOIN klient ON umowa_najmu.klient_id = klient.id_klienta
        JOIN maszyna ON umowa_najmu.maszyna_id = maszyna.id_maszyny
        WHERE umowa_najmu.id_umowy = $id";

$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("Nie znaleziono rekordu w bazie !");
}

$row = $result->fetch_assoc();

// tabela najemca
$najemca = array(
    'Imie' => $row['imie'],
    'Nazwisko' => $row['nazwisko'],
    'PESEL/NIP' => $row['numer_dowodu_nip'],
    'Adres' => $row['miasto'] . ', ' . $row['ulica'],
    'Kod pocztowy' => $row['kod_pocztowy'],
    'Miasto' => $row['miejscowosc'],
    'Telefon' => $row['numer_tel'],
    'Email' => $row['email']
);

// tabela przedmiot najmu
$przedmiot_najmu = array(
    'Przedmiot' => $row['typ_maszyny'] . ' - ' . $row['model'],
);

// tabela data najmu
$data_najmu = array(
    'Data wynajmu' => $row['data_wynajmu'],
    'Data zwrotu' => $row['data_zwrotu']
);

// uwagi
$uwagi = '';

//$pdf->AddFont('helvetica', '', 'helvetica.php');
$pdf->SetFont('DejaVu','',10);

// nagłówek
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(0, 12, $nazwa_firmy, 0, 1, 'C');
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 6, $adres . ' | ' . $telefony . ' | ' . $email, 0, 1, 'C');
$pdf->Cell(0, 6, $godziny_pracy, 0, 1, 'C');
$pdf->Ln(12);

// tabela wynajmujący
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 8, 'Wynajmujacy', 'B', 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($wynajmujacy as $key => $value) {
    $pdf->Cell(35, 8, $key, 0, 0, 'L');
    $pdf->Cell(70, 8, $value, 0, 1, 'L');
}
$pdf->Ln(6);

// tabela najemca
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 8, 'Najemca', 'B', 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($najemca as $key => $value) {
    $pdf->Cell(35, 8, $key, 0, 0, 'L');
    $pdf->Cell(70, 8, $value, 0, 1, 'L');
}
$pdf->Ln(6);

// tabela przedmiot najmu
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 8, 'Przedmiot najmu', 'B', 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($przedmiot_najmu as $key => $value) {
    $pdf->Cell(35, 8, $key, 0, 0, 'L');
    $pdf->Cell(70, 8, $value, 0, 1, 'L');
}
$pdf->Ln(6);

// tabela data najmu
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 8, 'Data najmu', 'B', 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($data_najmu as $key => $value) {
    $pdf->Cell(43.5, 8, $key, 0, 0, 'L');
    $pdf->Cell(43.5, 8, $value, 0, 0, 'L');
}
$pdf->Ln(6);

// uwagi
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 8, 'Uwagi', 'B', 1, 'L');
$pdf->SetFont('DejaVu','',10);
$pdf->MultiCell(0, 8, $uwagi, 0, 'L', false);
// obszar podpisów
$pdf->Ln(20);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(80, 10, '..........................................', 0, 0, 'L');
$pdf->Cell(80, 10, '..........................................', 0, 1, 'R');
$pdf->Cell(80, 5, 'Podpis najemcy', 0, 0, 'L');
$pdf->Cell(80, 5, 'Podpis wynajmującego', 0, 1, 'R');


$filename = "umowa_klient_" . $row['id_umowy'] . ".pdf";
$pdf->Output($filename, 'D');

$conn->close();
?>
