<?php
include_once "BaseDatos.php";
class empresa{

	private $idempresa,$enombre,$edireccion;
	
	public function __construct(){
		
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";

	}

	public function cargar($idempresa,$enombre,$edireccion){		

        $this->setIdempresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
    }
	
	public function getIdempresa(){
        return $this->idempresa;
    }
    public function setIdempresa($nid){
        $this->idempresa = $nid;
    }
    public function getEnombre(){
        return $this->enombre;
    }
    public function setEnombre($nnom){
        $this->enombre = $nnom;
    }
    public function getEdireccion(){
        return $this->edireccion;
    }
    public function setEdireccion($ndir){
        $this->edireccion = $ndir;
    }
    

	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	

	/**
	 * Recupera los datos de una empresa por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($idem){
		$base=new BaseDatos();
		$consultaempresa="Select * from empresa where idempresa=".$idem;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaempresa)){
				if($row2=$base->Registro()){
					$this->setIdempresa($idem);
					$this->setEnombre($row2['enombre']);
					$this->setEdireccion($row2['edireccion']);
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
	    $arregloempresa = null;
		$base=new BaseDatos();
		$consultaempresas="Select * from empresa ";
		if ($condicion!=""){
		    $consultaempresas=$consultaempresas.' where '.$condicion;
		}
		$consultaempresas.=" order by enombre ";
		//echo $consultaempresas;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaempresas)){				
				$arregloempresa= array();
				while($row2=$base->Registro()){
                    
					$idempresa=$row2['idempresa'];
					$enombre=$row2['enombre'];
					$edireccion=$row2['edireccion'];

					$perso=new empresa();
					$perso->cargar($idempresa,$enombre,$edireccion);
					array_push($arregloempresa,$perso);
	
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloempresa;
	}	


	
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
		$consultaInsertar="INSERT INTO empresa(idempresa,enombre,edireccion) 
				VALUES (".$this->getIdempresa().",'".$this->getEnombre()."','".$this->getEdireccion()."')";
		
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
		$consultaModifica="UPDATE empresa SET enombre='".$this->getEnombre()."',edireccion='".$this->getEdireccion()."' WHERE idempresa=". $this->getIdempresa();
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
				$consultaBorra="DELETE FROM empresa WHERE idempresa=". $this->getIdempresa();
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


/// contar las id incrementales de las empresas 
	public function contarIdEmpresas()
	{
		$base = new BaseDatos();
		$consulta = "SELECT MAX(idempresa) as total
                    FROM empresa";
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

//// modificar empresa


	public function __toString(){
	    return "\nId empresa: ". $this->getIdempresa()."\nnombre: ". $this->getEnombre(). "\tDireccion: ". $this->getEdireccion(). "\n";
			
	}
}
?>
