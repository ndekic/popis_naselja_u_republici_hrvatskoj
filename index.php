<?php
	
	if (isset($_POST["dodaj"])) {
		include_once 'spajanje_na_bazu.php';

		$nazivtablice = $_POST["nazivtablice"];
		$veza->beginTransaction();
		$izraz=$veza->prepare("	drop table if exists $nazivtablice;	
								create table $nazivtablice(
								ID 				int not null primary key auto_increment,
								mjesto 			varchar(100) not null,
								postanskiBroj 	varchar(20) not null,
								opcina 			varchar(100) not null,
								zupanija 		varchar(100) not null
								)engine=innodb CHARACTER SET utf8 COLLATE utf8_general_ci;"
							);
		$izraz->execute();

		$dokument = file_get_contents($_FILES['datoteka']['tmp_name']);

		if($dokument != null){		
			$rezultati = json_decode($dokument,true);
			
				foreach ($rezultati as $r) {
					unset($r["ID"]);
							
					$izraz=$veza->prepare(" insert $nazivtablice (mjesto, postanskiBroj, opcina, zupanija) 
											values (:mjesto, :postanskiBroj, :opcina, :zupanija);"
										);
					$izraz->execute($r);			
				}
			$poruka = "OK :)";
			$veza->commit();
		}
		else{
			$poruka = "Nije OK :(";
		}
	} // POST
?>
<!DOCTYPE html>
<html>
<head>
	<title>JSON to SQL</title>
</head>
<body>
	<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>" enctype="multipart/form-data">
	<h1>Popis mjesta RH</h1>
		<label for ="host">Host</label>
		<br />
		<input type="text" name="host" id="host" required="required" value="localhost" />
		<br /><br />		
		<label for ="imebaze">Naziv baze</label>
		<br />
		<input type="text" name="imebaze" id="imebaze" required="required" />
		<br /><br />
		<label for ="nazivtablice">Naziv tablice</label>
		<br />
		<input type="text" name="nazivtablice" id="nazivtablice" required="required" />
		<br /><br />
		<label for ="korisnickoime">Korisničko ime pristupa bazi</label>
		<br />
		<input type="text" name="korisnickoime" id="korisnickoime" required="required" />
		<br /><br />
		<label for ="lozinka">Lozinka pristupa bazi</label>
		<br />
		<input type="text" name="lozinka" id="lozinka" required="required" />
		<br /><br />
		<label for ="datoteka">JSON datoteka</label>
		<br />
		<input type="file" name="datoteka" id="datoteka" required="required"/>
		<br /><br />
		<input type="submit" value="Dodaj u bazu" name="dodaj" />	
		
		<?php 
			if (isset($poruka)){
				echo "<h1>" . $poruka . "</h1>";
			}
		?>
	</form>
	<form method="post" action="<?php echo $_SERVER["PHP_SELF"] ?>">
	<input type="submit" value="Preuzmi JSON" name="preuzmi" />
	</form>
			
		<?php
			$popis_mjesta_republika_hrvatska = 'popis_mjesta_republika_hrvatska.json';
			if(isset($_POST["preuzmi"])){
				if (file_exists($popis_mjesta_republika_hrvatska)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.basename($popis_mjesta_republika_hrvatska).'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($popis_mjesta_republika_hrvatska));
				readfile($popis_mjesta_republika_hrvatska);
				exit;
				}
			}
		?>
</body>
</html>