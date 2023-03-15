<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Entidades\Sucursal;
use App\Entidades\Cliente;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class ControladorWebRecuperarClave extends Controller{

      public function index(Request $request){

            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();

            return view('web.recuperarclave', compact('aSucursales'));
      }

      public function recuperar(Request $request){
            $titulo='Recupero de clave';
            $correo= $request->input('txtMail');
            $clave = rand(1000, 9999);
    
            $cliente = new Cliente();
            $cliente->obtenerPorCorreo($correo);
            if($cliente->correo !=""){
                //Envia  mail con las instrucciones
    
                $data = "Instrucciones";
    
                $mail = new PHPMailer(true);                            
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                               
                    $mail->isSMTP();
                    $mail->Host = env('MAIL_HOST');
                    $mail->SMTPAuth = true;
                    $mail->Username = env('MAIL_USERNAME');
                    $mail->Password = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = env('MAIL_ENCRYPTION');
                    $mail->Port = env('MAIL_PORT');
    
                    //Recipients
                    $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                    $mail->addAddress($correo);
    
                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Recupero de clave';
                    $mail->Body    = "Los datos de acceso son:
                    Usuario: $cliente->correo
                    Clave: $clave
                    ";
    
                    //$mail->send();

                    $mensaje = "La nueva clave es: $clave,y te enviamos al correo. {{$cliente->correo}}";
    
                    return view('web.recuperarclave', compact('titulo', 'mensaje'));
    
                } catch (Exception $e) {
                    $mensaje = "Hubo un error al enviar el correo.";
                    return view('web.recuperarclave', compact('titulo', 'mensaje'));
                }  
            } else {
                $mensaje="El correo ingresado no existe.";
                return view('web.recuperarclave', compact('titulo', 'mensaje'));
            }
        }

}






?>