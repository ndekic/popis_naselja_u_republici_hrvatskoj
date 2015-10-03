<?php
	
	if (isset($_POST["dodaj"])) {
		include_once 'spajanje_na_bazu.php';
		include_once 'unos_u_bazu.php';
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Popis naselja u Republici Hrvatskoj</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="css/stil.css">
</head>
<body>
	<h1>Popis naselja u Republici Hrvatskoj</h1>
	<div class="section group">
		<div class="col span_1_of_2">
			<form method="post" action="preuzimanje_json.php">
				<fieldset>
					<legend>Preuzimanje popisa u JSON formatu</legend>
					<input type="submit" value="Preuzmi JSON" name="preuzmi" />
				</fieldset>
			</form>

			<br />	

			<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data" accept=".json" >
				<fieldset>
					<legend>Unos izravno u bazu podataka (JSON -> SQL)</legend>
					<label for ="host">Host*</label>
					<br />
					<input type="text" name="host" id="host" required="required" value="<?php echo isset($_POST['host']) ? ($_POST['host']) : "" ?>" required="required" placeholder="localhost"/>
					<br /><br />		
					<label for ="imebaze">Naziv baze podataka*</label>
					<br />
					<input type="text" name="imebaze" id="imebaze" value="<?php echo isset($_POST['imebaze']) ? ($_POST['imebaze']) : "" ?>" required="required" />
					<br /><br />
					<label for ="nazivtablice">Naziv tablice*</label>
					<br />
					<input type="text" name="nazivtablice" id="nazivtablice" value="<?php echo isset($_POST['nazivtablice']) ? ($_POST['nazivtablice']) : "" ?>" required="required" />
					<br /><br />
					<label for ="korisnickoime">Korisničko ime pristupa bazi podataka</label>
					<br />
					<input type="text" name="korisnickoime" id="korisnickoime" value="<?php echo isset($_POST['korisnickoime']) ? ($_POST['korisnickoime']) : "" ?>" />
					<br /><br />
					<label for ="lozinka">Lozinka pristupa bazi podataka</label>
					<br />
					<input type="password" name="lozinka" id="lozinka" value="<?php echo isset($_POST['lozinka']) ? ($_POST['lozinka']) : "" ?>"/>
					<br /><br />
					<label for ="datoteka">JSON datoteka**</label>
					<br />
					<input type="file" name="datoteka" id="datoteka" required="required"/>
					<br /><br />
					<input type="submit" value="Unesi u bazu podataka" name="dodaj" class="siroko" />					
					<p>* Obavezan unos <br /> ** Odabrati <i>popis_naselja_u_republici_hrvatskoj.json</i> u mapi <i>json</i></p>
				</fieldset>
			</form>
		</div>

		<div class="col span_1_of_2">
			<?php if (isset($poruka)): ?>
			<fieldset>
				<legend>Prikaz</legend>
					<h4>Popis naselja u RH uspješno je unesen u bazu podataka <i><?php echo $_POST["imebaze"] ?></i>.<br />Prikazano je prvih 10 redova tablice <i><?php echo $_POST["nazivtablice"]; ?></i>.</h4>
					<table style="width:100%" border="1" cellpadding="5px">
						<thead>
							<tr>
								<th>Poštanski broj</th>
								<th>Mjesto</th>				
								<th>Općina</th>
								<th>Županija</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$veza->beginTransaction();
					  			$izraz=$veza->prepare("select * from nazivtablice limit 10");
					  			$izraz->bindParam("nazivtablice",$_POST["nazivtablice"]);
								$izraz->execute();
								$rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
								foreach ($rezultati as $red):
					  		?>
						  	<tr>		  		
						     	<td><?php echo $red->postanskiBroj ?></td>
						     	<td><?php echo $red->mjesto ?></td>
						     	<td><?php echo $red->opcina ?></td>
						     	<td><?php echo $red->zupanija ?></td>
						  	</tr>		  	
						    <?php 
						    	endforeach; 
						    	$izraz=$veza->prepare("select count(*) from nazivtablice");
						    	$izraz->bindParam("nazivtablice",$_POST["nazivtablice"]);
								$izraz->execute();
								$ukupno = $izraz->fetchColumn();
								$veza->commit();
						    ?>
						    <tr>
						    	<td colspan="4"><?php echo "Ukupno zapisa: " . $ukupno ?></td>
						    </tr>
					 </tbody>
					</table>
					<br /><br />
				</fieldset>
			<?php endif; ?>
		</div>
	</div>
</body>
</html>