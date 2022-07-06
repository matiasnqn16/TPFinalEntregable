<?php
include_once "BaseDatos.php";
class viaje{

	private $idviaje,$vdest,$vcantmaxpasajeros,$rdocumento,$objEmpresa,$objResp,$vimporte,$tipoasiento,$idayvuelta;
	
	public function __construct(){
		
		$this->idviaje = "";
		$this->vdest = "";
		$this->vcantmaxpasajeros = "";
		$this->rdocumento = "";
		$this->objEmpresa = "";
		$this->objResp = "";
		$this->vimporte = "";
		$this->tipoasiento = "";
		$this->idayvuelta = "";

	}

	public function cargar($idviaje,$vdestino,$vcantmaxpasajeros,$objEmpresa,$objResp,$vimporte,$tipoasiento,$idayvuelta){
		$this->setIdviaje($idviaje);
		$this->setVdest($vdestino);
		$this->setVcantmaxpasajeros($vcantmaxpasajeros);
		$this->setobjEmpresa($objEmpresa); // obj empresa
		$this->setobjResp($objResp); // obj empleado
		$this->setVimporte($vimporte);
		$this->setTipoasiento($tipoasiento);
		$this->setIdayvuelta($idayvuelta);		
		
    }
	
	public function getIdviaje(){
		return $this->idviaje;
	}
	public function setIdviaje($nidviaje){
		$this->idviaje = $nidviaje;
	}
	public function getVdest(){
		return $this->vdest;
	}
	public function setVdest($nvdest){
		$this->vdest = $nvdest;
	}
	public function getVcantmaxpasajeros(){
		return $this->vcantmaxpasajeros;
	}
	public function setVcantmaxpasajeros($nvcant){
		$this->vcantmaxpasajeros = $nvcant;
	}
	public function getobjEmpresa(){
		return $this->objEmpresa;
	}
	public function setobjEmpresa($nidemp){
		$this->objEmpresa = $nidemp;
	}
	public function getobjResp(){
		return $this->objResp;
	}
	public function setobjResp($nrnumempleado){
		$this->objResp = $nrnumempleado;
	}
	public function getVimporte(){
		return $this->vimporte;
	}
	public function setVimporte($nvimporte){
		$this->vimporte = $nvimporte;
	}
	public function getTipoasiento(){
		return $this->tipoasiento;
	}
	public function setTipoasiento($ntipo){
		$this->tipoasiento = $ntipo;
	}
	public function getIdayvuelta(){
		return $this->idayvuelta;
	}
	public function setIdayvuelta($nidayvuelta){
		$this->idayvuelta = $nidayvuelta;
	}


	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	

	
	

	/**
	 * Recupera los datos de una viaje por id
	 * @param int $idviaje
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idvia){
		$base=new BaseDatos();
		$consultaviaje="Select * from viaje where idviaje=".$idvia;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaviaje)){
				if($row2=$base->Registro()){
					$this->setIdviaje($idvia);
					$this->setVdest($row2['vdestino']);
					$this->setVcantmaxpasajeros($row2['vcantmaxpasajeros']);
					$this->setobjEmpresa($row2['idempresa']);
					$this->setobjResp($row2['rnumeroempleado']);
					$this->setVimporte($row2['vimporte']);
					$this->setTipoasiento($row2['tipoAsiento']);
					$this->setIdayvuelta($row2['idayvuelta']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }		
		 return $resp;
	}	
    

	public function listar($condicion=""){
	    $arregloviaje = null;
		$base=new BaseDatos();
		$consultaviajes="Select * from viaje ";
		if ($condicion!=""){
		    $consultaviajes=$consultaviajes.' where '.$condicion;
		}
		$consultaviajes.=" order by vdestino ";
		//echo $consultaviajes;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaviajes)){				
				$arregloviaje= array();
				while($row2=$base->Registro()){


					$idviaje=$row2['idviaje'];
					$vdestino=$row2['vdestino'];
					$vcantmaxpasajeros=$row2['vcantmaxpasajeros'];
					
					$idmpresa=$row2['idempresa'];
					$empresa = new empresa();
					$empresa->Buscar($idmpresa);

					$idesp=$row2['rnumeroempleado'];
					$empleado = new responsable();
					$empleado->Buscar($idesp);

					$vimporte=$row2['vimporte'];
					$tipoasiento=$row2['tipoAsiento'];
					$idayvuelta=$row2['idayvuelta'];
				
					$perso=new viaje();
					$perso->cargar($idviaje,$vdestino,$vcantmaxpasajeros,$empresa,$empleado,$vimporte,$tipoasiento,$idayvuelta);
					/* var_dump($perso); */
					array_push($arregloviaje,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloviaje;
	}	

