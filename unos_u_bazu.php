<?php
	$nazivtablice = $_POST['nazivtablice'];
	$veza->beginTransaction();
	$izraz=$veza->prepare
	(	"drop table if exists $nazivtablice;	
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
						
				$izraz=$veza->prepare
				(	"insert into $nazivtablice (mjesto, postanskiBroj, opcina, zupanija) 
					values (:mjesto, :postanskiBroj, :opcina, :zupanija);"
				);
				$izraz->execute($r);			
			}
		$poruka = true;
		$veza->commit();
	}
	else{
		echo "Greška";
	}