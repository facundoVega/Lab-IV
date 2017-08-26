<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';
require_once 'AutentificadorJWT.php';

class usuarioApi extends usuario implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$eluser=usuario::TraerUnUsuario($id);
     	$newResponse = $response->withJson($eluser, 200);  
        $response->getBody()->write("<h1>TraerUno</h1>");
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      $todosLosUsuarios=usuario::TraerTodoLosUsuarios();
		 $response = $response->withJson($todosLosUsuarios, 200);  

		 $response->getBody()->write("traer todos");
		 return $response;

    }
      public function CargarUno($request, $response, $args) {
     	$ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre= $ArrayDeParametros['nombre'];
        $tipo= $ArrayDeParametros['tipo'];
		$pass =$ArrayDeParametros['pass'];
        
        $miuser = new usuario();
		$miuser->nombre=$nombre;
		$miuser->tipo=$tipo;
		$miuser->password=$pass;
     
        
        $miuser->InsertarElUsuarioParametros();
        //$archivos = $request->getUploadedFiles();
        //$destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);
       // $nombreAnterior=$archivos['foto']->getClientFilename();
        //$extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
       // $extension=array_reverse($extension);
        //$archivos['foto']->moveTo($destino.$titulo.".".$extension[0]);
        $response->getBody()->write("se guardo el user");
		return $response;
		
	}
	public function ExisteUsuario($request, $response, $args)
	{
		$ArrayDeParametros = $request->getParsedBody();

		$nombre  = $ArrayDeParametros["nombre"];
		$pass = $ArrayDeParametros["pass"];
		$miuser = new usuario();
		$usuarioBuscado=null;
		$usuarioBuscado = $miuser->BuscarUsuario($pass, $nombre);
		

		if($usuarioBuscado!=null)
		{
			$token=AutentificadorJWT::CrearToken($usuarioBuscado);

			$response->getBody()->write($token);
			
		}
		else
		{
			$response->getBody()->write("no es un usuario de la api");
			return $response;
		}

		
		return $response;

	}
      public function BorrarUno($request, $response, $args) {
		 $ArrayDeParametros = $request->getParsedBody();
		 var_dump($ArrayDeParametros);
		 $id=$ArrayDeParametros['id'];
     	$user= new usuario();
     	$user->id=$id;
     	$cantidadDeBorrados=$user->BorrarUsuario();
     	$objDelaRespuesta= new stdclass();
	    $objDelaRespuesta->cantidad=$cantidadDeBorrados;
	    if($cantidadDeBorrados>0)
	    	{
	    		 $objDelaRespuesta->resultado="algo borro!!!";
	    	}
	    	else
	    	{
	    		$objDelaRespuesta->resultado="no Borro nada!!!";
	    	}
		$newResponse = $response->withJson($objDelaRespuesta, 200);  
		$response->getBody()->write("Borrar uno");
      	return $newResponse;
    }
     
     public function ModificarUno($request, $response, $args) {
     	$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    var_dump($ArrayDeParametros);    	
	    $miuser = new usuario();
	    $miuser->id=$ArrayDeParametros['id'];
	    $miuser->nombre=$ArrayDeParametros['nombre'];
	    $miuser->tipo=$ArrayDeParametros['tipo'];
	   $miuser->pass=$ArrayDeParametros['pass'];
	   

	   	$resultado =$miuser->ModificarUsuarioParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);	
		
		return $response;
	

    }
}