	public function listarColPasajeros($idViaje){
	    $arreglopasajero = null;
		$base=new BaseDatos();
		$consultapasajeros="Select * from pasajero ";
		$condicion="idviaje = ".$idViaje;
		if ($condicion!=""){
		    $consultapasajeros=$consultapasajeros.' where '.$condicion;
		}
		$consultapasajeros.=" order by papellido ";
		//echo $consultapasajeros;
		if($base->Iniciar()){
			if($base->Ejecutar($consultapasajeros)){				
				$arreglopasajero= array();
				while($row2=$base->Registro()){
					
					$rdoc=$row2['rdocumento'];
					$pnom=$row2['pnombre'];
					$pap=$row2['papellido'];
					$ptel=$row2['ptelefono'];
					$idvia=$row2['idviaje'];
				
					$perso=new pasajero();
					$perso->cargar($rdoc,$pnom,$pap,$ptel,$idvia);
					array_push($arreglopasajero,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arreglopasajero;  
	}	

	///// calcular lugares disponibles
	public function lugaresDisponibles($idViaje)
	{
		$base = new BaseDatos();
		$consulta = "SELECT COUNT(*) as total FROM viaje INNER JOIN pasajero ON pasajero.idviaje = viaje.idviaje WHERE pasajero.idviaje = ".$idViaje;
		$this->Buscar($idViaje);
		$cantMaxPas = $this->getVcantmaxpasajeros();
		if ($base->iniciar()) {
			if ($base->Ejecutar($consulta)) {
				if ($tot = $base->Registro()) {
					$cantPas = $tot['total'];
					$lugares = $cantMaxPas - $cantPas;
				}
			}
		}
		return $lugares;
	}

	public function contarIdviaje()
	{
		$base = new BaseDatos();
		$consulta = "SELECT MAX(idviaje) as total
                    FROM viaje";
		$autoid = 0;
		if ($base->iniciar()) {
			if ($base->Ejecutar($consulta)) {
				if ($tot = $base->Registro()) {
					$autoid = $tot['total'];
					$autoid++;
				}
			}
		}
		return $autoid;
	}
	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		
		$consultaInsertar="INSERT INTO viaje(idviaje,vdestino,vcantmaxpasajeros,idempresa,rnumeroempleado,vimporte,tipoAsiento,idayvuelta) 
				VALUES (".$this->getIdviaje().",'".$this->getVdest()."','".$this->getVcantmaxpasajeros()."','".$this->getobjEmpresa()."','".$this->getobjResp()."','".$this->getVimporte()."','".$this->getTipoasiento()."','".$this->getIdayvuelta()."')";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

			    $resp=  true;

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	
	
	public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getVdest()."',vcantmaxpasajeros='".$this->getVcantmaxpasajeros()."',idempresa='". $this->getobjEmpresa()."',rnumeroempleado='". $this->getobjResp()."',vimporte='". $this->getVimporte()."',tipoAsiento='". $this->getTipoasiento()."',idayvuelta='". $this->getIdayvuelta()."' WHERE idviaje=". $this->getIdviaje();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());
				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
	public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorra="DELETE FROM viaje WHERE idviaje=". $this->getIdviaje();
				if($base->Ejecutar($consultaBorra)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

	public function __toString(){
	    return "\nId viaje: ". $this->getIdviaje()."\tdestino: ". $this->getVdest()."\tcant max pasajeros: ". $this->getVcantmaxpasajeros()."\tid empresa: ". $this->getobjEmpresa()->getIdempresa()."\nnumero de empleado: ". $this->getobjResp()->getRnumeroempleado()."\timporte: ". $this->getVimporte()."\ttipo asiento: ". $this->getTipoasiento()."\tida y vuelta: ". $this->getIdayvuelta()."\n";
			
	}
}
?>
