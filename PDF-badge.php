<?

require('/usr/share/php/fpdf/fpdf.php');

class PageBadge extends FPDF
{
	function badge($x, $y, $q, $c)
	{
		// découpe
		$this->Line($x-5,$y,$x-1,$y);
		$this->Line($x,$y-5,$x,$y-1);
		$this->Line($x-5,$y+54,$x-1,$y+54);
		$this->Line($x,$y+59,$x,$y+55);

		$this->Line($x+91,$y,$x+87,$y);
		$this->Line($x+86,$y-5,$x+86,$y-1);
		$this->Line($x+91,$y+54,$x+87,$y+54);
		$this->Line($x+86,$y+59,$x+86,$y+55);

		// cadre
		//$pdf->Rect(20,20,86,54);

		// logo CRB
		$this->Image('logo-crb-pdf.png',$x+50,$y+3,32);

		// demi-fond rouge
		$this->SetFillColor(255,0,0);
		$this->SetXY($x,$y+27);
		$this->Rect($x, $y+27, 86, 27, 'F') ;

		// cadre principal qualification
		$this->SetFont('vera','B',16);
		$this->SetFillColor(0,0,0);
		$this->Rect($x+4, $y+12, 78, 10, 'F') ;
		$this->SetFillColor(255,255,255);
		$this->Rect($x+4.5, $y+12.5, 77, 9, 'F') ;

		// texte qualification
		$this->SetXY($x+5,$y+13);
		$this->SetTextColor(0,0,0);
		$this->Cell(76,8,"$q[0]",0,0,'C');

		// sous qualifications
		$this->SetFillColor(0,0,0);
		$this->SetFont('vera','B',8);
		$this->SetTextColor(255,255,255);
		for($i=0; $i<=4; $i++)
		{
			if (!empty($q[$i+1])) {
				$this->Rect($x+4+$i*16,$y+21,14,5,'F');
				$this->SetXY($x+4+$i*16,$y+23.5);
				$this->Cell(14,0,$q[$i+1],0,0,'C');
			}
		}

		// coordonnées
		$this->SetFont('vera','',8);
		$this->SetXY($x,$y+30); $this->Cell(25,0,"Nom :",0,0,'R');
		$this->SetXY($x,$y+33); $this->Cell(25,0,"Prénom :",0,0,'R');
		$this->SetXY($x,$y+36); $this->Cell(25,0,"Né le :",0,0,'R');
		$this->SetXY($x,$y+40); $this->Cell(25,0,"Zone :",0,0,'R');
		$this->SetXY($x,$y+43); $this->Cell(25,0,"Section :",0,0,'R');
		$this->SetXY($x,$y+46); $this->Cell(25,0,"Fonction :",0,0,'R');
		$this->SetXY($x,$y+50); $this->Cell(25,0,"Matricule :",0,0,'R');

		$this->SetFont('vera','B',8);
		$this->SetXY($x+26,$y+30); $this->Cell(25,0,$c[0]);
		$this->SetXY($x+26,$y+33); $this->Cell(25,0,$c[1]);
		$this->SetXY($x+26,$y+36); $this->Cell(25,0,$c[2]);
		$this->SetXY($x+26,$y+40); $this->Cell(25,0,$c[3]);
		$this->SetXY($x+26,$y+43); $this->Cell(25,0,$c[4]);
		$this->SetXY($x+26,$y+46); $this->Cell(25,0,$c[5]);
		$this->SetXY($x+26,$y+50); $this->Cell(25,0,$c[6]);
	}
}

