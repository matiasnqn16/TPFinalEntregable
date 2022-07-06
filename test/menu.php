<?php

include_once '../datos/Empresa.php';
include_once '../datos/Viaje.php';
include_once '../datos/Responsable.php';
include_once '../datos/Pasajero.php';


function menuEmpresa(){
                                // menu principal 
    //////////////////// comienzo del programa TestVieja ///////////////////
    // suponiendo que se trata de una sola empresa se lista la misma, por lo cual
    // solo se podra modificar la que vamos a utilizar actualmente


    // ---- se solicita una operacion que permita ingresar la informacion de la empresa
    // ---- se solicita una operacion que permita modificar la informacion de la empresa
    // ---- se solicita una operacion que permita eliminar la informacion de la empresa
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        \n-------Menu inicio--------\n
		\n bienvenido al programa de gestion de la empresa
        \n (Recuerde que ya tiene asignada la empresa a la base de datos)
        \n_________________________________________________________
        \nopciones:
        \n1- Ingresar empresa
        \n2- Modificar empresa
        \n3- Eliminar empresa
        \n
        \n4- ADMINISTRAR viajes
        \n
        \n5- Salir del programa
        \n";

    do {
        echo "Seleccione su opcion: ";
        $selector = trim(fgets(STDIN));
        if ($selector > 0 && $selector < 6) {
            switch($selector){
                case 1:
                    ingresarEmpresa();
                    break;
                case 2:
                    modificarEmpresa();
                    break;
                case 3:
                    eliminarEmpresa();
                    break;
                case 4:
                    menuViajes();
                    break;
                case 5:
                    echo "adios!";
                    break;
            }

        } else {
            echo "la seleccion es invalida" . "\n" .
                "Porfavor ingrese una opcion del 1 al 5." . "\n";
        }

    } while ($selector > 5);
}

function ingresarEmpresa(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se le pedira los siguientes datos:
    \n - nombre de la empresa - direccion de la empresa
    \n
    \n";
    do{
        echo "Ingrese el nombre: ";
        $enombre = trim(fgets(STDIN));
        echo "\nIngrese la direccion: ";
        $edireccion = trim(fgets(STDIN));
        echo "\n
            \nLos datos que ingreso son los siguientes:
            \n - ".$enombre." - ".$edireccion. " \n
            \nSon correctos los datos?
            \n1- Si
            \n2- No (volver al menu principal)
            \n
            \nSeleccione su opcion: ";
            $sel = trim(fgets(STDIN));
        if($sel > 0 && $sel < 3){
            switch($sel){
                case 1:
                    ////////////// iniciando nueva clase
                    $obj_empresa =  new empresa();
                    $autoid=$obj_empresa->contarIdEmpresas();
                    do{
                        $obj_empresa->cargar($autoid,$enombre,$edireccion);
                        $respuesta = $obj_empresa->insertar();
                        $autoid++;
                    }while(!$respuesta);

                    if ($respuesta == true) {
                        echo "\nOP INSERCION;  La empresa fue ingresada en la BD\n
                        \n A continuacion la base de datos queda de la siguiente manera\n";
                        $colempresas = $obj_empresa->listar("");
                        foreach ($colempresas as $unaempresa) {

                            echo $unaempresa;
                            echo "-------------------------------------------------------";
                        }
                    }
                    echo "\nVolviendo al menu anterior\n\n";
                    menuEmpresa();
                    break;
                case 2:
                    menuEmpresa();
                    break;
            }
        }else{
            echo "la seleccion es invalida" . "\n" .
                "Porfavor ingrese una opcion del 1 al 2." . "\n";
        }

    }while($sel > 2);
}

