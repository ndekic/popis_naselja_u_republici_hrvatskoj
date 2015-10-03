<?php 
	include_once 'spajanje_na_bazu.php';

	$izraz=$veza->prepare("select * from mjesta");
    $izraz->execute();
    $rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);

	$dokument = fopen('popis_mjesta_republika_hrvatska.json', 'w');
	fwrite($dokument, json_encode($rezultati));
	fclose($dokument);
?>