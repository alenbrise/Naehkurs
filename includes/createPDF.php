<?php

function generateBill($userID, $billID, $courseID) {
    include ("././res/fpdf/fpdf.php");
    $pdf = new FPDF(); //neues Objekt der Klasse FPDF
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->SetTextColor(255, 0, 0); //Textfarbe nach dem RGB-Farbschema
//x-Wert,y-Wert, Text, LBRT-Rahmen, wo weiter (1 neue Zeile)
    $pdf->Cell(100, 10, "Das ist ein pdf-Dokument!!", "BLTR", 0);
    $pdf->Cell(70, 30, "Das ist ein pdf-Dokument!!", "BLTR", 1);
    $pdf->SetFontSize(12);
    $pdf->SetTextColor(0, 0, 0);
    $text = $courseID.$userID.$billID."Jetzt folgt ein langer Text mit automatischem Zeilenumbruch. Dies wird nur mit der Methode write ausgegeben. Ich hoffe es reicht f&umlu;r einen Zeilenumbruch.";
//Zahl 5 bedeutet Zeilenabstand
    $pdf->Write(5, $text);
    $pdf->Ln(); //Zeilenumbruch
    //$pdf->Image("./img/stoffzentrale.jpg", 60, 50, 50);
    return base64_encode($pdf->Output("S", $billID . ".pdf")); 
}

?>