function modificarEmpresa(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se listaran las empresas
    ";
    $obj_empresa =  new empresa();
    $colempresas = $obj_empresa->listar("");
    $arrayDeIds = array(0);
    foreach ($colempresas as $unaempresa) {
        array_push($arrayDeIds,$unaempresa->getIdempresa());
        echo $unaempresa;
        echo "-------------------------------------------------------";
    }
    $salir=false;
    do{
        echo "\n(Si desea volver atras escriba 'salir')";
        echo "\n Ingrese la id de la empresa que desea modificar: ";
        $opc = trim(fgets(STDIN));
        if (array_search($opc, $arrayDeIds)) {
            $obj_empresa->Buscar($opc);
            echo "El nombre y la direccion actual es: -" . $obj_empresa->getEnombre() . " - " .  $obj_empresa->getEdireccion() . "
                \n\n Ingrese el nombre y la direccion a modificar: \n\n";
            echo "Ingrese el nombre: ";
            $enombre = trim(fgets(STDIN));
            echo "\nIngrese la direccion: ";
            $edireccion = trim(fgets(STDIN));
            echo "\n
                    \nLos datos que ingreso son los siguientes:
                    \n - " . $enombre . " - " . $edireccion . " \n";

            $obj_empresa->setIdempresa($opc);
            $obj_empresa->setEnombre($enombre);
            $obj_empresa->setEdireccion($edireccion);
            $obj_empresa->modificar();

            $salir = true;
        }if($opc == "salir"){
            $salir = true;
        }
         else{
            echo "\nEsa id no existe, porfavor ingrese la id: ";
        }

    }while(!$salir);
    echo "\n\nVolviendo al menu principal\n\n";
    menuEmpresa();
}

function eliminarEmpresa(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se listaran las empresas
    ";
    $obj_empresa =  new empresa();
    $colempresas = $obj_empresa->listar("");
    $arrayDeIds = array(0);
    foreach ($colempresas as $unaempresa) {
        array_push($arrayDeIds,$unaempresa->getIdempresa());
        echo $unaempresa;
        echo "-------------------------------------------------------";
    }
    $salir=false;
    do{
        echo "\nEsta seguro de querer eliminar la empresa? recuerde que si la empresa \n
        tiene viajes cargados no podra eliminarse, pero si quiere hare lo posible para eliminar
        \n(Si desea volver atras escriba 'salir')";
        echo "\n Ingrese la id de la empresa que desea eliminar: ";
        $opc = trim(fgets(STDIN));
        if (array_search($opc, $arrayDeIds)) {
            $obj_empresa->Buscar($opc);
            $obj_empresa->eliminar();
            $salir = true;
        }if($opc == "salir"){
            $salir = true;
        }
         else{
            echo "\nEsa id no existe, porfavor ingrese la id: ";
        }

    }while(!$salir);
    echo "\n\nVolviendo al menu principal\n\n";
    menuEmpresa();   
}

function menuViajes(){
    //
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        \n---------Menu Viajes---------\n
        \n Bienvenido al sistema de gestion de viajes de la empresa
        \n_______________________________________________________
        \nseleccione una de las opciones de la lista:
        \n
        \n1- Listar los viajes de la empresa
        \n(dentro de la lista podra seleccionar el viaje que desea eliminar, modificar o ingresar)
        \n
        \n2- listar los responsables de los viajes (eliminar, modificar y agregar)
        \n
        \n3- Volver al menu principal
        \n";
    do {
        echo "Seleccione su opcion: ";
        $selector = trim(fgets(STDIN));
        if ($selector > 0 && $selector < 4
        ) {
            switch($selector){
                case 1:
                    subMenuViajes();
                    break;
                case 2:
                    subMenuResponsable();
                    break;
                case 3:
                    menuEmpresa();
                    break;
            }
        } else {
            echo "la seleccion es invalida" . "\n" .
            "Porfavor ingrese una opcion del 1 al 3." . "\n";
        }
    } while ($selector > 3);
}

function subMenuViajes(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        \n-------SubMenuViajes-------\n
        \nA continuacion se muestran los viajes de la empresa
        \n";
        $obj_viaje = new viaje();
        $colViajes = $obj_viaje->listar();
        $arrayDeIds = array(0);
        foreach ($colViajes as $unviaje) {
            array_push($arrayDeIds,$unviaje->getIdviaje());
            echo $unviaje;
            echo "-------------------------------------------------------";
        }

        $salir=false;
    do{
        echo "\n 
        \nIngrese la id del viaje(ingrese 'salir' si desea volver): ";
        $opc = trim(fgets(STDIN));
        if (array_search($opc, $arrayDeIds)) {
            $obj_viaje->Buscar($opc);
            subSubMenuViajes($opc);
            $salir = true;
        }if($opc == "salir"){
            $salir = true;
        }else{
            echo "\nEsa id no existe, porfavor ingrese la id: ";
        }

    }while(!$salir);

    echo "\n Volviendo al menu anterior\n";   
    menuViajes();
}

