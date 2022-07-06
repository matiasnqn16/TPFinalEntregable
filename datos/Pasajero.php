<?php
include_once "BaseDatos.php";
class pasajero{

	private $rdocumento,$pnombre,$papellido,$ptelefono,$ObjViaje;
	
	public function __construct(){
		
		$this->rdocumento = "";
		$this->pnombre = "";
		$this->papellido = "";
		$this->ptelefono = "";
		$this->ObjViaje = "";
	}

	public function cargar($rdoc,$pnom,$pap,$ptel,$objViaje){		
		$this->setRdocumento($rdoc);
		$this->setPnombre($pnom);
		$this->setPapellido($pap);
		$this->setPtelefono($ptel);
		$this->setObjViaje($objViaje);
    }
	
	public function getRdocumento(){
		return $this->rdocumento;
	}
	public function setRdocumento($nrdoc){
		$this->rdocumento = $nrdoc;
	}
	public function getPnombre(){
		return $this->pnombre;
	}
	public function setPnombre($npnombre){
		$this->pnombre = $npnombre;
	}
	public function getPapellido(){
		return $this->papellido;
	}
	public function setPapellido($npapellido){
		$this->papellido = $npapellido;
	}
	public function getPtelefono(){
		return $this->ptelefono;
	}
	public function setPtelefono($nptelefono){
		$this->ptelefono = $nptelefono;
	}
	public function getObjViaje(){
		return $this->ObjViaje;
	}
	public function setObjViaje($nObjViaje){
		$this->ObjViaje = $nObjViaje;
	}
	
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	

	/**
	 * Recupera los datos de una pasajero por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($rdoc){
		$base=new BaseDatos();
		$consultapasajero="Select * from pasajero where rdocumento=".$rdoc;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultapasajero)){
				if($row2=$base->Registro()){
					$this->setRdocumento($rdoc);
					$this->setPnombre($row2['pnombre']);
					$this->setPapellido($row2['papellido']);
					$this->setPtelefono($row2['ptelefono']);
					$this->setObjViaje($row2['idviaje']);
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
	    $arreglopasajero = null;
		$base=new BaseDatos();
		$consultapasajeros="Select * from pasajero ";
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
					///////////////
					$idvia=$row2['idviaje'];
					$viaje  = new viaje();
					$viaje->Buscar($idvia);
				
					$perso=new pasajero();
					$perso->cargar($rdoc,$pnom,$pap,$ptel,$viaje);
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


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO pasajero(rdocumento,pnombre,papellido,ptelefono,idviaje) 
				VALUES (".$this->getRdocumento().",'".$this->getPnombre()."','".$this->getPapellido()."','".$this->getPtelefono()."','".$this->getObjViaje()."')";
		
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
		$consultaModifica="UPDATE pasajero SET pnombre='".$this->getPnombre()."',papellido='".$this->getPapellido()."',ptelefono='".$this->getPtelefono()."',idviaje='".$this->getObjViaje()."' WHERE rdocumento=". $this->getRdocumento();
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
				$consultaBorra="DELETE FROM pasajero WHERE rdocumento=". $this->getRdocumento();
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
	    return "\nNombre: ".$this->getPnombre(). "\n Apellido:".$this->getPapellido(). "\n Telefono:".$this->getPtelefono().
		"\n DNI: ".$this->getRdocumento()."\n";
			
	}
}
?>
