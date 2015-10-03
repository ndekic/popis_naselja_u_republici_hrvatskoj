<?php
	
	$popis_mjesta_republika_hrvatska = 'json/popis_mjesta_republika_hrvatska.json';
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