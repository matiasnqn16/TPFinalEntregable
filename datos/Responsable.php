<?php
include_once "BaseDatos.php";
class responsable{

	private $rnumeroempleado,$rnumerolicencia,$rnombre,$rapellido;
	
	public function __construct(){
		
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
        $this->rnombre = "";
        $this->rapellido = "";

	}

	public function cargar($rnumeroempleado,$rnumerolicencia,$rnombre,$rapellido){
		$this->setRnumeroempleado($rnumeroempleado);
        $this->setRnumerolicencia($rnumerolicencia);
        $this->setRnombre($rnombre);
        $this->setRapellido($rapellido);
		
    }
	
	public function getRnumeroempleado(){
        return $this->rnumeroempleado;
    }
    public function setRnumeroempleado($nnum){
        $this->rnumeroempleado = $nnum;
    }
    public function getRnumerolicencia(){
        return $this->rnumerolicencia;
    }
    public function setRnumerolicencia($nlic){
        $this->rnumerolicencia = $nlic;
    }
    public function getRnombre(){
        return $this->rnombre;
    }
    public function setRnombre($nnom){
        $this->rnombre = $nnom;
    }
    public function getRapellido(){
        return $this->rapellido;
    }
    public function setRapellido($nap){
        $this->rapellido = $nap;
    }


	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}
	public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	

	
	

	/**
	 * Recupera los datos de una responsable por id
	 * @param int $rnum
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($rnum){
		$base=new BaseDatos();
		$consultaresponsable="Select * from responsable where rnumeroempleado=".$rnum;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaresponsable)){
				if($row2=$base->Registro()){
                    $this->setRnumeroempleado($rnum);
                    $this->setRnumerolicencia($row2['rnumerolicencia']);
                    $this->setRnombre($row2['rnombre']);
                    $this->setRapellido($row2['rapellido']);
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
	    $arregloresponsable = null;
		$base=new BaseDatos();
		$consultaresponsables="Select * from responsable ";
		if ($condicion!=""){
		    $consultaresponsables=$consultaresponsables.' where '.$condicion;
		}
		$consultaresponsables.=" order by rapellido ";
		//echo $consultaresponsables;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaresponsables)){			$arregloresponsable= array();
				while($row2=$base->Registro()){

                    $rnumeroempleado=$row2['rnumeroempleado'];
                    $rnumerolicencia=$row2['rnumerolicencia'];
                    $rnombre=$row2['rnombre'];
                    $rapellido=$row2['rapellido'];
				
					$perso=new responsable();
					$perso->cargar($rnumeroempleado,$rnumerolicencia,$rnombre,$rapellido);
					array_push($arregloresponsable,$perso);
				}
				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloresponsable;
	}	

	public function contarIdresponsable()
	{
		$base = new BaseDatos();
		$consulta = "SELECT MAX(rnumeroempleado) as total
                    FROM responsable";
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
		$consultaInsertar="INSERT INTO responsable(rnumeroempleado,rnumerolicencia,rnombre,rapellido) 
				VALUES (".$this->getRnumeroempleado().",'".$this->getRnumerolicencia()."','".$this->getRnombre()."','".$this->getRapellido()."')";
		
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
		$consultaModifica="UPDATE responsable SET rnumerolicencia='". $this->getRnumerolicencia()."',rnombre='". $this->getRnombre()."',rapellido='". $this->getRapellido()."' WHERE rnumeroempleado=". $this->getRnumeroempleado();
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
				$consultaBorra="DELETE FROM responsable WHERE rnumeroempleado=". $this->getRnumeroempleado();
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
	    return "\nnumero Empleado: ". $this->getRnumeroempleado()."\nnumero Licencia: ". $this->getRnumerolicencia()."\nnombre: ". $this->getRnombre()."\napellido: ". $this->getRapellido()."\n";
			
	}
}
?>
