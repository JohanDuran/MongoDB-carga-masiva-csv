<?php 
	function getFields(){
			return ['usuario','temp_agua','velocidad_agua','area_cause_rio','PO2','DBO','NH4','DQO','EC','PO4','GYA','SD','Ssed','SST','SAAM','T','Aforo','ST','CF','pH','Fosfato','Nitrato','Turbidez','Sol_totales','nombre_institucion','nombre_estacion','fecha', 'kit_desc','lat','lng','alt','cod_prov','cond_cant','cod_dist','cod_rio','Color','DBO','NH4'];
	}

	function getRequiredHolandes(){
		return ['NH4','PO2','DBO'];
	}

	function getRequiredNsf(){
		return ['NH4','PO2','CF','pH'];
	}

	function getGenerals(){
		return ['usuario','fecha','indice_usado','val_indice','color','temp_agua','velocidad_agua','velocidad_agua','area_cauce_rio'];
	}

	function getOptionals(){
		return ['DQO','EC','PO4','GYA','SD','Ssed','SST','SAAM','T','Aforo','ST','CF','pH','Fosfato','Nitrato','Turbidez','Sol_totales'];
	}

	function getLocation(){
		return ['lat','lng'];
	}

	function getGeoreferenced(){
		return ['alt','cod_prov','cod_cant','cod_dist','cod_rio'];
	}

	function getPOI(){
		return ['nombre_institucion','nombre_estacion','kit_desc'];
	}


 ?>