function subSubMenuViajes($id){
    // el parametro id corresponde al id del viaje que se esta manipulando
    echo "\n+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n--sub sub menu viajes--
    \nSeleccione una de las opciones disponibles:\n
    \n1- listar Pasajeros del viaje
    \n(podra agregar,modificar o borrar pasajeros)
    \n2- crear viaje 
    \n3- modificar viaje
    \n4- eliminar viaje
    \n
    \n5- volver al menu anterior
    \n";

    do {
        echo "\nSeleccione su opcion: ";
        $selector = trim(fgets(STDIN));
        if ($selector > 0 && $selector < 6) {
            switch($selector){
                case 1:
                    menuPasajeros($id);
                    break;
                case 2:
                    agregarViaje();
                    break;
                case 3:
                    modificarViaje();
                    break;
                case 4:
                    eliminarViaje();
                    break;
                case 4:
                    menuViajes();
                    break;
            }

        } else {
            echo "la seleccion es invalida" . "\n" .
                "Porfavor ingrese una opcion del 1 al 4." . "\n";
        }

    } while ($selector > 5);

}

function menuPasajeros($id){
    echo "\n++++++++++++++++++++++++++++++++++++++++++++++++
    \nBienvenido al menu Pasajeros 
    \n___________________________________
    \n A continuacion se listan los pasajeros del viaje:
    \n";
    echo listarPasajeros($id);
    
    $salir=false;
    do{
        echo "\n Los lugares disponibles son de ". mostrarLugaresDisponibles($id) . " Asientos.";
        echo "\n ---Opciones---
        \n
        \n1- añadir nuevo pasajero
        \n2- modificar pasajero
        \n3- eliminar pasajero
        \n";
        echo "\n(Si desea volver atras escriba 'salir')\n";
        echo "\n Ingrese la opcion: ";
        $opc = trim(fgets(STDIN));
        if ($opc == 1) {
            agregarPasajero($id);
        }if($opc == 2){
            modificarPasajero($id);
        }if($opc == 3){
            eliminarPasajero($id);
        }if($opc == "salir"){
            $salir = true;
        }
        else{
            echo "\nEsa id no existe, porfavor ingrese la id: ";
        }
    }while(!$salir);
    echo "\n Volviendo al menu anterior\n";
    menuViajes();
}

function agregarPasajero($id){
    echo "\n----- agregar pasajero al viaje -----
    \n";
    if(listarPasajeros($id) == ""){
        echo "Este Viaje no tiene pasajeros";
    }else{
        echo "\n se listan los pasajeros actuales";
        echo listarPasajeros($id);
    }
    echo "\nEl viaje posee ". mostrarLugaresDisponibles($id). " asientos disponibles\n";
    $salir = false;
    //Añadir pasajeros hasta que no queden asientos
    while(!$salir && mostrarLugaresDisponibles($id) > 0){
        echo "\ningrese el dni del pasajero: ";
        $nDni= trim(fgets(STDIN));
        echo "\nIngrese el nombre: ";
        $nNombre= trim(fgets(STDIN));
        echo "\ningrese el apellido: ";
        $nApellido= trim(fgets(STDIN));
        echo "\ningrese el numero de telefono: ";
        $nTelefono= trim(fgets(STDIN));
        $agregarPasajero = new pasajero();
        $colPasajeros = $agregarPasajero->listar("pasajero.rdocumento =".$nDni);
        $arrayDeIds = array(0);
        foreach ($colPasajeros as $pasajero) {
            array_push($arrayDeIds,$pasajero->getRdocumento());
        }
        //podria poner una validacion 
        $done = false;
        do{
            if(array_search($nDni,$arrayDeIds)){
                echo "\nEste pasajero puede que este cargado o este en otro viaje\n";
                $done = true;
            }else{
                // inicio el objeto viaje para pasarlo
                $objViaje = new viaje();
                $objViaje->Buscar($id);
                $agregarPasajero->cargar($nDni,$nNombre,$nApellido,$nTelefono,$objViaje);
                $agregarPasajero->insertar();
                echo "\nagregado con exito!";
                $done = true;
            }
        }while(!$done);
        echo "\nDesea seguir agregando mas pasajeros? (s/n): ";
        $choice = trim(fgets(STDIN));
        if($choice == "n"){
            $salir = true;
        }

    }//while(!$salir || mostrarLugaresDisponibles($id) == 0);
    menuPasajeros($id);

}

