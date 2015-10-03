<?php 
//razvoj

	include_once 'spajanje_na_bazu.php';

	$izraz=$veza->prepare("select * from mjesta");
    $izraz->execute();
    $rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);

	$dokument = fopen('json/popis_naselja_u_republici_hrvatskoj.json', 'w');
	fwrite($dokument, json_encode($rezultati));
	fclose($dokument);