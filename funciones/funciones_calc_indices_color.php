<?php 

//Método para calcular el valor del indice NSF
function calcIndiceNsf($documento)
{
    $PO2=$documento['PO2']; 
    $DBO=$documento['DBO']; 
    $CF=$documento['CF']; 
    $pH=$documento['pH'];
    $valorPO2 = -13.55+(1.17*$PO2);
    $valorPO2 = $valorPO2*0.31;
    $valorDBO = 96.67-(7*$DBO);
    $valorDBO = $valorDBO*0.19;
    $valorCF = 97.2-(26.6*log10($CF));
    $valorCF = $valorCF*0.28;
    $valorpH = 316.96-(29.85*$pH);
    $valorpH = $valorpH*0.22;
    
    $respuesta = $valorPO2 + $valorDBO + $valorCF+ $valorpH;
    return $respuesta;
}


//Método para calcular el valor del indice NSF
function calcIndiceGlobal($documento)
{
    $PO2=$documento['PO2']; 
    $DBO=$documento['DBO']; 
    $CF=$documento['CF']; 
    $pH=$documento['pH'];
    $valorPO2 = -13.55+(1.17*$PO2);
    $valorPO2 = $valorPO2*0.31;
    $valorDBO = 96.67-(7*$DBO);
    $valorDBO = $valorDBO*0.19;
    $valorCF = 97.2-(26.6*log10($CF));
    $valorCF = $valorCF*0.28;
    $valorpH = 316.96-(29.85*$pH);
    $valorpH = $valorpH*0.22;
    
    $respuesta = $valorPO2 + $valorDBO + $valorCF+ $valorpH;
    return $respuesta;
}

//Método para calcular el índece Holandés
function calcIndiceHolandes($documento)
{
    $PO2=$documento['PO2']; 
    $DBO=$documento['DBO']; 
    $NH4=$documento['NH4']; 
    $puntos = 0;
  //validacion PO2
    if ($PO2 >= 91 && $PO2 <= 100) {
        $puntos += 1;
    } elseif (($PO2 >= 71 && $PO2 <= 90)||($PO2 >= 111 && $PO2 <= 120)) {
        $puntos += 2;
    } elseif (($PO2 >= 51 && $PO2 <= 70)||($PO2 >= 121 && $PO2 <= 130)) {
        $puntos += 3;
    } elseif ($PO2 >= 31 && $PO2 <= 50) {
        $puntos += 4;
    } else {
        $puntos += 5;
    }
  //validacion DBO
    if ($DBO <= 3.0) {
        $puntos += 1;
    } elseif ($DBO >= 3.1 && $DBO <= 6.0) {
        $puntos += 2;
    } elseif ($DBO >= 6.1 && $DBO <= 9.0) {
        $puntos += 3;
    } elseif ($DBO >= 9.1 && $DBO <= 15.0) {
        $puntos += 4;
    } else {
        $puntos += 5;
    }
  //validacion NH4
    if ($NH4 < 0.50) {
        $puntos += 1;
    } elseif ($NH4 >= 0.50 && $NH4 <= 1.0) {
        $puntos += 2;
    } elseif ($NH4 >= 1.1 && $NH4 <= 2.0) {
        $puntos += 3;
    } elseif ($NH4 >= 2.1 && $NH4 <= 5.0) {
        $puntos += 4;
    } else {
        $puntos += 5;
    }
    return $puntos;
}


//Método para calcular el color asociado al valor del índice NSF
function calcColorNsf($puntos)
{
    if ($puntos >= 91 && $puntos <= 100) {
        $respuesta = "Azul";
    } elseif ($puntos >= 71 && $puntos <= 90) {
        $respuesta = "Verde";
    } elseif ($puntos >= 51 && $puntos <= 70) {
        $respuesta = "Amarillo";
    } elseif ($puntos >= 26 && $puntos <= 50) {
        $respuesta = "Anaranjado";
    } else {
        $respuesta = "Rojo";
    }
    return $respuesta;
}


//Método para calcular el color asociado al valor del índice NSF
function calcColorGlobal($puntos)
{
    if ($puntos >= 91 && $puntos <= 100) {
        $respuesta = "Azul";
    } elseif ($puntos >= 71 && $puntos <= 90) {
        $respuesta = "Verde";
    } elseif ($puntos >= 51 && $puntos <= 70) {
        $respuesta = "Amarillo";
    } elseif ($puntos >= 26 && $puntos <= 50) {
        $respuesta = "Anaranjado";
    } else {
        $respuesta = "Rojo";
    }
    return $respuesta;
}

//Método para calcular el color asociado al valor del índice
function calcColorHolandes($puntos)
{
    if ($puntos == 3) {
        $respuesta = "Azul";
    } elseif ($puntos >= 4 && $puntos <= 6) {
        $respuesta = "Verde";
    } elseif ($puntos >= 7 && $puntos <= 9) {
        $respuesta = "Amarillo";
    } elseif ($puntos >= 10 && $puntos <= 12) {
        $respuesta = "Anaranjado";
    } else {
        $respuesta = "Rojo";
    }
    return $respuesta;
}

 ?>