function modificarPasajero($id){
    echo "\n--------- modificar pasajero --------
    \nA continuacion se listan los pasajeros del idviaje ".$id."
    \n";
    echo listarPasajeros($id);
    $salir = false;
    do{
        echo "
        \nIngrese el documento del pasajero que desea modificar: ";
        $dni = trim(fgets(STDIN));
        $modPasajero = new pasajero();
        if($modPasajero->Buscar($dni)){
            echo "\ndni correcto";
            
           /*  echo "\ningrese el nuevo dni: ";
            $nDni= trim(fgets(STDIN));
            //creo bandera por si el dni cambia y es necesario borrar el viejo
            $flag = false;
            if($nDni == $dni){
                $flag = true;
            } */
            echo "\nIngrese el nombre: ";
            $nNombre= trim(fgets(STDIN));
            echo "ingrese el apellido: ";
            $nApellido= trim(fgets(STDIN));
            echo "ingrese el numero de telefono: ";
            $nTelefono= trim(fgets(STDIN));

            $obj_viaje = new viaje();
            $colViajes = $obj_viaje->listar();
            $arrayDeIds = array(0);
            foreach ($colViajes as $unviaje) {
                array_push($arrayDeIds,$unviaje->getIdviaje());
                echo $unviaje;
                echo "-------------------------------------------------------";
            }
            //podria poner una validacion 
            $done = false;
            do{
                echo "(si desea volver al menu anterior teclee 'salir')";
                echo "\nIngrese el id del viaje de la lista de arriba: ";
                $nViaje= trim(fgets(STDIN));
                // inicio el objeto viaje para pasarlo
                $objViaje = new viaje();
                $objViaje->Buscar($nViaje);
                if(array_search($nViaje,$arrayDeIds)){
                    /* if(!$flag){
                        $viejoPas = new pasajero();
                        $viejoPas->Buscar($dni);
                        $viejoPas->eliminar();
                        // reseteo el obj pasajero 
                        $modPasajero = NULL;
                        $modPasajero = new pasajero();
                    } */
                    
                    $modPasajero->setRdocumento($dni);
                    $modPasajero->setPnombre($nNombre);
                    $modPasajero->setPapellido($nApellido);
                    $modPasajero->setPtelefono($nTelefono);
                    $modPasajero->setObjViaje($objViaje);
                    echo $modPasajero;
                    /* $respuesta = $modPasajero->modificar();
                    echo "\n/////////////////////////
                    \n".$respuesta."\n "; */
                    $done = true;
                    $salir = true;
                }if($nViaje == "salir"){
                    $done = true;
                }else{
                    echo "\nese id no existe";
                }
            }while(!$done);
        }else{
            echo "\nEse dni no existe en la lista";
        }
    }while(!$salir);
    menuPasajeros($id);
}

function eliminarPasajero($id){
    echo "\n-------eliminar pasajero-------\n
    \nA continuacion se muestran los pasajeros del idviaje ".$id."
    \n";
    echo listarPasajeros($id);
    
    $salir = false;
    do{
        echo "\n 
        \nIngrese el documento del pasajero(ingrese 'salir' si desea volver): ";
        $dni = trim(fgets(STDIN));
        $nuevoPasajero = new pasajero();
        $nuevoPasajero->buscar($dni);
        echo "\nEsta seguro de seguir? (s/n): ";
        $opc = trim(fgets(STDIN));
        if($opc == "s"){
            $nuevoPasajero->eliminar();
            $salir = true;
        }if($opc == "n"){
            $salir = true;
        }
    }while(!$salir);

}

function listarPasajeros($id){
    $obj_viaje = new viaje();
    $listaPasajeros = $obj_viaje->listarColPasajeros($id);
    $txt = "";
    foreach($listaPasajeros as $pasajero){
        $txt .= $pasajero;
    }
    return $txt;
}