function check($d,$data)
{
	include('PDF-badge-arraychecks.php');
//	echo "SYSTEM : function check(\$d,\$data)<br/>";	
	switch($d)
	{
		case 1:
			if (empty($data)) { echo "Le nom ne peut pas être vide.<br/>"; return 0; }
			if (strlen($data)>40) { echo "Le nom ne peut pas excéder 40 caractères.<br/>"; return 0; }
			if ($data != trim($data)) { echo "Le nom ne peut pas comporter d'espaces au début ni à la fin.<br/>"; return 0; }
			if ($data != mb_strtoupper($data)) { echo "Le nom doit être en majuscules.<br/>"; return 0;}
			$data=str_replace(' ','',$data);
			$data=str_replace('-','',$data);
			$data=str_replace("'",'',$data);
			if ($data != ctype_alpha($data)) { echo "Le nom ne peut comporter que des lettres, espaces, tirets ou apostrophes.<br/>"; return 0; }
			return 1;
		break;
		case 2:
			if (empty($data)) { echo "Le prénom ne peut pas être vide.<br/>"; return 0; }
			if (strlen($data)>40) { echo "Le prénom ne peut pas excéder 40 caractères.<br/>"; return 0; }
			if ($data != trim($data)) { echo "Le prénom ne peut pas comporter d'espaces au début ni à la fin.<br/>"; return 0; }
			if (str_replace('-',' ',$data)!=ucwords(mb_strtolower(str_replace('-',' ',$data)))) { echo "Le prénom doit commencer par une majuscule et être en minuscules<br/>"; return 0; }
			$data=str_replace(' ','',$data);
			$data=str_replace('-','',$data);
			$data=str_replace("'",'',$data);
			if ($data != ctype_alpha($data)) { echo "Le prénom ne peut comporter que des lettres, espaces, tirets ou apostrophes.<br/>"; return 0; }
			return 1;
		break;
		case 3:
			if ( strlen($data) != 10 ) { echo "La date n'est pas au format 31/12/2099.<br/>"; return 0; }
			if ( substr($data, 2, 1) != '/' ) { echo "La date n'est pas au format 31/12/2099.<br/>"; return 0; }
			if ( substr($data, 5, 1) != '/' ) { echo "La date n'est pas au format 31/12/2099.<br/>"; return 0; }
			if ( !checkdate($mo=substr($data,3,2), $da=substr($data,0,2), $ye=substr($data,6,4)) ) { echo "La date n'est pas valide.<br/>"; return 0; }
			return 1;
		break;
		case 4:
			for ($i = 0; ( $i < count($array_zones) && $array_zones[$i] != $data ); $i++);
			if ($i >= count($array_zones)) { echo "La zone n'est pas reconnue.<br/>"; return 0; }
			return 1;
		break;
		case 5:
			for ($i = 0; ( $i < count($array_sections) && $array_sections[$i] != $data ); $i++);
			if ($i >= count($array_sections)) { echo "La section n'est pas reconnue.<br/>"; return 0; }
			return 1;
		break;
		case 6:
			for ($i = 0; ( $i < count($array_fonctions) && $array_fonctions[$i] != $data ); $i++);
			if ($i >= count($array_fonctions)) { echo "La fonction n'est pas reconnue.<br/>"; return 0; }
			return 1;
		break;
		case 7:
			return 1;
		case 8:
			for ($i = 0; ( $i < count($array_qualifs) && $array_qualifs[$i] != $data ); $i++);
			if ($i >= count($array_qualifs)) { echo "La qualification n'est pas reconnue.<br/>"; return 0; }
			return 1;
		break;
		case 9:
		case 10:
		case 11:
		case 12:
		case 13:
			if (!empty($data))
			{
				for ($i = 0; ( $i < count($array_qualifs2) && $array_qualifs2[$i] != $data ); $i++);
				if ($i >= count($array_qualifs2)) { echo "La qualification n'est pas reconnue.<br/>"; return 0; }
			}
			return 1;
		break;
	}
}

/*if (isset($_POST['q0']))
{
	$pdf->AddPage();
	$qualif=array($_POST['q0'],$_POST['q1'],$_POST['q2'],$_POST['q3'],$_POST['q4'],$_POST['q5']);
	$coord=array($_POST['c1'],$_POST['c2'],$_POST['c3'],$_POST['c4'],$_POST['c5'],$_POST['c6'],$_POST['c7']);
	$pdf->badge(210/2-43,297/2-27,$qualif,$coord);
}
else*/

$upfile = $_FILES['upfile']['tmp_name'];

if (!empty($upfile))
{
	if (($handle = fopen($upfile, "r")))
	{
		if ($_POST['format'] == "A4")
		{
			$pdf=new PageBadge('P','mm','A4');
		}
		else
		{
			$pdf=new PageBadge('P','mm',array(86,54));
			$pdf->SetAutoPageBreak(1, 0);
		}

		$pdf->AddFont('vera','','52cb20fcc41f678b90f28409d0849f38_vera.php');
		$pdf->AddFont('vera','B','ba23003c7cf3cd5779f33f1ac2e9a7e4_verabd.php');
		$pdf->AddFont('veramono','','899874f5f734cbad85daaa8d94b11071_veramono.php');
		$pdf->AddFont('veramono','B','ba307e3cb9aaf771752aef82c5836b62_veramobd.php');

		$i = 0; // indice d'hauteur (4)
		$j = 0; // indice de largeur (2)
		$l = 0; // indice de page

		if ($_POST['format'] == "A4") { $nbhaut = 4; $nblarg = 2; }
		else { $nbhaut = 1; $nblarg = 1; }

		$nbpp = $nbhaut * $nblarg; // nombre de badges par page
		$row = 0; // compteur de ligne
		while (($data = fgetcsv($handle, 0, ",")))
		{
			$row ++;
			$d = 0; // indice de colonne
			if ($data[$d++])
			{
				for ($c = 0; $c <= 6; $c++) {
					if ( $_POST['forcer']!="forcer" && !check($d, $data[$d])) { echo "----> ligne $row colonne $d :: $data[$d]<br/><br/>"; }
					$coord[$c] = $data[$d++];
				}
				for ($c = 0; $c <= 5; $c++) {
					if ( $_POST['forcer']!="forcer" && !check($d, $data[$d])) { echo "----> ligne $row colonne $d :: $data[$d]<br/><br/>"; }
					$qualif[$c] = $data[$d++];
				}
				if ($l%$nbpp == 0) $pdf->AddPage();
				if ( !($l%$nblarg) ) $i = $l%$nbpp/$nblarg;
				$j = $l%$nblarg;

				if ($_POST['format'] == "A4") { $pdf->badge(105/2-43+$j*105, $i*60+20, $qualif, $coord); }
				else { $pdf->badge(0, 0, $qualif, $coord); }

				$l++;
			}
		}
		fclose($handle);
	}
	else
	{
		echo "Erreur : Le fichier n'a pas pu être ouvert.<br/><br/>";
	}
}
else
{
	echo "Erreur : Aucun fichier sélectionné.<br/><br/>";
}
$pdf->Output("badges.pdf","I");

?>
