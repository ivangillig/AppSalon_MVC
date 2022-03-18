<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
            //pasamos lo que el usuario escriba en el formulario
            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();
            
            if(empty($alertas)){
                //comprobar que exista el user
                $usuario = Usuario::where('email', $auth->email);
                
                if($usuario) {
                    //verificar el password
                    if($usuario->comprobarPasswordandVerificado($auth->password )){
                        // Autenticar el usuario
                        session_start();

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;


                        //Redireccionamiento
                        if($usuario->admin === "1"){
                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        }else{
                            header('Location: /cita');
                        }
                    }

                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
            }

        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'alertas' => $alertas
        ]);
    }

    public static function logout(){
        session_start();
        $_SESSION = [];

        header('Location: /');
    }
    
    public static function olvide(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)){
                //Verificamos que exista el usuario según mail
                $usuario = Usuario::where('email', $auth->email); 

                if($usuario && $usuario->confirmado ==="1"){
                    
                    //Generar un token
                    $usuario->crearToken();
                    $usuario->guardar();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    
                    //Alerta de exito
                    Usuario::setAlerta('exito','Enviamos un mail de confirmación a tu correo.');
                    

                }else{
                    Usuario::setAlerta('error','El usuario no existe o no está confirmado');
                    
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide-password', [
            'alertas' => $alertas
        ]);
    }
    
    
    public static function recuperar(Router $router){
        $alertas = [];
        $error = false;

        $token = s($_GET['token']);

        //Buscar usuario por token
        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no valido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);

            $password->validarPassword();
            
            $alertas = Usuario::getAlertas();
            
            if(empty($alertas)){
                //Verifico que el usuario no esté registrado
                 $usuario->password = null;

                 $usuario->password = $password->password;
                 $usuario->hashPassword();
                 $usuario->token = null;
                
                 $resultado = $usuario->guardar();
                 if($resultado){
                     header('Location: /');
                 }
            }


            

        }


        // debuguear($usuario);

        
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    } 

    public static function crear(Router $router){

        $usuario = new Usuario();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            
           $usuario->sincronizar($_POST);
           $alertas = $usuario->validarNuevaCuenta();

           //Reviso que el alerta esté vacío para seguir el POST
           if(empty($alertas)){
               //Verifico que el usuario no esté registrado
                $resultado = $usuario->existeUsuario();

                if($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else{
                    //Hasheo el pass
                    $usuario->hashPassword();

                    //Generar un token único
                    $usuario->crearToken();

                    //Envío mail de verificación
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                    $email -> enviarConfirmacion();

                   
                    //Crear el usuario
                    $resultado  = $usuario ->guardar();

                    
                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
           }
            
            
        }


        $router->render('auth/crear-cuenta', [

            //pasa los resultados a la vista
            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    } 

    public static function confirmar(Router $router){
        
        $alertas = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            //Muestro mensaje de error si el user no existe
            Usuario::setAlerta('error', 'El token ingresado no es válido, por favor revisa tu correo nuevamente.');
        }else{
            $usuario->confirmado = "1";
            $usuario->token = null;

            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
        }

        //traer alertas
        $alertas = Usuario::getAlertas();

        //Renderizar la vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);
    } 
}