function mostrarLugaresDisponibles($id){
    $obj_viaje = new viaje();
    $lugaresDisponibles = $obj_viaje->lugaresDisponibles($id);
    return $lugaresDisponibles;
}

function agregarViaje(){
    $nuevoViaje = new viaje();
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se le pedira los siguientes datos:
    \n - destino - cantMaxPasajeros - id empresa - responsable - importe - tipo asiento - ida y vuelta 
    \n
    \n";
    do{
        echo "Ingrese el destino: ";
        $verdad = false;
        do{
            $destino = trim(fgets(STDIN));
            if($nuevoViaje->listar("vdestino = '".$destino."'")){ //
                echo "\nEste destino ya esta en uso!
                \nporfavor ingrese otro: ";
            }else{
                $verdad = true;
            }

        }while(!$verdad);

        echo "Ingrese cantMaxPasajeros: ";
        $cantMaxPasajeros = trim(fgets(STDIN));
    //---------
        echo "\n A continuacion se listaran las empresas
        ";
        $obj_empresa =  new empresa();
        $colempresas = $obj_empresa->listar("");
        $arrayDeIds = array(0);
        foreach ($colempresas as $unaempresa) {
            array_push($arrayDeIds,$unaempresa->getIdempresa());
            echo $unaempresa;
            echo "-------------------------------------------------------";
        }

    //---------
        echo "\nIngrese el id empresa: ";
        $empresa = trim(fgets(STDIN));
    //---------
        echo "\nA continuacion se muestran los responsables de los viajes que posee la empresa
        \n";
        $obj_responsable = new responsable();
        $colresponsable = $obj_responsable->listar();
        $arrayDeIds = array(0);
        foreach ($colresponsable as $unresp) {
            array_push($arrayDeIds,$unresp->getRnumeroempleado());
            echo $unresp;
            echo "-------------------------------------------------------";
        }
    //---------
        echo "\nIngrese el responsable: ";
        $responsable = trim(fgets(STDIN));
        echo "Ingrese el importe: ";
        $importe = trim(fgets(STDIN));
        echo "\nIngrese el tipo asiento: ";
        $tipoasiento = trim(fgets(STDIN));
        echo "\nIngrese el tipo ida y vuelta : ";
        $idayvuelta = trim(fgets(STDIN));
        /////////////////////////
        echo "\n
        \nLos datos que ingreso son los siguientes:
        \n - " . $destino . " - " . $cantMaxPasajeros . " - " .$empresa. " - " .$responsable. " - " . $importe. " - " .$tipoasiento. " - " . $idayvuelta . " \n".
        "\nSon correctos los datos?
            \n1- Si
            \n2- No (volver al menu principal)
            \n
            \nSeleccione su opcion: ";
            $sel = trim(fgets(STDIN));
        if($sel > 0 && $sel < 3){
            switch($sel){
                case 1:
                    ////////////// iniciando nueva clase
                    $newViaje =  new viaje();
                    $autoid=$newViaje->contarIdviaje();
                    do{
                            //
                        $OBJempresa = new empresa();
					    $OBJempresa->Buscar($empresa);
                            //
                        $OBJempleado = new responsable();
					    $OBJempleado->Buscar($responsable);

                        $newViaje->cargar($autoid,$destino,$cantMaxPasajeros,$OBJempresa,$OBJempleado,$importe,$tipoasiento,$idayvuelta);
                        $respuesta = $newViaje->insertar();
                        $autoid++;
                    }while(!$respuesta);

                    echo "\nVolviendo al menu anterior\n\n";
                    menuViajes();
                    break;
                case 2:
                    menuViajes();
                    break;
            }
        }else{
            echo "la seleccion es invalida" . "\n" .
                "Porfavor ingrese una opcion del 1 al 2." . "\n";
        }

    }while($sel > 2);

}

