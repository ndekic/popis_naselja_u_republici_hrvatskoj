<?php
	
	$popis_naselja_u_republici_hrvatskoj = 'json/popis_naselja_u_republici_hrvatskoj.json';
	if(isset($_POST["preuzmi"])){
		if (file_exists($popis_naselja_u_republici_hrvatskoj)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($popis_naselja_u_republici_hrvatskoj).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($popis_naselja_u_republici_hrvatskoj));
		readfile($popis_naselja_u_republici_hrvatskoj);
		exit;
		}
	}