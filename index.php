<?php
	include('PDF-badge-arraychecks.php');
?>

<script>

function js_disp(x)
{
	r = document.getElementById('span_'+x);
	if (r.style.display == '') { r.style.display = 'none'; }
	else { r.style.display = ''; } 
}

</script>

<table style="border-collapse: collapse" width="100%">
	<tr>
		<td align="center">
			<h1>Badges SSCR</h1>
		</td>
		<td align="right" width="1">
			<img src="logo_crb_340x100.png"/>
		</td>
	</tr>
</table>

<hr/>

<h3>Charger un fichier :</h3>

<form method="post" action="PDF-badge.php" enctype="multipart/form-data">    
	<input type="hidden" name="MAX_FILE_SIZE" value="4194304"/>
	<input type="file" name="upfile" size="80"/>
	<input type="submit" value="Générer"/><br/>
	<input type="checkbox" name="forcer" value="forcer"/>forcer les erreurs
	<br/>Format :<input type="radio" name="format" value="A4" selected="selected"/>A4
	<input type="radio" name="format" value="86x54"/>86x54
</form>

<hr/>

<h3 onClick="js_disp(1)" style="cursor: pointer;">Fichier</h3>

<span style="display: none" id="span_1">

<ul>
<li>Format : CSV</li>
<li>Séparateur : virgule</li>
<li>Nombre de colonnes : 14</li>
<li>Taille maximale : 4 MB</li>
</ul>

</span>

<hr/>

<h3 onClick="js_disp(2)" style="cursor: pointer;">Contraintes</h3>

<span style="display: none" id="span_2">

	<ul>
	<li><h4>Colonne 1 : booléen</h4>
		<ul>
		<li>0 -> ligne non prise en compte</li>
		<li>1 -> ligne prise en compte</li>
		</ul>
	</li>

	<li><h4>Colonne 2 : NOM</h4>
		<ul>
		<li>en majuscule</li>
		<li>caractères autorisés : lettres, espaces, tirets, apostrophes</li>
		<li>taille maximale : 40 caractères</li>
		</ul>
	</li>

	<li><h4>Colonne 3 : Prénom</h4>
		<ul>
		<li>premières lettres en majuscule</li>
		<li>caractères autorisés : lettres, espaces, tirets, apostrophes</li>
		<li>taille maximale : 40 caractères</li>
		</ul>
	</li>

	<li><h4>Colonne 4 : Date de naissance</h4>
		<ul>
		<li>format : jj/mm/aaaa</li>
		</ul>
	</li>

	<li><h4>Colonne 5 : Zone</h4>
		<ul>
<?		foreach ($array_zones as $r) echo "<li>\"$r\"</li>";
?>		</ul>
	</li>

	<li><h4>Colonne 6 : Section</h4>
		<ul>
<?		foreach ($array_sections as $r) echo "<li>\"$r\"</li>";
?>		</ul>
	</li>

	<li><h4>Colonne 7 : Fonction</h4>
		<ul>
<?		foreach ($array_fonctions as $r) echo "<li>\"$r\"</li>";
?>		</ul>
	</li>

	<li><h4>Colonne 8 : Matricule</h4>
		<ul>
		<li>aucune contrainte</li>
		</ul>
	</li>

	<li><h4>Colonne 9 : Qualification</h4>
		<ul>
<?		foreach ($array_qualifs as $r) echo "<li>\"$r\"</li>";
?>		</ul>
	</li>

	<li><h4>Colonne 10->14 : Autres qualifications</h4>
		<ul>
<?		foreach ($array_qualifs2 as $r) echo "<li>\"$r\"</li>";
?>		</ul>
	</li>
</ul>

</span>

<hr/>

<h3 onClick="js_disp(3)" style="cursor: pointer;">Format / Impression</h3>

<span style="display: none" id="span_3">

<ul>
	<li><h4>Impression sur papier A4</h4>
		<ul>
			<li>8 badges par page</li>
			<li>Echelle : 95%</li>
			<li>Papier : laser couleur A4 160g/m²</li>
			<li>Plastique : 86mm x 54mm // 125µm x 2</li>
		</ul>
	</li>
	<li><h4>Impression sur badges 86mm sur 54mm</h4>
		<ul>
			<li>1 badge</li>
		</ul>
	</li>
</ul>

</span>

<hr/>

<h3 onClick="js_disp(4)" style="cursor: pointer;">Exemple</h3>

<span style="display: none" id="span_4">

<table style="border-collapse: collapse;">
	<tr height="20px">
		<td width="20px" style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
		<td></td>
		<td width="20px" style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
	</tr>
	<tr>
		<td></td>
		<td><img src="exempledebadge.png" width="480"/></td>
		<td></td>
	</tr>
	<tr height="20px">
		<td width="20px" style="border-right: 1px solid black; border-top: 1px solid black;"></td>
		<td></td>
		<td width="20px" style="border-left: 1px solid black; border-top: 1px solid black;"></td>
	</tr>
</table>

</span>

<hr/>

<!--
<form method="POST" action="PDF-badge.php">

	<table>

		<tr>
			<td colspan="5" align="center">
				<select name="q0">
					<option value="Secouriste">Secouriste</option>
					<option value="Equipier-Secours">Equipier-Secours</option>
					<option value="Equipier Poste Soins">Equipier Poste Soins</option>
					<option value="Chef d'Equipe">Chef d'Equipe</option>
					<option value="Ambulancier">Ambulancier</option>
					<option value="Formateur">Formateur</option>
				</select>
			</td>
		</tr>

		<tr>
<?			for ($i=1; $i<=5; $i++) {
?>				<td>
					<select name="<?='q'.$i?>">
						<option></option>
						<option value="BLS">SEC</option>
						<option value="BLS">BLS</option>
						<option value="SSCR">SSCR</option>
						<option value="ES">ES</option>
						<option value="CE">CE</option>
						<option value="VIR">VIR</option>
						<option value="EPS">EPS</option>
						<option value="TMS">TMS</option>
						<option value="AMU">AMU</option>
						<option value="PCO">PCO</option>
					</select>
				</td>
<?			 }
?>		</tr>

		<tr>
			<td colspan="2" align="right">Nom :</td>
			<td colspan="3"><input type="text" name="c1"/></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Prénom :</td>
			<td colspan="3"><input type="text" name="c2"/></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Date de naissance :</td>
			<td colspan="3"><input type="text" name="c3"/></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Zone :</td>
			<td colspan="3"><input type="text" name="c4"/></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Section :</td>
			<td colspan="3"><input type="text" name="c5"/></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Fonction :</td>
			<td colspan="3"><input type="text" name="c6"/></td>
		</tr>
		<tr>
			<td colspan="2" align="right">Matricule :</td>
			<td colspan="3"><input type="text" name="c7"/></td>
		</tr>
</table>

<input type="submit" value="Badge !"/>

</form>
-->
