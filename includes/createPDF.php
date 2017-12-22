<?php

function generateBill($userID, $billID, $courseID) {
    include ("././res/fpdf/fpdf.php");

    getDbConnection();

    $link = getDbConnection();

    $abfrage = "SELECT Anrede, Vorname, Nachname, Adresse, PLZ, Ort FROM `benutzer` WHERE $userID = Benutzer_ID";
    $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

    $userDetails = array();
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $userDetails[$key] = $value;
        }
    }
    
    $abfrage = "SELECT Kursname, Kursdatum, Preis FROM `kurs` WHERE $courseID=Kurs_ID";
    $res = mysqli_query($link, $abfrage) or die("Abfrage nicht geklappt");

    $courseDetails = array();
    while ($zeile = mysqli_fetch_Assoc($res)) {
        while (list($key, $value) = each($zeile)) {
            $courseDetails[$key] = $value;
        }
    }

    mysqli_close($link);
    
    $anrede = "";
    if($userDetails["Anrede"] == "female"){
        $anrede = "Sehr geehrte Frau";
    }else{
        $anrede = "Sehr geehrter Herr";
    }
    
    $pdf = new FPDF(); //neues Objekt der Klasse FPDF
    $pdf->AddPage();
    $pdf->SetFont('Helvetica', 'B', 16);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->SetFontSize(12);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Image("./res/img/stoffzentrale.jpg",10, 10, 20);
    $pdf->Cell(0,5,"Stoffzentrale Baden",0,1,'R');
    $pdf->Cell(0,5,"Weite Gasse 10",0,1,'R');
    $pdf->Cell(0,5,"5400 Baden",0,1,'R');
    $pdf->Cell(0,5,"www.stoffzentrale.ch",0,1,'R');
    $pdf->Cell(0,5,"info@stoffzentrale.ch",0,1,'R');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Cell(0,5, utf8_decode($userDetails["Vorname"]." ".$userDetails["Nachname"]), 0, 1, 'L');
    $pdf->Cell(0,5, utf8_decode($userDetails["Adresse"]), 0, 1, 'L');
    $pdf->Cell(0,5, utf8_decode($userDetails["PLZ"]." ".$userDetails["Ort"]), 0, 1, 'L');
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Helvetica','B',12);
    $pdf->write(7, utf8_decode(utf8_decode("Rechnung zum Kurs ".$courseDetails["Kursname"])));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->SetFont('Helvetica','',12);
    $pdf->write(7, utf8_decode($anrede." ".$userDetails["Nachname"]));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->write(7, utf8_decode("Besten Dank für Ihre Anmeldung zum Kurs ".$courseDetails["Kursname"]." am ".$courseDetails["Kursdatum"].". Bitte beachten Sie, dass Ihr Platz nur provisorisch reserviert ist. Um Ihre Buchung definitiv abzuschliessen, bitten wir Sie den offenen Rechnungsbetrag von CHF ".$courseDetails["Preis"].".- zu begleichen. Sobald die Zahlung bei uns eingetroffen ist, werden wir definitiv einen Platz für Sie freihalten und Sie wieder per E-Mail darüber informieren. Dazu bitten wir Sie den fälligen Betrag auf das untenstehende Konto zu überweisen."));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->write(7,"IBAN: CH 21 0000 0000 0000 0000 1, Meine Bank AG, 4600 Olten ");
    $pdf->Ln();
    $pdf->Ln();
    $pdf->write(7,utf8_decode("Besten Dank für Ihr Interesse und wir freuen uns, Sie an einem unserer Kurse begrüssen zu dürfen!"));
    $pdf->Ln();
    $pdf->Ln();
    $pdf->write(7,utf8_decode("Ihre Stoffzentrale"));

//Zahl 5 bedeutet Zeilenabstand
    //$pdf->Write(5, $text);
    $pdf->Ln(); //Zeilenumbruch
    $pdf->Image("./res/img/stoffzentrale.jpg",10, 10, 20);
    return base64_encode($pdf->Output("S", $billID . ".pdf"));
}

?>
