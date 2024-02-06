<?php
header('Content-Type: text/html; charset=utf-8');
require('tfpdf.php');

$pdf = new tFPDF();
$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);


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

$id = $_POST['id_serwisu'];

// pobranie danych z bazy
$sql = "SELECT serwis.id_serwisu, serwis.typ_maszyny, serwis.model_maszyny, serwis.uwagi, serwis.data_przyjecia,
        klient.imie, klient.nazwisko, klient.numer_dowodu_nip, klient.firma, klient.ulica, klient.miejscowosc, klient.kod_pocztowy, klient.miasto, klient.numer_tel, klient.email
        FROM serwis 
        INNER JOIN klient ON serwis.id_klienta = klient.id_klienta
        WHERE serwis.id_serwisu = $id";



$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    die("Nie znaleziono rekordu w bazie !");
}

$row = $result->fetch_assoc();
// nagłówek
$pdf->SetFont('DejaVu','',14);
$pdf->Cell(0, 12, $nazwa_firmy, 0, 1, 'C');
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(0, 6, $adres . ' | ' . $telefony . ' | ' . $email, 0, 1, 'C');
$pdf->Cell(0, 6, $godziny_pracy, 0, 1, 'C');
$pdf->Ln(12);

// tabela najemca
$najemca = array(
'Imię i nazwisko:' => $row['imie'] . ' ' . $row['nazwisko'] . ' ' . $row['firma'],
'Adres:' => $row['miasto'] . ' ' . $row['ulica'] . ' ' . $row['kod_pocztowy'] . ' ' . $row['miejscowosc'],
'Numer telefonu:' => $row['numer_tel'],
'Numer PESEL/NIP:' => $row['numer_dowodu_nip'],
'Email:' => $row['email'],
);

// tabela przedmiot najmu
$przedmiot_najmu = array(
'Przedmiot:' => $row['typ_maszyny'] . ' - ' . $row['model_maszyny'],
'Data przyjecia:' => $row['data_przyjecia'],
'Uwagi:' => $row['uwagi']
);

// tabela wynajmujący
$pdf->SetFont('DejaVu','',12);
$pdf->Cell(0, 10, 'Serwis', 0, 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($wynajmujacy as $key => $value) {
$pdf->Cell(35, 8, $key, 0, 0, 'L');
$pdf->Cell(70, 8, $value, 0, 1, 'L');
}
$pdf->Ln(6);
$pdf->Cell(0, 0, '', 'B', 1, 'C'); // dodanie linii

// tabela najemca
$pdf->SetFont('DejaVu','',12);
$pdf->Cell(0, 10, 'Klient', 0, 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($najemca as $key => $value) {
$pdf->Cell(35, 8, $key, 0, 0, 'L');
$pdf->Cell(70, 8, $value, 0, 1, 'L');
}
$pdf->Ln(6);
$pdf->Cell(0, 0, '', 'B', 1, 'C'); // dodanie linii

$pdf->SetFont('DejaVu','',12);
$pdf->Cell(0, 10, 'Przedmiot serwisu', 0, 1, 'L');
$pdf->SetFont('DejaVu','',10);
foreach ($przedmiot_najmu as $key => $value) {
$pdf->Cell(35, 8, $key, 0, 0, 'L');
$pdf->Cell(70, 8, $value, 0, 1, 'L');
}
$pdf->Ln(6);
$pdf->Cell(0, 0, '', 'B', 1, 'C'); // dodanie linii

// obszar podpisów
$pdf->Ln(20);
$pdf->SetFont('DejaVu','',10);
$pdf->Cell(80, 10, '..........................................', 0, 0, 'L');
$pdf->Cell(80, 10, '..........................................', 0, 1, 'R');
$pdf->Cell(80, 5, 'Serwisant', 0, 0, 'L');
$pdf->Cell(80, 5, 'Podpis', 0, 1, 'R');


$filename = "serwis_klient_" . $row['id_serwisu'] . ".pdf";
$pdf->Output($filename, 'D');

$pdf->Output();
?>