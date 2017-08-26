<?php

class usuario
{
	public $id;
 	public $nombre;
  	public $tipo;
	  public $estado;
	  public $password;
      
  	public function BorrarUsuario()
	 {//BORRADO LOGICO CAMBIA SU ESTADO DE HABILITADO A DESHABILITADO
	 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
			update usuarios 
			set estado='DESHABILITADO'
			
		
			WHERE id='$this->id'");
				$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }
	/*public static function BorrarCdPorAnio($año)
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from cds 				
				WHERE jahr=:anio");	
				$consulta->bindValue(':anio',$año, PDO::PARAM_INT);		
				$consulta->execute();
				return $consulta->rowCount();
	 }*/
	public function ModificarUsuario()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuarios 
				set nombre='$this->nombre',
				tipo='$this->tipo'
			
				WHERE id='$this->id'");
			return $consulta->execute();
	 }
	
	 public function BuscarUsuario($pass, $nombre)
	 {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select  *from usuarios where nombre =:Nombre and password= :pass ");
		$consulta->bindParam(":Nombre", $nombre,PDO::PARAM_STR);
		$consulta->bindParam(":pass", $pass,PDO::PARAM_STR);
		$consulta->execute();	
		$usuarioBuscado= $consulta->fetchObject('usuario');
		return $usuarioBuscado;				
		

	 }
  
	 public function InsertarElUsuario()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre,tipo)values('$this->nombre','$this->tipo)");
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
				
	 }
	  public function ModificarUsuarioParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuarios
				set nombre=:nombre,
				tipo=:tipo,
				password=:pass
				
				WHERE id=:id");
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_INT);
			$consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
			$consulta->bindValue(':pass', $this->pass, PDO::PARAM_STR);
			
	
			return $consulta->execute();
	 }
	 public function InsertarElUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuarios (nombre,tipo, estado,password)values(:nombre,:tipo, :estado,:pass)");
				$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_INT);
				$consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
				$consulta->bindValue(':estado', 'HABILITADO', PDO::PARAM_STR);
				$consulta->bindValue(':pass',$this->password, PDO::PARAM_STR);

				$consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }
	 public function GuardarUsuario()
	 {
	 	if($this->id>0)
	 		{
	 			$this->ModificarUsuarioParametros();
	 		}else {
	 			$this->InsertarElUsuarioParametros();
	 		}
	 }
  	public static function TraerTodoLosUsuarios()
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id ,nombre,  tipo, estado, password   from usuarios");
			$consulta->execute();	
			$usuarios = $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");
			
			$usuariosHabilitados = array();
			foreach($usuarios as $user)
			{
				if($user->estado=="HABILITADO")
				{
					$usuariosHabilitados[] = $user;

				}

			}
			//return $consulta->fetchAll(PDO::FETCH_CLASS, "usuario");	
			
			return $usuariosHabilitados;	
	}
	public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select id, nombre, tipo  from usuarios where id = $id");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('usuario');
			return $usuarioBuscado;				
			
	}
	/*public static function TraerUnCdAnio($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=? AND jahr=?");
			$consulta->execute(array($id, $anio));
			$cdBuscado= $consulta->fetchObject('cd');
      		return $cdBuscado;				
			
	}*/
	/*public static function TraerUnCdAnioParamNombre($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=:id AND jahr=:anio");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('cd');
      		return $cdBuscado;				
			
	}*/
	
	/*public static function TraerUnCdAnioParamNombreArray($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select  titel as titulo, interpret as cantante,jahr as año from cds  WHERE id=:id AND jahr=:anio");
			$consulta->execute(array(':id'=> $id,':anio'=> $anio));
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('cd');
      		return $cdBuscado;				
			
	}*/
	public function mostrarDatos()
	{
	  	return "Metodo mostar:".$this->nombre."  ".$this->tipo."  ".$this->tipo;
	}
}

?>