function modificarViaje(){
    echo "\n ++++++++++++++++++++++++++++++++++
    \n------ modificar viaje -------
    \nA continuacion se muestran los viajes que puede modificar";
    $viajes = new viaje();
    $colViajes = $viajes->listar("");
    foreach ($colViajes as $viaje){
        echo $viaje ."\n--------------------------\n";
    }
    $salir=false;
    do{
        echo "\n(Si desea volver atras escriba 'salir')";
        echo "\n Ingrese la id de la empresa que desea modificar: ";
        $opc = trim(fgets(STDIN));
        if($viajes->listar("viaje.idviaje = ".$opc)){
            $salir = true;
        }else{
            echo "\nla id que ingreso es invalida\n";
        }
    }while(!$salir);

    echo "\n A continuacion se le pedira los siguientes datos:
    \n - destino - cantMaxPasajeros - id empresa - responsable - importe - tipo asiento - ida y vuelta 
    \n
    \n";
    do{
        echo "Ingrese el destino: ";
        $verdad = false;
        do{
            $destino = trim(fgets(STDIN));
            if($viajes->listar("vdestino = '".$destino."'")){
                echo "\nEste destino ya esta en uso!
                \nporfavor ingrese otro: ";
            }else{
                $verdad = true;
            }

        }while(!$verdad);

        echo "Ingrese cantMaxPasajeros: ";
        /* $cantMaxPasajeros = trim(fgets(STDIN)); */
        ///////////////////////////////////////////////////////////

        $bd = new BaseDatos();
        $query  = "SELECT COUNT(*) as total FROM viaje INNER JOIN pasajero ON pasajero.idviaje = viaje.idviaje WHERE pasajero.idviaje = " . $opc;
        if($bd->iniciar()){
            if ($bd->Ejecutar($query)){
                if ($tot = $bd->Registro()){
                    $cantPas = $tot['total'];
                }
            }
        }
        
        $otraVerdad = false;
        do{
            $cantMaxPasajeros = trim(fgets(STDIN));
            if($cantMaxPasajeros < $cantPas){
                echo "\nLa cantidad maxima no debe ser menos a la cantida de pasajeros que hay en el viaje
                \nporfavor ingrese otro: ";
            }else{
                $otraVerdad = true;
            }

        }while(!$otraVerdad);
        ////////////////////////////////////////////////////////////
    //---------
        echo "\n A continuacion se listaran las empresas
        ";
        $obj_empresa =  new empresa();
        $colempresas = $obj_empresa->listar("");
        $arrayDeIds = array(0);
        foreach ($colempresas as $unaempresa) {
            array_push($arrayDeIds,$unaempresa->getIdempresa());
            echo $unaempresa;
            echo "-------------------------------------------------------";
        }

    //---------
        echo "\nIngrese el id empresa: ";
        $empresa = trim(fgets(STDIN));
    //---------
        echo "\nA continuacion se muestran los responsables de los viajes que posee la empresa
        \n";
        $obj_responsable = new responsable();
        $colresponsable = $obj_responsable->listar();
        $arrayDeIds = array(0);
        foreach ($colresponsable as $unresp) {
            array_push($arrayDeIds,$unresp->getRnumeroempleado());
            echo $unresp;
            echo "-------------------------------------------------------";
        }
    //---------
        echo "\nIngrese el responsable: ";
        $responsable = trim(fgets(STDIN));
        echo "Ingrese el importe: ";
        $importe = trim(fgets(STDIN));
        echo "\nIngrese el tipo asiento: ";
        $tipoasiento = trim(fgets(STDIN));
        echo "\nIngrese el tipo ida y vuelta : ";
        $idayvuelta = trim(fgets(STDIN));
        /////////////////////////
        echo "\n
        \nLos datos que ingreso son los siguientes:
        \n - " . $destino . " - " . $cantMaxPasajeros . " - " .$empresa. " - " .$responsable. " - " . $importe. " - " .$tipoasiento. " - " . $idayvuelta . " \n".
        "\nSon correctos los datos?
            \n1- Si
            \n2- No (volver al menu principal)
            \n
            \nSeleccione su opcion: ";
            $sel = trim(fgets(STDIN));
        if($sel > 0 && $sel < 3){
            switch($sel){
                case 1:
                    ////////////// iniciando nueva clase
                    $newViaje =  new viaje();
                    $newViaje->Buscar($opc);
                    $newViaje->setVdest($destino);
                    $newViaje->setVcantmaxpasajeros($cantMaxPasajeros);
                    // busco el obj Empresa
                    $OBJempresa = new empresa();
					$OBJempresa->Buscar($empresa);
                    $newViaje->setobjEmpresa($OBJempresa);
                    // busco el obj resp
                    $OBJempleado = new responsable();
					$OBJempleado->Buscar($responsable);
                    $newViaje->setobjResp($OBJempleado);
                    $newViaje->setVimporte($importe);
                    $newViaje->setTipoasiento($tipoasiento);
                    $newViaje->setIdayvuelta($idayvuelta);
                    $validar = $newViaje->modificar();
                    if($validar){

                    }else{
                        echo $newViaje->getmensajeoperacion();
                    }

                    echo "\nModificado con exito! 
                    \n";
                    echo "\nVolviendo al menu anterior\n\n";
                    menuViajes();
                    break;
                case 2:
                    menuViajes();
                    break;
            }
        }else{
            echo "la seleccion es invalida" . "\n" .
                "Porfavor ingrese una opcion del 1 al 2." . "\n";
        }

    }while($sel > 2);




}

