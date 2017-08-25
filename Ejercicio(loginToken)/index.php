<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    require_once 'vendor/autoload.php';
    require_once '/clases/AccesoDatos.php';
    require_once '/clases/usuario.php';
    require_once '/clases/usuarioApi.php';
    require_once '/clases/AutentificadorJWT.php';
    require_once '/clases/MWparaCORS.php';
    require_once '/clases/MWparaAutentificar.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);

    $app->group('/login', function () {   
     
       $this->post('/', \usuarioApi::class . ':ExisteUsuario');
      
          
            
});
    $app->group('/usuario', function () {   
        $this->get('/', usuarioApi::class . ':TraerTodos')->add(\MWparaCORS::class . ':HabilitarCORSTodos');;
        $this->get('/{id}', \usuarioApi::class . ':traerUno')->add(\MWparaCORS::class . ':HabilitarCORSTodos');;
        $this->delete('/', \usuarioApi::class . ':BorrarUno');
        $this->put('/', \usuarioApi::class . ':ModificarUno');
       $this->post('/', \usuarioApi::class . ':CargarUno');
      
          
            
})->add(\MWparaAutentificar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');;
        



    $app->run();


