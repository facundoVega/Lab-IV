<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;
    require_once 'vendor/autoload.php';
    require_once '/clases/AccesoDatos.php';
    require_once '/clases/usuario.php';
    require_once '/clases/usuarioApi.php';

    $config['displayErrorDetails'] = true;
    $config['addContentLengthHeader'] = false;

    $app = new \Slim\App(["settings" => $config]);


    $app->group('/usuario', function () {   
        $this->get('/', usuarioApi::class . ':TraerTodos');
        $this->get('/{id}', \usuarioApi::class . ':traerUno');
        $this->delete('/', \usuarioApi::class . ':BorrarUno');
        $this->put('/', \usuarioApi::class . ':ModificarUno');
       $this->post('/', \usuarioApi::class . ':CargarUno');
      
          
            
});
        



    $app->run();


