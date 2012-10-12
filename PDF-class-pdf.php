<?php

// ajouter nouvelle police :
// trouver une police en .ttf
// la convertir en .php et .z (google is your friend)
// copier dans /usr/share/php/fpdf/font/
// importer $pdf->AddFont('nom_a_utiliser','','nom_original_du_fichier_converti.php');

class PDF extends FPDF {

	function Header() {
		$this->Image('logo-crb-pdf.png',140,10,60);
		$this->SetFont('vera','',8);
		$this->Cell(0,0,'Croix-Rouge de Belgique');
		$this->Ln(4);
		$this->Cell(0,0,"Section locale d'Uccle");
		$this->Ln(4);
		$this->SetFont('vera','B',8);
		$this->Cell(0,0,"Service de Secours");
		$this->SetFont('vera','',8);
		$this->Ln(4);
		$this->Cell(0,0,"96 rue de Stalle");
		$this->Ln(4);
		$this->Cell(0,0,"1180 Uccle");
		$this->SetLineWidth(0.2);
		$this->Line(10,30,200,30);
		$this->ln(10);
	}

	function Footer() {
		global $numpg;
		if ($numpg>=1)
		{
			$this->SetFont('vera','',9);
			$this->SetXY(0,-17);
			$this->Cell(210,0,'page '.$this->PageNo().' sur {nb}',0,0,'C');
		}
	    $this->SetY(-15);
		$this->SetLineWidth(0.2);
		$this->Line(10,278,200,278);
		$this->SetFont('vera','',8);
		$this->Cell(13,0,'tel :',0,0,'R');
		$this->Cell(82,0,'+32 (0) 477 931 255');
		$this->SetFont('vera','',8);
		$this->Cell(95,0,'Banque ING :  IBAN BE90 3100 0858 8832',0,0,'R');
		$this->Ln(4);
		$this->Cell(13,0,'e-mail :',0,0,'R');
		$this->Cell(82,0,'arnaud.attout@gmail.com');
		$this->Cell(95,0,'Swift BBRUBEBB',0,0,'R');
	}

	function CheckPageBreak($h)
	{
    	//If the height h would cause an overflow, add a new page immediately
    	if($this->GetY()+$h>$this->PageBreakTrigger)
    	    $this->AddPage($this->CurOrientation);
	}

	function Fact_SautPage($h)
	{
    	if($this->GetY()+$h>$this->PageBreakTrigger)
    		{
			global $total;
			global $hl;
			$this->SetFillColor(191);
			$this->SetX(25);
			$this->SetLineWidth(0.2);
			$this->SetFont('vera','',10); $this->Cell(125,5, iconv('UTF-8', 'iso-8859-15', 'Sous-total page n°'.$this->PageNo().' à reporter'),'',0,'',true);
			$this->SetFont('veramono','',10); $this->Cell(35,5, number_format($total, 2, ',', ' ').iconv('UTF-8', 'iso-8859-15', ' €'),'',0,'R', true);
			$this->Ln($hl);
    	    $this->AddPage($this->CurOrientation);
			$this->Fact_TabTitre();
			$this->SetFillColor(191);
			$this->SetX(25);
			$this->SetLineWidth(0.2);
			$this->SetFont('vera','',10); $this->Cell(125,5, iconv('UTF-8', 'iso-8859-15', 'Sous-total page n°'.($this->PageNo()-1).' reporté'),'',0,'',true);
			$this->SetFont('veramono','',10); $this->Cell(35,5, number_format($total, 2, ',', ' ').iconv('UTF-8', 'iso-8859-15', ' €'),'',0,'R', true);
			$this->Ln($hl);
		}
	}

	function Fact_TabTitre()
	{
		global $hl;
		$this->SetFillColor(191);
		$this->SetX(25);
		$this->SetFont('vera','',10);
		$this->SetLineWidth(0.2);
		$this->Cell(70,5, iconv('UTF-8', 'iso-8859-15', 'Dénomination'),'TB',0,'', true);
		$this->Cell(20,5, iconv('UTF-8', 'iso-8859-15', 'Quantité'),'TB',0,'R', true);
		$this->Cell(35,5, iconv('UTF-8', 'iso-8859-15', 'Prix unitaire'),'TB',0,'R', true);
		$this->Cell(35,5, 'Montant','TB',0,'R', true);
		$this->Ln($hl);
	}

	function Fact_TabSousTitre($sstitre)
	{
		global $pause;
		global $hl;
		$this->Fact_SautPage(15);
		$this->SetFillColor(223);
		$this->SetX(25);
		$this->SetFont('vera','I',10);
		$this->Cell(160,5, $sstitre,'',0,'',($pause-1)%2);
		$this->Ln($hl);
	}

	function Fact_TabLigne($denom, $qtt, $prix, $mont)
	{
		global $hl;
		global $pause;
		global $factmulti;
		$this->Fact_SautPage($hl*3+$factmulti*$hl);
		$this->SetFillColor(223);
		$this->SetX(25);
		$this->SetFont('vera','',10); $this->Cell(70,5, $denom, 0, 0, 'L', ($pause-1)%2);
		$this->SetFont('veramono', '', 10);
		$this->Cell(20,5, $qtt, 0, 0, 'R', ($pause-1)%2);
		$this->Cell(35,5, $prix, 0, 0, 'R', ($pause-1)%2);
		$this->Cell(35,5, $mont, 0, 0, 'R', ($pause-1)%2);
		$this->SetFont('vera', '', 10);
		$this->Ln($hl);
	}

	function Signature()
	{
		$this->SetFillColor(255);
		$this->SetX(25);
		$this->SetFont('vera','',10); 
		$this->MultiCell(160,5,iconv('UTF-8', 'iso-8859-15', "Arnaud ATTOUT
Responsable du Service de Secours
Croix-Rouge d'Uccle"),0,0,'R');
	}
	
	function Paragraphe($text) {
		$this->SetX(25);
		$this->SetFont('vera','',10);
		$this->Multicell(160,5, $text);
		$this->Ln(5);
	}

	function CadreAdresse($text) {
		$this->SetX(105);
		$this->SetFont('vera','',10);
		$this->SetLineWidth(0.2);
		$this->MultiCell(80,5, $text,1,1);
		$this->Ln(6);
	}

	function LieuDate($date) {
		$this->SetX(185);
		$this->SetFont('vera','',10);
		$this->Cell(1,5, 'Uccle, le '.f_dh_format($date,'%e %B %Y'),0,0,'R');
		$this->Ln(10);
	}

	function Titre($text) {
		$this->SetX(25);
		$this->SetFont('vera','B',14);
		$this->SetLineWidth(0.2);
		$this->Cell(160,8, $text,'TB',0,'C');
		$this->Ln(14);
	}

}

?>
