<?php
include_once '../datos/Empresa.php';
include_once '../datos/Viaje.php';
include_once '../datos/Responsable.php';
include_once '../datos/Pasajero.php';
//echo 'Versión actual de PHP: ' . phpversion();
    
/* 
Implementar dentro de la clase TestViajes una operación que permita 
ingresar, modificar y eliminar la información de la empresa de viajes.
*/

	// creo un obj empresa
	$obj_empresa =  new empresa();
	
	//Busco todas las empresas almacenadas en la BD
	$colempresas =$obj_empresa->listar();
	foreach ($colempresas as $unaempresa){
	
		echo $unaempresa;
		echo "-------------------------------------------------------";
	}
	
	$obj_empresa->cargar(1,"Empresa s.a.","av siempreviva 742");
	$respuesta=$obj_empresa->insertar();
	// Inserto el OBj empresa en la base de datos
	if ($respuesta==true) {
			echo "\nOP INSERCION;  La empresa fue ingresada en la BD";
			$colempresas =$obj_empresa->listar("");
			foreach ($colempresas as $unaempresa){
		
				echo $unaempresa;
				echo "-------------------------------------------------------";
			}
	}else 
		echo $obj_empresa->getmensajeoperacion();
	

	// creo un obj responsable
	$obj_responsable =  new responsable();
	
	//Busco todas las responsables almacenadas en la BD
	$colresponsables =$obj_responsable->listar();
	foreach ($colresponsables as $unaresponsable){
	
		echo $unaresponsable;
		echo "-------------------------------------------------------";
	}
	
	$obj_responsable->cargar(1,423,"don barredora","nieve");
	$respuesta=$obj_responsable->insertar();
	// Inserto el OBj responsable en la base de datos
	if ($respuesta==true) {
			echo "\nOP INSERCION;  La responsable fue ingresada en la BD";
			$colresponsables =$obj_responsable->listar("");
			foreach ($colresponsables as $unaresponsable){
		
				echo $unaresponsable;
				echo "-------------------------------------------------------";
			}
	}else 
		echo $obj_responsable->getmensajeoperacion();



	// creo un obj viaje
	$obj_viaje =  new viaje();
	
	//Busco todos los viajes almacenados en la BD
	$colviajes =$obj_viaje->listar();
	foreach ($colviajes as $unviaje){
	
		echo $unviaje;
		echo "-------------------------------------------------------";
	}

	// Inserto el OBj viaje en la base de datos
	$obj_viaje->cargar(1,"chile",25,1,1,300,"cama","ida");
	$respuesta=$obj_viaje->insertar();
	if ($respuesta==true) {
			echo "\nOP INSERCION;  El viaje fue ingresado en la BD";
			$colviajes =$obj_viaje->listar("");
			foreach ($colviajes as $unviaje){
		
				echo $unviaje;
				echo "-------------------------------------------------------";
			}
	}else 
		echo $obj_viaje->getmensajeoperacion();


	// creo un obj pasajero
	$obj_pasajero =  new pasajero();
	
	//Busco todos los pasajeros almacenados en la BD
	$colpasajeros =$obj_pasajero->listar();
	foreach ($colpasajeros as $unpasajero){
	
		echo $unpasajero;
		echo "-------------------------------------------------------";
	}

	// Inserto el OBj pasajero en la base de datos
	$obj_pasajero->cargar('123123123', 'arroz', 'azul', 154124, 1);
	$obj_pasajero->cargar('345345345', 'berdura', 'balde', 154645, 1);
	$respuesta=$obj_pasajero->insertar();
	if ($respuesta==true) {
			echo "\nOP INSERCION;  El pasajero fue ingresado en la BD";
			$colpasajeros =$obj_pasajero->listar("");
			foreach ($colpasajeros as $unpasajero){
		
				echo $unpasajero;
				echo "-------------------------------------------------------";
			}
	}else 
		echo $obj_viaje->getmensajeoperacion();



////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////


	//genero condicion para listar la col de pasajeros de un viaje
	$idDelViaje = 1;
	$condicion = "idviaje = ".$idDelViaje;

	$grancolPasajeros = $obj_viaje->listarColPasajeros($condicion);

	foreach ($grancolPasajeros as $pasajero){
		echo $pasajero;
		echo "------------------------------------------------\n";
	}


?> 