function eliminarViaje(){
    echo "\n-------eliminar viaje-------\n
    \nA continuacion se muestran los viajes de la empresa
    \n";
    $obj_viaje = new viaje();
    $colViajes = $obj_viaje->listar();
    $arrayDeIds = array(0);
    foreach ($colViajes as $unviaje) {
        array_push($arrayDeIds,$unviaje->getIdviaje());
        echo $unviaje;
        echo "-------------------------------------------------------";
    }
    $salir = false;
    do{
    echo "\n 
    \nIngrese la id del viaje(ingrese 'salir' si desea volver): ";
    $id = trim(fgets(STDIN));
    $obj_viaje->buscar($id);
    echo "\n AVISO: Si el viaje posee pasajeros el mismo no puede ser eliminado, de lo contrario, se puede eliminar
    \nEsta seguro de seguir? (s/n): ";
    $opc = trim(fgets(STDIN));
    if($opc == "s"){
        $obj_viaje->eliminar();
        $salir = true;
    }if($opc == "n"){
        $salir = true;
    }
    }while(!$salir);
}

function subMenuResponsable(){
    echo "\n-------SubMenu Responsables-------\n
        \nA continuacion se muestran los responsables de los viajes que posee la empresa
        \n";
        $obj_responsable = new responsable();
        $colresponsable = $obj_responsable->listar();
        $arrayDeIds = array(0);
        foreach ($colresponsable as $unresp) {
            array_push($arrayDeIds,$unresp->getRnumeroempleado());
            echo $unresp;
            echo "-------------------------------------------------------";
        }
        $salir=false;
        do{
            echo "\n
            \n--Opciones--
            \n
            \n1- Agregar nuevo Responsable
            \n2- Modificar Responsable
            \n3- Eliminar responsable
            \n";
            echo "\n(Si desea volver atras escriba 'salir')";
            echo "\n Ingrese la opcion ";
            $opc = trim(fgets(STDIN));
            if ($opc == 1) {
                agregarResponsable();
            }if($opc == 2){
                modificarResponsable();
            }if($opc == 3){
                eliminarResponsable();
            }if($opc == "salir"){
                $salir = true;
            }
            else{
                echo "\nEsa id no existe, porfavor ingrese la id: ";
            }

        }while(!$salir);


    echo "\n Volviendo al menu anterior\n";
    menuViajes();
}

