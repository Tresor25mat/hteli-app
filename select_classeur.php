<?php
session_start();
$_SESSION['last_activity'] = time();
require_once ("connexion.php");

require_once("PHPExcel/PHPExcel/IOFactory.php");

if($_FILES['classeur']['tmp_name']==''){
	echo "4";
}else{
	$workbook=basename($_FILES['classeur']['name']);
	$dossier_classeur = 'classeurs/';
	if(!is_dir($dossier_classeur)){
	     mkdir($dossier_classeur);
	}
	$extensions_classeur= array('.XLS', '.XLSX', '.XLSM', '.CSV');
	$extension_classeur = strrchr($_FILES['classeur']['name'], '.');
	$extension_classeur_maj=strtoupper($extension_classeur);
	if(!in_array($extension_classeur_maj, $extensions_classeur)){
	    echo "3";
	}else{
		$objPHPExcel = PHPExcel_IOFactory::load($_FILES['classeur']['tmp_name']);
		//Récupération de toutes les feuilles du fichier Excel
		$Nbr=0;
		foreach($objPHPExcel->getSheetNames() as $sheet) {   
			$Nbr++; 
		}
		if($Nbr==1){
			$sheet = $objPHPExcel->getSheet(0); // FEUILLE A IMPORTER
			if($sheet->getCell('A1')->getValue()=='' || $sheet->getCell('E2')->getValue()==''){
				echo "2";
			}else if($sheet->getCell('A3')->getValue()==''){
				echo "2";
			}else{
			    $Time = time().rand(0,9);
			    $Time = substr($Time, 3, 8);
			    $workbook = 'CLASSEUR_' . $Time . $extension_classeur;
			    if(move_uploaded_file($_FILES['classeur']['tmp_name'], $dossier_classeur . $workbook)) //Si la fonction renvoie TRUE, c'est
			    {
		    		$comm="";
					foreach($objPHPExcel->getSheetNames() as $sheet) {   
						$comm.='<option value="'.$dossier_classeur.$workbook.','.$sheet.'" selected>'.$sheet.'</option>';
					}
					echo "1,".$comm;
			    }


			}
		}else{
		    $Time = time().rand(0,9);
		    $Time = substr($Time, 3, 8);
		    $workbook = 'CLASSEUR_' . $Time . $extension_classeur;
		    if(move_uploaded_file($_FILES['classeur']['tmp_name'], $dossier_classeur . $workbook)) //Si la fonction renvoie TRUE, c'est
		    {
		    	$comm="";
				foreach($objPHPExcel->getSheetNames() as $sheet) {   
					$comm.='<option value="'.$dossier_classeur.$workbook.','.$sheet.'">'.$sheet.'</option>';
				}
				echo $comm;
		    }
		}
	}
}



?>