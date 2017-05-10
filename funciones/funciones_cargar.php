<?php


	function getFields(){
			return ['usuario','temp_agua','velocidad_agua','area_cause_rio','PO2','DBO','NH4','DQO','EC','PO4','GYA','SD','Ssed','SST','SAAM','T','Aforo','ST','CF','pH','Fosfato','Nitrato','Turbidez','Sol_totales','nombre_institucion','nombre_estacion','fecha', 'kit_desc','lat','lng','alt','cod_prov','cond_cant','cod_dist','cod_rio','Color','DBO','NH4'];
	}

	function verificarCsv($file_ext,$file_size){
		$extensiones= array("php","html","csv");
		$errors=array();
		if(in_array($file_ext,$extensiones)=== false){
		 	$errors[]="Extension no permitida";
		}

		if($file_size > 2097152){
			$errors[]='Tama,o excede limite';
		}

		return $errors;
	}



?>