function agregarResponsable(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se le pedira los siguientes datos:
    \n - nombre - apellido - nro licencia
    \n
    \n";
    do{
        echo "Ingrese el nombre: ";
        $rnombre = trim(fgets(STDIN));
        echo "\nIngrese el apellido: ";
        $rapellido = trim(fgets(STDIN));
        echo "\nIngrese el Nro Licencia: ";
        $rnumerolicencia = trim(fgets(STDIN));
        echo "\n
        \nLos datos que ingreso son los siguientes:
        \n - " . $rnombre . " - " . $rapellido . " - " . $rnumerolicencia . " \n".
        "\nSon correctos los datos?
            \n1- Si
            \n2- No (volver al menu principal)
            \n
            \nSeleccione su opcion: ";
            $sel = trim(fgets(STDIN));
        if($sel > 0 && $sel < 3){
            switch($sel){
                case 1:
                    ////////////// iniciando nueva clase
                    $obj_responsable =  new responsable();
                    $autoid=$obj_responsable->contarIdresponsable();
                    do{
                        $obj_responsable->cargar($autoid,$rnumerolicencia,$rnombre,$rapellido);
                        $respuesta = $obj_responsable->insertar();
                        $autoid++;
                    }while(!$respuesta);

                    echo "\nVolviendo al menu anterior\n\n";
                    subMenuResponsable();
                    break;
                case 2:
                    subMenuResponsable();
                    break;
            }
        }else{
            echo "la seleccion es invalida" . "\n" .
                "Porfavor ingrese una opcion del 1 al 2." . "\n";
        }

    }while($sel > 2);
}

function modificarResponsable(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se listaran los responsables
    ";
    $obj_responsable =  new responsable();
    $colresponsables = $obj_responsable->listar("");
    $arrayDeIds = array(0);
    foreach ($colresponsables as $unaresponsable) {
        array_push($arrayDeIds,$unaresponsable->getRnumeroempleado());
        echo $unaresponsable;
        echo "-------------------------------------------------------";
    }
    $salir=false;
    do{
        echo "\n(Si desea volver atras escriba 'salir')";
        echo "\n Ingrese la id de la empresa que desea modificar: ";
        $opc = trim(fgets(STDIN));
        if (array_search($opc, $arrayDeIds)) {
            $obj_responsable->Buscar($opc);
            echo "El nombre y apellido actual es: -" . $obj_responsable->getRnombre() . " - " .  $obj_responsable->getRapellido() . "
            \nEl numero de licencia es: ". $obj_responsable->getRnumerolicencia() ."
                \n\n Ingrese el nombre y el apellido junto con la licencia a modificar: \n\n";
            echo "Ingrese el nombre: ";
            $rnombre = trim(fgets(STDIN));
            echo "\nIngrese el apellido: ";
            $rapellido = trim(fgets(STDIN));
            echo "\nIngrese el Nro Licencia: ";
            $rnumerolicencia = trim(fgets(STDIN));
            echo "\n
                    \nLos datos que ingreso son los siguientes:
                    \n - " . $rnombre . " - " . $rapellido . " - " . $rnumerolicencia . " \n";

            $obj_responsable->setRnumeroempleado($opc);
            $obj_responsable->setRnumerolicencia($rnumerolicencia);
            $obj_responsable->setRnombre($rnombre);
            $obj_responsable->setRapellido($rapellido);
            $obj_responsable->modificar();

            $salir = true;
        }if($opc == "salir"){
            $salir = true;
        }
         else{
            echo "\nEsa id no existe, porfavor ingrese la id: ";
        }

    }while(!$salir);
    subMenuResponsable();
}

function eliminarResponsable(){
    echo "+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    \n A continuacion se listaran los responsables
    ";
    $obj_responsable =  new responsable();
    $colresponsables = $obj_responsable->listar("");
    $arrayDeIds = array(0);
    foreach ($colresponsables as $unaresponsable) {
        array_push($arrayDeIds,$unaresponsable->getRnumeroempleado());
        echo $unaresponsable;
        echo "-------------------------------------------------------";
    }
    $salir=false;
    do{
        echo "\nEsta seguro de querer eliminar el responsable? recuerde que si el responsable \n
        esta en un viaje no se puede eliminar, a menos que no este en ningun viaje
        \n(Si desea volver atras escriba 'salir')";
        echo "\n Ingrese la id de la empresa que desea eliminar: ";
        $opc = trim(fgets(STDIN));
        if (array_search($opc, $arrayDeIds)) {
            $obj_responsable->Buscar($opc);
            $obj_responsable->eliminar();
            $salir = true;
        }if($opc == "salir"){
            $salir = true;
        }
         else{
            echo "\nEsa id no existe, porfavor ingrese la id: ";
        }

    }while(!$salir);
    echo "\n\nVolviendo al menu principal\n\n";
    subMenuResponsable();
}




// Inicio del programa
menuEmpresa(); 

?>